<?php
abstract class ViewBase {
	
	protected function montarGrowlUI($post){
        echo ($post) ? " <script type='text/javascript'> 
                         $.growlUI2('" . $post . "', '&nbsp;'); 
                       </script>" : "";
	}
	
	protected function telaCadastroSimples($post){
		$this->montarGrowlUI($post);
		$tela = new Tela();
		?>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">        
		        <form action="#" method="post" id="formCadastro" class="">
		            <input type="hidden" name="retorno" id="retorno" value="<?php echo $tela->getRetorno(); ?>"/>
		            <input type="hidden" name="controlador" id="controlador" value="<?php echo $tela->getControlador(); ?>"/>
		            <input type="hidden" name="funcao" id="funcao" value="<?php echo $tela->getFuncao(); ?>"/>
		            <input type="hidden" name="mensagem" id="mensagem" value="<?php echo $tela->getMensagem(); ?>"/>
					<div class="card-header d-flex">
			            <h4 class="card-header-title"><?php echo $tela->getTitulo(); ?></h4>
			            <div class="toolbar ml-auto">
			            	<?php if($tela->getBotaoVoltar()){ 
			            		echo '<a href="#" onclick="fncButtonCadastro(this)" 
											      funcao="'.$tela->getBotaoVoltar()->getFuncao().'" 
                                                  controlador="'.$tela->getBotaoVoltar()->getControlador().'" 
                                                  retorno="'.($tela->getBotaoVoltar()->getControlador())?$tela->getBotaoVoltar()->getControlador():'div_central'.'" 
                                                  class="btn btn-light btn-sm buttonCadastro">Voltar</a>';
			            	} ?>
			            	<a href="#" onclick="fncFormCadastro(this)" class="btn btn-primary btn-sm formCadastro">Cadastrar</a>
			            </div>
		            </div>
		            <?php 
		            //TODO terminar
		            foreach ($campos as $campo) { 
					'<div class="card-body">				
						<div class="form-group">
							<label for="nome" class="col-form-label">Nome *</label>
							<input id="nome" name="nome" type="text" class="form-control mgs_alerta" onkeyup="this.value=this.value.toUpperCase();">
						</div>
					</div>';
				 } ?>
				</form>
				</div>
			</div>
		</div>				
		<?php 
	}
}