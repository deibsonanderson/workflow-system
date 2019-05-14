<?php

class ViewFluxo {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }

    public function telaCadastrarFluxo($post) {
        ?>
        <script type="text/javascript">
        <?php
            echo ($post) ? "$.growlUI2('" . $post . "', '&nbsp;');" : "";
        ?>
             $(function() {
                 $("#sortable").sortable({opacity: 0.6, cursor: 'move', update: function() {}});
                 $("#sortable").disableSelection();
            });
        </script>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">                
		        <form action="#" method="post" id="formCadastro" class="">
		            <input type="hidden" name="retorno" id="retorno" value="div_central"/>
		            <input type="hidden" name="controlador" id="controlador" value="ControladorFluxo"/>
		            <input type="hidden" name="funcao" id="funcao" value="incluirFluxo"/>
		            <input type="hidden" name="mensagem" id="mensagem" value="1"/>
					<div class="card-header d-flex">
			            <h4 class="card-header-title">Cadatro de Fluxo</h4>
			            <div class="toolbar ml-auto">
			            	<a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarFluxo" controlador="ControladorFluxo" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
			            	<a href="#" onclick="fncFormCadastro(this)" class="btn btn-primary btn-sm formCadastro">Cadastrar</a>
			            </div>
		            </div>
					<div class="card-body">				
						<div class="form-group">
							<label for="nome" class="col-form-label">Título *</label>
							<input id="titulo" name="titulo" type="text" class="form-control mgs_alerta" onkeyup="this.value=this.value.toUpperCase();">
						</div>
						<div class="form-group">
							<label for="descricao">Descrição</label>
							<textarea class="form-control" id="descricao" rows="3"></textarea>
						</div>
						<div class="form-group">
							<label for="pais">Categoria *</label>
							<select id="categoria" name="categoria"  class="form-control" 
							onchange="getIdSelec(this)" 
							funcao="montarCheckAtividade" 
							controlador="ControladorFluxo" 
							retorno="sortable">
							<?php 
							try {
								$controladorCategoriaAtividade = new ControladorCategoriaAtividade();
								$objCategoriaAtividade = $controladorCategoriaAtividade->listarCategoriaAtividade();
							} catch (Exception $e) { echo 'erro no listarCategoriaAtividade'; }
							?>
								<option value="">Selecione...</option>
							<?php 
							 foreach ($objCategoriaAtividade as $catCategoriaAtividade){
							?>
								<option value="<?php echo $catCategoriaAtividade->getId()?>"><?php echo $catCategoriaAtividade->getNome();?></option>
							<?php                                  	
							 }
							 ?>                                 
							</select>
						</div>				
						<div class="form-group" >
			                <div id="sortable">
		                        <?php
		                        $controladorFluxo = new ControladorFluxo();
		                        $controladorFluxo->montarCheckAtividade(null);
		                        ?>  
			                </div>
						</div>
					</div>
				</form>
				</div>
			</div>
		</div>		
        <?php
    }

    public function telaListarFluxo($objFluxo) {
        $controladorAcao = new ControladorAcao();
        $perfil = $controladorAcao->retornaPerfilClasseAcao($_SESSION["login"],'telaListarFluxo');
        ?>
        <link rel="stylesheet" href="./assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
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
		            <h4 class="card-header-title">Fluxos</h4>
		            <div class="toolbar ml-auto">
		            	<a href="#" onclick="fncButtonCadastro(this)" funcao="telaCadastrarFluxo" controlador="ControladorFluxo" retorno="div_central" class="btn btn-primary btn-sm buttonCadastro">Novo</a>
		            </div>
		        </div>	        
				<div class="card-body">
					<div class="table-responsive">
						<table id="example" class="tablesorter table table-striped table-bordered second" style="width:100%">
							<thead>
								<tr>
		                            <th>C&oacute;digo</th>                             
		                            <th>Título</th> 
		                            <th class="sorting_disabled" style="text-align: center;" >A&ccedil;&atilde;o</th>
								</tr>
							</thead>
							<tbody>
		                        <?php
		                        if ($objFluxo) {
		                            foreach ($objFluxo as $fluxo) {
		                                ?>    
		                                <tr> 
		                                    <td onclick="getId(this)" class="getId" style="cursor:pointer"  id="<?php echo $fluxo->getId(); ?>" funcao="telaVisualizarFluxo" controlador="ControladorFluxo" retorno="div_central"><?php echo str_pad($fluxo->getId(), 5, "0", STR_PAD_LEFT); ?></td> 
		                                    <td onclick="getId(this)" class="getId" style="cursor:pointer"  id="<?php echo $fluxo->getId(); ?>" funcao="telaVisualizarFluxo" controlador="ControladorFluxo" retorno="div_central"><?php echo $fluxo->getTitulo(); ?></td> 
		                                    <td style="text-align:center">
					                          	<div class="btn-group ml-auto">
		                                        <?php
		                                        	echo ($perfil !== 'C')? '<button onclick="getId(this)" id="'.$fluxo->getId().'" funcao="telaAlterarFluxo" controlador="ControladorFluxo" retorno="div_central" class="getId btn btn-sm btn-outline-light"><i class="far fa-edit"></i></button>':'<button class="btn btn-sm" style="cursor: default;" ><i class="far fa-edit"></i></button>';
		                                            echo ($perfil === 'A')? '<button onclick="fncDeleteId(this)" modal="question" id="'.$fluxo->getId().'" funcao="excluirFluxo" controlador="ControladorFluxo" retorno="div_central" mensagem="4"  class="deleteId btn btn-sm btn-outline-light"><i class="far fa-trash-alt"></i></button>':'<button class="btn btn-sm" style="cursor: default;" ><i class="far fa-trash-alt"></i></button>'; 
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
    
    public function telaAlterarFluxo($objFluxo) {
    	?>
        <script type="text/javascript">
        <?php
            //echo ($post) ? "$.growlUI2('" . $post . "', '&nbsp;');" : "";
        ?>
 			$(function() {
                 $("#sortable").sortable({opacity: 0.6, cursor: 'move', update: function() {}});
                 $("#sortable").disableSelection();
             });
        </script>    	
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">        
		        <form action="#" method="post" id="formCadastro" class="">
					<input type="hidden" name="retorno" id="retorno" value="div_central"/>
		            <input type="hidden" name="controlador" id="controlador" value="ControladorFluxo"/>
		            <input type="hidden" name="funcao" id="funcao" value="alterarFluxo"/>
		            <input type="hidden" name="id" id="id" value="<?php echo $objFluxo[0]->getId(); ?>"/>	
		            <input type="hidden" name="mensagem" id="mensagem" value="1"/>
					<div class="card-header d-flex">
			            <h4 class="card-header-title">Atualizar de Fluxo</h4>
			            <div class="toolbar ml-auto">
			            	<a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarFluxo" controlador="ControladorFluxo" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
			            	<a href="#" onclick="fncFormCadastro(this)" class="btn btn-primary btn-sm formCadastro">Alterar</a>
			            </div>
		            </div>
					<div class="card-body">				
						<div class="form-group">
							<label for="nome" class="col-form-label">Título *</label>
							<input id="titulo" name="titulo" value="<?php echo $objFluxo[0]->getTitulo(); ?>" type="text" class="form-control mgs_alerta" onkeyup="this.value=this.value.toUpperCase();">
						</div>
						<div class="form-group">
							<label for="descricao">Descrição</label>
							<textarea class="form-control" id="descricao" rows="3"><?php echo $objFluxo[0]->getDescricao(); ?></textarea>
						</div>
						<div class="form-group">
							<label for="pais">Categoria *</label>
							<select id="categoria" name="categoria"  class="form-control" 
							onchange="getIdSelec(this,'<?php echo $objFluxo[0]->getId(); ?> ')" 
							funcao="montarCheckUpdateAtividade" 
							controlador="ControladorFluxo"
							retorno="sortable">
							<?php 
							try {
								$controladorCategoriaAtividade = new ControladorCategoriaAtividade();
								$objCategoriaAtividade = $controladorCategoriaAtividade->listarCategoriaAtividade();
							} catch (Exception $e) { echo 'erro no listarCategoriaAtividade'; }
							?>
								<option value="">Selecione...</option>
							<?php 
							 foreach ($objCategoriaAtividade as $catCategoriaAtividade){
							?>
								<option value="<?php echo $catCategoriaAtividade->getId()?>"><?php echo $catCategoriaAtividade->getNome();?></option>
							<?php                                  	
							 }
							 ?>                                 
							</select>
						</div>					
						<div class="form-group" >
			                <div id="sortable">
			                        <?php
			                        $controladorFluxo = new ControladorFluxo();
			                        $controladorFluxo->montarCheckUpdateAtividade(null, $objFluxo[0]->getId());
			                        ?>  
			                </div>
						</div>
					</div>
				</form>
				</div>
			</div>
		</div>		
        <?php
    }
    
    

    public function telaVisualizarFluxo($objFluxo) {
        ?>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">        
		        <form action="#" method="post" id="formCadastro" class="">
					<div class="card-header d-flex">
			            <h4 class="card-header-title">Visualizar Fluxo</h4>
			            <div class="toolbar ml-auto">
			            	<a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarFluxo" controlador="ControladorFluxo" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
			            </div>
		            </div>
					<div class="card-body">				
						<div class="form-group">
							<label for="nome" class="col-form-label">Título *</label>
							<input id="titulo" name="titulo" value="<?php echo $objFluxo[0]->getTitulo(); ?>" disabled type="text" class="form-control mgs_alerta" onkeyup="this.value=this.value.toUpperCase();">
						</div>
						<div class="form-group">
							<label for="descricao">Descrição</label>
							<textarea class="form-control" id="descricao" disabled rows="3"><?php echo $objFluxo[0]->getDescricao(); ?></textarea>
						</div>
						<div class="form-group">
							<?php
			                $controladorFluxo = new ControladorFluxo();
			                $listAtividades = $controladorFluxo->listarFluxoAtividades($objFluxo[0]->getId());
			                if($listAtividades){
			                    foreach ($listAtividades as $atividade){
			                    	if($atividade->getPropriedade() == '1'){
			                    		$simbolo = '';
			                    		$colorcss = 'color:#4656E9;';
			                    	}else{
			                    		$simbolo = '-';
			                    		$colorcss = 'color:#FF407B;';
			                    	}
									
									$imagem = './assets/images/avatar-1.jpg';
									if($atividade->getImagem() != null && $atividade->getImagem() != ''){
										$imagem = './imagens/atividade/'.$atividade->getImagem();
									}							
			                        ?>
				                    <div id="recordsArray_<?php echo $atividade->getId(); ?>" style="margin-bottom: 1px;">
					                    <li class="list-group-item align-items-center drag-handle">
					                        <label class="custom-control custom-checkbox">
											    <input type="checkbox" id="atividades[]" name="atividades[]" class="custom-control-input check-fluxo" value="<?php echo $atividade->getId(); ?>" <?php echo $checked; ?>>
					                            <span class="custom-control-label"><img src="<?php echo $imagem; ?>" style="width: 38px;border: 3px solid #c8c8c8;"></span>
												<span class="custom-control-label"><?php echo $atividade->getTitulo(); ?> | </span>
					                            <span class="custom-control-label" style="<?php echo $colorcss; ?>"><?php echo 'R$ '.$simbolo.valorMonetario($atividade->getValor(),'2'); ?></span>
					                    	</label>   
					                    </li>
				                    </div>                      
			                        <?php
			                    }
			                }                
			                ?>			                	
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