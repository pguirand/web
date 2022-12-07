//alert('Hello TopGaz');
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('#modinput').style.display = 'none';
    const initmeter = document.querySelector('#contmeter').innerHTML;
    document.querySelector('#newmeter').value = parseFloat(initmeter);

    // document.querySelector('#chcash').onclick = function() {
    //     document.querySelector('#cash1').style.display = 'block';
    //     document.querySelector('#cash2').style.display = 'block';
    // }

    document.querySelector('#butmod').onclick = function() {
        document.querySelector('#modinput').style.display = 'block';
        document.querySelector('#butok').disabled = true;
        //document.querySelector('#newmeter').value = '';
        document.querySelector('#newmeter').focus();
        document.querySelector('#newmeter').select();


        document.querySelector('#newmeter').onkeyup = () => {
            if (document.querySelector('#newmeter').value.length > 3) {
                document.querySelector('#butok').disabled = false;
            } else {
                document.querySelector('#butok').disabled = true;
            }
        
        document.querySelector('#butok').onclick = () => {
            const nmeter = document.querySelector('#newmeter').value;
            document.querySelector('#contmeter').innerHTML = nmeter;
            //document.querySelector('#newmeter').value = '';
            document.querySelector('#butok').disabled = true;
            document.querySelector('#modinput').style.display = 'none';
            return false;
        }    
            
        }
        return false;
    }
})