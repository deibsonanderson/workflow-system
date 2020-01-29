<?php
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
class DaoProcesso extends DaoBase {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }    
    
    public function atualizarValorFluxoProcesso($fluxoProcesso) {
    	try {
    		return $this->executar($this->sqlAtualizarMultiCustom(DaoBase::TABLE_PROCESSO_FLUXO, $fluxoProcesso->getId(), 
    				array('valor_atividade', 'propriedade_atividade'),
    				array($fluxoProcesso->getValor(),$fluxoProcesso->getPropriedade() )));
    	} catch (Exception $e) {
    		return $e;
    	}
    }    
  
    public function atualizarTituloFluxoProcesso($fluxoProcesso) {
    	try {
    		return $this->executar($this->sqlAtualizarMultiCustom(DaoBase::TABLE_PROCESSO_FLUXO, $fluxoProcesso->getId(),
    				array('titulo_atividade'), array($fluxoProcesso->getTitulo() )));
    	} catch (Exception $e) {
    		return $e;
    	}
    }    
    
    public function atualizarFixaFluxoProcesso($fluxoProcesso) {
    	try {
    		return $this->executar($this->sqlAtualizarMultiCustom(DaoBase::TABLE_PROCESSO_FLUXO, $fluxoProcesso->getId(),
    				array('fixa_atividade'), array($fluxoProcesso->getFixa() )));
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function atualizarDescricaoFluxoProcesso($fluxoProcesso) {
    	try {
    		return $this->executar($this->sqlAtualizarMultiCustom(DaoBase::TABLE_PROCESSO_FLUXO, $fluxoProcesso->getId(),
    				array('descricao_atividade'), array($fluxoProcesso->getDescricao() )));
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function atualizarVencimentoFluxoProcesso($fluxoProcesso) {
    	try {
    		return $this->executar($this->sqlAtualizarMultiCustom(DaoBase::TABLE_PROCESSO_FLUXO, $fluxoProcesso->getId(),
    				array('vencimento_atividade'), array($fluxoProcesso->getVencimento() )));
    	} catch (Exception $e) {
    		return $e;
    	}
    }  
    
    public function listarProcesso($id = null) {
        try {
            $retorno = array();
            $query = $this->executar(" SELECT p.id, p.id_usuario, p.id_titulo_fluxo, p.titulo, p.provisao, p.descricao, p.data, p.status, tf.titulo AS titulo_fluxo ".
            		" FROM ".DaoBase::TABLE_PROCESSO." p INNER JOIN ".DaoBase::TABLE_TITULO_FLUXO." tf ON (tf.id = p.id_titulo_fluxo) ".
            		"WHERE p.status = '1' ".$this->montarId($id,'p') );
           
            while ($objetoProcesso = mysqli_fetch_object($query)) {
            	$processo = $this->modelMapper($objetoProcesso, new Processo());
                
                $fluxo = new Fluxo();
                $fluxo->setId($objetoProcesso->id_titulo_fluxo);
                $fluxo->setTitulo($objetoProcesso->titulo_fluxo);
                $processo->setFluxo($fluxo);

                $usuario = new Usuario();
                $usuario->setId($objetoProcesso->id_usuario);
                $processo->setUsuario($usuario);

                $retorno[] = $processo;
            }
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function incluirProcesso($processo,$listFluxoAtividade) {
        try {
            $conexao = $this->ConectarBanco();
            $sql_processo = "INSERT INTO ".DaoBase::TABLE_PROCESSO." (id_usuario,id_titulo_fluxo,titulo, descricao,provisao,data, status) VALUES ('" . $processo->getUsuario()->getId() . "','" . $processo->getFluxo()->getId() . "','" . $processo->getTitulo() . "','" . $processo->getDescricao() . "','" . $processo->getProvisao() . "',".$processo->getData().",'" . $processo->getStatus() . "')";
            mysqli_query($conexao, $sql_processo) or die('Erro na execução  do insert!');
            sleep(1);
            $id_processo = mysqli_insert_id($conexao);

            $atuante = 1;
            $sql = "INSERT INTO ".DaoBase::TABLE_PROCESSO_FLUXO." (id_processo ,id_fluxo, atuante,ativo ,status, valor_atividade, propriedade_atividade, out_flow, vencimento_atividade, descricao_atividade, titulo_atividade, fixa_atividade) VALUES ";
            foreach ($listFluxoAtividade as $atividade) {
            	$sql .= "(" . $id_processo . "," . $atividade->getIdFluxo() . ",".$atuante.",1 , 1, " . $atividade->getValor() . "," . $atividade->getPropriedade() . ",0,'" . $atividade->getVencimento() . "','" . $atividade->getDescricao() . "','" . $atividade->getTitulo() . "','" . $atividade->getFixa() . "' ),";
                $atuante = 0;
            }
            $sql_fluxo = substr($sql, 0, -1);
            $retorno = mysqli_query($conexao, $sql_fluxo) or die('Erro na execução  do insert tb_workflow_processo_fluxo!');

            $this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function incluirProcessoFluxo($fluxoProcesso) {
    	try {
    		return $this->executar("INSERT INTO ".DaoBase::TABLE_PROCESSO_FLUXO." (id_processo ,id_fluxo, atuante,ativo ,status, valor_atividade, propriedade_atividade, out_flow, vencimento_atividade,descricao_atividade, titulo_atividade, fixa_atividade) VALUES ".
    				"('" . $fluxoProcesso->getProcesso() . "','" . $fluxoProcesso->getId_fluxo() . "','0', '1' , '1', '" . $fluxoProcesso->getValor() . "','" . $fluxoProcesso->getPropriedade() . "',1," . $fluxoProcesso->getVencimento() . ",'" . $fluxoProcesso->getDescricao() . "','" . $fluxoProcesso->getTitulo() . "','" . $fluxoProcesso->getFixa() . "' )");
    	} catch (Exception $e) {
    		return $e;
    	}
    }

    public function excluirProcesso($id) {
        try {
        	return $this->executarMulti(array(
        			"UPDATE ".DaoBase::TABLE_PROCESSO_FLUXO." SET status = '0' WHERE id_processo = $id",
        			$this->sqlExcluir(DaoBase::TABLE_PROCESSO, $id)
        	));
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function excluirProcessoFluxo($id) {
    	try {
    		return $this->executar($this->sqlExcluir(DaoBase::TABLE_PROCESSO_FLUXO, $id));
    	} catch (Exception $e) {
    		return $e;
    	}
    }

    public function abrirFecharFluxoProcesso($fluxoProcesso) {
        try {
        	return $this->executar($this->sqlAtualizarCustom(DaoBase::TABLE_PROCESSO_FLUXO, $fluxoProcesso, array('ativo', 'atuante')));
        } catch (Exception $e) {
            return $e;
        }
    }
    
    private function buscarIdProcessoByFluxoProcessoId($fluxoProcesso){
    	$processo = $this->executarQuery("SELECT id_processo AS id FROM ".DaoBase::TABLE_PROCESSO_FLUXO." WHERE id = " . 
    					$fluxoProcesso->getId(), 'Processo', false);
    	return (count($processo)>0)?$processo[0]->getId():null;
    }
    
    public function atuarFluxoProcesso($fluxoProcesso) {
        try {
        	$id_processo = $this->buscarIdProcessoByFluxoProcessoId($fluxoProcesso);
        	if ($id_processo) {
        		$retorno = $this->executarMulti(array("UPDATE ".DaoBase::TABLE_PROCESSO_FLUXO." SET atuante = '0' WHERE id_processo = " . $id_processo,
	        				"UPDATE ".DaoBase::TABLE_PROCESSO_FLUXO." SET atuante = '1' WHERE id = " . $fluxoProcesso->getId()));
            }            
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
        
    public function desatuarFluxoProcesso($fluxoProcesso) {
        try {
        	$id_processo = $this->buscarIdProcessoByFluxoProcessoId($fluxoProcesso);
        	if ($id_processo) {
        		$retorno = $this->executar("UPDATE ".DaoBase::TABLE_PROCESSO_FLUXO." SET atuante = '0' WHERE id_processo = " . $id_processo);
        	} 
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function alterarProcesso($processo){
    	try {
    		return $this->executar($this->sqlAtualizar(DaoBase::TABLE_PROCESSO, $processo));
    	} catch (Exception $e) {
    		return $e;
    	}
    }    
    
    public function buscarProcessoByFluxoProcessoId($id = null){
    	return $this->executarQuery("SELECT wp.id,
										    wp.titulo,
											wp.provisao,
											wp.descricao,
											wp.data,
											wp.status
										FROM ".DaoBase::TABLE_PROCESSO_FLUXO." wpf
										INNER JOIN ".DaoBase::TABLE_PROCESSO." wp ON (wpf.id_processo = wp.id)
										WHERE wpf.`id` = ".$id, 'Processo');
    }
        
    public function listarDistinctProcesso() {
    	try {
    		return $this->executarQuery(
    				$this->sqlSelect(DaoBase::TABLE_PROCESSO, array('id', 'titulo'), true).
    				$this->montarIdUsuario($_SESSION["login"]->getId()),
    				'Fluxo');
    	} catch (Exception $e) {
    		return $e;
    	}
    }    
    
    public function listarFluxoProcesso($id_usuario = null) {
    	try {
    		return $this->montarListarProcessoFluxo($this->executar(
    				$this->montarSQLProcessoFluxo().
    				$this->montarIdUsuario($id_usuario,'wp').
    				" ORDER BY wp.data DESC, wpf.ativo ASC, wp.id DESC "));
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function buscarFluxoProcesso($id = null, $order = null) {
        try {
        	if($order == null || $order == ''){
            	$sql = " ORDER BY wf.ordenacao ASC ";
            }else{
            	$sql = $order;
            }  
            return $this->montarListarProcessoFluxo($this->executar(
            		$this->montarSQLProcessoFluxo().$this->montarId($id,'wp').$sql));
        } catch (Exception $e) {
            return $e;
        }
    }
    
    private function montarSQLProcessoFluxo(){
    	try {
    		return "SELECT  wpf.id,
                            wp.id_titulo_fluxo,
                            wtf.titulo AS titulo_fluxo,
                            wp.id as id_processo,
                            wp.titulo as titulo_processo,
							wp.descricao as descricao_processo,
                            wpf.id_fluxo,
                            wpf.atuante,
                            wp.data as data_processo,
                            wpf.ativo,
                            wf.id_atividade,
                            wa.titulo AS titulo_atividade,
                            wa.imagem AS imagem_atividade,
                            wa.arquivo AS arquivo_atividade,
							wa.valor AS valor_atividade,
							wa.propriedade AS propriedade_atividade,
							wa.link AS link_atividade,
                            wa.descricao AS descricao_atividade,
                            wa.vencimento AS vencimento_atividade,
							wpf.valor_atividade AS valor_processo_fluxo,
							wpf.titulo_atividade AS titulo_processo_fluxo,
							wpf.propriedade_atividade AS propriedade_processo_fluxo,
							wpf.fixa_atividade AS fixa_processo_fluxo,
							wa.fixa AS fixa_atividade,
							wp.id_usuario,
							wp.provisao,
							wf.ordenacao,
							wpf.out_flow,
                            wpf.vencimento_atividade AS vencimento_processo_fluxo,
                            wpf.descricao_atividade AS descricao_processo_fluxo,
                            wc.nome AS titulo_categoria_atividade
                    FROM ".DaoBase::TABLE_PROCESSO_FLUXO." wpf
                    INNER JOIN ".DaoBase::TABLE_PROCESSO." wp ON (wpf.id_processo = wp.id)
                    INNER JOIN ".DaoBase::TABLE_TITULO_FLUXO." wtf ON (wtf.id = wp.id_titulo_fluxo)
                    INNER JOIN ".DaoBase::TABLE_FLUXO." wf ON (wpf.id_fluxo = wf.id)
                    INNER JOIN ".DaoBase::TABLE_ATIVIDADE." wa ON (wf.id_atividade = wa.id)
					INNER JOIN ".DaoBase::TABLE_CATEGORIA_ATIVIDADE." wc ON (wa.id_categoria = wc.id)
                    WHERE wpf.status = '1' AND wp.status = '1' ";
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    private function montarListarProcessoFluxo($query){
    	$retorno = array();
    	$ultimo_id = 0;
    	$processo = new Processo();
    	while ($objetoFluxoProcesso = mysqli_fetch_object($query)) {
    		if ($ultimo_id != $objetoFluxoProcesso->id_processo) {
    			if ($ultimo_id !== 0) {
    				$processo->setFluxoProcesso($aux);
    				$aux = null;
    				$retorno[] = $processo;
    			}
    			$processo = new Processo();
    			$processo->setId($objetoFluxoProcesso->id_processo);
    			$processo->setTitulo($objetoFluxoProcesso->titulo_processo);
    			$processo->setDescricao($objetoFluxoProcesso->descricao_processo);
    			$processo->setData($objetoFluxoProcesso->data_processo);
    			$processo->setProvisao($objetoFluxoProcesso->provisao);
    			$fluxo = new Fluxo();
    			$fluxo->setId($objetoFluxoProcesso->id_titulo_fluxo);
    			$fluxo->setTitulo($objetoFluxoProcesso->titulo_fluxo);
    			$processo->setFluxo($fluxo);
    			
    			$usuario = new Usuario();
    			$usuario->setId($objetoFluxoProcesso->id_usuario);
    			$processo->setUsuario($usuario);
    			
    			$ultimo_id = $objetoFluxoProcesso->id_processo;
    		}
    		
    		$fluxoProcesso = new FluxoProcesso();
    		$fluxoProcesso->setId($objetoFluxoProcesso->id);
    		$fluxoProcesso->setId_fluxo($objetoFluxoProcesso->id_fluxo);
    		$fluxoProcesso->setAtivo($objetoFluxoProcesso->ativo);
    		$fluxoProcesso->setAtuante($objetoFluxoProcesso->atuante);
    		$fluxoProcesso->setTitulo($objetoFluxoProcesso->titulo_processo_fluxo);
    		$fluxoProcesso->setOutFlow($objetoFluxoProcesso->out_flow);
    		$fluxoProcesso->setVencimento($objetoFluxoProcesso->vencimento_processo_fluxo);
    		$fluxoProcesso->setDescricao($objetoFluxoProcesso->descricao_processo_fluxo);
    		$fluxoProcesso->setValor($objetoFluxoProcesso->valor_processo_fluxo);
    		$fluxoProcesso->setPropriedade($objetoFluxoProcesso->propriedade_processo_fluxo);
    		$fluxoProcesso->setFixa($objetoFluxoProcesso->fixa_processo_fluxo);
    		
    		$categoriaAtividade = new CategoriaAtividade();
    		$categoriaAtividade->setNome($objetoFluxoProcesso->titulo_categoria_atividade);
    		
    		$atividade = new Atividade();
    		$atividade->setId($objetoFluxoProcesso->id_atividade);
    		$atividade->setTitulo($objetoFluxoProcesso->titulo_atividade);
    		$atividade->setDescricao($objetoFluxoProcesso->descricao_atividade);
    		$atividade->setArquivo($objetoFluxoProcesso->arquivo_atividade);
    		$atividade->setLink($objetoFluxoProcesso->link_atividade);
    		$atividade->setImagem($objetoFluxoProcesso->imagem_atividade);
    		$atividade->setVencimento($objetoFluxoProcesso->vencimento_atividade);
    		$atividade->setValor($objetoFluxoProcesso->valor_atividade);
    		$atividade->setPropriedade($objetoFluxoProcesso->propriedade_atividade);
    		$atividade->setFixa($objetoFluxoProcesso->fixa_atividade);
    		$atividade->setCategoria($categoriaAtividade);
    		
    		
    		$fluxoProcesso->setAtividade($atividade);
    		
    		$aux[] = $fluxoProcesso;
    	}
    	$processo->setFluxoProcesso($aux);
    	
    	$retorno[] = $processo;
    	
    	return $retorno;
    }
    
    public function listarAtividadesProcessosHaVencer($id_usuario = null) {
    	try {
    		$retorno = array();
    		$limitDay = 25;

    		$sql = "SELECT  wpf.id,
                            wp.id_titulo_fluxo,
                            wtf.titulo AS titulo_fluxo,
                            wp.id as id_processo,
                            wp.titulo as titulo_processo,
			                wp.descricao as descricao_processo,
							wp.provisao as provisao,
                            wpf.id_fluxo,
                            wpf.atuante,
                            wp.data as data_processo,
							wpf.fixa_atividade AS fixa_processo_fluxo,
							wa.fixa AS fixa_atividade,
                            wpf.ativo,
                            wf.id_atividade,
                            wpf.titulo_atividade AS titulo_atividade,
                            wa.imagem AS imagem_atividade,
                            wa.arquivo AS arquivo_atividade,
                            wa.descricao AS descricao_atividade,
							wpf.valor_atividade AS valor,
							wpf.propriedade_atividade AS propriedade,
                            wpf.titulo_atividade AS titulo_processo_fluxo,
                            wp.id_usuario,
							wa.vencimento,
                            CONCAT(LPAD( (CASE WHEN wa.vencimento > DAY(LAST_DAY(wp.data)) THEN DAY(LAST_DAY(wp.data)) ELSE wa.vencimento END ), 2, 0) ,'/',LPAD( MONTH(wp.data), 2, 0),'/',YEAR(wp.data)) as vencimento_format,
							CONCAT(LPAD( (CASE WHEN wa.vencimento > DAY(LAST_DAY(wp.data)) THEN DAY(LAST_DAY(wp.data)) ELSE wa.vencimento END ), 2, 0),'/',LPAD( MONTH(wp.data+ INTERVAL ".$limitDay." DAY), 2, 0),'/', YEAR(wp.data+ INTERVAL ".$limitDay." DAY)) as vencimento_next
					FROM tb_workflow_processo_fluxo wpf
                    INNER JOIN tb_workflow_processo wp ON (wpf.id_processo = wp.id)
                    INNER JOIN tb_workflow_titulo_fluxo wtf ON (wtf.id = wp.id_titulo_fluxo)
                    INNER JOIN tb_workflow_fluxo wf ON (wpf.id_fluxo = wf.id)
                    INNER JOIN tb_workflow_atividade wa ON (wf.id_atividade = wa.id)
                    WHERE wpf.status = '1' AND wpf.ativo = '1' AND wp.status = '1' AND wa.vencimento != '' AND wa.vencimento IS NOT NULL
                    AND (
									
	                    STR_TO_DATE(CONCAT(YEAR(wp.data),'-',MONTH(wp.data),'-',
	                    (CASE WHEN wa.vencimento > DAY(LAST_DAY(wp.data)) THEN DAY(LAST_DAY(wp.data)) ELSE wa.vencimento END )
	                    ), '%Y-%m-%d') BETWEEN
	                    STR_TO_DATE(CONCAT(YEAR(NOW() - INTERVAL ".$limitDay." DAY),'-',MONTH(NOW() - INTERVAL ".$limitDay." DAY),'-',DAY(NOW() - INTERVAL ".$limitDay." DAY)), '%Y-%m-%d') AND
	                    STR_TO_DATE(CONCAT(YEAR(NOW() + INTERVAL ".$limitDay." DAY),'-',MONTH(NOW() + INTERVAL ".$limitDay." DAY),'-',DAY(NOW() + INTERVAL ".$limitDay." DAY)), '%Y-%m-%d')
	                    		
					OR
	                    		
						STR_TO_DATE(CONCAT(YEAR(wp.data + INTERVAL ".$limitDay." DAY),'-',MONTH(wp.data + INTERVAL ".$limitDay." DAY),'-',
	                    (CASE WHEN wa.vencimento > DAY(LAST_DAY(wp.data)) THEN DAY(LAST_DAY(wp.data)) ELSE wa.vencimento END )
	                    ), '%Y-%m-%d') BETWEEN
	                    STR_TO_DATE(CONCAT(YEAR(NOW() - INTERVAL ".$limitDay." DAY),'-',MONTH(NOW() - INTERVAL ".$limitDay." DAY),'-',DAY(NOW() - INTERVAL ".$limitDay." DAY)), '%Y-%m-%d') AND
	                    STR_TO_DATE(CONCAT(YEAR(NOW() + INTERVAL ".$limitDay." DAY),'-',MONTH(NOW() + INTERVAL ".$limitDay." DAY),'-',DAY(NOW() + INTERVAL ".$limitDay." DAY)), '%Y-%m-%d')
	                    		
					)";
    		
    		$sql .= ($id_usuario != null) ? " AND wp.id_usuario = " . $id_usuario : "";
    		
    		$sql .= " ORDER BY CONCAT(YEAR(wp.data),'-',LPAD( MONTH(wp.data), 2, 0),'-',LPAD( (CASE WHEN wa.vencimento > DAY(LAST_DAY(wp.data)) THEN DAY(LAST_DAY(wp.data)) ELSE wa.vencimento END ), 2, 0)) ASC ";
    		
    		$query = $this->executar($sql);
    		$ultimo_id = 0;
    		$processo = new Processo();
    		while ($objetoFluxoProcesso = mysqli_fetch_object($query)) {
    			if ($ultimo_id != $objetoFluxoProcesso->id_processo) {
    				if ($ultimo_id !== 0) {
    					$processo->setFluxoProcesso($aux);
    					$aux = null;
    					$retorno[] = $processo;
    				}
    				$processo = new Processo();
    				$processo->setId($objetoFluxoProcesso->id_processo);
    				$processo->setTitulo($objetoFluxoProcesso->titulo_processo);

    				$ultimo_id = $objetoFluxoProcesso->id_processo;
    			}
    			
    			$fluxoProcesso = new FluxoProcesso();
    			$fluxoProcesso->setId($objetoFluxoProcesso->id);
    			$fluxoProcesso->setId_fluxo($objetoFluxoProcesso->id_fluxo);
    			$fluxoProcesso->setAtivo($objetoFluxoProcesso->ativo);
    			$fluxoProcesso->setAtuante($objetoFluxoProcesso->atuante);
    			$fluxoProcesso->setFixa($objetoFluxoProcesso->fixa_processo_fluxo);
    			$fluxoProcesso->setTitulo($objetoFluxoProcesso->titulo_processo_fluxo);
    			$fluxoProcesso->setValor($objetoFluxoProcesso->valor_processo_fluxo);
    			$fluxoProcesso->setDescricao($objetoFluxoProcesso->descricao_processo_fluxo);
    			$fluxoProcesso->setPropriedade($objetoFluxoProcesso->propriedade_processo_fluxo);
    			if($objetoFluxoProcesso->vencimento_processo_fluxo < date("d")){
    				$dataFormatada = $objetoFluxoProcesso->vencimento_next;
    			}else{
    				$dataFormatada = $objetoFluxoProcesso->vencimento_format;
    			}
    			$fluxoProcesso->setVencimento($dataFormatada);
    			
    			$atividade = new Atividade();
    			$atividade->setId($objetoFluxoProcesso->id_atividade);
    			$fluxoProcesso->setAtividade($atividade);
    			
    			$aux[] = $fluxoProcesso;
    		}
    		$processo->setFluxoProcesso($aux);
    		
    		$retorno[] = $processo;
    		
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
}

?>