<?php

class ProcessoSimplificado {

    private $id;
	private $descricao;
	private $titulo;
	private $data;	
	private $provisao;
    
	private $idTituloFluxo;
	private $tituloFluxo;
		
	private $totalValorAtividade;
	private $totalAtivo;    
	

    public function getId()
    {
        return $this->id;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getProvisao()
    {
        return $this->provisao;
    }

    public function getIdTituloFluxo()
    {
        return $this->idTituloFluxo;
    }

    public function getTituloFluxo()
    {
        return $this->tituloFluxo;
    }

    public function getTotalValorAtividade()
    {
        return $this->totalValorAtividade;
    }

    public function getTotalAtivo()
    {
        return $this->totalAtivo;
    }

  
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setProvisao($provisao)
    {
        $this->provisao = $provisao;
    }

    public function setIdTituloFluxo($idTituloFluxo)
    {
        $this->idTituloFluxo = $idTituloFluxo;
    }

    public function setTituloFluxo($tituloFluxo)
    {
        $this->tituloFluxo = $tituloFluxo;
    }

    public function setTotalValorAtividade($totalValorAtividade)
    {
        $this->totalValorAtividade = $totalValorAtividade;
    }

    public function setTotalAtivo($totalAtivo)
    {
        $this->totalAtivo = $totalAtivo;
    }

  
    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }

    
    

}

?>