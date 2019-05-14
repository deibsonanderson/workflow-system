<?php
class DaoModulo extends Dados{

	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

	public function listarModulo($id = null){
		try {	
			$retorno = array();
			$conexao = $this->ConectarBanco();
			$sql = "SELECT id,nome,status FROM tb_workflow_modulo WHERE status = '1' ";
			$sql .= ($id != null)?" AND id = ".$id:"";
			$query = mysqli_query($conexao,$sql) or die ('Erro na execução  do listar!');
			while($objetoModulo =  mysqli_fetch_object($query)){
				$modulo = new Modulo();
				$modulo->setId($objetoModulo->id);
				$modulo->setNome($objetoModulo->nome);				
				$modulo->setStatus($objetoModulo->status);
				
				$retorno[] = $modulo; 
			}
				$this->FecharBanco($conexao);
				return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}

	public function incluirModulo($modulo){
		try {	
			$conexao = $this->ConectarBanco();
			$sql = "INSERT INTO tb_workflow_modulo(nome,status) VALUES ('".$modulo->getNome()."','".$modulo->getStatus()."')";
			$retorno = mysqli_query($conexao,$sql) or die ('Erro na execução  do insert!');
			$this->FecharBanco($conexao);
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}

	public function alterarModulo($modulo){
		try {	
			$conexao = $this->ConectarBanco();
			$sql = "UPDATE tb_workflow_modulo SET nome = '".$modulo->getNome()."',status = '".$modulo->getStatus()."' WHERE id =".$modulo->getId()."";
			$retorno = mysqli_query($conexao,$sql) or die ('Erro na execução  do update!');
			$this->FecharBanco($conexao);
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}

	public function excluirModulo($id){
		try {
			$conexao = $this->ConectarBanco();
			
			$sql = "UPDATE tb_workflow_acao_usuario SET status = '0' WHERE id_classe IN (SELECT id FROM tb_workflow_classe WHERE id_modulo = ".$id.")";
			$retorno = mysqli_query($conexao,$sql) or die ('Erro na execução  do delet acao usuario empresa!');
						
			$sql = "UPDATE tb_workflow_classe SET status = '0' WHERE id_modulo = ".$id."";
			$retorno = mysqli_query($conexao,$sql) or die ('Erro na execução  do delet classe!');
			
			$sql = "UPDATE tb_workflow_modulo SET status = '0' WHERE id = ".$id."";
			$retorno = mysqli_query($conexao,$sql) or die ('Erro na execução  do delet modulo!');
			
			$this->FecharBanco($conexao);
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}

	}




}

?>