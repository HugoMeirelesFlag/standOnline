<?php
    require("standvirtual.php");
    session_start();
    $titulo=$_GET["titulo"];
    $comando="SELECT * FROM automoveis WHERE titulo='$titulo'";
    $resultado=mysqli_query($bd,$comando);
    if(!$resultado){
        echo "Ocorreu o erro".mysqli_errno($bd)."-".mysqli_error($bd).".</p>";
        exit();
    }
    $linha=$resultado->fetch_object();
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require '../PHPMailer-master/src/Exception.php';
    require '../PHPMailer-master/src/PHPMailer.php';
    require '../PHPMailer-master/src/SMTP.php';

    if(!isset($_SESSION["id"])){
        header("Location: index.php");
    }

    if (isset($_POST['btsubmit'])) {
        $mail = new PHPMailer(true);
        $titulo=$_POST['titulo'];
        $nome_utilizador=$_POST['nome_utilizador']; 
        $telefone=$_POST['telefone'];
        $email=$_POST['email'];
        $texto=$_POST['texto'];  
        $oferta=$_POST['oferta']; 
        $msg="<p>nome:".$nome_utilizador."</p>";
        $msg.="<p>email:".$email."</p>";
        $msg.="<p>telefone:".$telefone."</p>";
        $msg.="<p>Mensagen:".$texto."</p>";  
        $msg.="<p>oferta:".$oferta."€</p>";                      
        try {

            $mail->SMTPDebug = 2;                                 
            $mail->isSMTP();                                      
            $mail->Host = 'smtp.mailtrap.io';  
            $mail->SMTPAuth = true;                               
            $mail->Username = 'd246892be54023';                 
            $mail->Password = '527c0b97c5b0d6';    
                             
            $mail->Port = 25;
            
            $mail->setFrom('from@example.com', 'Mailer');
            $mail->addAddress('joe@example.net', 'Joe User');   
            
            $mail->Subject = 'anuncio:'.$titulo;
            $mail->Body    = $msg;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
        header("Location: registook.php?msg=Obrigado pela sua oferta!");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css"  href="header1.css" />
    <link rel="stylesheet" type="text/css"  href="automovel.css" />
    <title>Automóvel</title>
</head>
<body>
    <header>
        <img src="../imagens/logotipo.png" height="40px;" width="175px;"><br>
        <ul>
            <li><a href="perfil.php">Perfil</a></li>
            <li><a href="anuncios.php">Anúncios Activos</a></li>
            <li><a href="logout.php">Sair</a></li>
        </ul>
    </header>
    <div class="anuncio">
        <div class="informacao">
            <?php
                echo "<h1>".$linha->titulo."</h1>";
                echo"<p><strong>Marca:</strong>".$linha->marca."</p>";
                echo"<p><strong>Modelo:</strong>".$linha->modelo."</p>";
                echo"<p><strong>Registo:</strong>".$linha->mes."/".$linha->ano."</p>";
                echo"<p><strong>Cilindrada:</strong>".$linha->cilindrada."cc(".$linha->potencia."cv)</p>";
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
                $resultado->free_result();
            ?>
        </div>
        <div class="fotos">
            <div class="principal">
                <?php
                    echo"<img id='bigimage' src='../fotos/".$linha->foto1."'>";
                ?>
            </div>
            <div class="secundario">
                <?php
                    echo"<img id='smallimage' src='../fotos/".$linha->foto1."'>";
                    echo"<img id='smallimage' src='../fotos/".$linha->foto2."'>";
                    echo"<img id='smallimage' src='../fotos/".$linha->foto3."'>";
                    echo"<img id='smallimage' src='../fotos/".$linha->foto4."'>";
                    echo"<img id='smallimage' src='../fotos/".$linha->foto5."'>";
                ?>
            </div>
        </div>
    </div>
    <div id="contacto">
        <form id="formemail" method="post" action="<?=$_SERVER['PHP_SELF']?>" novalidate enctype="multipart/form-data">
            <?php
            if(isset($_SESSION['id'])){
                echo"<h2>Entre em contacto com o vendedor</h2>";
                $comandoA="SELECT * FROM utilizadores WHERE codigo_utilizador=".$_SESSION["id"];
                $resultadoA=$bd->query($comandoA);
                if (!$resultadoA) {
                    echo "<p>Ocorreu o erro ".$bd->errno()." - ".$bd->error()."</p>";
                    exit();
                }
                $linhaA=$resultadoA->fetch_object();
                echo'<p><strong>Nome:</strong>'.$linhaA->nome_utilizador.'</p>';
                echo '<input type="hidden" value="'.$linhaA->nome_utilizador.'" name="nome_utilizador" id="nome_utilizador" />';
                echo'<p><strong>email:</strong>'.$linhaA->email.'</p>';
                echo '<input type="hidden" value="'.$linhaA->email.'" name="email" id="email" />';
                echo'<p><strong>telefone:</strong>'.$linhaA->telefone.'</p>';
                echo '<input type="hidden" value="'.$linhaA->telefone.'" name="telefone" id="telefone" />';
                echo '<input type="hidden" value="'.$linha->titulo.'" name="titulo" id="titulo" />';
                $resultadoA->free_result();
                echo"<p><label for='texto'>Texto:</label><textarea rows='4' cols='50' id='texto' name='texto'></textarea></p>";
                echo "<p><label for='oferta'>Oferta:</label><input type='text' id='oferta' name='oferta'></p>";
                echo " <p><input type='submit' id='btsubmit' name='btsubmit' value='Enviar'></p>";
            }
            ?>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="automovel.js"></script>
</body>
</html>