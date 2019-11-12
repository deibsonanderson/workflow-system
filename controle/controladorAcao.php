<?php

class ControladorAcao {

	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

		
	
	public function listarClasseAcao($post = null){
		try {
			$modoloAcao = new DaoAcao();
			$retorno = $modoloAcao->listarClasseAcao($post);
			$modoloAcao->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		};
	}

	
	public function listarClasseAcaoParaMenu($post = null){
		try {
			$modoloAcao = new DaoAcao();
			$retorno =  $modoloAcao->listarClasseAcaoParaMenu($post);
			$modoloAcao->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}
	
        
	public function incluirClasseAcao($post){
		try {
			
			
			$usuario = new Usuario();
			$usuario->setId($post["usuario"]);
			
			unset($post["usuario"]);
			
			$moduloAcao = new DaoAcao();			
			if($moduloAcao->incluirClasseAcao($usuario,$post)){
				return "<script>javascript:open('main.php', '_top');</script>";
			}		
			$moduloAcao->__destruct();			
			
		} catch (Exception $e) {
                    return $e;
		}
	}
	
	
	public function telaListarAcao($post = null){
		try {
			$controladorUsuario = new ControladorUsuario();
			$objUsuario = $controladorUsuario->listarUsuario($post["id"]);
			$controladorUsuario->__destruct();
			
            $viewAcao = new ViewAcao();
            $retorno =  $viewAcao->telaListarAcao($this->listarClasseAcao($objUsuario[0]),$objUsuario);
			$viewAcao->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}	
	
	
        //Serve para verificar o tipo do perfil Acao
	public function retornaPerfilClasseAcao($post = null,$acao){
		try {
			$modoloAcao = new DaoAcao();
			return $modoloAcao->retornaPerfilClasseAcao($post,$acao);
			$modoloAcao->__destruct();
		} catch (Exception $e) {
			return $e;
		};
	}
}
?>