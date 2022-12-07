import decimal
from django import http
from django.http import HttpResponse, request
from django.http import response
from django.http.response import HttpResponseRedirect, JsonResponse
from django.shortcuts import render
from django import forms
from django.urls import reverse
from django.db.models import Sum
import datetime
from django.urls.base import clear_url_caches
from django.utils import safestring
from pytz import timezone
import pytz
from django.contrib.auth.models import User
from django.contrib.auth import authenticate, login, logout
from django.utils.safestring import SafeString

from .models import Caisse, Client, Compagnie, Creance, Customer, Parametre, Poste, Secteur, Transaction, Vente, Employe
from topgaz import models
import json

# Create your views here.

# ls_emp = (
#     ('','---Enter employee'),
#     ('2','emp2'),
#     ('3','emp3'),
# )
# class lsempForm(forms.Form):
#     lsemp = forms.CharField(widget=forms.Select(choices=ls_emp))

niv_opt = (
    ('moyen', 'MOYEN'),
    ('interessant', 'INTERESSANT'),
    ('vip', 'VIP'),
)
stat_opt = (
    ('actif', 'Actif'),
    ('inactif', 'Inactif')
)
cash_gd = 27500.2

class CustomerForm(forms.Form):
    prenom = forms.CharField(label="Prenom")
    nom = forms.CharField(label="Signature")
    niveau = forms.ChoiceField(choices=niv_opt)
    statut = forms.ChoiceField(widget=forms.RadioSelect, choices=stat_opt)

class CaisseForm(forms.Form):
    gdes_ouvert = forms.DecimalField(max_digits=7, decimal_places=2, label="Ouverture Gourdes", widget=forms.NumberInput(attrs={'id':'mtg','class':'galinput', 'autofocus':'autofocus', 'placeholder':' $ HT'}))
    us_ouvert = forms.DecimalField(max_digits=7, decimal_places=2, label="Ouverture US", widget=forms.NumberInput(attrs={'id':'mtu','class':'galinput', 'placeholder':'USD'}))
    meter_av = forms.DecimalField(max_digits=7, decimal_places=1, label="Compteur Avant", required=False, widget=forms.NumberInput(attrs={'class':'galinput', 'placeholder':'Meter', 'id':'newmeter'}))
    meter_cour = forms.DecimalField(max_digits=7, decimal_places=1, label="Compteur courant", widget=forms.NumberInput(attrs={'class':'galinput'}))
    gallons_vendus = forms.DecimalField(max_digits=7, decimal_places=1, label="Gallons Vendus", widget=forms.NumberInput(attrs={'class':'galinput'}))
    achat_us = forms.IntegerField(label="Achat US", widget=forms.NumberInput(attrs={'class':'galinput'}))
    montant_apport = forms.DecimalField(max_digits=7, decimal_places=2, label="Total Apport", widget=forms.NumberInput(attrs={'class':'galinput'}))
    montant_depenses = forms.DecimalField(max_digits=7, decimal_places=2, label="Total Depenses", widget=forms.NumberInput(attrs={'class':'galinput'}))

perv = (
    ('perg', 'Par Gallon'),
    ('perc', 'Par Montant')
)

type_trans = (
    ('dep', 'Depenses'),
    ('app', 'Apport'),
    ('usch', 'US Change')
)
class venteForm(forms.Form):
    meterin = forms.DecimalField(max_digits=7, decimal_places=1, label='Avant', disabled=True, widget=forms.NumberInput(attrs={'class':'sinput'}))
    meterout = forms.DecimalField(max_digits=7, decimal_places=1, label='Apres', widget=forms.NumberInput(attrs={'class':'hidden', 'id':'meter2'}))
    ptot = forms.DecimalField(label="Prix Total", decimal_places=2, widget=forms.NumberInput(attrs={'class':'hidden', 'id': 'p2tot'}))
    pgal = forms.IntegerField(label="Prix Gallon", widget=forms.NumberInput(attrs={'class':'hidden', 'id':'p2gal'}))
    qtgal = forms.DecimalField(max_digits=7, decimal_places=1, label='Quantite', widget=forms.NumberInput(attrs={'class':'galinput', 'id':'qtegal', 'autofocus':'autofocus','placeholder':'Qte'}))
    percash = forms.DecimalField(max_digits=7, decimal_places=1, disabled=True, label='Par Montant', widget=forms.NumberInput(attrs={'class':'galinput'}))
    typev = forms.ChoiceField(widget=forms.RadioSelect, choices=perv, initial='perg')

espece = (
    ('ht', '$ HT'),
    ('us', 'USD')
)
class transacForm(forms.Form):
    tmontant_dep = forms.DecimalField(max_digits=7, decimal_places=2, label='Montant', widget=forms.NumberInput(attrs={'class':'tinput', 'id':'stransac', 'placeholder':'Dep.'}))
    tmontant_app = forms.DecimalField(max_digits=7, decimal_places=2, label='Montant', widget=forms.NumberInput(attrs={'class':'tinput', 'id':'atransac', 'placeholder':'App.'}))
    tmontant_us = forms.DecimalField(max_digits=7, decimal_places=2, label='Montant', widget=forms.NumberInput(attrs={'class':'tinput', 'id':'utransac', 'placeholder':'Ach.'}))
    tcomment_dep = forms.CharField(max_length=128, label='Comment', widget=forms.Textarea(attrs={'rows':1, 'cols':1, 'class':'comment', 'placeholder':'Descr. Depense'}))
    tcomment_app = forms.CharField(max_length=128, label='Comment', widget=forms.Textarea(attrs={'rows':1, 'cols':1, 'class':'comment', 'placeholder':'Descr. Apport'}))
    ttype = forms.CharField(max_length=32, label='type', widget=forms.TextInput(attrs={'class':'hidden', 'placeholder':'type'}))
    tuschange = forms.IntegerField(label='US', widget=forms.NumberInput(attrs={'class':'hidden', 'placeholder':'US'}))
    trtype = forms.ChoiceField(widget=forms.RadioSelect,choices=type_trans, initial='dep')
    tespece = forms.ChoiceField(widget=forms.RadioSelect, choices=espece, initial='ht')
    t2espece = forms.ChoiceField(widget=forms.RadioSelect, choices=espece, initial='ht')
    temp = forms.CharField(max_length=32, label='temp', widget=forms.TextInput(attrs={'id':'temp_value'}))

class optionForm(forms.Form):
    taux = forms.IntegerField(label='Taux', widget=forms.NumberInput(attrs={'class':'param1', 'placeholder':'Taux', 'data-number':'dtaux'}))
    prix = forms.IntegerField(label='Prix', widget=forms.NumberInput(attrs={'class':'param1', 'placeholder':'Prix', 'data-number':'dprice'}))

class userForm(forms.Form):
    username = forms.CharField(max_length=32, label='Nom Utilisateur', widget=forms.TextInput(attrs={'placeholder':'Username'}))
    password = forms.CharField(max_length=32, label='Mot de Passe', widget=forms.PasswordInput(attrs={'placeholder':'Password'}))


group_emp = (
    ('admin','Admin'),
    ('agent', 'Agent')
)
sex_emp = (
    ('H', 'H'),
    ('F', 'F')
)
class empForm(forms.Form):
    nom = forms.CharField(max_length=32, label='Nom : ', widget=forms.TextInput(attrs={'placeholder':'Nom', 'class':'form-control'}))
    prenom = forms.CharField(max_length=32, label='Prenom :', widget=forms.TextInput(attrs={'placeholder':'Prenom', 'class':'form-control'}))
    group = forms.ChoiceField(label='Groupe :', widget=forms.RadioSelect(attrs={}), choices=group_emp, initial='agent')
    sex = forms.ChoiceField(label='Sexe :', widget=forms.RadioSelect, choices=sex_emp, initial='H')
    #poste = forms.CharField(max_length=32, label='Poste :', widget=forms.TextInput(attrs={'placeholder':'Poste', 'class':'form-control'}))
    salaire = forms.IntegerField(label='Salaire :', widget=forms.NumberInput(attrs={'placeholder':'$ HT', 'class':'form-control'}))
    email = forms.EmailField(max_length=32, label='E-mail :', widget=forms.TextInput(attrs={'placeholder':'mail@example.com', 'class':'form-control'}))


class loginForm(forms.Form):
    username = forms.CharField(max_length=32, label='Utilisateur', widget=forms.TextInput(attrs={'placeholder':'Username', 'id':'inputuser','class':'form-control'}))
    password = forms.CharField(max_length=32, label='Mot de Passe', widget=forms.PasswordInput(attrs={'placeholder':'Password', 'id':'inputpass','class':'form-control'}))

class posteForm(forms.Form):
    nom = forms.CharField(max_length=64, label='Poste :', widget=forms.TextInput(attrs={'placeholder':'Poste', 'class':'form-control'}))
    description = forms.CharField(max_length=64, label='Description :', widget=forms.TextInput(attrs={'placeholder':'Description', 'class':'form-control'}))
    grille = forms.DecimalField(label='Grille :', widget=forms.NumberInput(attrs={'placeholder':'Grille', 'class':'form-control'}))

class CompagnieForm(forms.Form):
    nom = forms.CharField(max_length=64, label='Nom Compagnie :', widget=forms.TextInput(attrs={'placeholder':'Nom', 'class':'form-control'}))
    adresse = forms.CharField(max_length=128, label='Adresse :', widget=forms.TextInput(attrs={'placeholder':'Adresse', 'class':'form-control'}))
    tel1 = forms.CharField(max_length=32, label='Telephone 1 :', widget=forms.TextInput(attrs={'placeholder':'Tel', 'class':'form-control'}))
    tel2 = forms.CharField(max_length=32, label='Telephone 2 :', widget=forms.TextInput(attrs={'placeholder':'Tel', 'class':'form-control'}))
    mail = forms.EmailField(max_length=64, label='E-mail :', widget=forms.TextInput(attrs={'placeholder':'E-mail', 'class':'form-control'}))
    #Statut a changer
    #statut = forms.CharField(max_length=32, label='Telephone 1 :', widget=forms.TextInput(attrs={'placeholder':'Tel', 'class':'form-control'}))





current = 0
# time_now = datetime.datetime.now()
# miami_time = timezone('Etc/GMT-5')
# time_open = miami_time.localize(time_now)
def heure():
    time_now = datetime.datetime.now()
    miami_time = timezone('Etc/GMT-5')
    time_open = miami_time.localize(time_now)
    return time_open

def index(request):
    message =''
    #return HttpResponse("Hello Unitek !")
    if request.method == 'POST':
        #form = loginForm(request.POST)
        #if form.is_valid():
        nomutil = request.POST['username']
        passutil = request.POST['password']
        user = authenticate(request, username=nomutil, password=passutil)
        #user = authenticate(username='pierre', password='computer')

        if user is not None:
            #return HttpResponse(f"Success! {nomutil} - {passutil}")
            login(request, user)
            message = 'success'
            return HttpResponseRedirect(reverse("topgaz:userpage"))
        else:
            return render(request, "topgaz/index.html", {
                'form':loginForm(),
                'message':'Invalid Credentials'
            })
    return render(request, "topgaz/index.html", {
        'form':loginForm()
    })

def welcome(request):
    #return HttpResponse("Greetings, Welcome Page")
    return render(request, "topgaz/dispatch.html")

def customers(request):
    if not request.user.is_authenticated:
        return render(request, "topgaz/denied.html")
    if request.method == "POST":
        name = request.POST['nom']
        fname = request.POST['prenom']
        niveau = request.POST['niveau']
        statut = request.POST['statut']
        new_customer = Customer(nom=name, prenom=fname, niveau=niveau, statut=statut)
        new_customer.save()

    return render(request, "topgaz/customers.html", {
    "customers": Customer.objects.all(),
    "form": CustomerForm()#.as_p()

    })

def add_customer(request):
    pass


def caisse(request):
    if not request.user.is_authenticated:
        return render(request, "topgaz/denied.html")
    taux = 58
    #ind = 0
    last_caisse = Caisse.objects.last()
    av_compteur = last_caisse.cur_meter
    last_price = last_caisse.cur_price

    now_compteur = av_compteur
    if request.method == 'POST':
        if last_caisse.etat_caisse == "OUVERT":
            return render(request, "topgaz/ncaisse.html", {
                'message': 'IMPOSSIBLE DEJA OUVERT !',
                "results": Caisse.objects.all().order_by('-id')[:20],
                "form": CaisseForm(),        
                'now_meter': av_compteur,
                'price': last_price,
                'param': Parametre.objects.last()
            })
        else:
            gd_open = request.POST['gdes_ouvert']
            us_open = request.POST['us_ouvert']
            mod_meter = request.POST['meter_av']
            if mod_meter is not decimal.Decimal('0.00'):
                now_compteur = mod_meter
            cur_price = Parametre.objects.last().prixgallon
            time = heure()
            new_caisse = Caisse(etat_caisse='OUVERT', heure_ouv=time, gd_open=gd_open, us_open=us_open, av_meter=now_compteur, cur_meter=now_compteur, cur_price=cur_price)
            new_caisse.save()
            #global current
            current = new_caisse.id
            #detcaisse(current)
            #return render(request, "topgaz/ndetail.html")
            return HttpResponseRedirect(reverse('topgaz:detcaisse'))
   
    last_caisse = Caisse.objects.last()
    return render(request, "topgaz/ncaisse.html", {
        "results": Caisse.objects.all().order_by('-id')[:20],
        "form": CaisseForm(),
        #"ind": current,
        'now_meter': av_compteur,
        'price': last_price,
        'param': Parametre.objects.last(),
        'last':last_caisse
    })

def viewcaisse(request, caisse_id):
    caisse = Caisse.objects.get(pk=caisse_id)
    liste = Vente.objects.filter(caisse=caisse_id).order_by('-id')
    ltrans = Transaction.objects.filter(caisse=caisse_id).order_by('-id')

    
    return render(request, "topgaz/viewcaisse.html", {
        'caisse':caisse,
        'liste':liste,
        'ltrans':ltrans
    })

def detcaisse(request):
    if not request.user.is_authenticated:
        return render(request, "topgaz/denied.html")
    dcaisse = Caisse.objects.last()
    current = dcaisse.id
    live_ht=live_us=sum_gal=sum_vente=sum_dep=sum_depus=valop=sum_app=sum_appus=sum_us=sum_equiht=decimal.Decimal('0.00')
    link1=tab1=link2=tab2=link3=tab3=''
    fiche={}
    link1 = 'active'
    tab1 = 'show active'

    if request.method == 'POST' and "valerror" in request.POST:
        fk_caisse = Caisse.objects.get(pk=current)
        last = Vente.objects.last()
        qte = float(request.POST['errnb'])
        aftmet = float(request.POST['errafter'])
        nmont = float(request.POST['errmont'])
        loss = float(request.POST['errloss'])
        flag = request.POST['flag']
        last.nberr = last.nbgal
        last.nbgal = qte
        last.outmeter = aftmet
        last.totalv = nmont
        last.perte = loss
        last.flagged = flag
        last.save()
        fk_caisse.cur_meter = aftmet
        fk_caisse.tot_gal = aftmet - float(last.inmeter)
        fk_caisse.save()



    if request.method == 'POST' and "sale" in request.POST:
        fk_caisse = Caisse.objects.get(pk=current)
        quantite =request.POST['qtgal']
        galprix = request.POST['pgal']
        mtot = float(request.POST['ptot'])
        afterc = float(request.POST['meterout'])
        actuel = fk_caisse.cur_meter
        before = float(fk_caisse.av_meter)
        timev = heure()
        achat = request.POST['achat']
        numero = request.POST['numero']
        if achat == "CREDIT":
            client = Client.objects.get(pk=numero)
            new_creance = Creance(timev=timev, dette=mtot,client=client)
            new_creance.save()
            client.solde = float(client.solde) - mtot
            client.save()
            new_transac = Transaction(timet=timev, montant=mtot, comment=client.nom_compagnie, type="CREDIT", caisse=fk_caisse)
            new_transac.save()

        else:
            client = None
        new_vente = Vente(client=client, type=achat, timev=timev, pgal=galprix, totalv=mtot, outmeter=afterc,nbgal=quantite, inmeter=actuel, caisse=fk_caisse)
        new_vente.save()
        #som1 = fk_caisse.tot_ventes
        fk_caisse.cur_meter = afterc
        # sum_vente = list(Vente.objects.filter(caisse=fk_caisse.id).aggregate(Sum('totalv')).values())[0]
        #fk_caisse.tot_gal = afterc - before
        sum_gal = list(Vente.objects.filter(caisse=fk_caisse.id).aggregate(Sum('nbgal')).values())[0]
        fk_caisse.tot_gal = sum_gal
        #fk_caisse.tot_ventes = float(fk_caisse.tot_ventes) + mtot
        tot_montant = list(Vente.objects.filter(caisse=fk_caisse.id).aggregate(Sum('totalv')).values())[0]
        fk_caisse.tot_ventes = tot_montant
        fk_caisse.prevu_gd = float(fk_caisse.prevu_gd) + mtot
        fk_caisse.save()
        valop = 'vente'
        diff2 = afterc - before
        if diff2 == 0:
            return HttpResponse(f'No New Sale{diff2}')
        # else:
        #     return HttpResponse(diff2)

        return render(request, "topgaz/printpage.html", {
            'test':tot_montant,
            'fiche':new_vente,
            'value':valop,
            'time':heure()

        })

    # if request.method == 'POST' and "aclose" in request.POST:
    #     #fk_caisse = Caisse.objects.get(pk=current)
    #     #current = fk_caisse.id
    #     #return HttpResponseRedirect(reverse('topgaz:closing'))
    #     return render (request, "topgaz/closing.html", {
    #         'current':current
    #     })

    if request.method == 'POST' and "but_dep" in request.POST:
        fk_caisse = Caisse.objects.get(pk=current)
        mdep = request.POST['tmontant_dep']
        mdesc = request.POST['tcomment_dep']
        mtype = 'Depense'
        currency = request.POST['tespece']
        timet = heure()
        link1 = ''
        tab1 = ''
        link2 = 'active'
        tab2 = 'show active'

        if currency == 'ht':
            new_dep = Transaction(timet=timet, montant=mdep, comment = mdesc, currency=currency, type=mtype, caisse=fk_caisse)
            new_dep.save()
            mt_dep = list(Transaction.objects.filter(caisse=fk_caisse.id, type='Depense').aggregate(Sum('montant')).values())[0]
            fk_caisse.total_dep = mt_dep
            fk_caisse.save()
        else:
            new_dep = Transaction(timet=timet, montantus=mdep, comment = mdesc, currency=currency, type=mtype, caisse=fk_caisse)
            new_dep.save()
            mt_depus = list(Transaction.objects.filter(caisse=fk_caisse.id, type='Depense').aggregate(Sum('montantus')).values())[0]
            fk_caisse.total_depus = mt_depus
            fk_caisse.save()
        # sum_dep = list(Transaction.objects.filter(caisse=fk_caisse.id, type='Depense').aggregate(Sum('montant')).values())[0]
        # sum_depus = list(Transaction.objects.filter(caisse=fk_caisse.id, type='Depense').aggregate(Sum('montantus')).values())[0]
        valop = 'transaction'

    if request.method =='POST' and "but_app" in request.POST:
        timet = heure()
        fk_caisse = Caisse.objects.get(pk=current)
        mapp = request.POST['tmontant_app']
        adesc = request.POST['tcomment_app']
        atype = 'Apport'
        currency = request.POST['t2espece']
        link1 = ''
        tab1 = ''
        link2 = 'active'
        tab2 = 'show active'
        if currency == 'ht':
            new_app = Transaction(timet=timet, montant=mapp, comment=adesc, currency=currency, type=atype, caisse=fk_caisse)
            new_app.save()
            tot_app = list(Transaction.objects.filter(caisse=fk_caisse.id, type='Apport').aggregate(Sum('montant')).values())[0]
            fk_caisse.total_app = tot_app
            fk_caisse.save()

        else:
            new_app = Transaction(timet=timet, montantus=mapp, comment=adesc, currency=currency, type=atype, caisse=fk_caisse)
            new_app.save()
            tot_appus = list(Transaction.objects.filter(caisse=fk_caisse.id, type='Apport').aggregate(Sum('montantus')).values())[0]
            fk_caisse.total_appus = tot_appus
            fk_caisse.save()

        # sum_app = list(Transaction.objects.filter(caisse=fk_caisse.id, type='Apport').aggregate(Sum('montant')).values())[0]
        # sum_appus = list(Transaction.objects.filter(caisse=fk_caisse.id, type='Apport').aggregate(Sum('montantus')).values())[0]

        valop = 'transaction'

    if request.method == 'POST' and "but_ch" in request.POST:
        timet = heure()
        tdj = Parametre.objects.last().tauxdujour
        #tdj = 105
        fk_caisse = Caisse.objects.get(pk=current)
        mtus = int(request.POST['tmontant_us'])
        utype = 'Change'
        equivht = mtus * tdj / 5
        link1 = ''
        tab1 = ''
        link2 = 'active'
        tab2 = 'show active'
        new_change = Transaction(timet=timet, montant=mtus, type=utype, equiht=equivht, tdj=tdj, caisse=fk_caisse)
        new_change.save()
        tot_us = list(Transaction.objects.filter(caisse=fk_caisse.id, type='Change').aggregate(Sum('montant')).values())[0]
        tot_equiht = list(Transaction.objects.filter(caisse=fk_caisse.id, type='Change').aggregate(Sum('equiht')).values())[0]

        fk_caisse.total_buyus = tot_us
        fk_caisse.total_equiht = tot_equiht
        fk_caisse.save()
        
        # sum_us = list(Transaction.objects.filter(caisse=fk_caisse.id, type='Change').aggregate(Sum('montant')).values())[0]
        # sum_equiht = list(Transaction.objects.filter(caisse=fk_caisse.id, type='Change').aggregate(Sum('equiht')).values())[0]
        valop = 'transaction'

    fk_caisse = Caisse.objects.last()
    cur_caisse = Caisse.objects.get(pk=current)
    list_trans = Transaction.objects.filter(caisse=cur_caisse).order_by('id')[:50]
    list_vent = Vente.objects.filter(caisse=cur_caisse).order_by('-id')[:50]
    #listevente = Vente.objects.all().order_by('-id')[:3]
    tot_price = 0
    # fk_caisse = Caisse.objects.get(pk=current)
    lastsale = Vente.objects.last()
    sum_cre = list(Transaction.objects.filter(caisse=fk_caisse.id, type='CREDIT').aggregate(Sum('montant')).values())[0]
    sum_pay = list(Transaction.objects.filter(caisse=fk_caisse.id, type='PAIEMENT').aggregate(Sum('montant')).values())[0]
    sum_gal = list(Vente.objects.filter(caisse=fk_caisse.id).aggregate(Sum('nbgal')).values())[0]
    sum_vente = list(Vente.objects.filter(caisse=fk_caisse.id).aggregate(Sum('totalv')).values())[0]
    sum_dep = list(Transaction.objects.filter(caisse=fk_caisse.id, type='Depense').aggregate(Sum('montant')).values())[0]
    sum_depus = list(Transaction.objects.filter(caisse=fk_caisse.id, type='Depense').aggregate(Sum('montantus')).values())[0]
    sum_app = list(Transaction.objects.filter(caisse=fk_caisse.id, type='Apport').aggregate(Sum('montant')).values())[0]
    sum_appus = list(Transaction.objects.filter(caisse=fk_caisse.id, type='Apport').aggregate(Sum('montantus')).values())[0]
    sum_us = list(Transaction.objects.filter(caisse=fk_caisse.id, type='Change').aggregate(Sum('montant')).values())[0]
    sum_equiht = list(Transaction.objects.filter(caisse=fk_caisse.id, type='Change').aggregate(Sum('equiht')).values())[0]

    if sum_pay is None:
        sum_pay = decimal.Decimal('0.00')
    if sum_cre is None:
        sum_cre = decimal.Decimal('0.00')
    if sum_gal is None:
        sum_gal = decimal.Decimal('0.00')
    if sum_vente == None:
        sum_vente = decimal.Decimal('0.00')
    if sum_dep == None:
        sum_dep = decimal.Decimal('0.00')
    if sum_app == None:
        sum_app = decimal.Decimal('0.00')
    if sum_equiht == None:
        sum_equiht = decimal.Decimal('0.00')
    if sum_us == None:
        sum_us = decimal.Decimal('0.00')
    if sum_appus == None:
        sum_appus = decimal.Decimal('0.00')
    if sum_depus is None:
        sum_depus = decimal.Decimal('0.00')


    live_ht = cur_caisse.gd_open + sum_vente + sum_app - sum_dep - sum_equiht -sum_cre + sum_pay
    live_us = cur_caisse.us_open + sum_us + sum_appus - sum_depus

    fk_caisse.prevu_gd = live_ht
    fk_caisse.prevu_us = live_us
    fk_caisse.save()

    return render(request, "topgaz/tndetail.html", {
        'caisse':fk_caisse,
        'last':lastsale,
        'list_trans':list_trans,
        'list_vent':list_vent,
        'courant': cur_caisse,
        'session': current,
        'venteform': venteForm(),
        'transform': transacForm(),
        # 'liste': listevente,
        #'tot_price': tot_price,
        'sum_gal':sum_gal,
        'sum_vente':sum_vente,
        'sum_dep':sum_dep,
        'sum_depus':sum_depus,
        'sum_app': sum_app,
        'sum_appus':sum_appus,
        'sum_us':sum_us,
        'sum_equiht':sum_equiht,
        'sum_cre':sum_cre,
        'sum_pay':sum_pay,
        'live_ht':live_ht,
        'live_us': live_us,
        'value':valop,
        'param': Parametre.objects.last(),
        'link1':link1,
        'tab1':tab1,
        'link2':link2,
        'tab2':tab2,
        'clients':Client.objects.all()


    })

def operation(request):
    titop = ['Interface Ventes', 'Interface Change US', 'Interface Apports', 'Interface Depenses' ]


def closing(request):
    if not request.user.is_authenticated:
        return render(request, "topgaz/denied.html")
    # else:
    #     empl = Employe.objects.get(utilisateur__username=request.user.username)
    #     emposte = empl.poste.nom_poste
    #     groupe = emposte
    #     comp = 'Manager'
    #     #message='rew'
    #     if groupe !=comp:
    #         message = f'{empl.prenom.capitalize()} votre profil est {emposte} non {comp}. - Acces refuse !'
    #         #return HttpResponse(messsage)
    #         return render(request, "topgaz/denied.html", {
    #             'message':message
    #         })
    
    last_caisse = Caisse.objects.last()
    message = ''

    if request.method == 'POST' and 'close_all' in request.POST:
        caisgd = float(request.POST['caisgd'])
        caisus = float(request.POST['caisus'])
        ecgd = float(request.POST['ec1'])
        ecus = float(request.POST['ec2'])

        last_caisse.gd_close = caisgd
        last_caisse.us_close = caisus
        last_caisse.ecart_gd = ecgd
        last_caisse.ecart_us = ecus
        last_caisse.etat_caisse = 'FERMÉ'
        last_caisse.ap_meter = last_caisse.cur_meter
        last_caisse.heure_close = heure()
        last_caisse.save()
        message = "FERMETURE CAISSE AVEC SUCCES !"


    

    return render(request, "topgaz/closing.html", {
        'caisse':last_caisse,
        'message':message
        #'current':current
    })


def param(request):
    if not request.user.is_authenticated:
        return render(request, "topgaz/denied.html")
    msg = ''
    time2=prop1=prop2= ''
    last = Parametre.objects.last()
    if last is None:
        first = Parametre(tauxdujour=0, prixgallon=0)
        first.save()

    if request.method == 'POST' and 'subtaux' in request.POST:
        vartaux = request.POST['taux']
        time = heure()
        delta = datetime.timedelta(hours=5)
        time2 = time + delta
        newtaux = Parametre(tauxdujour=vartaux, prixgallon=last.prixgallon, time=time, time2=time2)
        newtaux.save()
        msg = f'Taux mis a jour : {vartaux} Gdes.'
        prop1 = 'fw-bold h5 text-primary'

    if request.method == 'POST' and 'subprice' in request.POST:
        varprice = request.POST['prix']
        time = heure()
        delta = datetime.timedelta(hours=5)
        time2 = time + delta
        newprice = Parametre(tauxdujour=last.tauxdujour, prixgallon=varprice, time=time, time2=time2)
        newprice.save()
        msg = f'Prix mis a jour : $ {varprice} HT.'
        prop2 = 'fw-bold h5 text-primary'

    #tous = Parametre.objects.all().order_by('-id')[:10]
    # ftous = tous.reverse() working but without slice
    #tous =  reversed(Parametre.objects.all().order_by('-id')[:10])
    tous =  Parametre.objects.all().order_by('-id')[:20]

    last = Parametre.objects.last()
    return render(request, "topgaz/param.html", {
        'form': optionForm(),
        'last': last,
        'tous':tous,
        'msg': msg,
        'time2':time2,
        'prop1':prop1,
        'prop2':prop2
    })


def creer_user(request):
    pass

def addemp(request):
    if not request.user.is_authenticated:
        return render(request, "topgaz/denied.html")
    lsuser = User.objects.all()
    liste = 'Empty'
    message = ''
    lsposte = Poste.objects.all()
    if request.method == 'POST' and "saveemp" in request.POST:
        form = empForm(request.POST)
        if form.is_valid():
            efname = form.cleaned_data['prenom']
            elname = form.cleaned_data['nom']
            egroup = form.cleaned_data['group']
            esex = form.cleaned_data['sex']
            iposte = request.POST['lpos']
            esalaire = form.cleaned_data['salaire']
            message = 'Enregistrement reussi !'
            #eposte = Poste.objects.get(pk=int(iposte))
        else:
            message = 'Erreur'
            lsposte = Poste.objects.all()
            lsuser = User.objects.all()
            return render(request, "topgaz/addemp.html", {
                'form':form,
                'message':message,
                'lsposte': lsposte
            })
        eposte = Poste.objects.get(pk=int(iposte))
        new_emp = Employe(prenom=efname,nom=elname,sexe=esex,groupe=egroup,salaire=esalaire,poste=eposte)
        new_emp.save()
        #new_emp.poste.add(eposte)
        lsuser = User.objects.all()
    report = message
    lsuser = User.objects.all()
    return render(request, "topgaz/addemp.html", {
        'lsposte':lsposte,
        'form': empForm(),
        'liste':Employe.objects.all(),
        'message':report,
        'lsuser':User.objects.all()
    })

def userpage(request):
    if not request.user.is_authenticated:
        return render(request, "topgaz/denied.html")
    return render(request, "topgaz/userpage.html")

def useradd(request):
    if not request.user.is_authenticated:
        return render(request, "topgaz/denied.html")

    #Start view
    util=fname=lname=mpass=mail=message=ch_emp=''
    if request.method == 'POST' and "adduser" in request.POST:
        form = userForm(request.POST)
        if form.is_valid():
            util = form.cleaned_data['username']
            mpass = form.cleaned_data['password']
            user = User.objects.create_user(username=util, password=mpass)

            emp_sel = request.POST['emp']
            ch_emp = Employe.objects.get(pk=int(emp_sel))
            user.first_name = ch_emp.prenom
            user.last_name = ch_emp.nom
            user.email = ch_emp.email
            user.save()
            #sel_user = User.objects.get(username=util)
            ch_emp.utilisateur = User.objects.get(username=util)
            #???
            #ch_emp.utilisateur = sel_user.username
            ch_emp.save()

            message = 'Utilisateur enregistré !'
            liste_emp = Employe.objects.filter(utilisateur=None)
        else:
            liste_emp = Employe.objects.filter(utilisateur=None)
            message = 'Echec Operation'
            return render(request, "topgaz/creer_user.html")

    report = message
    liste_emp = Employe.objects.filter(utilisateur=None)
    return render(request, "topgaz/useradd.html", {
        'form':userForm(),
        'message':report,
        'liste':liste_emp,
        'choisi':ch_emp
        #'new_user':sel_user

    })

def plogin(request):
    pass
    #user = authenticate(request, username='pierre', password='computer')
def plogout(request):
    logout(request)
    return render(request, "topgaz/index.html", {
        'message':'Deconnecte(e)',
        'form':loginForm()
    })

def rh(request):
    message=''
    if request.method == 'POST':
        form = posteForm(request.POST)
        if form.is_valid():
            nposte = form.cleaned_data['nom']
            ndesc = form.cleaned_data['description']
            ngrille = form.cleaned_data['grille']
            message = 'Enregistrement reussi !'

        else:
            message = 'Erreur Validation'
            return render(request, "topgaz/rh.html", {
                'form':form,
                'message': message
            })

        new_poste = Poste(nom_poste=nposte, description=ndesc, grille=ngrille)
        new_poste.save()

    liste = Poste.objects.all()
    return render(request, "topgaz/rh.html", {
        'form':posteForm(),
        'liste':liste,
        'message':message
    })

def myprint(request):

    data = {
        'name':'Proligaz',
        'qte':15,
        'prix':58,
        'total': 15*58
    }
    y = json.dumps(data)
    return HttpResponse(y)

def compagnie(request):
    message=''
    if request.method == 'POST':
        form = CompagnieForm(request.POST)
        if form.is_valid():
            cname = form.cleaned_data['nom']
            cadd = form.cleaned_data['adresse']
            ctel1 = form.cleaned_data['tel1']
            ctel2 = form.cleaned_data['tel2']
            cmail = form.cleaned_data['mail']
            message = 'Enregistrement reussi'
        else:
            #message = 'Erreur Validation'
            return render(request, "topgaz/compagnie.html", {
                'form':form,
                'message':message
            })
        new_comp = Compagnie(nom_compagnie=cname, adresse=cadd, telephone1=ctel1, telephone2=ctel2, email=cmail)
        new_comp.save()

    return render(request, "topgaz/compagnie.html", {
        'form':CompagnieForm,
        'message':message
    })

def printpage(request):
    diff = 0
    lsale = Vente.objects.last()
    ap = lsale.outmeter
    av = lsale.inmeter
    diff = ap - av
    # if diff == 0:
    #     return HttpResponse('No new Sale.')
    # else:
    #time_now = datetime.datetime.now()
    #miami_time = timezone('Etc/GMT-5')
    #time_open = miami_time.localize(time_now)
    #heure()
    return render(request, "topgaz/printpage.html", {
        'diff':diff,
        'time':heure(),
        #'tim':time_now
    })

def clients(request):
    if not request.user.is_authenticated:
        return render(request, "topgaz/denied.html")
    
    msg = ''

    if request.method == 'POST' and 'savecl' in request.POST:
        ncomp = request.POST['cpname']
        adresse = request.POST['cadr']
        tel1 = request.POST['ctel']
        first = request.POST['firstname']
        last = request.POST['lastname']
        tel2 = request.POST['telcont']
        secteur = Secteur.objects.get(pk=int(request.POST['secteur']))
        newclient = Client(nom_compagnie=ncomp, adresse=adresse, telephone=tel1, nom_contact=last, prenom_contact=first, tel_contact=tel2, secteur=secteur) 
        # newclient.secteur.add(secteur)
        newclient.save()
        msg = f'Enregistrement Reussi ! {ncomp} dans {secteur.nom_secteur}'
        

    clients = Client.objects.all()
    secteurs = Secteur.objects.all()
    return render(request, "topgaz/clients.html", {
        'clients':clients,
        'msg':msg,
        'secteurs':secteurs
    })

def delclient(request, client_id):
    todel = Client.objects.get(pk=client_id)
    # Client.objects.get(pk=client_id).delete()
    todel.delete()
    msg = f'le Client "{todel.nom_compagnie}" a ete Supprime.'
    return HttpResponseRedirect(reverse('topgaz:clients'))
    
    clients = Client.objects.all()
    return render(request, "topgaz/clients.html", {
        'msg':msg,
        'clients':clients
    })


def transac(request):
    return render(request, "topgaz/transac.html")

def secteur(request):
    msg = ''
    if request.method == "POST" and "newsec" in request.POST:
        nomsect = request.POST['secname']
        descript = request.POST['secdes']
        msg = f'Nouveau Secteur "{nomsect}" Enregistre'

        new_sect = Secteur(nom_secteur=nomsect, description=descript)
        new_sect.save()
    secteurs = Secteur.objects.all()
    return render(request, "topgaz/secteur.html", {
        'msg':msg,
        'secteurs':secteurs
    })


def delsecteur(request, secteur_id):
    delsect = Secteur.objects.get(pk=secteur_id)
    delsect.delete()
    sup = f"{delsect.nom_secteur} est Supprime"
    secteurs = Secteur.objects.all()
    return render(request, "topgaz/secteur.html", {
        'sup':sup, 
        'secteurs':secteurs
    })
    return HttpResponseRedirect(reverse('topgaz:secteur'))

def paiement(request):
    dcaisse = Caisse.objects.last()
    current = dcaisse.id
    fk_caisse = Caisse.objects.get(pk=current)
    if request.method == "POST" and "vend" in request.POST:
        montant = float(request.POST['montant'])
        client = request.POST['client']
        customer = Client.objects.get(pk=client)
        timep = heure()
        new_creance = Creance(timev=timep, paiement=montant, client=customer) 
        new_creance.save()
        customer.solde = float(customer.solde) + montant
        customer.save()
        new_transac = Transaction(timet=timep, montant=montant, comment=customer.nom_compagnie, type="PAIEMENT", caisse=fk_caisse)
        new_transac.save()
        msg = f"Paiement de $ {montant} HT Effectue par {customer.nom_compagnie}."
   
    clients = Client.objects.all()
    secteurs = Secteur.objects.all()
    
    return render(request, "topgaz/clients.html", {
        'msg':msg,
        'clients':clients,
        'secteurs':secteurs
    })
    #return HttpResponseRedirect(reverse('topgaz:clients'))


def load_client(request):
    idclient = request.GET.get('emp', None)
    client = Client.objects.get(pk=idclient)
    #choix = idclient.nom_compagnie
    response = {
        'num_client': client.id,
        'nom_client': client.nom_compagnie,
        'adresse': client.adresse,
        'secteur': client.secteur.nom_secteur,
        'solde':client.solde

    }
    #return HttpResponse(number.nom_compagnie)
    return JsonResponse(response)
