<?php
class Campo {
	
	private $titulo;
	private $obrigatorio;
	
	public function getTitulo() {
		return $this->titulo;
	}
	
	public function setTitulo($titulo) {
		$this->titulo = $titulo;
	}
	
	public function getObrigatorio() {
		return $this->obrigatorio;
	}
	
	public function setObrigatorio($obrigatorio) {
		$this->obrigatorio = $obrigatorio;
	}
	
}
?>