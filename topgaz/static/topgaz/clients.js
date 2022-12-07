$(document).ready(function() {
    $('#cdata').hide();
    $('.hinput').hide();
    $('.payok').hide();
    $('.payok').prop('disabled', true);

    $('.confirmpay').click(function() {
        var montant = $(this).prev('.hinput').val();  
        var client = $(this).next('.names').val();
        // return confirm('Are You sure ?');
        //return confirm('Etes-vous Surr ?');
        let text = `${client} Paie $ ${montant} HT - Confirmer Paiement ?`;
        if (confirm(text) == true) {
            //text = "You pressed OK!";
        } else {
            //text = "You canceled!";
            return false;
        }
        // document.getElementById("demo").innerHTML = text;
    });

    $('.vend').click(function() {
        var next = $(this).next('.hinput');
        $('.hinput').not(next).hide();
        $('.payok').hide();
        $('.payok').prop('disabled', true);
        //$(this).next('.hinput').toggle(200);
        next.toggle(300);
        next.focus();
        return false;
    });

    $('.hinput').keyup(function() {
        $(this).next('.payok').show();
        if ($(this).val().length > 1)
            $('.payok').prop('disabled', false);
        else 
            $('.payok').prop('disabled', true);
    })
    $('#ch_emp').change(function() {
        var valselec = this.value;
        //var valselec = $('#ch_emp').val();
        var optselec = $("option:selected", this).text();
        //alert(`${valselec} value is selected`);
        //alert(`${optselec}`);
        console.log(`${optselec}`);
        $.ajax({
            data: $(this).serialize(),
            url: "load_client",
            //on success
            success: function(response) {
                console.log(response);
                $('#cdata').slideDown('fast');
                $('#numcl').html(`Client # ${response.num_client}`);
                $('#dclient').html(response.nom_client);
                $('#dsect').html(response.secteur);
                $('#dsolde').html(response.solde);
                $('#numero').val(response.num_client);
            },
            error: function(response) {
                console.log('error');
            }
        });
        return false;
    })
})