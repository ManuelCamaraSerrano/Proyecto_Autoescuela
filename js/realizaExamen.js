window.addEventListener("load",function(){
    const contenedor = document.getElementById("contenedorExamen");
    const paginacion = document.getElementById("paginacion"); // Contenedor donde se encuentran los botones de paginación
    var arrayOpcionesElegidas= [];

    // Cuando se carga la página mandamos una petición ajax para coger las preguntas
    var formData = new FormData();        
        const ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function(){
            if(ajax.readyState==4 && ajax.status==200)
            {
                var respuesta = ajax.responseText;
                respuesta=JSON.parse(respuesta);
                // Barajamos el array que recibimos
                respuestaBarajada = barajarArray(respuesta);
                for(let i=0;i<respuesta.length;i++)
                {
                    // Por cada pregunta la pintamos
                    pintaPreguntas(i+1,respuestaBarajada[i][1]["enunciado"],respuestaBarajada[i][1]["foto"],respuestaBarajada[i][2][0]["id"],respuestaBarajada[i][2][0]["enunciado"],respuestaBarajada[i][2][1]["id"],respuestaBarajada[i][2][1]["enunciado"],respuestaBarajada[i][2][2]["id"],respuestaBarajada[i][2][2]["enunciado"],respuestaBarajada[i][2][3]["id"],respuestaBarajada[i][2][3]["enunciado"]);
                }
                // Creamos la paginación
                crearPaginacion(parseInt(respuestaBarajada[0][0]["npreguntas"]));
            }
        }
        ajax.open("POST","../formularios/getExamenAleatorio.php");
        ajax.send(formData);


        function pintaPreguntas(npregunta,enunciado,foto,r1,enun1,r2,enun2,r3,enun3,r4,enun4){
            // Creamos el section donde meteremos todo el contenido
            var section = document.createElement("section");
            section.id="pregunta_"+npregunta;
            // Al primero le aplicamos la clase activado para que se vea y a los demas desactivado
            if(npregunta==1){
                section.className="activado";
            }
            else{
                section.className="desactivo";
            }

            // H1 para la pregunta que es
            var h1 = document.createElement("h1");
            h1.innerText = "Pregunta "+npregunta;
            // Creamos la imagen
            var img = document.createElement("img");
            img.src=foto;

            // H2 para la pregunta
            var h2 = document.createElement("h2");
            h2.innerText=enunciado;

            // Creamos los radios con sus labels
            var div1 = document.createElement("div");
            var radio1 = document.createElement("input");
            radio1.id="op"+npregunta;
            radio1.type="radio";
            radio1.name="opcion"+npregunta;
            radio1.className="op"+r1;
            var label1 = document.createElement("label");
            label1.innerText=enun1;
            radio1.onclick= function(){
                var pulsado = this.value; // Esta variable guarda si el boton ha sido pulsado o no
                // Si ha sido pulsado hacemos lo siguiente
                if(pulsado=="on"){
                    // Añadimos al array la opcion elegida
                    arrayOpcionesElegidas[parseInt(this.parentNode.parentNode.id.slice(9))-1]=this.className.slice(2);
                    // Le añadimos al boton de la pregunta que se ha contestado la clase activo
                    var id="#boton"+parseInt(this.parentNode.parentNode.id.slice(9));
                    let boton = document.querySelectorAll(id);
                    boton[0].className="activo";
                }
            }

            var div2 = document.createElement("div");
            var radio2 = document.createElement("input");
            radio2.id="op"+npregunta;
            radio2.type="radio";
            radio2.name="opcion"+npregunta;
            radio2.className="op"+r2;
            var label2 = document.createElement("label");
            label2.innerText=enun2;
            radio2.onclick= function(){
                var pulsado = this.value; // Esta variable guarda si el boton ha sido pulsado o no
                // Si ha sido pulsado hacemos lo siguiente
                if(pulsado=="on"){
                    // Añadimos al array la opcion elegida
                    arrayOpcionesElegidas[parseInt(this.parentNode.parentNode.id.slice(9))-1]=this.className.slice(2);
                    // Le añadimos al boton de la pregunta que se ha contestado la clase activo
                    var id="#boton"+parseInt(this.parentNode.parentNode.id.slice(9));
                    let boton = document.querySelectorAll(id);
                    boton[0].className="activo";
                }

            }

            var div3 = document.createElement("div");
            var radio3 = document.createElement("input");
            radio3.id="op"+npregunta;
            radio3.type="radio";
            radio3.name="opcion"+npregunta;
            radio3.className="op"+r3;
            var label3 = document.createElement("label");
            label3.innerText=enun3;
            radio3.onclick= function(){
                var pulsado = this.value; // Esta variable guarda si el boton ha sido pulsado o no
                // Si ha sido pulsado hacemos lo siguiente
                if(pulsado=="on"){
                    // Añadimos al array la opcion elegida
                    arrayOpcionesElegidas[parseInt(this.parentNode.parentNode.id.slice(9))-1]=this.className.slice(2);
                    // Le añadimos al boton de la pregunta que se ha contestado la clase activo
                    var id="#boton"+parseInt(this.parentNode.parentNode.id.slice(9));
                    let boton = document.querySelectorAll(id);
                    boton[0].className="activo";
                }

            }

            var div4 = document.createElement("div");
            var radio4 = document.createElement("input");
            radio4.id="op"+npregunta;
            radio4.type="radio";
            radio4.name="opcion"+npregunta;
            radio4.className="op"+r4;
            var label4 = document.createElement("label");
            label4.innerText=enun4;
            radio4.onclick= function(){
                var pulsado = this.value; // Esta variable guarda si el boton ha sido pulsado o no
                // Si ha sido pulsado hacemos lo siguiente
                if(pulsado=="on"){
                    // Añadimos al array la opcion elegida
                    arrayOpcionesElegidas[parseInt(this.parentNode.parentNode.id.slice(9))-1]=this.className.slice(2);
                    // Le añadimos al boton de la pregunta que se ha contestado la clase activo
                    var id="#boton"+parseInt(this.parentNode.parentNode.id.slice(9));
                    let boton = document.querySelectorAll(id);
                    boton[0].className="activo";
                }

            }

            // Creamos el boton anterior y le controlamos el onclick
            var anterior = document.createElement("button");
            anterior.innerText="Anterior";
            anterior.id="pregunta_"+npregunta;
            anterior.onclick = function(){
                // Ponemos todas las preguntas con la clase desactivo
                let section = document.querySelectorAll("section");
                    for(let i=0; i<section.length; i++){
                        section[i].className="desactivo";
                    }
                    
                // Cogemos el numero de la pregunta y le restamos 1
                var numeroPregun = this.id.slice(9);
                numeroPregun = numeroPregun-1;
                // Si el numero de preguntas es = 0 activamos la primera pregunta
                if(numeroPregun==0)
                {
                    section[0].className="activo";
                }
                else{
                    // Sino activamos la pregunta anterior
                    section[numeroPregun-1].className="activo";
                }

            }

            // Creamos el boton siguiente y le controlamos el onclick
            var siguiente = document.createElement("button");
            siguiente.innerText="Siguiente";
            siguiente.id="pregunta_"+npregunta;
            siguiente.onclick = function(){
                // Ponemos todas las preguntas con la clase desactivo
                let section = document.querySelectorAll("section");
                    for(let i=0; i<section.length; i++){
                        section[i].className="desactivo";
                    }
                    
                // Cogemos el numero de la pregunta y le sumamos 1
                var numeroPregun = this.id.slice(9);
                numeroPregun = parseInt(numeroPregun)+1;
                // Si el numero de preguntas es > que la preguntas que existen activamos la ultima pregunta
                if(section.length<numeroPregun)
                {
                    section[numeroPregun-2].className="activo";
                }
                else{
                    // Sino activamos la pregunta siguiente
                    section[numeroPregun-1].className="activo";
                }

            }

            // Creamos el boton finalizar y le controlamos el onclick
            var finalizar = document.createElement("button");
            finalizar.innerText="Finalizar";
            finalizar.id="pregunta_"+npregunta;
            finalizar.onclick = function(){
                // Convertimos en JSON los dos array que le pasaremos a PHP
                respuestaBarajada = JSON.stringify(respuestaBarajada);
                arrayOpcionesElegidas = JSON.stringify(arrayOpcionesElegidas);
                //Mandamos el ajax con las respuestas seleccionadas
                var texto=encodeURI("exBarajado="+respuestaBarajada+" & respuestas="+arrayOpcionesElegidas);
                const ajax=new XMLHttpRequest();
                    ajax.onreadystatechange=function(ev){
                        ev.preventDefault();
                        if(ajax.readyState==4 && ajax.status==200){
                            var respuesta=ajax.responseText;
                            
                        }
                    }          
                    ajax.open("POST","../Formularios/getExamenAleatorio.php");
                    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    ajax.send(texto);
            }

            // Creamos el boton finalizar y le controlamos el onclick
            var dudosa = document.createElement("button");
            dudosa.innerText="Dudosa";
            dudosa.id="pregunta_"+npregunta;
            dudosa.onclick = function(){
                // Le añadimos al boton de la pregunta que se ha contestado la clase dudosa
                var id="#boton"+parseInt(this.parentNode.id.slice(9));
                let boton = document.querySelectorAll(id);
                boton[0].className="dudosa";
            }

            // Aádimos todo al contenedor
            contenedor.appendChild(section);
            section.appendChild(h1);
            section.appendChild(img);
            section.appendChild(h2);
            div1.appendChild(radio1);
            div1.appendChild(label1);
            div2.appendChild(radio2);
            div2.appendChild(label2);
            div3.appendChild(radio3);
            div3.appendChild(label3);
            div4.appendChild(radio4);
            div4.appendChild(label4);
            section.appendChild(div1);
            section.appendChild(div2);
            section.appendChild(div3);
            section.appendChild(div4);
            section.appendChild(anterior);
            section.appendChild(siguiente);
            section.appendChild(finalizar);
            section.appendChild(dudosa);

        }

})