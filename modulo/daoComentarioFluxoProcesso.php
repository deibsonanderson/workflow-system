<?php

class DaoComentarioFluxoProcesso extends DaoBase {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }
    
    private function montarListarComentarioFluxoProcesso($query){
    	$retorno = array();
    	while ($objetoComentarioFluxoProcesso = mysqli_fetch_object($query)) {
    		$comentarioFluxoProcesso = $this->modelMapper($objetoComentarioFluxoProcesso, new ComentarioFluxoProcesso());
    		$fluxoProcesso = new FluxoProcesso();
    		$fluxoProcesso->setId($objetoComentarioFluxoProcesso->id_processo_fluxo);
    		$comentarioFluxoProcesso->setFluxoProcesso($fluxoProcesso);
    		$retorno[] = $comentarioFluxoProcesso;
    	}
    	return $retorno;
    }
    
    private function montarSQlListarComentarioFluxoProcesso($complemento){
    	return "SELECT id, descricao, categoria, arquivo, id_processo_fluxo, data, status FROM ".DaoBase::TABLE_COMENTARIO." WHERE status = '1' ".$complemento;
    }

    public function listarComentarioFluxoProcesso($id = null) {
        try {
        	$sql = $this->montarSQlListarComentarioFluxoProcesso('');
            $sql .= ($id != null) ? " AND id_processo_fluxo = " . $id : "";
            $sql .= " ORDER BY id DESC ";
            return $this->montarListarComentarioFluxoProcesso($this->executar($sql));
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function listarComentarioByIdsFluxoProcesso($ids = null) {
    	try {
    		$sql = $this->montarSQlListarComentarioFluxoProcesso(" AND descricao != '' ");
    		$sql .= ($ids != null) ? " AND id_processo_fluxo IN (" . implode(',', array_map('intval', $ids)). ")" : "";
    		$sql .= " ORDER BY id DESC ";
    		return $this->montarListarComentarioFluxoProcesso($this->executar($sql));
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function checarComentarioExistent($id = null) {
    	try {
    		$query = $this->executar("SELECT id_processo_fluxo, SUM(anexo) as anexo, SUM(comentario) as comentario FROM ( SELECT id_processo_fluxo, (CASE WHEN LENGTH(arquivo) <= 0 THEN 1 ELSE 0 END) anexo, (CASE WHEN LENGTH(arquivo) > 0 THEN 1 ELSE 0 END) comentario FROM ".DaoBase::TABLE_COMENTARIO." WHERE status = '1' AND id_processo_fluxo = " . $id. " ) AS X GROUP BY id_processo_fluxo");
    		while ($objetoComentarioFluxoProcesso = mysqli_fetch_object($query)) {
    			$objeto = new stdClass();
    			
    			$objeto->totalAnexo = (int) $objetoComentarioFluxoProcesso->anexo;
    			$objeto->totalComentario = (int) $objetoComentarioFluxoProcesso->comentario;
    			
    			$retorno = $objeto;
    		}
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    private function montarSQlByFilterOrData($filter){
    	return "SELECT wc.id,
                           wc.descricao,
                           wc.arquivo,
						   wc.categoria,
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
                 FROM ".DaoBase::TABLE_COMENTARIO." wc
                 LEFT JOIN ".DaoBase::TABLE_PROCESSO_FLUXO." wpf ON (wpf.id = wc.id_processo_fluxo)
				 LEFT JOIN ".DaoBase::TABLE_FLUXO." wf ON ( wf.id = wpf.id_fluxo )
                 LEFT JOIN ".DaoBase::TABLE_TITULO_FLUXO." wtf ON ( wf.id_titulo_fluxo = wtf.id )
                 LEFT JOIN ".DaoBase::TABLE_PROCESSO." wp ON (wp.id = wpf.id_processo)
                 LEFT JOIN ".DaoBase::TABLE_ATIVIDADE." wa ON (wa.id = wf.id_atividade)
                 WHERE wc.status = '1' ".$filter;
    }
    
    private function montarListarByFilterOrData($query){
    	$retorno = array();
    	while ($objetoComentarioFluxoProcesso = mysqli_fetch_object($query)) {
    		$comentarioFluxoProcesso = $this->modelMapper($objetoComentarioFluxoProcesso, new ComentarioFluxoProcesso());
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
    	return $retorno;
    }
    
    public function listarComentarioFluxoProcessoByData($data = null) {
        try {
            $sql = ($data != null) ? " AND DATE_FORMAT(wc.data,'%d/%m/%Y') = '".$data."'" : " AND DATE_FORMAT(wc.data,'%Y-%m-%d') = CURDATE() ";
            $sql .= " ORDER BY wc.id DESC ";
            return $this->montarListarByFilterOrData($this->executar($this->montarSQlByFilterOrData($sql)));
        } catch (Exception $e) {
            return $e;
        }
    }

    public function incluirComentarioFluxoProcesso($comentarioFluxoProcesso) {
        try {
        	return $this->executar("INSERT INTO ".DaoBase::TABLE_COMENTARIO." (descricao,arquivo,categoria,id_processo_fluxo,data,status) VALUES ('" . $comentarioFluxoProcesso->getDescricao() . "','" . $comentarioFluxoProcesso->getArquivo() . "','" . $comentarioFluxoProcesso->getCategoria() . "','" . $comentarioFluxoProcesso->getFluxoProcesso()->getId() . "',".$comentarioFluxoProcesso->getData().",'" . $comentarioFluxoProcesso->getStatus() . "')");
        } catch (Exception $e) {
            return $e;
        }
    }

    public function excluirComentario($id) {
    	try {
    		return $this->executar("DELETE FROM ".DaoBase::TABLE_COMENTARIO." WHERE id = $id");
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function buscarComentario($id = null) {
    	try {
    		$retorno = $this->montarListarComentarioFluxoProcesso($this->executar(
    				$this->montarSQlListarComentarioFluxoProcesso($this->montarId($id))));    		
    		
    		return (count($retorno) > 0 )?$retorno[0]:null;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
        
    public function listarComentarioFluxoProcessoByFilter($filter = null) {
    	try {
    		return $this->montarListarByFilterOrData($this->executar($this->montarSQlByFilterOrData($filter)));
    	} catch (Exception $e) {
    		return $e;
    	}
    }

}

?>