<?php

class Atividade {

    private $id;
    private $titulo;
    private $status;
    private $idFluxo;
    private $descricao;
    private $imagem;
    private $link;
    private $arquivo;
    private $valor;
    private $propriedade;
    private $categoria;
    private $usuario;
    private $vencimento;
    
    public function getUsuario() {
    	return $this->usuario;
    }
    
    public function setUsuario($usuario) {
    	$this->usuario = $usuario;
    }
    
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

    public function getTitulo() {
        return $this->titulo;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
    
    public function getIdFluxo() {
        return $this->idFluxo;
    }

    public function setIdFluxo($idFluxo) {
        $this->idFluxo = $idFluxo;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getImagem() {
        return $this->imagem;
    }

    public function getArquivo() {
        return $this->arquivo;
    }

    public function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    public function setArquivo($arquivo) {
        $this->arquivo = $arquivo;
    }

    public function getLink() {
        return $this->link;
    }

    public function setLink($link) {
        $this->link = $link;
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

    public function getCategoria() {
    	return $this->categoria;
    }
    
    public function setCategoria($categoria) {
    	$this->categoria = $categoria;
    }
        
    public function getVencimento() {
    	return $this->vencimento;
    }
    
    public function setVencimento($vencimento) {
    	$this->vencimento = $vencimento;
    }
}

?>