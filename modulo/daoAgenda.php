<?php

class DaoAgenda extends DaoBase {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }

    public function listarAgenda($data = null, $ordem = null) {
        try {
        	$sqlOrdem = ($ordem == null)?" ORDER BY data DESC ":" ORDER BY ordem ASC ";
        	return $this->executarQuery(
        			$this->sqlSelect(DaoBase::TABLE_AGENDA, array('id', 'data','descricao','arquivo','ordem','ativo','link','status'), false).
        			$this->montarIdUsuario($_SESSION["login"]->getId()).$this->montarData($data).$sqlOrdem,
        			'Agenda');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function incluirAgenda($agenda) {
        try {
        	return $this->executar("INSERT INTO ".DaoBase::TABLE_AGENDA." (data,descricao,arquivo,ordem,id_usuario,ativo,link, status) VALUES ('" . $agenda->getData() . "','" . $agenda->getDescricao() . "','" . $agenda->getArquivo() . "','" . $this->recuperarMaiorOrder($agenda) . "','" . $_SESSION["login"]->getId() . "','1','" . $agenda->getLink() . "','" . $agenda->getStatus() . "')");
        } catch (Exception $e) {
            return $e;
        }
    }
    
    private function recuperarMaiorOrder($agenda){
    	$query_ordem = $this->executar("SELECT MAX(ordem) AS ordem FROM `".DaoBase::TABLE_AGENDA."` WHERE data = '" . $agenda->getData() . "'");
    	$max_ordem = "1";
    	while ($objetoModulo = mysqli_fetch_assoc($query_ordem)) {
    		if ($objetoModulo["ordem"] > 0) {
    			$max_ordem = $objetoModulo["ordem"];
    			++$max_ordem;
    		} 
    	}
    	return $max_ordem;
    }

    public function ordernarAgenda($agenda,$updateRecordsArray) {
        try {
        	$listingCounter = 1;
        	foreach ($updateRecordsArray as $recordIDValue) {
        		$this->executar(" UPDATE ".DaoBase::TABLE_AGENDA." SET ordem = '" . $listingCounter . "' WHERE id = " . $recordIDValue . " AND data = '" . $agenda->getData() . "'");
        		$listingCounter+= 1;
        	}
        	return $this->executar($sql);
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function alterarAgenda($agenda) {
        try {
        	return $this->executar($this->sqlAtualizarCustom(DaoBase::TABLE_AGENDA, $agenda, array('ativo')));
        } catch (Exception $e) {
            return $e;
        }
    }

    public function excluirAgenda($id) {
        try {
        	return $this->executar($this->sqlExcluir(DaoBase::TABLE_AGENDA, $id));
        } catch (Exception $e) {
            return $e;
        }
    }

}

?>