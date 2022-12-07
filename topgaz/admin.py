from django.contrib import admin
from django.contrib.admin.options import ModelAdmin
from .models import Caisse, Compagnie, Creance, Employe, Customer, Parametre, Poste, Transaction, Vente, Client, Secteur

# Register your models here.

class CaisseAdmin(admin.ModelAdmin):
    list_display = ('id', 'heure_ouv', 'gd_open', 'us_open')

class VenteAdmin(admin.ModelAdmin):
    filter_horizontal = ('caisse',)

# class EmployeAdmin(admin, ModelAdmin):
#     filter_horizontal = ('poste',)

admin.site.register(Client)
admin.site.register(Secteur)
admin.site.register(Creance)
admin.site.register(Employe)
admin.site.register(Customer)
admin.site.register(Caisse, CaisseAdmin)
admin.site.register(Vente)
admin.site.register(Transaction)
admin.site.register(Parametre)
admin.site.register(Poste)
admin.site.register(Compagnie)


