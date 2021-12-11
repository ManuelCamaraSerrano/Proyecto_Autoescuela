window.addEventListener("load",function(){
    const tabla = document.getElementById("tabla");
    const tbody = document.getElementById("tbody");
    const paginacion = document.getElementById("paginacion"); // Contenedor donde se encuentran los botones de paginación

    // Cuando se carga la página mandamos una petición ajax para coger los primeros usuarios
    var formData = new FormData();        
        const ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function(){
            if(ajax.readyState==4 && ajax.status==200)
            {
                var respuesta = ajax.responseText;
                respuesta=JSON.parse(respuesta);
                for(let i=0;i<respuesta.length;i++)
                {
                    insertarFila(respuesta[i]['id'],respuesta[i]['descripcion']);
                }
            }
        }
        ajax.open("POST","../formularios/paginacionTematica.php");
        ajax.send(formData);

        crearPaginacion();
    
    function insertarFila(id,descripcion){
        // Creamos el tr 
        var tr=document.createElement("tr");
        tr.className="tem"+id;
        // Creamos los td
        var td1=document.createElement("td");
        td1.innerText= descripcion;
        var td2=document.createElement("td");

        // Creamos el spam borrar
        var borrar=document.createElement("span");
        borrar.className="fa fa-trash fa-2x";

        // Capturamos el onclick
        borrar.onclick=function(){
            var fila = this.parentNode.parentNode;
            id=fila.className.slice(3);
            var texto=encodeURI("borrar="+id);
            // Mandamos el ajax con el id del usuario para que desde php lo borren de la BD
            const ajax=new XMLHttpRequest();
            ajax.onreadystatechange=function(ev){
                ev.preventDefault();
                if(ajax.readyState==4 && ajax.status==200){
                    var respuesta=ajax.responseText;
                    if (respuesta=="OK"){
                        // Si la respuesta es Ok le mostraremos un mensaje de alerta y lo borraremos de la tabla
                        alert("Esta seguro que desea borrar esta Tematica");
                        tbody.removeChild(fila);
                        alert("Tematica Borrada");
                    }
                }
            }          
            ajax.open("POST","../Formularios/paginacionTematica.php?clase");
            ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajax.send(texto);
        }

        // Creamos el span de editar
        var editar=document.createElement("span");
        editar.className="fa fa-edit fa-2x";
        editar.onclick=editarFila;

        // Añadimos los td al tr y por ultimo el tr al tbody de la tabla
        td2.appendChild(borrar);
        td2.appendChild(editar);
        tbody.appendChild(tr);
        tr.appendChild(td1);
        tr.appendChild(td2);
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
        // Borramos los otros iconos y metemos los iconos de cancelar y guardar
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
        // Restablecemos los cambios y volvemos al modo de borrado o modificacion
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
        // Validamos si los campos introducidos son correctos
        respuestas.push((tds[0].children[0].value!="")?true:false);
        

        // Este for recorre los td y si son falsos les pone el borde en rojo
        for(i=0;i<1;i++)
        {
            if(respuestas[i]==false){
                tds[i].children[0].className="error";
            }
        }
        
        id=fila.className.slice(3);

        //Mandamos el ajax con el id del usuario y sus campos para actualizarlos
        var texto=encodeURI("editar="+id+"& descripcion="+tds[0].children[0].value);
        const ajax=new XMLHttpRequest();
            ajax.onreadystatechange=function(ev){
                ev.preventDefault();
                if(ajax.readyState==4 && ajax.status==200){
                    var respuesta=ajax.responseText;
                    if (respuesta=="OK"){
                        // Si la respuesta es Ok editamos los campos y mostramos de nuevo los iconos de borrar y editar
                        if (respuestas.every(function(valor,indice){return valor})){
                            for(let i=0;i<tds.length-1;i++){
                                let valor=tds[i].children[0].value;
                                tds[i].innerHTML=valor;
                            }
                            td.innerHTML="";
                            td.appendChild(fila.contenedor.children[0]);
                            td.appendChild(fila.contenedor.children[0]);
                        }
                        alert("Usuario Editado");
                    }
                }
            }          
            ajax.open("POST","../Formularios/paginacionTematica.php?clase");
            ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajax.send(texto);
        
    }

    function crearPaginacion(){
        var botonIni = document.createElement('button');
        botonIni.innerText="<<";
        paginacion.appendChild(botonIni);
        for (i=0; i<4; i++){
            var boton = document.createElement('button');
            boton.innerText=(i+1);
            // Controlamos el onclick del boton para que cuando pulse mande un ajax con la página que queremos que nos devuelva php
            boton.onclick = function(){
                var texto=encodeURI("pagina="+this.innerText);
                const ajax=new XMLHttpRequest();
                ajax.onreadystatechange=function(ev){
                    ev.preventDefault();
                    if(ajax.readyState==4 && ajax.status==200){
                        var respuesta=ajax.responseText;
                            respuesta=JSON.parse(respuesta);
                            // Vaciamos la tabla
                            tbody.innerHTML="";
                            // Mediante un bucle vamos insertando las nuevas filas
                            for(let i=0;i<respuesta.length;i++)
                            {
                                insertarFila(respuesta[i]['id'],respuesta[i]['descripcion']);
                            }
                        
                    }
                }          
                ajax.open("POST","../Formularios/paginacionTematica.php?clase");
                ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                ajax.send(texto);
            }
            paginacion.appendChild(boton);
            }
            var botonFin = document.createElement('button');
            botonFin.innerText=">>";
            paginacion.appendChild(botonFin);
        }
    

    
})