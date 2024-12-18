let input = document.getElementById('code-postal');
let displayMag = document.getElementById('magasins');

console.log(displayMag.innerHTML);


function checkCodePostal(){
    if (input.value.length == 5 && !isNaN(input.value)) {
        value = input.value;
        window.location.replace('/panier/retrait/'+value);
    }
}

input.addEventListener('selectionchange', checkCodePostal);