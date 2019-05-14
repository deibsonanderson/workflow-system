<?php

class ControladorCategoriaAtividade {

	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

	
	public function listarCategoriaAtividade($id = null){
		try {
			$moduloCategoriaAtividade = new DaoCategoriaAtividade();
			return $moduloCategoriaAtividade->listarCategoriaAtividade($id,$_SESSION["login"]->getId());
			$moduloCategoriaAtividade->__destruct();
		} catch (Exception $e) {
			return $e;
		}
	}

	
	public function incluirCategoriaAtividade($post){
		try {
			$categoria = new CategoriaAtividade();
			$categoria->setNome($post["nome"]);
			$categoria->setStatus('1');
			
			$usuario = new Usuario();
			$usuario->setId($_SESSION["login"]->getId());
			$categoria->setUsuario($usuario);
			
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
			
			$usuario = new Usuario();
			$usuario->setId($_SESSION["login"]->getId());
			$categoria->setUsuario($usuario);
			
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
			$id = $post["id"];
			$moduloCategoriaAtividade = new DaoCategoriaAtividade();
			$moduloCategoriaAtividade->excluirCategoriaAtividade($id);
			$moduloCategoriaAtividade->__destruct();
			return $this->telaListarCategoriaAtividade();
		} catch (Exception $e) {
			return $e;
		}
	}

	
	public function telaCadastrarCategoriaAtividade($post = null){
		try {
			$viewCategoriaAtividade = new ViewCategoriaAtividade();
			return $viewCategoriaAtividade->telaCadastrarCategoriaAtividade($post);
			$viewCategoriaAtividade->__destruct();
		} catch (Exception $e) {
			return $e;
		}
	}
	
	
	public function telaListarCategoriaAtividade($post = null){
		try {
			$viewCategoriaAtividade = new ViewCategoriaAtividade();
			return $viewCategoriaAtividade->telaListarCategoriaAtividade($this->listarCategoriaAtividade(null));
			$viewCategoriaAtividade->__destruct();
		} catch (Exception $e) {
			return $e;
		}
	}
	
	
	public function telaAlterarCategoriaAtividade($post = null){
		try {
			$viewCategoriaAtividade = new ViewCategoriaAtividade();
			return $viewCategoriaAtividade->telaAlterarCategoriaAtividade($this->listarCategoriaAtividade($post["id"]));
			$viewCategoriaAtividade->__destruct();
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