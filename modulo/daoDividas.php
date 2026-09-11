<?php
class DaoDividas extends DaoBase{

	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

	public function listarDividas($id = null){
		try {
			return $this->executarQuery(
					$this->sqlSelect(DaoBase::TABLE_DIVIDAS, array('id', 'descricao', 'valor', 'dataInicial', 'dataFinal', 'status', 'id_usuario'), false).$this->montarId($id),
					'Dividas');
		} catch (Exception $e) {
			return $e;
		}
	}

	public function incluirDividas($dividas){
		try {
			return $this->executar($this->sqlInserir(DaoBase::TABLE_DIVIDAS, $dividas));
		} catch (Exception $e) {
			return $e;
		}
	}

	public function alterarDividas($dividas){
		try {	
			return $this->executar($this->sqlAtualizar(DaoBase::TABLE_DIVIDAS, $dividas));
		} catch (Exception $e) {
			return $e;
		}
	}

	public function excluirDividas($id){
		try {
			return $this->executar($this->sqlExcluir(DaoBase::TABLE_DIVIDAS, $id));
		} catch (Exception $e) {
			return $e;
		}
	}
}

?>
