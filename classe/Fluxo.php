<?php

class Fluxo{

	private $id;
	private $titulo;
	private $status;
    private $atividades;
    private $descricao;
	private $usuario;
	
	public function getUsuario() {
		return $this->usuario;
	}
	
	public function setUsuario($usuario) {
		$this->usuario = $usuario;
	}

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

	public function getTitulo(){
		return $this->titulo;
	}

	public function setTitulo($titulo){
		if($titulo == ""){ 
             throw new Exception('Atributo titulo foi passado como nulo'); 
        }
		$this->titulo = $titulo;
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
	
	function getAtividades() {
            return $this->atividades;
        }

        function setAtividades($atividades) {
            $this->atividades = $atividades;
        }


        public function getDescricao() {
            return $this->descricao;
        }

        public function setDescricao($descricao) {
            $this->descricao = $descricao;
        }


	
	
	
}
?>