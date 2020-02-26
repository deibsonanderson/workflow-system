<?php
class Campo {
	
	private $titulo;
	private $nome;
	private $tipo;
	private $obrigatorio;
	private $upperCase;
	
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
}
?>