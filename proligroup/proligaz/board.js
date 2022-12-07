document.addEventListener('DOMContentLoaded', function() {
  document.querySelector('#form1').onsubmit = function() {
    const autres = document.querySelector('#autres').value;
    alert(`Vous avez choisi: ${autres} gallons.`);
  };
});
