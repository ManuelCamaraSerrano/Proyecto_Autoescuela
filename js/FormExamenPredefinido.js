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
                    insertarFila(respuesta[i]['id'],respuesta[i]['descripcion'],respuesta[i]['npreguntas'],respuesta[i]['duracion']);
                }
            }
        }
        ajax.open("POST","../formularios/paginacionExamen.php");
        ajax.send(formData);

        crearPaginacion();
    
    function insertarFila(id,descripcion,npreguntas,duracion){
        // Creamos el tr 
        var tr=document.createElement("tr");
        tr.className="Exa"+id;
        // Creamos los td
        var td1=document.createElement("td");
        var td2=document.createElement("td");
        var td4=document.createElement("td");
        var td6 = document.createElement("td");
        td1.innerHTML=id;
        td2.innerHTML=descripcion;
        td4.innerHTML=npreguntas;
        td6.innerHTML=duracion;       

        // Añadimos los td al tr y por ultimo el tr al tbody de la tabla
        tbody.appendChild(tr);
        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td4);
        tr.appendChild(td6);
    }

    
    function crearPaginacion(){
        var botonIni = document.createElement('button');
        botonIni.innerText="<<";
        paginacion.appendChild(botonIni);
        for (i=0; i<4; i++){
            var boton = document.createElement('button');
            if(i==0){
                boton.className="activo";
            }
            boton.innerText=(i+1);
            // Controlamos el onclick del boton para que cuando pulse mande un ajax con la página que queremos que nos devuelva php
            boton.onclick = function(){
                var texto=encodeURI("pagina="+this.innerText);
                let boton = document.querySelectorAll("button");
                        for(let i=0; i<boton.length; i++){
                            boton[i].className="desactivo";
                        }
                this.className="activo";
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
                                insertarFila(respuesta[i]['id'],respuesta[i]['descripcion'],respuesta[i]['npreguntas'],respuesta[i]['duracion']);
                            }
                        
                    }
                }          
                ajax.open("POST","../Formularios/paginacionExamen.php?clase");
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