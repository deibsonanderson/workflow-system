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
    				$this->montarIdUsuario($_SESSION["login"]->getId()).
    		        $this->sqlOrderBy('id', DaoBase::DESC),
    				'Fluxo');
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function listarFluxoProcessoAgenda($id_usuario = null, $dataIn = null, $tipo = null) {
        try {
            /*
            var_dump($this->montarSQLProcessoFluxo().
            $this->montarIdUsuario($id_usuario,'wp').
            $this->validaTipoDisplayAgenda($tipo, $dataIn).
            " ORDER BY wp.data DESC, wpf.ativo ASC, wp.id DESC ");
            die();
            */
            return $this->montarListarProcessoFluxo($this->executar(
                $this->montarSQLProcessoFluxo().
                $this->montarIdUsuario($id_usuario,'wp').
                $this->validaTipoDisplayAgenda($tipo, $dataIn).
                " ORDER BY wp.data DESC, wpf.ativo ASC, wp.id DESC "));
        } catch (Exception $e) {
            return $e;
        }
    }
    
    private function validaTipoDisplayAgenda($tipo = null, $dataIn = null){
        switch ($tipo) {
            case 'listWeek':
            case 'agendaWeek':
                $date = date_create($dataIn);
                date_add($date, date_interval_create_from_date_string("6 days"));                
                return " AND CONCAT(YEAR(wp.data),'-',LPAD(MONTH(wp.data), 2, '0'),'-',LPAD(wpf.vencimento_atividade, 2, '0')) between date('".$dataIn."') and date('".date_format($date, "Y-m-d")."') ";
                break;
            case 'agendaDay':
                return " AND CONCAT(YEAR(wp.data),'-',LPAD(MONTH(wp.data), 2, '0'),'-',LPAD(wpf.vencimento_atividade, 2, '0')) =  date('".$dataIn."') ";
                break;
            default:
                return " AND (MONTH(wp.data) = MONTH('".$dataIn."') AND YEAR(wp.data) = YEAR('".$dataIn."')) ";
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
                            LPAD(wpf.vencimento_atividade, 2, '0') AS vencimento_processo_fluxo,
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
    
    public function listarFluxoProcessoSimplificado($id_usuario = null) {
        try {
            //echo $this->montarSQLProcessoFluxo().$this->montarIdUsuario($id_usuario,'wp')." ORDER BY wp.data DESC, wpf.ativo ASC, wp.id DESC ";
            //die();
            return $this->montarListarProcessoFluxoSimplificado($this->executar(
                $this->montarSQLProcessoFluxoSimplificado().
                $this->montarIdUsuario($id_usuario,'wp').
                " GROUP BY wp.id  ORDER BY wp.data DESC, wpf.ativo ASC, wp.id DESC "));
        } catch (Exception $e) {
            return $e;
        }
    }
    
    private function montarSQLProcessoFluxoSimplificado(){
        try {
            return "SELECT  wp.id_titulo_fluxo,
                            wtf.titulo AS titulo_fluxo,
                            wp.id as id_processo,
                            wp.descricao as descricao_processo,
                            wp.titulo as titulo_processo,                            
							wp.data as data_processo,                            
							wp.provisao as provisao_processo,
                    		SUM(CASE
                        		WHEN wa.propriedade = '1' THEN wpf.valor_atividade ELSE -wpf.valor_atividade
                    		END) AS total_valor_atividade,
                    		SUM(CASE
                        		WHEN wpf.ativo = '1' THEN 1 ELSE 0
                    		END) AS total_ativo							
                    FROM ".DaoBase::TABLE_PROCESSO_FLUXO." wpf
                    INNER JOIN ".DaoBase::TABLE_PROCESSO." wp ON (wpf.id_processo = wp.id)
                    INNER JOIN ".DaoBase::TABLE_TITULO_FLUXO." wtf ON (wtf.id = wp.id_titulo_fluxo)
                    INNER JOIN ".DaoBase::TABLE_FLUXO." wf ON (wpf.id_fluxo = wf.id)
                    INNER JOIN ".DaoBase::TABLE_ATIVIDADE." wa ON (wf.id_atividade = wa.id)					
                    WHERE wpf.status = '1' AND wp.status = '1' ";
        } catch (Exception $e) {
            return $e;
        }
    }
    
    private function montarListarProcessoFluxoSimplificado($query){
        $retorno = array();        
        $processo = null;
        while ($objetoProcessoSimplificado = mysqli_fetch_object($query)) {
            $processo = new ProcessoSimplificado();
            $processo->setId($objetoProcessoSimplificado->id_processo);
            $processo->setTitulo($objetoProcessoSimplificado->titulo_processo);            
            $processo->setDescricao($objetoProcessoSimplificado->descricao_processo);
            $processo->setData($objetoProcessoSimplificado->data_processo);
            $processo->setProvisao($objetoProcessoSimplificado->provisao_processo);
            
            
            $processo->setIdTituloFluxo($objetoProcessoSimplificado->id_titulo_fluxo);
            $processo->setTituloFluxo($objetoProcessoSimplificado->titulo_fluxo);
            
            $processo->setTotalAtivo($objetoProcessoSimplificado->total_ativo);
            $processo->setTotalValorAtividade($objetoProcessoSimplificado->total_valor_atividade);
            
            $retorno[] = $processo;
            
        }        
        
        return $retorno;
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
    
    
    private function montarSQlProcessoGeral(){
        return "SELECT     wpf.id AS id_processo_fluxo,
                           wpf.id_processo AS wpf_id_processo,
						   wpf.status AS status_wpf,
                           wpf.fixa_atividade AS fixa_atividade_wpf,
                           wpf.atuante AS atuante_wpf,
                           wpf.propriedade_atividade AS propriedade_atividade_wpf,
                           wpf.titulo_atividade AS titulo_atividade_wpf,
                           wpf.valor_atividade AS valor_atividade_wpf,
                           wpf.vencimento_atividade AS vencimento_atividade_wpf,
                           wpf.descricao_atividade AS descricao_atividade_wpf,
                           wpf.out_flow AS out_flow_wpf,
						   
						   
                           wc.id AS id_comentario,
                           wc.descricao AS descricao_comentario,
                           wc.arquivo AS anexo_comentario,
						   wc.categoria AS categoria_comentario,
                           wc.data AS data_comentario,
                           wc.status AS status_comentario,                           
						   
                           wa.id AS id_atividade, 
                           wa.titulo AS titulo_atividade,
                           wa.status AS status_atividade,
                           wa.imagem AS imagem_atividade,
                           wa.link AS link_atividade, 
                           wca.nome AS nome_categoria_atividade, 
						   
                           wtf.id AS id_fluxo,     
                           wtf.titulo AS titulo_fluxo,
                           wtf.descricao AS descricao_fluxo, 
                           wtf.status AS status_fluxo,
                           
                           wp.id AS id_processo, 
                           wp.titulo AS processo_titulo,
                           wp.provisao AS provisao_processo, 
                           wp.descricao AS descricao_processo, 
                           wp.data AS data_processo,
						   wp.status AS status_processo


                 FROM ".DaoBase::TABLE_PROCESSO_FLUXO." wpf
                 LEFT JOIN ".DaoBase::TABLE_COMENTARIO." wc ON (wpf.id = wc.id_processo_fluxo)
				 INNER JOIN ".DaoBase::TABLE_FLUXO." wf ON ( wf.id = wpf.id_fluxo )
                 INNER JOIN ".DaoBase::TABLE_TITULO_FLUXO." wtf ON ( wf.id_titulo_fluxo = wtf.id )
                 INNER JOIN ".DaoBase::TABLE_PROCESSO." wp ON (wp.id = wpf.id_processo)
                 INNER JOIN ".DaoBase::TABLE_ATIVIDADE." wa ON (wa.id = wf.id_atividade)
                 INNER JOIN ".DaoBase::TABLE_CATEGORIA_ATIVIDADE." wca ON (wa.id_categoria = wca.id)
                 WHERE wpf.status = 1 AND wp.status = 1 AND wc.status = 1
				 ORDER BY wp.id, wtf.id, wa.id, wc.id ASC ";
    }

    private function montarListarProcessoGeral($query) {
        $objetos = array();
        while ($objeto = mysqli_fetch_object($query)) {
            $objetos[] = $objeto;
        }      
        //debug($objetos);
        // Carregar Processos
        $processos = array();
        foreach ($objetos as $objeto) {

            if ($processos[$objeto->id_processo] == null && $objeto->status_processo == 1 && $objeto->status_wpf == 1 ) {
                $processo = new Processo();
                $processo->setId($objeto->id_processo);
                $processo->setTitulo($objeto->processo_titulo);
                $processo->setProvisao($objeto->provisao_processo);
                $processo->setDescricao($objeto->descricao_processo);
                $processo->setData($objeto->data_processo);
                $processo->setStatus($this->formatterStatus($objeto->status_processo));
                
                $fluxo = new Fluxo();
                $fluxo->setId(($objeto->id_fluxo != null)?$objeto->id_fluxo:"N/A");
                $fluxo->setTitulo(($objeto->titulo_fluxo != null) ? $objeto->titulo_fluxo : "N/A");
                $fluxo->setDescricao($objeto->descricao_fluxo);
                $fluxo->setStatus($this->formatterStatus($objeto->status_fluxo));
                $processo->setFluxo($fluxo);               

                $processos[$objeto->id_processo] = $processo;
            }
        }
        
        //Carregar Atividade
        foreach ($processos as $processo) {
            $atividades = array();
            $ultimaAtividade = null;
            foreach ($objetos as $objeto) {
                if ($processo->getId() == $objeto->id_processo) {
                    if($ultimaAtividade == null || $ultimaAtividade != $objeto->id_atividade){
                        $atividade = new Atividade();
                        $atividade->setId($objeto->id_atividade);
                        $atividade->setTitulo($objeto->titulo_atividade_wpf);
                        $atividade->setIdFluxo($objeto->id_processo_fluxo);
                        $atividade->setCategoria($objeto->nome_categoria_atividade);
                        $atividade->setFixa($this->formatterFixo($objeto->fixa_atividade_wpf));
                        $atividade->setPropriedade(($objeto->propriedade_atividade_wpf == 1)?'Positivo':'Negativo');
                        $atividade->setValor($this->formatterValor($objeto->propriedade_atividade_wpf, $objeto->valor_atividade_wpf));
                        $atividade->setVencimento($objeto->vencimento_atividade_wpf);
                        $atividade->setDescricao($objeto->descricao_atividade_wpf);
                        $atividade->setStatus($objeto->status_atividade);
                        $atividade->setImagem($objeto->imagem_atividade);
                        $atividade->setLink($objeto->link_atividade);
                        $atividade->setOutFlow($this->formatterOutFlow($objeto->out_flow_wpf));                      
                        
                        $atividades[] = $atividade;
                        
                        $ultimaAtividade = $objeto->id_atividade;
                    }
                }
            }

            //Carregar Comentarios
            
            foreach ($atividades as $atividade) {
                $comentarios = null;
                foreach ($objetos as $objeto) {
                    if ($atividade->getId() == $objeto->id_atividade 
                        && $objeto->id_comentario != null
                        && $atividade->getIdFluxo() == $objeto->id_processo_fluxo) {
                        
                        if($comentarios == null){
                            $comentarios = array();
                        }
                        
                        $comentario = new ComentarioFluxoProcesso();
                        $comentario->setId($objeto->id_comentario);
                        $comentario->setDescricao($objeto->descricao_comentario);
                        $comentario->setArquivo($objeto->anexo_comentario);
                        $comentario->setCategoria($this->getCategoriaAnexo($objeto->categoria_comentario));
                        $comentario->setData($objeto->data_comentario);
                        $comentario->setStatus($this->formatterStatus($objeto->status_comentario));
                        $comentarios[] = $comentario;
                    }
                }
                
                $atividade->setIdFluxo(null);
                $atividade->setComentarios($comentarios);
            }
            
            $processo->getFluxo()->setAtividades($atividades);
        }       

        return $processos;
    }
    
    public function listarProcessoGeral() {
        try {
			//var_dump($this->montarSQlProcessoGeral());
            return $this->montarListarProcessoGeral($this->executar($this->montarSQlProcessoGeral()));
        } catch (Exception $e) {
            return $e;
        }
    }
    
    private function formatterStatus($status){
        return ($status == '1')?'Ativo':'Inativo';        
    }
    
    private function getCategoriaAnexo($categoria){
        $return = "";
        switch ($categoria) {
            case '1' :
                $return = 'Boleto';
                break;
            case '2' :
                $return = 'Comprovante';
                break;
            case '3' :
                $return =  'Fatura';
                break;
            case '4' :
                $return = 'Documento';
                break;
            case '5' :
                $return =  'Nota Fiscal';
                break;
            case '6' :
                $return = 'Outros';
                break;
            default :
                $return =  'Sem anexo';
                break;
        }
        return $return;
    }
    
    private function formatterValor($prop,$valor){
        return ($prop == 0)?'-'.$valor:$valor;
    }
    
    private function formatterFixo($fixo){
        return ($fixo == 0)?'Fixo':'Variável';
    }

    private function formatterOutFlow($flow){
        return ($flow == 0)?'Recorrente':'Avulso';
    }
    
    
}

?>