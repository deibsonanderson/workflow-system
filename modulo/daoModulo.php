<?php
class DaoModulo extends DaoBase{

	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

	public function listarModulo($id = null){
		try {
			return $this->executarQuery(
					$this->sqlSelect(DaoBase::TABLE_MODULO, array('id', 'nome', 'status'), false).$this->montarId($id),
					'Modulo');
		} catch (Exception $e) {
			return $e;
		}
	}

	public function incluirModulo($modulo){
		try {
			return $this->executar($this->sqlInserir(DaoBase::TABLE_MODULO, $modulo));
		} catch (Exception $e) {
			return $e;
		}
	}

	public function alterarModulo($modulo){
		try {	
			return $this->executar($this->sqlAtualizar(DaoBase::TABLE_MODULO, $modulo));
		} catch (Exception $e) {
			return $e;
		}
	}

	public function excluirModulo($id){
		try {
			return $this->executarMulti(
					array("UPDATE ".DaoBase::TABLE_ACAO_USUARIO." SET status = '0' WHERE id_classe IN (SELECT id FROM tb_workflow_classe WHERE id_modulo = $id)", 
							"UPDATE ".DaoBase::TABLE_CLASSE." SET status = '0' WHERE id_modulo = $id", 
						  $this->sqlExcluir(DaoBase::TABLE_MODULO, $id))
					);
		} catch (Exception $e) {
			return $e;
		}
	}




}

?>