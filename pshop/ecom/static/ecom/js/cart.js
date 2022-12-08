// alert('hello');
$(document).ready(function() {
    $('.increment-btn').click(function(e) {
        e.preventDefault();

        var inc_value = $(this).closest('.product-data').find('.qty-input').val();
        var value = parseInt(inc_value, 10);
        value = isNaN(value) ? 0: value;
        if(value < 10)
        {
            value++;
            $(this).closest('.product-data').find('.qty-input').val(value);
        }

    })

    $('.decrement-btn').click(function(e) {
        e.preventDefault();

        var dec_value = $(this).closest('.product-data').find('.qty-input').val();
        var value = parseInt(dec_value, 10);
        value = isNaN(value) ? 0: value;
        if(value > 1)
        {
            value--;
            $(this).closest('.product-data').find('.qty-input').val(value);
        }

    })

    $('.addToCartBtn').click(function(e) {
        e.preventDefault();

        var product_id = $(this).closest('.product-data').find('.prod_id').val();
        var product_qty = $(this).closest('.product-data').find('.qty-input').val();
        var token = $('input[name=csrfmiddlewaretoken]').val();
        $.ajax({
            method: "POST",
            url:"/shopping/addtocart",
            data: {
                'product_id':product_id,
                'product_qty':product_qty,
                csrfmiddlewaretoken: token
            },
            success: function(response) {
                console.log(response);
                alertify.success(response.status);
            }

        });
        
    });

    $('.changeQty').click(function(e) {
        e.preventDefault();

        var product_id = $(this).closest('.product-data').find('.prod_id').val();
        var product_qty = $(this).closest('.product-data').find('.qty-input').val();
        var token = $('input[name=csrfmiddlewaretoken]').val();
        $.ajax({
            method: "POST",
            url:"/shopping/updatecart",
            data: {
                'product_id':product_id,
                'product_qty':product_qty,
                csrfmiddlewaretoken: token
            },
            success: function(response) {
                console.log(response);
                // alertify.success(response.status);
            }

        });
        
    });
    
    $(document).on('click', '.deleteitem', function (e) {
        e.preventDefault();
        
        var product_id = $(this).closest('.product-data').find('.prod_id').val();
        var token = $('input[name=csrfmiddlewaretoken]').val();
        
        $.ajax({
            method: "POST",
            url: "/shopping/deleteitem",
            data: {
                'product_id':product_id,
                csrfmiddlewaretoken: token
            },
            success: function (response) {
                console.log(response);
                alertify.success(response.status);
                $('.cartdata').load(location.href + " .cartdata");
            }
        });
        
    });

    $('.addtolist').click(function (e) { 
        e.preventDefault();
        
        var product_id = $(this).closest('.product-data').find('.prod_id').val();
        var token = $('input[name=csrfmiddlewaretoken]').val();
        $.ajax({
            method: "POST",
            url:"/shopping/addtolist",
            data: {
                'product_id':product_id,
                csrfmiddlewaretoken: token
            },
            success: function(response) {
                console.log(response);
                alertify.success(response.status);
            }

        });
        
    });

    $(document).on('click', '.delwishitem', function (e) {
 
        e.preventDefault();

        var product_id = $(this).closest('.product-data').find('.prod_id').val();
        var token = $('input[name=csrfmiddlewaretoken]').val();
        $.ajax({
            method: "POST",
            url:"/shopping/delwishitem",
            data: {
                'product_id':product_id,
                csrfmiddlewaretoken: token
            },
            success: function(response) {
                console.log(response);
                alertify.success(response.status);
                $('.wishdata').load(location.href + " .wishdata");

            }

        });


        
    });
    
})