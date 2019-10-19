<?php
function foto($foto) {
    $erros="";
    if ($foto['error']!==0) {
        switch($foto['error']) {
            case '1':
                $erros.='<p>O ficheiro transferido excede a directiva upload_max_filesize do php.ini.</p>';
                break;
            case '2':
                $erros.='<p>O ficheiro transferido excede a directiva MAX_FILE_SIZE do formulário.</p>';
                break;
            case '3':
                $erros.='<p>O ficheiro foi parcialmente transferido.</p>';
                break;
           case '4':
               $erros.='<p>Nenhum ficheiro foi transferido.</p>';
               break;
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
                $erros.='<p>'.$foto['error'].' - Código de erro não disponível.</p>';
        }
    }else{
        if (empty($foto['tmp_name']) || $foto['tmp_name'] === 'none') {
            $erros.="<p>Não foi possível transferir o ficheiro.</p>";
        } else {
            switch ($foto['type']) {
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
                $extensao=strtolower(strrchr($foto['name'],'.'));
                $nome_ficheiro=$nome_temp.$extensao;
                if (!move_uploaded_file($foto['tmp_name'], "../fotos/" . $nome_ficheiro)) {
                    $erros.='<p>Ocorreu um erro no envio do ficheiro, por favor volte a tentar, se o erro persistir, contacte-nos.</p>';
                return $erros;
                }else{
                    return $nome_ficheiro;
                }
            }
        }
    }
}
?>