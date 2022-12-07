$(document).ready(function() {
    // $('#showpos').click(function() {
    //     window.print();
    // })

    // $('#back').click(function() {
    //     //redirect...
    //     //window.location.replace('/../topgaz/detcaisse'); 
    //     //simulate clicking behavior...
    //     window.location.href = "/../topgaz/detcaisse";

    // })

    setTimeout(function() {  
        window.print();
    },2000);

    window.onfocus = function() {
        setTimeout(function() {
            window.location.href = "/../topgaz/detcaisse";
        },1000);
    };

    // window.onafterprint = function() {
    //     setTimeout(function() {
    //         // window.location.replace('/../topgaz/detcaisse');
    //         window.location.href = "/../topgaz/detcaisse";
    //     },1000)       
    // };
    
});


    // setTimeout(function () { window.print(); }, 3000);
    //     window.onfocus = function () { setTimeout(function () { 
    //         alert('now');
    //         // window.close(); 
    //     }, 500); 
    //     }