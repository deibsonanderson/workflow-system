<?php

class ControladorUsuario {

	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

	public function listarUsuario($id = null){
		try {
			$moduloUsuario = new DaoUsuario();
			return $moduloUsuario->listarUsuario($id);
			$moduloUsuario->__destruct();
		} catch (Exception $e) {
			return $e;
		}
	}
	
	
	public function listarUsuarioLogin($id = null){
		try {
			$moduloUsuario = new DaoUsuario();
			return $moduloUsuario->listarUsuarioLogin($id);
			$moduloUsuario->__destruct();
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
			//$usuario->setEmpresa($post["empresa"]);			
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
			$usuario->setSenha(md5($post["senha"]));
			$usuario->setImagem($post["imagem"]);
			$usuario->setPerfil($post["perfil"]);			
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
			return $viewUsuario->telaCadastrarUsuario();
			$viewUsuario->__destruct();
		} catch (Exception $e) {
			return $e;
		}
	}
	
	public function telaListarUsuario($post = null){
		try {
			$viewUsuario = new ViewUsuario();
			return $viewUsuario->telaListarUsuario($this->listarUsuario(null));
			$viewUsuario->__destruct();
		} catch (Exception $e) {
			return $e;
		}
	}
	
	public function telaAlterarUsuario($post = null){
		try {
			$viewUsuario = new ViewUsuario();
			return $viewUsuario->telaAlterarUsuario($this->listarUsuario($post["id"]));
			$viewUsuario->__destruct();
		} catch (Exception $e) {
			return $e;
		}
	}
		
	public function telaVisualizarUsuario($post = null){
		try {
			$viewUsuario = new ViewUsuario();
			return $viewUsuario->telaVisualizarUsuario($this->listarUsuario($post["id"]));
			$viewUsuario->__destruct();
		} catch (Exception $e) {
			return $e;
		}
	}
		
}
?>