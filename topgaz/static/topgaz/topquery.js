// function myprint() {
//     let text = "Press a button!\nEither OK or Cancel.";
//     if (confirm(text) == true) {
//       text = "Printing...";
//       window.print();
//       return false;
//     } else {
//       text = "You canceled!";
//       return false;
//     }
//     document.getElementById("demo").innerHTML = text;
//   }

function calcul() {
    var newmet = $('#fini').val();
    $('#errafter').val(newmet);
}

$(document).ready(function() {

    //Parametres
    $('#taux').addClass('hidden');
    var diff, nmont;
    $('#errmont').val(0);
    // $("#id").css("display", "none");
    // $("#id").css("display", "block");
    //alert('ready');

    //$('#pos').css('display','none');
    $('#ok1').hide();
    $('#ok2').hide();
    $('#cordiv').hide();
    $('#cordiv2').hide();
    $('#corrig').hide();
    $('#annul').hide();
    //var vtot = parseFloat($('#lastin').html());
    //$('#nolastv').val(vtot * -1); 
    //alert('12');

    var dec1 = parseFloat($('#lbg').html());
    var dec2 = parseFloat($('#lbu').html());

    
    $('#mtg').val(dec1);
    $('#mtu').val(dec2);


    // $('.confirmation').click(function() {
    //     $(".ui-dialog-titlebar").hide();
    //     return confirm('Etes-vous Surr ?');
    // });

    // $(".confirmation").confirm({
    //     title:"Delete confirmation",
    //     text:"This is very dangerous, you shouldn't do it! Are you really really sure?",
    //     confirm: function(button) {
    //         alert("You just confirmed.");
    //     },
    //     cancel: function(button) {
    //         alert("You aborted the operation.");
    //     },
    //     confirmButton: "Yes I am",
    //     cancelButton: "No"
    // });

    $('.confirmation').click(function() {  
        // return confirm('Are You sure ?');
        //return confirm('Etes-vous Surr ?');
        let text = "Etes-vous sur de vouloir supprimer ?";
        if (confirm(text) == true) {
            //text = "You pressed OK!";
        } else {
            //text = "You canceled!";
            return false;
        }
        // document.getElementById("demo").innerHTML = text;
    });
    

    $('#chg1').click(function() {
        $('#taux').slideDown('fast');
        return false
    });

    $('#anul1').click(function() {
        $('#taux').slideUp('fast');
        return false
    });

    $('#chg2').click(function() {
        $('#dprice').slideDown('fast');
        return false
    });

    $('#anul2').click(function() {
        $('#dprice').slideUp('fast');
        //$('#dprice').toggle('slide');
        return false
    });

    $('#sell').click(function() {
        //alert('hi');
        window.print();
        //var dvent = $('#vente')
        setTimeout(function() {
            //alert('goin to click');
            $('#vente').click();
        }, 2000);
    });

    $('#fini').keyup(function() {
        //calcul();
        var start = parseFloat($('#averr').html());
        var end = parseFloat($('#fini').val());
        var prix = parseInt($('#prix').html());
        
        //alert(`${start}`);
        diff = (end - start).toFixed(1);
        var newmet = end;
        nmont = (diff * prix).toFixed(2);
        //$('#errmont').val(nmont);
        $('#errloss').val(nmont);
        $('#errafter').val(newmet);
        $('#errnb').val(diff);

        

        if (diff < 0) {
            $('#dif').css('color', 'red');
            $('#ifpay').prop('disabled',false);
        } else if (diff == 0 ){
            $('#dif').css('color', 'black');
            $('#ifpay').prop('checked', false);
            $('#ifpay').prop('disabled',true);
        } else {
            $('#dif').css('color', 'green');
            $('#ifpay').prop('disabled',false);
        }
        $('#dif').html(`${diff} Gal.`);
    })

    $('#ifpay').click(function() {
        if($(this).prop('checked') == true) {
            $('#errloss').val(0);
            $('#errmont').val(nmont);
            $('#flag').val('NON');


        } else if ($(this).prop('checked')==false) {
            $('#errloss').val(nmont);
            $('#errmont').val(0);
            $('#flag').val('OUI');

        }    
    });

    $('#corrig').click(function() {
        var m1 = parseFloat($('#averr').html());
        var m2 = parseFloat($('#aperr').html());
        var adif = m2 - m1;
        //alert(adif);
        if (adif<diff) {
            alert('Koreksyon pa ka plis ke dènye vant la !');
            return false;
        };

        if (diff < 0) {
            alert('Meter apres doit etre superieur a Meter avant !\r\nRevérifier.');
            return false;
        } else if (diff==0) {
            $('#flag').val('NON');
            $('#valerror').trigger('click');
            return false;
        } else {
            $('#valerror').trigger('click');
            return false;
        }      
    });

    // $('input[type="checkbox"]').click(function(){
    //     if($(this).is(":checked")){
    //         console.log("Checkbox is checked.");
    //     }
    //     else if($(this).is(":not(:checked)")){
    //         console.log("Checkbox is unchecked.");
    //     }
    // });

    $('#chcash').click(function() {
        //alert('ok');
        $('.newcash').slideDown('fast');
        $('#opennow').removeClass('btn-primary');
        $('#opennow').prop('disabled', true);
        $('#okc').prop('disabled', true);
        $('#cash3').slideUp('fast');
        $('#mtg').val('');
        $('#mtu').val('');
        return false;

    });

    $('#erreur').click(function() {
        $('#erreur').hide();
        $('#cordiv').slideDown('fast');
        $('#cordiv2').slideDown('fast');
        $('#corrig').slideDown('fast');
        $('#annul').slideDown('fast');
        $('#flag').val('OUI');
    
    });

    $('#annul').click(function() {
        $('#flag').val('NON');
        //alert('hey');
        //$('#cordiv').hide('slide', {direction: 'left'}, 2500);
        $('#erreur').hide();
        $('#cordiv2').slideUp('fast');
        $('#cordiv').slideUp('fast');

        $('#corrig').slideUp('fast');
        $('#annul').slideUp('fast');
        setTimeout(function() {
            $('#erreur').slideDown('fast');
        }, 200);
        
        //$('#erreur').slideDown('fast');

    })

    $('#okc').click(function() {
        $('#cash2').slideUp('medium');
        $('#cash3').slideDown('fast');
        $('#okc').removeClass('btn-primary');
        $('#okc').prop('disabled', true);
        $('#newg').html($('#mtg').val());
        $('#newu').html($('#mtu').val());
        $('#opennow').addClass('btn-primary');
        $('#opennow').prop('disabled', false);
        $('.before').css('text-decoration','line-through');
        $('.before').css('color','red');
        $('.after').css('font-size','22px');
        $('.after').css('font-weight','bolder');
        $('.after').css('color','green');
        return false;


    });

    $("#mtg").keyup(function() {
        var q = parseInt($('#ok2').html());
        if ( $(this).val().length === 0 )
            var g = 0;
        else
            var g = 1;
        $('#ok1').html(g)
        var t = parseInt($('#ok1').html())
        var t1 = q * t ;
        if (t1 === 1) {
            $('#okc').addClass('btn-primary');
            $('#okc').prop('disabled', false);
        } else {
            $('#okc').removeClass('btn-primary');
            $('#okc').prop('disabled', true);
        }
        //alert('ok');
        return false;

    });
    $("#mtu").keyup(function() {
        var p = parseInt($('#ok1').html());
        if ( $(this).val().length === 0 )
            var h = 0;
        else
            var h = 1;
        $('#ok2').html(h);
        var s = parseInt($('#ok2').html());
        var s1 = p * s;
        if (s1 === 1) {
            $('#okc').addClass('btn-primary');
            $('#okc').prop('disabled', false);
        } else {
            $('#okc').removeClass('btn-primary');
            $('#okc').prop('disabled', true);
        }
        return false;

        //Achat credits

        //alert(s1);
    });

    $('#debt').hide();
    $('#acredit').click(function() {
        $('#debt').slideDown('fast');
    });

    $('#pcash').click(function() {
        $('#debt').slideUp('fast');
    })

    // $('#opennow').click(function() {
    //     $('#myform').submit();
    // })

    //$('#success-alert').fadeOut(2000);
    //alert('Hello JQuery');
    $('.newcash').hide();
    //$('#cash3').hide();
    $(".alert").fadeTo(2000, 0.7).slideUp(500, function() {
    $(".alert").slideUp(1000);


});
});




  // $('#success-alert').html("Hello 3World!");
    // $('.alert').fadeOut(2000);


