//alert('Parametres')
function showOpt(option) {
    document.querySelectorAll('.cont').forEach(cont => {
        cont.style.display = 'none';
        document.querySelector(`#${option}`).style.display = 'block';

    })
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.optbut').forEach(button => {
        button.onclick = function() {
            showOpt(this.dataset.option);
           
            return false;
            
        }
    })
    document.querySelectorAll('.sauveg').forEach(savebut => {
        savebut.disabled = true;
    })
   
    document.querySelectorAll('.hid2').forEach(inp => {
        inp.onkeyup = function() {
            let id = this.dataset.number;
            if (inp.value.length > 1) {
                document.querySelector(`#${id}`).disabled = false;
            } else {
                document.querySelector(`#${id}`).disabled = true;

            }
        }
    })
})

