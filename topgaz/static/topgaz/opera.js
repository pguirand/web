//alert('Interface Operations ...')


function showDiv(operation) {
    document.querySelectorAll('.operation').forEach(operation => {
        operation.style.display = 'none';
    })
    document.querySelector(`#${operation}`).style.display = 'block';
}

document.addEventListener('DOMContentLoaded', function () {
    //alert('Test ongoing...');

    let lprix = parseInt(document.querySelector('#prix').innerHTML);
    document.querySelector('#qtegal').focus();
    document.querySelector('#qtegal').onkeyup = () => {
        //alert('hey');
        let qte = document.querySelector('#qtegal').value;
        //document.querySelector('#nbr').innerHTML = qte;
        let prix = parseInt(document.querySelector('#prix').innerHTML)
        let avant = parseFloat(document.querySelector('#avantm').innerHTML)
        let after = (parseFloat(qte) + parseFloat(avant)).toFixed(1)
        //document.querySelector('#metapr').innerHTML = after;
        total = (qte * prix).toFixed(2);
        document.querySelector('#p2gal').value = prix;
        document.querySelector('#afterm').innerHTML = after;
        document.querySelector('#meter2').value = after;

        document.querySelector('#buytot').innerHTML = total;
        document.querySelector('#p2tot').value = total;
        //document.querySelector('#montantt').innerHTML = total;
        //document.querySelector('#alltot').innerHTML = `$${total}`;
    }
    document.querySelector('#utransac').onkeyup = () => {
        //alert('hey');
        let toc = document.querySelector('#utransac').value;
        let rate = parseInt(document.querySelector('#rate').innerHTML); 
        document.querySelector('#ceg').innerHTML = `$${toc * rate/5}`;


    }

    // setTimeout(function () { window.print(); }, 3000);
    //     window.onfocus = function () { setTimeout(function () { 
    //         alert('now');
    //         // window.close(); 
    //     }, 500); 
    //     }

    // window.onafterprint = function() {
    //var mysell = document.querySelector('#vente');
    //mysell.click();
    //alert("Print Completed");
    // }


    // document.querySelector('#sell').onclick = function() {
    //     alert('...');
    //     window.print();
    //     window.onfocus = function() {
    //         setTimeout(function() {
    //             console.log('now');
    //         },3000);

    //         }
    //     };


    // setTimeout(function () { window.print(); }, 3000);
    // window.onfocus = function () { setTimeout(function () { 
    //     alert('now');

    //     // window.close(); 
    // }, 5000);





    // var alertdiv = document.querySelector('.alert');
    // setTimeout(function() {
    //     document.querySelectorAll('.alert').forEach(div => {
    //         div.remove();
    //     })
    //     //alertdiv.remove();

    // },3000)


    // document.querySelector('#summary').style.display = 'block';
    // document.querySelector('#vente').style.display = 'block';
    // document.querySelector('#transaction').style.display = 'block';

    // document.querySelectorAll('.bop').forEach(bop => {
    //     bop.onclick = function() {
    //         showDiv(this.dataset.operation);
    //     }
    // })


})
