<?php
class Usuario{
	
	private $id;
	private $nome;
	private $imagem;
	private $login;
	private $senha;
	//private $empresa;
	private $status;
	private $perfil;
	private $popup_vencimento;
	private $classe;
	
	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

	
	
	
	function setId($id){
		if($id == ""){ 
			throw new Exception('Atributo nome foi passado como nulo'); 
		}
		$this->id = $id;
		
	}
	
	function getId(){
		return $this->id;
	}
	
	function setNome($nome){
		if($nome == ""){ 
             throw new Exception('Atributo nome foi passado como nulo'); 
        }
        $this->nome = $nome;	
	}
	
	function getNome(){
		return $this->nome;
	}
	
	function setClasse($classe){
	    $this->classe = $classe;	
	}
	
	function getClasse(){
		return $this->classe;
	}
	
	function setLogin($login){
		if($login == ""){
			throw new Exception('Atributo login foi passado como nulo');
		}
		$this->login = $login;
	}
	
	function getLogin(){
		return $this->login;
	}
	
	function setSenha($senha){
		if($senha == ""){
			throw new Exception('Atributo senha foi passado como nulo');
		}
		$this->senha = $senha;
	}
	
	function getSenha(){
		return $this->senha;
	}
	
//	function setEmpresa($empresa){
//		if($empresa == ""){
//			throw new Exception('Atributo empresa foi passado como nulo');
//		} 
//		$this->empresa = $empresa;
//	}
//	
//	function getEmpresa(){
//		return $this->empresa;
//	}
	
	function setImagem($imagem){
		$this->imagem = $imagem;
	}
	
	function getImagem(){
		return $this->imagem;
	}
	
	function setStatus($status){
		if($status == ""){
			throw new Exception('Atributo status foi passado como nulo');
		}
		$this->status = $status;
	}
	
	function getStatus(){
		return $this->status;
	}
	
	
	function setPerfil($perfil){
		$this->perfil = $perfil;
	}
	
	function getPerfil(){
		return $this->perfil;
	}
	
	function setPopup_vencimento($popup_vencimento){
		$this->popup_vencimento = $popup_vencimento;
	}
	
	function getPopup_vencimento(){
		return $this->popup_vencimento;
	}
}
?>