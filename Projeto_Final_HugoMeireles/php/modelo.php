<?php
    header("Content-Type: application/json");
    require("standvirtual.php");
    $cod_marca=$_GET["cod_marca"];
    $comando="SELECT * FROM modelos WHERE marca='$cod_marca'";
    $resultado=$bd->query($comando);
    $dados=[];
    if (!$resultado) {
        echo "<p>Ocorreu o erro ".$bd->errno()." - ".$bd->error()."</p>";
        exit();
    }
    while($linha=$resultado->fetch_object()){
        array_push($dados,array('cod_modelo'=>$linha->cod_modelo,'modelo'=>$linha->modelo));
    }
    echo json_encode($dados);
    $resultado->free_result();
    $bd->close();
?>