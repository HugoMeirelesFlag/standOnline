<?php
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;

 require '../PHPMailer-master/src/Exception.php';
 require '../PHPMailer-master/src/PHPMailer.php';
 require '../PHPMailer-master/src/SMTP.php';

if (isset($_POST['btsubmit'])) {
    require_once("standvirtual.php");
    $nome_utilizador=$_POST['nome_utilizador'];
    $email=$_POST['email'];
    $morada_utilizador=$_POST['morada_utilizador'];
    $localidade_utilizador=$_POST['localidade_utilizador'];
    $cp_utilizador=$_POST['cp_utilizador'];
    $cp_utilizador_loc=$_POST['cp_utilizador_loc'];
    $telefone=$_POST['telefone'];
    $senha=$_POST['senha'];
    $rsenha=$_POST['rsenha'];
    $data_registo = date('Y-m-d H:i:s');
    $erros="";

   

    $campos_obrigatorios=['nome_utilizador','morada_utilizador','localidade_utilizador','cp_utilizador','cp_utilizador_loc','email','senha','rsenha'];
    for ($posicao=0;$posicao<count($campos_obrigatorios);$posicao++) {
        $campo=$campos_obrigatorios[$posicao];
        if ($_POST[$campo]==="") {
            if($erros===""){
                $erros="<p>Os campos assinalados são de preenchimento obrigatório!</p>";
            }
            $erros.="<p>".$campo."</p>";
        }
    }

    if (strlen($nome_utilizador)<3) {
        $erros.="<p>O campo 'Nome' tem de ter, no mínimo, 3 caracteres!</p>";
    } else {
        if (!preg_match("/^[a-zA-Z'\- ]{3,80}$/", $nome_utilizador)) {
            $erros.="<p>O campo 'Nome' só pode ter letras, apóstrofos e hifens!</p>";
        }
    }
    
    if (strlen($morada_utilizador)>80) {
        $erros.="<p>O campo 'Morada' só pode ter 80 caracteres!</p>";
    }
    if (strlen($localidade_utilizador)>40) {
        $erros.="<p>O campo 'Localidade' só pode ter 40 caracteres!</p>";
    }

    if ($cp_utilizador==="" || strlen($cp_utilizador)!==8) {
        $erros.="<p>A primeira parte do Código Postal só pode ter 8 algarismos</p>";
    } else {
        if (!preg_match('/[0-9]{4}-[0-9]{3}/', $cp_utilizador)) {
            $erros.="<p>A primeira parte do Código Postal só pode ter formato 0000-000!</p>";
        } else {
            $cp=$cp_utilizador." ".$cp_utilizador_loc;
        }
    }

    if ($telefone!=="" && (!ctype_digit($telefone) || strlen($telefone)!==9)) {
        $erros.="<p>O telefone só pode conter algarismos (9 algarimos)!</p>";
    }

    if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $erros.="<p>O formato do email introduzido está incorrecto!</p>";
    } else {
        $comando="SELECT * FROM utilizadores WHERE email='$email'";
        $resultado=$bd->query($comando);
        if (!$resultado) {
            echo "<p>Ocorreu o erro ".$bd>errno()." - ".$bd->error()."</p>";
            exit();
        }
        if ($resultado->num_rows!==0) {
            $erros.="<p>Já existe um utilizador com o email fornecido.</p>";
        }
    }

    if ($senha!=="" && strlen($senha)<8) {
        $erros.="<p>A senha só pode conter pelos menos 8 caracteres!</p>";
    }

    if($senha!==$rsenha){
        $erros.="<p>As senhas introduzidas têm de ser iguais</p>";
    }

    if (empty($erros)) {
        $senha_encriptada=password_hash($senha, PASSWORD_DEFAULT);
        $comandoInser="INSERT INTO utilizadores(nome_utilizador,email,morada_utilizador,localidade_utilizador,cp_utilizador,telefone,senha,estado,perfil data_registo) VALUES('$nome_utilizador','$email','$morada_utilizador','$localidade_utilizador','$cp','$telefone','$senha_encriptada','R','U','$data_registo')";
        if (!$resultadoInser=$bd->query($comandoInser)) {
            echo "<p>Ocorreu o erro ".$resultadoInser->errno()." - ".$resultadoInser->error()."</p>";
            exit();
        }
        if ($bd->affected_rows!==1) {
            $erros.="<p>Erro no registo de utilizador!</p>";
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
            $mail->addAddress($email, $nome_utilizador);   
            
            $mail->Subject = 'Standvirtual ativação conta';
            $mail->Body    = '<p><a href=""></a>></p><p>Por favor clique no link para proceder a ativação da conta.</p>';
            $mail->AltBody = '';

            $mail->send();
            echo 'Por favor verifique email para ativar conta';
        } catch (Exception $e) {
            echo 'Erro. email nao enviado: ', $mail->ErrorInfo;
        }
            header("Location: registook.php?msg=Obrigado por se ter registado.Vai receber uma mensagem de email para confirmar registo.");
        }
        
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="header1.css" />
    <title>Registo</title>
</head>
<body>
    <header>
        <img src="../imagens/logotipo.png" height="40px;" width="175px;"><br>
        <ul>
            <li><a href="recuperarsenha.php">Recuperar senha</a></li>
            <li><a href="registo.php">Registo de utilizador</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </header>
    <form id="formregisto" method="post" action="<?=$_SERVER['PHP_SELF']?>" novalidate enctype="multipart/form-data">
        <h2>Registo de utilizador</h2>
        <?php
        if (!empty($erros)) { 
            echo $erros;
        }
        ?>
        <p><label for="nome_utilizador">Nome:</label> <input type="text" id="nome_utilizador" name="nome_utilizador" value="<?=(isset($nome_utilizador)) ? $nome_utilizador : '' ?>"></p>
        <p><label for="email">E-mail:</label> <input type="text" id="email" name="email" value="<?=(isset($email)) ? $email : '' ?>"></p>
        <p><label for="morada_utilizador">Morada:</label> <input type="text" id="morada_utilizador" name="morada_utilizador" maxlength="80" value="<?=(isset($morada_utilizador)) ? $morada_utilizador : '' ?>"></p>
        <p><label for="localidade_utilizador">Localidade:</label><input type="text" id="localidade_utilizador" name="localidade_utilizador" maxlength="40" value="<?=(isset($localidade_utilizador)) ? $localidade_utilizador : '' ?>"></p>
        <p><label for="cp_utilizador">CP:</label> <input type="text" id="cp_utilizador" name="cp_utilizador" size="8" maxlength="8" pattern="[0-9]{4}[\-]?[0-9]{3}" pvalue="<?=(isset($cp_utilizador)) ? $cp_utilizador : '' ?>"> <input type="text" id="cp_utilizador_loc" name="cp_utilizador_loc" maxlength="30" value="<?=(isset($cp_utilizador_loc)) ? $cp_utilizador_loc : '' ?>"></p>
        <p><label for="telefone">Telefone:</label> <input type="text" id="telefone" name="telefone" value="<?=(isset($telefone)) ? $telefone : '' ?>"></p>
        <p><label for="senha">Senha:</label> <input type="password" id="senha" name="senha"></p>
        <p><label for="rsenha">Repetir senha:</label> <input type="password" id="rsenha" name="rsenha"></p>
        <p><input type="submit" id="btsubmit" name="btsubmit" value="Efectuar registo"></p>
    </form>
</body>
</html>