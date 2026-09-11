<?php

class ViewDividas extends ViewBase {

    //construtor
    public function __construct() {
    }

    //destruidor
    public function __destruct() {
    }
    
    const CONTROLADOR = 'ControladorDividas';
    const TELA_LISTAR = 'telaListarDividas';

    public function telaCadastrarDividas($post) {
		echo $this->montarGrowlUI($post);
    	?>
		<script type="text/javascript" >
   			function validarCampo(elemento){
				if(validateDate($(elemento).val()) == false){
					msgSlide("17");
					$(elemento).val('<?php echo $dataIn; ?>');
				}
			}
		
		    if ($("#datetimepicker1").length) {
		        $('#datetimepicker1').datetimepicker({
		            format: 'L'
		        });
		    }
			if ($("#datetimepicker2").length) {
		        $('#datetimepicker2').datetimepicker({
		            format: 'L'
		        });
		    }
			$('.money').mask('000.000.000.000.000,00', {reverse: true});        
		</script>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">        
		        <form action="#" method="post" id="formCadastro" class="">
					<input type="hidden" name="retorno" id="retorno" value="<?php echo $this::DIV_CENTRAL; ?>"/>
					<input type="hidden" name="controlador" id="controlador" value="<?php echo $this::CONTROLADOR; ?>"/>
					<input type="hidden" name="funcao" id="funcao" value="incluirDividas"/>
					<input type="hidden" name="mensagem" id="mensagem" value="<?php echo $this::MENSAGEM_UM; ?>"/>
		            
					<div class="card-header d-flex">
			            <h4 class="card-header-title">Cadastrar Dívidas</h4>
			            <div class="toolbar ml-auto">
			            	<a href="#" onclick="fncButtonCadastro(this)" funcao="<?php echo $this::TELA_LISTAR; ?>" controlador="<?php echo $this::CONTROLADOR; ?>" retorno="<?php echo $this::DIV_CENTRAL; ?>" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
							<a href="#" onclick="fncFormCadastro(this)" class="btn btn-primary btn-sm formCadastro">Cadastrar</a>			            	
			            </div>
		            </div>
		            <div class="card-body">
						<div class="form-group">
							<label for="descricao" class="col-form-label">Descrição *</label>
							<input id="descricao" name="descricao" type="text" value="" class="form-control mgs_alerta">
						</div>
						
						<div class="form-group">
							<label for="valor" class="col-form-label">Valor R$ *</label>
							<input id="valor" name="valor" type="text" value="" class="form-control money mgs_alerta" >
						</div>
						
						<div class="form-group">
						    <label for="dataInicial">Data Inicial *</label>
							<div class="input-group date" id="datetimepicker1" data-target-input="nearest">
			                    <input type="text" id="dataInicial" onblur="validarCampo(this)" onkeypress="return mascara(event, this, '##/##/####');" maxlength="10" name="dataInicial" value="" class="form-control datetimepicker-input mgs_alerta" data-target="#datetimepicker1">
			                    <div class="input-group-append" id="datepicker1" name="datepicker1" data-target="#datetimepicker1" data-toggle="datetimepicker">
			                  		<div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
			                    </div>
			                </div>
		                </div>

						<div class="form-group">
						    <label for="dataFinal">Data Final *</label>
							<div class="input-group date" id="datetimepicker2" data-target-input="nearest">
			                    <input type="text" id="dataFinal" onblur="validarCampo(this)" onkeypress="return mascara(event, this, '##/##/####');" maxlength="10" name="dataFinal" value="" class="form-control datetimepicker-input mgs_alerta" data-target="#datetimepicker2">
			                    <div class="input-group-append" id="datepicker2" name="datepicker2" data-target="#datetimepicker2" data-toggle="datetimepicker">
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

    public function telaListarDividas($objDividas) {
    	$campos = array (
    			$this->criarCampo ( 'Codigo', 'id', $this::CODIGO ),
    			$this->criarCampo ( 'Descricao', 'descricao', $this::TEXT ),
				$this->criarCampo ( 'Data Inicial', 'dataInicial', $this::DATE ),
				$this->criarCampo ( 'Data Final', 'dataFinal', $this::DATE ),
				$this->criarCampo ( 'Valor', 'valor', $this::TEXT ));
    	
    	$botoesListar = array($this->criarBotaoListarAcao($this::CONTROLADOR, 'telaAlterarDividas',$this::ALTERAR),
    			$this->criarBotaoListarAcao($this::CONTROLADOR, 'excluirDividas', $this::EXCLUIR),
    			$this->criarBotaoListarAcao($this::CONTROLADOR, 'telaVisualizarDividas', $this::VISUALIZAR));
    	
    	$tela = $this->criarTela (
    			$this::CONTROLADOR,
    			'incluirDividas',
    			$this::DIV_CENTRAL,
    			$this::MENSAGEM_UM,
    			$this->montarBtnNovo($this::CONTROLADOR, 'telaCadastrarDividas'),
    			$this->montarBotaoAcao($this::CADASTRAR),
    			'Dívidas',
    			$campos,
    			$botoesListar);
    	
    	return $this->criarTelaListar( $tela, $objDividas, ViewBase::VERDADEIRO, ViewBase::VERDADEIRO );
    }

    public function telaAlterarDividas($objDividas) {
		$divida = $objDividas[0];
    	?>
		<script type="text/javascript" >
   			function validarCampo(elemento){
				if(validateDate($(elemento).val()) == false){
					msgSlide("17");
					$(elemento).val('<?php echo $dataIn; ?>');
				}
			}
		
		    if ($("#datetimepicker1").length) {
		        $('#datetimepicker1').datetimepicker({
		            format: 'L'
		        });
		    }
			if ($("#datetimepicker2").length) {
		        $('#datetimepicker2').datetimepicker({
		            format: 'L'
		        });
		    }
			$('.money').mask('000.000.000.000.000,00', {reverse: true});       
		</script>		
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">        
		        <form action="#" method="post" id="formCadastro" class="">
					<input type="hidden" name="retorno" id="retorno" value="<?php echo $this::DIV_CENTRAL; ?>"/>
					<input type="hidden" name="controlador" id="controlador" value="<?php echo $this::CONTROLADOR; ?>"/>
					<input type="hidden" name="funcao" id="funcao" value="alterarDividas"/>
					<input type="hidden" name="mensagem" id="mensagem" value="<?php echo $this::MENSAGEM_DOIS; ?>"/>
					<input type="hidden" name="id" id="id" value="<?php echo $divida->getId(); ?>"/>
		            
					<div class="card-header d-flex">
			            <h4 class="card-header-title">Alterar Dívida</h4>
			            <div class="toolbar ml-auto">
			            	<a href="#" onclick="fncButtonCadastro(this)" funcao="<?php echo $this::TELA_LISTAR; ?>" controlador="<?php echo $this::CONTROLADOR; ?>" retorno="<?php echo $this::DIV_CENTRAL; ?>" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
							<a href="#" onclick="fncFormCadastro(this)" class="btn btn-primary btn-sm formCadastro">Alterar</a>			            	
			            </div>
		            </div>
		            <div class="card-body">
						<div class="form-group">
							<label for="descricao" class="col-form-label">Descrição *</label>
							<input id="descricao" name="descricao" type="text" value="<?php echo $divida->getDescricao(); ?>" class="form-control mgs_alerta">
						</div>
						
						<div class="form-group">
							<label for="valor" class="col-form-label">Valor R$ *</label>
							<input id="valor" name="valor" type="text" value="<?php echo $divida->getValor(); ?>" class="form-control money mgs_alerta" >
						</div>
						
						<div class="form-group">
						    <label for="dataInicial">Data Inicial *</label>
							<div class="input-group date" id="datetimepicker1" data-target-input="nearest">
			                    <input type="text" id="dataInicial" onblur="validarCampo(this)" onkeypress="return mascara(event, this, '##/##/####');" maxlength="10" name="dataInicial" value="<?php echo recuperaData($divida->getDataInicial()); ?>" class="form-control datetimepicker-input mgs_alerta" data-target="#datetimepicker1">
			                    <div class="input-group-append" id="datepicker1" name="datepicker1" data-target="#datetimepicker1" data-toggle="datetimepicker">
			                  		<div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
			                    </div>
			                </div>
		                </div>

						<div class="form-group">
						    <label for="dataFinal">Data Final *</label>
							<div class="input-group date" id="datetimepicker2" data-target-input="nearest">
			                    <input type="text" id="dataFinal" onblur="validarCampo(this)" onkeypress="return mascara(event, this, '##/##/####');" maxlength="10" name="dataFinal" value="<?php echo recuperaData($divida->getDataFinal()); ?>" class="form-control datetimepicker-input mgs_alerta" data-target="#datetimepicker2">
			                    <div class="input-group-append" id="datepicker2" name="datepicker2" data-target="#datetimepicker2" data-toggle="datetimepicker">
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

    public function telaVisualizarDividas($objDividas) {
		$divida = $objDividas[0];
    	?>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">        
		        <form action="#" method="post" id="formCadastro" class="">
					<div class="card-header d-flex">
			            <h4 class="card-header-title">Visualizar Dívida</h4>
			            <div class="toolbar ml-auto">
			            	<a href="#" onclick="fncButtonCadastro(this)" funcao="<?php echo $this::TELA_LISTAR; ?>" controlador="<?php echo $this::CONTROLADOR; ?>" retorno="<?php echo $this::DIV_CENTRAL; ?>" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
			            </div>
		            </div>
		            <div class="card-body">
						<div class="form-group">
							<label for="descricao" class="col-form-label">Descrição *</label>
							<input disabled="disabled" id="descricao" name="descricao" type="text" value="<?php echo $divida->getDescricao(); ?>" class="form-control mgs_alerta">
						</div>
						
						<div class="form-group">
							<label for="valor" class="col-form-label">Valor R$ *</label>
							<input disabled="disabled" id="valor" name="valor" type="text" value="<?php echo $divida->getValor(); ?>" class="form-control money mgs_alerta" >
						</div>
						
						<div class="form-group">
						    <label for="dataInicial">Data Inicial *</label>
							<div class="input-group date" id="datetimepicker1" data-target-input="nearest">
			                    <input disabled="disabled" type="text" id="dataInicial" onblur="validarCampo(this)" onkeypress="return mascara(event, this, '##/##/####');" maxlength="10" name="dataInicial" value="<?php echo recuperaData($divida->getDataInicial()); ?>" class="form-control datetimepicker-input mgs_alerta" data-target="#datetimepicker1">
			                    <div class="input-group-append" id="datepicker1" name="datepicker1" data-target="#datetimepicker1" data-toggle="datetimepicker">
			                  		<div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
			                    </div>
			                </div>
		                </div>

						<div class="form-group">
						    <label for="dataFinal">Data Final *</label>
							<div class="input-group date" id="datetimepicker2" data-target-input="nearest">
			                    <input disabled="disabled" type="text" id="dataFinal" onblur="validarCampo(this)" onkeypress="return mascara(event, this, '##/##/####');" maxlength="10" name="dataFinal" value="<?php echo recuperaData($divida->getDataFinal()); ?>" class="form-control datetimepicker-input mgs_alerta" data-target="#datetimepicker2">
			                    <div class="input-group-append" id="datepicker2" name="datepicker2" data-target="#datetimepicker2" data-toggle="datetimepicker">
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
