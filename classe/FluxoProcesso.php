<?php

class FluxoProcesso {

    private $id;
    private $id_fluxo;
    private $atividade;
    private $status;
    private $ativo;
    private $atuante;
    private $processo;
    private $titulo;
    private $valor;
    private $propriedade;
    private $vencimento;
    private $outFlow;
    private $descricao;
    
    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function getAtividade() {
        return $this->atividade;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getAtivo() {
        return $this->ativo;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setAtividade($atividade) {
        $this->atividade = $atividade;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }
    
    public function getId_fluxo() {
        return $this->id_fluxo;
    }

    public function setId_fluxo($id_fluxo) {
        $this->id_fluxo = $id_fluxo;
    }

    public function getAtuante() {
        return $this->atuante;
    }

    public function setAtuante($atuante) {
        $this->atuante = $atuante;
    }

    public function getProcesso() {
        return $this->processo;
    }

    public function setProcesso($processo) {
        $this->processo = $processo;
    }

    public function getTitulo() {
    	return $this->titulo;
    }
    
    public function setTitulo($titulo) {
    	$this->titulo = $titulo;
    }
    
    public function getVencimento() {
    	return $this->vencimento;
    }
    
    public function setVencimento($vencimento) {
    	$this->vencimento = $vencimento;
    }
    
    public function getValor() {
    	return $this->valor;
    }
    
    public function setValor($valor) {
    	$this->valor = $valor;
    }
    
    public function getPropriedade() {
    	return $this->propriedade;
    }
    
    public function setPropriedade($propriedade) {
    	$this->propriedade = $propriedade;
    }
    
    public function getOutFlow() {
    	return $this->outFlow;
    }
    
    public function setOutFlow($outFlow) {
    	$this->outFlow = $outFlow;
    }
        
    public function getDescricao() {
    	return $this->descricao;
    }
    
    public function setDescricao($descricao) {
    	$this->descricao = $descricao;
    }

}

?>