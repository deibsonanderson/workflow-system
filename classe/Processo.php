<?php

class Processo {

    private $id;
    private $usuario;
    private $fluxo;
    private $descricao;
    private $data;
    private $status;
    private $fluxoProcesso;
	private $titulo;
	private $provisao;
    
    
    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }

    //Get And Sets
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
    public function getUsuario() {
        return $this->usuario;
    }

    public function getFluxo() {
        return $this->fluxo;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getData() {
        return $this->data;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setFluxo($fluxo) {
        $this->fluxo = $fluxo;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setData($data) {
        $this->data = $data;
    }
    
    public function getFluxoProcesso() {
        return $this->fluxoProcesso;
    }

    public function setFluxoProcesso($fluxoProcesso) {
        $this->fluxoProcesso = $fluxoProcesso;
    }
	
	public function getTitulo() {
        return $this->titulo;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function getProvisao() {
    	return $this->provisao;
    }
    
    public function setProvisao($provisao) {
    	$this->provisao = $provisao;
    }

}

?>