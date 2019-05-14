<?php

class Modulo{

	private $id;
	private $nome;
	private $status;
	private $classe;


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

	public function getNome(){
		return $this->nome;
	}

	public function setNome($nome){
		if($nome == ""){ 
             throw new Exception('Atributo nome foi passado como nulo'); 
        }
		$this->nome = $nome;
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
	
	
	public function getClasse(){
		return $this->classe;
	}

	public function setClasse($classe){
		if($classe == ""){ 
             throw new Exception('Atributo Classe foi passado como nulo'); 
        }
		$this->classe = $classe;
	}
	
	
	
}
?>