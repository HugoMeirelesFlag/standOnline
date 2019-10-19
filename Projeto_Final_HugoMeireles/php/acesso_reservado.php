<?php
    require_once("standvirtual.php");
    session_start();
    $comando="SELECT * FROM utilizadores WHERE codigo_utilizador=".$_SESSION["id"];
    $resultado=mysqli_query($bd,$comando);
    $linha=$resultado->fetch_object();
    if(!$resultado){
        echo "Ocorreu o erro".mysqli_errno($bd)."-".mysqli_error($bd).".</p>";
        exit();
    }
    if(!isset($_SESSION["id"])||$linha->perfil ==="U"){
        header("Location: index.php");
    }
    $resultado->free_result();
    if (isset($_POST['btsubmit'])) {
        $erros="";
        if(isset($_POST['marca']) && !isset($_POST['modelo'])){
            $marca=$_POST['marca'];
            $comando="SELECT marca FROM marcas WHERE marca='$marca'";
            $resultado=mysqli_query($bd,$comando);
            if(!$resultado){
                echo "Ocorreu o erro".mysqli_errno($bd)."-".mysqli_error($bd).".</p>";
                exit();
            }
            if ($resultado->num_rows!==0) {
                $erros.="<p>Já existe essa marca.</p>";
            }
            if($erros===""){
                $comandoInser="INSERT INTO marcas(marca) VALUES('$marca')";
                if (!$resultadoInser=$bd->query($comandoInser)) {
                    echo "<p>Ocorreu o erro ".$resultadoInser->errno()." - ".$resultadoInser->error()."</p>";
                    exit();
                }
                if ($bd->affected_rows!==1) {
                    $erros.="<p>Erro no registo de utilizador!</p>";
                }else{
                    echo"Marca Inserida";
                }
            }
        }elseif(isset($_POST['modelo']) && isset($_POST['marca']) && $_POST['marca']!==0  ){
            $marca=$_POST['marca'];
            $modelo=$_POST['modelo'];
            
            $comando="SELECT modelo FROM modelos WHERE modelo='$modelo'";
            $resultado=mysqli_query($bd,$comando);
            if(!$resultado){
                echo "Ocorreu o erro".mysqli_errno($bd)."-".mysqli_error($bd).".</p>";
                exit();
            }
            if ($resultado->num_rows!==0) {
                $erros.="<p>Já existe esse modelo.</p>";
            }
            if($erros===""){
                $comandoInser="INSERT INTO modelos(modelo,marca) VALUES('$modelo',$marca)";
                if (!$resultadoInser=$bd->query($comandoInser)) {
                    echo "<p>Ocorreu o erro ".$resultadoInser->errno()." - ".$resultadoInser->error()."</p>";
                    exit();
                }
                if ($bd->affected_rows!==1) {
                    $erros.="<p>Erro no registo de utilizador!</p>";
                }else{
                    echo"Modelo Inserida";
                }
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
    <link rel="stylesheet" type="text/css" href="header2.css" />
    <link rel="stylesheet" type="text/css" href="acesso_reservado.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Backoffice</title>
</head>
<body>
    <header>
        <img src="../imagens/logotipo.png" height="40px;" width="175px;"><br>
        <ul>
            <li><a href="acesso_reservado.php?marcas">Marcas</a></li>
            <li><a href="acesso_reservado.php?modelos">Modelos</a></li>
            <li><a href="acesso_reservado.php?utilizadores">Utilizadores</a></li>
        </ul>
    </header>
    <?php
        if(isset($_GET['marcas'])){
            echo"<h1>Marcas</h1>";
        }elseif(isset($_GET['modelos'])){
            echo"<h1>Modelos</h1>";
        }elseif(isset($_GET['utilizadores'])){
            echo"<h1>Utilizadores</h1>";
        }
    ?>
    <div>
        <form id="formregisto" method="post" action="<?=$_SERVER['PHP_SELF']?>" novalidate enctype="multipart/form-data">
        <?php
        $comando="SELECT * FROM marcas";
        $resultado=$bd->query($comando);
        if (!$resultado) {
            echo "<p>Ocorreu o erro ".$bd->errno()." - ".$bd->error()."</p>";
            exit();
        }
        if(isset($_GET['marcas'])){
            echo"<p><label for='marca'>Marca:</label> <input type='text' id='marca' name='marca'></p>";
            echo"<p><input type='submit' id='btsubmit' name='btsubmit' value='Inserir'></p>";
        }elseif(isset($_GET['modelos'])){
            echo "<label for='marca'>marca:</label>";
            echo "<select id='marca' name='marca'>";
            echo "<option value='0'>Seleccione</option>";
            while ($linha=$resultado->fetch_object()) {
                echo '<option id="marca" name="marca" value="'.$linha->cod_marca.'">'.$linha->marca.'</option>';
            }
            echo "</select>";
            echo"<p><label for='modelo'>Modelo:</label> <input type='text' id='modelo' name='modelo'></p>";
            echo"<p><input type='submit' id='btsubmit' name='btsubmit' value='Inserir'></p>";
        }
    ?>
        </form>
    </div>
    <div class="dados">
    <form >
        <?php
            if(isset($_GET['apagarmodelo'])){
                $comando="DELETE FROM modelos WHERE cod_modelo=".$_GET['apagarmodelo'];
                $resultado=mysqli_query($bd,$comando);
                if(!$resultado){
                    echo "Ocorreu o erro".mysqli_errno($bd)."-".mysqli_error($bd).".</p>";
                    exit();
                }else{
                    header("Location: acesso_reservado.php?modelos");
                }
            }elseif(isset($_GET['apagarmarca'])){
                $comando="DELETE FROM marcas WHERE cod_marca=".$_GET['apagarmarca'];
                $resultado=mysqli_query($bd,$comando);
                if(!$resultado){
                    echo "Ocorreu o erro".mysqli_errno($bd)."-".mysqli_error($bd).".</p>";
                    exit();
                }else{
                    header("Location: acesso_reservado.php?marcas");
                }
            }elseif(isset($_GET['apagarutilizador'])){
                $comando="DELETE FROM utilizadores WHERE codigo_utilizador=".$_GET['apagarutilizador'];
                $resultado=mysqli_query($bd,$comando);
                if(!$resultado){
                    echo "Ocorreu o erro".mysqli_errno($bd)."-".mysqli_error($bd).".</p>";
                    exit();
                }else{
                    header("Location: acesso_reservado.php?utilizadores");
                }
            }
            elseif(isset($_GET['alterarutilizador'])&& isset($_GET['estado'])){
                $estado=$_GET['estado'];
                $comando="UPDATE utilizadores SET estado='$estado' WHERE codigo_utilizador=".$_GET['alterarutilizador'];
                $resultado=mysqli_query($bd,$comando);
                if(!$resultado){
                    echo "Ocorreu o erro".mysqli_errno($bd)."-".mysqli_error($bd).".</p>";
                    exit();
                }else{
                    header("Location: acesso_reservado.php?utilizadores");
                }
            }
            if(isset($_GET['marcas'])){
                $comando="SELECT cod_marca,marca FROM marcas";
                $resultado=mysqli_query($bd,$comando);
                if(!$resultado){
                    echo "Ocorreu o erro".mysqli_errno($bd)."-".mysqli_error($bd).".</p>";
                    exit();
                }
                echo "<table>";
                echo"<thead><tr><th>Marcas</th><th>Operações</th></tr></thead>";
                echo "<tbody>";
                while ($linha=$resultado->fetch_object()) {
                    echo "<tr>";
                    echo "<td>".$linha->marca."</td>";
                    echo "<td><a onclick=\"return confirm('Pretendes mesmo apagar o item?');\" href='acesso_reservado.php?apagarmarca=".$linha->cod_marca."'  id='apagar' name='marca' value=".$linha->cod_marca.">Apagar</a></td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo '</table>';
               
            }elseif(isset($_GET['modelos'])){
                $comando="SELECT ma.marca,mo.modelo,mo.cod_modelo FROM marcas ma,modelos mo where ma.cod_marca=mo.marca";
                $resultado=mysqli_query($bd,$comando);
                if(!$resultado){
                    echo "Ocorreu o erro".mysqli_errno($bd)."-".mysqli_error($bd).".</p>";
                    exit();
                }
                echo "<table>";
                echo"<thead><tr><th>Marcas</th><th>Modelo</th><th>Operações</th></tr></thead>";
                echo "<tbody>";
                while ($linha=$resultado->fetch_object()) {
                    echo "<tr>";
                    echo "<td>".$linha->marca."</td>";
                    echo "<td>".$linha->modelo."</td>";
                    echo "<td><a onclick=\"return confirm('Pretendes mesmo apagar o item?');\" href='acesso_reservado.php?apagarmodelo=".$linha->cod_modelo."' id='apagar' name='modelo' value=".$linha->cod_modelo.">Apagar</a></td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo '</table>';
            }elseif(isset($_GET['utilizadores'])){
                $comando="SELECT codigo_utilizador,nome_utilizador,email,estado,data_registo FROM utilizadores";
                $resultado=mysqli_query($bd,$comando);
                if(!$resultado){
                    echo "Ocorreu o erro".mysqli_errno($bd)."-".mysqli_error($bd).".</p>";
                    exit();
                }
                echo "<table class='tabela'>";
                echo"<thead><tr><th>Nome</th><th>Email</th><th>Estado</th><th>Data de registo</th><th>Operações</th></tr></thead>";
                echo "<tbody>";
                while ($linha=$resultado->fetch_object()) {
                    echo "<tr>";
                    echo "<td>".$linha->nome_utilizador."</td>";
                    echo "<td>".$linha->email."</td>";
                    echo "<td>";
                    echo "<select id='estado' name='estado'>";
                    if($linha->estado==="A"){
                        echo "<option data-id=".$linha->codigo_utilizador." value=".$linha->estado." selected>Activo</option>";
                        echo "<option data-id=".$linha->codigo_utilizador." value='R'>Registado</option>";
                        echo "<option data-id=".$linha->codigo_utilizador."  value='D'>Desativo</option>";
                    }elseif($linha->estado==="R"){
                        echo "<option data-id=".$linha->codigo_utilizador." value=".$linha->estado." selected>Registado</option>";
                        echo "<option data-id=".$linha->codigo_utilizador."  value='A'>Activo</option>";
                        echo "<option data-id=".$linha->codigo_utilizador." value='D'>Desativo</option>";
                    }elseif($linha->estado==="D"){
                        echo "<option data-id=".$linha->codigo_utilizador." value=".$linha->estado." selected>Desativo</option>";
                        echo "<option data-id=".$linha->codigo_utilizador." value='A'>Activo</option>";
                        echo "<option data-id=".$linha->codigo_utilizador." value='R'>Registado</option>";
                    }
                    echo "</select>";
                    echo "</td>";
                    echo "<td>".$linha->data_registo."</td>";
                    echo "<td><a onclick=\"return confirm('Pretendes mesmo apagar o item?');\" href='acesso_reservado.php?apagarutilizador=".$linha->codigo_utilizador."'><img  id='icon' src='../imagens/trash.png'></a></td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo '</table>';
            }
        ?>
    </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <script src="acessoreservado.js"></script>
</body>
</html>