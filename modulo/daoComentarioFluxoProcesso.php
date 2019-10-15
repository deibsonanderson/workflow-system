<?php

class DaoComentarioFluxoProcesso extends Dados {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }

    public function listarComentarioFluxoProcesso($id = null) {
        try {
            $retorno = array();
            $conexao = $this->ConectarBanco();
            $sql = "SELECT id,descricao,arquivo,id_processo_fluxo,data,status FROM tb_workflow_comentario WHERE status = '1' ";
            $sql .= ($id != null) ? " AND id_processo_fluxo = " . $id : "";
            $sql .= " ORDER BY id DESC ";
			
            $query = mysqli_query($conexao,$sql) or die('Erro na execução  do listar!');
            while ($objetoComentarioFluxoProcesso = mysqli_fetch_object($query)) {
                $comentarioFluxoProcesso = new ComentarioFluxoProcesso();
                $comentarioFluxoProcesso->setId($objetoComentarioFluxoProcesso->id);
                $comentarioFluxoProcesso->setDescricao($objetoComentarioFluxoProcesso->descricao);
                $comentarioFluxoProcesso->setArquivo($objetoComentarioFluxoProcesso->arquivo);
                $comentarioFluxoProcesso->setStatus($objetoComentarioFluxoProcesso->status);
                $comentarioFluxoProcesso->setData($objetoComentarioFluxoProcesso->data);
                $fluxoProcesso = new FluxoProcesso();
                $fluxoProcesso->setId($objetoComentarioFluxoProcesso->id_processo_fluxo);
                $comentarioFluxoProcesso->setFluxoProcesso($fluxoProcesso);

                $retorno[] = $comentarioFluxoProcesso;
            }
            $this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function listarComentarioByIdsFluxoProcesso($ids = null) {
    	try {
    		$retorno = array();
    		$conexao = $this->ConectarBanco();
    		$sql = "SELECT id,descricao,arquivo,id_processo_fluxo,data,status FROM tb_workflow_comentario WHERE status = '1' AND descricao != '' ";
    		$sql .= ($ids != null) ? " AND id_processo_fluxo IN (" . implode(',', array_map('intval', $ids)). ")" : "";
    		$sql .= " ORDER BY id DESC ";
    		
    		$query = mysqli_query($conexao,$sql) or die('Erro na execução  do listar!');
    		while ($objetoComentarioFluxoProcesso = mysqli_fetch_object($query)) {
    			$comentarioFluxoProcesso = new ComentarioFluxoProcesso();
    			$comentarioFluxoProcesso->setId($objetoComentarioFluxoProcesso->id);
    			$comentarioFluxoProcesso->setDescricao($objetoComentarioFluxoProcesso->descricao);
    			$comentarioFluxoProcesso->setArquivo($objetoComentarioFluxoProcesso->arquivo);
    			$comentarioFluxoProcesso->setStatus($objetoComentarioFluxoProcesso->status);
    			$comentarioFluxoProcesso->setData($objetoComentarioFluxoProcesso->data);
    			$fluxoProcesso = new FluxoProcesso();
    			$fluxoProcesso->setId($objetoComentarioFluxoProcesso->id_processo_fluxo);
    			$comentarioFluxoProcesso->setFluxoProcesso($fluxoProcesso);
    			
    			$retorno[] = $comentarioFluxoProcesso;
    		}
    		$this->FecharBanco($conexao);
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function checarComentarioExistent($id = null) {
    	try {
    		$retorno = array();
    		$conexao = $this->ConectarBanco();
    		
    		$sql = "SELECT id_processo_fluxo, SUM(anexo) as anexo, SUM(comentario) as comentario FROM ( SELECT id_processo_fluxo, (CASE WHEN LENGTH(arquivo) <= 0 THEN 1 ELSE 0 END) anexo, (CASE WHEN LENGTH(arquivo) > 0 THEN 1 ELSE 0 END) comentario FROM tb_workflow_comentario WHERE status = '1' AND id_processo_fluxo = " . $id. " ) AS X GROUP BY id_processo_fluxo";
    		
    		$query = mysqli_query($conexao,$sql) or die('Erro na execução  do listar!');
    		while ($objetoComentarioFluxoProcesso = mysqli_fetch_object($query)) {
    			$objeto = new stdClass();
    			
    			$objeto->totalAnexo = (int) $objetoComentarioFluxoProcesso->anexo;
    			$objeto->totalComentario = (int) $objetoComentarioFluxoProcesso->comentario;
    			
    			$retorno = $objeto;
    		}
    		$this->FecharBanco($conexao);
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function listarComentarioFluxoProcessoByData($data = null) {
        try {
            $retorno = array();
            $conexao = $this->ConectarBanco();
            $sql = "SELECT wc.id,
                           wc.descricao,
                           wc.arquivo,
                           wc.id_processo_fluxo,
                           wc.data,
                           wc.status,
                           wpf.id_processo,
						   wpf.titulo_atividade as titulo_atividade_processo,	
                           wp.titulo as processo_titulo,
                           wp.descricao as processo_descricao,
						   wpf.ativo, 
						   wpf.atuante,
						   wf.id_atividade,
						   wa.titulo as titulo_atividade						   
                 FROM tb_workflow_comentario wc
                 LEFT JOIN tb_workflow_processo_fluxo wpf ON (wpf.id = wc.id_processo_fluxo) 
				 LEFT JOIN tb_workflow_fluxo wf ON ( wf.id = wpf.id_fluxo ) 										 										 
                 LEFT JOIN tb_workflow_processo wp ON (wp.id = wpf.id_processo) 
                 LEFT JOIN tb_workflow_atividade wa ON (wa.id = wf.id_atividade)
                 WHERE wc.status = '1' ";
            $sql .= ($data != null) ? " AND DATE_FORMAT(wc.data,'%d/%m/%Y') = '".$data."'" : " AND DATE_FORMAT(wc.data,'%Y-%m-%d') = CURDATE() ";
            $sql .= " ORDER BY wc.id DESC ";
            //debug($sql);
            $query = mysqli_query($conexao,$sql) or die('Erro na execução  do listar!');
            while ($objetoComentarioFluxoProcesso = mysqli_fetch_object($query)) {
                $comentarioFluxoProcesso = new ComentarioFluxoProcesso();
                $comentarioFluxoProcesso->setId($objetoComentarioFluxoProcesso->id);
                $comentarioFluxoProcesso->setDescricao($objetoComentarioFluxoProcesso->descricao);
                $comentarioFluxoProcesso->setArquivo($objetoComentarioFluxoProcesso->arquivo);
                $comentarioFluxoProcesso->setStatus($objetoComentarioFluxoProcesso->status);
                $comentarioFluxoProcesso->setData($objetoComentarioFluxoProcesso->data);
                $fluxoProcesso = new FluxoProcesso();
                $fluxoProcesso->setId($objetoComentarioFluxoProcesso->id_processo_fluxo);
                $fluxoProcesso->setAtivo($objetoComentarioFluxoProcesso->ativo);
                $fluxoProcesso->setAtuante($objetoComentarioFluxoProcesso->atuante);

                $atividade = new Atividade();
                $atividade->setId($objetoComentarioFluxoProcesso->id_atividade);
                $tituloAtividade = ($objetoComentarioFluxoProcesso->titulo_atividade_processo == null)?
                $objetoComentarioFluxoProcesso->titulo_atividade:$objetoComentarioFluxoProcesso->titulo_atividade_processo;
                $atividade->setTitulo($tituloAtividade);
                $fluxoProcesso->setAtividade($atividade);				
				
                $comentarioFluxoProcesso->setFluxoProcesso($fluxoProcesso);
                
                $processo = new Processo();
                $processo->setId($objetoComentarioFluxoProcesso->id_processo);
                $processo->setDescricao($objetoComentarioFluxoProcesso->processo_descricao);
                $processo->setTitulo($objetoComentarioFluxoProcesso->processo_titulo);
                $comentarioFluxoProcesso->setProcesso($processo);
                
                $retorno[] = $comentarioFluxoProcesso;
            }
            $this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function incluirComentarioFluxoProcesso($comentarioFluxoProcesso) {
        try {
            $conexao = $this->ConectarBanco();
            $sql = "INSERT INTO tb_workflow_comentario(descricao,arquivo,id_processo_fluxo,data,status) VALUES ('" . $comentarioFluxoProcesso->getDescricao() . "','" . $comentarioFluxoProcesso->getArquivo() . "','" . $comentarioFluxoProcesso->getFluxoProcesso()->getId() . "',".$comentarioFluxoProcesso->getData().",'" . $comentarioFluxoProcesso->getStatus() . "')";
            $retorno = mysqli_query($conexao,$sql) or die('Erro na execução  do insert!');
            $this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function excluirComentarioFluxoProcesso($id) {
        try {
            $conexao = $this->ConectarBanco();

            $sql = "UPDATE tb_workflow_comentario SET status = '0' WHERE id = " . $id . "";
            $retorno = mysqli_query($conexao,$sql) or die('Erro na execução  do delet comentarioFluxoProcesso!');

            $this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function excluirComentario($id) {
    	try {
    		$conexao = $this->ConectarBanco();
    		
    		$sql = "DELETE FROM tb_workflow_comentario WHERE id = " . $id . "";
    		
    		//debug($sql);
    		$retorno = mysqli_query($conexao,$sql) or die('Erro na execução do delete comentarioFluxoProcesso!');
    		
    		$this->FecharBanco($conexao);
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    
    public function buscarComentario($id = null) {
    	try {
    		$retorno = array();
    		$conexao = $this->ConectarBanco();
    		$sql = "SELECT id,descricao,arquivo,id_processo_fluxo,data,status FROM tb_workflow_comentario WHERE status = '1' ";
    		$sql .= ($id != null) ? " AND id = " . $id : "";
    		
    		
    		$query = mysqli_query($conexao,$sql) or die('Erro na execução  do listar!');
    		while ($objetoComentarioFluxoProcesso = mysqli_fetch_object($query)) {
    			$comentario = new ComentarioFluxoProcesso();
    			$comentario->setId($objetoComentarioFluxoProcesso->id);
    			$comentario->setDescricao($objetoComentarioFluxoProcesso->descricao);
    			$comentario->setArquivo($objetoComentarioFluxoProcesso->arquivo);
    			$comentario->setStatus($objetoComentarioFluxoProcesso->status);
    			$comentario->setData($objetoComentarioFluxoProcesso->data);
    			$fluxoProcesso = new FluxoProcesso();
    			$fluxoProcesso->setId($objetoComentarioFluxoProcesso->id_processo_fluxo);
    			$comentario->setFluxoProcesso($fluxoProcesso);
    			
    			return $comentario;
    		}
    		$this->FecharBanco($conexao);
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
        
    public function listarComentarioFluxoProcessoByFilter($filter = null) {
    	try {
    		$retorno = array();
    		$conexao = $this->ConectarBanco();
    		$sql = "SELECT wc.id,
                           wc.descricao,
                           wc.arquivo,
                           wc.id_processo_fluxo,
                           wc.data,
                           wc.status,
                           wpf.id_processo,
						   wpf.titulo_atividade as titulo_atividade_processo,
                           wp.titulo as processo_titulo,
                           wp.descricao as processo_descricao,
						   wpf.ativo,
						   wpf.atuante,
						   wf.id_atividade,
						   wf.id_titulo_fluxo,
						   wtf.titulo as titulo_fluxo,
						   wa.titulo as titulo_atividade
                 FROM tb_workflow_comentario wc
                 LEFT JOIN tb_workflow_processo_fluxo wpf ON (wpf.id = wc.id_processo_fluxo)
				 LEFT JOIN tb_workflow_fluxo wf ON ( wf.id = wpf.id_fluxo )
				 LEFT JOIN tb_workflow_titulo_fluxo wtf ON ( wf.id_titulo_fluxo = wtf.id )
                 LEFT JOIN tb_workflow_processo wp ON (wp.id = wpf.id_processo)
                 LEFT JOIN tb_workflow_atividade wa ON (wa.id = wf.id_atividade)
                 WHERE wc.status = '1' ";
    		$sql .= $filter;
    		$query = mysqli_query($conexao,$sql) or die('Erro na execução  do listar!');
    		while ($objetoComentarioFluxoProcesso = mysqli_fetch_object($query)) {
    			
    			$comentario = new ComentarioFluxoProcesso();
    			$comentario->setId($objetoComentarioFluxoProcesso->id);
    			$comentario->setDescricao($objetoComentarioFluxoProcesso->descricao);
    			$comentario->setArquivo($objetoComentarioFluxoProcesso->arquivo);
    			$comentario->setStatus($objetoComentarioFluxoProcesso->status);
    			$comentario->setData($objetoComentarioFluxoProcesso->data);
    			
    			$fluxoProcesso = new FluxoProcesso();
    			$fluxoProcesso->setId($objetoComentarioFluxoProcesso->id_processo_fluxo);
    			$fluxoProcesso->setAtivo($objetoComentarioFluxoProcesso->ativo);
    			$fluxoProcesso->setAtuante($objetoComentarioFluxoProcesso->atuante);
    			$fluxoProcesso->setTitulo($objetoComentarioFluxoProcesso->titulo_fluxo);
    			
    			$atividade = new Atividade();
    			$atividade->setId($objetoComentarioFluxoProcesso->id_atividade);
    			$tituloAtividade = ($objetoComentarioFluxoProcesso->titulo_atividade_processo == null)?
    			$objetoComentarioFluxoProcesso->titulo_atividade:$objetoComentarioFluxoProcesso->titulo_atividade_processo;
    			$atividade->setTitulo($tituloAtividade);
    			$fluxoProcesso->setAtividade($atividade);
    			
    			$comentario->setFluxoProcesso($fluxoProcesso);
    			
    			$processo = new Processo();
    			$processo->setId($objetoComentarioFluxoProcesso->id_processo);
    			$processo->setDescricao($objetoComentarioFluxoProcesso->processo_descricao);
    			$processo->setTitulo($objetoComentarioFluxoProcesso->processo_titulo);
    			$comentario->setProcesso($processo);
    			
    			$retorno[] = $comentario;
    		}
    		$this->FecharBanco($conexao);
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }

}

?>