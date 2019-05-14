<?php
class DaoCategoriaAtividade extends Dados{

	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

	public function listarCategoriaAtividade($id = null, $id_usuario = null){
		try {	
			$retorno = array();
			$conexao = $this->ConectarBanco();
			$sql = "SELECT id, nome, status FROM tb_workflow_categoria_atividade WHERE status = '1' ";
			$sql .= ($id_usuario != null) ? " AND id_usuario = " . $id_usuario : "";
			$sql .= ($id != null)?" AND id = ".$id:"";
			$query = mysqli_query($conexao,$sql) or die ('Erro na execução  do listar!');
			while($objetoCategoriaAtividade =  mysqli_fetch_object($query)){
				$categoria = new CategoriaAtividade();
				$categoria->setId($objetoCategoriaAtividade->id);
				$categoria->setNome($objetoCategoriaAtividade->nome);				
				$categoria->setStatus($objetoCategoriaAtividade->status);
				
				$retorno[] = $categoria; 
			}
				$this->FecharBanco($conexao);
				return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}

	public function incluirCategoriaAtividade($categoria){
		try {	
			$conexao = $this->ConectarBanco();
			$sql = "INSERT INTO tb_workflow_categoria_atividade(nome,status,id_usuario) VALUES ('".$categoria->getNome()."','".$categoria->getStatus()."','".$categoria->getUsuario()->getId()."')";
			$retorno = mysqli_query($conexao,$sql) or die ('Erro na execução  do insert!');
			$this->FecharBanco($conexao);
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}

	public function alterarCategoriaAtividade($categoria){
		try {	
			$conexao = $this->ConectarBanco();
			$sql = "UPDATE tb_workflow_categoria_atividade SET nome = '".$categoria->getNome()."',status = '".$categoria->getStatus()."' WHERE id =".$categoria->getId()."";
			$retorno = mysqli_query($conexao,$sql) or die ('Erro na execução  do update!');
			$this->FecharBanco($conexao);
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}

	public function excluirCategoriaAtividade($id){
		try {
			$conexao = $this->ConectarBanco();
			
			//$sql = "UPDATE tb_workflow_atividade SET status = '0' WHERE id_modulo = ".$id."";
			//$retorno = mysqli_query($conexao,$sql) or die ('Erro na execução  do delet classe!');
			
			$sql = "UPDATE tb_workflow_categoria_atividade SET status = '0' WHERE id = ".$id."";
			$retorno = mysqli_query($conexao,$sql) or die ('Erro na execução  do delet modulo!');
			
			$this->FecharBanco($conexao);
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}

	}




}

?>