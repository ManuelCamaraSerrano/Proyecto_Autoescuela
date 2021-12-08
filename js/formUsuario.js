window.addEventListener("load",function(){
    const tabla = document.getElementById("tabla");
    const tbody = document.getElementById("tbody");
    const pag1 = document.getElementById("pag1");
    const pag2 = document.getElementById("pag2");
    const pag3 = document.getElementById("pag3");
    const pag4 = document.getElementById("pag4");
    const pag5 = document.getElementById("pag5");
    const lista = document.getElementById("lista");

    var formData = new FormData();        
        const ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function(){
            if(ajax.readyState==4 && ajax.status==200)
            {
                var respuesta = ajax.responseText;
                respuesta=JSON.parse(respuesta);
                for(let i=0;i<respuesta.length;i++)
                {
                    insertarFila(respuesta[i]['nombre'],respuesta[i]['rol'],respuesta[i]['fechanac'],respuesta[i]['activo']);
                }
            }
        }
        ajax.open("POST","../formularios/paginacion.php");
        ajax.send(formData);
        
    lista.onclick = function(){
        var formData = new FormData();        
        const ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function(){
            if(ajax.readyState==4 && ajax.status==200)
            {
                var respuesta = ajax.responseText;
                respuesta=JSON.parse(respuesta);
                for(let i=0;i<respuesta.length;i++)
                {
                    insertarFila(respuesta[i]['nombre'],respuesta[i]['rol'],respuesta[i]['fechanac'],respuesta[i]['activo']);
                }
            }
        }
        ajax.open("POST","../formularios/paginacion.php");
        ajax.send(formData);
    }
    
    function insertarFila(nombre,rol,fechanac,activado){
        var tr=document.createElement("tr");
        var td1=document.createElement("td");
        var td2=document.createElement("td");
        var td4=document.createElement("td");
        var td5=document.createElement("td");
        var td6 = document.createElement("td");
        td1.innerHTML=nombre;
        td2.innerHTML=rol;
        td4.innerHTML=fechanac;
        td5.innerHTML=activado;

        var borrar=document.createElement("span");
        borrar.className="fa fa-trash fa-2x";
        borrar.onclick=function(){
            var fila = this.parentNode.parentNode;
            fila.parentNode.removeChild(fila);
        }
        var editar=document.createElement("span");
        editar.className="fa fa-edit fa-2x";
        //editar.onclick=editarFila;

        td6.appendChild(borrar);
        td6.appendChild(editar);
        tbody.appendChild(tr);
        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td4);
        tr.appendChild(td5);
        tr.appendChild(td6);
    }

    function editarFila(){
        var fila=this.parentElement.parentElement;
        var contenedor=document.createElement("div");
        var td = this.parentElement;
        fila.contenedor=contenedor;
        contenedor.appendChild(td.children[0]);
        contenedor.appendChild(td.children[0]);
        var tds=fila.children;
        for (i=0;i<tds.length-1;i++){
            var contenido=tds[i].innerText;
            tds[i].setAttribute("valor",contenido);
            var input=document.createElement("input");
            input.type="text";
            input.value=contenido;
            tds[i].removeChild(tds[i].childNodes[0]);
            tds[i].appendChild(input);
        }
        // Esta linea coge el input del dni y lo deshabilita para que no se modifique
        tds[0].children[0].disabled=true;
        var spanC=document.createElement("span");
        var spanG=document.createElement("span");
        spanC.className="fa fa-times fa-2x";
        spanC.onclick=cancelarModificacion;
        spanG.className="fa fa-save fa-2x";
        spanG.onclick=guardarModificacion;
        td.appendChild(spanC);
        td.appendChild(spanG);
    }

    function cancelarModificacion(){
        var fila=this.parentElement.parentElement;
        var td= this.parentElement;
        var tds=fila.children;
        for(let i=0;i<tds.length-1;i++){
            let valor=tds[i].getAttribute("valor");
            tds[i].innerHTML=valor;
        }
        td.innerHTML="";
        td.appendChild(fila.contenedor.children[0]);
        td.appendChild(fila.contenedor.children[0]);
    }

    function guardarModificacion(){
        var fila=this.parentElement.parentElement;
        var td = this.parentElement;
        var tds=fila.children;
        var respuestas=[];
        respuestas.push((tds[0].children[0].value.esDNI())?true:false);
        respuestas.push((tds[1].children[0].value!="")?true:false);
        respuestas.push((parseInt(tds[2].children[0].value)==tds[2].children[0].value)?true:false);

        // Este for recorre los td y si son falsos les pone el borde en rojo
        for(i=0;i<3;i++)
        {
            if(respuestas[i]==false){
                tds[i].children[0].className="error";
            }
        }

        if (respuestas.every(function(valor,indice){return valor})){
            for(let i=0;i<tds.length-1;i++){
                let valor=tds[i].children[0].value;
                tds[i].innerHTML=valor;
            }
            td.innerHTML="";
            td.appendChild(fila.contenedor.children[0]);
            td.appendChild(fila.contenedor.children[0]);
        }
    }

    
})