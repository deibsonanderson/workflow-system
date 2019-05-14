<?php

class ControladorModulo {

	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

	
	public function listarModulo($id = null){
		try {
			$moduloModulo = new DaoModulo();
			
			return $moduloModulo->listarModulo($id);
			$moduloModulo->__destruct();
		} catch (Exception $e) {
			return $e;
		}
	}

	
	public function incluirModulo($post){
		try {
			$modulo = new Modulo();
			$modulo->setNome($post["nome"]);
			$modulo->setStatus('1');
			$moduloModulo = new DaoModulo();
			
			if($moduloModulo->incluirModulo($modulo)){
				return $this->telaCadastrarModulo();	
			}		
			$moduloModulo->__destruct();
		} catch (Exception $e) {
                    return $e;
		}
	}

	
	public function alterarModulo($post){
		try {
			$modulo = new Modulo();
			$modulo->setId($post["id"]);
			$modulo->setNome($post["nome"]);
			$modulo->setStatus('1');		
			$moduloModulo = new DaoModulo();
			if($moduloModulo->alterarModulo($modulo)){
				return $this->telaListarModulo();
			}
			$moduloModulo->__destruct();
		} catch (Exception $e) {
			return $e;
		} 
		
		
	}

	
	public function excluirModulo($post){
		try {
			$id = $post["id"];
			$moduloModulo = new DaoModulo();
			$moduloModulo->excluirModulo($id);
			$moduloModulo->__destruct();
			return $this->telaListarModulo();
		} catch (Exception $e) {
			return $e;
		}
	}

	
	public function telaCadastrarModulo($post = null){
		try {
			$viewModulo = new ViewModulo();
			return $viewModulo->telaCadastrarModulo($post);
			$viewModulo->__destruct();
		} catch (Exception $e) {
			return $e;
		}
	}
	
	
	public function telaListarModulo($post = null){
		try {
			$viewModulo = new ViewModulo();
			return $viewModulo->telaListarModulo($this->listarModulo(null));
			$viewModulo->__destruct();
		} catch (Exception $e) {
			return $e;
		}
	}
	
	
	public function telaAlterarModulo($post = null){
		try {
			$viewModulo = new ViewModulo();
			return $viewModulo->telaAlterarModulo($this->listarModulo($post["id"]));
			$viewModulo->__destruct();
		} catch (Exception $e) {
			return $e;
		}
	}

	
	public function telaVisualizarModulo($post = null){
		try {
			$viewModulo = new ViewModulo();
			return $viewModulo->telaVisualizarModulo($this->listarModulo($post["id"]));
			$viewModulo->__destruct();
		} catch (Exception $e) {
			return $e;
		}
	}

}
?>