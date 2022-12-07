from django import forms
from django.db import models
from decimal import Decimal
import datetime

from django.db.models.base import ModelState
from django.contrib.auth.models import User
from django.db.models.deletion import DO_NOTHING, SET_NULL


# Create your models here.

class Compagnie(models.Model):
    nom_compagnie = models.CharField(max_length=64)
    adresse = models.CharField(max_length=128, blank=True, default='Non Defini')
    telephone1= models.CharField(max_length=32, blank=True, default='Non Defini')
    telephone2= models.CharField(max_length=32, blank=True, default='Non Defini')
    email= models.EmailField(max_length=64, blank=True, default='Non Defini')
    statut= models.CharField(max_length=16, blank=True, default='Actif')



class Poste(models.Model):
    nom_poste = models.CharField(max_length=64, blank=True, default='Not Assigned')
    description = models.CharField(max_length=128, blank=True, default='Not Assigned')
    grille = models.DecimalField(max_digits=7, decimal_places=2, blank=True, default=Decimal('0.00'))

    def __str__(self):
        return f"{self.nom_poste} - grille: $ {self.grille} HT" 

class Caisse(models.Model):
    heure_ouv = models.DateTimeField(blank=True, default='2000-01-01')
    heure_close = models.DateTimeField(blank=True, default='2000-01-01')
    gd_open = models.DecimalField(max_digits=7, decimal_places=2, blank=True)
    us_open = models.DecimalField(max_digits=7, decimal_places=2, blank=True)
    av_meter = models.DecimalField(max_digits=7, decimal_places=1, blank=True, default=Decimal('0.00'))
    ap_meter = models.DecimalField(max_digits=7, decimal_places=1, blank=True, default=Decimal('0.00'))
    cur_meter = models.DecimalField(max_digits=7, decimal_places=1, blank=True, default=Decimal('0.00')) 
    cur_price = models.IntegerField(blank=True, default=0) 
    tot_gal = models.DecimalField(max_digits=7, decimal_places=1, blank=True, default=Decimal('0.00'))
    tot_ventes = models.DecimalField(max_digits=7, decimal_places=1, blank=True, default=Decimal('0.00'))
    total_app = models.DecimalField(max_digits=7, decimal_places=2, blank=True, default=Decimal('0.00'))
    total_appus = models.DecimalField(max_digits=7, decimal_places=2, blank=True, default=Decimal('0.00'))
    total_dep = models.DecimalField(max_digits=7, decimal_places=2, blank=True, default=Decimal('0.00'))
    total_depus = models.DecimalField(max_digits=7, decimal_places=2, blank=True, default=Decimal('0.00'))
    total_buyus = models.DecimalField(max_digits=7, decimal_places=2, blank=True, default=Decimal('0.00'))
    total_equiht = models.DecimalField(max_digits=7, decimal_places=2, blank=True, default=Decimal('0.00'))
    auth_user = models.CharField(max_length=64, blank=True, default="NA")
    prevu_gd = models.DecimalField(max_digits=7, decimal_places=2, blank=True, default=Decimal('0.00'))
    prevu_us = models.DecimalField(max_digits=7, decimal_places=2, blank=True, default=Decimal('0.00'))
    gd_close = models.DecimalField(max_digits=7, decimal_places=2, blank=True, default=Decimal('0.00'))
    us_close = models.DecimalField(max_digits=7, decimal_places=2, blank=True, default=Decimal('0.00'))
    ecart_gd = models.DecimalField(max_digits=7, decimal_places=2, blank=True, default=Decimal('0.00'))
    ecart_us = models.DecimalField(max_digits=7, decimal_places=2, blank=True, default=Decimal('0.00'))
    etat_caisse = models.CharField(max_length=32, blank=True, default="FERME")

    def __str__(self):
        return f" id: {self.id} - ${self.us_open} HT | {self.us_open} USD"

class Employe(models.Model):
    prenom = models.CharField(max_length=64)
    nom = models.CharField(max_length=64)
    sexe = models.CharField(max_length=12, blank=True)
    groupe = models.CharField(max_length=32, blank=True)
    poste = models.ForeignKey(Poste, related_name='fonction', blank=True, on_delete=SET_NULL, null=True, default=None)
    #poste = models.CharField(max_length=64, blank=True)
    salaire = models.IntegerField()
    email = models.EmailField(blank=True)
    utilisateur = models.OneToOneField(User, on_delete=SET_NULL ,related_name="contact", blank=True, null=True, default=None)

    def __str__(self):
        return f"{self.prenom.capitalize()} {self.nom.upper()} - {self.poste} {self.email} - {self.utilisateur}"

class  Customer(models.Model):
    nom = models.CharField(max_length=64)
    prenom = models.CharField(max_length=64)
    statut = models.CharField(max_length=64, blank=True, default="Unassigned")
    niveau = models.CharField(max_length=64, blank=True, default="Unassigned")

class Secteur(models.Model):
    nom_secteur = models.CharField(max_length=64, blank=True, default="Non Defini")
    description = models.CharField(max_length=128, blank=True, default="Non Defini")

    def __str__(self):
        return f"{self.nom_secteur} - {self.description}"

class Client(models.Model):
    nom_compagnie = models.CharField(max_length=64, blank=True, default='Non Defini')
    #secteur = models.CharField(max_length=128, blank=True, default='Non Defini')
    adresse = models.CharField(max_length=128, blank=True, default='Non Defini')
    telephone = models.CharField(max_length=64, blank=True, default='Non Defini')
    nom_contact = models.CharField(max_length=64, blank=True, default='Non Defini')
    prenom_contact = models.CharField(max_length=128, blank=True, default='Non Defini')
    tel_contact = models.CharField(max_length=64, blank=True, default='Non Defini')
    solde = models.DecimalField(max_digits=7, decimal_places=1, blank=True, default=Decimal('0.00'))
    secteur = models.ForeignKey(Secteur, on_delete=models.CASCADE, related_name="compagnie", blank=True, null=True, default=None)

    def __str__(self):
        return f"{self.nom_compagnie} - {self.secteur} - solde : $ {self.solde} HT"

    
class Vente(models.Model):
    inmeter = models.DecimalField(max_digits=7, decimal_places=1, blank=True, default=Decimal('0.00'))
    outmeter = models.DecimalField(max_digits=7, decimal_places=1, blank=True, default=Decimal('0.00'))
    totalv = models.DecimalField(max_digits=7, decimal_places=1, blank=True, default=Decimal('0.00'))
    pgal = models.IntegerField(blank=True, default=0)
    nbgal = models.DecimalField(max_digits=7, decimal_places=1, blank=True, default=Decimal('0.00'))
    nberr = models.DecimalField(max_digits=7, decimal_places=1, blank=True, default=Decimal('0.00'))
    perte = models.DecimalField(max_digits=7, decimal_places=1, blank=True, default=Decimal('0.00'))
    flagged = models.CharField(max_length=8, blank=True, default="NON")
    bycash = models.IntegerField(blank=True, default=0)
    type = models.CharField(max_length=8, blank=True, default="CASH")
    timev = models.DateTimeField(blank=True, default='2000-01-01')
    caisse = models.ForeignKey(Caisse, on_delete=models.CASCADE, related_name="encaisse")
    client = models.ForeignKey(Client, on_delete=models.CASCADE, related_name="achat", blank=True, null=True, default=None)
    def __str__(self):
        return f"date: {self.timev} - {self.inmeter}->{self.outmeter} | qte:{self.nbgal} - tot:{self.totalv} -err{self.nberr} - perte:{self.perte} - flag {self.flagged}"

class Creance(models.Model):
    timev = models.DateTimeField(blank=True, default='2000-01-01')
    dette = models.DecimalField(max_digits=7, decimal_places=1, blank=True, default=Decimal('0.00'))   
    paiement = models.DecimalField(max_digits=7, decimal_places=1, blank=True, default=Decimal('0.00'))
    client = models.ForeignKey(Client, on_delete=models.CASCADE, related_name="operation", blank=True, null=True, default=None)
    #solde = models.DecimalField(max_digits=7, decimal_places=1, blank=True, default=Decimal('0.00'))

    def __str__(self):
        return f"{self.timev.replace(microsecond=0)} - Acheter : {self.dette} - Pay : {self.paiement} de : {self.client.nom_compagnie} "





class Transaction(models.Model):
    montant = models.DecimalField(max_digits=7, decimal_places=2, blank=True, default=Decimal('0.00'))
    montantus = models.DecimalField(max_digits=7, decimal_places=2, blank=True, default=Decimal('0.00'))
    comment = models.CharField(max_length=128, blank=True, default="Not defined")
    type = models.CharField(max_length=32, blank=True, default="Not defined")
    equiht = models.IntegerField(blank=True, default=0)
    tdj = models.IntegerField(blank=True, default=0)
    currency = models.CharField(max_length=32, blank=True, default="Not defined")
    timet = models.DateTimeField(blank=True, default='2000-01-01')
    caisse = models.ForeignKey(Caisse, on_delete=models.CASCADE, related_name='transaction' )
    def __str__(self):
        return f"{self.type}- {self.montant} {self.currency} || {self.montantus} {self.currency}"

class Parametre(models.Model):
    tauxdujour  = models.IntegerField(blank=True, default=0)
    prixgallon = models.IntegerField(blank=True, default=0)
    time = models.DateTimeField(blank=True, default='2021-01-01')
    time2 = models.DateTimeField(blank=True, default='2021-01-01')

    def __str__(self):
        return f"Taux : {self.tauxdujour}. Prix {self.prixgallon} a {self.time}"

     