<?php
class DaoClasse extends DaoBase{

	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

	
	public function listarClasse($id = null){
		try {
			$query = $this->executar("SELECT c.id,c.nome,c.id_perfil,c.controlador,c.funcao,c.status,
					       c.id_modulo, m.nome as nome_modulo, m.status as status_modulo
					FROM tb_workflow_classe c INNER JOIN tb_workflow_modulo m ON (c.id_modulo = m.id)
					WHERE c.status = '1'".$this->montarId($id));
			while($objetoClasse =  mysqli_fetch_object($query)){
				$classe = $this->modelMapper($objetoClasse, new Classe());
				$classe->setPerfil($objetoClasse->id_perfil);
				
				$modulo = new Modulo();
				$modulo->setId($objetoClasse->id_modulo);
				$modulo->setNome($objetoClasse->nome_modulo);
				$modulo->setStatus($objetoClasse->status_modulo);
				$classe->setModulo($modulo);
				
				$retorno[] = $classe; 
			}
				return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}

	public function incluirClasse($classe){
		try {	
			return $this->executar("INSERT INTO ".DaoBase::TABLE_CLASSE."(nome,id_perfil,controlador,funcao,id_modulo,status) VALUES ('".$classe->getNome()."',2,'".$classe->getControlador()."','".$classe->getFuncao()."','".$classe->getModulo()."','".$classe->getStatus()."')");
		} catch (Exception $e) {
			return $e;
		}
	}

	public function alterarClasse($classe){
		try {	
			return $this->executar("UPDATE ".DaoBase::TABLE_CLASSE." SET nome = '".$classe->getNome()."', funcao = '".$classe->getFuncao()."', id_perfil = 2, controlador = '".$classe->getControlador()."', id_modulo = '".$classe->getModulo()."', status = '".$classe->getStatus()."' WHERE id =".$classe->getId());
		} catch (Exception $e) {
			return $e;
		}
	}

	public function excluirClasse($id){
		try {
			return $this->executarMulti(
					array($this->sqlExcluir(DaoBase::TABLE_CLASSE, $id),
						  "UPDATE ".DaoBase::TABLE_ACAO_USUARIO." SET status = '0' WHERE id_classe = $id"
					));
		} catch (Exception $e) {
			return $e;
		}

	}




}

?>