<?php
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
class DaoProcesso extends Dados {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }    
    
    public function atualizarValorFluxoProcesso($fluxoProcesso) {
    	try {
    		$conexao = $this->ConectarBanco();
    		$sql = "UPDATE tb_workflow_processo_fluxo SET valor_atividade=". $fluxoProcesso->valor_atividade. ", propriedade_atividade = ". $fluxoProcesso->propriedade. "  WHERE id = " . $fluxoProcesso->getId() . "";
    		$retorno = mysqli_query($conexao,$sql) or die('Erro na update valor atividade!');
    		$this->FecharBanco($conexao);
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    

    public function listarProcesso($id = null) {
        try {
            $retorno = array();
            $conexao = $this->ConectarBanco();
            $sql = "SELECT id,id_usuario,id_titulo_fluxo,titulo,provisao, descricao,data, status FROM tb_workflow_processo WHERE status = '1' ";
            $sql .= ($id != null) ? " AND id = " . $id : "";
            $query = mysqli_query($conexao,$sql) or die('Erro na execução  do listar!');
            while ($objetoProcesso = mysqli_fetch_object($query)) {
                $processo = new Processo();
                $processo->setId($objetoProcesso->id);
				$processo->setTitulo($objetoProcesso->titulo);
                $processo->setDescricao($objetoProcesso->descricao);
                $processo->setStatus($objetoProcesso->status);
                $processo->setProvisao($objetoProcesso->provisao);
                $processo->setData($objetoProcesso->data);
                
                $fluxo = new Fluxo();
                $fluxo->setId($objetoProcesso->id_titulo_fluxo);
				
                    $controladorFluxo = new ControladorFluxo();
                    $listFluxo = $controladorFluxo->buscarFluxo($objetoProcesso->id_titulo_fluxo);
                    if($listFluxo != null){
                            $fluxo->setTitulo($listFluxo[0]->getTitulo());
                    }
                $processo->setFluxo($fluxo);

                $usuario = new Usuario();
                $usuario->setId($objetoProcesso->id_usuario);
                $processo->setUsuario($usuario);

                $retorno[] = $processo;
            }
            $this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function listarFluxoProcesso($id_usuario = null) {
        try {
            $retorno = array();
            $conexao = $this->ConectarBanco();
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
                            wpf.ativo,
                            wf.id_atividade,
                            wpf.titulo_atividade AS titulo_atividade,
                            wa.imagem AS imagem_atividade,
                            wa.arquivo AS arquivo_atividade,
                            wa.descricao AS descricao_atividade,
							wa.vencimento AS vencimento_atividade,
							wpf.valor_atividade AS valor,
							wpf.propriedade_atividade AS propriedade,
                            wp.id_usuario
                    FROM tb_workflow_processo_fluxo wpf
                    INNER JOIN tb_workflow_processo wp ON (wpf.id_processo = wp.id)
                    INNER JOIN tb_workflow_titulo_fluxo wtf ON (wtf.id = wp.id_titulo_fluxo)
                    INNER JOIN tb_workflow_fluxo wf ON (wpf.id_fluxo = wf.id)
                    INNER JOIN tb_workflow_atividade wa ON (wf.id_atividade = wa.id)
                    WHERE wpf.status = '1' AND wp.status = '1' ";
            $sql .= ($id_usuario != null) ? " AND wp.id_usuario = " . $id_usuario : "";

            $sql .= " ORDER BY wp.data DESC, wpf.ativo ASC, wp.id DESC ";

            $query = mysqli_query($conexao,$sql) or die('Erro na execução  do listar!');
            $ultimo_id = 0;
            $processo = new Processo();
            while ($objetoFluxoProcesso = mysqli_fetch_object($query)) {
                if ($ultimo_id !== $objetoFluxoProcesso->id_processo) {
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

                $atividade = new Atividade();
                $atividade->setId($objetoFluxoProcesso->id_atividade);
                $atividade->setTitulo($objetoFluxoProcesso->titulo_atividade);
                $atividade->setDescricao($objetoFluxoProcesso->descricao_atividade);
                $atividade->setArquivo($objetoFluxoProcesso->arquivo_atividade);
                $atividade->setImagem($objetoFluxoProcesso->imagem_atividade);
                $atividade->setValor($objetoFluxoProcesso->valor);
                $atividade->setPropriedade($objetoFluxoProcesso->propriedade);
                $atividade->setVencimento($objetoFluxoProcesso->vencimento_atividade);
                
                $fluxoProcesso->setAtividade($atividade);

                $aux[] = $fluxoProcesso;
            }
            $processo->setFluxoProcesso($aux);

            $retorno[] = $processo;
            $this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function incluirProcesso($processo,$listFluxoAtividade) {
        try {
            $conexao = $this->ConectarBanco();
            $sql_processo = "INSERT INTO tb_workflow_processo(id_usuario,id_titulo_fluxo,titulo, descricao,provisao,data, status) VALUES ('" . $processo->getUsuario()->getId() . "','" . $processo->getFluxo()->getId() . "','" . $processo->getTitulo() . "','" . $processo->getDescricao() . "','" . $processo->getProvisao() . "',".$processo->getData().",'" . $processo->getStatus() . "')";
            mysqli_query($conexao, $sql_processo) or die('Erro na execução  do insert!');
            sleep(1);
            $id_processo = mysqli_insert_id($conexao);

            $atuante = 1;
            $sql = "INSERT INTO tb_workflow_processo_fluxo (id_processo ,id_fluxo, atuante,ativo ,status, valor_atividade, propriedade_atividade, titulo_atividade) VALUES ";
            foreach ($listFluxoAtividade as $atividade) {
            	$sql .= "(" . $id_processo . "," . $atividade->getIdFluxo() . ",".$atuante.",1 , 1, " . $atividade->getValor() . "," . $atividade->getPropriedade() . ",'" . $atividade->getTitulo() . "' ),";
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

    public function excluirProcesso($id) {
        try {
            $conexao = $this->ConectarBanco();

            $sql = "UPDATE tb_workflow_processo SET status = '0' WHERE id = " . $id . "";
            mysqli_query($conexao,$sql) or die('Erro na execução  do delet processo!');

            $sql = "UPDATE tb_workflow_processo_fluxo SET status = '0' WHERE id_processo = " . $id . "";
            $retorno = mysqli_query($conexao,$sql) or die('Erro na execução  do delet processo!');
            
            $this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function abrirFluxoProcesso($fluxoProcesso) {
        try {
            $conexao = $this->ConectarBanco();
            $sql = "UPDATE tb_workflow_processo_fluxo SET ativo = '1' WHERE id = " . $fluxoProcesso->getId() . "";
            $retorno = mysqli_query($conexao,$sql) or die('Erro na execução  do update!');
            $this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function fecharFluxoProcesso($fluxoProcesso) {
        try {
            $conexao = $this->ConectarBanco();
            $sql = "UPDATE tb_workflow_processo_fluxo SET ativo = '0', atuante = '0' WHERE id = " . $fluxoProcesso->getId() . "";
            $retorno = mysqli_query($conexao,$sql) or die('Erro na execução  do update!');
			$this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function atuarFluxoProcesso($fluxoProcesso) {
        try {
            $conexao = $this->ConectarBanco();
            $sqlGeral = "SELECT pf.id_processo FROM tb_workflow_processo_fluxo pf WHERE pf.id = " . $fluxoProcesso->getId() . "";
            $query = mysqli_query($conexao, $sqlGeral) or die('Erro na execução do atuarFluxoProcesso tb_workflow_processo_fluxo!');
            $objetoFluxoProcesso = mysqli_fetch_object($query);
            if ($objetoFluxoProcesso->id_processo != null) {
                
                $sql = "UPDATE tb_workflow_processo_fluxo SET atuante = '0' WHERE id_processo = " . $objetoFluxoProcesso->id_processo . "";
                mysqli_query($conexao,$sql) or die('Erro na execução  do update da tb_workflow_processo_fluxo!');
                
                $sql = "UPDATE tb_workflow_processo_fluxo SET atuante = '1' WHERE id = " . $fluxoProcesso->getId() . "";
                $retorno = mysqli_query($conexao,$sql) or die('Erro na execução  do update da tb_workflow_processo_fluxo!');
                
            }            
            
            $this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    
    public function desatuarFluxoProcesso($fluxoProcesso) {
        try {
            $conexao = $this->ConectarBanco();
            $sqlGeral = "SELECT pf.id_processo FROM tb_workflow_processo_fluxo pf WHERE pf.id = " . $fluxoProcesso->getId() . "";
            $query = mysqli_query($conexao, $sqlGeral) or die('Erro na execução do desatuarFluxoProcesso tb_workflow_processo_fluxo!');
            $objetoFluxoProcesso = mysqli_fetch_object($query);
            if ($objetoFluxoProcesso->id_processo != null) {
                
                $sql = "UPDATE tb_workflow_processo_fluxo SET atuante = '0' WHERE id_processo = " . $objetoFluxoProcesso->id_processo . "";
                $retorno = mysqli_query($conexao,$sql) or die('Erro na execução  do update da tb_workflow_processo_fluxo!');
                
            }            
            
            $this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function buscarProcessoByFluxoProcessoId($id = null){
    	$retorno = array();
    	$conexao = $this->ConectarBanco();
    	$sql = "SELECT  wp.id,
					    wp.titulo,
						wp.provisao, 
						wp.descricao,
						wp.data, 
						wp.status
					FROM tb_workflow_processo_fluxo wpf
					INNER JOIN tb_workflow_processo wp ON (wpf.id_processo = wp.id) 
					WHERE wpf.`id` = ".$id;
    	$query = mysqli_query($conexao,$sql) or die('Erro na execução  do listar!');
    	
    	while ($objetoProcesso = mysqli_fetch_object($query)) {
    		$processo = new Processo();
    		$processo->setId($objetoProcesso->id);
    		$processo->setTitulo($objetoProcesso->titulo);
    		$processo->setDescricao($objetoProcesso->descricao);
    		$processo->setStatus($objetoProcesso->status);
    		$processo->setProvisao($objetoProcesso->provisao);
    		$retorno[] = $processo;
    	}
    	$this->FecharBanco($conexao);
    	return $retorno;
    }
    
    
    public function buscarFluxoProcesso($id = null, $order = null) {
        try {
            $retorno = array();
            $conexao = $this->ConectarBanco();
            $sql = "SELECT  wpf.id,
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
							wa.link AS link_atividade,
                            wa.descricao AS descricao_atividade,
                            wa.vencimento AS vencimento_atividade,
							wpf.valor_atividade AS valor,
							wpf.titulo_atividade AS titulo_processo_fluxo,
							wpf.propriedade_atividade AS propriedade,
                            wp.id_usuario,
							wp.provisao,
							wf.ordenacao
                    FROM tb_workflow_processo_fluxo wpf
                    INNER JOIN tb_workflow_processo wp ON (wpf.id_processo = wp.id)
                    INNER JOIN tb_workflow_titulo_fluxo wtf ON (wtf.id = wp.id_titulo_fluxo)
                    INNER JOIN tb_workflow_fluxo wf ON (wpf.id_fluxo = wf.id)
                    INNER JOIN tb_workflow_atividade wa ON (wf.id_atividade = wa.id)
                    WHERE wpf.status = '1' AND wp.status = '1' ";
            $sql .= ($id != null) ? " AND wp.id = " . $id : "";
			
            if($order == null || $order == ''){
            	$sql .= " ORDER BY wf.ordenacao ASC ";
            }else{
            	$sql .= $order;
            }
            
            $query = mysqli_query($conexao,$sql) or die('Erro na execução  do listar!');
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
                
                $atividade = new Atividade();
                $atividade->setId($objetoFluxoProcesso->id_atividade);
                $atividade->setTitulo($objetoFluxoProcesso->titulo_atividade);
                $atividade->setDescricao($objetoFluxoProcesso->descricao_atividade);
                $atividade->setArquivo($objetoFluxoProcesso->arquivo_atividade);
                $atividade->setLink($objetoFluxoProcesso->link_atividade);
                $atividade->setImagem($objetoFluxoProcesso->imagem_atividade);
                $atividade->setVencimento($objetoFluxoProcesso->vencimento_atividade);
                $atividade->setValor($objetoFluxoProcesso->valor);
                $atividade->setPropriedade($objetoFluxoProcesso->propriedade);
                
                $fluxoProcesso->setAtividade($atividade);

                $aux[] = $fluxoProcesso;
            }
            $processo->setFluxoProcesso($aux);

            $retorno[] = $processo;

            $this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    
    public function alterarProcesso($processo){
    	try {
    		$conexao = $this->ConectarBanco();
    		$sql = "UPDATE tb_workflow_processo SET titulo = '".$processo->getTitulo()."', provisao = '".$processo->getProvisao()."', descricao = '".$processo->getDescricao()."', data = ".$processo->getData()." WHERE id =".$processo->getId()."";
    		$retorno = mysqli_query($conexao,$sql) or die ('Erro na execução  do update!');
    		$this->FecharBanco($conexao);
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    
    public function listarAtividadesProcessosHaVencer($id_usuario = null) {
    	try {
    		$retorno = array();
    		$limitDay = 25;
    		$conexao = $this->ConectarBanco();
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
                            wpf.ativo,
                            wf.id_atividade,
                            wpf.titulo_atividade AS titulo_atividade,
                            wa.imagem AS imagem_atividade,
                            wa.arquivo AS arquivo_atividade,
                            wa.descricao AS descricao_atividade,
							wpf.valor_atividade AS valor,
							wpf.propriedade_atividade AS propriedade,
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
    		//debug($sql);
    		$query = mysqli_query($conexao,$sql) or die('Erro na execução  do listar!');
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
    			
    			$atividade = new Atividade();
    			$atividade->setId($objetoFluxoProcesso->id_atividade);
    			$atividade->setTitulo($objetoFluxoProcesso->titulo_atividade);
    			$atividade->setDescricao($objetoFluxoProcesso->descricao_atividade);
    			$atividade->setArquivo($objetoFluxoProcesso->arquivo_atividade);
    			$atividade->setImagem($objetoFluxoProcesso->imagem_atividade);
    			$atividade->setValor($objetoFluxoProcesso->valor);
    			$atividade->setPropriedade($objetoFluxoProcesso->propriedade);
    			
    			if($objetoFluxoProcesso->vencimento < date("d")){
    				$dataFormatada = $objetoFluxoProcesso->vencimento_next;
    			}else{
    				$dataFormatada = $objetoFluxoProcesso->vencimento_format;
    			}
    			$atividade->setVencimento($dataFormatada);
    			
    			$fluxoProcesso->setAtividade($atividade);
    			
    			$aux[] = $fluxoProcesso;
    		}
    		$processo->setFluxoProcesso($aux);
    		
    		$retorno[] = $processo;
    		
    		$this->FecharBanco($conexao);
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function listarDistinctProcesso() {
    	try {
    		$retorno = array();
    		$conexao = $this->ConectarBanco();
    		$sql = "SELECT DISTINCT id,titulo FROM tb_workflow_processo WHERE status = '1' AND id_usuario = " . $_SESSION["login"]->getId();
    		$query = mysqli_query($conexao,$sql) or die('Erro na execução  do listar!');
    		while ($objetoProcesso = mysqli_fetch_object($query)) {
    			$processo = new Processo();
    			$processo->setId($objetoProcesso->id);
    			$processo->setTitulo($objetoProcesso->titulo);
    			$retorno[] = $processo;
    		}
    		$this->FecharBanco($conexao);
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }

}

?>