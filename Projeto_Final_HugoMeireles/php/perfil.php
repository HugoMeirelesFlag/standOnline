<?php
    require_once("standvirtual.php");
    session_start();
    if(!isset($_SESSION["id"])){
        header("Location: index.php");
    }
    $comando="SELECT * FROM utilizadores WHERE codigo_utilizador=".$_SESSION["id"];
    $resultado=mysqli_query($bd,$comando);
    if(!$resultado){
        echo "Ocorreu o erro".mysqli_errno($bd)."-".mysqli_error($bd).".</p>";
        exit();
    }
    $linha=$resultado->fetch_object();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="header1.css" />
    <title>Perfil de Utilizador</title>
</head>
<body>
    <header>
        <img src="../imagens/logotipo.png" height="40px;" width="175px;"><br>
        <ul>
            <li><a href="perfil.php">Perfil</a></li>
            <li><a href="anuncios.php">Anúncios</a></li>
            <li><a href="logout.php">Sair</a></li>
            <?php
                if($linha->perfil !== "U"){
                    echo '<li><a href="acesso_reservado.php">Acesso reservado</a></li>';
                }
            ?>
            
        </ul>
    </header>
    <?php
        echo "<h1>Informação</h1>";
        echo"<strong>Nome:</strong>".$linha->nome_utilizador."</p>";
        echo"<strong>email:</strong>".$linha->email."</p>";
        echo"<p><strong>Morada:</strong>".$linha->morada_utilizador."</p>";
        echo"<strong>localidade:</strong>".$linha->localidade_utilizador."</p>";
        echo"<strong>Codigo Postal:</strong>".$linha->cp_utilizador."</p>";
        echo"<strong>telefone:</strong>".$linha->telefone."</p>";
        echo"<strong>Data de registo:</strong>".$linha->data_registo."</p>";
        $resultado->free_result();
        $bd->close(); 
    ?>
    <p><a href="alterarperfil.php">Editar</a><p>
    <p><a href="anuncios.php">Anuncios</a><p>
    <p><a href="index.php">Página Principal</a><p>
</body>
</html>