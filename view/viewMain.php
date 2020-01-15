<?php

class ViewMain{
	
	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

	public function checkStyleVencido($date){
		$result = "";
		if(strtotime(desformataData($date)) < strtotime(date("Y")."-".date("m")."-".date("d"))){
			$result = "color:#F0346E;";
		}
		return $result;
	}
	
	public function telaListarAtividadesProcessosHaVencer($processos){
		$isShow = false;
		?>
		<!-- Modal -->
		<div class="modal" id="vencimento" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title">Próximo do vencimento</h5>
		        <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">Fechar</span>
		        </button>
		      </div>
		      <div class="modal-body">
      			<div style="overflow-y: auto;height: 300px; ">
	      			<div class="table-responsive">
						<table id="example" class="table" style="width:100%">
							<thead>
								<tr>
									<th>Vencimento</th>
									<th>Processo</th>
									<th>Atividade</th> 
								</tr>
							</thead>
							<tbody>
							<?php
							if($processos != null){
								foreach ($processos as $processo){
									if($processo->getFluxoProcesso() != null){
										foreach($processo->getFluxoProcesso() as $fluxoProcesso){
											?>    
												<tr>
													<td style="<?php echo $this->checkStyleVencido($fluxoProcesso->getVencimento()); ?>text-align:center;"><?php echo $fluxoProcesso->getVencimento(); ?></td> 
						                            
						                            <td onclick="getId(this); $.unblockUI();" 
						                                funcao="telaTimeLineProcesso" 
						                                controlador="ControladorProcesso" 
						                                id="<?php echo $processo->getId(); ?>" 
						                                retorno="div_central"                 
						                            	style="<?php echo $this->checkStyleVencido($fluxoProcesso->getVencimento()); ?>text-align:center;cursor: pointer;"><?php echo $processo->getTitulo(); ?></td> 
						                            
						                            <td id_processo_fluxo="<?php echo $fluxoProcesso->getId(); ?>"
														id_processo="<?php echo $processo->getId(); ?>"
														id="<?php echo $fluxoProcesso->getAtividade()->getId(); ?>"
														ativo="<?php echo $fluxoProcesso->getAtivo(); ?>"
														atuante="<?php echo $fluxoProcesso->getAtuante(); ?>"
														titulo_processo_fluxo="<?php echo $fluxoProcesso->getTitulo(); ?>"
														vencimento_processo_fluxo="<?php echo $fluxoProcesso->getVencimento(); ?>"
														valor_processo_fluxo="<?php echo $fluxoProcesso->getValor(); ?>"
														descricao_processo_fluxo="<?php echo $fluxoProcesso->getDescricao(); ?>"
														onclick="getIdProcesso(this); $.unblockUI();"
														funcao="telaVisualizarAtividadeProcesso"
														controlador="controladorAtividade"
														retorno="div_central"
						                            	style="<?php echo $this->checkStyleVencido($fluxoProcesso->getVencimento()); ?>text-align:center;cursor: pointer;"><?php echo $fluxoProcesso->getTitulo(); ?></td>								
												</tr>	
											<?php
										}
										$isShow = true;
									}
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
		</div>
		<?php if($isShow){ ?>
      	<script>
			$(document).ready(function() {
			    $.blockUI({
		            message: $('#vencimento'),
		        });
		        $('#close').click(function() {
		            $.unblockUI();
		            return false;
		        }); 
			});      
		</script>			
		<?php 
		}
	}
}	


?>