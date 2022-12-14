export class ValidacionCuantiaAvanzado{
    cuantiaTotal;
    totalSuma;
    constructor(cuantiaTotal){
        this.cuantiaTotal = parseInt(cuantiaTotal);
        this.totalSuma = 0;
    }
    calcTotalSuma(inputs){
        inputs.forEach(input =>{
            if(input.value){
              this.totalSuma += parseInt(input.value);  
            }else{
                this.totalSuma += 0;
            }
            
        });
    }

    logicaRetroaccionUsuario(submit){
        if (this.totalSuma < this.cuantiaTotal) {
            console.log(`Te quedan por asignar ${this.cuantiaTotal - this.totalSuma}`);
            submit.disabled = true;
        } else if (this.totalSuma > this.cuantiaTotal) {
            console.log(`Te has pasado, sobran ${this.totalSuma - this.cuantiaTotal}`);
            submit.disabled = true;
        } else if(this.totalSuma === this.cuantiaTotal){
            console.log(`Correcte (suma)${this.totalSuma} = (cuantiaTotal)${this.cuantiaTotal}`);
            submit.disabled = false;
        }
    }
    
}



