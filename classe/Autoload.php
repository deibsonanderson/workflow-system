<?php
session_start();
function __autoload($classe){

	if(file_exists("../classe/".$classe.".php")){
		include_once("../classe/".$classe.".php");
	}elseif(file_exists("./classe/".$classe.".php")){
		include_once("./classe/".$classe.".php");
	}
	
	if(file_exists("../controle/".$classe.".php")){
		include_once("../controle/".$classe.".php");
	}elseif(file_exists("./controle/".$classe.".php")){
		include_once("./controle/".$classe.".php");
	}
	
	if(file_exists("../interface/".$classe.".php")){
		include_once("../interface/".$classe.".php");
	}elseif(file_exists("./interface/".$classe.".php")){
		include_once("./interface/".$classe.".php");
	}
	
	if(file_exists("../view/".$classe.".php")){
		include_once("../view/".$classe.".php");
	}elseif(file_exists("./view/".$classe.".php")){
		include_once("./view/".$classe.".php");
	}

	if(file_exists("../modulo/".$classe.".php")){
		include_once("../modulo/".$classe.".php");
	}elseif(file_exists("./modulo/".$classe.".php")){
		include_once("./modulo/".$classe.".php");
	}	
	
}

	function debug($valor, $notDie=false){
		echo "<pre>";
		var_dump($valor);
		if(!$notDie) die();
	}
?>