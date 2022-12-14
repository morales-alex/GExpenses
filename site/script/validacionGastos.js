class ValidacionCuantiaAvanzado{
    cuantiaTotal;
    totalSuma = 0;
    constructor(cuantiaTotal){
        this.cuantiaTotal = cuantiaTotal;
        this.totalSuma = 0;
    }
    calcTotalSuma(inputs){
        inputs.forEach(input =>{
            this.totalSuma += parseInt(input.value);
        });
        return this.totalSuma;
    }

    logicaRetroaccionUsuario(){
        if (totalSuma < cuantiaTotal) {
            console.log(`Te quedan por asignar ${cuantiaTotal - totalSuma}`);
            submit.disabled = true;
        } else if (totalSuma > cuantiaTotal) {
            console.log(`Te has pasado, sobran ${totalSuma - cuantiaTotal}`);
            submit.disabled = true;
        } else if(totalSuma === cuantiaTotal){
            console.log(`Correcte (suma)${totalSuma} = (cuantiaTotal)${cuantiaTotal}`);
            submit.disabled = false;
        }
    }
    
}

const form = document.getElementById('addGastos');
const inputs = Array.from(form.getElementsByClassName('pago'));
const submit = document.getElementById('boton-aceptar-gastos');
const cuantiaTotal = document.getElementsByClassName('cuantia')[0].value;

const ValidacionCuantiaAvanzado = new ValidacionCuantiaAvanzado(cuantiaTotal);

inputs.forEach(input => {
    input.addEventListener('keyup', e => {
        totalSuma = 0;
        ValidacionCuantiaAvanzado.calcTotalSuma(inputs);
        logicaRetroaccionUsuario();
    });
});


