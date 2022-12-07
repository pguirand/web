from unicodedata import name
from django.urls import path
from . import views

app_name = 'topgaz'

urlpatterns = [
    path("", views.index, name="index"),
    path("customers", views.customers, name="customers"),
    path("caisse", views.caisse, name="caisse"),
    path("detcaisse", views.detcaisse, name="detcaisse"),
    path("operation", views.operation, name="operation"),
    path("closing", views.closing, name="closing"), 
    path("param", views.param, name="param"),
    path("creer_user", views.creer_user, name="creer_user"),
    path("addemp", views.addemp, name="addemp"),
    path("userpage", views.userpage, name="userpage"),
    path("plogin", views.plogin, name="plogin"),
    path("plogout", views.plogout, name="plogout"),
    path("useradd", views.useradd, name="useradd"),
    path("rh", views.rh, name="rh"),
    path("myprint", views.myprint, name="myprint"),
    path("compagnie", views.compagnie, name="compagnie"),
    path("printpage", views.printpage, name="printpage"),
    path("viewcaisse/<int:caisse_id>", views.viewcaisse, name="viewcaisse"),
    path('transac', views.transac, name="transac"),
    path('clients', views.clients, name="clients"),
    path('delclient/<int:client_id>', views.delclient, name="delclient"),
    path('secteur', views.secteur, name="secteur"),
    path('delsecteur/<int:secteur_id>', views.delsecteur, name="delsecteur"),
    path('load_client', views.load_client, name="load_client"),
    path('paiement', views.paiement, name="paiement")
]