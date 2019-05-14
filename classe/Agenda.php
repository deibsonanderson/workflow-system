<?php

class Agenda {

    private $id;
    private $descricao;
    private $data;
    private $ordem;
    private $status;
    private $link;
    private $arquivo;
    private $ativo;

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getData() {
        return $this->data;
    }

    public function getOrdem() {
        return $this->ordem;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function setOrdem($ordem) {
        $this->ordem = $ordem;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
    public function getLink() {
        return $this->link;
    }

    public function setLink($link) {
        $this->link = $link;
    }
    public function getAtivo() {
        return $this->ativo;
    }

    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    function getArquivo() {
        return $this->arquivo;
    }

    function setArquivo($arquivo) {
        $this->arquivo = $arquivo;
    }



}

?>