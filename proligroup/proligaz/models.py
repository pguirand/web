from django.db import models
from django.utils import timezone
import datetime

# Create your models here.
class Clients(models.Model):
    prenom = models.CharField(max_length=64)
    nom = models.CharField(max_length=64)
    phone1 = models.CharField(max_length=32)
    phone2 = models.CharField(max_length=32, blank=True)
    adresse = models.CharField(max_length=128, blank=True)
    mail = models.CharField(max_length=64, blank=True)
    niveau = models.CharField(max_length=32, blank=True)

    def __str__(self):
        return f"{self.prenom}, {self.nom} : Tel: {self.phone1}"

class Categories(models.Model):
    nom_categorie = models.CharField(max_length=64)

    def __str__(self):
        return f"{self.id} - Catégorie : {self.nom_categorie}"


class Produits(models.Model):
    code = models.CharField(max_length=4)
    description = models.CharField(max_length=128)
    categorie = models.ForeignKey(Categories, on_delete=models.CASCADE)
    prix = models.DecimalField(max_digits=7, decimal_places=2)
    #prix = models.IntegerField()

    def __str__(self):
        return f"{self.id}: ({self.code})- {self.description} dans {self.categorie} est à ${self.prix}.00"



class Ventes(models.Model):
    date_vente = models.DateField()
    heure_vente = models.TimeField()
    commentaire = models.CharField(max_length=128, default="No Comment", blank=True)
    produit = models.ForeignKey(Produits, on_delete=models.CASCADE, related_name="articles")
    quantite = models.IntegerField(default=1)
    client = models.ForeignKey(Clients, on_delete=models.CASCADE, related_name="acheteurs")
    def __str__(self):
        return f"{self.id}: {self.produit} {self.quantite} par : {self.client}"

class Poste(models.Model):
    nom_poste = models.CharField(max_length=128)
    description = models.CharField(max_length = 256)
    def __str__(self):
        return f"{self.id} : {self.nom_poste} - {self.description}"


class Employe(models.Model):
    prenom = models.CharField(max_length=64)
    nom = models.CharField(max_length=128)
    poste = models.ForeignKey(Poste, on_delete=models.CASCADE, related_name="postevendeur")
    phone = models.CharField(max_length=64)
    mail = models.CharField(max_length=128, blank=True)
    salaire_base = models.DecimalField(max_digits=7, decimal_places=2, blank=True, default=0)
    prod_vendus = models.ManyToManyField(Ventes, blank=True, related_name="vendeur")
    def __str__(self):
        return f"{self.id}: {self.prenom} {self.nom} {self.salaire_base}"


class Remplissage(models.Model):
    heure_rempl = models.DateTimeField(blank=True, default='2020-06-10 00:14')
    compt_debut = models.DecimalField(max_digits=6, decimal_places=1)
    compt_avant = models.DecimalField(max_digits=6, decimal_places=1)
    achat_pour = models.DecimalField(max_digits=6, decimal_places=2, blank=True)
    quantite = models.DecimalField(max_digits=6, decimal_places=1)
    compt_apres = models.DecimalField(max_digits=6, decimal_places=1)
    px_gallon = models.IntegerField()
    montant = models.DecimalField(max_digits=5, decimal_places=2)
    compt_fin = models.DecimalField(max_digits=6, decimal_places=1, blank=True, default=0)
    type_pay = models.CharField(max_length=32, blank=True, default='CASH')
    statut = models.CharField(max_length=32, blank=True, default="OPENED")
