<?php

class ControladorComentarioFluxoProcesso {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }

    public function listarComentarioFluxoProcesso($id = null) {
        try {
            $daoComentarioFluxoProcesso = new DaoComentarioFluxoProcesso();
            $retorno = $daoComentarioFluxoProcesso->listarComentarioFluxoProcesso($id);
            $daoComentarioFluxoProcesso->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function listarComentarioByIdsFluxoProcesso($ids = null) {
    	try {
    		$daoComentarioFluxoProcesso = new DaoComentarioFluxoProcesso();
    		$retorno = $daoComentarioFluxoProcesso->listarComentarioByIdsFluxoProcesso($ids);
    		$daoComentarioFluxoProcesso->__destruct();
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function checarComentarioExistent($id = null) {
    	try {
    		$daoComentarioFluxoProcesso = new DaoComentarioFluxoProcesso();
    		$retorno = $daoComentarioFluxoProcesso->checarComentarioExistent($id);
    		$daoComentarioFluxoProcesso->__destruct();
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function listarComentarioFluxoProcessoByData($data = null) {
        try {
            $daoComentarioFluxoProcesso = new DaoComentarioFluxoProcesso();
            $retorno = $daoComentarioFluxoProcesso->listarComentarioFluxoProcessoByData($data);
            $daoComentarioFluxoProcesso->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function incluirComentarioFluxoProcesso($post) {
        try {
            $comentarioFluxoProcesso = new ComentarioFluxoProcesso();
            $comentarioFluxoProcesso->setDescricao($post["descricao"]);
            $comentarioFluxoProcesso->setArquivo($post["arquivo"]);
            $fluxoProcesso = new FluxoProcesso();
            $fluxoProcesso->setId($post["id_processo_fluxo"]);
            $comentarioFluxoProcesso->setFluxoProcesso($fluxoProcesso);
            $comentarioFluxoProcesso->setStatus('1');
            
            if($post["data_comentario"] == null || $post["data_comentario"] == '' || !validarDate($post["data_comentario"])){
            	$comentarioFluxoProcesso->setData("NOW()");
            }else{
            	$comentarioFluxoProcesso->setData("'".desformataData($post["data_comentario"])."'");
            }
            
            $daoComentarioFluxoProcesso = new DaoComentarioFluxoProcesso();
            if($post["descricao"] != '' || $post["arquivo"] != ''){
                if ($daoComentarioFluxoProcesso->incluirComentarioFluxoProcesso($comentarioFluxoProcesso)) {
                    $controladorAtividade = new ControladorAtividade();
                    $controladorAtividade->telaVisualizarAtividadeProcesso($post);
                }            
            }else{
                $controladorAtividade = new ControladorAtividade();
                $controladorAtividade->telaVisualizarAtividadeProcesso($post);
            }
            $daoComentarioFluxoProcesso->__destruct();
        } catch (Exception $e) {
            return $e;
        }
    }

    public function excluirComentarioFluxoProcesso($post) {
        try {
            $id = $post["id"];
            $daoComentarioFluxoProcesso = new DaoComentarioFluxoProcesso();
            $daoComentarioFluxoProcesso->excluirComentarioFluxoProcesso($id);
            $daoComentarioFluxoProcesso->__destruct();
            return $this->telaListarComentarioFluxoProcesso();
        } catch (Exception $e) {
            return $e;
        }
    }
    
    
    public function buscarComentario($id = null) {
    	try {
    		$daoComentarioFluxoProcesso = new DaoComentarioFluxoProcesso();
    		$retorno = $daoComentarioFluxoProcesso->buscarComentario($id);
    		$daoComentarioFluxoProcesso->__destruct();
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    
    public function excluirComentarioAtividadeFluxoProcesso($post) {
    	try {
    		$daoComentarioFluxoProcesso = new DaoComentarioFluxoProcesso();
    		
    		$comentario = $daoComentarioFluxoProcesso->buscarComentario($post["id"]);
    		if($comentario != null){
    		
        		if($comentario->getArquivo() !== null && $comentario->getArquivo() !== ''){
        		     
        			$pastaArquivo = getcwd()."/arquivos/atividade";
        			$arquivoExclusao = $comentario->getArquivo();
        			if (!empty($arquivoExclusao)) {
        				if (file_exists($pastaArquivo . "/" . $arquivoExclusao)) {
        					unlink($pastaArquivo . "/" . $arquivoExclusao);
        				}
        				if (file_exists($pastaArquivo . "/thumbnail" . $arquivoExclusao)) {
        					unlink($pastaArquivo . "/thumbnail" . $arquivoExclusao);
        				}
        			}
    	   		}

    	   		$daoComentarioFluxoProcesso->excluirComentario($comentario->getId());
    	   		$daoComentarioFluxoProcesso->__destruct();
    	   		
    		}
    		
    		$controladorAtividade = new ControladorAtividade();
    		return $controladorAtividade->comentariosAtividadeProcesso($post["processoFluxoId"]);
    	} catch (Exception $e) {
    		return $e;
    	}
    }

}

?>