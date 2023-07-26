<?php

class ControladorUsuario {

	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

	public function listarUsuario($id = null){
		try {
			$moduloUsuario = new DaoUsuario();
			$retorno = $moduloUsuario->listarUsuario($id);
			$moduloUsuario->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}
	
	
	public function listarUsuarioLogin($id = null){
		try {
			$moduloUsuario = new DaoUsuario();
			$retorno = $moduloUsuario->listarUsuarioLogin($id);
			$moduloUsuario->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}

	public function incluirUsuario($post){
		try {
			$usuario = new Usuario();
			$usuario->setNome($post["nome"]);
			$usuario->setLogin($post["login"]);
			$usuario->setSenha(md5($post["senha"]));
			$usuario->setImagem($post["imagem"]);
			$usuario->setPerfil($post["perfil"]);			
						
			$usuario->setStatus('1');
			
			$moduloUsuario = new DaoUsuario();
			if($moduloUsuario->incluirUsuario($usuario)){
				return $this->telaCadastrarUsuario();	
			}		
			$moduloUsuario->__destruct();
		} catch (Exception $e) {
                    return $e;
		}
	}

	public function alterarUsuario($post){
		try {
			
			$usuario = new Usuario();
			$usuario->setId($post["id"]);
			$usuario->setNome($post["nome"]);
			$usuario->setLogin($post["login"]);
			$usuario->setPopup_vencimento($post["popup_vencimento"]);
			$usuario->setImagem($post["imagem"]);
			$usuario->setPerfil($post["perfil"]);
			$usuario->setClasse($post["classe"]);		
			$usuario->setStatus('1');
			
			$moduloUsuario = new DaoUsuario();
			if($moduloUsuario->alterarUsuario($usuario)){
				return $this->telaListarUsuario();
			}
			$moduloUsuario->__destruct();
		} catch (Exception $e) {
			return $e;
		} 
				
	}

	public function excluirUsuario($post){
		try {
			$id = $post["id"];
			$moduloUsuario = new DaoUsuario();
			$moduloUsuario->excluirUsuario($id);
			$moduloUsuario->__destruct();
			return $this->telaListarUsuario();
		} catch (Exception $e) {
			return $e;
		}
	}

	public function telaCadastrarUsuario($post = null){
		try {
			$viewUsuario = new ViewUsuario();
			$post = null;
			$retorno = $viewUsuario->telaCadastrarUsuario();
			$viewUsuario->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}
	
	public function telaListarUsuario($post = null){
		try {
			$viewUsuario = new ViewUsuario();
			$retorno = $viewUsuario->telaListarUsuario($this->listarUsuario(null));
			$viewUsuario->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}
	
	public function telaAlterarUsuario($post = null){
		try {
			$viewUsuario = new ViewUsuario();
			$retorno = $viewUsuario->telaAlterarUsuario($this->listarUsuario($post["id"]));
			$viewUsuario->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}
		
	public function telaVisualizarUsuario($post = null){
		try {
			$viewUsuario = new ViewUsuario();
			$retorno = $viewUsuario->telaVisualizarUsuario($this->listarUsuario($post["id"]));
			$viewUsuario->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}
	
	public function alterarSenhaUsuario($post){
		try {
			
			$usuario = new Usuario();
			$usuario->setId($post["id"]);
			$usuario->setSenha(md5($post["senha"]));
			
			$moduloUsuario = new DaoUsuario();
			if($moduloUsuario->alterarSenhaUsuario($usuario)){
				return $this->telaListarUsuario();
			}
			$moduloUsuario->__destruct();
		} catch (Exception $e) {
			return $e;
		} 
				
	}	
	
	public function telaAlterarSenhaUsuario($post = null){
		try {
			$viewUsuario = new ViewUsuario();
			$retorno = $viewUsuario->telaAlterarSenhaUsuario($this->listarUsuario($post["id"]));
			$viewUsuario->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}	
		
}
?>