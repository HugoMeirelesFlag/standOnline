<?php
session_start();
if (isset($_POST['btsubmit'])) {
    if($_POST['token']!==$_SESSION['token']){
        header("Location: index.php");
        exit();
    }
    require_once("standvirtual.php");
    $email=$bd->real_escape_string($_POST['email']);
    $senha=$bd->real_escape_string($_POST['senha']);

    $erros="";

    $comando="SELECT * FROM utilizadores WHERE email='$email'";
    $resultado=$bd->query($comando);
    if (!$resultado) {
        echo "<p>Ocorreu o erro ".$bd->errno." - ".$bd->error."</p>";
        exit();
    }

    if($email=="" || $senha==""){
        $erros="<p>Os dois campos são de preenchimento obrigatório.</p>";
    }

    if ($resultado->num_rows<1) {
        $erros="<p>Utilizador inexistente.</p>";
    }

    if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $erros.="<p>Email com formato incorrecto.</p>";
    } 

    if ($resultado->num_rows!==1) {
        $erros="<p>Utilizador inexistente.</p>";
    } else {
        $linha=$resultado->fetch_object();
        if (!password_verify($senha,$linha->senha)) {
            $erros="<p>Password errada.</p>";
        } else {
            $_SESSION["id"]=$linha->codigo_utilizador;
            $_SESSION["nome"]=$linha->nome_utilizador;
            header("Location: perfil.php");
        }
    }
}
$num_aleatorio=rand(1000,10000);
$token=uniqid($num_aleatorio, true);
$token=hash("sha512",uniqid($num_aleatorio, true));
$_SESSION['token']=$token;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="header1.css" />
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        .btn-primary {
            background-color: green;
            border-color: green;
        }
    </style>
</head>
<body>
    <header>
        <img src="../imagens/logotipo.png" height="40px;" width="175px;"><br>
    </header>
    <?php
    if (!empty($erros)) {
        echo $erros;
    }
    ?>
    <form id="formlogin" method="post" action="<?=$_SERVER['PHP_SELF'];?>">
        <div class="form-group">
            <p><label for="email">E-mail:</label> <input type="text" id="email" name="email" class="form-control form-control-sm" aria-describedby="emailHelp"></p>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <p><label for="senha">Senha:</label> <input type="password" id="senha" name="senha"></p>
        <input type="hidden" id="token" name="token" value="<?=$token?>">
        <p><input type="submit" id="btsubmit" name="btsubmit" value="Validar" class="btn btn-primary"></p>
    </form>
    <p><a href="perfil.php">Voltar à página principal</a></p>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>