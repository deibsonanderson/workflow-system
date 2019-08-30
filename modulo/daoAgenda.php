<?php

class DaoAgenda extends Dados {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }

    public function listarAgenda($data = null, $ordem = null) {
        try {
            $retorno = array();
            $conexao = $this->ConectarBanco();
            $sql = "SELECT id,data,descricao,arquivo,ordem,ativo,link,status FROM tb_workflow_agenda WHERE status = '1' ";
            if ($_SESSION["login"]->getId()) {
                $sql .= " AND id_usuario = " . $_SESSION["login"]->getId() . "";
            }
            $sql .= ($data != null) ? " AND data = '" . $data . "'" : " ";
            if($ordem == null){
				$sql .= " ORDER BY data DESC ";
			}else{
				$sql .= " ORDER BY ordem ASC ";
			}
			//var_dump($sql);
			$query = mysqli_query($conexao,$sql) or die('Erro na execução  do listar!');
			while ($objetoAgenda = mysqli_fetch_object($query)) {
                $agenda = new Agenda();
                $agenda->setId($objetoAgenda->id);
                $agenda->setData($objetoAgenda->data);
                $agenda->setStatus($objetoAgenda->status);
                $agenda->setDescricao($objetoAgenda->descricao);
                $agenda->setArquivo($objetoAgenda->arquivo);
                $agenda->setOrdem($objetoAgenda->ordem);
				$agenda->setLink($objetoAgenda->link);
                $agenda->setAtivo($objetoAgenda->ativo);

                $retorno[] = $agenda;
            }

            $this->FecharBanco($conexao);
            return $retorno;
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
            $conexao = $this->ConectarBanco();
            $sql = " UPDATE tb_workflow_agenda SET ativo = '" . $agenda->getAtivo() . "' WHERE id = " . $agenda->getId() . "";
            $retorno = mysqli_query($conexao,$sql) or die('Erro na execução  do update tb_workflow_agenda!'.$sql);
            $this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function excluirAgenda($id) {
        try {
            $conexao = $this->ConectarBanco();

            $sql = "UPDATE tb_workflow_agenda SET status = '0' WHERE id = " . $id . "";
            $retorno = mysqli_query($conexao,$sql) or die('Erro na execução  do delet agenda!');

            $this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

}

?>