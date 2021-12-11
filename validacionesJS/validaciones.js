function soloNumeros(e)
{
	var key = window.Event ? e.which : e.keyCode
	return ((key >= 48 && key <= 57) || (key==8))
}

function soloLetras(e){
    key = e.keyCode || e.which;
    teclado= String.fromCharCode(key).toLowerCase();
    letras= " abcdefghijklmnñopqrstuvwxyz";
    especiales = "8-37-38-46";

    teclado_especial = false;

    for(let i in especiales)
    {
        if(key==especiales[i]){
            teclado_especial=true;
            break;
        }
    }

    if(letras.indexOf(teclado)==-1 && !teclado_especial){
        return false;
    }

}

String.prototype.esFecha=function(){
    var respuesta=false;
    var partes=(/^(\d\d)\/(\d\d)\/(\d{4})$/).exec(this.valueOf());
    if (partes && partes.length==4){
        var dia=new Date(partes[3],partes[2]-1,partes[1]);
        if (dia.getDate()==partes[1] &&
            dia.getMonth()==partes[2]-1 &&
            dia.getFullYear()==partes[3]){
                respuesta=true;
            }
     }
     return respuesta;
}