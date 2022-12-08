from django.urls import path
from . import views

app_name = "ecom"

urlpatterns = [
    path('', views.index, name='index'),
    path('collections', views.collections, name="collections"),
    path('collectionview/<str:slug>/', views.collectionview, name="collectionview"),
    path('productview/<str:cate_slug>/<str:prod_slug>/', views.productview, name="productview"),
    path('register', views.register, name="register"),
    path('login', views.loginpage, name="loginpage"),
    path('logout', views.logoutpage, name='logoutpage'),
    path('addtocart', views.addtocart, name="addtocart"),
    path('viewcart', views.viewcart, name="viewcart"),
    path('updatecart', views.updatecarte, name="updatecart"),
    path('deleteitem', views.deleteitem, name="deleteitem"),
    path('whishlist', views.wishlist, name="wishlist"),
    path('addtolist', views.addtolist, name="addtolist"),
    path('delwishitem', views.delwishitem, name="delwishitem"),
    path('checkout', views.checkout, name="checkout"),
    path('placeorder', views.placeorder, name="placeorder"),
    path('myorders', views.myorders, name="myorders"),
    path('orderview/<str:tr_no>/', views.orderview, name="orderview"),
    path('prodlist', views.prodlist, name="prodlist"),
    path('searchproduct', views.searchproduct, name="searchproduct")


]