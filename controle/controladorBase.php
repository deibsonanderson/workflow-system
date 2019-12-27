<?php
abstract class ControladorBase {
	
	protected function excluirBase($id,$classeDao,$operacaoDao,$retornoView){
		$classeDao->$operacaoDao($id);
		$classeDao->__destruct();
		return $retornoView;
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