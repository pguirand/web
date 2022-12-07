from django.contrib import admin
from .models import Produits, Clients, Ventes, Categories, Poste, Employe


# Register your models here.

class VenteAdmin(admin.ModelAdmin):
    list_display = ("date_vente", "heure_vente", "produit", "quantite", "client")

class ProduitAdmin(admin.ModelAdmin):
    list_display = ("code", "description","categorie", "prix")

class CategorieAdmin(admin.ModelAdmin):
    list_display = ("id", "nom_categorie")

class EmployeAdmin(admin.ModelAdmin):
    #list_display = ("id", "prenom", "nom", "poste", "phone", "salaire_base")
    filter_horizontal = ("prod_vendus",)

admin.site.register(Produits, ProduitAdmin)
admin.site.register(Clients)
admin.site.register(Ventes, VenteAdmin)
admin.site.register(Categories, CategorieAdmin)
admin.site.register(Poste)
admin.site.register(Employe, EmployeAdmin)
