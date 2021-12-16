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

function hayContenido(valor){
    var respuesta = false;
    if(valor!="")
    {
        respuesta=true;
    }
    return respuesta;
}

function validagmail(gmail){
    respuesta = /^.+(\@gmail\.)(es|com)$/.test(gmail);
    return respuesta;
}

function barajarArray(array) {
    var tamanioArray = array.length;
    var variableTemp;
    var valorRandom;
  
    // Mientras queden elementos a mezclar
    while (0 !== tamanioArray) {
  
      // Seleccionar un elemento sin mezclar
      valorRandom = Math.floor(Math.random() * tamanioArray);
      tamanioArray -= 1;
  
      // E intercambiarlo con el elemento actual
      variableTemp = array[tamanioArray];
      array[tamanioArray] = array[valorRandom];
      array[valorRandom] = variableTemp;
    }
  
    return array;
  }

  function crearPaginacion(npreguntas){
    for (i=0; i<npreguntas; i++){
        var boton = document.createElement('button');
        
        boton.className="desactivo";

        boton.innerText=(i+1);
        boton.id="boton"+(i+1);
        // Controlamos el onclick del boton para que cuando pulse se active esa pregunta y las demás se oculten
        boton.onclick = function(){
            let section = document.querySelectorAll("section");
            for(let i=0; i<section.length; i++){
                section[i].className="desactivo";
            }
            
            section[parseInt(this.innerText)-1].className="activo";
        }
        paginacion.appendChild(boton);
        }
    }