<?php
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
unlink('file.zip');
 
if($_GET['files'] != null && count($_GET['files']) > 0){
    $path = 'arquivos/atividade/';
    
    $files = null;
    foreach ($_GET['files'] as $value) {
        $files[] = $path.$value;
    }   
    $zipname = 'file.zip';
    $zip = new ZipArchive;
    $zip->open($zipname, ZipArchive::CREATE);
    foreach ($files as $file) {
	  $zip->addFromString(basename($file), file_get_contents($file));
    }
    $zip->close();
    
}
header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$zipname);
header('Content-Length: ' . filesize($zipname));
readfile($zipname);
?>