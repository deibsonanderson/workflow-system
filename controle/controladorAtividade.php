<?php

class ControladorAtividade {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }

    public function listarAtividade($id = null, $pagina = null) {
        try {
        	$daoAtividade = new DaoAtividade();
            $retorno = $daoAtividade->listarAtividade($id,$_SESSION["login"]->getId(), $pagina);
            $daoAtividade->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function listarDistinctAtividade() {
    	try {
    		$daoAtividade = new DaoAtividade();
    		$retorno = $daoAtividade->listarDistinctAtividade();
    		$daoAtividade->__destruct();
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function listarAtividadeByCategoria($id = null) {
    	try {
    		$daoAtividade = new DaoAtividade();
    		$retorno = $daoAtividade->listarAtividadeByCategoria($id,$_SESSION["login"]->getId());
    		$daoAtividade->__destruct();
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }    

    public function incluirAtividade($post) {
        try {
            $atividade = new Atividade();
            $atividade->setTitulo($post["titulo"]);
            $atividade->setDescricao($post["descricao"]);
            $atividade->setLink($post["link"]);
            $atividade->setArquivo($post["arquivo"]);
            $atividade->setImagem($post["imagem"]);
            $atividade->setStatus('1');
            $atividade->setFixa($post["fixa"]);
            $atividade->setCategoria($post["categoria"]);
            if($post["vencimento"] != ""){
				$atividade->setVencimento($post["vencimento"]);
            }
			
			$atividade->setValor(valorMonetario($post["valor"], "1"));
            $atividade->setPropriedade($post["propriedade"]);

            $usuario = new Usuario();
            $usuario->setId($_SESSION["login"]->getId());
            $atividade->setUsuario($usuario);
            
            
            $daoAtividade = new DaoAtividade();

            if ($daoAtividade->incluirAtividade($atividade)) {
                return $this->telaCadastrarAtividade();
            }
            $daoAtividade->__destruct();
        } catch (Exception $e) {
            return $e;
        }
    }

    public function alterarAtividade($post) {
        try {
            $atividade = new Atividade();
            $atividade->setId($post["id"]);
            $atividade->setTitulo($post["titulo"]);
            $atividade->setDescricao($post["descricao"]);
            $atividade->setLink($post["link"]);
            $atividade->setArquivo($post["arquivo"]);
            $atividade->setImagem($post["imagem"]);
            $atividade->setStatus('1');
            $atividade->setFixa($post["fixa"]);
            $atividade->setVencimento($post["vencimento"]);
            $atividade->setCategoria($post["categoria"]);
            $atividade->setValor(valorMonetario($post["valor"], "1"));
            $atividade->setPropriedade($post["propriedade"]);
            
            $usuario = new Usuario();
            $usuario->setId($_SESSION["login"]->getId());
            $atividade->setUsuario($usuario);
            
            $daoAtividade = new DaoAtividade();
            if ($daoAtividade->alterarAtividade($atividade)) {
                return $this->telaListarAtividade();
            }
            $daoAtividade->__destruct();
        } catch (Exception $e) {
            return $e;
        }
    }

    public function excluirAtividade($post) {
        try {
            $id = $post["id"];
            $daoAtividade = new DaoAtividade();
            $daoAtividade->excluirAtividade($id);
            $daoAtividade->__destruct();
            return $this->telaListarAtividade();
        } catch (Exception $e) {
            return $e;
        }
    }

    public function telaCadastrarAtividade($post = null) {
        try {
            $viewAtividade = new ViewAtividade();
            $post = null;
            $retorno = $viewAtividade->telaCadastrarAtividade($post);
            $viewAtividade->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function telaListarAtividade($post = null) {
        try {
            $viewAtividade = new ViewAtividade();
            if($post["pagina"] === null || $post["pagina"] === ''){
            	$post["pagina"] = 1;
            }
            $retorno = $viewAtividade->telaListarAtividade($this->listarAtividade(null, $post["pagina"]), $post["pagina"]);
            $viewAtividade->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function telaAlterarAtividade($post = null) {
        try {
            $viewAtividade = new ViewAtividade();
            $pagina = $this->listarAtividade($post["id"], null);
            $retorno = $viewAtividade->telaAlterarAtividade($pagina->retorno);
            $viewAtividade->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function telaVisualizarAtividade($post = null) {
        try {
            $viewAtividade = new ViewAtividade();
            $pagina = $this->listarAtividade($post["id"], null);
            $retorno = $viewAtividade->telaVisualizarAtividade($pagina->retorno);
            $viewAtividade->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function telaVisualizarAtividadeProcesso($post = null) {
        try {
        	
            $viewAtividade = new ViewAtividade();
            $processoFluxo = new FluxoProcesso();
            $processoFluxo->setId($post["id_processo_fluxo"]);        
//             $processoFluxo->setAtivo($post["ativo"]);
//             $processoFluxo->setAtuante($post["atuante"]);
//             $processoFluxo->setTitulo($post["titulo_processo_fluxo"]);
//             $processoFluxo->setVencimento($post["vencimento_processo_fluxo"]);
//             $processoFluxo->setDescricao($post["descricao_processo_fluxo"]);
//             $processoFluxo->setValor($post["valor_processo_fluxo"]);
            
            $processo = new Processo();
            $processo->setId($post["id_processo"]);
            $processoFluxo->setProcesso($processo);
            $retorno = $viewAtividade->telaVisualizarAtividadeProcesso($this->buscarAtividade($post["id"]),$processoFluxo);
            $viewAtividade->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    
    public function buscarAtividade($id = null) {
        try {
            $daoAtividade = new DaoAtividade();
            $retorno = $daoAtividade->buscarAtividade($id);
            $daoAtividade->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    
    public function comentariosAtividadeProcesso($processoFluxoId, $isDelete) {
        try {
            $viewAtividade = new ViewAtividade();
            if($isDelete == null || $isDelete == ''){
            	$isDelete = false;
            }
            $retorno = $viewAtividade->telaComentariosAtividadeProcesso($processoFluxoId, $isDelete);
            $viewAtividade->__destruct();
            
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    
    public function telaListarComentariosAtividadeProcesso($post = null) {
    	try {
    		$viewAtividade = new ViewAtividade();
    		$controladorComentarioFluxoProcesso = new ControladorComentarioFluxoProcesso();
    		
			if(isset($post) && count($post) == 0){
				$controladorProcesso = new ControladorProcesso();
				$processos = $controladorProcesso->listarDistinctProcesso();
				if($processos != null && count($processos) > 0){
					$post["processo"] = $processos[0]->getId();
				}
			}
    		$retorno = $viewAtividade->telaListarComentariosAtividadeProcesso($controladorComentarioFluxoProcesso->listarComentarioFluxoProcessoByFilter($post), $processos);
    		$viewAtividade->__destruct();
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }

}

?>