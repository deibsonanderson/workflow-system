<?php

class ControladorMain {

	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}


	public function listarAtividadesProcessosHaVencer(){
		$controladorProcesso = new ControladorProcesso();
		return $controladorProcesso->listarAtividadesProcessosHaVencer($_SESSION["login"]->getId());
	}
	
	
	public function telaListarAtividadesProcessosHaVencer() {
		try {
			$viewMain = new ViewMain();
			$retorno = $viewMain->telaListarAtividadesProcessosHaVencer($this->listarAtividadesProcessosHaVencer());
			$viewMain->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}
}
?>