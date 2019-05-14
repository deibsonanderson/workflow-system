<?php

class Acao{

	private $id;
	private $classe;
	private $usuario_empresa;
	private $status;
	private $perfil;
		

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

	

	public function getClasse(){
		return $this->classe;
	}

	public function setClasse($classe){
		if($classe == ""){ 
             throw new Exception('Atributo Classe foi passado como nulo'); 
        }
		$this->classe = $classe;
	}
	
	
	
	public function getUsuarioEmpresa(){
		return $this->usuario_empresa;
	}

	public function setUsuarioEmpresa($usuario_empresa){
		if($usuario_empresa == ""){ 
             throw new Exception('Atributo Usuario Empresa foi passado como nulo'); 
        }
		$this->usuario_empresa = $usuario_empresa;
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
	
	
	public function getPerfil(){
		return $this->perfil;
	}

	public function setPerfil($perfil){
		$this->perfil = $perfil;
	}
	
	
	
	
	
}
?>