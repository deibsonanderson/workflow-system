<?php
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
require_once 'include.php';

$c = new Controlador();

class Controlador {
	
	public $funcao;
	public $controlador;
	
	public function __construct() {		
		$funcao = $_POST["funcao"];
		$controlador = $_POST["controlador"];

		
		unset($_POST["funcao"]);
		unset($_POST["controlador"]);
		unset($_POST["retorno"]);
		unset($_POST["mensagem"]);
		
		$this->chamarControle($_POST,$funcao,$controlador);		
	} 
	
		
	private function chamarControle($post,$funcao,$controlador){
		try {
			$class = new $controlador();
			echo $class->$funcao($post);
		} catch (Exception $e) {
			echo $e;
		}
	} 	
	
}
?>