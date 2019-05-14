<?php

class Login{

	private $id;
	private $usuario;
	private $data;
	private $status;
	

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
			throw new Exception('Atributo Id foi passado como nulo'); 
		}
		$this->id = $id;
	}

	public function getUsuario(){
		return $this->usuario;
	}

	public function setUsuario($usuario){
		if($usuario == ""){ 
             throw new Exception('Atributo Usuario foi passado como nulo'); 
        }
		$this->usuario = $usuario;
	}
	
	
	public function getData(){
		return $this->data;
	}

	public function setData($data){
		if($usuario == ""){ 
             throw new Exception('Atributo Data foi passado como nulo'); 
        }
		$this->data = $data;
	}
	
	
	public function getStatus(){
		return $this->status;
	}

	public function setStatus($status){
		if($status == ""){ 
             throw new Exception('Atributo Status foi passado como nulo'); 
        }
		$this->status = $status;
	}
	
	
	
	
	
	
}
?>