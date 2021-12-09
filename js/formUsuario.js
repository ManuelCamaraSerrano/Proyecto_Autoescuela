window.addEventListener("load",function(){
    const tabla = document.getElementById("tabla");
    const tbody = document.getElementById("tbody");
    const paginacion = document.getElementById("paginacion");

    var formData = new FormData();        
        const ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function(){
            if(ajax.readyState==4 && ajax.status==200)
            {
                var respuesta = ajax.responseText;
                respuesta=JSON.parse(respuesta);
                for(let i=0;i<respuesta.length;i++)
                {
                    insertarFila(respuesta[i]['id'],respuesta[i]['nombre'],respuesta[i]['rol'],respuesta[i]['fechanac'],respuesta[i]['activo']);
                }
            }
        }
        ajax.open("POST","../formularios/paginacion.php");
        ajax.send(formData);

        crearPaginacion();
        
    function paginator(pagina){
        var texto=encodeURI("pagina="+pagina);
            // Mandamos el ajax con el id del usuario para que desde php lo borren de la BD
            const ajax=new XMLHttpRequest();
            ajax.onreadystatechange=function(ev){
                ev.preventDefault();
                if(ajax.readyState==4 && ajax.status==200){
                    var respuesta=ajax.responseText;
                    if (respuesta=="OK"){
                        alert("Nuevas filas");
                    }
                }
            }          
            ajax.open("POST","../Formularios/paginacion.php?clase");
            ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajax.send(texto);
    }
    
    function insertarFila(id,nombre,rol,fechanac,activado){
        var tr=document.createElement("tr");
        tr.className="Usu"+id;
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
                        alert("Esta seguro que desea borrar este Usuario");
                        var fila = this.parentNode.parentNode;
                        fila.parentNode.removeChild(fila);
                        alert("Usuario Borrado");
                    }
                }
            }          
            ajax.open("POST","../Formularios/paginacion.php?clase");
            ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajax.send(texto);
        }

        var editar=document.createElement("span");
        editar.className="fa fa-edit fa-2x";
        editar.onclick=editarFila;

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
        respuestas.push((tds[0].children[0].value!="")?true:false);
        respuestas.push((tds[1].children[0].value!="")?true:false);
        respuestas.push((tds[2].children[0].value!="")?true:false);
        respuestas.push((parseInt(tds[3].children[0].value)==tds[3].children[0].value)?true:false);

        // Este for recorre los td y si son falsos les pone el borde en rojo
        for(i=0;i<4;i++)
        {
            if(respuestas[i]==false){
                tds[i].children[0].className="error";
            }
        }
        
        id=fila.className.slice(3);

        //Mandamos el ajax con el id del usuario y sus campos para actualizarlos
        var texto=encodeURI("editar="+id+"& nombre="+tds[0].children[0].value+"& rol="+tds[1].children[0].value+"& fechanac="+tds[2].children[0].value+"& activo="+tds[3].children[0].value);
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
            ajax.open("POST","../Formularios/paginacion.php?clase");
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
            boton.onclick = function(){
                var texto=encodeURI("pagina="+this.innerText);
                // Mandamos el ajax con el id del usuario para que desde php lo borren de la BD
                const ajax=new XMLHttpRequest();
                ajax.onreadystatechange=function(ev){
                    ev.preventDefault();
                    if(ajax.readyState==4 && ajax.status==200){
                        var respuesta=ajax.responseText;
                            respuesta=JSON.parse(respuesta);
                            tbody.innerHTML="";
                            for(let i=0;i<respuesta.length;i++)
                            {
                                insertarFila(respuesta[i]['id'],respuesta[i]['nombre'],respuesta[i]['rol'],respuesta[i]['fechanac'],respuesta[i]['activo']);
                            }
                        
                    }
                }          
                ajax.open("POST","../Formularios/paginacion.php?clase");
                ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                ajax.send(texto);
            }
            paginacion.appendChild(boton);
            }
        }
        var botonFin = document.createElement('button');
        botonFin.innerText=">>";
        paginacion.appendChild(botonFin);


    

    
})