<?php

class ControladorClasse {

	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}
	

	public function listarClasse($id = null){
		try {
			$moduloClasse = new DaoClasse();
			
			$retorno = $moduloClasse->listarClasse($id);
			$moduloClasse->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}
	

	public function incluirClasse($post){
		try {
			$classe = new Classe();
			$classe->setNome($post["nome"]);
			$classe->setPerfil($post["perfil"]);
			$classe->setControlador($post["controlador_"]);
			$classe->setFuncao($post["funcao_"]);
			$classe->setModulo($post["modulo"]);			
            $classe->setStatus('1');
			$moduloClasse = new DaoClasse();
			
			if($moduloClasse->incluirClasse($classe)){
				return $this->telaCadastrarClasse();	
			}		
			$moduloClasse->__destruct();
		} catch (Exception $e) {
                    return $e;
		}
	}
	

	public function alterarClasse($post){
		try {
			$classe = new Classe();
			$classe->setId($post["id"]);
			$classe->setNome($post["nome"]);
			$classe->setPerfil($post["perfil"]);			
			$classe->setControlador($post["controlador_"]);
			$classe->setFuncao($post["funcao_"]);
			$classe->setModulo($post["modulo"]);
            $classe->setStatus('1');		
			$moduloClasse = new DaoClasse();
			if($moduloClasse->alterarClasse($classe)){
				return $this->telaListarClasse();
			}
			$moduloClasse->__destruct();
		} catch (Exception $e) {
			return $e;
		} 		
	}
	

	public function excluirClasse($post){
		try {
			$id = $post["id"];
			$moduloClasse = new DaoClasse();
			$moduloClasse->excluirClasse($id);
			$moduloClasse->__destruct();
			return $this->telaListarClasse();
		} catch (Exception $e) {
			return $e;
		}
	}

	public function telaCadastrarClasse($post = null){
		try {
			$viewClasse = new ViewClasse();
			$post = null;
			$retorno = $viewClasse->telaCadastrarClasse($post);
			$viewClasse->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}
	
	public function telaListarClasse($post = null){
		try {
			$viewClasse = new ViewClasse();
			$retorno = $viewClasse->telaListarClasse($this->listarClasse(null));
			$viewClasse->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}
	
	public function telaAlterarClasse($post = null){
		try {
			$viewClasse = new ViewClasse();
			$retorno = $viewClasse->telaAlterarClasse($this->listarClasse($post["id"]));
			$viewClasse->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}
	
	
	public function telaVisualizarClasse($post = null){
		try {
			$viewClasse = new ViewClasse();
			$retorno = $viewClasse->telaVisualizarClasse($this->listarClasse($post["id"]));
			$viewClasse->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}

}
?>