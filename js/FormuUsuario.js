window.addEventListener("load",function(){
    var spanGmail = document.getElementById("spanGmail");
    var spanNombre = document.getElementById("spanNombre");
    var spanApellidos = document.getElementById("spanApellidos");
    var txtApellidos = document.getElementById("apellidos");
    var txtGmail = document.getElementById("gmail");
    var txtNombre = document.getElementById("nombre");
    var fechanac = document.getElementById("fechanac");
    const boton = document.getElementById("aceptar");
    var foto = document.getElementById("foto");
    var rol = document.getElementById("rol");

    boton.onclick = function(ev){
        ev.preventDefault();
        var errores = [];
        if(txtGmail.value=="")
        {   // Validamos si hay contenido
            spanGmail.innerHTML=(hayContenido(txtGmail.value))? "": "No ha introducido su Gmail";
            errores.push(false);
        }
        else{
            if(!validagmail(txtGmail.value))
            {
                //Validamos si tiene una estructura de gmail
                spanGmail.innerHTML=(validagmail(txtGmail.value))? "": "Gmail incorrecto";
                errores.push(false);
            }
            else{
                spanGmail.innerHTML="";
            }
        }

         // Validamos si hay contenido
         if(!hayContenido(txtNombre.value))
            {
                //Validamos si hay contenido
                spanNombre.innerHTML=(hayContenido(txtNombre.value))? "": "No ha introducido su nombre";
                errores.push(false);
            }
            else{
                spanNombre.innerHTML="";
            }

            if(!hayContenido(txtApellidos.value))
            {
                //Validamos si hay contenido
                spanApellidos.innerHTML=(hayContenido(txtApellidos.value))? "": "No ha introducido sus apellidos";
                errores.push(false);
            }
            else{
                spanApellidos.innerHTML="";
            }

            if(errores.length==0){
                var formData = new FormData();
                formData.append("aceptar","aceptar");
                formData.append("nombre",txtNombre.value);
                formData.append("email",txtGmail.value);
                formData.append("apellidos",txtApellidos.value);
                formData.append("fechanac",fechanac.value);
                formData.append("foto",foto.files[0]);
                formData.append("rol",rol.value);
                const ajax = new XMLHttpRequest();
        
                ajax.onreadystatechange = function(){
                    if(ajax.readyState==4 && ajax.status==200)
                    {
                        var respuesta = ajax.responseText;
                        
                        if(respuesta=="OK"){
                            alert("Usuario Insertado");
                        }
                    }
                }
                ajax.open("POST","../Formularios/respuestaAltaUsuario.php");

                ajax.send(formData);
            }
         
         
       
    }


})