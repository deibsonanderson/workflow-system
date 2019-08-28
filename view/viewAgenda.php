<?php

class ViewAgenda {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }
    
    public function telaCadastrarAgenda($post) {
        date_default_timezone_set('America/Sao_Paulo');
		$dataIn = date("d/m/Y");
		if($post["data"] !== null){
			$dataIn = $post["data"];
		}
		$controladorProcesso = new ControladorProcesso();
		$objProcesso = $controladorProcesso->listarFluxoProcesso($_SESSION["login"]->getId());

		$html = "";
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
								$html .= "{
				                        title: '".trim($processo->getTitulo())."-".trim($fluxoProcesso->getAtividade()->getTitulo())."',
				                        start: '".date('Y',$date)."-".date('m',$date)."-".$fluxoProcesso->getAtividade()->getVencimento()."',
				                        backgroundColor: '#4285F4',
				                        borderColor: '#4285F4'
				                      },";
						}						
					}
				}
			}
			
			$controladorAgenda = new ControladorAgenda();
			$agendas = $controladorAgenda->listarAgenda(null);
			//debug($agendas);
			if ($agendas != null) {
				foreach ($agendas as $agenda) {
					if($agenda->getStatus() == '1'){
						if($agenda->getAtivo()){
							$color = "#82db76";	
						}else{
							$color = "#ef172c";
						}	
						$html .= "{
			                        title: '".trim($agenda->getDescricao())."',
			                        start: '".$agenda->getData()."',
			                        backgroundColor: '".$color."',
			                        borderColor: '".$color."'
			                      },";
						
					}
				}
			}
			$html = substr($html, 0, strlen($html)-1);
		}
		
        ?>
        <script src="./assets/main/js/popup-upload.js" type="text/javascript"></script>
        <script src="./assets/main/js/jquery.form.js" type="text/javascript" ></script>
        <script type="text/javascript" >
            $(document).ready(function() {
                //$('#tooltip').hide();
                fncInserirArquivo("form_arquivo", "progress_arquivo", "porcentagem_arquivo", "arquivo", "arquivoAtual", "./arquivos/agenda/", "arquivo");

	            $('#calendar1').fullCalendar({
	                header: {
	                    left: 'prev,next today',
	                    center: 'title',
	                    right: 'month,agendaWeek,agendaDay,listWeek'
	                },
	                dayClick: function(date, jsEvent, view) {
	                	//alert('Clicked on: ' + date.format());
	                	visualizarAgenda(date.format());
			        },
	                defaultDate: Date(),//'2018-03-12',
	                locale: 'pt-br',
	                navLinks: true, // can click day/week names to navigate views
	                editable: true,
	                eventLimit: true, // allow "more" link when too many events
	                events: [ <?php echo $html; ?> 
		                /*
		                {
	                        title: 'All Day Event',
	                        start: '2018-03-01',
	                    },
	                    {
	                        title: 'Long Event',
	                        start: '2018-03-07',
	                        end: '2018-03-10'
	                    },
	                    {
	                        id: 999,
	                        title: 'Repeating Event',
	                        start: '2018-03-09T16:00:00',
	                        backgroundColor: '#ffc108',
	                        borderColor: '#ffc108'
	
	                    },
	                    {
	                        id: 999,
	                        title: 'Repeating Event',
	                        start: '2018-03-16T16:00:00',
	                        backgroundColor: '#ffc108',
	                        borderColor: '#ffc108'
	
	                    },
	                    {
	                        title: 'Conference',
	                        start: '2018-03-11',
	                        end: '2018-03-13',
	                        backgroundColor: '#ff407b',
	                        borderColor: '#ff407b'
	
	                    },
	                    {
	                        title: 'Meeting',
	                        start: '2018-03-12T10:30:00',
	                        end: '2018-03-12T12:30:00',
	                        backgroundColor: '#25d5f2',
	                        borderColor: '#25d5f2'
	                    },
	                    {
	                        title: 'Lunch',
	                        start: '2018-03-12T12:00:00',
	                        backgroundColor: '#ff407b',
	                        borderColor: '#ff407b'
	
	                    },
	                    {
	                        title: 'Meeting',
	                        start: '2018-03-12T14:30:00',
	                        backgroundColor: '#25d5f2',
	                        borderColor: '#25d5f2'
	                    },
	                    {
	                        title: 'Happy Hour',
	                        start: '2018-03-12T17:30:00'
	                    },
	                    {
	                        title: 'Dinner',
	                        start: '2018-03-12T20:00:00'
	                    },
	                    {
	                        title: 'Birthday Party',
	                        start: '2018-03-13T07:00:00',
	                        backgroundColor: '#ef172c',
	                        borderColor: '#ef172c'
	                    },
	                    {
	                        title: 'Click for Google qeqewqweq qwe qweqwe qweqweq',
	                        url: 'http://google.com/',
	                        start: '2019-08-14',
	                        backgroundColor: '#4285F4',
	                        borderColor: '#4285F4'
	                    }*/
	                    
	                ]
	            });


                });
        </script> 
        <script type="text/javascript">
        <?php
        	echo ($post && $post["isView"] !== "s") ? "$.growlUI2('" . $post . "', '&nbsp;');" : "";
        ?>
        </script>
        <script type="text/javascript" >
            $(document).ready(function() {
                ordenar();
                /*$("#datepicker").datepicker({
                    onSelect: function(dateText, inst) {
                    	//alert(dateText+'---'+dia+'/'+mes+'/'+ano);
                    	var mes = dateText.substring(0, 2);
                    	var dia = dateText.substring(3, 5);
                    	var ano = dateText.substring(6, 10);
        				visualizarAgenda(dia+'/'+mes+'/'+ano);
                    }
                });*/
            });

            function visualizarAgenda(dateText){
                $("#txt_data_cad").val(dateText);
                
                $.ajax({
                    url: 'controlador.php',
                    type: 'POST',
                    data: 'retorno=div_agenda_retorno&controlador=controladorAgenda&funcao=telaVisualizarAgenda&data=' + dateText,
                    success: function(result) {
                        $('#div_agenda_retorno').html(result);
                    },
                    beforeSend: function() {
                        $('#loader').css({
                            display: "block"
                        });
                        $('#div-loader').css({
                            opacity: 0.5
                        });
                    },
                    complete: function() {
                        $('#loader').css({
                            display: "none"
                        });
                        $('#div-loader').css({
                            opacity: 1.0
                        });
                    }
                });
            }

            function ordenar() {
                $("#div_agenda").sortable({opacity: 0.6, cursor: 'move', update: function() {
                        var txt_data_cad = document.getElementById("txt_data_cad").value;
                        var order = $(this).sortable("serialize") + '&action=updateRecordsListings&txt_data_cad=' + txt_data_cad + '&retorno=div_agenda_retorno&controlador=controladorAgenda&funcao=ordernarAgenda';
                        $.ajax({
                            url: 'controlador.php',
                            type: 'POST',
                            data: order,
                            success: function(result) {
                                //$('#div_agenda_retorno').html(result);
                            },
                            beforeSend: function() {
                                $('#loader').css({
                                    display: "block"
                                });
                                $('#div-loader').css({
                                    opacity: 0.5
                                });
                            },
                            complete: function() {
                                $('#loader').css({
                                    display: "none"
                                });
                                $('#div-loader').css({
                                    opacity: 1.0
                                });
                            }
                        });
                    }
                });
            }

            function desativarAgenda(id, ativo) {
                var txt_data_cad = document.getElementById("txt_data_cad").value;
                var dados = 'id=' + id + '&retorno=div_agenda_retorno&controlador=controladorAgenda&funcao=alterarAgenda&txt_data_cad=' + txt_data_cad + '&ativo=' + ativo;
                $.ajax({
                    url: 'controlador.php',
                    type: 'POST',
                    data: dados,
                    success: function(result) {
                        $('#div_agenda_retorno').html(result);
                    },
                    beforeSend: function() {
                        $('#loader').css({
                            display: "block"
                        });
                        $('#div-loader').css({
                            opacity: 0.5
                        });
                    },
                    complete: function() {
                        $('#loader').css({
                            display: "none"
                        });
                        $('#div-loader').css({
                            opacity: 1.0
                        });
                    }
                });
            }

            function removerAgenda(id) {
                var dados = 'id=' + id + '&retorno=div_agenda_retorno&controlador=controladorAgenda&funcao=excluirAgenda&mensagem=4';
                fncRemoverArquivoAuto('arquivo' + id, './arquivos/agenda/', 'arquivo', '', '');
                $.ajax({
                    url: 'controlador.php',
                    type: 'POST',
                    data: dados,
                    success: function(result) {
                        $('#recordsArray_' + id).fadeOut();
                        setTimeout(function() {
                            $('#recordsArray_' + id).remove();
                        }, 3000);
                    },
                    beforeSend: function() {
                        $('#loader').css({
                            display: "block"
                        });
                        $('#div-loader').css({
                            opacity: 0.5
                        });
                    },
                    complete: function() {
                        $('#loader').css({
                            display: "none"
                        });
                        $('#div-loader').css({
                            opacity: 1.0
                        });
                    }
                });
            }
        </script>		
		<div class="card-header d-flex">
            <h4 class="card-header-title">Cadatro de Agenda</h4>
            <div class="toolbar ml-auto">
	            <a href="#" class="btn btn-primary btn-sm formCadastro">Cadastrar</a>            	
            </div>
        </div>	
		<div class="card-body">	
        	<form action="#" method="post" id="formCadastro" class="">
                <input type="hidden" name="retorno" id="retorno" value="div_agenda_retorno"/>
                <input type="hidden" name="controlador" id="controlador" value="ControladorAgenda"/>
                <input type="hidden" name="funcao" id="funcao" value="incluirAgenda"/>
                <input type="hidden" name="mensagem" id="mensagem" value="1"/>
				<input type="hidden" name="txt_data_cad" id="txt_data_cad" value="<?php echo $dataIn; ?>" />
                <input type="hidden" name="arquivo" id="arquivo" value="" />					
				<div class="form-group">
					<div id='calendar1'></div>
				</div>
				<!-- div class="form-group">
					<div id="datepicker" ></div>
				</div-->
				<div class="form-group">
					<label for="link" class="col-form-label">Link *</label>
					<input id="link" name="link" type="text" class="form-control mgs_alerta" onkeyup="this.value=this.value.toLowerCase();">
				</div>
				<div class="form-group">
					<label for="txt_descricao">Descrição</label>
					<textarea class="form-control" id="txt_descricao" name="txt_descricao" rows="3"></textarea>
				</div>
			</form>				
			<div class="form-group">
                <table border="0" style="width: 100%">
                    <tr>
                        <td colspan="3">
                            <label>Tamanho Máxima: 2 Megas.</label>&nbsp;&nbsp; 
                        </td>
                    </tr>
                    <tr style="">
                        <td style="width: 20%;text-align: right;">
                            <span id="span-teste" class="upload-wrapper" >                                                        
                                <form action="./post-imagem.php" method="post" id="form_arquivo">
                                    <input name="pastaArquivo" type="hidden" value="./arquivos/agenda/">
                                    <input name="largura" type="hidden" value="640">
                                    <input name="opcao" type="hidden" value="1">
                                    <input name="tipoArq" type="hidden" value="arquivo">
                                    <input type="file" name="file" class="upload-file" onchange="javascript: fncSubmitArquivo('enviar_arquivo', this);" >
                                    <input type="submit" id="enviar_arquivo" style="display:none;">
                                    <img src="./assets/images/img_upload.png" class="upload-button" />

                                </form>
                            </span>
                        </td>
                        <td style="width: 20%">
                            <img onclick="fncRemoverArquivo('arquivo', './arquivos/agenda/', 'arquivo', 'arquivoAtual', '');" src="./assets/images/remove.png" border="0" title="Clique para remover" style="cursor:pointer;margin-bottom:7px;" class="upload-button" />
                        </td>
                        <td style="width: 60%;">
                            <span name="arquivoAtual" id="arquivoAtual" onClick="fnAbreArquivo('arquivo', './arquivos/agenda/')"   ><br />Adicione um arquivo clicando no <img src="./assets/images/img_upload.png" border="0" style="float:none;margin:0;width: 20px;" /></span>
                            <progress id="progress_arquivo" value="0" max="100" style="display:none;"></progress>
                            <span id="porcentagem_arquivo" style="display:none;">0%</span>                        
                        </td>                    
                    </tr>
                </table>
			</div>				
		</div>
		<div class="card-footer">	
			<div id="div_agenda_retorno">  
				<!-- Bloco Agenda por data -->
                <div id="div_agenda" >
                    <?php
                    $controladorAgenda = new ControladorAgenda();
                    $post = array("data" => $dataIn);
                    $listAgenda = $controladorAgenda->listarAgenda($post);
                    if ($listAgenda) {
                        foreach ($listAgenda as $agenda) {
                            if ($agenda->getAtivo() != "1") {
                                $cor = "background-color: #DFF0D8 !important;";
                                $atv = "1";
                            } else {
                                $cor = "";
                                $atv = "0";
                            }
                            ?>        
                            <fieldset id="recordsArray_<?php echo $agenda->getId(); ?>" style="padding-left: 10px;padding-right: 10px;<?php echo $cor; ?>">
							<table id="example" class="tablesorter table table-striped table-bordered second" style="width:100%">
	                            <tbody>
                                    <tr>
                                        <td style="width: 10%;text-align: center;" >
                                            <label style="width: 100px;margin-right: 20px;">
                                                <input  type="image" src="./assets/images/icn_alert_success.png" title="Desativar" onclick="desativarAgenda(<?php echo $agenda->getId(); ?>,<?php echo $atv; ?>);"  >
                                                <input type="image" src="./assets/images/icn_trash.png" title="Excluir" onclick="removerAgenda(<?php echo $agenda->getId(); ?>);" ><?php echo recuperaData($agenda->getData()); ?></label><br/>
                                            <input type="hidden" name="arquivo<?php echo $agenda->getId(); ?>" id="arquivo<?php echo $agenda->getId(); ?>" value="<?php echo $agenda->getArquivo(); ?>" /> 
                                            <?php
                                            echo ($agenda->getLink() != '' || $agenda->getLink() != null) ? '<a href="' . $agenda->getLink() . '" target="_blank" title="Acesso ao Link Clique aqui!" ><img src="assets/images/external_link29.png" ></a>' : '';
                                            echo ($agenda->getArquivo() != '') ? '&nbsp;&nbsp;<img src="assets/images/arrow.png" style="cursor: pointer;" title="Arquivo: ' . $agenda->getArquivo() . '" onClick="fnAbreArquivo(\'arquivo' . $agenda->getId() . '\', \'./arquivos/agenda\')" >' : '';
                                            ?>
                                        </td>
                                        <td style="width: 90%"><?php echo nl2br($agenda->getDescricao()); ?></td>
                                    </tr>
								</tbody>
                            </table>			
                            </fieldset>
                            <?php
                        }
                    }
                    ?>
                </div>		
				<!-- Bloco Agenda por data -->
		
                <!-- Bloco Comentario por data -->
                <div class="module_content">
                    <?php
                    $controladorComentario = new ControladorComentarioFluxoProcesso();
                    $listComentario = $controladorComentario->listarComentarioFluxoProcessoByData(null);
                    if ($listComentario) {
                        ?><h3 class="tabs_involved">Comentários dos processos</h3><?php
                        $cont = 0;
                        foreach ($listComentario as $comentario) {
                            $getIdProcessoStr = 'class="getIdProcesso" funcao="telaVisualizarAtividadeProcesso" controlador="controladorAtividade" retorno="div_central" id_processo_fluxo="' . $comentario->getFluxoProcesso()->getId() . '"  id_processo="' . $comentario->getProcesso()->getId() . '"   id="' . $comentario->getFluxoProcesso()->getAtividade()->getId() . '" ativo="' . $comentario->getFluxoProcesso()->getAtivo() . '" atuante="' . $comentario->getFluxoProcesso()->getAtuante() . '"';
                            ++$cont;
                            ?>                
                            <fieldset style="padding-left: 10px;padding-right: 10px;cursor: pointer;">
								<table id="example" class="tablesorter table table-striped table-bordered second" style="width:100%">
		                            <tbody>
	                                    <tr >
	                                        <td <?php echo $getIdProcessoStr; ?> ><label style="width: 100px;cursor: pointer;" ><?php echo recuperaData($comentario->getData()); ?></label></td>
	                                        <td <?php echo $getIdProcessoStr; ?> ><label style="width: 170px;cursor: pointer;"><?php echo limitarTexto($comentario->getProcesso()->getTitulo(), 20); ?></label></td>
	                                        <td <?php echo $getIdProcessoStr; ?> ><?php echo ($comentario->getDescricao() != '') ? nl2br($comentario->getDescricao()) : $comentario->getArquivo(); ?></td>
	                                        <td><?php echo ($comentario->getArquivo() != '') ? '<img src="assets/images/arrow.png" style="cursor: pointer;" title="Arquivo: ' . $comentario->getArquivo() . '" onClick="fnAbreArquivo(\'arquivo' . $cont . '\', \'./arquivos/atividade\')" >' : ''; ?>
	                                            <input type="hidden" name="arquivo<?php echo $cont; ?>" id="arquivo<?php echo $cont; ?>" value="<?php echo $comentario->getArquivo(); ?>" /> 
	                                        </td>
	                                    </tr>
									</tbody> 
								</table>                  
                            </fieldset>
                            <div class="clear"></div>
                            <?php
                        }
                    }
                    ?>	                
                </div>
                <!-- Bloco Comentario por data -->		
			</div>
		</div>
		<?php
    }

    public function telaVisualizarAgenda($listAgenda, $data) {
        if ($listAgenda) {
            ?>
            <script type="text/javascript" >
                $("#txt_descricao").val("");
                $("#link").val("");
                $("#arquivo").val("");
                $('#arquivoAtual').html("<br />Adicione um arquivo clicando no <img src='./assets/images/img_upload.png' border='0' style='float:none;margin:0;width: 20px;' /> ao lado.");
                $('#arquivoAtual').css('cursor', 'default');
                $('#arquivoAtual').css('text-decoration', 'none');
                ordenar();
            </script>   
            <div id="div_agenda" >
                <?php
                foreach ($listAgenda as $agenda) {

                    if ($agenda->getAtivo() != "1") {
                        $cor = "background-color: #DFF0D8 !important;";
                        $atv = "1";
                    } else {
                        $cor = "";
                        $atv = "0";
                    }
                    ?>
                    <fieldset id="recordsArray_<?php echo $agenda->getId(); ?>" style="padding-left: 10px;padding-right: 10px;<?php echo $cor; ?>">
						<table id="example" class="tablesorter table table-striped table-bordered second" style="width:100%">
                            <tbody>
	                            <tr>
	                                <td style="width: 10%;text-align: center;" >
	                                    <label style="width: 100px;margin-right: 20px;">
	                                        <input type="image" src="./assets/images/icn_alert_success.png" title="Desativar" onclick="desativarAgenda(<?php echo $agenda->getId(); ?>,<?php echo $atv; ?>);"  >
	                                        <input type="image" src="./assets/images/icn_trash.png" title="Excluir" onclick="removerAgenda(<?php echo $agenda->getId(); ?>);" ><?php echo recuperaData($agenda->getData()); ?></label><br/>
	                                    <input type="hidden" name="arquivo<?php echo $agenda->getId(); ?>" id="arquivo<?php echo $agenda->getId(); ?>" value="<?php echo $agenda->getArquivo(); ?>" /> 
	                                    <?php
	                                    echo ($agenda->getLink() != '' || $agenda->getLink() != null) ? '<a href="' . $agenda->getLink() . '" target="_blank" title="Acesso ao Link Clique aqui!" ><img src="assets/images/external_link29.png" ></a>' : '';
	                                    echo ($agenda->getArquivo() != '') ? '&nbsp;&nbsp;<img src="assets/images/arrow.png" style="cursor: pointer;" title="Arquivo: ' . $agenda->getArquivo() . '" onClick="fnAbreArquivo(\'arquivo' . $agenda->getId() . '\', \'./arquivos/agenda\')" >' : '';
	                                    ?>
	                                </td>
	                                <td style="width: 90%"><?php echo nl2br($agenda->getDescricao()); ?></td>
	                            </tr>				
							</tbody> 
						</table>
                    </fieldset>
                    <div class="clear"></div>
                    <?php
                }
                ?></div><?php
        }
        if ($data != null) {
            ?>
            <!-- Bloco Comentario por data -->
            <div class="module_content">
                <?php
                $controladorComentario = new ControladorComentarioFluxoProcesso();
                $listComentario = $controladorComentario->listarComentarioFluxoProcessoByData($data);
                if ($listComentario) {
                    ?><h3 class="tabs_involved">Comentários dos processos</h3><?php
                    $cont = 0;
                    foreach ($listComentario as $comentario) {
                        $getIdProcessoStr = 'class="getIdProcesso" funcao="telaVisualizarAtividadeProcesso" controlador="controladorAtividade" retorno="div_central" id_processo_fluxo="' . $comentario->getFluxoProcesso()->getId() . '" id="' . $comentario->getFluxoProcesso()->getAtividade()->getId() . '" id_processo="' . $comentario->getProcesso()->getId() . '" ativo="' . $comentario->getFluxoProcesso()->getAtivo() . '" atuante="' . $comentario->getFluxoProcesso()->getAtuante() . '"';
                        ++$cont;
                        ?>                
                        <fieldset style="padding-left: 10px;padding-right: 10px;cursor: pointer;">
							<table id="example" class="tablesorter table table-striped table-bordered second" style="width:100%">
	                            <tbody>
	                                <tr style="cursor: pointer;">
	                                    <td <?php echo $getIdProcessoStr; ?>><label style="width: 100px;cursor: pointer;"><?php echo recuperaData($comentario->getData()); ?></label></td>
	                                    <td <?php echo $getIdProcessoStr; ?>><label style="width: 170px;cursor: pointer;"><?php echo limitarTexto($comentario->getProcesso()->getTitulo(), 20); ?></label></td>
	                                    <td <?php echo $getIdProcessoStr; ?>><?php echo ($comentario->getDescricao() != '') ? nl2br($comentario->getDescricao()) : $comentario->getArquivo(); ?></td>
	                                    <td><?php echo ($comentario->getArquivo() != '') ? '<img src="assets/images/arrow.png" style="cursor: pointer;" title="Arquivo: ' . $comentario->getArquivo() . '" onClick="fnAbreArquivo(\'arquivo' . $cont . '\', \'./arquivos/atividade\')" >' : ''; ?>
	                                        <input type="hidden" name="arquivo<?php echo $cont; ?>" id="arquivo<?php echo $cont; ?>" value="<?php echo $comentario->getArquivo(); ?>" /> 
	                                    </td>
	                                </tr>
	                            </tbody>    
                            </table>                   
                        </fieldset>
                        <div class="clear"></div>
                        <?php
                    }
                }
                ?>	                
                <div class="clear"></div>            
            </div>
            <!-- Bloco Comentario por data -->             
            <?php
        }
    }
	
    public function telaListarAgenda($objAgenda) {
        $controladorAcao = new ControladorAcao();
        $perfil = $controladorAcao->retornaPerfilClasseAcao($_SESSION["login"], 'telaListarAgenda');
        ?>
        <script type="text/javascript">
            $('.tablesorter').dataTable({
                "sPaginationType": "full_numbers"
            });
            $(document).ready(function() {
                $('#tooltip').hide();
            });
        </script>
		<div class="card-header d-flex">
            <h4 class="card-header-title">Agendas</h4>
            <div class="toolbar ml-auto">
            	<a href="#" funcao="telaCadastrarAgenda" retorno="div_central" class="btn btn-primary btn-sm buttonCadastro">Novo</a>
            </div>
        </div>			
		<div class="card-body">
			<div class="table-responsive">
				<table id="example" class="tablesorter table table-striped table-bordered second" style="width:100%">
					<thead>
						<tr>
                            <th>Data</th> 
                            <th>Descri&ccedil;&atilde;o</th> 
						</tr>
					</thead>
					<tbody>
                        <?php
                        if ($objAgenda) {
                            foreach ($objAgenda as $agenda) {
                                ?>    
                                <tr> 
                                    <!--td class="getData" style="cursor:pointer"  data="<?php echo recuperaData($agenda->getData()); ?>" funcao="telaCadastrarAgenda" controlador="ControladorAgenda" retorno="div_central"><?php echo str_pad($agenda->getId(), 5, "0", STR_PAD_LEFT); ?></td--> 
                                    <td class="getData" style="cursor:pointer"  data="<?php echo recuperaData($agenda->getData()); ?>" funcao="telaCadastrarAgenda" controlador="ControladorAgenda" retorno="div_central"><?php echo recuperaData($agenda->getData()); ?></td> 
                                    <td class="getData" style="cursor:pointer"  data="<?php echo recuperaData($agenda->getData()); ?>" funcao="telaCadastrarAgenda" controlador="ControladorAgenda" retorno="div_central"><?php echo limitarTexto($agenda->getDescricao(), 110); ?></td> 
                                    <!--td >
                                        <?php
                                        echo ($perfil !== 'C') ? '<input type="image" src="./assets/images/icn_edit.png" title="Alterar" id="' . $agenda->getId() . '" class="getId" funcao="telaAlterarAgenda" controlador="ControladorAgenda" retorno="div_central">' : '<input type="image" src="images/icn_edit_disable.png" title="Excluir" mensagem="4" style="cursor: default;">';
                                        echo ($perfil === 'A') ? '<input type="image" src="./assets/images/icn_trash.png" title="Excluir" id="' . $agenda->getId() . '" class="deleteId" funcao="excluirAgenda" controlador="ControladorAgenda" retorno="div_central" mensagem="4">' : '<input type="image" src="images/icn_trash_disable.png" title="Excluir" mensagem="4" style="cursor: default;">';
                                        ?>                                         
                                    </td-->

                                </tr> 
                                <?php
                            }
                        }
                        ?>   			
					</tbody> 
				</table>
			</div>
		</div>
		        
        <?php
    }	

}
?>