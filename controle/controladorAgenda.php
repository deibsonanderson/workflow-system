<?php

class ControladorAgenda {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }

    public function listarAgenda($post = null) {
        try {
            $daoAgenda = new DaoAgenda();
            $retorno = $daoAgenda->listarAgenda(desformataData($post["data"]));
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
    
    public function eventosAgenda($id_usuario){
    	$controladorProcesso = new ControladorProcesso();
    	$objProcesso = $controladorProcesso->listarFluxoProcesso($id_usuario);
    	
    	$eventos = "";
    	$processoFluxoIds = array();
    	if ($objProcesso != null && $objProcesso[0]->getId() != null) {
    		foreach ($objProcesso as $processo) {
    			if ($processo->getFluxoProcesso() != null) {
    				foreach ($processo->getFluxoProcesso() as $fluxoProcesso) {
    					if(($fluxoProcesso->getAtividade()->getVencimento() != null ||
    							$fluxoProcesso->getAtividade()->getVencimento() != "" ||
    							$fluxoProcesso->getAtividade()->getVencimento() != "00") &&
    							($fluxoProcesso->getAtividade()->getTitulo() != null ||
    									trim($fluxoProcesso->getAtividade()->getTitulo()) != "")){
    										
    										$date = strtotime($processo->getData());
    										
    										$eventos .= "{
									                        title: '".trim($fluxoProcesso->getAtividade()->getTitulo())."-".trim($processo->getTitulo())."',
									                        start: '".date('Y',$date)."-".date('m',$date)."-".$fluxoProcesso->getAtividade()->getVencimento()."',
									                        backgroundColor: '#4285F4',
									                        borderColor: '#4285F4'
									                      },";
											
    					}
    					$processoFluxoIds[] = $fluxoProcesso->getId();
    				}
    			}
    		}
    		$eventos .= $this->eventosAgendaComentarios($processoFluxoIds);
    		
    		$controladorAgenda = new ControladorAgenda();
    		$agendas = $controladorAgenda->listarAgenda(null);
    		if ($agendas != null) {
    			foreach ($agendas as $agenda) {
    				if($agenda->getStatus() == '1'){
    					if($agenda->getAtivo()){
    						$color = "#82db76";
    					}else{
    						$color = "#ef172c";
    					}
    					$eventos .= "{
				                        title: '".trim($agenda->getDescricao())."',
				                        start: '".$agenda->getData()."',
				                        backgroundColor: '".$color."',
				                        borderColor: '".$color."'
				                      },";
    					
    				}
    			}
    		}
    		$eventos = substr($eventos, 0, strlen($eventos)-1);
    	}
    	
    	return $eventos;
    }
    
    public function eventosAgendaComentarios($processoFluxoIds){
    	$eventos = '';
    	$controladorComentario = new ControladorComentarioFluxoProcesso();
    	$listComentario = $controladorComentario->listarComentarioByIdsFluxoProcesso($processoFluxoIds);
    	if($listComentario != null){
    		foreach ($listComentario as $comentario){
    			$date = strtotime($comentario->getData());
    			$eventos .= "{
		                        title: '".trim(limitarTexto(preg_replace("/[^a-zA-Z0-9-_ ]/", "", $comentario->getDescricao()),40))."',
		                        start: '".date('Y-m-d',$date)."',
		                        backgroundColor: '#FFC108',
		                        borderColor: '#FFC108'
		                      },";
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

}

?>