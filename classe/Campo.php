<?php
class Campo {
	
	private $titulo;
	private $nome;
	private $atributo;
	private $tipo;
	private $obrigatorio;
	private $upperCase;
	
	private $controlador;
	private $funcao;
	
	public function getTitulo() {
		return $this->titulo;
	}
	
	public function setTitulo($titulo) {
		$this->titulo = $titulo;
	}
	
	public function getNome() {
		return $this->nome;
	}
	
	public function setNome($nome) {
		$this->nome = $nome;
	}
	
	public function getTipo() {
		return $this->tipo;
	}
	
	public function setTipo($tipo) {
		$this->tipo = $tipo;
	}
	
	public function getObrigatorio() {
		return $this->obrigatorio;
	}
	
	public function setObrigatorio($obrigatorio) {
		$this->obrigatorio = $obrigatorio;
	}
	
	public function getUpperCase() {
		return $this->upperCase;
	}
	
	public function setUpperCase($upperCase) {
		$this->upperCase = $upperCase;
	}
	
	public function getAtribudo() {
		return $this->atributo;
	}
	
	public function setAtributo($atributo) {
		$this->atributo = $atributo;
	}
	
	
	public function getControlador() {
		return $this->controlador;
	}
	
	public function setControlador($controlador) {
		$this->controlador = $controlador;
	}
		
	public function getFuncao() {
		return $this->funcao;
	}
	
	public function setFuncao($funcao) {
		$this->funcao = $funcao;
	}
}
?>