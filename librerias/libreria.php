<?php
    use PHPMailer\PHPMailer\PHPMailer;
    require "../vendor/autoload.php";

    function enviaCorreo($codigoUsuario){
        $mail = new PHPMailer();
        $mail->IsSMTP();
        // cambiar a 0 para no ver mensajes de error
        $mail->SMTPDebug  = 0;                          
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "tls";                 
        $mail->Host       = "smtp.gmail.com";    
        $mail->Port       = 587;                 
        // introducir usuario de google
        $mail->Username   = "manuelcs160@gmail.com"; 
        // introducir clave
        $mail->Password   = "Yogui2002";       
        $mail->SetFrom('manuelcs160@gmail.com', 'Test');
        // asunto
        $mail->Subject    = utf8_decode("Validación de la cuenta");
        $mail->CharSet    = 'UFT-8';
        // cuerpo
        $mail->MsgHTML("<h1>Bienvenido a Autoescuela Juanchu</h1>
                        <p>Pulse el siguiente enlace para crear su contraseña y poder registrarse en la autoescuela</p> <br>
                        <a href='http://localhost/Proyecto_Autoescuela/Formularios/FormRestablecerContasenia.php?codigoUsu=$codigoUsuario'>Registro de contraseña</a>");
        // destinatario
        $address = "manuelcs160@gmail.com";
        $mail->AddAddress($address, "Test");
        // enviar
        $resul = $mail->Send();
        if(!$resul) {
          echo "Error" . $mail->ErrorInfo;
        } else {
          echo "Enviado";
        }
    }

    function generaContrasenia(){
      $caracteres='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      $longpalabra=8;
      for($pass='', $n=strlen($caracteres)-1; strlen($pass) < $longpalabra ; ) {
        $x = rand(0,$n);
        $pass.= $caracteres[$x];
      }
      return $pass;
    }

    function pintaCabecera(){
      echo "<header>
      <img src='../img/Logo.png' alt=''>
        <nav>
           <ul>
              <li>
                <a href=''>Usuarios</a>
                <ul>
                   <li><a href=''> Alta de Usuario</a></li>
                   <li><a href=''>Alta Masiva</a></li>
                </ul>
              </li>

              <li>
                <a href=''>Temáticas</a>
                <ul>
                   <li><a href=''>Alta Temática</a></li>
                </ul>
              </li>

              <li>
                <a href=''>Preguntas</a>
                <ul>
                   <li><a href=''> Alta Pregunta</a></li>
                   <li><a href=''>Alta Masiva</a></li>
                </ul>
              </li>

              <li>
                <a href=''>Examenes</a>
                <ul>
                   <li><a href=''> Alta Examen</a></li>
                   <li><a href=''>Histórico</a></li>
                </ul>
              </li>
           </ul>
        </nav>
        <div class='social'>
          <ul>
            <li><a href='' lang='es-ES' class='fab fa-twitter'></a></li>
            <li><a href='https://www.youtube.com/channel/UCLy9lmj_0cqffXUzbGHNmYA' target='_blank' class='fab fa-instagram'></a></li>
            <li><a href='https://www.instagram.com/sevillafc/' target='_blank' class='fab fa-facebook'></a></li>
          </ul>
        </div>
        <img src='../img/Joman.jpg' alt='' id='fotoUsu'>
    </header>";
    }

    function pintaPieDePagina(){
      echo "<footer>
      <h1>Encuéntranos</h1>
      <iframe src='https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2508.2937112444056!2d-3.7863070284617444!3d37.78195777362684!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd6dd7079eb2cfb9%3A0xc1baca549e967925!2sAutoescuela%20Juanchu!5e0!3m2!1ses!2ses!4v1638817607165!5m2!1ses!2ses' width='400' height='300' style='border:0;' allowfullscreen='' loading='lazy'></iframe>
      <ul>
        <li><a href=''>Guía de estilo</a></li>
        <li><a href=''>Mapa web del sitio</a></li>
      </ul>
      <ul> 
        <p>Enlaces relacionados:</p>
        <li><a href='https://www.dgt.es/inicio/'>DGT</a></li>
        <li><a href='https://sede.dgt.gob.es/es/permisos-de-conducir/obtencion-renovacion-duplicados-permiso/permiso-conducir/index.shtml'>Solicitud oficial de examen</a></li>
        <li><a href='https://practicatest.com/informacion/permisos-y-licencias/nuevas-normas-dgt-aprobar-examen'>Normativa de examen</a></li>
      </ul>
      <ul> 
        <p>Contacto:</p>
        <li>Teléfono: 657 42 32 21</li>
        <li>email: autojuanchu@gmail.com</li>
      </ul>
      <hr>
    </footer>";
    }

    function pintaPaginacion($nombre){
      echo "<section class='paginacion'>
              <ul id='lista'>
                  <li><a href='paginacion.php?clase=$nombre & pagina=1' id='pag1'>1</a></li>
                  <li><a href='paginacion.php?clase=$nombre & pagina=2' id='pag2'>2</a></li>
                  <li><a href='paginacion.php?clase=$nombre & pagina=3' id='pag3'>3</a></li>
                  <li><a href='paginacion.php?clase=$nombre & pagina=4' id='pag4'>4</a></li>
                  <li><a href='paginacion.php?clase=$nombre & pagina=5' id='pag5'>5</a></li>
              </ul>
          </section>";
    }

    