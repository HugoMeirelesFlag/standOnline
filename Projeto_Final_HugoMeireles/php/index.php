<?php
        session_start();
        require_once("standvirtual.php");
        $comando="SELECT * FROM marcas";
        $resultado=$bd->query($comando);
        if (!$resultado) {
            echo "<p>Ocorreu o erro ".$bd->errno()." - ".$bd->error()."</p>";
            exit();
        }
        $comandoD="SELECT titulo,foto1 FROM automoveis ORDER BY RAND() LIMIT 1";
        $resultadoD=$bd->query($comandoD);
        if (!$resultadoD) {
            echo "<p>Ocorreu o erro ".$bd->errno()." - ".$bd->error()."</p>";
            exit();
        }
        $linhaD=$resultadoD->fetch_object();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="header1.css" />
    <link rel="stylesheet" type="text/css" href="index.css" />
    <title>Home</title>
</head>
<body>
    <header>
        <img src="../imagens/logotipo.png" height="40px;" width="175px;"><br>
        <ul>
            <?php
                $comandoA="SELECT * FROM utilizadores WHERE codigo_utilizador=".$_SESSION["id"];
                $resultadoA=$bd->query($comandoA);
                if (!$resultadoA) {
                    echo "<p>Ocorreu o erro ".$bd->errno()." - ".$bd->error()."</p>";
                    exit();
                }
                $linhaA=$resultadoA->fetch_object();
                echo '<li><a href="registo.php">Registo de utilizador</a></li>';
                if(!isset($_SESSION["id"])){
                    
                    echo '<li><a href="login.php">login</a></li>';
                }else{
                    echo '<li><a href="perfil.php">Perfil</a></li>';
                    echo '<li><a href="logout.php">Sair</a></li>';
                }
                if($linhaA->perfil !== "U"){
                    echo '<li><a href="acesso_reservado.php">Acesso reservado</a></li>';
                }
            ?>
        </ul>
    </header>
    <div Class="Pesquisa_destaque">
        <div class="pesquisa">
            <h1>Pesquisa</h1>
                <p>
                    <label for="marca">marca:</label>
                    <select id="marca">
                    <option value="0">Seleccione</option>
                        <?php
                            while ($linha=$resultado->fetch_object()) {
                        ?>
                        <option value="<?=$linha->cod_marca?>"><?=$linha->marca?></option>
                        <?php
                            }
                        ?>
                    </select>
                </p>
                <p>
                    <label for="modelo">modelo:</label>
                    <select id="modelo">
                    </select>
                </p>
                <p>
                    <label for="combustivel">combustivel:</label>
                    <select id="combustivel">
                    <option value="">Seleccione</option>
                    <option value="G">Gasolina</option>
                    <option value="D">Diesel</option>
                    </select>
                </p>
                <p>
                    <input type="submit" id="btsubmit" name="btsubmit" value="pesquisar">
                </p>
        </div>
        <div class="destaque">
            <h1>Destaques</h1>
            <?php
                echo "<figure>";
                echo "<img src='../fotos/".$linhaD->foto1."'>";
                echo "<figcaption>";
                echo $linhaD->titulo;
                echo "</figcaption>";
                echo "</figure>";
            ?>
        </div>
    </div>
    <div class="informaçao">
    <?php
        if (isset($_GET["cod_marca"]) && isset($_GET["cod_modelo"]) && isset($_GET["combustivel"])) {
            $cod_marca=$_GET["cod_marca"];
            $cod_modelo=$_GET["cod_modelo"];
            $combustivel=$_GET["combustivel"];
            if (empty($cod_marca) || empty($cod_modelo) || empty($combustivel)) {
                echo "<p>Seleccione todos os campos!</p>\n";
            } else {
                $comandoCont="SELECT foto1,titulo,mes,ano,preco FROM automoveis WHERE marca='$cod_marca' AND modelo='$cod_modelo' AND combustivel='$combustivel'";
                $resultadoCont=$bd->query($comandoCont);
                if (!$resultadoCont) {
                    echo "<p>Ocorreu o erro ".$bd->errno()." - ".$bd->error()."</p>";
                    exit();
                }
                $comandoP="SELECT ma.marca,mo.modelo,a.combustivel FROM marcas ma,modelos mo, automoveis a WHERE ma.cod_marca=$cod_marca AND mo.cod_modelo=$cod_modelo AND a.combustivel='$combustivel'";
                $resultadoP=$bd->query($comandoP);
                if (!$resultadoP) {
                    echo "<p>Ocorreu o erro ".$bd->errno()." - ".$bd->error()."</p>";
                    exit();
                }
                $linhaP=$resultadoP->fetch_object();
                echo "<p>Pesquisa por : $linhaP->marca $linhaP->modelo a ";
                if($linhaP->combustivel=='G'){
                    echo "Gasolina";
                }else{
                    echo "Diesel"; 
                }
                    echo"</p>";
                echo "<p>Total de resultados : $resultadoCont->num_rows";
                if ($resultadoCont->num_rows===0) {
                    echo "<p>Nenhum resultado encontrado.</p>\n";
                } else {
                    
                    echo "<table>";
                    echo"<thead><tr><th>Foto</th><th>titulo de anúncio</th><th>Mês/Ano</th><th>Preço</th></tr></thead>";
                    echo "<tbody>";
                    while ($linhaCont=$resultadoCont->fetch_object()) {
                        echo "<tr>";
                        echo "<td><img src='../fotos/".$linhaCont->foto1."'></td>";
                        echo '<td><a href="automovel.php?titulo='.$linhaCont->titulo.'">'.$linhaCont->titulo.'</td>';
                        echo "<td>".$linhaCont->mes."/".$linhaCont->ano."</td>";
                        echo "<td>".$linhaCont->preco."€</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                }
                $resultadoCont->free_result();
            }
        }
        $bd->close();
    ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="marca_modelo_ajax.js"></script>
</body>
</html>