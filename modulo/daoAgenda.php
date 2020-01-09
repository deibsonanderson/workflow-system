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
            $conexao = $this->ConectarBanco();

            $sql_ordem = "SELECT MAX(ordem) AS ordem FROM `tb_workflow_agenda` WHERE data = '" . $agenda->getData() . "'";
            $query_ordem = mysqli_query($conexao, $sql_ordem) or die('Erro na execução  do cad!');

            while ($objetoModulo = mysqli_fetch_assoc($query_ordem)) {
                if ($objetoModulo["ordem"] > 0) {
                    $max_ordem = $objetoModulo["ordem"];
                    ++$max_ordem;
                } else {
                    $max_ordem = "1";
                }
            }
            $sql = "INSERT INTO tb_workflow_agenda(data,descricao,arquivo,ordem,id_usuario,ativo,link, status) VALUES ('" . $agenda->getData() . "','" . $agenda->getDescricao() . "','" . $agenda->getArquivo() . "','" . $max_ordem . "','" . $_SESSION["login"]->getId() . "','1','" . $agenda->getLink() . "','" . $agenda->getStatus() . "')";
            $retorno = mysqli_query($conexao,$sql) or die('Erro na execução  do insert!');

            $this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function ordernarAgenda($agenda,$updateRecordsArray) {
        try {
            $conexao = $this->ConectarBanco();
            $listingCounter = 1;
            $sql = "";
            foreach ($updateRecordsArray as $recordIDValue) {
                $sql = " UPDATE tb_workflow_agenda SET ordem = '" . $listingCounter . "' WHERE id = " . $recordIDValue . " AND data = '" . $agenda->getData() . "'";
                $retorno = mysqli_query($conexao,$sql) or die('Erro na execução  do update tb_workflow_agenda!'.$sql);
                $listingCounter = $listingCounter + 1;
            }
            $this->FecharBanco($conexao);
            return $retorno;
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