<?php
    if (!$bd=new mysqli("localhost","root","","standvirtual")) {
        if ($bd->connect_errno()===1049) {
            echo "<p>Ocorreu um erro na ligação à base de dados.</p>";
            exit(); // ou die();
        } else {
            echo "<p>Ocorreu um erro. Volte a tentar mais tarde.</p>";
            exit();
        }
    }
    // definir a codificação dos caracteres
    $bd->set_charset("utf8");
?>
