<?php

class ViewClasse extends ViewBase {
	
	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}
	
	const CONTROLADOR = 'ControladorClasse';
	const TELA_LISTAR = 'telaListarClasse';
	
	public function telaCadastrarClasse($post){		
		?>
		<script type="text/javascript">
			<?php
			echo ($post)?"$.growlUI2('".$post."', '&nbsp;');":"";
			?>			        
   		</script>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">   		
		        <form action="#" method="post" id="formCadastro" class="">
					<input type="hidden" name="retorno" id="retorno" value="div_central"/>
					<input type="hidden" name="controlador" id="controlador" value="ControladorClasse"/>
					<input type="hidden" name="funcao" id="funcao" value="incluirClasse"/>
					<input type="hidden" name="mensagem" id="mensagem" value="1"/>
					<div class="card-header d-flex">
			            <h4 class="card-header-title">Cadatro de Classe</h4>
			            <div class="toolbar ml-auto">
			            	<a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarClasse" controlador="ControladorClasse" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
			            	<a href="#" onclick="fncFormCadastro(this)" class="btn btn-primary btn-sm formCadastro">Cadastrar</a>
			            </div>
		            </div>
					<div class="card-body">				
						<div class="form-group">
							<label for="nome" class="col-form-label">Nome *</label>
							<input id="nome" name="nome" type="text" class="form-control mgs_alerta" onkeyup="this.value=this.value.toUpperCase();" >
						</div>
						<div class="form-group">
							<label for="nome" class="col-form-label">Controlador *</label>
							<input id="controlador_" name="controlador_" type="text" class="form-control mgs_alerta" >
						</div>
						<div class="form-group">
							<label for="nome" class="col-form-label">Função *</label>
							<input id="funcao_" name="funcao_" type="text" class="form-control mgs_alerta" >
						</div>
						<div class="form-group">
							<label for="pais">Módulo *</label>
							<select id="modulo" name="modulo"  class="mgs_alerta form-control">
							<?php 
							try {
								$controladorModulo = new ControladorModulo();
								$objModulo = $controladorModulo->listarModulo();
							} catch (Exception $e) { echo 'erro no listarModulo'; }
							?>
								<option value="">Selecione...</option>
							<?php 
							 foreach ($objModulo as $catModulo){
							?>
								<option value="<?php echo $catModulo->getId()?>"><?php echo $catModulo->getNome();?></option>
							<?php                                  	
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
	
	
	public function telaListarClasse($objClasse){
        ?>
		<script type="text/javascript">
				$('.tablesorter').dataTable({
					"sPaginationType": "full_numbers"
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
		            <h4 class="card-header-title">Classes</h4>
		            <div class="toolbar ml-auto">
		            	<a href="#" onclick="fncButtonCadastro(this)" funcao="telaCadastrarClasse" controlador="ControladorClasse" retorno="div_central" class="btn btn-primary btn-sm buttonCadastro">Novo</a>
		            </div>
		        </div>	
				<div class="card-body">
					<div class="table-responsive">
						<table id="example" class="tablesorter table table-striped table-bordered second" style="width:100%">
							<thead>
								<tr>
									<th>Código</th> 
									<th>Descri&ccedil;&atilde;o</th> 
									<th>Controlador</th> 
									<th>Fun&ccedil;&atilde;o</th> 
		                            <th>Modulo</th> 							
									<th class="sorting_disabled" style="text-align: center;" >A&ccedil;&atilde;o</th> 
								</tr>
							</thead>
							<tbody>
							<?php 
								if($objClasse){
									foreach ($objClasse as $classe){
							?>    
								<tr> 
									<td onclick="getId(this)"  class="getId" style="cursor:pointer"  id="<?php echo $classe->getId(); ?>" funcao="telaVisualizarClasse" controlador="ControladorClasse" retorno="div_central"><?php echo str_pad($classe->getId(), 5, "0", STR_PAD_LEFT); ?></td> 
									<td onclick="getId(this)"  class="getId" style="cursor:pointer"  id="<?php echo $classe->getId(); ?>" funcao="telaVisualizarClasse" controlador="ControladorClasse" retorno="div_central"><?php echo $classe->getNome(); ?></td> 
									<td onclick="getId(this)"  class="getId" style="cursor:pointer"  id="<?php echo $classe->getId(); ?>" funcao="telaVisualizarClasse" controlador="ControladorClasse" retorno="div_central"><?php echo ($classe->getControlador())?$classe->getControlador():"-";?></td> 
									<td onclick="getId(this)"  class="getId" style="cursor:pointer"  id="<?php echo $classe->getId(); ?>" funcao="telaVisualizarClasse" controlador="ControladorClasse" retorno="div_central"><?php echo ($classe->getFuncao())?$classe->getFuncao():"-";?></td> 
									<td onclick="getId(this)"  class="getId" style="cursor:pointer"  id="<?php echo $classe->getId(); ?>" funcao="telaVisualizarClasse" controlador="ControladorClasse" retorno="div_central"><?php echo ($classe->getModulo())?$classe->getModulo()->getNome():"-";?></td> 
									<td style="text-align:center">
										<div class="btn-group ml-auto">
				                            <button onclick="getId(this)" id="<?php echo $classe->getId(); ?>" funcao="telaAlterarClasse" controlador="ControladorClasse" retorno="div_central" class="getId btn btn-sm btn-outline-light"><i class="far fa-edit"></i></button>
			                                <button onclick="fcnModalDeleteId(this)" modal="question" id="<?php echo $classe->getId(); ?>" funcao="excluirClasse" controlador="ControladorClasse" retorno="div_central" mensagem="4" class="deleteId btn btn-sm btn-outline-light"><i class="far fa-trash-alt"></i></button> 
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
		
	
	public function telaAlterarClasse($objClasse){
		?>
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">		
        <form action="#" method="post" id="formCadastro" class="">
			<input type="hidden" name="retorno" id="retorno" value="div_central"/>
			<input type="hidden" name="controlador" id="controlador" value="ControladorClasse"/>
			<input type="hidden" name="funcao" id="funcao" value="alterarClasse"/>
			<input type="hidden" name="mensagem" id="mensagem" value="2"/>
			<input type="hidden" name="id" id="id" value="<?php echo $objClasse[0]->getId();?>"/>	
			<div class="card-header d-flex">
	            <h4 class="card-header-title">Cadatro de Classe</h4>
	            <div class="toolbar ml-auto">
	            	<a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarClasse" controlador="ControladorClasse" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
	            	<a href="#" onclick="fncFormCadastro(this)" class="btn btn-primary btn-sm formCadastro">Alterar</a>
	            </div>
            </div>
			<div class="card-body">				
				<div class="form-group">
					<label for="nome" class="col-form-label">Nome *</label>
					<input id="nome" name="nome" type="text" value="<?php echo $objClasse[0]->getNome();?>" class="form-control mgs_alerta" onkeyup="this.value=this.value.toUpperCase();">
				</div>
				<div class="form-group">
					<label for="nome" class="col-form-label">Controlador *</label>
					<input id="controlador_" name="controlador_" value="<?php echo $objClasse[0]->getControlador();?>" type="text" class="form-control mgs_alerta" >
				</div>
				<div class="form-group">
					<label for="nome" class="col-form-label">Função *</label>
					<input id="funcao_" name="funcao_" type="text" value="<?php echo $objClasse[0]->getFuncao();?>" class="form-control mgs_alerta" >
				</div>
				<div class="form-group">
					<label for="pais">Módulo *</label>
					<select id="modulo" name="modulo"  class="mgs_alerta form-control">
					<?php 
					try {
						$controladorModulo = new ControladorModulo();
						$objModulo = $controladorModulo->listarModulo();
					} catch (Exception $e) {
					}
					?>
						<option value="">Selecione...</option>
					<?php 
					foreach ($objModulo as $catModulo){
						if($catModulo->getId() == $objClasse[0]->getModulo()->getId()){
							?><option value="<?php echo $catModulo->getId()?>" selected="selected"><?php echo $catModulo->getNome();?></option><?php 
						}else{
							?><option value="<?php echo $catModulo->getId()?>"><?php echo $catModulo->getNome();?></option><?php                                  	
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
	
	
	public function telaVisualizarClasse($objClasse){
		$campo = $this->criarCampo ( 'modulo', 'modulo', $this::LISTAGEM, ViewBase::VERDADEIRO, ViewBase::FALSO, 'nome' );
		$campo->setControlador('ControladorModulo');
		$campo->setFuncao('listarModulo');

		$campos = array (
				$this->criarCampo ( 'nome', 'nome', $this::TEXT, ViewBase::VERDADEIRO, ViewBase::VERDADEIRO ),
				$this->criarCampo ( 'controlador', 'controlador_', $this::TEXT,ViewBase::VERDADEIRO, ViewBase::FALSO, 'controlador' ),
				$this->criarCampo ( 'funcao', 'funcao_', $this::TEXT, ViewBase::VERDADEIRO, ViewBase::FALSO, 'funcao' ), 
				$campo );		
				
		$tela = $this->criarTela ( null, null, null, null,
				$this->montarBtnVoltar($this::CONTROLADOR, $this::TELA_LISTAR), $this->montarBotaoAcao($this::ALTERAR),
				'Visualizar Classe', $campos );
	
		return $this->criarTelaManter ( $tela, $post, ViewBase::VERDADEIRO, $objClasse[0], $objClasse[0]->getModulo()->getId());
	}
	
}


?>