$(document).ready(function() {
    $('#close').prop('disabled', true);

    $('#caisgd').keyup(function() {
        //alert('key');
        var p = parseInt($('#tp1').html());
        if ( $(this).val().length === 0 )
            {
            var h = 0;
            //alert('NUl');
            }
            
        else
            var h = 1;
        $('#tp2').html(h);
        var s = parseInt($('#tp2').html());
        var s1 = p * s;

        var pregd = parseFloat($('#pregd').val());
        var caisgd = parseFloat($('#caisgd').val());
        var ecgd;
        if (h===0) {
            ecgd = '';
        } else {
            ecgd = (caisgd - pregd).toFixed(1);
        }
         
        $('#ecartgd').html(`$  ${ecgd} HT`);
        $('#ec1').val(ecgd);
        if (s1 === 1) {
            $('#close').removeClass('btn-secondary');
            $('#close').addClass('btn-primary');
            $('#close').prop('disabled', false);
        } else {
            $('#close').removeClass('btn-primary');
            $('#close').addClass('btn-secondary');
            $('#close').prop('disabled', true);

        }
        if (ecgd < 0) {
            console.log('negatif');
            $('#ecartgd').addClass('text-danger');
        } else if(ecgd === 0) {
            console.log('zero');
            $('#ecartgd').removeClass('text-danger');
            $('#ecartgd').addClass('text-success');

        } else {
            console.log('positif');
            $('#ecartgd').removeClass('text-danger');
            $('#ecartgd').removeClass('text-success');

        }
        return false;


    });

    $('#caisus').keyup(function() {
        //alert('key');
        var q = parseInt($('#tp2').html());
        if ( $(this).val().length === 0 )
            var g = 0;
        else
            var g = 1;
        $('#tp1').html(g)
        var t = parseInt($('#tp1').html())
        var t1 = q * t ;
        var preus = parseFloat($('#preus').val());
        var caisus = parseFloat($('#caisus').val());

        var ecus;
        if (g===0) {
            ecus = '';
        } else {
            ecus = (caisus - preus).toFixed(1); 
        }
        $('#ecartus').html(`${ecus} USD`);
        $('#ec2').val(ecus);
        if (t1 === 1) {
            $('#close').removeClass('btn-secondary');
            $('#close').addClass('btn-primary');
            $('#close').prop('disabled', false);
            //console.log(t1);

        } else {
            $('#close').removeClass('btn-primary');
            $('#close').addClass('btn-secondary');
            $('#close').prop('disabled', true);
        }
        if (ecus < 0) {
            console.log('negatif');
            $('#ecartus').addClass('text-danger');
        } else if(ecus === 0) {
            console.log('zero');
            $('#ecartus').removeClass('text-danger');
            $('#ecartus').addClass('text-success');

        } else {
            console.log('positif');
            $('#ecartus').removeClass('text-danger');
            $('#ecartus').removeClass('text-success');

        }
        return false;

    });



})