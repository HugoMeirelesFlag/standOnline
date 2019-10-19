<?php
    require_once("standvirtual.php");
    $comando="SELECT * FROM marcas";
    $resultado=$bd->query($comando);
    if (!$resultado) {
        echo "<p>Ocorreu o erro ".$bd->errno()." - ".$bd->error()."</p>";
        exit();
    }
    if (isset($_POST['btsubmit'])) {
        $titulo=$_POST['titulo'];
        $marca=$_POST['marca'];
        $modelo=$_POST['modelo'];
        $mes=$_POST['mes'];
        $ano=$_POST['ano'];
        $cilindrada=$_POST['cilindrada'];
        $potencia=$_POST['potencia'];
        $combustivel=$_POST['combustivel'];
        $kms=$_POST['kms'];
        $cor=$_POST['cor'];
        $n_portas=$_POST['n_portas'];
        $descricao=$_POST['descricao'];
        $jantes_liga_leve=isset($_POST['jantes_liga_leve'])? 'S' : 'N';
        $direcao_assistida=isset($_POST['direcao_assistida']) ? 'S' : 'N';
        $fecho_central=isset($_POST['fecho_central']) ? 'S' : 'N';
        $eps=isset($_POST['eps'])? 'S' : 'N';
        $ar_condicionado=isset($_POST['ar_condicionado']) ? 'S' : 'N';
        $vidros_eletricos=isset($_POST['vidros_eletricos']) ? 'S' : 'N';
        $computador_bordo=isset($_POST['computador_bordo']) ? 'S' : 'N';
        $farois_nevoeiro=isset($_POST['farois_nevoeiro']) ? 'S' : 'N';
        $livro_revisoes=isset($_POST['livro_revisoes']) ? 'S' : 'N';
        $preco=$_POST['preco'];
        $destaque=isset($_POST['destaque']) ? 'S' : 'N';

        $erros="";

        $campos_obrigatorios=['titulo','marca','mes','ano','cilindrada','potencia','combustivel','kms','cor','n_portas','preco','destaque'];
        for ($posicao=0;$posicao<count($campos_obrigatorios);$posicao++) {
            $campo=$campos_obrigatorios[$posicao];
            if ($_POST[$campo]==="") {
                if($erros===""){
                    $erros="<p>Os campos assinalados são de preenchimento obrigatório!</p>";
                }
                $erros.="<p>".$campo."</p>";
            }
        }

        if($mes>12 || $mes<=0){
            $erros.="Colocar mês real!";
        }
        if($mes>1885 || $mes>=date("Y")){
            $erros.="Colocar ano real!";
        }
        if($n_portas!="3" && $n_portas!="5"){
            $erros.="Insira Nº de portas crediveis!";
        }

        require_once("foto.php");
        $foto1=foto($_FILES['foto1']);
        $foto2=foto($_FILES['foto2']);
        $foto3=foto($_FILES['foto3']);
        $foto4=foto($_FILES['foto4']);
        $foto5=foto($_FILES['foto5']);

        if (empty($erros)) {
            $comandoInser="INSERT INTO automoveis (marca, modelo, ano, mes, cilindrada, potencia, combustivel, kms, preco, cor, n_portas, descricao, titulo, estado, destaque, jantes_liga_leve, direcao_assistida, fecho_central, eps, ar_condicionado, vidros_eletricos, computador_bordo, farois_nevoeiro, livro_revisoes, foto1, foto2, foto3, foto4, foto5) VALUES ('$marca', '$modelo', '$ano', '$mes', '$cilindrada', '$potencia', '$combustivel', '$kms', '$preco', '$cor', '$n_portas', '$descricao', '$titulo', 'A', '$destaque', '$jantes_liga_leve', '$direcao_assistida', '$fecho_central', '$eps', '$ar_condicionado', '$vidros_eletricos', '$computador_bordo', '$farois_nevoeiro', '$livro_revisoes', '$foto1', '$foto2', '$foto3', '$foto4', '$foto5')";
            if (!$resultadoInser=$bd->query($comandoInser)) {
                echo "<p>Ocorreu o erro ".$resultadoInser->errno()." - ".$resultadoInser->error()."</p>";
                exit();
            }
            // echo $comandoInser;
            if ($bd->affected_rows!==1) {
                $erros.="<p>Erro no registo do anuncio!</p>";
            } else {
                header("Location: registook.php?msg=Registo efectuado com sucesso");
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
    <title>InsireAnuncio</title>
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
    <form id="formregisto" method="post" action="<?=$_SERVER['PHP_SELF']?>" novalidate enctype="multipart/form-data">
        <h2>Colocar anúncio</h2>
        <?php
        if (!empty($erros)) { 
            echo $erros;
        }
        ?>
        <p><label for="titulo">Título:</label><input type="text" id="titulo" name="titulo" ></p>
        <p>
            <label for="marca">marca:</label>
            <select id="marca" name="marca">
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
            <select id="modelo" name="modelo">
            </select>
        </p>
        <p><label for="mes">Data de registo:</label> <input type="text" id="mes" name="mes" maxlength="2" pattern="[0-9]{2}" >/<input type="text" id="ano" name="ano" maxlength="4" pattern="[0-9]{4}"></p>
        <p><label for="cilindrada">Cilindrada:</label><input type="text" id="cilindrada" name="cilindrada" ></p>
        <p><label for="potencia">Potência:</label><input type="text" id="potencia" name="potencia"></p>
        <p>
            <label for="combustivel">combustivel:</label>
            <select id="combustivel" name="combustivel">
            <option value="">Seleccione</option>
            <option value="G">Gasolina</option>
            <option value="D">Diesel</option>
            </select>
        </p>
        <p><label for="kms">Kms:</label><input type="text" id="kms" name="kms"></p>
        <p><label for="cor">Cor:</label><input type="text" id="cor" name="cor"></p>
        <p><label for="n_portas">Nº portas:</label><input type="text" id="n_portas" name="n_portas"></p>
        <p><label for="descricao">Descricão:</label><textarea id="descricao" name="descricao" rows="2" cols="50"></textarea></p>
        <fieldset>
            <legend>Características</legend>
                <input type="checkbox" name="jantes_liga_leve" value="jantes_liga_leve">Jantes de liga leve<br>
                <input type="checkbox" name="direcao_assistida" value="direcao_assistida">Direcao assistida<br>
                <input type="checkbox" name="fecho_central" value="fecho_central"> Fecho central<br>
                <input type="checkbox" name="eps" value="eps">Eps<br>
                <input type="checkbox" name="ar_condicionado" value="ar_condicionado">Ar condicionado<br>
                <input type="checkbox" name="vidros_eletricos" value="vidros_eletricos">Vidros Elétricos<br>
                <input type="checkbox" name="computador_bordo" value="computador_bordo">Computador de bordo<br>
                <input type="checkbox" name="farois_nevoeiro" value="farois_nevoeiro">Faróis de nevoeiro<br>
                <input type="checkbox" name="livro_revisoes" value="livro_revisoes">Livro de revisões<br>
        </fieldset>
        <p><label for="preco">Preço:</label><input type="text" id="preco" name="preco">€</p>
        <input type="checkbox" name="destaque" value="destaque">Colocar em destaque?<br>
        <p><label for="foto1">Foto1:</label><input type="file" id="foto1" name="foto1"></p>
        <p><label for="foto2">Foto2:</label><input type="file" id="foto2" name="foto2"></p>
        <p><label for="foto3">Foto3:</label><input type="file" id="foto3" name="foto3"></p>
        <p><label for="foto4">Foto4:</label><input type="file" id="foto4" name="foto4"></p>
        <p><label for="foto5">Foto5:</label><input type="file" id="foto5" name="foto5"></p>
        <p><input type="submit" id="btsubmit" name="btsubmit" value="Registar Anuncio"></p>
    </form>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="marca_modelo_ajax.js"></script>
</body>
</html>