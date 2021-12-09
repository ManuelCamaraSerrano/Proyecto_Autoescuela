window.addEventListener("load",function(){
   const contenedorPreguntas = document.getElementById("preguntas");
   const tbody = document.getElementById("tbody");
   const tbody2 = document.getElementById("tbody2");
   const tabla = document.getElementById("tabla");
   const tabla2 = document.getElementById("tabla2");
   const btnAceptar = document.getElementById("aceptar");
   const combo = document.getElementById("tematica");
   var duracion=document.getElementById("duracion");
   var descripcion=document.getElementById("descripcion");
   var npreguntas=document.getElementById("npreguntas");
   var pinsert = document.getElementById("pinsert");
   const filtro=document.getElementById("filtro");


   filtro.onkeyup=function(){
       const tr=tbody.getElementsByTagName("tr");
       for(let i=0;i<tr.length;i++){
           tr[i].classList.remove("marcado");
           if(tr[i].innerHTML.indexOf(filtro.value)<0)
               tr[i].classList.add("oculto")
           else
               tr[i].classList.remove("oculto")
        }
   }

    btnAceptar.onclick = function(ev){
        ev.preventDefault();
        // Cuando pulse el boton de aceptar le enviaremos el array de las preguntas elegidas
        var preguntasElegidas=[];
        var pregunta;
        for(let a=0; a<tbody2.children.length; a++){
            pregunta= tbody2.children[a].id.slice(5);
            preguntasElegidas.push(pregunta);
        }
            var jsonpreguntas = JSON.stringify(preguntasElegidas);

            var texto=encodeURI("aceptar=aceptar & preguntas=" + jsonpreguntas+" & descripcion="+descripcion.value+" & duracion="+duracion.value+" & npreguntas="+npreguntas.value);
            const ajax=new XMLHttpRequest();
            ajax.onreadystatechange=function(){
                if(ajax.readyState==4 && ajax.status==200){
                    var respuesta=ajax.responseText;
                    if (respuesta=="OK"){
                       alert ("Ok");
                    }
                }
            }          
            ajax.open("POST","../Formularios/FormAltaExamen.php");
            ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajax.send(texto);

            // Una vez enviado los datos restablecemos el formulario
            duracion.value="";
            descripcion.value="";
            npreguntas.value="";
            combo.value="";
            // Vaciamos las dos tablas
            while (tbody2.firstChild){
                tbody2.removeChild(tbody2.firstChild);
              };

            while (tbody.firstChild){
                tbody.removeChild(tbody.firstChild);
            };

              //Rellenamos la primera tabla

            cargaTabla();
        
    }
    
    cargaTabla();

    function cargaTabla()
    {
        // Recogemos de php el array con las preguntas 
    var formData = new FormData();        
    const ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function(){
        if(ajax.readyState==4 && ajax.status==200)
        {
            var respuesta = ajax.responseText;
            respuesta=JSON.parse(respuesta);
            for(let i=0;i<respuesta.length;i++)
            {
                crearContenido(respuesta[i]);
            }
        }
    }
    ajax.open("POST","../formularios/respuestaJSONpreguntas.php");
    ajax.send(formData);
    }
    
    

    function crearContenido(respuesta)
    {
        // Creamos por cada pregunta una fila con enunciado y tematica
        const tr=document.createElement("tr");
        tr.setAttribute(respuesta.nombreTematica,respuesta.nombreTematica);
        tr.className="activo";
        tr.id="fila_"+respuesta.id;
        tr.draggable=true;
        tr.height="100";
        tr.ondragstart = function(ev){          
            ev.dataTransfer.setData("text", ev.target.id);
        }
        var td1=document.createElement("td");
        td1.innerHTML=respuesta.enunciado;
        td1.ondragover=function(ev)
        {
            ev.preventDefault();
        }

        td1.ondrop=function(ev)
        {
            if(td1.parentNode.parentNode.parentNode.id=="tabla"){
                ev.preventDefault();
                ev.stopPropagation();
                var data = ev.dataTransfer.getData("text");
                const fila=ev.target.parentNode;
                fila.parentNode.insertBefore(document.getElementById(data),fila);
                pinsert.value=tbody2.children.length;
            }
            if(tbody2.children.length<parseInt(npreguntas.value))
                {
                    ev.preventDefault();
                    ev.stopPropagation();
                    var data = ev.dataTransfer.getData("text");
                    const fila=ev.target.parentNode;
                    fila.parentNode.insertBefore(document.getElementById(data),fila);
                    pinsert.value=tbody2.children.length;
                }
            
        }
        
        var td2=document.createElement("td");
        td2.innerHTML=respuesta.nombreTematica;

        td2.ondragover=function(ev)
        {
            ev.preventDefault();
        }

        td2.ondrop=function(ev)
        {
            if(td2.parentNode.parentNode.parentNode.id=="tabla"){
                ev.preventDefault();
                ev.stopPropagation();
                var data = ev.dataTransfer.getData("text");
                const fila=ev.target.parentNode;
                fila.parentNode.insertBefore(document.getElementById(data),fila);
                pinsert.value=tbody2.children.length;
            }
            if(tbody2.children.length<parseInt(npreguntas.value))
                {
                    ev.preventDefault();
                    ev.stopPropagation();
                    var data = ev.dataTransfer.getData("text");
                    const fila=ev.target.parentNode;
                    fila.parentNode.insertBefore(document.getElementById(data),fila);
                    pinsert.value=tbody2.children.length;
                }
            
        }

        tr.appendChild(td1);
        tr.appendChild(td2);
        tbody.appendChild(tr);
    }

    combo.onchange = function(){
        // Cuando el combobox cambie de valor cambiamos todas las filas a la clase desactivado
        for(let i=0; i<tbody.children.length;i++){
            tbody.children[i].className="desactivado";
        }
        // Una vez elegida la opción ponemos la clase de la eleccion en activo
        var opcionElegida = this.options[combo.selectedIndex].innerHTML;
        // Si esta vacio la respuesta elegida ponemos todas en activo pq quiere decir que no ha elegido ninguna tematica
        if(opcionElegida==""){
            let tr = document.querySelectorAll("tr");
            for(let i=0; i<tr.length; i++){
                tr[i].className="activo";
            }
        }
        else{
            let tr = document.querySelectorAll("["+opcionElegida+"]");
            for(let i=0; i<tr.length; i++){
                tr[i].className="activo";
            }
        }
    }

    tabla2.addEventListener("drop",function(ev) 
    {
        if(npreguntas.value!=""){

            if(tbody2.children.length==0)
            {
                pinsert.value=1;
            }
            ev.preventDefault();
            var data = ev.dataTransfer.getData("text");        
            ev.target.tBodies[0].appendChild(document.getElementById(data));
        }
    });

    tabla2.addEventListener("dragover", function(ev)
    {
        ev.preventDefault();
    });

    

    
   

      



})