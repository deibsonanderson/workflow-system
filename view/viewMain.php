<?php

class ViewMain{
	
	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

	
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
									<td style="text-align:center"><?php echo $fluxoProcesso->getAtividade()->getVencimento(); ?></td> 
		                            <td style="text-align:center"><?php echo $processo->getTitulo(); ?></td> 
		                            <td style="text-align:center"><?php echo $fluxoProcesso->getAtividade()->getTitulo(); ?></td>								
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
		      <!--div class="modal-footer">
		        <button type="button" class="btn btn-secondary" id="1" >Não</button>
		        <button type="button" class="btn btn-primary" id="2" >Sim</button>
		      </div-->
		    </div>
		  </div>
		</div>
		<?php if($isShow){ ?>
      	<script>
			$(document).ready(function() {
			    $.blockUI({
		            message: $('#vencimento'),
		            //css: {
		            //    width: '70%'
		            //}
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