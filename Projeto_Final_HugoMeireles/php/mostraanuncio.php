<?php
    require_once("standvirtual.php");
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="header1.css" />
    <link rel="stylesheet" type="text/css" href="mostraanuncio.css" />
    <title>Anuncio</title>
</head>
<body>
    <header>
        <img src="../imagens/logotipo.png" height="40px;" width="175px;"><br>
        <ul>
            <li><a href="perfil.php">Perfil</a></li>
            <li><a href="login.php">Anúncios activos</a></li>
            <li><a href="logout.php">Sair</a></li>
        </ul>
    </header>
    <div class="informacao">
        <?php
            $titulo=$_GET["titulo"];
            $comando="SELECT * FROM automoveis WHERE titulo='$titulo'";
            $resultado=mysqli_query($bd,$comando);
            if(!$resultado){
                echo "Ocorreu o erro".mysqli_errno($bd)."-".mysqli_error($bd).".</p>";
                exit();
            }
            $linha=$resultado->fetch_object();
            echo "<h1>".$linha->titulo."</h1>";
            echo"<p><strong>Marca:</strong>".$linha->marca."</p>";
            echo"<p><strong>Modelo:</strong>".$linha->modelo."</p>";
            echo"<p><strong>Registo:</strong>".$linha->mes."/".$linha->ano."</p>";
            echo"<p><strong>Cilindrada:</strong>".$linha->cilindrada."(".$linha->potencia.")</p>";
            echo"<p><strong>NºKms:</strong>".$linha->kms."</p>";
            echo"<p><strong>cor:</strong>".$linha->cor."</p>";
            echo"<p><strong>Nº de portas:</strong>".$linha->n_portas."</p>";
            echo"<p><strong>descricao:</strong>".$linha->descricao."</p>";
            echo"<p><strong>Caracteristicas:</strong>";
            echo "<p>";
            echo"<ul>";
            if($linha->jantes_liga_leve === "S"){
                echo "<li>Jantes de liga leve</li>";
            }
            if($linha->direcao_assistida === "S"){
                echo "<li>Direcao assistida</li>";
            }
            if($linha->fecho_central === "S"){
                echo "<li>Fecho central.</li>";
            }
            if($linha->eps === "S"){
                echo "<li>Eps</li>";
            }
            if($linha->ar_condicionado === "S"){
                echo "<li>Ar condicionado</li>";
            }
            if($linha->vidros_eletricos === "S"){
                echo "<liVidros eletricos</li>";
            }
            if($linha->computador_bordo === "S"){
                echo "<li>Computador de bordo</li>";
            }
            if($linha->farois_nevoeiro === "S"){
                echo "<li>Farois de nevoeiro</li>";
            }
            if($linha->livro_revisoes === "S"){
                echo "<li>Livro de revisoes</li>";
            }
            echo "</ul>";
            echo"</p>";
            echo"<p><strong>Preço:</strong>".$linha->preco."€</p>";
            echo "<div class='imagens'>";
            echo"<label>Foto:</label>";
            echo"<img src='../fotos/".$linha->foto1."'></p>";
            echo"<img src='../fotos/".$linha->foto2."'></p>";
            echo"<img src='../fotos/".$linha->foto3."'></p>";
            echo"<img src='../fotos/".$linha->foto4."'></p>";
            echo"<img src='../fotos/".$linha->foto5."'></p>";
            $resultado->free_result();
            $bd->close(); 
        ?>
    </div>
    <p><a href="index.php">Voltar a pagina principal</a></p>
</body>
</html>