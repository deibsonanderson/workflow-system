<?php

class ViewProcesso {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }

    public function telaCadastrarProcesso($post) {
     	date_default_timezone_set('America/Sao_Paulo');
     	$dataIn = date("d/m/Y");
    	?>
        <script type="text/javascript">
        <?php
        echo ($post) ? "$.growlUI2('" . $post . "', '&nbsp;');" : "";
        ?>
		function addUser(elemento){
			$('#div_usuario').append($('#'+elemento).val()+'-'+$('#'+elemento).attr('descricao')+'<br/>');
		}
		 $('.money').mask('000.000.000.000.000,00', {reverse: true});

		 function validarCampo(elemento){
			 if(validateDate($(elemento).val()) == false){
			 	msgSlide("17");
			 	$(elemento).val('<?php echo $dataIn; ?>');
			 }
		 }

	    if ($("#datetimepicker4").length) {
	        $('#datetimepicker4').datetimepicker({
	            format: 'L'
	        });
	    }
		 
        </script>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">        
		        <form action="#" method="post" id="formCadastro" class="">
		            <input type="hidden" name="retorno" id="retorno" value="div_central"/>
		            <input type="hidden" name="controlador" id="controlador" value="ControladorProcesso"/>
		            <input type="hidden" name="funcao" id="funcao" value="incluirProcesso"/>
		            <input type="hidden" name="mensagem" id="mensagem" value="1"/>
					<div class="card-header d-flex">
			            <h4 class="card-header-title">Cadatro de Processo</h4>
			            <div class="toolbar ml-auto">
			            	<a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarProcesso" controlador="ControladorProcesso" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
			            	<a href="#" onclick="fncFormCadastro(this)" class="btn btn-primary btn-sm formCadastro">Cadastrar</a>
			            </div>
		            </div>
					<div class="card-body">				
						<div class="form-group">
							<label for="titulo" class="col-form-label">Titulo *</label>
							<input id="titulo" name="titulo" type="text" class="form-control mgs_alerta" onkeyup="this.value=this.value.toUpperCase();">
						</div>
						<div class="form-group">
							<label for="descricao">Descrição</label>
							<textarea class="form-control" name="descricao" id="descricao" rows="3"></textarea>
						</div>				
						
						<div class="form-group">
							<label for="provisao" class="col-form-label">Provisão R$</label>
							<input id="provisao" name="provisao" type="text" value="0,00" class="form-control money" >
						</div>
						
						<div class="form-group">
						    <label for="fluxo">Vigencia *</label>
							<div class="input-group date" id="datetimepicker4" data-target-input="nearest">
			                    <input type="text" id="vigencia" onblur="validarCampo(this)" onkeypress="return mascara(event, this, '##/##/####');" maxlength="10" name="vigencia" value="<?php echo $dataIn; ?>" class="form-control datetimepicker-input mgs_alerta" data-target="#datetimepicker4">
			                    <div class="input-group-append" id="datepicker" name="datepicker" data-target="#datetimepicker4" data-toggle="datetimepicker">
			                  		<div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
			                    </div>
			                </div>
		                </div>				
						
						<div class="form-group">
							<label for="fluxo">Fluxo *</label>
							<select id="fluxo" name="fluxo" class="mgs_alerta form-control" >
		                        <?php
		                        $controladorFluxo = new ControladorFluxo();
		                        $listFluxo = $controladorFluxo->listarFluxo();
		                        if ($listFluxo) {
		                            foreach ($listFluxo as $fluxo) {
		                                ?>
		                                <option value="<?php echo $fluxo->getId() ?>"><?php echo $fluxo->getTitulo(); ?></option>
		                                <?php
		                            }
		                        }
		                        ?>                               
							</select>						
							
						</div>				
					</div>
				</form>
				</div>
			</div>
		</div>		
        <?php
    }

    
    public function telaTimeLineProcesso($objProcesso, $order = null){
    	$funcao = "telaTimeLineProcesso";
    	if($order == '1'){
    		$funcao = "telaTimeLineProcessoOrderAtivo";
    	}
    	?>
        <script type="text/javascript">
        	$('.tablesorter').dataTable({
                "sPaginationType": "full_numbers",
                "aaSorting": [[0, 'desc']]
            });
            $('#tooltip').hide();

			if( screen.width > 360){
				$('#h4_desktop').hide();
			}else{				
				$('#h4_mobile').hide();
			}
			/*$('.dimensions').tooltip({
                track: true,
                delay: 0,
                showURL: true,
                opacity: 0.85
			});*/
        </script>
		<div id="timeline-top" class="row" onClick="limparListFilter();">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">        
					<div class="card-header d-flex">
						<h4 id="h4_mobile" class="card-header-title">
							<?php echo ($objProcesso == null || $objProcesso[0]->getTitulo() == null)?'Processos':limitarTexto($objProcesso[0]->getTitulo(), 50);?>
						</h4>
						<h4 id="h4_desktop" class="card-header-title">
							<?php echo ($objProcesso == null || $objProcesso[0]->getTitulo() == null)?'Processos':limitarTexto($objProcesso[0]->getTitulo(), 10);?>
						</h4>
						<div class="toolbar ml-auto">
							<a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarProcesso" controlador="ControladorProcesso" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
							<?php if($objProcesso != null && $objProcesso[0]->getId() != null ){ ?>
							<a href="#" onclick="getId(this)" id="<?php echo $objProcesso[0]->getId(); ?>" funcao="<?php echo $funcao; ?>" controlador="ControladorProcesso" retorno="div_central" class="btn btn-primary btn-sm formCadastro">Ordernar</a>
							<?php } ?>
						</div>
					</div>
					<div class="card-header d-flex">
						<div class="input-group" id="filter">
							<input type="text" id="filtro" onKeyUp="filtrarTimeline($(this).val(), false)" class="form-control" placeholder="Informe aqui o título da atividades...">
							<div class="input-group-append">
								<button type="button" onClick="filtrarTimeline('', false)" class="btn btn-light">Limpar</button>
							</div>
						</div>						
					</div>						
		     	</div>
		     </div>

		</div>
		<section class="cd-timeline js-cd-timeline" onClick="limparListFilter();">
			<div class="cd-timeline__container">
            <?php
            if ($objProcesso != null && $objProcesso[0]->getFluxoProcesso() != null) {
            	foreach ($objProcesso[0]->getFluxoProcesso() as $fluxoProcesso) {
            		
            		$controladorComentario = new ControladorComentarioFluxoProcesso();
            		$comentario = $controladorComentario->checarComentarioExistent($fluxoProcesso->getId());
            		
            		if ($fluxoProcesso->getAtividade()->getImagem() == "" || $fluxoProcesso->getAtividade()->getImagem() == null) {
            			$imagem = "assets/images/atividade.png";
            		} else {
            			$imagem = "imagens/atividade/" . $fluxoProcesso->getAtividade()->getImagem();
            		}
            
            		$btnEstilo = 'btn-light';
            		$imgEstilo = 'desativo';
            		$opacit = 'opacity:0.5;';
						
            		if($fluxoProcesso->getAtivo() == '1'){
            			$imgEstilo = 'ativo';
            			$btnEstilo = 'btn-primary';
						$opacit = 'opacity:1.0;';
            		}
            		if($fluxoProcesso->getAtuante() == '1'){
						$imgEstilo = 'picture';
            			$btnEstilo = 'btn-success';
            			$opacit = 'opacity:1.0;';
            		}            		
           ?>    
	            <div class="cd-timeline__block js-cd-block" style="<?php echo $opacit; ?>" >
					<div class="cd-timeline__img cd-timeline__img--<?php echo $imgEstilo; ?> js-cd-img" 
						 id_processo_fluxo="<?php echo $fluxoProcesso->getId(); ?>"
						 id_processo="<?php echo $objProcesso[0]->getId(); ?>" 
						 id="<?php echo $fluxoProcesso->getAtividade()->getId(); ?>"
						 ativo="<?php echo $fluxoProcesso->getAtivo(); ?>"
						 atuante="<?php echo $fluxoProcesso->getAtuante(); ?>"
						 onclick="getIdProcesso(this)"
						 funcao="telaVisualizarAtividadeProcesso" 
						 controlador="controladorAtividade" 
						 retorno="div_central"
						 style="cursor: pointer;">
						<img src="<?php echo $imagem; ?>" alt="Picture">
					</div>
					<!-- cd-timeline__img -->
					<div class="cd-timeline__content js-cd-content">
						<h3 id_processo_fluxo="<?php echo $fluxoProcesso->getId(); ?>"
							id_processo="<?php echo $objProcesso[0]->getId(); ?>" 
							id="<?php echo $fluxoProcesso->getAtividade()->getId(); ?>"
							ativo="<?php echo $fluxoProcesso->getAtivo(); ?>"
							atuante="<?php echo $fluxoProcesso->getAtuante(); ?>"
							onclick="getIdProcesso(this)"
							funcao="telaVisualizarAtividadeProcesso" 
							controlador="controladorAtividade" 
							retorno="div_central"
							style="cursor: pointer;">
								<?php echo $fluxoProcesso->getAtividade()->getTitulo(); ?>
							</h3>
						<p>
						<?php 
						if($comentario->totalComentario > 0){
							echo '<i class="fas fa-file-archive"></i> Anexos ('.$comentario->totalComentario.')';
						} 
						if($comentario->totalAnexo > 0 && $comentario->totalComentario > 0){
							echo '&nbsp&nbsp&nbsp';
						}		
						if($comentario->totalAnexo > 0){
							echo '<i class="fas fa-file-alt"></i> Comentários ('.$comentario->totalAnexo.')'; 
						}	 
					    ?>
						</p>	
						<p  id_processo_fluxo="<?php echo $fluxoProcesso->getId(); ?>"
							id_processo="<?php echo $objProcesso[0]->getId(); ?>" 
							id="<?php echo $fluxoProcesso->getAtividade()->getId(); ?>"
							ativo="<?php echo $fluxoProcesso->getAtivo(); ?>"
							atuante="<?php echo $fluxoProcesso->getAtuante(); ?>"
							onclick="getIdProcesso(this)"
							funcao="telaVisualizarAtividadeProcesso" 
							controlador="controladorAtividade" 
							retorno="div_central"
							style="cursor: pointer;"><?php echo $fluxoProcesso->getAtividade()->getDescricao(); ?>
							<br />
							Valor: <?php 
							$propriedade = ($fluxoProcesso->getAtividade()->getPropriedade() == '1')?'':'-';
							echo 'R$ '.$propriedade.moneyFormat($fluxoProcesso->getAtividade()->getValor()); 
							?>
							</p>
						<a  href="#" 
							id_processo_fluxo="<?php echo $fluxoProcesso->getId(); ?>"
							id_processo="<?php echo $objProcesso[0]->getId(); ?>" 
							id="<?php echo $fluxoProcesso->getAtividade()->getId(); ?>"
							ativo="<?php echo $fluxoProcesso->getAtivo(); ?>"
							atuante="<?php echo $fluxoProcesso->getAtuante(); ?>"
							onclick="getIdProcesso(this)"
							funcao="telaVisualizarAtividadeProcesso" 
							controlador="controladorAtividade" 
							retorno="div_central" 
							class="btn <?php echo $btnEstilo; ?> btn-lg getIdProcesso"><!--Detalhe-->
							<img src="./assets/images/<?php echo ($fluxoProcesso->getAtivo() == '1')?'go.png':'godisabled.png' ?>" class="time-line-btn-action"></a>

		                <?php
		                if ($fluxoProcesso->getAtuante() == 1) {
		                ?>
		                    <a href="#" onclick="getId(this)" funcao="desatuarFluxoProcesso" controlador="controladorProcesso" id="<?php echo $fluxoProcesso->getId(); ?>" retorno="div_central" class="btn <?php echo $btnEstilo; ?> btn-lg getIdProcesso" ><img src="./assets/images/desactive.png" class="time-line-btn-action"><!-- Desmarcar --></a>
		                <?php
		                } else if ($fluxoProcesso->getAtivo() == 1 && $fluxoProcesso->getAtuante() != 1) {
		                ?>
		                    <a href="#" onclick="getId(this)" funcao="atuarFluxoProcesso" controlador="controladorProcesso" id="<?php echo $fluxoProcesso->getId(); ?>" retorno="div_central" class="btn <?php echo $btnEstilo; ?> btn-lg getIdProcesso" ><img src="./assets/images/active.png" class="time-line-btn-action"><!--Marcar --></a>
		                <?php
		                }
		
		                if ($fluxoProcesso->getAtivo() == 1) {
		                ?>
		                    <a href="#" onclick="getId(this)" funcao="fecharFluxoProcesso" controlador="controladorProcesso" id="<?php echo $fluxoProcesso->getId(); ?>" retorno="div_central" class="btn <?php echo $btnEstilo; ?> btn-lg getIdProcesso" ><img src="./assets/images/close.png" class="time-line-btn-action"><!--Fechar --></a>
		                <?php
		                } else {
		                ?>
		                    <a href="#" onclick="getId(this)" funcao="abrirFluxoProcesso" controlador="controladorProcesso" id="<?php echo $fluxoProcesso->getId(); ?>" retorno="div_central" class="btn <?php echo $btnEstilo; ?> btn-lg getIdProcesso" ><img src="./assets/images/open.png" class="time-line-btn-action"><!--Abrir --></a>
		                <?php
		                }
		                ?>
					</div>
					<!-- cd-timeline__content -->
				</div>
           <?php
           		}
    	    }
	       ?>    	
			</div>
		</section>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">        
				<div class="card-header d-flex">
		            <h4 class="card-header-title"></h4>
		            <div class="toolbar ml-auto">
		            	<a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarProcesso" controlador="ControladorProcesso" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
		            	<a href="#timeline-top" class="btn btn-primary btn-sm buttonCadastro">Topo</a>
		            </div>
		        </div>	
		     	</div>
		     </div>
		</div>
	<?php 
    }
    
    public function telaListarProcesso($objProcesso){
    	$controladorAcao = new ControladorAcao();
    	$perfil = $controladorAcao->retornaPerfilClasseAcao($_SESSION["login"], 'telaListarProcesso');
		?>
        <script type="text/javascript">
        	$('.tablesorter').dataTable({
                "sPaginationType": "full_numbers",
                "aaSorting": [[0, 'desc']]
            });
            $(document).ready(function() {
                $('#tooltip').hide();
                fixTableLayout('example');                
            });  
            /*$('.dimensions').tooltip({
                track: true,
                delay: 0,
                showURL: true,
                opacity: 0.85
            });*/
        </script>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">        
					<div class="card-header d-flex">
			            <h4 class="card-header-title">Módulos</h4>
			            <?php
			            if ($perfil !== 'C') {
			            ?>            
			            <div class="toolbar ml-auto">
			            	<a href="#" onclick="fncButtonCadastro(this)" funcao="telaCadastrarProcesso" controlador="ControladorProcesso" retorno="div_central" class="btn btn-primary btn-sm buttonCadastro">Novo</a>
			            </div>
			            <?php
			            }
			            ?>            
			        </div>		
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="tablesorter table table-striped table-bordered second" style="width:100%">
								<thead>
									<tr>
			                            <th>Fluxos</th>
										<th>Gráfico</th>
										<th>Relatório</th>
										<th>Código</th> 
			                            <th>Data</th> 
			                            <th>Título</th> 
			                            <th>Tipo</th>
			                            <th>Provisão</th>
			                            <th>Atividades</th> 
			                            <th>Restante</th>			                             
			                            <th class="sorting_disabled" style="text-align: center;" >A&ccedil;&atilde;o</th> 
									</tr>
								</thead>
			                    <tbody>
			                        <?php
			                        if ($objProcesso != null && $objProcesso[0]->getId() != null) {
										foreach ($objProcesso as $processo) {
											
											$count = 0;
											$restante = 0;
											$total = 0;
											if ($processo->getFluxoProcesso() != null) {
												foreach ($processo->getFluxoProcesso() as $fluxoProcesso) {		
													if($fluxoProcesso->getAtividade()->getPropriedade() == '1'){
														$total += $fluxoProcesso->getAtividade()->getValor();
													}else{
														$total -= $fluxoProcesso->getAtividade()->getValor();
													}
													
													if($fluxoProcesso->getAtivo() == '1'){
														$count += 1;
													}
												}
											}
											$restante = $processo->getProvisao()+$total; 
											
											$styleCor = '';
											if($count > 0){
												$styleCor = 'color:#FF407B;';
											}
											?>    
			                                <tr style="<?php echo $styleCor; ?>">
			                                    <td onclick="getId(this)"  class="getId dimensions" style="cursor:pointer;text-align: center;"  id="<?php echo $processo->getId(); ?>" funcao="telaTimeLineProcesso" controlador="ControladorProcesso" retorno="div_central" style="" title="<?php echo nl2br($processo->getDescricao()); ?>" ><img alt="time line" src="./assets/images/flow.png"></td> 
			                                    <td onclick="getId(this)"  class="getId dimensions" style="cursor:pointer;text-align: center;"  id="<?php echo $processo->getId(); ?>" funcao="telaGraficoProcessosAtividades" controlador="ControladorProcesso" retorno="div_central" style="" title="<?php echo nl2br($processo->getDescricao()); ?>" ><img alt="gráfico" src="./assets/images/chart.png" style="width: 38px;"></td> 
			                                    <td onclick="getId(this)"  class="getId dimensions" style="cursor:pointer;text-align: center;"  id="<?php echo $processo->getId(); ?>" funcao="telaRelatorioProcessosAtividades" controlador="ControladorProcesso" retorno="div_central" style="" title="<?php echo nl2br($processo->getDescricao()); ?>" ><img alt="gráfico" src="./assets/main/images/relatorio-logo.png" style="width: 38px;"></td> 
			                                    <td onclick="getId(this)"  class="getId dimensions" style="cursor:pointer"  id="<?php echo $processo->getId(); ?>" funcao="telaVisualizarProcesso" controlador="ControladorProcesso" retorno="div_central" style="" title="<?php echo nl2br($processo->getDescricao()); ?>" ><?php echo str_pad($processo->getId(), 5, '0', STR_PAD_LEFT); ?></td> 
			                                    <td onclick="getId(this)"  class="getId dimensions" style="cursor:pointer"  id="<?php echo $processo->getId(); ?>" funcao="telaVisualizarProcesso" controlador="ControladorProcesso" retorno="div_central" style="" title="<?php echo nl2br($processo->getDescricao()); ?>" ><?php echo recuperaData($processo->getData()); ?></td> 
			                                    <td onclick="getId(this)"  class="getId dimensions" style="cursor:pointer"  id="<?php echo $processo->getId(); ?>" funcao="telaVisualizarProcesso" controlador="ControladorProcesso" retorno="div_central" style="" title="<?php echo nl2br($processo->getDescricao()); ?>"  ><?php echo limitarTexto($processo->getTitulo(), 40); ?></td> 
			                                    <td onclick="getId(this)"  class="getId dimensions" style="cursor:pointer"  id="<?php echo $processo->getId(); ?>" funcao="telaVisualizarProcesso" controlador="ControladorProcesso" retorno="div_central" style="" title="<?php echo nl2br($processo->getDescricao()); ?>" ><?php echo  ($processo->getFluxo())?limitarTexto($processo->getFluxo()->getTitulo(), 40):''; ?></td> 
			                                    <td onclick="getId(this)"  class="getId dimensions" style="cursor:pointer"  id="<?php echo $processo->getId(); ?>" funcao="telaVisualizarProcesso" controlador="ControladorProcesso" retorno="div_central" style="" title="<?php echo nl2br($processo->getDescricao()); ?>" ><?php echo 'R$ '.number_format($processo->getProvisao(), 2, ',', '.'); ?></td>
			                                    <td onclick="getId(this)"  class="getId dimensions" style="cursor:pointer"  id="<?php echo $processo->getId(); ?>" funcao="telaVisualizarProcesso" controlador="ControladorProcesso" retorno="div_central" style="" title="<?php echo nl2br($processo->getDescricao()); ?>" ><?php echo 'R$ '.number_format($total, 2, ',', '.'); ?></td> 
			                                    <td onclick="getId(this)"  class="getId dimensions" style="cursor:pointer"  id="<?php echo $processo->getId(); ?>" funcao="telaVisualizarProcesso" controlador="ControladorProcesso" retorno="div_central" style="" title="<?php echo nl2br($processo->getDescricao()); ?>" ><?php echo 'R$ '.number_format($restante, 2, ',', '.'); ?></td> 
			                                    <td style="text-align:center">
						                            <div class="btn-group ml-auto">
			                                        <?php
			                                        echo ($perfil !== 'C')? '<button onclick="getId(this)" id="'.$processo->getId().'" funcao="telaAlterarProcesso" controlador="ControladorProcesso" retorno="div_central" class="getId btn btn-sm btn-outline-light"><i class="far fa-edit"></i></button>':'<button class="btn btn-sm" style="cursor: default;" ><i class="far fa-edit"></i></button>';
			                                        echo ($perfil === 'A')? '<button onclick="fncDeleteId(this)"  modal="question" id="'.$processo->getId().'" funcao="excluirProcesso" controlador="ControladorProcesso" retorno="div_central" mensagem="4"  class="deleteId btn btn-sm btn-outline-light"><i class="far fa-trash-alt"></i></button>':'<button class="btn btn-sm" style="cursor: default;" ><i class="far fa-trash-alt"></i></button>'; 
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
    
    public function telaVisualizarProcesso($objProcesso) {
        ?>
        <script type="text/javascript">
        <?php
            echo ($post) ? "$.growlUI2('" . $post . "', '&nbsp;');" : "";
        ?>
		$(document).ready(function() {
			$('#tooltip').hide();
        });
        </script>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">        
		        <form action="#" method="post" id="formCadastro" class="">
		            <div class="card-header d-flex">
			            <h4 class="card-header-title">Visualizar Processo</h4>
			            <div class="toolbar ml-auto">
			            	<a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarProcesso" controlador="ControladorProcesso" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
			            </div>
		            </div>
					<div class="card-body">				
						<div class="form-group">
							<label for="titulo" class="col-form-label">Titulo *</label>
							<input id="titulo" name="titulo" type="text" disabled value="<?php echo $objProcesso[0]->getTitulo(); ?>" class="form-control mgs_alerta" onkeyup="this.value=this.value.toUpperCase();">
						</div>
						<div class="form-group">
							<label for="descricao">Descrição</label>
							<textarea class="form-control" id="descricao" disabled rows="3"><?php echo $objProcesso[0]->getDescricao(); ?></textarea>
						</div>				
						<div class="form-group">
							<label for="titulo" class="col-form-label">Fluxo *</label>
							<input id="titulo" name="titulo" type="text" disabled value="<?php echo $objProcesso[0]->getFluxo()->getTitulo(); ?>" class="form-control mgs_alerta" onkeyup="this.value=this.value.toUpperCase();">
						</div>				
						<div class="form-group">
							<label for="provisao" class="col-form-label">Provisão R$</label>
							<input id="provisao" name="provisao" disabled value="<?php echo valorMonetario($objProcesso[0]->getProvisao(), '2'); ?>" type="text" class="form-control money" >
						</div>					
					</div>
				</form>
				</div>
			</div>
		</div>		        
        <?php
    }
    
    public function telaGraficoProcessosAtividades($objProcesso){
    	$data = "";
    	if ($objProcesso != null && $objProcesso[0]->getFluxoProcesso() != null) {
    		foreach ($objProcesso[0]->getFluxoProcesso() as $fluxoProcesso) {
				$sinal = ($fluxoProcesso->getAtividade()->getPropriedade() == '1')?'':'-';
				
    			$data .= "{ x: '".limitarTexto($fluxoProcesso->getAtividade()->getTitulo(), 30)."', y: ".$sinal.$fluxoProcesso->getAtividade()->getValor()." },";	
    			
    		}
    		$data = substr($data, 0, -1);
    	}
    	?>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">
					<div class="card-header d-flex">
			            <h4 class="card-header-title">Atividades do processo</h4>
			            <div class="toolbar ml-auto">
			            	<a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarProcesso" controlador="ControladorProcesso" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
			            </div>
		            </div>
					<div class="card-body">
						<div id="morris_bar"></div>
					</div>
				</div>
			</div>
		</div>
	    <script type="text/javascript">
    	(function(window, document, $, undefined) {
    	    "use strict";
    	    $(function() {
				
    	        if ($('#morris_bar').length) {
    	            Morris.Bar({
    	                element: 'morris_bar',
    	                data: [ <?php echo $data; ?> ],
    	                xkey: 'x',
    	                ykeys: ['y'],
    	                labels: ['Y'],
    	                   barColors: ['#5969ff'],
    	                     resize: true,
    	                        gridTextSize: '14px'
    	            });
    	        }

    	    });

    	})(window, document, window.jQuery); 
    	</script>
		<?php 
    }
    
    
    public function telaGraficoProcessos($objProcesso){
    	$labels = '[';
    	$provisao = '[';
    	$soma = '[';
    	if ($objProcesso != null) {
    		foreach ($objProcesso as $key=>$processo) {
    			if($key < 5){
    				$restante = $processo->getProvisao();
    				if ($processo->getFluxoProcesso() != null) {
    					foreach ($processo->getFluxoProcesso() as $fluxoProcesso) {
    						if($fluxoProcesso->getAtivo() == '0'){
    							if($fluxoProcesso->getAtividade()->getPropriedade() == '1'){
    								$restante += $fluxoProcesso->getAtividade()->getValor();
    							}else{
    								$restante -= $fluxoProcesso->getAtividade()->getValor();
    							}
    						}
    					}
    				}
    				$labels .= "'.".limitarTexto($processo->getTitulo(), 30).".',";
    				$provisao .= "".$processo->getProvisao().",";
    				$soma .= "".$restante.",";
    			}
    		}
    		
    		$labels = substr($labels, 0, -1)."]";
    		$provisao = substr($provisao, 0, -1)."]";
    		$soma = substr($soma, 0, -1)."]";
    		
    	}
    	?>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">
					<div class="card-header d-flex">
			            <h4 class="card-header-title">Gráfico Processos</h4>
			            <div class="toolbar ml-auto">
			            	<a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarProcesso" controlador="ControladorProcesso" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
			            </div>
		            </div>
					<div class="card-body">
						<canvas id="chartjs_bar"></canvas>
					</div>
				</div>
			</div>
		</div>
	    <script type="text/javascript">
    	(function(window, document, $, undefined) {
    	    "use strict";
    	    $(function() {

                if ($('#chartjs_bar').length) {
                    var ctx = document.getElementById("chartjs_bar").getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: <?php echo $labels; ?>,
                            datasets: [{
                                label: 'Provisão',
                                data: <?php echo $provisao; ?>,
                               backgroundColor: "rgba(89, 105, 255,0.5)",
                                        borderColor: "rgba(89, 105, 255,0.7)",
                                borderWidth: 2
                            }, {
                                label: 'Total Atividades',
                                data: <?php echo $soma; ?>,
                               backgroundColor: "rgba(255, 64, 123,0.5)",
                                        borderColor: "rgba(255, 64, 123,0.7)",
                                borderWidth: 2
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{

                                }]
                            },
                            legend: {
                            display: true,
                            position: 'bottom',

                            labels: {
                                fontColor: '#71748d',
                                fontFamily: 'Circular Std Book',
                                fontSize: 14,
                            }
                        },

                        scales: {
                            xAxes: [{
                                ticks: {
                                    fontSize: 14,
                                    fontFamily: 'Circular Std Book',
                                    fontColor: '#71748d',
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    fontSize: 14,
                                    fontFamily: 'Circular Std Book',
                                    fontColor: '#71748d',
                                }
                            }]
                        }
                    }

                        
                    });
                }

    	    });

    	})(window, document, window.jQuery); 
    	</script>
		<?php 
    }
    
    public function telaRelatorioProcessosAtividades($objProcesso){
    	?>
        <script type="text/javascript">
        	$('.tablesorter').dataTable({
        		"info": false,
                "paging":false
            });
            $('#tooltip').hide();
        </script>    	
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">        
					<div class="card-header d-flex">
			            <h4 class="card-header-title">Relatório Atividades do Processos</h4>
			            <div class="toolbar ml-auto">
			            	<a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarProcesso" controlador="ControladorProcesso" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
							<a href="#" onclick="window.open('planilha.php?id=<?php echo $objProcesso[0]->getId();?>');" class="btn btn-primary btn-sm buttonCadastro">Download</a>
			            </div>
			        </div>		
					<div class="card-body">
						<div class="table-responsive">
							<table id="rel-atividades" class="tablesorter table table-striped table-bordered second" style="width:100%">
								<thead>
									<tr>
			                            <th>Imagem</th>
			                            <th>Título</th> 
			                            <th>Valor (R$)</th>
										<th>Status</th>
			                        </tr>
								</thead>
			                    <tbody>
		                        <?php 
		                        if ($objProcesso != null && $objProcesso[0]->getFluxoProcesso() != null) {
		                        	$positivo = 0;
		                        	$negativo = 0;
		                        	$aberto = 0;
									$fechado = 0;
									
		                        	foreach ($objProcesso[0]->getFluxoProcesso() as $fluxoProcesso) {
		                        		if($fluxoProcesso->getAtividade()->getPropriedade() == '1'){
		                        			$positivo += $fluxoProcesso->getAtividade()->getValor();
		                        			$sinal = '';
		                        			$colorcss = 'color:BLUE;';
		                        		}else{
		                        			$negativo += $fluxoProcesso->getAtividade()->getValor();
		                        			$sinal = '-';
		                        			$colorcss = 'color:RED;';
		                        		}
		                        		
										if($fluxoProcesso->getAtivo() == '1' ){
											if($fluxoProcesso->getAtividade()->getPropriedade() == '1'){
												$aberto += $fluxoProcesso->getAtividade()->getValor();
											}else{
												$aberto -= $fluxoProcesso->getAtividade()->getValor();
											}
											$colorStatus = 'color:RED;';
										}else{
											if($fluxoProcesso->getAtividade()->getPropriedade() == '1'){
												$fechado += $fluxoProcesso->getAtividade()->getValor();
											}else{
												$fechado -= $fluxoProcesso->getAtividade()->getValor();
											}
											$colorStatus = 'color:BLUE;';
										}	
											
		                        		$imagem = './assets/images/avatar-1.jpg';
		                        		if($fluxoProcesso->getAtividade()->getImagem() != null && $fluxoProcesso->getAtividade()->getImagem() != ''){
		                        			$imagem = './imagens/atividade/'.$fluxoProcesso->getAtividade()->getImagem();
		                        		}
		                        		
		                        		?>    
											<tr>
												<td style="text-align: center;"><img src="<?php echo $imagem; ?>" style="width: 38px;"></td> 
					                            <td ><?php echo limitarTexto($fluxoProcesso->getAtividade()->getTitulo(), 30); ?></td> 
					                            <td style="<?php echo $colorcss; ?>" ><?php echo $sinal.valorMonetario($fluxoProcesso->getAtividade()->getValor(),'2'); ?></td> 
												<td style="text-align: center; <?php echo $colorStatus; ?>"><?php echo ($fluxoProcesso->getAtivo() == '0')?'Fechado':'Aberto'; ?></td> 
											</tr>	
										<?php
			                        }
									$negativo = $negativo*(-1);
			                    }
				                ?>
			                    </tbody> 
							</table>
							<br/>
							<br/>
							<table id="rel-totais" class="tablesorter table table-striped table-bordered second" style="width:100%">
			                    <tbody>
					                <tr>
										<td style="" >Provisão:</td> 
						                <td style="" ><?php echo 'R$ '.moneyFormat($objProcesso[0]->getProvisao()); ?></td> 
						            </tr>
						            <tr>
										<td style="" >Total Aberto:</td> 
						                <td style="color:RED;" ><?php echo 'R$ '.moneyFormat($aberto); ?></td> 
						            </tr>
						            <tr>
										<td style="" >Total Fechado:</td> 
						                <td style="color:BLUE;" ><?php echo 'R$ '.moneyFormat($fechado); ?></td> 
						            </tr>
						            <tr>
										<td style="" >Total Positivo:</td> 
						                <td style="color:BLUE;" ><?php echo 'R$ '.moneyFormat($positivo); ?></td> 
						            </tr>
						            <tr>
										<td style="" >Total Negativo:</td> 
						                <td style="color:RED;" ><?php echo 'R$ '.moneyFormat($negativo); ?></td> 
						            </tr>  
					                <tr>
										<td style="" >Total Geral (Positivo x Negativo):</td> 
						                <td style="" ><?php echo 'R$ '.moneyFormat(($positivo+$negativo)); ?></td> 
						            </tr>
						            <tr>
										<td style="" >Provisão x Total Geral:</td> 
						                <td style="color:#008000;" ><?php echo 'R$ '.moneyFormat(($objProcesso[0]->getProvisao()+($positivo+$negativo))); ?></td> 
						            </tr>   
						        </tbody>
						     </table>       			                    
						</div>
					</div>
				</div>
			</div>
		</div>			
		<?php 
    }
    
    
    public function telaAlterarProcesso($objProcesso) {
    	date_default_timezone_set('America/Sao_Paulo');
    	$dataIn = date("d/m/Y");
    	?>
        <script type="text/javascript">
		function validarCampo(elemento){
			 if(validateDate($(elemento).val()) == false){
			 	msgSlide("17");
			 	$(elemento).val('<?php echo $dataIn; ?>');
			 }
		}    	

	    if ($("#datetimepicker4").length) {
	        $('#datetimepicker4').datetimepicker({
	            format: 'L'
	        });
	    }
			
    	<?php
            echo ($post) ? "$.growlUI2('" . $post . "', '&nbsp;');" : "";
        ?>
		$(document).ready(function() {
			$('#tooltip').hide();
        });
		$('.money').mask('000.000.000.000.000,00', {reverse: true});
        </script>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">        
		        <form action="#" method="post" id="formCadastro" class="">
		            <input type="hidden" name="retorno" id="retorno" value="div_central"/>
		            <input type="hidden" name="controlador" id="controlador" value="ControladorProcesso"/>
		            <input type="hidden" name="funcao" id="funcao" value="alterarProcesso"/>
		            <input type="hidden" name="mensagem" id="mensagem" value="1"/>
		            <input type="hidden" name="id" id="id" value="<?php echo $objProcesso[0]->getId(); ?>"/>		        
		            <div class="card-header d-flex">
			            <h4 class="card-header-title">Visualizar Processo</h4>
			            <div class="toolbar ml-auto">
			            	<a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarProcesso" controlador="ControladorProcesso" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
			        		<a href="#" onclick="fncFormCadastro(this)" class="btn btn-primary btn-sm formCadastro">Alterar</a>
			            </div>
		            </div>
					<div class="card-body">				
						<div class="form-group">
							<label for="titulo" class="col-form-label">Titulo *</label>
							<input id="titulo" name="titulo" type="text" value="<?php echo $objProcesso[0]->getTitulo(); ?>" class="form-control mgs_alerta" onkeyup="this.value=this.value.toUpperCase();">
						</div>
						<div class="form-group">
							<label for="descricao">Descrição</label>
							<textarea class="form-control" id="descricao" rows="3"><?php echo $objProcesso[0]->getDescricao(); ?></textarea>
						</div>				
						<div class="form-group">
							<label for="titulo" class="col-form-label">Fluxo *</label>
							<input id="titulo" name="titulo" type="text" disabled value="<?php echo $objProcesso[0]->getFluxo()->getTitulo(); ?>" class="form-control mgs_alerta" onkeyup="this.value=this.value.toUpperCase();">
						</div>				
						<div class="form-group">
							<label for="provisao" class="col-form-label">Provisão R$</label>
							<input id="provisao" name="provisao" value="<?php echo valorMonetario($objProcesso[0]->getProvisao(), '2'); ?>" type="text" class="form-control money" >
						</div>
						<div class="form-group">
						    <label for="fluxo">Vigencia *</label>
							<div class="input-group date" id="datetimepicker4" data-target-input="nearest">
			                    <input type="text" id="vigencia" onblur="validarCampo(this)" onkeypress="return mascara(event, this, '##/##/####');" maxlength="10" name="vigencia" value="<?php echo recuperaData($objProcesso[0]->getData()); ?>" class="form-control datetimepicker-input mgs_alerta" data-target="#datetimepicker4">
			                    <div class="input-group-append" id="datepicker" name="datepicker" data-target="#datetimepicker4" data-toggle="datetimepicker">
			                  		<div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
			                    </div>
			                </div>
		                </div>													
					</div>
				</form>
				</div>
			</div>
		</div>		        
        <?php
	}

}
?>