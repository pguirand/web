from django.urls import path

from . import views


app_name = "proligaz"
urlpatterns = [

path("", views.index, name="index"),
path("login", views.login_view, name="login"),
path("logout", views.logout_view, name="logout"),
path("board", views.board, name="board"),
path("sales", views.sales, name="sales"),
path("new_sale", views.new_sale, name="new_sale"),
path("transaction", views.transaction, name="transaction"),
path("new_client", views.new_client, name="new_client"),
path("clients", views.clients, name="clients"),
path("produits", views.produits, name="produits"),
path("info", views.info, name="info"),
path("sales/<int:sale_id>", views.sale, name="sale"),
path("employe", views.employe, name="employe"),
path("sales/<int:sale_id>/supervise", views.supervise, name="supervise" ),
path("test", views.test, name="test"),
path("java", views.java2, name="java2"),
path("java/sections/<int:num>", views.section, name="section"),
path("test3", views.test3, name="test3"),
path("test4", views.test4, name="test4")
]
