<?php
class BotaoLink {
	
	private $titulo;
	private $funcao;
	private $controlador;
	private $retorno;
	private $mensagem;
	private $acao;
	
	public function getTitulo() {
		return $this->titulo;
	}
	
	public function setTitulo($titulo) {
		$this->titulo = $titulo;
	}
	
	
	public function getFuncao() {
		return $this->funcao;
	}
	
	public function setFuncao($Funcao) {
		$this->funcao = $Funcao;
	}
	
	public function getControlador() {
		return $this->controlador;
	}
	
	public function setControlador($controlador) {
		$this->controlador = $controlador;
	}
	
	public function getRetorno() {
		return $this->retorno;
	}
	
	public function setRetorno($retorno) {
		$this->retorno = $retorno;
	}
	
	public function getMensagem() {
		return $this->mensagem;
	}
	
	public function setMensagem($mensagem) {
		$this->mensagem = $mensagem;
	}
	
	public function getAcao() {
		return $this->acao;
	}
	
	public function setAcao($acao) {
		$this->acao = $acao;
	}
}