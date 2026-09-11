<?php

class Dividas{

	private $id;
	private $descricao;
	private $valor;
	private $dataInicial;
	private $dataFinal;
	private $status;
	private $id_usuario;

	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

	//Get And Sets
	public function getId(){
		return $this->id;
	}

	public function setId($id){
		if($id == ""){
			throw new Exception('Atributo id foi passado como nulo'); 
		}
		$this->id = $id;
	}

	public function getDescricao(){
		return $this->descricao;
	}

	public function setDescricao($descricao){
		if($descricao == ""){ 
             throw new Exception('Atributo descricao foi passado como nulo'); 
        }
		$this->descricao = $descricao;
	}
	
	public function getValor(){
		return $this->valor;
	}

	public function setValor($valor){
		$this->valor = $valor;
	}

	public function getDataInicial(){
		return $this->dataInicial;
	}

	public function setDataInicial($dataInicial){
		$this->dataInicial = $dataInicial;
	}

	public function getDataFinal(){
		return $this->dataFinal;
	}

	public function setDataFinal($dataFinal){
		$this->dataFinal = $dataFinal;
	}

	public function getStatus(){
		return $this->status;
	}

	public function setStatus($status){
		if($status == ""){ 
             throw new Exception('Atributo status foi passado como nulo'); 
        }
		$this->status = $status;
	}
	
	public function getId_usuario(){
		return $this->id_usuario;
	}

	public function setId_usuario($id_usuario){
		$this->id_usuario = $id_usuario;
	}
}
?>
