<?php

class ViewModulo {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }

    public function telaCadastrarModulo($post) {
        ?>
        <script type="text/javascript">
        <?php
        echo ($post) ? "$.growlUI2('" . $post . "', '&nbsp;');" : "";
        ?>			        
        </script>
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">        
        <form action="#" method="post" id="formCadastro" class="">
            <input type="hidden" name="retorno" id="retorno" value="div_central"/>
            <input type="hidden" name="controlador" id="controlador" value="ControladorModulo"/>
            <input type="hidden" name="funcao" id="funcao" value="incluirModulo"/>
            <input type="hidden" name="mensagem" id="mensagem" value="1"/>
			<div class="card-header d-flex">
	            <h4 class="card-header-title">Cadatro Módulos</h4>
	            <div class="toolbar ml-auto">
	            	<a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarModulo" controlador="ControladorModulo" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
	            	<a href="#" onclick="fncFormCadastro(this)" class="btn btn-primary btn-sm formCadastro">Cadastrar</a>
	            </div>
            </div>
			<div class="card-body">				
				<div class="form-group">
					<label for="nome" class="col-form-label">Nome *</label>
					<input id="nome" name="nome" type="text" class="form-control mgs_alerta" onkeyup="this.value=this.value.toUpperCase();">
				</div>
			</div>
		</form>
		</div>
	</div>
</div>		
        <?php
    }

    public function telaListarModulo($objModulo) {
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
            <h4 class="card-header-title">Módulos</h4>
            <div class="toolbar ml-auto">
            	<a href="#" onclick="fncButtonCadastro(this)" funcao="telaCadastrarModulo" controlador="ControladorModulo" retorno="div_central" class="btn btn-primary btn-sm buttonCadastro">Novo</a>
            </div>
        </div>		
		<div class="card-body">
			<div class="table-responsive">
				<table id="example" class="tablesorter table table-striped table-bordered second" style="width:100%">
					<thead>
						<tr>
							<th>Codigo</th>
							<th>Nome</th>
							<th class="sorting_disabled" style="text-align: center;" >A&ccedil;&atilde;o</th> 
						</tr>
					</thead>
					<tbody>
					<?php 
                    if ($objModulo) {
                        foreach ($objModulo as $modulo) {
                    ?>    
						<tr>
							<td onclick="getId(this)"  class="getId" style="cursor:pointer"  id="<?php echo $modulo->getId(); ?>" funcao="telaVisualizarModulo" controlador="ControladorModulo" retorno="div_central"><?php echo str_pad($modulo->getId(), 5, "0", STR_PAD_LEFT); ?></td> 
                            <td onclick="getId(this)"  class="getId" style="cursor:pointer"  id="<?php echo $modulo->getId(); ?>" funcao="telaVisualizarModulo" controlador="ControladorModulo" retorno="div_central"><?php echo $modulo->getNome(); ?></td> 
                            <td style="text-align:center">
                            	<div class="btn-group ml-auto">
		                            <button onclick="getId(this)" id="<?php echo $modulo->getId(); ?>" funcao="telaAlterarModulo" controlador="ControladorModulo" retorno="div_central" class="getId btn btn-sm btn-outline-light"><i class="far fa-edit"></i></button>
	                                <button onclick="fcnModalDeleteId(this)" modal="question" id="<?php echo $modulo->getId(); ?>" funcao="excluirModulo" controlador="ControladorModulo" retorno="div_central" mensagem="4" class="deleteId btn btn-sm btn-outline-light"><i class="far fa-trash-alt"></i></button> 
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

    public function telaAlterarModulo($objModulo) {
        ?>
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">        
        <form action="#" method="post" id="formCadastro" class="">
            <input type="hidden" name="retorno" id="retorno" value="div_central"/>
            <input type="hidden" name="controlador" id="controlador" value="ControladorModulo"/>
            <input type="hidden" name="funcao" id="funcao" value="alterarModulo"/>
            <input type="hidden" name="mensagem" id="mensagem" value="2"/>
            <input type="hidden" name="id" id="id" value="<?php echo $objModulo[0]->getId(); ?>"/>
			<div class="card-header d-flex">
	            <h4 class="card-header-title">Alterar Módulos</h4>
	            <div class="toolbar ml-auto">
	            	<a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarModulo" controlador="ControladorModulo" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
	            	<a href="#" onclick="fncFormCadastro(this)" class="btn btn-primary btn-sm formCadastro">Alterar</a>
	            </div>
            </div>
			<div class="card-body">				
				<div class="form-group">
					<label for="nome" class="col-form-label">Nome *</label>
				    <input type="text" id="nome" name="nome" value="<?php echo $objModulo[0]->getNome(); ?>" class="form-control mgs_alerta" onkeyup="this.value=this.value.toUpperCase();">
				</div>
			</div>
		</form>        
		</div>
	</div>
</div>		
        <?php
    }

    public function telaVisualizarModulo($objModulo) {
        ?>
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">        
        <form action="#" method="post" id="formCadastro" class="">
            <input type="hidden" name="retorno" id="retorno" value="div_central"/>
            <input type="hidden" name="controlador" id="controlador" value="ControladorModulo"/>
            <input type="hidden" name="funcao" id="funcao" value="alterarModulo"/>
            <input type="hidden" name="mensagem" id="mensagem" value="2"/>
			<div class="card-header d-flex">
	            <h4 class="card-header-title">Visualizar Módulos</h4>
	            <div class="toolbar ml-auto">
	            	<a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarModulo" controlador="ControladorModulo" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
	            </div>
            </div>
			<div class="card-body">				
				<div class="form-group">
					<label for="nome" class="col-form-label">Nome *</label>
				    <input type="text" id="nome" name="nome" value="<?php echo $objModulo[0]->getNome(); ?>" class="form-control mgs_alerta" disabled="disabled" onkeyup="this.value=this.value.toUpperCase();">
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