<?php  
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
$caminho = $_GET['d'];
$arquivo = $_GET['f'];
$file = $caminho."/".$arquivo;

if (file_exists($file)){
	header('Content-Type: application/save');
	header('Content-Length:'.filesize($file));
	header('Content-Disposition: attachment; filename="'.$arquivo.'"');
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Pragma: no-cache');
	
	// nesse momento ele le o arquivo e envia
	$fp = fopen("$file", "r");
	fpassthru($fp);
	fclose($fp);
} else {
	echo '<script>alert("O arquivo requisitado não foi encontrado neste servidor."); history.back();</script>';
}
?>