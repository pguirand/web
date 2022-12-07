from django import forms
from django.shortcuts import render
from django.http import HttpResponse, JsonResponse, HttpResponseRedirect
from django.urls import reverse
from django.utils import timezone
from django.utils.timezone import localtime, now
import math, pytz
from datetime import datetime, timezone
from django import forms
from .models import Produits, Ventes, Clients, Employe, Categories, Poste, Remplissage
from django.db.models import Sum, F, FloatField
from django.db.models.functions import Cast
from django.contrib.auth import authenticate, login, logout

filt =  Ventes.objects.all()
#customers = ["Paul", "Junior", "Pierre", "Bedia", "Martine"]
# Create your views here.

class NewCatForm(forms.Form):
    categorie = forms.CharField(label="Catégorie")

class NewPosteForm(forms.Form):
    poste = forms.CharField(label="Poste")
    description = forms.CharField(label="Description du Poste")
class NewClientForm(forms.Form):
    client = forms.CharField(label="New Client")
    priority = forms.IntegerField(label="Priority", min_value=1, max_value=3)

#class NewRemplissageForm(forms.Form):
#    avant = forms.CharField(label="Avant")


def index(request):
    if not request.user.is_authenticated:
        return HttpResponseRedirect(reverse("login"))
    #return render(request, "proligaz/index.html")
    return render(request, "proligaz/user.html")

def login_view(request):
    if request.method == "POST":
        username = request.POST["username"]
        password = request.POST["password"]
        user = authenticate(request, username=username, password=password)
        if user is not None:
            login(request, user)
            return HttpResponseRedirect(reverse("proligaz:index"))
        else:
            return render(request, "proligaz/login.html", {
            "message": "Utilisateur ou mot de passe Incorrects !"
            })


    return render(request, "proligaz/login.html")

def logout_view(request):
    logout(request)
    return render(request, "proligaz/login.html", {
    "message": "Déconnecté(e)"
    })

def clients(request):
    if "customers" not in request.session:
        request.session["customers"] = []
    return render(request, "proligaz/clients.html",
    {
    "lsclients": request.session["customers"],
    "lscl2": Clients.objects.all()
    })

def new_client(request):
    if request.method =="POST":
        form = NewClientForm(request.POST)
        if form.is_valid():
            client = form.cleaned_data["client"]
            #customers.append(client)
            request.session["customers"] += [client]
            return HttpResponseRedirect(reverse("proligaz:clients"))
        else:
            return render(request, "proligaz/addclient.html", {
            "form": form
            })
    return render(request, "proligaz/addclient.html", {
    "form": NewClientForm(),
    "list3": request.session["customers"]
    })

def sales(request):

    total = Ventes.objects.annotate(
        result = Cast(F('quantite') * F('produit__prix'), FloatField()))
    sumv = list(filt.aggregate(Sum('quantite')).values())[0]
    montant = list(filt.aggregate(Sum('produit__prix')).values())[0]
    return render(request, "proligaz/sales.html", {
    #"nventes": Ventes.objects.all(),
    "countv": filt.count,
    #"num": Ventes.objects.date_vente(),
    "total": total,
    "sumv": sumv,
    "montant": montant,
    "montant2": float(sumv * montant)
    })
    #infos = [3018.2, 38, 85, 0]
def sale(request, sale_id):
    sale = Ventes.objects.get(pk=sale_id)
    price = sale.produit.prix
    facture = price * sale.quantite
    return render(request, "proligaz/sale.html", {
    "sale": sale,
    "supervisors": sale.vendeur.all(),
    "non_supervisors": Employe.objects.exclude(prod_vendus=sale).all(),
    "price": price,
    "facture": facture
    })

def produits(request):
    postes = Poste.objects.all()
    produits = Produits.objects.all()
    categories = Categories.objects.all()
    count = Produits.objects.count
    somme = round(list(Produits.objects.aggregate(Sum('prix')).values())[0], 2)
    cat_sel = ''
    cat_to_del = ''
    cat_to_upd = ''
    new_cat = ''
    if request.method == "POST" and "button_cat" in request.POST:
        new_prod = request.POST["categorie"]
        #categories.nom_categorie.add(new_prod)
        new = Categories(nom_categorie=new_prod)
        new.save()
    if request.method == "POST" and "button_pos" in request.POST:
        nom = request.POST["poste"]
        description = request.POST["description"]
        new_poste = Poste(nom_poste=nom, description=description)
        new_poste.save()
    if request.method == "POST" and "del_cat" in request.POST:
        cat_sel = request.POST["cat"]
        cat_to_del = Categories.objects.get(pk=int(request.POST["cat"]))
        #cat_to_del = Categories.objects.filter(id=int(request.POST['cat']))
        cat_to_del.delete()
    if request.method == "POST" and "upd_cat" in request.POST:
        cat_sel = request.POST["cat2"]
        cat_to_upd = Categories.objects.get(pk=int(request.POST["cat2"]))
        new_cat = request.POST["new_cat"]
        cat_to_upd.nom_categorie = new_cat
        #cat_to_upd.save(['nom_categorie'])
        cat_to_upd.save()

    return render(request, "proligaz/produits.html", {
    "produits": produits,
    "Categories": categories,
    "count": count,
    "somme": somme,
    "postes": postes,
    "cat_sel": cat_sel,
    "cat_to_del": cat_to_del,
    "cat_to_upd": cat_to_upd,
    "new_cat": new_cat,
    "form2": NewPosteForm(),
    "form1": NewCatForm()

    #"nouv": Categories.nom_categorie.add(new_prod)
    })


def supervise(request, sale_id):
    if request.method == "POST":
        sale = Ventes.objects.get(pk=sale_id)
        supervisor = Employe.objects.get(pk=int(request.POST["supervisor"]))
        supervisor.prod_vendus.add(sale)
        return HttpResponseRedirect(reverse("proligaz:sale", args=(sale.id,)))

def transaction(request):
    return render(request, "proligaz/transaction.html")

def new_sale(request):
    #filt =  Ventes.objects.all()
    #filt =  Ventes.objects.filter(id=3)
    return render(request, "proligaz/nvente.html", {
    "ventes": filt,
    "count": filt.count,
    "somme1": list(filt.aggregate(Sum('quantite')).values())[0],
    #"somme2": list(Ventes.objects.aggregate(Sum('Ventes.Produits.prix')).values())[0]
    })


def board(request):
    compt_debut = ''
    compt_avant = ''

    compt_fin = ''
    after = ''
    #timezone.localtime()
    #tz = pytz.timezone('America/Santo_Domingo')
    #tz = timezone.now
    #heure_rempl = datetime.now()
    ls_remp = Remplissage.objects.all().order_by('-heure_rempl')
    #ls_remp = Remplissage.objects.all().order_by('-heure_rempl')[:10]
    last = Remplissage.objects.last()
    heure_rempl = datetime.now()


    if request.method == "POST"  and "valid" in request.POST:
        #nouv_remp = Remplissage(heure_rempl=heure_rempl, compt_debut=compt_debut, compt_avant=compt1, achat_pour=achat_pour, quantite=ng, compt_apres=compt2, px_gallon=pg, montant=montant, compt_fin=compt_fin)
        compt_debut = float(last.compt_debut)
        compt_avant = float(last.compt_apres)
        compt_fin = 0
        #compt_fin = float(last.compt_fin)
        pg = float(request.POST["p2gal"])
        buyfor = 0
        quant = float(request.POST["nbgal"])
        after = compt_avant + quant
        montant = quant * pg

        nouv_remp = Remplissage(heure_rempl=heure_rempl, compt_debut=compt_debut, compt_avant=compt_avant, achat_pour=buyfor, quantite=quant, compt_apres=after, px_gallon=pg, montant=montant, compt_fin=compt_fin)
        nouv_remp.save()
        #ls_remp = Remplissage.objects.all().order_by('-heure_rempl')

        last = Remplissage.objects.last()
        #update records
        #Remplissage.objects.filter(type_pay='cash').update(type_pay ='CASH')

    if request.method =="POST" and "fermer" in request.POST:
        close = Remplissage.objects.last()

        close.compt_debut = close.compt_apres
        close.compt_fin = close.compt_apres
        close.statut = 'CLOSED'
        close.save()

    return render(request, "proligaz/board.html", {
    "ls_remp": ls_remp,
    "last": last,
    "avant": compt_avant,
    "debut":compt_debut,
    "fin": compt_fin,
    "after": after

    })

def info(request):
    compt1 = 3018.2
    pg = 36
    tx = 75
    ng = 100
    compt2 = compt1 + ng
    pa1usd = 1.43
    pa1htd = round((pa1usd * tx / 5), 2)
    pv1usd = round((pg * 5 / tx), 2)
    ben1usd = round((pv1usd - pa1usd), 2)
    bentotusd = round((ben1usd * ng), 2)
    pvtothtd = round((ng * pg), 2)
    pvtotusd = round((pv1usd * ng), 2)
    list1 = [100, 205, 190, 255]
    return render(request, "proligaz/infos.html", {
    "compt1": compt1,
    "pg": pg,
    "tx": tx,
    "ng": ng,
    "pa1usd": pa1usd,
    "pv1usd": pv1usd,
    "ben1usd": ben1usd,
    "pvtothtd": pvtothtd,
    "pvtotusd": pvtotusd,
    "bentotusd": bentotusd,
    "compt2": compt2,
    "lists": list1
    })

def employe(request):
    emp = Employe.objects.all()
    return render(request, "proligaz/employe.html", {
    "emp": emp
    })

def test(request):
    return render(request, "proligaz/testjava.html")

def java2(request):
    return render(request, "proligaz/java2.html")

texts = ["Lorem ipsum dolor sit amet. Ex eligendi rerum non aspernatur delectus eos quia architecto non temporibus eligendi. Et corrupti omnis in sapiente cumque qui quasi provident est error vitae eum labore sequi nam fuga illum et quod quaerat. Aut esse repellat vel mollitia numquam est earum impedit 33 quibusdam reiciendis! A distinctio cumque eos esse beatae ea voluptatem assumenda ex sunt soluta. ",
         "Sed quas velit eum voluptatem nulla est eligendi amet aut ducimus dolores in soluta tenetur qui cumque quidem qui quia necessitatibus. Eos consequatur quasi ab officia autem ea soluta sequi ab laborum dolorem vel cupiditate omnis qui impedit ratione nam magnam quia. Ut reprehenderit quis aut ipsam omnis ea odio minima id officiis omnis. Et dignissimos nihil ut vitae vitae qui necessitatibus magnam 33 sunt quaerat et officia voluptatem aut velit soluta. ",
         "Sed consequatur porro in illum inventore et facere beatae et exercitationem fuga sed officiis obcaecati non velit neque sed doloremque quia. Non accusamus adipisci et expedita dolorum sit sint rerum et veniam voluptas est suscipit repellendus ut consequatur aliquid. Sed quia eveniet ea minima nostrum ut veniam voluptatem et facilis animi. Aut voluptatem nihil a cumque adipisci ea dolor quaerat est nihil recusandae et quia quia. "]

def section(request, num):
    if 1 <= num <= 3:
        return HttpResponse(texts[num -1])
    else:
        raise Http404("No Such Section")

def test3(request):
    return render(request, "proligaz/test3.html")

def test4(request):
    return render(request, "proligaz/test4.html")
