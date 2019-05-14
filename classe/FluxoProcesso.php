<?php

class FluxoProcesso {

    private $id;
    private $id_fluxo;
    private $atividade;
    private $status;
    private $ativo;
    private $atuante;
    private $processo;
    
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

    function getAtuante() {
        return $this->atuante;
    }

    function setAtuante($atuante) {
        $this->atuante = $atuante;
    }

    function getProcesso() {
        return $this->processo;
    }

    function setProcesso($processo) {
        $this->processo = $processo;
    }



}

?>