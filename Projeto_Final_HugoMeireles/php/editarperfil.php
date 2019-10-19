<?php
require_once("loja.php");
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: index.php");
}
        $comando="SELECT * FROM utilizadores WHERE codigo_utilizador=".$_SESSION["id"];
        //executar o comando
        $resultado=mysqli_query($bd,$comando);
        if(!$resultado){
            echo "Ocorreu o erro".mysqli_errno($bd)."-".mysqli_error($bd).".</p>";
            exit();
        }
        $linha=$resultado->fetch_object();
        $nome_utilizador=$linha->nome_utilizador;
        $morada_utilizador=$linha->morada_utilizador ;
        $localidade_utilizador=$linha->localidade_utilizador ;
        $cp_utilizador=substr($linha->cp_utilizador,0,4);
        $cp_utilizador2=substr($linha->cp_utilizador,5,3);
        $cp_utilizador_loc=substr($linha->cp_utilizador,9);
        $pais=$linha->pais ;
        $telefone=$linha->telefone;
        $email=$linha->email;
        $nif=$linha->nif;
        $data_nascimento=$linha->data_nascimento;
        $foto=$linha->foto;
if (isset($_POST['btsubmit'])) {
    require_once("loja.php");
    // echo "<pre>".print_r($_FILES, TRUE)."</pre>";
    // echo "<pre>".print_r($_POST, TRUE)."</pre>";
    $nome_utilizador=$_POST['nome_utilizador']==="" ? $linha->nome_utilizador : $_POST['nome_utilizador'] ;
    $morada_utilizador=$_POST['morada_utilizador']==="" ? $linha->morada_utilizador : $_POST['morada_utilizador'] ;
    $localidade_utilizador=$_POST['localidade_utilizador']==="" ?$linha->localidade_utilizador : $_POST['localidade_utilizador'] ;
    $cp_utilizador=$_POST['cp_utilizador']==="" ? substr($linha->cp_utilizador,0,4) : $_POST['cp_utilizador'];
    $cp_utilizador2=$_POST['cp_utilizador2']==="" ? substr($linha->cp_utilizador,5,3) : $_POST['cp_utilizador2'];
    $cp_utilizador_loc=$_POST['cp_utilizador_loc']==="" ? substr($linha->cp_utilizador,9) : $_POST['cp_utilizador_loc'];
    $pais=$_POST['pais']==="" ? $linha->pais : $_POST['pais'] ;
    $telefone=$_POST['telefone']==="" ? $linha->telefone : $_POST['telefone'] ;
    $email=$_POST['email']==="" ? $linha->email : $_POST['email'] ;
    $nif=$_POST['nif']==="" ? $linha->nif : $_POST['nif'] ;
    $data_nascimento=$_POST['data_nascimento']==="" ? $linha->data_nascimento : $_POST['data_nascimento'] ;

    $erros="";
    // validação de dados
    // TPC - apresentar uma mensagem do tipo:
    // Os campos 'nome_utilizador', 'email' são de preenchimento obrigatório.

    // campo nome - só posso escrever letras ou apóstrofos/hifens - no mínimo 3 caracteres
    if (strlen($nome_utilizador)<3) {
        $erros.="<p>O campo 'Nome' tem de ter, no mínimo, 3 caracteres!</p>";
    } else {
        // $valido=true;
        // // ctype_alpha() is equivalent to (ctype_upper($text) || ctype_lower($text))
        // $posicao2=0;
        // while ($posicao2<strlen($nome_utilizador) && $valido) {
        //     if (!ctype_alpha($nome_utilizador[$posicao2]) && $nome_utilizador[$posicao2]!=="'" && $nome_utilizador[$posicao2]!=="-") {
        //         $valido=false;
        //     }
        //     $posicao2++;
        // }
        // if (!$valido) {
        //     $erros.="<p>O campo 'Nome' só pode ter letras, apóstrofos e hifens!</p>";
        // }
        if (!preg_match("/^[a-zA-Z'\- ]{3,80}$/", $nome_utilizador)) {
            $erros.="<p>O campo 'Nome' só pode ter letras, apóstrofos e hifens!</p>";
        }
    }

    // controlar tamanhos - morada (80), localidade(40)
    if (strlen($morada_utilizador)>80) {
        $erros.="<p>O campo 'Morada' só pode ter 80 caracteres!</p>";
    }
    if (strlen($localidade_utilizador)>40) {
        $erros.="<p>O campo 'Localidade' só pode ter 40 caracteres!</p>";
    }

    // cp - 4 + 3 algarismos - formato 9999-999
    if ($cp_utilizador!=="" && (!ctype_digit($cp_utilizador) || strlen($cp_utilizador)!==4)) {
        $erros.="<p>A primeira parte do Código Postal só pode conter algarismos (4 algarimos)!</p>";
    } else {
        if ($cp_utilizador2!=="" && (!ctype_digit($cp_utilizador2) || strlen($cp_utilizador2)!==3)) {
            $erros.="<p>A segunda parte do Código Postal só pode conter algarismos (3 algarimos)!</p>";
        } else {
            $cp=$cp_utilizador."-".$cp_utilizador2." ".$cp_utilizador_loc;
        }
    }

    // is_numeric("-23"); // cuidado que é true
    // is_numeric("+23"); // cuidado que é true

    // telefone - 9 algarismos
    if ($telefone!=="" && (!ctype_digit($telefone) || strlen($telefone)!==9)) {
        $erros.="<p>O telefone só pode conter algarismos (9 algarimos)!</p>";
    }

    // endereço de email válido - tem de ter uma @
    // antes da arroba tem de ter pelo menos 1 carácter (ver caracteres autorizados)
    // depois da arroba tem de ter pelo menos 2 caracteres (ver caracteres autorizados)
    // antes de um ponto
    // depois do último ponto tem de ter no mínimo 2 caracteres
    // ubirmingham.ac.uk
    // .com.pt
    // porto.flag.pt

    if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $erros.="<p>O formato do email introduzido está incorrecto!</p>";
    } else {
        // e-mail - verificar se já existe na nossa BD
        $comando="SELECT * FROM utilizadores WHERE email='$email'";
        $resultado=$bd->query($comando);
        $linha=$resultado->fetch_object();
        if($email!==$linha->email){
            if (!$resultado) {
                echo "<p>Ocorreu o erro ".$bd>errno()." - ".$bd->error()."</p>";
                exit();
            }
            if ($resultado->num_rows!==0) {
                $erros.="<p>O email introduzido já está registado!</p>";
            }
        }
    }

    require_once("funcoes.php");
    
    // nif - 9 algarismos - verificar se já existe
    // if ($nif!=="" && (!ctype_digit($nif) || strlen($nif)!==9)) {
    //     $erros.="<p>O NIF só pode conter algarismos (9 algarimos)!</p>";
    // } else {   
    // if (is_null($nif) || !is_numeric($nif) || strlen($nif)!=9) {
    if ($nif!=="") {
        if (!ctype_digit($nif) || strlen($nif)!==9) {        
            $erros.="<p>O NIF só pode conter algarismos (9 algarismos)!</p>"; 
        } else {
            // verificar se nif é válido - algoritmo - check digit
            if (!validarNIF($nif)) {
                $erros.="<p>O NIF é inválido!</p>";
            } else {
                $comando="SELECT * FROM utilizadores WHERE nif='$nif'";
                $resultado=$bd->query($comando);
                $linha=$resultado->fetch_object();
                if($nif!==$linha->nif){
                    if (!$resultado) {
                        echo "<p>Ocorreu o erro ".$bd->errno()." - ".$bd->error()."</p>";
                        exit();
                    }
                    if ($resultado->num_rows!==0) {
                        $erros.="<p>O NIF introduzido já está registado!</p>";
                    }
                }
            }
        }
    }
    $d = new DateTime($data_nascimento);
    date_default_timezone_set('Europe/Lisbon');
    $date = date('Y-m-d H:i:s');
    if($data_nascimento>$date){
        $erros.="<p>O campo 'data de nascimento' tem de ser antes de hoje!</p>";
    }else{
        if(date('Y')-substr($data_nascimento,0,4)<18){
            $erros.="<p>Tens de ter mais de 18 anos</p>";
        }else{
            if ($data_nascimento!=="" && !preg_match("/^\d\d\d\d-\d\d-\d\d$/", $data_nascimento)) {
                $erros.="<p>O campo 'data de nascimento' só pode ter o formato, AAAA-MM-DD!</p>";
            }else{
                // $partes=explode("-",$data_nascimento);
                // if(!checkdate($partes[1],$partes[2],$partes[3])){
                //     $erros.="<p>O campo 'data de nascimento' é invalida</p>;"
                // }
                $ano=substr($data_nascimento,0,4);
                $mes=substr($data_nascimento,5,2);
                $dia=substr($data_nascimento,8,2);
                if(!checkdate($mes,$dia,$ano)){
                    $erros.="<p>O campo 'data de nascimento' é invalida</p>;";
                }
            }
        }
    }
    // data_nascimento - se tem formato válido e se existe
    

    if ($_FILES['foto']['error']!==4) {
        if ($_FILES['foto']['error']!==0) {
            switch($_FILES['foto']['error']) {
                case '1':
                    $erros.='<p>O ficheiro transferido excede a directiva upload_max_filesize do php.ini.</p>';
                    break;
                case '2':
                    $erros.='<p>O ficheiro transferido excede a directiva MAX_FILE_SIZE do formulário.</p>';
                    break;
                case '3':
                    $erros.='<p>O ficheiro foi parcialmente transferido.</p>';
                    break;
            //    case '4':
            //        $erros.='<p>Nenhum ficheiro foi transferido.</p>';
            //        break;
                case '6':
                    $erros.='<p>Não existe pasta temporária.</p>';
                    break;
                case '7':
                    $erros.='<p>Não foi possível escrever o ficheiro em disco.</p>';
                    break;
                case '8':
                    $erros.='<p>Problemas com a extensão do ficheiro.</p>';
                    break;
                /*case '999':*/
                default:
                    $erros.='<p>'.$_FILES['foto']['error'].' - Código de erro não disponível.</p>';
            }
        } else {
            if (empty($_FILES['foto']['tmp_name']) || $_FILES['foto']['tmp_name'] === 'none') {
                $erros.="<p>Não foi possível transferir o ficheiro.</p>";
            } else {
                switch ($_FILES['foto']['type']) {
                    case 'image/jpeg':
                    case 'image/jpg':
                    case 'image/gif':
                    case 'image/png':
                    // case 'image/svg+xml':
                        $extvalida=true;
                        break;
                    default:
                        $extvalida=false;
                }
                if (!$extvalida) {
                    $erros.="<p>O formato do ficheiro não é permitido.</p>";
                } else {
                    $aleatorio=mt_rand();
                    $nome_temp=date('YmdHis').$aleatorio;
                    $extensao=strtolower(strrchr($_FILES['foto']['name'],'.'));
                    $nome_ficheiro=$nome_temp.$extensao;
                    if (!move_uploaded_file($_FILES['foto']['tmp_name'], "fotos/" . $nome_ficheiro)) {
                        $erros.='<p>Ocorreu um erro no envio do ficheiro, por favor volte a tentar, se o erro persistir, contacte-nos.</p>';
                    }
                }
            }
        }
    }
    if (empty($erros)) {
        // $comandoInser="INSERT INTO utilizadores(nome_utilizador,morada_utilizador,localidade_utilizador,cp_utilizador,pais,telefone,email,nif,data_nascimento,foto,senha) VALUES('$nome_utilizador','$morada_utilizador','$localidade_utilizador','$cp','$pais','$telefone','$email','$nif','$data_nascimento','$nome_ficheiro','$senha_encriptada')";
        if ($_FILES['foto']['error']!==4) {
            $comandoAlt="UPDATE utilizadores SET nome_utilizador='".$nome_utilizador."', morada_utilizador='".$morada_utilizador."', localidade_utilizador='".$localidade_utilizador."', cp_utilizador='".$cp_utilizador."-".$cp_utilizador2." ".$cp_utilizador_loc."', pais='".$pais."', telefone='".$telefone."', email='".$email."', nif='".$nif."', data_nascimento='".$data_nascimento."', foto='".$nome_ficheiro."' WHERE codigo_utilizador=".$_SESSION["id"];
        }else{
            $comandoAlt="UPDATE utilizadores SET nome_utilizador='".$nome_utilizador."', morada_utilizador='".$morada_utilizador."', localidade_utilizador='".$localidade_utilizador."', cp_utilizador='".$cp_utilizador."-".$cp_utilizador2." ".$cp_utilizador_loc."', pais='".$pais."', telefone='".$telefone."', email='".$email."', nif='".$nif."', data_nascimento='".$data_nascimento."' WHERE codigo_utilizador=".$_SESSION["id"];
        }
            if (!$resultadoAlt=$bd->query($comandoAlt)) {
                echo "<p>Ocorreu o erro ".$resultadoAlt->errno()." - ".$resultadoAlt->error()."</p>";
                exit();
            }
            // echo $comandoInser;
            if ($bd->affected_rows!==1) {
                $erros.="<p>Erro no registo de utilizador!</p>";
            } else {
                header("Location: mensagens.php?msg=Registo alterado efectuado com sucesso");
            }
        }
    
    // encriptar senha

    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form id="formaltera" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" novalidate>
        <h2>Registo de utilizador</h2>
        <?php
        if (!empty($erros)) { // é igual ao isset, mas além de verificar se
            // a variável está definida, também verifica se a variável contém um valor
            echo $erros;
        }
        ?>
        <p><label for="nome_utilizador">Nome:</label> <input type="text" id="nome_utilizador" name="nome_utilizador" value="<?=(isset($nome_utilizador)) ? $nome_utilizador : '' ?>"></p>
        <p><label for="morada_utilizador">Morada:</label> <input type="text" id="morada_utilizador" name="morada_utilizador" maxlength="80" value="<?=(isset($morada_utilizador)) ? $morada_utilizador : '' ?>"></p>
        <p><label for="localidade_utilizador">Localidade:</label> <input type="text" id="localidade_utilizador" name="localidade_utilizador" maxlength="40" value="<?=(isset($localidade_utilizador)) ? $localidade_utilizador : '' ?>"></p>
        <p><label for="cp_utilizador">CP:</label> <input type="text" id="cp_utilizador" name="cp_utilizador" size="4" maxlength="4" pattern="[1-9][0-9]{3}" value="<?=(isset($cp_utilizador)) ? $cp_utilizador : '' ?>">-<input type="text" id="cp_utilizador2" name="cp_utilizador2" size="3" maxlength="3" pattern="\d{3}" value="<?=(isset($cp_utilizador2)) ? $cp_utilizador2 : '' ?>"> <input type="text" id="cp_utilizador_loc" name="cp_utilizador_loc" maxlength="30" value="<?=(isset($cp_utilizador_loc)) ? $cp_utilizador_loc : '' ?>"></p>
        <p><label for="pais">País:</label> <select id="pais" name="pais">
            <option value="0">-- Seleccione um país --</option>
            <option value="pt" <?=(isset($pais) && $pais==="pt") ? "selected" : '' ?>>Portugal</option>
            <option value="es" <?=(isset($pais) && $pais==="es") ? "selected" : '' ?>>Espanha</option>
            <option value="fr" <?=(isset($pais) && $pais==="fr") ? "selected" : '' ?>>França</option>
        </select></p>
        <p><label for="telefone">Telefone:</label> <input type="text" id="telefone" name="telefone" value="<?=(isset($telefone)) ? $telefone : '' ?>"></p>
        <p><label for="email">E-mail:</label> <input type="text" id="email" name="email" value="<?=(isset($email)) ? $email : '' ?>"></p>
        <p><label for="nif">NIF:</label> <input type="text" id="nif" name="nif" value="<?=(isset($nif)) ? $nif : '' ?>"></p>
        <p><label for="data_nascimento">Data nascimento:</label> <input type="date" id="data_nascimento" name="data_nascimento" value="<?=(isset($data_nascimento)) ? $data_nascimento : '' ?>"></p>
        <p><label for="foto">Foto:</label> <input type="file" id="foto" name="foto" accept="image/*"></p>
        <strong>foto:</strong><img src='fotos/<?=$foto?>'></p>
        <p><input type="submit" id="btsubmit" name="btsubmit" value="Efectuar registo"></p>
    </form>
    <p><a href="alterapass.php">Alterar password<p>
    <p><a href="perfil.php">Voltar<p>
</body>
</html>