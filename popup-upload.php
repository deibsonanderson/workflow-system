<?php
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
//EXTRA******************************************************************************
//troca os espaços em branco "%20" no nome dos arquivos por underline "_"
function removeEspacosEmBranco($valor) {
    $valor = str_replace("%20", "_", $valor);
    $valor = str_replace(" ", "_", $valor);
    return $valor;
}

function geraThumb($path, $imagem) {
    $ext = explode(".", $imagem);
    $ext = $ext[sizeof($ext) - 1];
    $arquivo_origem = $path . $imagem;
    $arquivo_destino = $path . "thumbnail" . $imagem;
    $nome_arquivo_destino = "thumbnail" . $imagem;

    if (strtolower($ext) == "jpg") {
        $img_origem = imagecreatefromjpeg($arquivo_origem);
    }
    if (strtolower($ext) == "gif") {
        $img_origem = imagecreatefromgif($arquivo_origem);
    }
    if (strtolower($ext) == "png") {
        $img_origem = imagecreatefrompng($arquivo_origem);
    }

    if (imagesx($img_origem) > $largura) {
        if (imagesx($img_origem) > imagesy($img_origem)) {
            $nova_largura = 100;
            $nova_altura = $nova_largura * imagesy($img_origem) / imagesx($img_origem);
        } else {
            $nova_altura = 75;
            $nova_largura = $nova_altura * imagesx($img_origem) / imagesy($img_origem);
        }
        if ($nova_largura > 350)
            $nova_largura = 350;
        $img_destino = imagecreatetruecolor($nova_largura, $nova_altura);
        imagecopyresampled($img_destino, $img_origem, 0, 0, 0, 0, $nova_largura, $nova_altura, imagesx($img_origem), imagesy($img_origem));

        if (strtolower($ext) == "jpg") {
            imageJPEG($img_destino, $arquivo_destino, 85);
        }
        if (strtolower($ext) == "gif") {
            imageGIF($img_destino, $arquivo_destino);
        }
        if (strtolower($ext) == "png") {
            imagePNG($img_destino, $arquivo_destino);
        }
    }

    return $nome_arquivo_destino;
}

function tamanhoImagem($imagem, $largura) {
    $tam_img = getimagesize($imagem);
    if ($tam_img[0] > $largura) {
        return false;
    } else {
        return true;
    }
}

function redimensionaImg($path, $imagem, $largura) {
    $ext = explode(".", $imagem);
    $ext = $ext[sizeof($ext) - 1];
    $arquivo_origem = $path . "/" . $imagem;
    $arquivo_destino = $arquivo_origem;
    $nome_arquivo_destino = $imagem;

    if (strtolower($ext) == "jpg") {
        $img_origem = imagecreatefromjpeg($arquivo_origem);
    }
    if (strtolower($ext) == "gif") {
        $img_origem = imagecreatefromgif($arquivo_origem);
    }
    if (strtolower($ext) == "png") {
        $img_origem = imagecreatefrompng($arquivo_origem);
    }

    if (imagesx($img_origem) > $largura) {
        $nova_largura = $largura;
        //$x = 100*$nova_largura / imagesx($img_origem);
        $nova_altura = $nova_largura * imagesy($img_origem) / imagesx($img_origem);
        $img_destino = imagecreatetruecolor($nova_largura, $nova_altura);
        imagecopyresampled($img_destino, $img_origem, 0, 0, 0, 0, $nova_largura, $nova_altura, imagesx($img_origem), imagesy($img_origem));

        if (strtolower($ext) == "jpg") {
            imageJPEG($img_destino, $arquivo_destino, 85);
        }
        if (strtolower($ext) == "gif") {
            imageGIF($img_destino, $arquivo_destino);
        }
        if (strtolower($ext) == "png") {
            imagePNG($img_destino, $arquivo_destino);
        }
    }

    return $nome_arquivo_destino;
}

//EXTRA*******************************************************************************


function is__writable($path) {
    if ($path{strlen($path) - 1} == '/')
        return is__writable($path . uniqid(mt_rand()) . '.tmp');

    if (file_exists($path)) {
        if (!($f = @fopen($path, 'r+')))
            return false;
        fclose($f);
        return true;
    }

    if (!($f = @fopen($path, 'w')))
        return false;
    fclose($f);
    unlink($path);
    return true;
}

$opcao = $_GET['opcao'];
$pastaArquivo = $_GET['pastaArquivo'];
$largura = $_GET['largura'];
$tipoArq = $_GET['tipoArq'];



if ($opcao == "1") {
    
    //ARMAZENA O ARQUIVO NO SERVIDOR
    $pastaArquivo = $_POST['pastaArquivo'];
    $largura = $_POST['largura'];
    $tipoArq = $_POST['tipoArq'];
    $permissao = is__writable($pastaArquivo . "/");
    if (!$permissao) {
        echo "<script type='text/javascript'>alert('A pasta está sem permissão de escrita.\\nFavor entrar em contato com o Administrador.');</script>";
        
    } else {
        if (($_FILES['arquivo']['name'] != "")) {
            if($_FILES['arquivo']['size'] == 0){
                    echo "<script type='text/javascript'>alert('Formato da Imagem Inválido!\\n ou tamanho máximo de 2 MB foi excedido!');</script>";
            }else{
                if ($_FILES['arquivo']['size'] > (2 * 1024 * 1024) ) {
                    echo "<script type='text/javascript'>alert('Tamanho máximo do arquivo excedido!\\nTamanho máximo permitido: 2 MB.');</script>";
                } else {

                    $nome_arquivo = $_FILES['arquivo']['name'];
                    $nome_arquivo = removeEspacosEmBranco($nome_arquivo);
                    $nome_arquivo = str_replace("[^a-zA-Z0-9_.]", "", strtr($nome_arquivo, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_"));
                    $ext = explode(".", $nome_arquivo);
                    $ext = "." . $ext[sizeof($ext) - 1];
                    if (trim($nome_arquivo) == $ext) {
                        $nome_arquivo = "arquivo_sem_nome" . $ext;
                    }
                    if (file_exists($pastaArquivo . "/" . $nome_arquivo)) {
                        $diretorio = opendir($pastaArquivo);
                        $arquivoTemp = $nome_arquivo;
                        //armazena os arquivos do diretório em um array
                        while (false !== ($arquivoDir = readdir($diretorio))) {
                            if ($arquivoDir != "." && $arquivoDir != ".." && $arquivoDir != "Thumbs.db") {
                                $vArquivoDir[] = strtolower($arquivoDir);
                            }
                        }
                        //varre o array de arquivos e gera uma cópia do arquivo
                        while (in_array(strtolower($arquivoTemp), $vArquivoDir)) {
                            $cont++;
                            $arquivoTemp = $cont . "-" . $nome_arquivo;
                        }
                        $nome_arquivo = $arquivoTemp;
                    }
                    $ext = explode(".", $nome_arquivo);
                    $ext = $ext[sizeof($ext) - 1];
                    $ext = strtolower($ext);
                    if ($tipoArq == "imagem") {
                        if ($ext == "jpg" || $ext == "png" || $ext == "gif") {
                            $path = $pastaArquivo . "/" . $nome_arquivo;
                            move_uploaded_file($_FILES['arquivo']['tmp_name'], $path);
                            geraThumb($pastaArquivo . "/", $nome_arquivo);
                            if (!tamanhoImagem($path, $largura)) {
                                redimensionaImg($pastaArquivo, $nome_arquivo, $largura);
                            }
                        } else {
                            echo "<script type='text/javascript'>alert('Formato da Imagem Inválido!\\nFormatos Válidos: JPG, GIF e JPG.');</script>";
                            $erro = true;
                        }
                        if (!$erro) {
                            echo "<script type='text/javascript'>window.opener.guardarDados(\"00»" . $nome_arquivo . "»" . "\"); window.parent.close();</script>";
                            exit();
                        }
                    } else if ($tipoArq == "arquivo") {
                        if ($ext != "exe" && $ext != "php") {
                            $path = $pastaArquivo . "/" . $nome_arquivo;
                            move_uploaded_file($_FILES['arquivo']['tmp_name'], $path);
                        } else {
                            echo "<script type='text/javascript'>alert('Formato do Arquivo Inválido!');</script>";
                            $erro = true;
                        }
                        if (!$erro) {
                            echo "<script type='text/javascript'>window.opener.guardarDados(\"00»" . $nome_arquivo . "»" . "\"); window.parent.close();</script>";
                            exit();
                        }
                    }
                }
                                
            }
        }
    }
} else if ($opcao == "2") {
    //APAGA O ARQUIVO DO SERVIDOR
    $arquivoExclusao = $_GET['arquivo'];
    if (!empty($arquivoExclusao)) {
        if (file_exists($pastaArquivo . "/" . $arquivoExclusao)) {
            unlink($pastaArquivo . "/" . $arquivoExclusao);
        }
        if (file_exists($pastaArquivo . "/thumbnail" . $arquivoExclusao)) {
            unlink($pastaArquivo . "/thumbnail" . $arquivoExclusao);
        }
    }
    //echo montaMensagemRetorno("13")."<script>fnExibeMsgRetorno();</script>";
    exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title></title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="css/reset.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/text.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/grid.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/layout.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="css/nav.css" media="screen" />
        <!--[if IE 6]><link rel="stylesheet" type="text/css" href="css/ie6.css" media="screen" /><![endif]-->
        <!--[if IE 7]><link rel="stylesheet" type="text/css" href="css/ie.css" media="screen" /><![endif]-->


        <link rel="shortcut icon" href="">
        <base target="_self">
        <script src="./assets/vendor/jquery/jquery-3.3.1.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            function critica_dados() {
                if (document.fUpload.arquivo.value == "") {
                    alert("Esqueceu de escolher o ARQUIVO.");
                    document.fUpload.arquivo.focus();
                    return;
                }
                document.fUpload.submit();
                
            }

            function fnCancela(){
                window.close();
            }

            $(document).ready(function() {			
                $('#arquivo').click();
                $('#arquivo').change(function() {
                    critica_dados(); 
                });
            });
			
        </script>
    </head>
    <body style="background-color:#2E5E79;"> <!-- width:300px;height:188px; -->
        <div class="container_12" style="margin-left:5px;width:480px;">
            <div class="clear"></div>
            <div class="grid_12" >
                <div class="box round first" >
                    <form action="popup-upload.php?opcao=1" method="post" name="fUpload" enctype="multipart/form-data" style="margin:0;">
                        <h2>Upload de Arquivo</h2>
                        <div class="block">
                            <table class="form">
                                <tr align="center">
                                    <td >
                                        <input name="pastaArquivo" type="hidden" value="<?php echo $pastaArquivo; ?>">
                                        <input name="largura" type="hidden" value="<?php echo $largura; ?>">
                                        <input name="tipoArq" type="hidden" value="<?php echo $tipoArq; ?>">
                                        <input name="arquivo" id="arquivo" type="file" class="" value="procurar" ><br />
                                    </td>                           
                                </tr>
                                <tr align="center">
                                    <td >
                                        <input type="button" class="btn btn-grey" value="enviar" onClick="critica_dados()" />
                                        <input type="button" class="btn btn-grey" value="cancelar" onClick="fnCancela()" />
                                    </td>                           
                                </tr>
                            </table>
                        </div>
                    </form>
                </div>
            </div> 
        </div>				
    </body>
</html>