<?php

class ControladorProcesso {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }

    public function listarProcesso($id = null) {
        try {
            $daoProcesso = new DaoProcesso();
            $retorno = $daoProcesso->listarProcesso($id);
            $daoProcesso->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function buscarProcessoByFluxoProcessoId($id_fluxo_processo = null) {
    	try {
    		$daoProcesso = new DaoProcesso();
    		$retorno = $daoProcesso->buscarProcessoByFluxoProcessoId($id_fluxo_processo);
    		$daoProcesso->__destruct();
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }

    public function listarFluxoProcesso($id_usuario = null) {
        try {
            $daoProcesso = new DaoProcesso();
            $retorno = $daoProcesso->listarFluxoProcesso($id_usuario);
            $daoProcesso->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
  
    public function listarFluxoProcessoSimplificado($id_usuario = null) {
        try {
            $daoProcesso = new DaoProcesso();
            $retorno = $daoProcesso->listarFluxoProcessoSimplificado($id_usuario);
            $daoProcesso->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function listarAtividadesProcessosHaVencer($id_usuario = null) {
    	try {
    		$daoProcesso = new DaoProcesso();
    		$retorno = $daoProcesso->listarAtividadesProcessosHaVencer($id_usuario);
    		$daoProcesso->__destruct();
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }

    public function buscarFluxoProcesso($id = null, $order = null) {
        try {
            $daoProcesso = new DaoProcesso();
            $retorno = $daoProcesso->buscarFluxoProcesso($id, $order);
            $daoProcesso->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }    

    public function incluirProcesso($post) {
        try {
            $processo = new Processo();
            $processo->setDescricao($post["descricao"]);
            $processo->setTitulo($post["titulo"]);
            $processo->setProvisao(valorMonetario($post["provisao"], "1"));
            $processo->setStatus('1');
			
            if($post["vigencia"] == null || $post["vigencia"] == '' || !validarDate($post["vigencia"])){
				$processo->setData("NOW()");
			}else{
				$processo->setData("'".desformataData($post["vigencia"])."'");
			}

			$fluxo = new Fluxo();
            $fluxo->setId($post["fluxo"]);
            $processo->setFluxo($fluxo);

            $usuario = new Usuario();
            $usuario->setId($_SESSION["login"]->getId());
            $processo->setUsuario($usuario);
            $daoProcesso = new DaoProcesso();

            $controladorFluxo = new ControladorFluxo();
            $listFluxoAtividade = $controladorFluxo->listarFluxoAtividades($processo->getFluxo()->getId());
            if ($listFluxoAtividade) {
                if ($daoProcesso->incluirProcesso($processo, $listFluxoAtividade)) {
                    return $this->telaListarProcesso();
                }
            } else {
                ?>
                <script type="text/javascript">
                    $.growlUI('Ocorreu algum erro no cadastro do processo favor refazer!', '&nbsp;');
                </script>
                <?php
                $controladorProcesso = new ControladorProcesso();
                echo $controladorProcesso->telaListarProcesso();
            }
            $daoProcesso->__destruct();
        } catch (Exception $e) {
            return $e;
        }
    }

    public function abrirFluxoProcesso($post) {
        try {
            $fluxoProcesso = new FluxoProcesso();
            $fluxoProcesso->setId($post["id"]);
            $fluxoProcesso->setAtivo('1');
            $daoProcesso = new DaoProcesso();
            if ($daoProcesso->abrirFecharFluxoProcesso($fluxoProcesso)) {
            	$processo = $this->buscarProcessoByFluxoProcessoId($fluxoProcesso->getId());
            	if($_SESSION["order"] == '2'){
            		return $this->telaTimeLineProcessoOrderAtivo(array("id" => $processo[0]->getId()));
            	}else{
            		return $this->telaTimeLineProcesso(array("id" => $processo[0]->getId()));
            	}
            }
            $daoProcesso->__destruct();
        } catch (Exception $e) {
            return $e;
        }
    }

    public function fecharFluxoProcesso($post) {
        try {
            $fluxoProcesso = new FluxoProcesso();
            $fluxoProcesso->setId($post["id"]);
            $fluxoProcesso->setAtivo('0');
            $fluxoProcesso->setAtuante('0');
            $daoProcesso = new DaoProcesso();
            if ($daoProcesso->abrirFecharFluxoProcesso($fluxoProcesso)) {
            	$processo = $this->buscarProcessoByFluxoProcessoId($fluxoProcesso->getId());
            	if($_SESSION["order"] == '2'){
            		return $this->telaTimeLineProcessoOrderAtivo(array("id" => $processo[0]->getId()));
            	}else{
            		return $this->telaTimeLineProcesso(array("id" => $processo[0]->getId()));
            	}
            }
            $daoProcesso->__destruct();
        } catch (Exception $e) {
            return $e;
        }
    }    
    
    public function atuarFluxoProcesso($post) {
        try {
            $fluxoProcesso = new FluxoProcesso();
            $fluxoProcesso->setId($post["id"]);
            $daoProcesso = new DaoProcesso();
            if ($daoProcesso->atuarFluxoProcesso($fluxoProcesso)) {
            	$processo = $this->buscarProcessoByFluxoProcessoId($fluxoProcesso->getId());
            	if($_SESSION["order"] == '2'){
            		return $this->telaTimeLineProcessoOrderAtivo(array("id" => $processo[0]->getId()));
            	}else{
            		return $this->telaTimeLineProcesso(array("id" => $processo[0]->getId()));
            	}
            }
            $daoProcesso->__destruct();
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function desatuarFluxoProcesso($post) {
        try {
            $fluxoProcesso = new FluxoProcesso();
            $fluxoProcesso->setId($post["id"]);
            $daoProcesso = new DaoProcesso();
            if ($daoProcesso->desatuarFluxoProcesso($fluxoProcesso)) {
            	$processo = $this->buscarProcessoByFluxoProcessoId($fluxoProcesso->getId());
            	if($_SESSION["order"] == '2'){
            		return $this->telaTimeLineProcessoOrderAtivo(array("id" => $processo[0]->getId()));
            	}else{
            		return $this->telaTimeLineProcesso(array("id" => $processo[0]->getId()));
            	}
            }
            $daoProcesso->__destruct();
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function atualizarValorFluxoProcesso($post){
    	try {
    		$fluxoProcesso = new FluxoProcesso();
    		$fluxoProcesso->setId($post["id"]);
    		$fluxoProcesso->setPropriedade($post["propriedade"]);
    		$fluxoProcesso->setValor(valorMonetario($post["valor"], "1"));
    		$daoProcesso = new DaoProcesso();
    		$daoProcesso->atualizarValorFluxoProcesso($fluxoProcesso);
    		$daoProcesso->__destruct();
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function atualizarTituloFluxoProcesso($post){
    	try {
    		$fluxoProcesso = new FluxoProcesso();
    		$fluxoProcesso->setId($post["id"]);
    		$fluxoProcesso->setTitulo($post["valor"]);
    		$daoProcesso = new DaoProcesso();
    		$daoProcesso->atualizarTituloFluxoProcesso($fluxoProcesso);
    		$daoProcesso->__destruct();
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function atualizarDescricaoFluxoProcesso($post){
    	try {
    		$fluxoProcesso = new FluxoProcesso();
    		$fluxoProcesso->setId($post["id"]);
    		$fluxoProcesso->setDescricao($post["valor"]);
    		$daoProcesso = new DaoProcesso();
    		$daoProcesso->atualizarDescricaoFluxoProcesso($fluxoProcesso);
    		$daoProcesso->__destruct();
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function atualizarFixaFluxoProcesso($post){
    	try {
    		$fluxoProcesso = new FluxoProcesso();
    		$fluxoProcesso->setId($post["id"]);
    		$fluxoProcesso->setFixa($post["valor"]);
    		$daoProcesso = new DaoProcesso();
    		$daoProcesso->atualizarFixaFluxoProcesso($fluxoProcesso);
    		$daoProcesso->__destruct();
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function atualizarVencimentoFluxoProcesso($post){
    	try {
    		$fluxoProcesso = new FluxoProcesso();
    		$fluxoProcesso->setId($post["id"]);
    		$fluxoProcesso->setVencimento($post["valor"]);
    		$daoProcesso = new DaoProcesso();
    		$daoProcesso->atualizarVencimentoFluxoProcesso($fluxoProcesso);
    		$daoProcesso->__destruct();
    	} catch (Exception $e) {
    		return $e;
    	}
    }

    public function excluirProcesso($post) {
        try {
            $id = $post["id"];
            $daoProcesso = new DaoProcesso();
            $daoProcesso->excluirProcesso($id);
            $daoProcesso->__destruct();
            return $this->telaListarProcesso();
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function alterarProcesso($post) {
    	try {
    		$processo = new Processo();
    		$processo->setId($post["id"]);
    		$processo->setDescricao($post["descricao"]);
    		$processo->setTitulo($post["titulo"]);
    		$processo->setProvisao(valorMonetario($post["provisao"], "1"));
    		
    		if($post["vigencia"] == null || $post["vigencia"] == '' || !validarDate($post["vigencia"])){
    			$processo->setData("NOW()");
    		}else{
    			$processo->setData(desformataData($post["vigencia"]));
    		}
    		
    		$daoProcesso = new DaoProcesso();
    		if ($daoProcesso->alterarProcesso($processo)) {
    			return $this->telaListarProcesso();
    		}
    		$daoProcesso->__destruct();
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function listarDistinctProcesso() {
    	try {
    		$daoProcesso = new DaoProcesso();
    		$retorno = $daoProcesso->listarDistinctProcesso();
    		$daoProcesso->__destruct();
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function incluirProcessoFluxo($post = null){
    	$fluxoProcesso = new FluxoProcesso();
    	
    	$fluxoProcesso->setTitulo($post["input_titulo"]);
    	$fluxoProcesso->setDescricao($post["input_descricao"]);
    	$fluxoProcesso->setProcesso($post["id_processo"]);
    	$fluxoProcesso->setId_fluxo($post["id_fluxo"]);
    	$fluxoProcesso->setPropriedade($post["input_propriedade"]);
    	if($post["input_vencimento"] != ""){
    		$fluxoProcesso->setVencimento("'".$post["input_vencimento"]."'"); 
    	}else{
    		$fluxoProcesso->setVencimento('NULL');
    	}
    	$fluxoProcesso->setValor(valorMonetario($post["input_valor"], '1'));
   		
    	$daoProcesso = new DaoProcesso();
    	$daoProcesso->incluirProcessoFluxo($fluxoProcesso);
    	
    	$retorno = $this->telaTimeLineProcesso(array("id" => $post["id_processo"]));
    	$this->__destruct();
    	return $retorno;
    }
    
    public function excluirProcessoFluxo($post) {
    	try {
    		$daoProcesso = new DaoProcesso();
    		$daoProcesso->excluirProcessoFluxo($post["id"]);
    		$retorno = $this->telaTimeLineProcesso(array("id" => $post["id_processo"]));
    		$this->__destruct();
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function listarProcessoGeral() {
        try {
            $daoProcesso = new DaoProcesso();
            $retorno = $daoProcesso->listarProcessoGeral();
            $daoProcesso->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function telaCadastrarProcesso($post = null) {
        try {
            $viewProcesso = new ViewProcesso();
            $post = null;
            $retorno = $viewProcesso->telaCadastrarProcesso($post);
            $viewProcesso->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function telaListarProcesso($post = null) {
        try {
            $viewProcesso = new ViewProcesso();
            $retorno = $viewProcesso->telaListarProcesso($this->listarFluxoProcessoSimplificado($_SESSION["login"]->getId()));
            $viewProcesso->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function telaAlterarProcesso($post = null) {
        try {
            $viewProcesso = new ViewProcesso();
            $retorno = $viewProcesso->telaAlterarProcesso($this->listarProcesso($post["id"]));
            $viewProcesso->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function telaVisualizarProcesso($post = null) {
        try {
            $viewProcesso = new ViewProcesso();
            $retorno = $viewProcesso->telaVisualizarProcesso($this->listarProcesso($post["id"]));
            $viewProcesso->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }    
    
    public function telaTimeLineProcesso($post = null) {
    	try {
    		$viewProcesso = new ViewProcesso();
			$_SESSION["order"] = '1';
    		$retorno = $viewProcesso->telaTimeLineProcesso($this->buscarFluxoProcesso($post["id"]),$_SESSION["order"]);
    		$viewProcesso->__destruct();
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function telaTimeLineProcessoOrderAtivo($post = null) {
    	try {
    		$viewProcesso = new ViewProcesso();
			$_SESSION["order"] = '2';
    		$order = " ORDER BY wpf.ativo DESC,wf.ordenacao ASC ";
    		$retorno = $viewProcesso->telaTimeLineProcesso($this->buscarFluxoProcesso($post["id"],$order),$_SESSION["order"]);
    		$viewProcesso->__destruct();
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function telaTimeLineProcessoOrderVencimento($post = null) {
    	try {
    		$viewProcesso = new ViewProcesso();
			$_SESSION["order"] = '3';
    		$order = " ORDER BY wa.vencimento ASC, wpf.ativo ASC ";
    		$retorno = $viewProcesso->telaTimeLineProcesso($this->buscarFluxoProcesso($post["id"],$order),$_SESSION["order"]);
    		$viewProcesso->__destruct();
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function telaGraficoProcessos($post = null){
    	try {
    		$viewProcesso = new ViewProcesso();
    		$retorno = $viewProcesso->telaGraficoProcessos($this->listarFluxoProcesso($_SESSION["login"]->getId()));
    		$viewProcesso->__destruct();
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}    	
    }

    public function telaGraficoProcessosAtividades($post = null){
    	try {
    		$viewProcesso = new ViewProcesso();
    		$retorno = $viewProcesso->telaGraficoProcessosAtividades($this->buscarFluxoProcesso($post["id"]));
    		$viewProcesso->__destruct();
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function telaRelatorioProcessosAtividades($post = null){
    	try {
    		$viewProcesso = new ViewProcesso();
    		$retorno = $viewProcesso->telaRelatorioProcessosAtividades($this->buscarFluxoProcesso($post["id"]));
    		$viewProcesso->__destruct();
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function telaModalCadastrarProcessoFluxo($post = null){
    	$viewProcesso = new ViewProcesso();
    	$retorno = $viewProcesso->telaModalCadastrarProcessoFluxo($this->buscarFluxoProcesso($post["id"]));
    	$viewProcesso->__destruct();
    	return $retorno;
    }
    
	public function telaModalComentariosProcessoFluxo($post = null) {
		$viewProcesso = new ViewProcesso ();
		$retorno = $viewProcesso->telaModalComentariosProcessoFluxo ( $post ["titulo_processo_fluxo"], $post ["id_processo_fluxo"] );
		$viewProcesso->__destruct ();
		return $retorno;
	}
    
    

}
?>