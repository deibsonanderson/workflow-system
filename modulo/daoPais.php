<?php
class DaoPais extends Dados{

	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

	public function listarPais($id = null){
		try {
			$retorno = array();	
			$conexao = $this->ConectarBanco();
			$sql = "SELECT id,nome FROM tb_workflow_pais";
			$sql .= ($id != null)?" AND id = ".$id:"";
			$query = mysqli_query($conexao,$sql) or die ('Erro na execução dos dados!');
			while($objetoPais =  mysqli_fetch_object($query)){
				$pais = new Pais();
				$pais->setId($objetoPais->id);
				$pais->setNome($objetoPais->nome);
				$retorno[] = $pais; 
			}
				$this->FecharBanco($conexao);
				return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}


}

?>