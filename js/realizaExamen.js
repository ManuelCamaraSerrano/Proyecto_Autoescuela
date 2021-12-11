window.addEventListener("load",function(){
    const contenedor = document.getElementById("contenedorExamen");
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
                    pintaPreguntas(i+1,respuesta[i][1]["enunciado"],respuesta[i][1]["foto"],respuesta[i][2][0]["id"],respuesta[i][2][0]["enunciado"],respuesta[i][2][1]["id"],respuesta[i][2][1]["enunciado"],respuesta[i][2][2]["id"],respuesta[i][2][2]["enunciado"],respuesta[i][2][3]["id"],respuesta[i][2][3]["enunciado"]);
                }
                crearPaginacion(parseInt(respuesta[0][0]["npreguntas"]));
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

            var h1 = document.createElement("h1");
            h1.innerText = "Pregunta "+npregunta;
            // Creamos la imagen
            var img = document.createElement("img");
            img.src=foto;

            // H1 para el titulo
            var h2 = document.createElement("h2");
            h2.innerText=enunciado;

            // Creamos los radios con sus labels
            var div1 = document.createElement("div");
            var radio1 = document.createElement("input");
            radio1.type="radio";
            radio1.name="opcion";
            radio1.className="op"+r1;
            var label1 = document.createElement("label");
            label1.innerText=enun1;

            var div2 = document.createElement("div");
            var radio2 = document.createElement("input");
            radio2.type="radio";
            radio2.name="opcion";
            radio2.className="op"+r2;
            var label2 = document.createElement("label");
            label2.innerText=enun2;

            var div3 = document.createElement("div");
            var radio3 = document.createElement("input");
            radio3.type="radio";
            radio3.name="opcion";
            radio3.className="op"+r3;
            var label3 = document.createElement("label");
            label3.innerText=enun3;

            var div4 = document.createElement("div");
            var radio4 = document.createElement("input");
            radio4.type="radio";
            radio4.name="opcion";
            radio4.className="op"+r4;
            var label4 = document.createElement("label");
            label4.innerText=enun4;

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
        }


        function crearPaginacion(npreguntas){
            for (i=0; i<npreguntas; i++){
                var boton = document.createElement('button');
                boton.innerText=(i+1);
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
})