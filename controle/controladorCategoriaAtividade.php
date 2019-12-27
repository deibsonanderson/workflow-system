<?php

class ControladorCategoriaAtividade extends ControladorBase {

	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

	
	public function listarCategoriaAtividade($id = null){
		try {
			$modulo = new DaoCategoriaAtividade();
			$retorno = $modulo->listarCategoriaAtividade($id,$this->getUsuarioLoginId());
			$modulo->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}
	
	public function incluirCategoriaAtividade($post){
		try {
			$categoria = $this->modelMapper($post, new CategoriaAtividade());
			$categoria->setUsuario($this->getUsuarioLogin());
			
			$modulo = new DaoCategoriaAtividade();
			if($modulo->incluirCategoriaAtividade($categoria)){
				return $this->telaCadastrarCategoriaAtividade();	
			}		
			$modulo->__destruct();
		} catch (Exception $e) {
            return $e;
		}
	}
	
	public function alterarCategoriaAtividade($post){
		try {
			$modulo = new DaoCategoriaAtividade();
			if($modulo->alterarCategoriaAtividade($this->modelMapper($post, new CategoriaAtividade()))){
				return $this->telaListarCategoriaAtividade();
			}
			$modulo->__destruct();
		} catch (Exception $e) {
			return $e;
		} 
	}
	
	public function excluirCategoriaAtividade($post){
		try {
			$this->excluirBase($post["id"], new DaoCategoriaAtividade(), 
					'excluirCategoriaAtividade');
			return $this->telaListarCategoriaAtividade();
		} catch (Exception $e) {
			return $e;
		}
	}
	
	public function telaCadastrarCategoriaAtividade($post = null){
		try {
			$view = new ViewCategoriaAtividade();
			$post = null;
			$retorno = $view->telaCadastrarCategoriaAtividade($post);
			$view->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}	
	
	public function telaListarCategoriaAtividade($post = null){
		try {
			$view = new ViewCategoriaAtividade();
			$post = null;
			$retorno =  $view->telaListarCategoriaAtividade($this->listarCategoriaAtividade($post));
			$view->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}	
	
	public function telaAlterarCategoriaAtividade($post = null){
		try {
			$view = new ViewCategoriaAtividade();
			$retorno = $view->telaAlterarCategoriaAtividade($this->listarCategoriaAtividade($post["id"]));
			$view->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}
	
	public function telaVisualizarCategoriaAtividade($post = null){
		try {
			$view = new ViewCategoriaAtividade();
			$retorno =  $view->telaVisualizarCategoriaAtividade($this->listarCategoriaAtividade($post["id"]));
			$view->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}

}
?>