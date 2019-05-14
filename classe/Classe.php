<?php

class Classe{

	private $id;
	private $nome;
	private $status;
	private $modulo;
	private $perfil;
	private $controlador;
	private $funcao;
	private $acao;
        private $secao;

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
	
	
	public function getModulo(){
		return $this->modulo;
	}

	public function setModulo($modulo){
		$this->modulo = $modulo;
	}
	
	
	
	public function getPerfil(){
		return $this->perfil;
	}

	public function setPerfil($perfil){
		$this->perfil = $perfil;
	}
	
	
		
	public function getControlador(){
		return $this->controlador;
	}

	public function setControlador($controlador){
		$this->controlador = $controlador;
	}
	
	
		
	public function getFuncao(){
		return $this->funcao;
	}

	public function setFuncao($funcao){
		$this->funcao = $funcao;
	}
	

	public function getAcao(){
		return $this->acao;
	}

	public function setAcao($acao){
		$this->acao = $acao;
	}
	

	public function getSecao(){
		return $this->secao;
	}

	public function setSecao($secao){
		$this->secao = $secao;
	}	
	
}
?>