<?php

class ControladorAgenda {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }

    public function listarAgenda($post = null, $id_usuario = null, $dataIn = null, $tipo = null) {
        try {
        	$daoAgenda = new DaoAgenda();
        	$retorno = $daoAgenda->listarAgenda(desformataData($post["data"]), null, $id_usuario, $dataIn, $tipo);
            $daoAgenda->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
	
    public function visualiAgenda($post = null) {
        try {
            $daoAgenda = new DaoAgenda();
            $retorno = $daoAgenda->listarAgenda($post["data"],true);
            $daoAgenda->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function ajaxEventsAgenda($post = null){
        return $this->eventosAgenda($post["id_usuario"], $post["dataIn"], $post["tipo"]);
    }
    
    public function eventosAgenda($id_usuario, $dataIn = null, $tipo = null){
        $controladorProcesso = new ControladorProcesso();
    	$objProcesso = $controladorProcesso->listarFluxoProcessoAgenda($id_usuario, $dataIn, $tipo);
    	
    	$eventos = "";
    	$processoFluxoIds = array();
    	if ($objProcesso != null && $objProcesso[0]->getId() != null) {
    		foreach ($objProcesso as $processo) {
    			if ($processo->getFluxoProcesso() != null) {
    				foreach ($processo->getFluxoProcesso() as $fluxoProcesso) {
    					if(($fluxoProcesso->getVencimento() != null || $fluxoProcesso->getVencimento() != "" || $fluxoProcesso->getVencimento() != "00") 
    							&& ($fluxoProcesso->getTitulo() != null || trim($fluxoProcesso->getTitulo()) != "") ){
    										$date = strtotime($processo->getData());
    										$eventos .= '{ "id": "'.$fluxoProcesso->getAtividade()->getId().'", "title": "'.trim($fluxoProcesso->getTitulo()).' - '.trim($processo->getTitulo()).'", "start": "'.date("Y",$date).'-'.date("m",$date).'-'.$fluxoProcesso->getVencimento().'", "backgroundColor": "#4285F4", "borderColor": "#4285F4", "tipo": "P", "id_processo_fluxo": "'.$fluxoProcesso->getId().'", "ativo": "'.$fluxoProcesso->getAtivo().'", "atuante": "'.$fluxoProcesso->getAtuante().'", "id_processo": "'.$processo->getId().'" },';
    					}
    					$processoFluxoIds[] = $fluxoProcesso->getId();    					    					
    				}
    			}
    		}    		
    	}
    	$eventos .= $this->eventosAgendaComentarios($processoFluxoIds, $id_usuario, $dataIn, $tipo);
    	
    	$eventos .= $this->montarEventosAgenda($id_usuario, $dataIn, $tipo);
    	
    	$eventos = substr($eventos, 0, strlen($eventos)-1);
    	
    	return '['.$eventos.']';
    }
    
    public function montarEventosAgenda($id_usuario = null, $dataIn = null, $tipo = null){
    	$eventos = "";
    	$controladorAgenda = new ControladorAgenda();
    	$agendas = $controladorAgenda->listarAgenda(null, $id_usuario, $dataIn, $tipo);
    	if ($agendas != null) {
    		foreach ($agendas as $agenda) {
    			if($agenda->getStatus() == '1'){
    				if($agenda->getAtivo()){
    					$color = '#82db76';
    				}else{
    					$color = '#ef172c';
    				}
    				$eventos .= '{ "id": "'.$agenda->getId().'", "title": "'.trim($agenda->getDescricao()).'", "start": "'.$agenda->getData().'", "backgroundColor": "'.$color.'", "borderColor": "'.$color.'", "tipo": "A"},';
    			}
    		}
    	}
    	
    	return $eventos;
    }
    
    public function eventosAgendaComentarios($processoFluxoIds, $id_usuario = null, $dataIn = null, $tipo = null){
    	$eventos = '';
    	$controladorComentario = new ControladorComentarioFluxoProcesso();
    	$listComentario = $controladorComentario->listarComentarioByIdsFluxoProcesso($processoFluxoIds, $id_usuario, $dataIn, $tipo);
    	if($listComentario != null){
    		foreach ($listComentario as $comentario){
    			$date = strtotime($comentario->getData());
    			$eventos .= '{ "id": "'.$comentario->getId().'", "title": "'.trim(limitarTexto(preg_replace('/[^a-zA-Z0-9-_ ]/', '', $comentario->getDescricao()),40)).'", "start": "'.date("Y-m-d",$date).'", "backgroundColor": "#FFC108", "borderColor": "#FFC108", "tipo": "C" },';
    		}
    	}
    	return $eventos;
    }

    public function incluirAgenda($post) {
        try {
            $agenda = new Agenda();
            $agenda->setDescricao($post["txt_descricao"]);
            $agenda->setArquivo($post["arquivo"]);
            $agenda->setLink($post["link"]);
            $agenda->setData(desformataData($post["txt_data_cad"]));
            $agenda->setStatus('1');
            $daoAgenda = new DaoAgenda();
            
            if ($daoAgenda->incluirAgenda($agenda)) {
            	return $this->telaCadastrarAgenda(array("data" => desformataData($post["txt_data_cad"])));
            }
            $daoAgenda->__destruct();
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function alterarAgenda($post) {
        try {
            $agenda = new Agenda();
            $agenda->setId($post["id"]);
            $agenda->setAtivo($post["ativo"]);
            $daoAgenda = new DaoAgenda();
            if ($daoAgenda->alterarAgenda($agenda)) {
                return $this->telaCadastrarAgenda(array("data" => $post["txt_data_cad"]));
            }
            $daoAgenda->__destruct();
        } catch (Exception $e) {
            return $e;
        }
    }    

    public function ordernarAgenda($post) {
        try {
            $agenda = new Agenda();
            $agenda->setId($post["id"]);
            $agenda->setData(desformataData($post["txt_data_cad"]));
            $agenda->setStatus('1');
            $updateRecordsArray = $post['recordsArray'];
            $daoAgenda = new DaoAgenda();
            if ($daoAgenda->ordernarAgenda($agenda,$updateRecordsArray)) {
                $postVisual = array("data" => $post["txt_data_cad"]);  
                return $this->telaVisualizarEventosAgenda($postVisual);
            }
            $daoAgenda->__destruct();
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function telaFullCalendar(){
    	$controladorAgenda = new ControladorAgenda();
    	$eventos = $controladorAgenda->eventosAgenda($_SESSION["login"]->getId());
    	?>
	     <script type="text/javascript" >
	     	var txt_data_cad = document.getElementById("txt_data_cad").value;

         	$('#calendar1').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listWeek'
                },
                dayClick: function(date, jsEvent, view) {
	                $("#txt_data_cad").val(fncRecuperarData(date.format()));
                	telaVisualizarEventosAgenda(date.format());
                	telaVisualizarComentariosAgenda(date.format());
		        },
                defaultDate: fncRecuperarData(txt_data_cad),//'2018-03-12',
                locale: 'pt-br',
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                events: [ <?php echo $eventos; ?> ]
            });
	     </script>	
    	<?php
    }
    
    public function excluirAgenda($post) {
        try {
            $id = $post["id"];
            $daoAgenda = new DaoAgenda();
            $daoAgenda->excluirAgenda($id);
            $daoAgenda->__destruct();
            return $this->telaCadastrarAgenda(array("data" => desformataData($post["data"])));
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function excluirAgendaList($post) {
    	try {
    		$id = $post["id"];
    		$daoAgenda = new DaoAgenda();
    		$daoAgenda->excluirAgenda($id);
    		$daoAgenda->__destruct();
    		return $this->telaListarAgenda();
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function listarComentarioFluxoProcessoByData($post = null) {
    	try {
    		$daoComentarioFluxoProcesso = new DaoComentarioFluxoProcesso();
    		$retorno = $daoComentarioFluxoProcesso->listarComentarioFluxoProcessoByData(recuperaData($post["data"]));
    		$daoComentarioFluxoProcesso->__destruct();
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }

    public function telaCadastrarAgenda($post = null) {
        try {
            $viewAgenda = new ViewAgenda();
            $retorno = $viewAgenda->telaCadastrarAgenda($post);
            $viewAgenda->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function telaVisualizarEventosAgenda($post = null) {
    	try {
    		$viewAgenda = new ViewAgenda();
    		$retorno = $viewAgenda->telaVisualizarEventosAgenda($this->visualiAgenda($post));
    		$viewAgenda->__destruct();
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function telaVisualizarComentariosAgenda($post = null) {
    	try {
    		$viewAgenda = new ViewAgenda();
    		$retorno = $viewAgenda->telaVisualizarComentariosAgenda(
    				$this->listarComentarioFluxoProcessoByData($post));
    		$viewAgenda->__destruct();
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
     
    public function telaListarAgenda($post = null) {
        try {
        	$viewAgenda = new ViewAgenda();
            $retorno = $viewAgenda->telaListarAgenda($this->listarAgenda(null));
            $viewAgenda->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }	
    
    public function telaModalAgendaProcessoFluxo($post = null) {
    	try {    		   		
    		$processoFluxo = new FluxoProcesso();
    		$processoFluxo->setId($post["id_processo_fluxo"]);
    		$processoFluxo->setAtivo($post["ativo"]);
    		$processoFluxo->setAtuante($post["atuante"]);
    		
    		$processo = new Processo();
    		$processo->setId($post["id_processo"]);
    		$processoFluxo->setProcesso($processo);
    		
    		$controladorAtividade = new ControladorAtividade();
    		$objAtividade = $controladorAtividade->buscarAtividade($post["id"]);
    		
    		$viewAgenda = new ViewAgenda(); 
    		$retorno = $viewAgenda->telaModalAgendaProcessoFluxo($objAtividade,$processoFluxo);
    		$viewAgenda->__destruct();
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }

}

?>