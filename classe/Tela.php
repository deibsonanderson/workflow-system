<?php
class Tela {
	
	private $funcao;
	private $controlador;
	private $retorno;
	private $mensagem; 
	private $titulo;
	private $campos;
	private $botaoRedirect;
	private $botaoCadastrarAlterar;
	
	private $botaoListarAlterar;
	private $botaoListarExcluir;
	private $botaoListarVisualizar;
	
	
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
	
	public function getCampos() {
		return $this->campos;
	}
	
	public function setCampos($campos) {
		$this->campos = $campos;
	}
	
	public function getBotaoRedirect() {
		return $this->botaoRedirect;
	}
	
	public function setBotaoRedirect($botaoRedirect) {
		$this->botaoRedirect = $botaoRedirect;
	}
	
	public function getBotaoCadastrarAlterar() {
		return $this->botaoCadastrarAlterar;
	}
	
	public function setBotaoCadastrarAlterar($botaoCadastrarAlterar) {
		$this->botaoCadastrarAlterar = $botaoCadastrarAlterar;
	}

	public function getBotaoListarAlterar() {
		return $this->botaoListarAlterar;
	}
	
	public function setBotaoListarAlterar($botaoListarAlterar) {
		$this->botaoListarAlterar = $botaoListarAlterar;
	}
	
	public function getBotaoListarExcluir() {
		return $this->botaoListarExcluir;
	}
	
	public function setBotaoListarExcluir($botaoListarExcluir) {
		$this->botaoListarExcluir = $botaoListarExcluir;
	}
	
	public function getBotaoListarVisualizar() {
		return $this->botaoListarVisualizar;
	}
	
	public function setBotaoListarVisualizar($botaoListarVisualizar) {
		$this->botaoListarVisualizar = $botaoListarVisualizar;
	}
}
?>