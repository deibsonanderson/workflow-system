<?php

class ControladorFluxo {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }

    public function listarFluxo($id = null) {
        try {
            $daoFluxo = new DaoFluxo();
            $retorno = $daoFluxo->listarFluxo($id,$_SESSION["login"]->getId());
            $daoFluxo->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function listarFluxoAtividades($id_titulo_fluxo = null) {
        try {
            $daoFluxo = new DaoFluxo();
            $retorno = $daoFluxo->listarFluxoAtividades($id_titulo_fluxo,$_SESSION["login"]->getId());
            $daoFluxo->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }    
    
    public function alterarFluxo($post) {
    	$this->incluirFluxo($post);
    	$this->excluirFluxo($post);
    }

    public function incluirFluxo($post) {
        try {

            $fluxo = new Fluxo();
            $fluxo->setTitulo($post["titulo"]);
            $fluxo->setDescricao($post["descricao"]);
            $fluxo->setStatus('1');
            
            $usuario = new Usuario();
            $usuario->setId($_SESSION["login"]->getId());
            $fluxo->setUsuario($usuario);
            
            $listIds = $post["atividades"];
            
            if($listIds){
                $listAtividades = array();
                foreach ($listIds as $id_atividades) {
                    $atividade = new Atividade();
                    $atividade->setId($id_atividades);
                    $listAtividades[] = $atividade;
                }
                $fluxo->setAtividades($listAtividades);

                $daoFluxo = new DaoFluxo();
                if($daoFluxo->incluirFluxo($fluxo)) {
                    return $this->telaCadastrarFluxo();
                }
                $daoFluxo->__destruct();
            }else{
                ?>
                <script type="text/javascript">
                    $.growlUI('Deve-se selecionar pelo menos uma atividade para o fluxo!', '&nbsp;');                    
                </script>
                <?php
                $controladorFluxo = new ControladorFluxo();
                return $controladorFluxo->telaListarFluxo();
            }
            
        } catch (Exception $e) {
            return $e;
        }
    }

    public function excluirFluxo($post) {
        try {
            $id = $post["id"];
            $daoFluxo = new DaoFluxo();
            $daoFluxo->excluirFluxo($id);
            $daoFluxo->__destruct();
            return $this->telaListarFluxo();
        } catch (Exception $e) {
            return $e;
        }
    }

    public function telaCadastrarFluxo($post = null) {
        try {
            $viewFluxo = new ViewFluxo();
            $retorno = $viewFluxo->telaCadastrarFluxo($post);
            $viewFluxo->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function telaListarFluxo($post = null) {
        try {
            $viewFluxo = new ViewFluxo();
            $retorno = $viewFluxo->telaListarFluxo($this->listarFluxo(null));
            $viewFluxo->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function telaVisualizarFluxo($post = null) {
        try {
            $viewFluxo = new ViewFluxo();
            $retorno = $viewFluxo->telaVisualizarFluxo($this->listarFluxo($post["id"]));
            $viewFluxo->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function telaAlterarFluxo($post = null) {
    	try {
    		$viewFluxo = new ViewFluxo();
    		$retorno = $viewFluxo->telaAlterarFluxo($this->listarFluxo($post["id"]));
    		$viewFluxo->__destruct();
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    
    public function montarCheckAtividade($post) {
        try {
        	$id = null;
        	if($post["id"] !== ''){
        		$id = $post["id"];
        	}        	
            $controladorAtividade = new ControladorAtividade();
            $listAtividades = $controladorAtividade->listarAtividadeByCategoria($id);
            
            if($listAtividades){
				$indice = 0;
                foreach ($listAtividades as $atividade){
                	
					if($atividade->getPropriedade() == '1'){
                		$simbolo = '';
                		$colorcss = 'color:#4656E9;';
                	}else{
                		$simbolo = '-';
                		$colorcss = 'color:#FF407B;';
                	}
					
					$imagem = './assets/images/avatar-1.jpg';
					if($atividade->getImagem() != null && $atividade->getImagem() != ''){
						$imagem = './imagens/atividade/'.$atividade->getImagem();
					}	
                    ?>
                    <div id="recordsArray_<?php echo $atividade->getId(); ?>" style="margin-bottom: 1px;">
	                    <li id="listArray_<?php echo $atividade->getId(); ?>" class="list-group-item align-items-center drag-handle">
							<div class="row">
								<div style="margin-top: 10px;" class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10">
									<label class="custom-control custom-checkbox">
										<input type="checkbox" id="atividades[]" name="atividades[]" class="custom-control-input check-fluxo" value="<?php echo $atividade->getId(); ?>">
										<span class="custom-control-label"><img src="<?php echo $imagem; ?>" style="width: 38px;border: 3px solid #c8c8c8;"></span>
										<span class="custom-control-label"><?php echo $atividade->getTitulo(); ?> | </span>
										<span class="custom-control-label" style="<?php echo $colorcss; ?>"><?php echo 'R$ '.$simbolo.valorMonetario($atividade->getValor(),'2'); ?></span>
									</label>
								</div>
								<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2">
									<div style="float:right" class="btn-group-vertical">
										<i class="btn btn-light btn-sm fa fa-arrow-up" aria-hidden="true" onclick="listUp(<?php echo $atividade->getId(); ?>)"></i>
										<i class="btn btn-light btn-sm fa fa-arrow-down" aria-hidden="true" onclick="listDown(<?php echo $atividade->getId(); ?>)"></i>
									</div>
								</div>
							</div>
	                    </li>
                    </div>
                    <?php
					++$indice;
                }
            }
            
        } catch (Exception $e) {
            return $e;
        }
    }
    
    
    public function montarCheckUpdateAtividade($post, $fluxoId = null) {
    	try {
    		
    		$id = null;
    		if($post["id"] !== ''){
    			$id = $post["id"];
    		}
    		if($fluxoId === null){
    			$fluxoId = $post['param'];
    		}
    		
    		$controladorFluxo = new ControladorFluxo();
    		$listAtividadesByFluxo = $controladorFluxo->listarFluxoAtividades($fluxoId);
    		
    		$controladorAtividade = new ControladorAtividade();
    		$listAtividades = $controladorAtividade->listarAtividadeByCategoria($id);
    		if($listAtividades){
    			foreach ($listAtividades as $atividade){
    				$checked = '';
    				foreach ($listAtividadesByFluxo as $atividadeFluxo ){
    					if($atividadeFluxo->getId() == $atividade->getId()){
    						$checked = 'checked="checked"';
    						break;
    					}
    				}
    				if($atividade->getPropriedade() == '1'){
    					$simbolo = '';
    					$colorcss = 'color:#4656E9;';
    				}else{
    					$simbolo = '-';
    					$colorcss = 'color:#FF407B;';
    				}
    				
    				$imagem = './assets/images/avatar-1.jpg';
    				if($atividade->getImagem() != null && $atividade->getImagem() != ''){
    					$imagem = './imagens/atividade/'.$atividade->getImagem();
    				}
    				?>
                    <div id="recordsArray_<?php echo $atividade->getId(); ?>" style="margin-bottom: 1px;">
	                    <li id="listArray_<?php echo $atividade->getId(); ?>" class="list-group-item align-items-center drag-handle">
	                        <div class="row">
							<div style="margin-top: 10px;" class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10">
								<label class="custom-control custom-checkbox">
									<input type="checkbox" id="atividades[]" name="atividades[]" class="custom-control-input check-fluxo" value="<?php echo $atividade->getId(); ?>" <?php echo $checked; ?>>
									<span class="custom-control-label"><img src="<?php echo $imagem; ?>" style="width: 38px;border: 3px solid #c8c8c8;"></span>
									<span class="custom-control-label"><?php echo $atividade->getTitulo(); ?> | </span>
									<span class="custom-control-label" style="<?php echo $colorcss; ?>"><?php echo 'R$ '.$simbolo.valorMonetario($atividade->getValor(),'2'); ?></span>
								</label>
								</div>
								<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-2">
									<div style="float:right" class="btn-group-vertical">
										<i class="btn btn-light btn-sm fa fa-arrow-up" aria-hidden="true" onclick="listUp(<?php echo $atividade->getId(); ?>)"></i>
										<i class="btn btn-light btn-sm fa fa-arrow-down" aria-hidden="true" onclick="listDown(<?php echo $atividade->getId(); ?>)"></i>
									</div>
								</div>
							</div>							
	                    </li>
                    </div>
                    <?php
                }
            }
            
        } catch (Exception $e) {
            return $e;
        }
    }

    public function buscarFluxo($id = null) {
        try {
            $daoFluxo = new DaoFluxo();
            $retorno = $daoFluxo->buscarFluxo($id,$_SESSION["login"]->getId());
            $daoFluxo->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function listarDistinctFluxo() {
    	try {
    		$daoFluxo = new DaoFluxo();
    		$retorno = $daoFluxo->listarDistinctFluxo();
    		$daoFluxo->__destruct();
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
}

?>