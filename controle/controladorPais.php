<?php

class ControladorPais {

	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

	public function listarPais($id = null){
		try {
			$modulo_pais = new DaoPais();
			$retorno = $modulo_pais->listarPais($id);
			$modulo_pais->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}


	

}
?>