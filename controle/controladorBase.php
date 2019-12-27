<?php
abstract class ControladorBase {
	
	protected function excluirBase($id,$classeDao,$operacaoDao){
		$classeDao->$operacaoDao($id);
		$classeDao->__destruct();
	}
	
	protected function listarBase($id, $classeDao, $operacaoDao){
		$retorno = $classeDao->$operacaoDao($id);
		$classeDao->__destruct();
		return $retorno;
	}

	protected function listarBaseComLoginId($id, $classeDao, $operacaoDao){
		$retorno = $classeDao->$operacaoDao($id, $this->getUsuarioLoginId());
		$classeDao->__destruct();
		return $retorno;
	}	
	
	protected function modelMapper($post, $destino){
		foreach($post as $chave => $valor) {
			$set = 'set'.ucfirst($chave);
			if(method_exists($destino, $set)){
				$destino->$set($valor);
			}
		}
		return $destino;
	}
	
	protected  function getUsuarioLoginId(){
		$usuario = new Usuario();
		$usuario->setId($_SESSION["login"]->getId());
		return $usuario->getId();
	}
	
	protected  function getUsuarioLogin(){
		$usuario = new Usuario();
		$usuario->setId($_SESSION["login"]->getId());
		return $usuario;
	}
}