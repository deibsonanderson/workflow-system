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
            $retorno = array();
            $conexao = $this->ConectarBanco();
            $sql = "SELECT id,titulo,descricao,status FROM tb_workflow_titulo_fluxo WHERE status = '1' ";
			$sql .= ($id_usuario != null) ? " AND id_usuario = " . $id_usuario : "";
            $sql .= ($id != null) ? " AND id = " . $id : "";
            
            $query = mysqli_query($conexao,$sql) or die('Erro na execução  do listar tb_workflow_titulo_fluxo!');
            while ($objetoFluxo = mysqli_fetch_object($query)) {
                $fluxo = new Fluxo();
                $fluxo->setId($objetoFluxo->id);
                $fluxo->setTitulo($objetoFluxo->titulo);
                $fluxo->setDescricao($objetoFluxo->descricao);
                $fluxo->setStatus($objetoFluxo->status);
                $retorno[] = $fluxo;
            }
            $this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function listarFluxoAtividades($id_titulo_fluxo = null, $id_usuario = null) {
        try {
            $retorno = array();
            $conexao = $this->ConectarBanco();
            $sql = "SELECT wf.id AS id_fluxo, wf.id_atividade, wa.fixa, wa.titulo, wf.status, wa.valor, wa.propriedade, wa.descricao AS atividade_descricao, wa.imagem
                    FROM tb_workflow_fluxo wf
                    INNER JOIN tb_workflow_atividade wa ON (wf.id_atividade = wa.id )
                    WHERE wf.status = '1' " ;
			$sql .= ($id_usuario != null) ? " AND wf.id_usuario = " . $id_usuario : "";		
            $sql .= ($id_titulo_fluxo != null) ? " AND id_titulo_fluxo = " . $id_titulo_fluxo : "";
            $sql .= " ORDER BY wf.ordenacao ASC ";
            $query = mysqli_query($conexao,$sql) or die('Erro na execução  do listarFluxoAtividades tb_workflow_fluxo!');
            while ($objetoFluxoAtividade = mysqli_fetch_object($query)) {
                $atividade = new Atividade();
                $atividade->setId($objetoFluxoAtividade->id_atividade);
                $atividade->setTitulo($objetoFluxoAtividade->titulo);
                $atividade->setStatus($objetoFluxoAtividade->status);
                $atividade->setIdFluxo($objetoFluxoAtividade->id_fluxo);
                $atividade->setValor($objetoFluxoAtividade->valor);
                $atividade->setPropriedade($objetoFluxoAtividade->propriedade);
                $atividade->setImagem($objetoFluxoAtividade->imagem);
                $atividade->setDescricao($objetoFluxoAtividade->atividade_descricao);
                $atividade->setFixa($objetoFluxoAtividade->fixa);
				
                $retorno[] = $atividade;
            }
            $this->FecharBanco($conexao);
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
            $conexao = $this->ConectarBanco();

            $sql = "UPDATE tb_workflow_titulo_fluxo SET status = '0' WHERE id = " . $id . "";
            mysqli_query($conexao,$sql) or die('Erro na execução  do delet tb_workflow_titulo_fluxo!');
            
            $sql = "UPDATE tb_workflow_fluxo SET status = '0' WHERE id_titulo_fluxo = " . $id . "";
            $retorno = mysqli_query($conexao,$sql) or die('Erro na execução  do delet fluxo!');

            $this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    
    public function buscarFluxo($id = null, $id_usuario = null) {
        try {
            $retorno = array();
            $conexao = $this->ConectarBanco();
            $sql = "SELECT id,titulo,descricao,status FROM tb_workflow_titulo_fluxo ";
			$sql .= ($id != null) ? " WHERE id = " . $id : "";
			$sql .= ($id_usuario != null) ? " AND id_usuario = " . $id_usuario : "";
            $query = mysqli_query($conexao,$sql) or die('Erro na execução  do buscarFluxo tb_workflow_titulo_fluxo!');
            while ($objetoFluxo = mysqli_fetch_object($query)) {
                $fluxo = new Fluxo();
                $fluxo->setId($objetoFluxo->id);
                $fluxo->setTitulo($objetoFluxo->titulo);
                $fluxo->setDescricao($objetoFluxo->descricao);
                $fluxo->setStatus($objetoFluxo->status);
                $retorno[] = $fluxo;
            }
            $this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    
    public function listarDistinctFluxo() {
    	try {
    		$retorno = array();
    		$conexao = $this->ConectarBanco();
    		$sql = "SELECT DISTINCT id,titulo FROM tb_workflow_titulo_fluxo WHERE status = '1' AND id_usuario = " . $_SESSION["login"]->getId();
    		$query = mysqli_query($conexao,$sql) or die('Erro na execução  do listar tb_workflow_titulo_fluxo!');
    		while ($objetoFluxo = mysqli_fetch_object($query)) {
    			$fluxo = new Fluxo();
    			$fluxo->setId($objetoFluxo->id);
    			$fluxo->setTitulo($objetoFluxo->titulo);
    			$retorno[] = $fluxo;
    		}
    		$this->FecharBanco($conexao);
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
}

?>