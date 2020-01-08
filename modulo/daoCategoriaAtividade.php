<?php
class DaoCategoriaAtividade extends DaoBase {
	
	public function __construct(){}

	public function __destruct(){}
		
	public function listarCategoriaAtividade($id = null, $id_usuario = null) {
		try {
			return $this->executarQuery($this->sqlSelect(DaoBase::TABLE_CATEGORIA_ATIVIDADE, array('id', 'nome', 'status')).
					$this->montarIdUsuario($id_usuario).$this->montarId($id),'CategoriaAtividade');
		} catch ( Exception $e ) {
			return $e;
		}
	}
	
	public function incluirCategoriaAtividade($categoria){
		try {	
			return $this->executar("INSERT INTO ".DaoBase::TABLE_CATEGORIA_ATIVIDADE."(nome,status,id_usuario) VALUES ('".$categoria->getNome()."','1','".$categoria->getUsuario()->getId()."')");
		} catch (Exception $e) {
			return 'Erro na execução do insert CategoriaAtividade - error:'.$e;
		}
	}

	public function alterarCategoriaAtividade($categoria){
		try {	
			return $this->executar($this->sqlAtualizar(DaoBase::TABLE_CATEGORIA_ATIVIDADE, $categoria));
		} catch (Exception $e) {
			return $e;
		}
	}

	public function excluirCategoriaAtividade($id){
		try {
			return $this->executar($this->sqlExcluir(DaoBase::TABLE_CATEGORIA_ATIVIDADE, $id));
		} catch (Exception $e) {
			return $e;
		}
	}

}

?>