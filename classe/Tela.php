<?php
class Tela {
	
	private $funcao;
	private $controlador;
	private $retorno;
	private $mensagem; 
	private $titulo;
	private $campos;
	private $botaoVoltar;
	
	
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
		$this->Funcao = $Funcao;
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
	
	public function getCampos() {
		return $this->campos;
	}
	
	public function setCampos($campos) {
		$this->campos = $campos;
	}
	
	public function getBotaoVoltar() {
		return $this->botaoVoltar;
	}
	
	public function setBotaoVoltar($botaoVoltar) {
		$this->botaoVoltar = $botaoVoltar;
	}
	
}
?>