<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registo Efectuado</title>
</head>
<body>
    <header>
        <img src="../imagens/logotipo.png" height="40px;" width="175px;"><br>
    </header>
    <?php
        if(isset($_GET['msg'])){
            echo $_GET['msg'];
        }
    ?>
    <p><a href="index.php">Voltar a pagina principal</a></p>
</body>
</html>