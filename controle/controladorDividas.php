<?php
class ControladorDividas {
	//construtor
	public function __construct(){}
	//destruidor
	public function __destruct(){}
	
	public function listarDividas($id = null){
		try {
			$daoDividas = new DaoDividas();
			return $daoDividas->listarDividas($id);
			$daoDividas->__destruct();
		} catch (Exception $e) {
			return $e;
		}
	}
	
	public function incluirDividas($post){
		try {
			$dividas = new Dividas();
			$dividas->setDescricao($post["descricao"]);
			$dividas->setValor($post["valor"]);
			
			// Formata data se vier do datepicker (pt-br) ou deixa caso esteja em formato americano
			// Supondo que a view passa no formato americano ou pt-br dependendo do input
			$dividas->setDataInicial(desformataData($post["dataInicial"]));
			$dividas->setDataFinal(desformataData($post["dataFinal"]));
			
			$dividas->setStatus('1');
			// Exemplo de preenchimento de usuário se vier da sessão, mas o $post ou view podem não enviar.
			if(isset($_SESSION["login"])) {
				$dividas->setId_usuario($_SESSION["login"]->getId());
			}
			$daoDividas = new DaoDividas();
			if($daoDividas->incluirDividas($dividas)){
				return $this->telaCadastrarDividas();	
			}		
			$daoDividas->__destruct();
		} catch (Exception $e) {
            return $e;
		}
	}
	
	public function alterarDividas($post){
		try {
			$dividas = new Dividas();
			$dividas->setId($post["id"]);
			$dividas->setDescricao($post["descricao"]);
			$dividas->setValor($post["valor"]);
			$dividas->setDataInicial(desformataData($post["dataInicial"]));
			$dividas->setDataFinal(desformataData($post["dataFinal"]));
			$dividas->setStatus('1');		
			$daoDividas = new DaoDividas();
			if($daoDividas->alterarDividas($dividas)){
				return $this->telaListarDividas();
			}
			$daoDividas->__destruct();
		} catch (Exception $e) {
			return $e;
		} 
	}
	
	public function excluirDividas($post){
		try {
			$id = $post["id"];
			$daoDividas = new DaoDividas();
			$daoDividas->excluirDividas($id);
			$daoDividas->__destruct();
			return $this->telaListarDividas();
		} catch (Exception $e) {
			return $e;
		}
	}
		
	public function telaCadastrarDividas($post = null){
		try {
			$viewDividas = new ViewDividas();
			$post = null;
			$retorno = $viewDividas->telaCadastrarDividas($post);
			$viewDividas->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}
	
	public function telaListarDividas($post = null){
		try {
			$viewDividas = new ViewDividas();
			$retorno = $viewDividas->telaListarDividas($this->listarDividas(null));
			$viewDividas->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}
	
	public function telaAlterarDividas($post = null){
		try {
			$viewDividas = new ViewDividas();
			$retorno = $viewDividas->telaAlterarDividas($this->listarDividas($post["id"]));
			$viewDividas->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}
	public function telaVisualizarDividas($post = null){
		try {
			$viewDividas = new ViewDividas();
			$retorno = $viewDividas->telaVisualizarDividas($this->listarDividas($post["id"]));
			$viewDividas->__destruct();
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}
}
?>