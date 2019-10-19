<?php
    session_start();
    require_once("standvirtual.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require '../PHPMailer-master/src/Exception.php';
    require '../PHPMailer-master/src/PHPMailer.php';
    require '../PHPMailer-master/src/SMTP.php';

    if (isset($_POST['btsubmit'])) {
        $email=$_POST['email'];
        $erros="";

        if(!isset($_SESSION["id"])){
            header("Location: index.php");
        }

        $comando="SELECT * FROM utilizadores WHERE email='$email'";
        $resultado=$bd->query($comando);
        $linha=$resultado->fetch_object();
        if (!$resultado) {
            echo "<p>Ocorreu o erro ".$bd->errno." - ".$bd->error."</p>";
            exit();
        }
        if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            $erros.="<p>Email com formato incorrecto.</p>";
        } 
        if ($resultado->num_rows!==1) {
            $erros="<p>Utilizador inexistente.</p>";
        } else {
            $mail = new PHPMailer(true);         
            try {
                $mail->SMTPDebug = 2;                                 
                $mail->isSMTP();                                      
                $mail->Host = 'smtp.mailtrap.io';  
                $mail->SMTPAuth = true;                               
                $mail->Username = 'd246892be54023';                 
                $mail->Password = '527c0b97c5b0d6';    
                                
                $mail->Port = 25;
                
                $mail->setFrom('from@example.com', 'Mailer');
                $mail->addAddress($email, $linha->nome_utilizador);     
                
                $mail->Subject = 'Recuperação de password';
                $mail->Body    = "A sua palavra passe é".$linha->senha;
                $mail->AltBody = '';

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            }
            header("Location: registook.php?msg=Password enviada para email.");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form id="formlogin" method="post" action="<?=$_SERVER['PHP_SELF'];?>">
        <div class="form-group">
            <p><label for="email">E-mail:</label> <input type="text" id="email" name="email" class="form-control form-control-sm" aria-describedby="emailHelp"></p>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <p><input type="submit" id="btsubmit" name="btsubmit" value="Validar" class="btn btn-primary"></p>
    </form>
</body>
</html>