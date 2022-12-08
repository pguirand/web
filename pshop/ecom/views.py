from django.shortcuts import redirect, render
from django.http import HttpResponse, JsonResponse, HttpResponseRedirect
from django.contrib import messages
from django.contrib.auth import authenticate, login, logout
from django.contrib.auth.decorators import login_required
from django.contrib.auth.models import User 
from .models import *
import random
import datetime, os
from .forms import CustomUserForm
from django.urls import reverse

# Create your views here.

def index(request):
    trending_prod = Product.objects.filter(trending=1)
    return render(request, 'ecom/index.html', {
        'trending': trending_prod
    })

def collections(request):
    collections = Category.objects.filter(status=0)
    return render(request, "ecom/collections.html", {
        'collections':collections
    })

def collectionview(request, slug):
    if Category.objects.filter(slug=slug, status=0):
        products = Product.objects.filter(category__slug=slug)
        category_name = Category.objects.get(slug=slug)
        return render(request, "ecom/products.html", {
            "products": products,
            'category':category_name
        })
    else:
        messages.warning(request, "No such Categorie found")
        return redirect('ecom:collections')

def productview(request, cate_slug,  prod_slug):
    if(Category.objects.filter(slug=cate_slug, status=0)):
        if(Product.objects.filter(slug=prod_slug, status=0)):
            product = Product.objects.filter(slug=prod_slug, status=0).first()
            category = Category.objects.get(slug=cate_slug, status=0)
        else:
            messages.error(request, "No such Product found")
            return redirect('ecom:collections')

    else:
        messages.error(request, "No such Category found")
        return redirect('ecom:collections')
    return render(request, "ecom/productview.html", {
        "product": product, 
        'category': category
    })

def register(request):
    form = CustomUserForm()
    if request.method == 'POST':
        form = CustomUserForm(request.POST)
        if form.is_valid():
            form.save()
            messages.success(request, "Registered Successfully! Login to continue")
            return redirect('ecom:loginpage')
    return render(request, "ecom/register.html", {
        "form":form
    })

def loginpage(request):
    if request.user.is_authenticated:
        messages.warning(request, "You're already logged in.")
        return redirect('ecom:collections')
    else:
        if request.method == "POST":
            name = request.POST.get('username')
            passw = request.POST.get('password')

            user = authenticate(request, username=name, password=passw)

            if user is not None:
                login(request, user)
                messages.success(request, "Logged in Successfully !")
                return redirect('ecom:collections')
            else:
                messages.error(request, "Invalid username or password")
                return redirect('ecom:loginpage')
        return render(request, "ecom/login.html")

def logoutpage(request):
    if request.user.is_authenticated:
        logout(request)
        messages.success(request, "Logged out Successfully.")
        return redirect('ecom:index')

@login_required(login_url='ecom:loginpage')
def addtocart(request):
    if request.method == "POST":
        if request.user.is_authenticated:
            prod_id = int(request.POST.get('product_id'))
            product_check = Product.objects.get(id=prod_id)
            if product_check:
                if(Cart.objects.filter(user=request.user.id, product_id=prod_id)):
                    return JsonResponse({
                        'status': "Product already in Cart"
                    })
                else:
                    prod_qty = int(request.POST.get('product_qty'))

                    if product_check.quantity >= prod_qty:
                        Cart.objects.create(user=request.user, product_id=prod_id, product_qty=prod_qty)
                        return JsonResponse({
                            'status':"Product added Successfully!"
                        })
                    else:
                        return JsonResponse({
                            'status': "Only "+ str(product_check.quantity)+ " quantity available."
                        })
            else:
                return JsonResponse({
                    'status': "No such product found"
                })
        else:
            return JsonResponse({
                'status': "Login to continue"
            })
    return redirect('ecom:index')


@login_required(login_url='ecom:loginpage')
def viewcart(request):
    cart = Cart.objects.filter(user=request.user)
    return render(request, "ecom/cart.html", {
        "cart":cart
    })

@login_required(login_url='ecom:loginpage')
def updatecarte(request):
    if request.method == "POST":
        prod_id = int(request.POST.get('product_id'))
        if(Cart.objects.filter(user=request.user, product_id=prod_id)):
            prod_qty = int(request.POST.get('product_qty'))
            cart = Cart.objects.get(user=request.user, product_id=prod_id)
            cart.product_qty = prod_qty
            cart.save()
            return JsonResponse({
                'status': 'Updated Successfully!'
            })
    return redirect('ecom:collections')

@login_required(login_url='ecom:loginpage')
def deleteitem(request):
    if request.method == 'POST':
        prod_id = int(request.POST.get('product_id'))
        if(Cart.objects.filter(user=request.user, product_id=prod_id)):
            cartitem = Cart.objects.get(product_id=prod_id, user=request.user)
            cartitem.delete()
            return JsonResponse({
                'status': 'Deleted Successfully'
            })
        return redirect('ecom:collections')


@login_required(login_url='ecom:loginpage')
def wishlist(request):
    wishlist = Wishlist.objects.filter(user=request.user)
    return render(request, 'ecom/wishlist.html', {
        'wishlist':wishlist
    })

def addtolist(request):
    if request.method == "POST":
        if request.user.is_authenticated:
            prod_id = int(request.POST.get('product_id'))
            product_check = Product.objects.get(id=prod_id)
            if product_check:
                if(Wishlist.objects.filter(user=request.user, product_id=prod_id)):
                    return JsonResponse({
                        'status': "Product already in Wishlist"
                    })
                else:
                    Wishlist.objects.create(user=request.user, product_id=prod_id)
                    return JsonResponse({
                        'status': 'Item Added to WishList Successfully.'
                    })
            else:
                return JsonResponse({
                    'status': 'No such Product found'
                })
        else:
            return JsonResponse({
                'status': 'Login to Continue'
            })    
    
    return redirect('ecom:wishlist')

def delwishitem(request):
    if request.method == "POST":
        if request.user.is_authenticated:
            prod_id = int(request.POST.get('product_id'))
            if(Wishlist.objects.filter(user=request.user, product_id=prod_id)):
                wishlistitem = Wishlist.objects.get(product_id=prod_id)
                wishlistitem.delete()
                return JsonResponse({
                    'status': "Product removed from WishList"
                })
            else: 
                return JsonResponse({
                    'status': 'Product not found in WishList.'
                })
        else:
            return JsonResponse({
                'status': 'Login to continue'
            })
    return redirect('ecom:wishlist')


@login_required(login_url='ecom:loginpage') 
def checkout(request):
    rawcart = Cart.objects.filter(user=request.user)
    for item in rawcart:
        if item.product_qty > item.product.quantity:
            to_be_removed = Cart.objects.get(id=item.id)
            to_be_removed.delete()

    cartitems = Cart.objects.filter(user=request.user)
    total_price = 0
    for item in cartitems:
        total_price = total_price + item.product.selling_price * item.product_qty

    userprofile = Profile.objects.filter(user=request.user).first()

    return render(request, "ecom/checkout.html", {
        'cartitems': cartitems, 
        'total_price': total_price,
        'userprofile':userprofile
    })



@login_required(login_url='ecom:loginpage') 
def placeorder(request):
    if request.method == "POST":

        currentuser = User.objects.get(id=request.user.id)

        if not currentuser.first_name:
            currentuser.first_name = request.POST.get('fname')
            currentuser.last_name = request.POST.get('lname')
            currentuser.save()
        
        if not Profile.objects.filter(user=request.user):
            userprofile = Profile()
            userprofile.user = request.user
            userprofile.phone = request.POST.get('phone')
            userprofile.address = request.POST.get('address')
            userprofile.city = request.POST.get('city')
            userprofile.state = request.POST.get('state')
            userprofile.country = request.POST.get('country')
            userprofile.pincode = request.POST.get('pincode')

            userprofile.save()



        neworder = Order()
        neworder.user = request.user
        neworder.fname = request.POST.get('fname')
        neworder.lname = request.POST.get('lname')
        neworder.email = request.POST.get('email')
        neworder.phone = request.POST.get('phone')
        neworder.address = request.POST.get('address')
        neworder.city = request.POST.get('city')
        neworder.state = request.POST.get('state')
        neworder.country = request.POST.get('country')
        neworder.pincode = request.POST.get('pincode')
        neworder.payment_mode = request.POST.get('payment_mode')
        neworder.payment_id = request.POST.get('payment_id')


        cart = Cart.objects.filter(user=request.user)
        cart_total_price = 0    
        for item in cart:
            cart_total_price = cart_total_price +  item.product.selling_price * item.product_qty

        neworder.total_price = cart_total_price
        trackno = 'pshop'+str(random.randint(1111111, 9999999))
        while Order.objects.filter(tracking_no=trackno) is None:
            trackno = 'pshop'+str(random.randint(1111111, 9999999))

        neworder.tracking_no = trackno
        neworder.save()

        neworderitems = Cart.objects.filter(user=request.user)
        for item in neworderitems:
            OrderItem.objects.create(
                order = neworder,
                product = item.product, 
                price = item.product.selling_price, 
                quantity = item.product_qty
            )

            #Decrease quantity from available stock
            orderproduct = Product.objects.filter(id=item.product_id).first()
            orderproduct.quantity = orderproduct.quantity - item.product_qty
            orderproduct.save()

        # Clear user's Cart
        Cart.objects.filter(user=request.user).delete()

        messages.success(request, "Your order has been placed Successfully !")

        payMode = request.POST.get('payment_mode')
        if payMode == "Paid by Paypal":
            return JsonResponse({'status': "Your order has been placed Successfully !"})

    return redirect("ecom:collections")
        
def myorders(request):
    orders = Order.objects.filter(user=request.user)
    return render(request, "ecom/orders.html", {
        "orders":orders
    })

def orderview(request, tr_no):
    order = Order.objects.filter(user=request.user).filter(tracking_no=tr_no).first()
    orderitems = OrderItem.objects.filter(order=order)
    if order is None:
        return HttpResponse(f'No order with tracking No : {tr_no} ')
    else:
        return render(request, "ecom/orderview.html", {
            "order": order,
            "orderitems":orderitems
        })

def prodlist(request):
    products = Product.objects.filter(status=0).values_list('name', flat=True)
    productlist = list(products)
    return JsonResponse(productlist, safe=False)

def searchproduct(request):
    if request.method == "POST":
        searched = request.POST.get("searchedstring")
        if searched == "":
            return redirect(request.META.get('HTTP_REFERER'))
        else:
            product = Product.objects.filter(name__contains=searched).first()

            if product:
                # return redirect("productview"+"/"+product.category.slug+"/"+product.slug+"/")
                # return HttpResponseRedirect("collectionview"+"/"+product.category.slug+"/"+product.slug+"/")
                return redirect("ecom:productview", product.category.slug, product.slug)
            else:
                messages.info(request, "No product found from your search")
                return redirect(request.META.get('HTTP_REFERER'))


    return redirect(request.META.get('HTTP_REFERER'))
