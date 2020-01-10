<?php

class DaoFluxo extends DaoBase {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }

    public function listarFluxo($id = null, $id_usuario = null) {
        try {
        	return $this->executarQuery(
	        			$this->sqlSelect(DaoBase::TABLE_TITULO_FLUXO, array('id', 'titulo', 'descricao', 'status'), false).
	        			$this->montarIdUsuario($_SESSION["login"]->getId()).$this->montarId($id), 'Fluxo');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function listarFluxoAtividades($id_titulo_fluxo = null, $id_usuario = null) {
        try {
        	$sql = ($id_titulo_fluxo != null) ? " AND id_titulo_fluxo = " . $id_titulo_fluxo : "";
        	$sql .= ' ORDER BY wf.ordenacao ASC ';
        	$query = $this->executar("SELECT wf.id AS id_fluxo, wf.id_atividade, wa.fixa, wa.titulo, wf.status, wa.valor, wa.propriedade, wa.descricao AS atividade_descricao, wa.imagem
                    FROM tb_workflow_fluxo wf
                    INNER JOIN tb_workflow_atividade wa ON (wf.id_atividade = wa.id )
                    WHERE wf.status = '1' ".$this->montarIdUsuario($id_usuario,'wf').$sql);
            while ($objetoFluxoAtividade = mysqli_fetch_object($query)) {
          		$atividade = $this->modelMapper($objetoFluxoAtividade, new Atividade());
          		$atividade->setId($objetoFluxoAtividade->id_atividade);
                $atividade->setIdFluxo($objetoFluxoAtividade->id_fluxo);
                $atividade->setDescricao($objetoFluxoAtividade->atividade_descricao);

                $retorno[] = $atividade;
            }

            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function incluirFluxo($fluxo) {
        try {
            $conexao = $this->ConectarBanco();
            
            if($fluxo->getAtividades()){
            	$sql = "INSERT INTO tb_workflow_titulo_fluxo(titulo,descricao, id_usuario, status) VALUES ('" . $fluxo->getTitulo() . "','" . $fluxo->getDescricao() . "','" . $fluxo->getUsuario()->getId() . "', '" . $fluxo->getStatus() . "')";
                mysqli_query($conexao,$sql) or die('Erro na execução  do insert tb_workflow_titulo_fluxo!');
                sleep(1);
                $id_titulo_fluxo = mysqli_insert_id($conexao);
                $sql = "INSERT INTO `tb_workflow_fluxo` (
                                                                `id_atividade` ,
                                                                `id_titulo_fluxo` ,
                                                                `ordenacao` ,
																`id_usuario`,                                                                
																`status`
																)
                                                                VALUES ";

                $ordenacao = 1;
                foreach ($fluxo->getAtividades() as $atividades) {
                	$sql .= "( " . $atividades->getId() . ", " . $id_titulo_fluxo . ", '" . $ordenacao . "', '" . $fluxo->getUsuario()->getId() . "', 1 ),";
                    ++$ordenacao;
                }
                $sql_fluxo = substr($sql, 0, -1);
                $retorno = mysqli_query($conexao, $sql_fluxo) or die('Erro na execução  do insert tb_workflow_fluxo!');
            }else{
                die('Erro na execução  do insert tb_workflow_fluxo!');
            }
            $this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function excluirFluxo($id) {
        try {
        	return $this->executarMulti(
        			array($this->sqlExcluir(DaoBase::TABLE_TITULO_FLUXO, $id),
        					"UPDATE ".DaoBase::TABLE_FLUXO." SET status = '0' WHERE id_titulo_fluxo = $id")
        			);
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function listarDistinctFluxo() {
    	try {
    		return $this->executarQuery(
    				$this->sqlSelect(DaoBase::TABLE_TITULO_FLUXO, array('id', 'titulo'), true).
    				$this->montarIdUsuario($_SESSION["login"]->getId()),
    				'Fluxo');
    	} catch (Exception $e) {
    		return $e;
    	}
    }
}

?>