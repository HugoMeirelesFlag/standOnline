<?php
require_once("standvirtual.php");
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: index.php");
}


        $comando="SELECT * FROM utilizadores WHERE codigo_utilizador=".$_SESSION["id"];
        //executar o comando
        $resultado=mysqli_query($bd,$comando);
        if(!$resultado){
            echo "Ocorreu o erro".mysqli_errno($bd)."-".mysqli_error($bd).".</p>";
            exit();
        }
        $linha=$resultado->fetch_object();
        $nome_utilizador=$linha->nome_utilizador;
        $morada_utilizador=$linha->morada_utilizador ;
        $localidade_utilizador=$linha->localidade_utilizador ;
        $cp_utilizador=substr($linha->cp_utilizador,0,8);
        $cp_utilizador_loc=substr($linha->cp_utilizador,9);
        $telefone=$linha->telefone;
        $email=$linha->email;
if (isset($_POST['btsubmit'])) {
    require_once("standvirtual.php");
    // echo "<pre>".print_r($_FILES, TRUE)."</pre>";
    // echo "<pre>".print_r($_POST, TRUE)."</pre>";
    $nome_utilizador=$_POST['nome_utilizador']==="" ? $linha->nome_utilizador : $_POST['nome_utilizador'] ;
    $morada_utilizador=$_POST['morada_utilizador']==="" ? $linha->morada_utilizador : $_POST['morada_utilizador'] ;
    $localidade_utilizador=$_POST['localidade_utilizador']==="" ?$linha->localidade_utilizador : $_POST['localidade_utilizador'] ;
    $cp_utilizador=$_POST['cp_utilizador']==="" ? substr($linha->cp_utilizador,0,8) : $_POST['cp_utilizador'];
    $cp_utilizador_loc=$_POST['cp_utilizador_loc']==="" ? substr($linha->cp_utilizador,9) : $_POST['cp_utilizador_loc'];
    $telefone=$_POST['telefone']==="" ? $linha->telefone : $_POST['telefone'] ;
    $email=$_POST['email']==="" ? $linha->email : $_POST['email'] ;
    $senha=$_POST['senha'];
    $senhaR=$_POST['senha_rep'];
    $senha_encriptada=password_hash($senha, PASSWORD_DEFAULT);

    $erros="";

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
    if ($cp_utilizador ==="" || !preg_match("/[0-9]{4}-[0-9]{3}/", $cp_utilizador) ) {
        $erros.="<p>A primeira parte do Código Postal formato 0000-000!</p>";
    } else {
        if ($cp_utilizador_loc==="") {
            $erros.="<p>A segunda parte do Código Postal não pode estar vazia!</p>";
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
        $linha=$resultado->fetch_object();
        if($email!==$linha->email){
            if (!$resultado) {
                echo "<p>Ocorreu o erro ".$bd>errno()." - ".$bd->error()."</p>";
                exit();
            }
            if ($resultado->num_rows!==0) {
                $erros.="<p>O email introduzido já está registado!</p>";
            }
        }
    }

    if ($senha!=="") {
        if (strlen($senha)<8) {
            $erros.="<p>A senha só pode conter pelos menos 8 caracteres!</p>";
        }
        
        if($senha!==$senhaR){
            $erros.="<p>As senhas introduzidas têm de ser iguais</p>";
        }
    }
    
    if (empty($erros)) {
        if ($senha==="") {
            $comandoAlt="UPDATE utilizadores SET nome_utilizador='".$nome_utilizador."', morada_utilizador='".$morada_utilizador."', localidade_utilizador='".$localidade_utilizador."', cp_utilizador='".$cp_utilizador."".$cp_utilizador_loc."', telefone='".$telefone."', email='".$email."' WHERE codigo_utilizador=".$_SESSION["id"];
        }else{
            $comandoAlt="UPDATE utilizadores SET nome_utilizador='".$nome_utilizador."', morada_utilizador='".$morada_utilizador."', localidade_utilizador='".$localidade_utilizador."', cp_utilizador='".$cp_utilizador."".$cp_utilizador_loc."', telefone='".$telefone."', email='".$email."', senha='".$senha_encriptada."' WHERE codigo_utilizador=".$_SESSION["id"];
        }
        if (!$resultadoAlt=$bd->query($comandoAlt)) {
            echo "<p>Ocorreu o erro ".$resultadoAlt->errno()." - ".$resultadoAlt->error()."</p>";
            exit();
        }
        if ($bd->affected_rows!==1) {
            $erros.="<p>Erro no registo de utilizador!</p>";
        } else {
            header("Location: perfil.php");
        }
    }
}
if (isset($_POST['btcancel'])){
    header("Location:index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="header1.css" />
    <title>Editar Perfil</title>
</head>
<body>
    <header>
        <img src="../imagens/logotipo.png" height="40px;" width="175px;"><br>
        <ul>
            <li><a href="perfil.php">Perfil</a></li>
            <li><a href="logout.php">Sair</a></li>
        </ul>
    </header>
    <form id="formaltera" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" novalidate>
        <h2>Editar perfil de utilizador</h2>
        <?php
        if (!empty($erros)) { 
            echo $erros;
        }
        ?>
        <p><label for="nome_utilizador">Nome:</label> <input type="text" id="nome_utilizador" name="nome_utilizador" value="<?=(isset($nome_utilizador)) ? $nome_utilizador : '' ?>"></p>
        <p><label for="email">E-mail:</label> <input type="text" id="email" name="email" value="<?=(isset($email)) ? $email : '' ?>"></p>
        <p><label for="morada_utilizador">Morada:</label> <input type="text" id="morada_utilizador" name="morada_utilizador" maxlength="80" value="<?=(isset($morada_utilizador)) ? $morada_utilizador : '' ?>"></p>
        <p><label for="localidade_utilizador">Localidade:</label> <input type="text" id="localidade_utilizador" name="localidade_utilizador" maxlength="40" value="<?=(isset($localidade_utilizador)) ? $localidade_utilizador : '' ?>"></p>
        <p><label for="cp_utilizador">CP:</label> <input type="text" id="cp_utilizador" name="cp_utilizador" size="8" maxlength="8" pattern="[0-9]{4}[\-]?[0-9]{3}" value="<?=(isset($cp_utilizador)) ? $cp_utilizador : '' ?>"><input type="text" id="cp_utilizador_loc" name="cp_utilizador_loc" maxlength="30" value="<?=(isset($cp_utilizador_loc)) ? $cp_utilizador_loc : '' ?>"></p>
        <p><label for="telefone">Telefone:</label> <input type="text" id="telefone" name="telefone" value="<?=(isset($telefone)) ? $telefone : '' ?>"></p>
        <p><label for="senha">Senha:</label> <input type="password" id="senha" name="senha"></p>
        <p><label for="senha_rep">Repetir senha:</label> <input type="password" id="senha_rep" name="senha_rep"></p>
        <p><input type="submit" id="btsubmit" name="btsubmit" value="Alterar registo"></p>
        <p><input type="cancel" id="btcancel" name="btcancel" value="Cancelar"></p>
    </form>
</body>
</html>