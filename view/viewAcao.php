<?php

class ViewAcao{
	
	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}
	
	public function telaListarAcao($objModulo,$objUsuario){
	    ?>
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">	    
		<div class="card-header d-flex">
            <h4 class="card-header-title">Perfis</h4>
            <div class="toolbar ml-auto">
            	<a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarUsuario" controlador="ControladorUsuario" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
               	<a href="#" onclick="fncFormCadastro(this)" class="btn btn-primary btn-sm formCadastro">Cadastrar</a>
            
            </div>
        </div>		
		<div class="card-body">
			<form action="#" method="post" id="formCadastro" class="">
	            <input type="hidden" name="retorno" id="retorno" value="div_central"/>
	            <input type="hidden" name="controlador" id="controlador" value="ControladorAcao"/>
	            <input type="hidden" name="funcao" id="funcao" value="incluirClasseAcao"/>
	            <input type="hidden" name="mensagem" id="mensagem" value="1"/>
				<input type="hidden" name="usuario" id="usuario" value="<?php echo $objUsuario[0]->getId(); ?>"/>
			    *&nbsp;A = Lista&nbsp;/&nbsp;Vizualiza&nbsp;/&nbsp;Altera&nbsp;/&nbsp;Inclui&nbsp;/&nbsp;Exclui.<br />
                *&nbsp;B = Lista&nbsp;/&nbsp;Vizualiza&nbsp;/&nbsp;Altera.<br />
                *&nbsp;C = Lista&nbsp;/&nbsp;Vizualiza.<br />
                *&nbsp;0 = Nenhum acesso. 
				<div class="table-responsive">
					<table id="example" class="tablesorter table table-striped table-bordered second" style="width:100%">
						<tbody>
						<?php 
                        foreach ($objModulo as $modulo){
                        ?>
                        <tr>
                            <td class="col1" colspan="2" >
                            	<label><?php echo $modulo->getNome(); ?></label>  
                            </td>
                        </tr>
                        <?php 	
                       	foreach ($modulo->getClasse() as $classe){
                        ?>
                        <tr>
                            <td class="col1" >&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $classe->getNome();?></td>
                            <td class="col2" >
                            <?php 
                            switch ($classe->getAcao()->getPerfil()) {
                            	case "A":
	                           	?>
		                            <label class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" name="<?php echo $classe->getId();?>" value="<?php echo $classe->getId();?>|0" class="custom-control-input"><span class="custom-control-label">0</span>
                                    </label>
		                            <label class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" name="<?php echo $classe->getId();?>" value="<?php echo $classe->getId();?>|A" checked class="custom-control-input"><span class="custom-control-label">A</span>
                                    </label>
		                            <label class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" name="<?php echo $classe->getId();?>" value="<?php echo $classe->getId();?>|B" class="custom-control-input"><span class="custom-control-label">B</span>
                                    </label>
		                            <label class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" name="<?php echo $classe->getId();?>" value="<?php echo $classe->getId();?>|C" class="custom-control-input"><span class="custom-control-label">C</span>
                                    </label>
	                           	<?php                            		
                            	break;
                            	case "B":
	                           	?>
		                            <label class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" name="<?php echo $classe->getId();?>" value="<?php echo $classe->getId();?>|0"  class="custom-control-input"><span class="custom-control-label">0</span>
                                    </label>
		                            <label class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" name="<?php echo $classe->getId();?>" value="<?php echo $classe->getId();?>|A"  class="custom-control-input"><span class="custom-control-label">A</span>
                                    </label>
		                            <label class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" name="<?php echo $classe->getId();?>" value="<?php echo $classe->getId();?>|B" checked class="custom-control-input"><span class="custom-control-label">B</span>
                                    </label>
		                            <label class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" name="<?php echo $classe->getId();?>" value="<?php echo $classe->getId();?>|C"  class="custom-control-input"><span class="custom-control-label">C</span>
                                    </label>	                           	
                                    <?php                            		
                            	break;
                            	case "C":
	                           	?>
		                            <label class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" name="<?php echo $classe->getId();?>" value="<?php echo $classe->getId();?>|0"  class="custom-control-input"><span class="custom-control-label">0</span>
                                    </label>
		                            <label class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" name="<?php echo $classe->getId();?>" value="<?php echo $classe->getId();?>|A"  class="custom-control-input"><span class="custom-control-label">A</span>
                                    </label>
		                            <label class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" name="<?php echo $classe->getId();?>" value="<?php echo $classe->getId();?>|B"  class="custom-control-input"><span class="custom-control-label">B</span>
                                    </label>
		                            <label class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" name="<?php echo $classe->getId();?>" value="<?php echo $classe->getId();?>|C" checked class="custom-control-input"><span class="custom-control-label">C</span>
                                    </label>	                           	
                                    <?php
                            	break;
								case "0":
	                           	?>
		                            <label class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" name="<?php echo $classe->getId();?>" value="<?php echo $classe->getId();?>|0" checked class="custom-control-input"><span class="custom-control-label">0</span>
                                    </label>
		                            <label class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" name="<?php echo $classe->getId();?>" value="<?php echo $classe->getId();?>|A" class="custom-control-input"><span class="custom-control-label">A</span>
                                    </label>
		                            <label class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" name="<?php echo $classe->getId();?>" value="<?php echo $classe->getId();?>|B" class="custom-control-input"><span class="custom-control-label">B</span>
                                    </label>
		                            <label class="custom-control custom-radio custom-control-inline">
                                    	<input type="radio" name="<?php echo $classe->getId();?>" value="<?php echo $classe->getId();?>|C"  class="custom-control-input"><span class="custom-control-label">C</span>
                                    </label>	                           	
                                    <?php
                            	break;
                            }
                            
                            ?>
                            </td>
                        </tr>
                        <?php 
                        	}
                         }	
                        ?>
						</tbody>
					</table>
				</div>
			</form>
		</div>
		</div>
	</div>
</div>		    
	<?php
	} 
	
}


?>