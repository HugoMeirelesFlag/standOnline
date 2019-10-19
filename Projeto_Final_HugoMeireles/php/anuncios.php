<?php
        require_once("standvirtual.php");
        session_start();
        if(!isset($_SESSION["id"])){
            header("Location: index.php");
        }
        $comando="SELECT * FROM automoveis WHERE estado='A' AND codigo_utilizador=".$_SESSION["id"];
        $resultado=$bd->query($comando);
        if (!$resultado) {
            echo "<p>Ocorreu o erro ".$bd->errno()." - ".$bd->error()."</p>";
            exit();
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="header1.css" />
    <link rel="stylesheet" type="text/css" href="anuncios.css" />
    <title>Anúncios</title>
</head>
<body>
    <header>
        <img src="../imagens/logotipo.png" height="40px;" width="175px;"><br>
        <ul>
            <li><a href="perfil.php">Perfil</a></li>
            <li><a href="anuncios.php">Anúncios</a></li>
            <li><a href="logout.php">Sair</a></li>
        </ul>
    </header>
    <div id="anuncios">
        <h1>Anúncios activos</h1>
        <p><a href="inseriranuncio.php">Inserir anúncios<p></a>
        <?php
            if (!$resultado) {
                echo "<p>Ocorreu o erro ".$bd->errno()." - ".$bd->error()."</p>";
                exit();
            }
            if ($resultado->num_rows===0) {
                echo "<p>Nenhum resultado encontrado.</p>\n";
            } else {
                echo "<table>";
                echo"<thead><tr><th>Foto</th><th>titulo de anúncio</th><th>Mês/Ano</th><th>Preço</th></tr></thead>";
                echo "<tbody>";
                while ($linha=$resultado->fetch_object()) {
                    echo "<tr>";
                    echo '<td><a href="mostraanuncio.php?titulo='.$linha->titulo.'">';
                    echo "<img src='../fotos/".$linha->foto1."'>";
                    echo '</a></td>';
                    echo '<td><a href="mostraanuncio.php?titulo='.$linha->titulo.'">'.$linha->titulo.'</a></td>';
                    echo "<td>".$linha->mes."/".$linha->ano."</td>";
                    echo "<td>".$linha->preco."€</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            $resultado->free_result();
            }
            $bd->close();
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="marca_modelo_ajax.js"></script>
</body>
</html>