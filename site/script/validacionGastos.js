const form = document.getElementById('form');
const inputs = Array.from(form.getElementsByClassName('pago'));
const submit = document.getElementById('submit');
console.log(submit);
console.log(inputs);
const total = 10;
let totalSuma = 0;

inputs.forEach(input => {
    input.addEventListener('keyup', e => {
        totalSuma = 0;
        inputs.forEach(input => {
            totalSuma += parseInt(input.value);
        });
        if (totalSuma < total) {
            console.log(`Te quedan por asignar ${total - totalSuma}`);
            submit.disabled = true;
        } else if (totalSuma > total) {
            console.log(`Te has pasado, sobran ${totalSuma - total}`);
            submit.disabled = true;
        } else if(totalSuma === total){
            console.log(`Correcte (suma)${totalSuma} = (total)${total}`);
            submit.disabled = false;

        }
    });
});


