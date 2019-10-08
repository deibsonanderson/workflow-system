<?php

class ViewAgenda {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }
    
    public function telaCadastrarAgenda($post) {
		?>
        <script src="./assets/main/js/popup-upload.js" type="text/javascript"></script>
        <script src="./assets/main/js/jquery.form.js" type="text/javascript" ></script>
		<?
    	date_default_timezone_set('America/Sao_Paulo');
		$dataIn = date("Y-m-d");
		if($post["data"] !== null){
			$dataIn = $post["data"];
		}
		$controladorAgenda = new ControladorAgenda();
		$eventos = $controladorAgenda->eventosAgenda($_SESSION["login"]->getId());
		?>
        <script type="text/javascript" >
            $(document).ready(function() {
                $('#tooltip').hide();
                fncInserirArquivo("form_arquivo", "progress_arquivo", "porcentagem_arquivo", "arquivo", "arquivoAtual", "./arquivos/agenda/", "arquivo");

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
	                defaultDate: '<?php echo $dataIn; ?>',//'2018-03-12',
	                locale: 'pt-br',
	                navLinks: true, // can click day/week names to navigate views
	                editable: true,
	                eventLimit: true, // allow "more" link when too many events
	                events: [ <?php echo $eventos; ?> ]
	            });
                ordenarAgenda();
            });

   			function validarCampo(elemento){
				if(validateDate($(elemento).val()) == false){
					msgSlide("17");
					$(elemento).val('<?php echo recuperaData($dataIn); ?>');
				}
			}
		
		    if ($("#datetimepicker4").length) {
		        $('#datetimepicker4').datetimepicker({
		            format: 'L'
		        });
		    }  
        </script>
        <div style="display: none;" id="script"></div>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">
					<div class="card-header d-flex">
						<h4 class="card-header-title">Cadatro de Agenda</h4>
					</div>
					<div class="card-body">	
						<div class="form-group">
							<div id='calendar1'></div>
						</div>					
					</div>
				</div>
			</div>
		</div>
		
		<div id="div_agenda_retorno">
		<?php 
			echo $controladorAgenda->telaVisualizarEventosAgenda(array("data" => $dataIn)); 
		?>
		</div>
		<div id="div_comentario_retorno">
		<?php echo $controladorAgenda->telaVisualizarComentariosAgenda(array("data" => $dataIn)); ?>
		</div>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">
					<div class="card-header d-flex">
						<div class="toolbar ml-auto">
							<a href="#" onclick="fncFormCadastro(this)" class="btn btn-primary btn-sm formCadastro">Cadastrar</a>            	
						</div>
					</div>
			        <div class="card-body">
				       	<form action="#" method="post" id="formCadastro" class="">
							<input type="hidden" name="retorno" id="retorno" value="div_central"/>
							<input type="hidden" name="controlador" id="controlador" value="ControladorAgenda"/>
							<input type="hidden" name="funcao" id="funcao" value="incluirAgenda"/>
							<input type="hidden" name="mensagem" id="mensagem" value="1"/>
							<!-- input type="hidden" name="txt_data_cad" id="txt_data_cad" value="<?php echo $dataIn; ?>" /-->
							<input type="hidden" name="arquivo" id="arquivo" value="" />	
							<div class="form-row">
								<div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<label for="link" class="col-form-label">Link</label>
									<input id="link" name="link" type="text" class="form-control" onkeyup="this.value=this.value.toLowerCase();">
								</div>
								<div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
									<label for="fluxo">Data Agenda *</label>
									<div class="input-group date" id="datetimepicker4" data-target-input="nearest">
					                    <input type="text" id="txt_data_cad" name="txt_data_cad" onblur="validarCampo(this)" onkeypress="return mascara(event, this, '##/##/####');" maxlength="10" value="<?php echo recuperaData($dataIn); ?>" class="form-control datetimepicker-input mgs_alerta" data-target="#datetimepicker4">
					                    <div class="input-group-append" id="datepicker" name="datepicker" data-target="#datetimepicker4" data-toggle="datetimepicker">
					                  		<div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
					                    </div>
					                </div>
								</div>
								<div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
									<label for="txt_descricao">Descrição</label>
									<textarea class="form-control" id="txt_descricao" name="txt_descricao" rows="3"></textarea>
								</div>
							</div>
						</form>
						<div class="form-row">
							<div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
							    <label>Tamanho Máxima: 2 Megas.</label>&nbsp;&nbsp; 
								<table border="0">
									<tr>
										<td style="cursor:pointer;">
											<form action="./post-imagem.php" method="post" id="form_arquivo" >
												<input name="pastaArquivo" type="hidden" value="./arquivos/agenda/">
												<input name="largura" type="hidden" value="640">
												<input name="opcao" type="hidden" value="1">
												<input name="tipoArq" type="hidden" value="arquivo">
												<input type="file" name="file" class="upload-file" style="width: 30px;" onchange="javascript: fncSubmitArquivo('enviar_arquivo', this);" >
												<input type="submit" id="enviar_arquivo" style="display:none;">
												<img src="./assets/images/img_upload.png" class="upload-button" />
											</form>											
										</td>
										<td>
											<img onclick="fncRemoverArquivo('arquivo', './arquivos/agenda/', 'arquivo', 'arquivoAtual', '');" src="./assets/images/remove.png" border="0" title="Clique para remover" style="cursor:pointer;margin-bottom:7px;" class="upload-button" />
										</td>
									</tr>									
								</table>
							</div>
							<div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
								<span name="arquivoAtual" id="arquivoAtual" onClick="fnAbreArquivo('arquivo', './arquivos/agenda/')"   ><br />Adicione um arquivo clicando no <img src="./assets/images/img_upload.png" border="0" style="float:none;margin:0;width: 20px;" /></span>
								<progress id="progress_arquivo" value="0" max="100" style="display:none;"></progress>
								<span id="porcentagem_arquivo" style="display:none;">0%</span>                        
							</div>
						</div>
			        </div>
				</div>
			</div>
		</div>		
		<?php
    }
    
    public function telaVisualizarEventosAgenda($listAgenda){
    	if ($listAgenda) {
	    ?>
	        <div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="card">
						<div class="card-header d-flex">
							<h4 class="card-header-title">Eventos Agenda</h4>
						</div>
						<div class="card-body">								
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
										<fieldset id="recordsArray_<?php echo $agenda->getId(); ?>" style="padding-left: 10px;padding-right: 10px;">
										<table id="example" class="tablesorter table table-striped table-bordered second" style="width:100%">
											<tbody>
												<tr style="<?php echo $cor; ?>">
													<td style="width: 10%;text-align: center;" >
														<label style="width: 100px;margin-right: 20px;">
														<input  type="image" src="./assets/images/icn_alert_success.png" title="Desativar" onclick="desativarAgenda(<?php echo $agenda->getId(); ?>,<?php echo $atv; ?>);"  >
														<input type="image" src="./assets/images/icn_trash.png" title="Excluir" onclick="removerAgenda(<?php echo $agenda->getId(); ?>,'<?php echo $agenda->getArquivo(); ?>');" ><?php echo recuperaData($agenda->getData()); ?></label><br/>
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
								?>
							</div>		
						</div>
					</div>
				</div>
			</div>
		<?php
    	}
    }
    
    public function telaVisualizarComentariosAgenda($listComentario){
    	if ($listComentario) {
		?>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card module_content">
					<div class="card-header d-flex">
						<h4 class="card-header-title">Comentários dos processos</h4>
					</div>
					<div class="card-body">	
						<div class="table-responsive">
							<table id="example" class="tablesorter table table-striped table-bordered second" style="width:100%">
								<thead>
									<tr>
										<th>Data</th>
										<th>Processo</th>
										<th>Atividade</th>
										<th>Descri&ccedil;&atilde;o</th> 
										<th class="sorting_disabled">Arquivo</th> 
									</tr>
								</thead>
								<tbody>
								<?php 
									$cont = 0;
									foreach ($listComentario as $comentario) {
										$getIdProcessoStr = 'class="getIdProcesso" funcao="telaVisualizarAtividadeProcesso" controlador="controladorAtividade" retorno="div_central" id_processo_fluxo="' . $comentario->getFluxoProcesso()->getId() . '"  id_processo="' . $comentario->getProcesso()->getId() . '"   id="' . $comentario->getFluxoProcesso()->getAtividade()->getId() . '" ativo="' . $comentario->getFluxoProcesso()->getAtivo() . '" atuante="' . $comentario->getFluxoProcesso()->getAtuante() . '"';
										++$cont;
			                    ?>    
									<tr>
										<td <?php echo $getIdProcessoStr; ?> ><label style="width: 100px;cursor: pointer;" ><?php echo recuperaData($comentario->getData()); ?></label></td>
										<td <?php echo $getIdProcessoStr; ?> ><label style="width: 170px;cursor: pointer;"><?php echo limitarTexto($comentario->getProcesso()->getTitulo(), 40); ?></label></td>
										<td <?php echo $getIdProcessoStr; ?> ><label style="width: 170px;cursor: pointer;"><?php echo limitarTexto($comentario->getFluxoProcesso()->getAtividade()->getTitulo(), 40); ?></label></td>
										<td <?php echo $getIdProcessoStr; ?> ><?php echo ($comentario->getDescricao() != '') ? nl2br($comentario->getDescricao()) : $comentario->getArquivo(); ?></td>
										<td style="text-align: center;"><?php echo ($comentario->getArquivo() != '') ? '<img src="assets/images/arrow.png" style="cursor: pointer;" title="Arquivo: ' . $comentario->getArquivo() . '" onClick="fnAbreArquivo(\'arquivo' . $cont . '\', \'./arquivos/atividade\')" >' : ''; ?>
											<input type="hidden" name="arquivo<?php echo $cont; ?>" id="arquivo<?php echo $cont; ?>" value="<?php echo $comentario->getArquivo(); ?>" /> 
										</td>
									</tr>	
								<?php
			                        }
			                    ?>   	
								</tbody>
							</table>
						</div>			
					</div>
				</div>				
			</div>
		</div>	
	<?php     	
    	}
    }

    public function telaVisualizarAgendaOld($listAgenda, $data) {
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
                ?></div>
        <?php
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
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">        
				<div class="card-header d-flex">
		            <h4 class="card-header-title">Agendas</h4>
		            <div class="toolbar ml-auto">
		            	<a href="#" onclick="fncButtonCadastro(this)" funcao="telaCadastrarAgenda" controlador="ControladorAgenda" retorno="div_central" class="btn btn-primary btn-sm buttonCadastro">Novo</a>
		            </div>
		        </div>		
				<div class="card-body">
					<div class="table-responsive">
						<table id="example" class="tablesorter table table-striped table-bordered second" style="width:100%">
							<thead>
								<tr>
		                            <th>Data</th> 
		                            <th>Descri&ccedil;&atilde;o</th> 
		                            <th class="sorting_disabled" style="text-align: center;" >A&ccedil;&atilde;o</th>  
								</tr>
							</thead>
							<tbody>
							<?php 
							if ($objAgenda) {
								foreach ($objAgenda as $agenda) {
		                    ?>    
								<tr>
									<td onclick="fcnGetData(this)" style="cursor:pointer"  data="<?php echo recuperaData($agenda->getData()); ?>" funcao="telaCadastrarAgenda" controlador="ControladorAgenda" retorno="div_central"><?php echo recuperaData($agenda->getData()); ?></td> 
		                            <td onclick="fcnGetData(this)" style="cursor:pointer"  data="<?php echo recuperaData($agenda->getData()); ?>" funcao="telaCadastrarAgenda" controlador="ControladorAgenda" retorno="div_central"><?php echo limitarTexto($agenda->getDescricao(), 110); ?></td> 
		                            <td style="text-align:center">
		                            	<div class="btn-group ml-auto">
				                            <?php 
				                            echo ($perfil === 'A') ? '<button onclick="fncDeleteId(this)" modal="question" id="'.$agenda->getId().'" funcao="excluirAgenda" controlador="ControladorAgenda" retorno="div_central" mensagem="4" class="deleteId btn btn-sm btn-outline-light"><i class="far fa-trash-alt"></i></button>':'<button class="deleteId btn btn-sm btn-outline-light"><i class="far fa-trash-alt"></i></button>';
			                            	?>
			                            </div> 
		                            </td>								
								</tr>
							<?php
		                        }
		                    }
		                    ?>   	
							</tbody>
						</table>
					</div>
				</div>
				</div>
			</div>
		</div>	        
        <?php
    }	

}
?>