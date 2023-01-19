<?php

class ViewAgenda {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }
    
    public function telaModalAgendaProcessoFluxo($objAtividade, $processoFluxo){
    	$controladorProcesso = new ControladorProcesso();
    	$objProcessoFluxo = null;
    	$objProcesso = $controladorProcesso->buscarFluxoProcesso($processoFluxo->getProcesso()->getId());
    	if ($objProcesso != null && $objProcesso[0]->getId() != null) {
    		foreach ($objProcesso as $processo) {
		    	if ($processo != null && $processo->getFluxoProcesso() != null) {
		    		foreach ($processo->getFluxoProcesso() as $fluxoProcesso) {
		    			if($fluxoProcesso->getId() == $processoFluxo->getId()){
		    				$objProcessoFluxo = $fluxoProcesso;
		    				break;
		    			}
		    		}
		    		break;
		    	}
    		}
    	}
    ?>
    	<script type="text/javascript">
			function closeModal(){
		        $.unblockUI();
		    }
		</script>
    	<div class="modal" id="modalAgenda" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg" role="document" style="overflow-y: initial !important;">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title"></h5>
	            <div class="toolbar ml-auto">
		            <button type="button" class="btn btn-light" 
		            	 id_processo_fluxo="<?php echo $objProcessoFluxo->getId(); ?>"
						 id_processo="<?php echo $objProcesso[0]->getId(); ?>" 
						 id="<?php echo $objProcessoFluxo->getAtividade()->getId(); ?>"
						 ativo="<?php echo $objProcessoFluxo->getAtivo(); ?>"
						 atuante="<?php echo $objProcessoFluxo->getAtuante(); ?>"
						 onclick="getIdProcesso(this);closeModal();"
						 funcao="telaVisualizarAtividadeProcesso" 
						 controlador="controladorAtividade" 
						 retorno="div_central">
			          <span aria-hidden="true">Acessar Atividade</span>
			        </button>
			        <button type="button" id="closeModalAgenda" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">Fechar</span>
			        </button>
	            </div>		 
		      </div>
		      <div class="modal-body" style="height: 450px; overflow-y: auto;">
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="card">          
							<div class="card-footer">
								<div class="table-responsive">
									<table id="example" class="tablesorter table table-striped table-bordered second" style="width: 100%">
										<thead>
											<tr>
												<th>Código</th>
												<th>Data</th>
												<th>Processo</th>
												<th>Fluxo</th>
												<th>Vencimento</th>
												<th>Processos</th>
												<th>Valor</th>
											</tr>
										</thead>
										<tbody>
						                    <?php
						                    if ($objProcessoFluxo != null) {
						                    ?>    
						                    <tr style="text-align:center;">
												<td class="getId dimensions" style="cursor: pointer"
													id="<?php echo $objProcesso[0]->getId(); ?>"
													funcao="telaVisualizarProcesso"
													controlador="ControladorProcesso" retorno="div_central"
													style=""
													title="<?php echo nl2br($objProcesso[0]->getDescricao()); ?>"><?php echo str_pad($objProcesso[0]->getId(), 5, '0', STR_PAD_LEFT); ?></td>
												<td class="getId dimensions" style="cursor: pointer"
													id="<?php echo $processo->getId(); ?>"
													funcao="telaVisualizarProcesso"
													controlador="ControladorProcesso" retorno="div_central"
													style=""
													title="<?php echo nl2br($objProcesso[0]->getDescricao()); ?>"><?php echo recuperaData($objProcesso[0]->getData()); ?></td>
												<td class="getId dimensions" style="cursor: pointer"
													id="<?php echo $processo->getId(); ?>"
													funcao="telaVisualizarProcesso"
													controlador="ControladorProcesso" retorno="div_central"
													style=""
													title="<?php echo nl2br($objProcesso[0]->getDescricao()); ?>"><?php echo limitarTexto($objProcesso[0]->getTitulo(), 40); ?></td>
												<td class="getId dimensions" style="cursor: pointer"
													id="<?php echo $processo->getId(); ?>"
													funcao="telaVisualizarProcesso"
													controlador="ControladorProcesso" retorno="div_central"
													style=""
													title="<?php echo nl2br($objProcesso[0]->getDescricao()); ?>"><?php echo ($objProcesso[0]->getFluxo()) ? limitarTexto($objProcesso[0]->getFluxo()->getTitulo(), 40) : ''; ?></td>
												<td class="getId dimensions" style="cursor: pointer"
													id="<?php echo $processo->getId(); ?>"
													funcao="telaVisualizarProcesso"
													controlador="ControladorProcesso" retorno="div_central"
													style=""
													title="<?php echo nl2br($processo->getDescricao()); ?>">
													<?php
														if($objProcessoFluxo->getVencimento() != "" && $objProcessoFluxo->getVencimento() != null && $objProcessoFluxo->getVencimento() != "00"){
															$date = strtotime($processo->getData());
															echo $objProcessoFluxo->getVencimento().'/'.date('m',$date).'/'.date('Y',$date);
														}else{
															echo "-";
														}
													?>
												</td>
												<td class="" style="text-align: center;">
													<span>
					                                    <?php
					                                    if ($objProcessoFluxo->getAtividade()->getImagem() == "" || $objProcessoFluxo->getAtividade()->getImagem() == null) {
			                                                $imagem = "assets/images/atividade.png";
			                                            } else {
			                                            	$imagem = "imagens/atividade/" . $objProcessoFluxo->getAtividade()->getImagem();
			                                            }
			                                            ?>
			                                            <div style="">
															<a class="dimensions"
																atuante="<?php echo $objProcessoFluxo->getAtuante(); ?>"
																style="text-decoration: none;"
																title="<?php echo 'Título: ' . $objProcessoFluxo->getTitulo() . '<br/>Descrição: ' . nl2br($objProcessoFluxo->getDescricao()); ?>">
			                                                    <?php
			                                                    $estilo = '';
			                                                    if ($objProcessoFluxo->getAtividade()->getId() != $objAtividade[0]->getId()) {
			                                                        $estilo = 'opacity: 0.1;z-index: 1;';
			                                                    } else {
			                                                        $estilo = ';z-index: 1;border: 3px solid #00F;cursor:pointer;';
			                                                    }
			                                                    ?>
																<img class="" style="width: 32px; height: 33px; <?php echo $estilo; ?>" src="<?php echo $imagem; ?>" />
															</a>
														</div>
								                    </span>
								                </td>
												<td id="valueChange" class="getId dimensions"
													style="cursor: pointer"
													title="<?php echo nl2br($processo->getDescricao()); ?>">
													<div>
					                                    <?php
					                                    if($objProcessoFluxo->getPropriedade() == '1'){
						                                    	$simbolo = '';
						                                    }else{
						                                    	$simbolo = '-';
						                                    }
						                                    echo 'R$ '.$simbolo.valorMonetario($objProcessoFluxo->getValor(),'2');
					                                    ?>
							                        </div>
												</td>
											</tr> 
						                    <?php						                        
						                    }
						                    ?>    				
						                </tbody>
									</table>
								</div>
							</div>
								
							<div class="card-body">
								<div class="form-group">
									<label for="nome" class="col-form-label" style="float: left;">Nome *</label> 
									<input id="titulo" name="titulo" type="text" disabled value="<?php echo $objProcessoFluxo->getTitulo(); ?>" class="form-control mgs_alerta" onkeyup="this.value=this.value.toUpperCase();">
								</div>
								<div class="form-group">
									<label for="descricao" style="float: left;">Descrição</label>
									<textarea class="form-control" id="descricao" disabled rows="3"><?php echo $objProcessoFluxo->getDescricao(); ?></textarea>
								</div>
					            <?php
					            if ($objAtividade != null && $objAtividade[0]->getLink()) {
					            ?>			
								<div class="form-group" style="text-align:left;">
									<label for="link" class="col-form-label">Link:&nbsp;
										<a target="_blank" href="<?php echo $objAtividade[0]->getLink(); ?>"><?php echo $objAtividade[0]->getLink(); ?></a>
									</label> 
								</div>
					            <?php
					            }								
					            if ($objAtividade != null && $objAtividade[0]->getArquivo()) {
					            ?>
								<div class="form-group" style="text-align:left;" >
									<label for="arquivoAtual" class="col-form-label">Arquivo da atividade disponivel:&nbsp;</label> 
									<input type="hidden" name="arquivo_atividade" id="arquivo_atividade" value="<?php echo $objAtividade[0]->getArquivo(); ?>" /> 
									<span name="arquivoAtual"  style="cursor: pointer;">
					                    <a target="_blank" title="Abrir arquivo: <?php echo $objAtividade[0]->getArquivo(); ?>" style="text-decoration: underline;" href="<?php echo './arquivos/atividade/'.$objAtividade[0]->getArquivo(); ?>"><?php echo $objAtividade[0]->getArquivo(); ?></a> &nbsp;
					                    <img src="assets/images/arrow.png" onClick="fnAbreArquivo('arquivo_atividade', './arquivos/atividade/')" style="cursor: pointer;width: 29px;" title="Download arquivo: <?php echo $objAtividade[0]->getArquivo(); ?>" >
					                </span>
								</div>
								<?php } ?>
							</div>
							<div class="card-footer" id="div_comentarios">
				        		<?php
					        		$controladorAtividade = new ControladorAtividade();
					        		echo $controladorAtividade->comentariosAtividadeProcesso($processoFluxo->getId(),true);
				        		?>
						    </div>
						</div>
					</div>
				</div>	
		      </div>
		    </div>
		  </div>
		</div>	
	<?php     	
    }
    
    public function telaCadastrarAgenda($post) {
		?>
        <div id="div_modal_agenda_retorno"></div>
        <script src="./assets/main/js/popup-upload.js" type="text/javascript"></script>
        <script src="./assets/main/js/jquery.form.js" type="text/javascript" ></script>
		<?php
    	date_default_timezone_set('America/Sao_Paulo');
		$dataIn = date("Y-m-d");
		if($post["data"] !== null){
			$dataIn = $post["data"];
		}
		$controladorAgenda = new ControladorAgenda();
		$eventos = $controladorAgenda->eventosAgenda($_SESSION["login"]->getId(), $dataIn);
		?>
        <script type="text/javascript" >
        
            $(document).ready(function() {
                
                $('#tooltip').hide();
                fncInserirArquivo("form_arquivo", "progress_arquivo", "porcentagem_arquivo", "arquivo", "arquivoAtual", "./arquivos/agenda/", "arquivo");
                fncMontaAgenda('#calendar1', <?php echo $_SESSION["login"]->getId(); ?>, '<?php echo $dataIn; ?>', <?php echo $eventos; ?>);
			    fncOrdenarAgenda();
			    
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

    public function telaListarAgenda($objAgenda) {
        $controladorAcao = new ControladorAcao();
        $perfil = $controladorAcao->retornaPerfilClasseAcao($_SESSION["login"], 'telaListarAgenda');
        ?>
        <script type="text/javascript">
            $.fn.dataTable.moment( 'DD/MM/YYYY' );
            $('.tablesorter').dataTable({
                "sPaginationType": "full_numbers",
                "aaSorting": [[0, 'desc']]
            });
            $(document).ready(function() {
                $('#tooltip').hide();
                fixTableLayout('example');
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
		                            <th>Status</th>  
		                            <th>Link</th> 
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
		                            <td onclick="fcnGetData(this)" style="cursor:pointer"  data="<?php echo recuperaData($agenda->getData()); ?>" funcao="telaCadastrarAgenda" controlador="ControladorAgenda" retorno="div_central"><?php echo ($agenda->getAtivo() == '1')?'Ativo':'Inativo'; ?></td> 
		                            <td onclick="fcnGetData(this)" style="cursor:pointer; text-align: center;"  data="<?php echo recuperaData($agenda->getData()); ?>" funcao="telaCadastrarAgenda" controlador="ControladorAgenda" retorno="div_central">
		                            	<?php echo ($agenda->getLink() != '' || $agenda->getLink() != null) ? '<a href="' . $agenda->getLink() . '" target="_blank" title="Acesso ao Link Clique aqui!" ><img src="assets/images/external_link29.png" ></a>' : ''; ?>
		                            </td> 
		                            <td style="text-align:center">
		                            	<div class="btn-group ml-auto">
				                            <?php 
				                            echo ($perfil === 'A') ? '<button onclick="fcnModalDeleteId(this)" modal="question" id="'.$agenda->getId().'" funcao="excluirAgendaList" controlador="ControladorAgenda" retorno="div_central" mensagem="4" class="deleteId btn btn-sm btn-outline-light"><i class="far fa-trash-alt"></i></button>':'<button class="deleteId btn btn-sm btn-outline-light"><i class="far fa-trash-alt"></i></button>';
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