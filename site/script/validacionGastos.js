export class ValidacionCuantiaAvanzado{
    cuantiaTotal;
    totalSuma;
    constructor(cuantiaTotal){
        this.cuantiaTotal = Number(Number.parseFloat(cuantiaTotal).toFixed(2));
        this.totalSuma = 0;
    }
    calcTotalSuma(inputs){
        inputs.forEach(input =>{
            if(input.value){
              this.totalSuma += Number(Number.parseFloat(input.value).toFixed(2));  
            }else{
                this.totalSuma += 0;
            }
            
        });
    }

    logicaRetroaccionUsuario(submit){
        if (this.totalSuma < this.cuantiaTotal) {
            console.log(submit);
            submit.disabled = true;
            return `Te quedan por asignar ${Number(Number.parseFloat(this.cuantiaTotal - this.totalSuma).toFixed(2))}`;
            
        } else if (this.totalSuma > this.cuantiaTotal) {
            submit.disabled = true;
            return `Te has pasado, sobran ${Number(Number.parseFloat(this.totalSuma - this.cuantiaTotal).toFixed(2))}`;
            
        } else if(this.totalSuma === this.cuantiaTotal){
            submit.disabled = false;
            console.log(submit);
            return true;
            

        }
    }
    
}