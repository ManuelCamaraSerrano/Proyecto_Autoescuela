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

    

    