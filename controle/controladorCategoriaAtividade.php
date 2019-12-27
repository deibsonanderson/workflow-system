<?php

class ControladorCategoriaAtividade extends ControladorBase {

	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

	
	public function listarCategoriaAtividade($id = null){
		try {
			$moduloCategoriaAtividade = new DaoCategoriaAtividade();
			$retorno = $moduloCategoriaAtividade->listarCategoriaAtividade($id,$this->getUsuarioLoginId());
			$moduloCategoriaAtividade->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}

	
	public function incluirCategoriaAtividade($post){
		try {
			$categoria = new CategoriaAtividade();
			$categoria->setNome($post["nome"]);
			$categoria->setStatus('1');
			
			$categoria->setUsuario($this->getUsuarioLogin());
			
			$moduloCategoriaAtividade = new DaoCategoriaAtividade();
			if($moduloCategoriaAtividade->incluirCategoriaAtividade($categoria)){
				return $this->telaCadastrarCategoriaAtividade();	
			}		
			$moduloCategoriaAtividade->__destruct();
		} catch (Exception $e) {
                    return $e;
		}
	}

	
	public function alterarCategoriaAtividade($post){
		try {
			$categoria = new CategoriaAtividade();
			$categoria->setId($post["id"]);
			$categoria->setNome($post["nome"]);
			$categoria->setStatus('1');
			
			$moduloCategoriaAtividade = new DaoCategoriaAtividade();
			if($moduloCategoriaAtividade->alterarCategoriaAtividade($categoria)){
				return $this->telaListarCategoriaAtividade();
			}
			$moduloCategoriaAtividade->__destruct();
		} catch (Exception $e) {
			return $e;
		} 
		
		
	}

	
	public function excluirCategoriaAtividade($post){
		try {
			return $this->excluirBase($post["id"], new DaoCategoriaAtividade(), 
					'excluirCategoriaAtividade', $this->telaListarCategoriaAtividade());
		} catch (Exception $e) {
			return $e;
		}
	}

	
	public function telaCadastrarCategoriaAtividade($post = null){
		try {
			$viewCategoriaAtividade = new ViewCategoriaAtividade();
			$post = null;
			$retorno = $viewCategoriaAtividade->telaCadastrarCategoriaAtividade($post);
			$viewCategoriaAtividade->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}
	
	
	public function telaListarCategoriaAtividade($post = null){
		try {
			$viewCategoriaAtividade = new ViewCategoriaAtividade();
			$post = null;
			$retorno =  $viewCategoriaAtividade->telaListarCategoriaAtividade($this->listarCategoriaAtividade($post));
			$viewCategoriaAtividade->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}
	
	
	public function telaAlterarCategoriaAtividade($post = null){
		try {
			$viewCategoriaAtividade = new ViewCategoriaAtividade();
			$retorno = $viewCategoriaAtividade->telaAlterarCategoriaAtividade($this->listarCategoriaAtividade($post["id"]));
			$viewCategoriaAtividade->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}

	
	public function telaVisualizarCategoriaAtividade($post = null){
		try {
			$viewCategoriaAtividade = new ViewCategoriaAtividade();
			return $viewCategoriaAtividade->telaVisualizarCategoriaAtividade($this->listarCategoriaAtividade($post["id"]));
			$viewCategoriaAtividade->__destruct();
		} catch (Exception $e) {
			return $e;
		}
	}

}
?>