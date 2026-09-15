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
    	
    	return $this->criarTelaListar( $tela, $objDividas, ViewBase::VERDADEIRO, ViewBase::VERDADEIRO, 'XPTO' );
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

	public function telaDiagramaDividas($objDividas, $periodo){
		$mesAtual = date('m');

		if($objDividas == null) {
			$cabecalhoAno = '<th rowspan="2" class="gantt-th-divida text-center">Não ha dados encontrados...</th>';
		} else {
			$cabecalhoAno = '<th rowspan="2" class="gantt-th-divida">Dívida</th>';
			foreach ($periodo as $ano => $meses){ 
				$cabecalhoAno .= '<th colspan="'.count($meses).'" class="text-center gantt-th-ano">'.$ano.'</th>';
			}

			$cabecalhoMes = '';
			foreach ($periodo as $ano => $meses){
				foreach ($meses as $mes){
					$cabecalhoMes .= '<th class="text-center gantt-th-mes" '.$this->marcarDataAtual($mesAtual, $mes).'  >'.obterSiglaMes($mes).'</th>';
				}
			}
		}
	?>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">        
					<div class="card-header d-flex">
			            <h4 class="card-header-title">Diagramas das dividias Futuras</h4>
			            <?php
			            if ($perfil !== 'C') {
			            ?>            
			            <div class="toolbar ml-auto">
			            	<a href="#" onclick="fncButtonCadastro(this)" 
							funcao="telaListarDividas" 
							controlador="ControladorDividas" 
							retorno="div_central" 
							class="btn btn-primary btn-sm buttonCadastro">Listar Dividas</a>
			            </div>
			            <?php
			            }
			            ?>            
			        </div>		
					<div class="card-body">
						<div class="rowtable-responsive" >
							<div id="gantt" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" >								
								<div class="gantt-container">
									<table class="table table-bordered table-sm gantt-table">
										<thead class="thead-light">
											<tr>												
												<?php echo $cabecalhoAno; ?>
											</tr>
											<tr>
												<?php echo $cabecalhoMes; ?>
											</tr>
										</thead>
										<tbody>
											<?php 
											$cores = ['#e6b8af', '#f4cccc', '#d9ead3', '#cfe2f3', '#fce5cd', '#fff2cc'];
											$corIndex = 0;
											$totalGeral = 0;
											$totalParcelaMes = 0;
											
											foreach ($objDividas as $divida){ 
												$dataIni = new DateTime($divida->getDataInicial());
												$dataFim = new DateTime($divida->getDataFinal());
												
												$inicioNormalizado = clone $dataIni;
												$inicioNormalizado->modify('first day of this month 00:00:00');
												
												$fimNormalizado = clone $dataFim;
												$fimNormalizado->modify('last day of this month 23:59:59');
												
												$corAtual = $cores[$corIndex % count($cores)];
												$corIndex++;
											
												$saldoDevedor = $this->saldoDevedorRestante($periodo, $divida->getValor());
												$totalGeral += $saldoDevedor;
												$totalParcelaMes += $divida->getValor();
												echo $this->montarCorpoDiagramaDividas($periodo, $divida, $inicioNormalizado, $fimNormalizado, $corAtual, $saldoDevedor);
											} 
											?>
										</tbody>
									</table>								
								</div>	
							</div>							
						</div>
					</div>
					<div class="card-header d-flex">
			            <h4 class="card-header-title">Total de Parcela no mês: <?php echo moneyFormat($totalParcelaMes); ?> / Saldo Devedor Geral R$ <?php echo moneyFormat($totalGeral); ?></h4>
			        </div>
				</div>
			</div>
		</div>	
	<?php 			
	}

	private function montarCorpoDiagramaDividas($periodo, $divida, $inicioNormalizado, $fimNormalizado, $corAtual, $saldoDevedor){
											
		$html = '<tr><td class="gantt-td-nome"><b>'.$divida->getDescricao().'</b>
		<br/>Valor por parcela: <b>'.moneyFormat($divida->getValor()).'</b>
		<br/>Saldo Devedor R$ <b>'.moneyFormat($saldoDevedor).'</b>
		</td>';
		
		$parcela = 1;
		$anoAtual = date('Y');
		$mesAtual = date('m');

		$totalParcelas = $this->totalParcelas($periodo);
		foreach ($periodo as $ano => $meses) { 
			foreach ($meses as $mes) {
				$dataAtual = new DateTime("$ano-$mes-01 00:00:00");
				
				$isAtivo = false;
				if ($dataAtual >= $inicioNormalizado && $dataAtual <= $fimNormalizado) {
					$isAtivo = true;
				}
			
				if ($isAtivo) { 

					$opacidade = ($mes < $mesAtual && $ano <= $anoAtual)?'opacity:50%;':'';

					$html .= '<td class="text-center gantt-td-parcela" '.$this->marcarDataAtual($mesAtual, $mes).'  >
								<div class="gantt-div-parcela" style="background-color: '.$corAtual.';'.$opacidade.'" title="'.$divida->getDescricao().'">
									'.$parcela++.' / '.$totalParcelas.'
								</div>
							  </td>';

				} else { 
					$html .= '<td class="gantt-td-vazio" '.$this->marcarDataAtual($mesAtual, $mes).'></td>';
				}
			} 
		}		
		$html .= '</tr>';
		return $html;	
	}

	private function marcarDataAtual($atual, $momento){
		return ($atual == $momento)?'style="background-color: #b4b4b4;"':'';
	}

	private function saldoDevedorRestante($periodo, $valor){
		$anoAtual = date('Y');
		$mesAtual = date('m');

		$total = 0;
		foreach ($periodo as $ano => $meses) { 
			foreach ($meses as $mes) {
				if($mes >= $mesAtual && $ano >= $anoAtual){
					$total += $valor;
				}
			}
		}
		return $total;
	}

	private function totalParcelas($periodo){
		$total = 0;
		foreach ($periodo as $ano => $meses) { 
			foreach ($meses as $mes) {
				$total++;
			}
		}
		return $total;
	}	

}
?>
