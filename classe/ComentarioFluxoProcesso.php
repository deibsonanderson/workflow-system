<?php
class ComentarioFluxoProcesso {
	
	private $id;
	private $descricao;
	private $status;
	private $arquivo;
	private $categoria;
	private $fluxoProcesso;
	private $data;
	private $processo;
	
	// construtor
	public function __construct() {
	}
	
	// destruidor
	public function __destruct() {
	}
	
	// Get And Sets
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getDescricao() {
		return $this->descricao;
	}
	
	public function getStatus() {
		return $this->status;
	}
	
	public function getFluxoProcesso() {
		return $this->fluxoProcesso;
	}
	
	public function setDescricao($descricao) {
		$this->descricao = $descricao;
	}
	
	public function setStatus($status) {
		$this->status = $status;
	}
	
	public function setFluxoProcesso($fluxoProcesso) {
		$this->fluxoProcesso = $fluxoProcesso;
	}
	
	public function getData() {
		return $this->data;
	}
	
	public function setData($data) {
		$this->data = $data;
	}
	function getArquivo() {
		return $this->arquivo;
	}
	function setArquivo($arquivo) {
		$this->arquivo = $arquivo;
	}
	
	public function getProcesso() {
		return $this->processo;
	}
	
	public function setProcesso($processo) {
		$this->processo = $processo;
	}
	
	public function getCategoria() {
		return $this->categoria;
	}
	
	public function setCategoria($categoria) {
		$this->categoria = $categoria;
	}
}
?>