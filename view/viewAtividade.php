<?php

class ViewAtividade {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }

    public function telaCadastrarAtividade($post) {
    	?>
        <script type="text/javascript">
        <?php
        echo ($post) ? "$.growlUI2('" . $post . "', '&nbsp;');" : "";
        ?>
        $('.money').mask('000.000.000.000.000,00', {reverse: true});
        </script>
        <script src="./assets/main/js/popup-upload.js" type="text/javascript"></script>
        <script src="./assets/main/js/jquery.form.js" type="text/javascript" ></script>
        <script type="text/javascript" >
            $(document).ready(function() {
                fncInserirArquivo("form_arquivo", "progress_arquivo", "porcentagem_arquivo", "arquivo", "arquivoAtual", "./arquivos/atividade/", "arquivo");
                fncInserirArquivo("form_imagem", "progress", "porcentagem", "imagem", "imagemAtual", "./imagens/atividade/", "imagem");
            });
        </script>
<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">        
		        
				<div class="card-header d-flex">
		            <h4 class="card-header-title">Cadatro de Atividade</h4>
		            <div class="toolbar ml-auto">
			            <a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarAtividade" controlador="ControladorAtividade" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
			            <a href="#" onclick="fncFormCadastro(this)" class="btn btn-primary btn-sm formCadastro">Cadastrar</a>            	
		            </div>
		        </div>	
				<div class="card-body">	
		        	<form action="#" method="post" id="formCadastro" class="">
			            <input type="hidden" name="retorno" id="retorno" value="div_central"/>
			            <input type="hidden" name="controlador" id="controlador" value="ControladorAtividade"/>
			            <input type="hidden" name="funcao" id="funcao" value="incluirAtividade"/>
			            <input type="hidden" name="mensagem" id="mensagem" value="1"/>
			            <input type="hidden" name="arquivo" id="arquivo" value="" />    
			            <input type="hidden" name="imagem" id="imagem" value="" />  						
						<div class="form-group">
							<label for="titulo" class="col-form-label">Nome *</label>
							<input id="titulo" name="titulo" type="text" class="form-control mgs_alerta" >
						</div>
						<div class="form-group">
							<label for="descricao">Descrição</label>
							<textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
						</div>
						<div class="form-group">
							<label for="link" class="col-form-label">Link</label>
							<input id="link" name="link" type="text" class="form-control" onkeyup="this.value=this.value.toLowerCase();">
						</div>
						<div class="form-group">
							<label for="vencimento" class="col-form-label">Dia do Vencimento</label>
							<select id="vencimento" name="vencimento" class="form-control">
							<option value="">Selecione...</option>
							<?php 
								for($i = 1; $i <=31; $i++){
									echo "<option value='$i' >Dia $i</option>";
								}
							?>
							</select>
						</div>								
						<div class="form-group">
							<label for="valor" class="col-form-label">Valor R$</label>
							<input id="valor" name="valor" type="text" value="0,00" class="form-control money" >
						</div>
						<div class="form-group">
							<label for="propriedade">Propriedade</label>
							<select id="propriedade" name="propriedade"  class="mgs_alerta form-control" >
								<option value="1"  >Prositivo</option>
		                        <option value="0" selected="selected" >Negativo</option>
		        			</select>
						</div>
						<div class="form-group">
							<label for="pais">Categoria *</label>
							<select id="categoria" name="categoria" class="mgs_alerta form-control">
							<?php 
							try {
								$controladorCategoriaAtividade = new ControladorCategoriaAtividade();
								$objCategoriaAtividade = $controladorCategoriaAtividade->listarCategoriaAtividade();
							} catch (Exception $e) { echo 'erro no listarCategoriaAtividade '; }
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
					</form>				
					<div class="form-group">
		                <table border="0" style="width: 100%">
		                    <tr>
		                        <td colspan="3">
		                            <label>Imagem Largura Máxima: 640px</label>&nbsp;&nbsp; 
		                        </td>
		                    </tr>
		                    <tr style="height: 110px;">
		                        <td style="width: 20%;text-align: right;">
		                            <span id="span-teste" class="upload-wrapper" >  
		                                <form action="./post-imagem.php" method="post" id="form_imagem">
		                                    <input name="pastaArquivo" type="hidden" value="./imagens/atividade/">
		                                    <input name="largura" type="hidden" value="128">
		                                    <input name="opcao" type="hidden" value="1">
		                                    <input name="tipoArq" type="hidden" value="imagem">
		                                    <input type="file" name="file" class="upload-file" style="width: 30px;" onchange="javascript: fncSubmitArquivo('enviar', this);" >
		                                    <input type="submit" id="enviar" style="display:none;">   
		                                    <img src="./assets/images/img_upload.png" class="upload-button" />
		                                </form> 
		                            </span>
		                        </td>
		                        <td style="width: 20%">
		                            <img onclick="fncRemoverArquivo('imagem', './imagens/atividade', 'imagem', 'imagemAtual', './assets/images/imagemPadrao.jpg');" src="./assets/images/remove.png" border="0" title="Clique para remover" style="cursor:pointer;margin-bottom:7px;" class="upload-button" />
		                        </td>
		                        <td style="width: 60%">
		                            <img id="imagemAtual" name="imagemAtual" src="./assets/images/imagemPadrao.jpg" border="0" style="" />
		                            <progress id="progress" value="0" max="100" style="display:none;"></progress>
		                            <span id="porcentagem" style="display:none;">0%</span>                            
		                        </td>
		                    </tr>
		                </table>
					</div>				
					<div class="form-group">
		                <table border="0" style="width: 100%">
		                    <tr>
		                        <td colspan="3">
		                            <label>Tamanho Máxima: 2 Megas.</label>&nbsp;&nbsp; 
		                        </td>
		                    </tr>
		                    <tr style="height: 110px;">
		                        <td style="width: 20%;text-align: right;">
		                            <span id="span-teste" class="upload-wrapper" >                                                        
		                                <form action="./post-imagem.php" method="post" id="form_arquivo">
		                                    <input name="pastaArquivo" type="hidden" value="./arquivos/atividade/">
		                                    <input name="largura" type="hidden" value="640">
		                                    <input name="opcao" type="hidden" value="1">
		                                    <input name="tipoArq" type="hidden" value="arquivo">
		                                    <input type="file" name="file" class="upload-file" style="width: 30px;"  onchange="javascript: fncSubmitArquivo('enviar_arquivo', this);" >
		                                    <input type="submit" id="enviar_arquivo" style="display:none;">
		                                    <img src="./assets/images/img_upload.png" class="upload-button" />
		                                </form>
		                            </span>
		                        </td>
		                        <td style="width: 20%">
		                            <img onclick="fncRemoverArquivo('arquivo', './arquivos/atividade/', 'arquivo', 'arquivoAtual', '');" src="./assets/images/remove.png" border="0" title="Clique para remover" style="cursor:pointer;margin-bottom:7px;" class="upload-button" />
		                        </td>
		                        <td style="width: 60%;">
		                            <span name="arquivoAtual" id="arquivoAtual" onClick="fnAbreArquivo('arquivo', './arquivos/atividade/')"   ><br />Adicione um arquivo clicando no <img src="./assets/images/img_upload.png" border="0" style="float:none;margin:0;width: 20px;" /></span>
		                            <progress id="progress_arquivo" value="0" max="100" style="display:none;"></progress>
		                            <span id="porcentagem_arquivo" style="display:none;">0%</span>
		                        </td>
		                    </tr>
		                </table>				
					</div>
				</div>
				</div>
			</div>
</div>		        	
        <?php
    }

    public function telaListarAtividade($objAtividade, $pagina) {
    	$controladorAcao = new ControladorAcao();
        $perfil = $controladorAcao->retornaPerfilClasseAcao($_SESSION["login"], 'telaListarAtividade');
        ?>
        <script type="text/javascript">
            $('.tablesorter').dataTable({
				"sPaginationType": "full_numbers"
                /*"paging":   false,
                "ordering": false,
                "info":     false,
                "searching": false*/
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
			            <h4 class="card-header-title">Atividade</h4>
			        	<?php
			            if ($perfil === 'A') {
			            ?>
			            <div class="toolbar ml-auto">
			            	<a href="#" onclick="fncButtonCadastro(this)" funcao="telaCadastrarAtividade" controlador="ControladorAtividade" retorno="div_central" class="btn btn-primary btn-sm buttonCadastro">Novo</a>
			            </div>
			            <?php } ?>
			        </div>		
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="tablesorter table table-striped table-bordered second" style="width:100%">
								<thead>
									<tr>
			                            <th>C&oacute;digo</th> 
			                            <th>Imagem</th>
			                            <th>T&iacute;tulo</th>
			                            <th>Custo</th>  
			                            <th>Descri&ccedil;&atilde;o</th>
										<th>Vencimento</th>	
										<th>Arquivo</th>							
			                            <th class="sorting_disabled" style="text-align: center;" >A&ccedil;&atilde;o</th> 
									</tr>
								</thead>
								<tbody>
			                        <?php
			                        if ($objAtividade->retorno) {
			                        	foreach ($objAtividade->retorno as $atividade) {
			                            	if($atividade->getPropriedade() == '1'){
			                            		$simbolo = '';
			                            		$colorcss = 'color:BLUE;';
			                            	}else{
			                            		$simbolo = '-';
			                            		$colorcss = 'color:RED;';
											}
											
											$imagem = './assets/images/avatar-1.jpg';
											if($atividade->getImagem() != null && $atividade->getImagem() != ''){
												$imagem = './imagens/atividade/'.$atividade->getImagem();
											}
			                            	?>    
			                                <tr> 
			                                    <td onclick="getId(this)"  class="getId" style="cursor:pointer"  id="<?php echo $atividade->getId(); ?>" funcao="telaVisualizarAtividade" controlador="ControladorAtividade" retorno="div_central"><?php echo str_pad($atividade->getId(), 5, "0", STR_PAD_LEFT); ?></td> 
			                                    <td onclick="getId(this)"  class="getId" style="cursor:pointer;text-align: center;"  id="<?php echo $atividade->getId(); ?>" funcao="telaVisualizarAtividade" controlador="ControladorAtividade" retorno="div_central"><img src="<?php echo $imagem; ?>" style="width: 38px;"></td> 
			                                    <td onclick="getId(this)"  class="getId" style="cursor:pointer"  id="<?php echo $atividade->getId(); ?>" funcao="telaVisualizarAtividade" controlador="ControladorAtividade" retorno="div_central"><?php echo $atividade->getTitulo(); ?></td> 
			                                    <td onclick="getId(this)"  class="getId;" style="cursor:pointer;<?php echo $colorcss; ?>"  id="<?php echo $atividade->getId(); ?>" funcao="telaVisualizarAtividade" controlador="ControladorAtividade" retorno="div_central"><?php echo 'R$ '.$simbolo.valorMonetario($atividade->getValor(),'2'); ?></td>
			                                    <td onclick="getId(this)"  class="getId" style="cursor:pointer"  id="<?php echo $atividade->getId(); ?>" funcao="telaVisualizarAtividade" controlador="ControladorAtividade" retorno="div_central"><?php echo limitarTexto($atividade->getDescricao(), 110); ?></td> 
			                                    <td onclick="getId(this)"  class="getId" style="cursor:pointer;text-align: center; "  id="<?php echo $atividade->getId(); ?>" funcao="telaVisualizarAtividade" controlador="ControladorAtividade" retorno="div_central"><?php echo ($atividade->getVencimento() == "00" || $atividade->getVencimento() == null || $atividade->getVencimento() == "")?"-":$atividade->getVencimento(); ?></td>
											    <td style="text-align: center;">
						                        <?php
						                        	$controladorComentario = new ControladorComentarioFluxoProcesso();
						                        	echo $controladorComentario->showIconFile($atividade->getArquivo());
						                        ?>
						                        </td>
												<td style="text-align:center">
			                                        <div class="btn-group ml-auto">
				                                        <?php
				                                        echo ($perfil !== 'C')? '<button onclick="getId(this)" id="'.$atividade->getId().'" funcao="telaAlterarAtividade" controlador="ControladorAtividade" retorno="div_central" class="getId btn btn-sm btn-outline-light"><i class="far fa-edit"></i></button>':'<button class="btn btn-sm" style="cursor: default;" ><i class="far fa-edit"></i></button>';
				                                        echo ($perfil === 'A')? '<button onclick="fcnModalDeleteId(this)" modal="question" id="'.$atividade->getId().'" funcao="excluirAtividade" controlador="ControladorAtividade" retorno="div_central" mensagem="4"  class="deleteId btn btn-sm btn-outline-light"><i class="far fa-trash-alt"></i></button>':'<button class="btn btn-sm" style="cursor: default;" ><i class="far fa-trash-alt"></i></button>'; 
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
						<!--div class="row justify-content-md-center ">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
								<?php //echo paginacao($pagina, $objAtividade->numPaginas, 'telaListarAtividade', 'ControladorAtividade', 'div_central'); ?>
							</div>							
						</div-->
					</div>
				</div>
			</div>
</div>		
    <?php
    }

    public function telaAlterarAtividade($objAtividade) {
    	?>
        <script src="./assets/main/js/popup-upload.js" type="text/javascript"></script>
        <script src="./assets/main/js/jquery.form.js" type="text/javascript" ></script>
        <script type="text/javascript" >
            $(document).ready(function() {
                fncInserirArquivo("form_arquivo", "progress_arquivo", "porcentagem_arquivo", "arquivo", "arquivoAtual", "./arquivos/atividade/", "arquivo");
                fncInserirArquivo("form_imagem", "progress", "porcentagem", "imagem", "imagemAtual", "./imagens/atividade/", "imagem");
            });
            $('.money').mask('000.000.000.000.000,00', {reverse: true}); 
        </script>
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">        
		<div class="card-header d-flex">
            <h4 class="card-header-title">Alterar Atividade</h4>
            <div class="toolbar ml-auto">
	            <a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarAtividade" controlador="ControladorAtividade" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
	            <a href="#" onclick="fncFormCadastro(this)" class="btn btn-primary btn-sm formCadastro">Alterar</a>            	
            </div>
        </div>	
		<div class="card-body">	
			<form action="#" method="post" id="formCadastro" class="">
                <input type="hidden" name="retorno" id="retorno" value="div_central"/>
                <input type="hidden" name="controlador" id="controlador" value="ControladorAtividade"/>
                <input type="hidden" name="funcao" id="funcao" value="alterarAtividade"/>
                <input type="hidden" name="mensagem" id="mensagem" value="2"/>
                <input type="hidden" name="arquivo" id="arquivo" value="<?php echo $objAtividade[0]->getArquivo(); ?>" />    
                <input type="hidden" name="imagem" id="imagem" value="<?php echo $objAtividade[0]->getImagem(); ?>" />
                <input type="hidden" name="id" id="id" value="<?php echo $objAtividade[0]->getId(); ?>"/>	 						
				<div class="form-group">
					<label for="nome" class="col-form-label">Nome *</label>
					<input id="titulo" name="titulo" type="text" value="<?php echo $objAtividade[0]->getTitulo(); ?>" class="form-control mgs_alerta">
				</div>
				<div class="form-group">
					<label for="descricao">Descrição</label>
					<textarea class="form-control" name="descricao" id="descricao" rows="3"><?php echo $objAtividade[0]->getDescricao(); ?></textarea>
				</div>
				<div class="form-group">
					<label for="link" class="col-form-label">Link</label>
					<input id="link" name="link" type="text" class="form-control" value="<?php echo $objAtividade[0]->getLink(); ?>" onkeyup="this.value=this.value.toLowerCase();">
				</div>
				
				<div class="form-group">
					<label for="vencimento" class="col-form-label">Dia do Vencimento</label>
					<select id="vencimento" name="vencimento" class="form-control">
					<option value="">Selecione...</option>
					<?php 
						for($i = 1; $i <=31; $i++){
							$select = ($objAtividade[0]->getVencimento() == $i)?'selected="selected"':'';
							echo "<option value='".$i."' ".$select." >".$i."</option>";
						}
					?>
					</select>
				</div>					
				
				<div class="form-group">
					<label for="valor" class="col-form-label">Valor R$</label>
					<input id="valor" name="valor" value="<?php echo $objAtividade[0]->getValor(); ?>" type="text" class="form-control money" >
				</div>
				<div class="form-group">
					<label for="propriedade">Propriedade</label>
					<select id="propriedade" name="propriedade"  class="mgs_alerta form-control" >
                        <?php
                        if ($objAtividade[0]->getPropriedade() == 1) {
                            $selected_1 = 'selected="selected" ';
                            $selected_2 = '';
                        } else {
                            $selected_1 = '';
                            $selected_2 = ' selected="selected"';
                        }
                        ?>
                        <option value="1" <?php echo $selected_1; ?> >Prositivo</option>
                        <option value="0" <?php echo $selected_2; ?> >Negativo</option>
        			</select>	
				</div>
				<div class="form-group">
					<label for="pais">Categoria *</label>
					<select id="categoria" name="categoria" class="mgs_alerta form-control">
					<?php 
					try {
						$controladorCategoriaAtividade = new ControladorCategoriaAtividade();
						$objCategoriaAtividade = $controladorCategoriaAtividade->listarCategoriaAtividade();
					} catch (Exception $e) { echo 'erro no listarCategoriaAtividade'; }
					?>
						<option value="">Selecione...</option>
					<?php 
					foreach ($objCategoriaAtividade as $catCategoriaAtividade){
						if($catCategoriaAtividade->getId() == $objAtividade[0]->getCategoria()->getId()){
							?><option value="<?php echo $catCategoriaAtividade->getId()?>" selected="selected"><?php echo $catCategoriaAtividade->getNome();?></option><?php 
						}else{
							?><option value="<?php echo $catCategoriaAtividade->getId()?>"><?php echo $catCategoriaAtividade->getNome();?></option><?php                                  	
						}
					 }
					 ?>                                 
					</select>
				</div>					
								
			</form>				
			<div class="form-group">
                <?php
                if ($objAtividade[0]->getImagem()) {
                    $imagem = "./imagens/atividade/thumbnail" . $objAtividade[0]->getImagem();
                } else {
                    $imagem = "./assets/images/imagemPadrao.jpg";
                }
                ?>	 
                <table border="0" style="width: 100%">
                    <tr>
                        <td colspan="3">
                            <label>Imagem Largura Máxima: 640px</label>&nbsp;&nbsp; 
                        </td>
                    </tr>
                    <tr style="height: 110px;">
                        <td style="width: 20%;text-align: right;">
                            <span id="span-teste" class="upload-wrapper" >  
                                <form action="./post-imagem.php" method="post" id="form_imagem">
                                    <input name="pastaArquivo" type="hidden" value="./imagens/atividade/">
                                    <input name="largura" type="hidden" value="128">
                                    <input name="opcao" type="hidden" value="1">
                                    <input name="tipoArq" type="hidden" value="imagem">
                                    <input type="file" name="file" class="upload-file" style="width: 30px;"  onchange="javascript: fncSubmitArquivo('enviar', this);" >
                                    <input type="submit" id="enviar" style="display:none;">   
                                    <img src="./assets/images/img_upload.png" class="upload-button" />
                                </form> 
                            </span>
                        </td>
                        <td style="width: 20%">
                            <img onclick="fncRemoverArquivo('imagem', './imagens/atividade', 'imagem', 'imagemAtual', './assets/images/imagemPadrao.jpg');" src="./assets/images/remove.png" border="0" title="Clique para remover" style="cursor:pointer;margin-bottom:7px;" class="upload-button" />
                        </td>
                        <td style="width: 60%">
                            <img id="imagemAtual" name="imagemAtual" src="<?php echo $imagem; ?>" border="0" style="" />
                            <progress id="progress" value="0" max="100" style="display:none;"></progress>
                            <span id="porcentagem" style="display:none;">0%</span>                            
	                        </td>
	                    </tr>
	                </table>
				</div>				
				<div class="form-group">
                <table border="0" style="width: 100%">
                    <tr>
                        <td colspan="3">
                            <label>Tamanho Máxima: 2 Megas.</label>&nbsp;&nbsp; 
                        </td>
                    </tr>
                    <tr style="height: 110px;">
                        <td style="width: 20%;text-align: right;">
                            <span id="span-teste" class="upload-wrapper" >                                                        
                                <form action="./post-imagem.php" method="post" id="form_arquivo">
                                    <input name="pastaArquivo" type="hidden" value="./arquivos/atividade/">
                                    <input name="largura" type="hidden" value="640">
                                    <input name="opcao" type="hidden" value="1">
                                    <input name="tipoArq" type="hidden" value="arquivo">
                                    <input type="file" name="file" class="upload-file" style="width: 30px;" onchange="javascript: fncSubmitArquivo('enviar_arquivo', this);" >
                                    <input type="submit" id="enviar_arquivo" style="display:none;">
                                    <img src="./assets/images/img_upload.png" class="upload-button" />
                                </form>
                            </span>
                        </td>
                        <td style="width: 20%">
                            <img onclick="fncRemoverArquivo('arquivo', './arquivos/atividade/', 'arquivo', 'arquivoAtual', '');" src="./assets/images/remove.png" border="0" title="Clique para remover" style="cursor: pointer;margin-bottom:7px;" class="upload-button" />
                        </td>
                        <td style="width: 60%">
                            <span name="arquivoAtual" id="arquivoAtual" onClick="fnAbreArquivo('arquivo', './arquivos/atividade/')" style="<?php echo ($objAtividade[0]->getArquivo()) ? 'cursor: pointer;text-decoration: underline;' : '' ?>"  >
                                <?php
                                if ($objAtividade[0]->getArquivo()) {
                                    echo $objAtividade[0]->getArquivo();
                                } else {
                                    ?><br />Adicione um arquivo clicando no <img src="./assets/images/img_upload.png" border="0" style="float:none;margin:0;width: 20px;" /><?php
                                }
                                ?> 
                            </span>
                            <progress id="progress_arquivo" value="0" max="100" style="display:none;"></progress>
                            <span id="porcentagem_arquivo" style="display:none;">0%</span>	                            
                        </td>
                    </tr>
                </table>			
			</div>
		</div>        
		</div>
	</div>
</div>             
        <?php
    }

    public function telaVisualizarAtividade($objAtividade) {
        ?>
        <script type="text/javascript" >
            $('.money').mask('000.000.000.000.000,00', {reverse: true}); 
        </script>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">        
				<div class="card-header d-flex">
		            <h4 class="card-header-title">Visualizar Atividade</h4>
		            <div class="toolbar ml-auto">
			            <a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarAtividade" controlador="ControladorAtividade" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
			        </div>
		        </div>	              
				<div class="card-body">	
		        	<form action="#" method="post" id="formCadastro" class="">
		                <input type="hidden" name="arquivo" id="arquivo" value="<?php echo $objAtividade[0]->getArquivo(); ?>" />    
		                <input type="hidden" name="imagem" id="imagem" value="<?php echo $objAtividade[0]->getImagem(); ?>" />
						<div class="form-group">
							<label for="nome" class="col-form-label">Nome *</label>
							<input id="titulo" name="titulo" type="text" disabled="disabled" value="<?php echo $objAtividade[0]->getTitulo(); ?>" class="form-control mgs_alerta" onkeyup="this.value=this.value.toUpperCase();">
						</div>
						<div class="form-group">
							<label for="descricao">Descrição</label>
							<textarea class="form-control" id="descricao" disabled="disabled" rows="3"><?php echo $objAtividade[0]->getDescricao(); ?></textarea>
						</div>
						<div class="form-group">
							<label for="link" class="col-form-label">Link</label>
							<input id="link" type="text" class="form-control" disabled="disabled" value="<?php echo $objAtividade[0]->getLink(); ?>" onkeyup="this.value=this.value.toLowerCase();">
						</div>
						<div class="form-group">
							<label for="valor" class="col-form-label">Valor R$</label>
							<input id="valor" name="valor" disabled="disabled" value="<?php echo $objAtividade[0]->getValor(); ?>" type="text" class="form-control money" >
						</div>
						<div class="form-group">
							<label for="propriedade">Propriedade</label>
							<select id="propriedade" disabled="disabled" name="propriedade"  class="mgs_alerta form-control" >
		                        <?php
		                        if ($objAtividade[0]->getPropriedade() == '1') {
		                            $selected_1 = 'selected="selected"';
		                            $selected_2 = '';
		                        } else {
		                        	$selected_1 = '';
		                        	$selected_2 = 'selected="selected"';
		                        }
		                        ?>
		                        <option value="1" <?php echo $selected_1; ?> >Prositivo</option>
		                        <option value="0" <?php echo $selected_2; ?> >Negativo</option>
		        			</select>	
						</div>							
				<div class="form-group">
					<label for="pais">Categoria *</label>
					<select id="categoria" disabled="disabled" name="categoria" dis class="mgs_alerta form-control">
					<?php 
					try {
						$controladorCategoriaAtividade = new ControladorCategoriaAtividade();
						$objCategoriaAtividade = $controladorCategoriaAtividade->listarCategoriaAtividade();
					} catch (Exception $e) { echo 'erro no listarCategoriaAtividade'; }
					?>
						<option value="">Selecione...</option>
					<?php 
					foreach ($objCategoriaAtividade as $catCategoriaAtividade){
						if($catCategoriaAtividade->getId() == $objAtividade[0]->getCategoria()->getId()){
							?><option value="<?php echo $catCategoriaAtividade->getId()?>" selected="selected"><?php echo $catCategoriaAtividade->getNome();?></option><?php 
						}else{
							?><option value="<?php echo $catCategoriaAtividade->getId()?>"><?php echo $catCategoriaAtividade->getNome();?></option><?php                                  	
						}
					 }
					 ?>                                 
					</select>
				</div>							
					</form>				
					<div class="form-group">
		                <label>Imagem Largura Máxima: 640px</label>&nbsp;&nbsp;
		                <?php
		                if ($objAtividade[0]->getImagem()) {
		                    $imagem = "./imagens/atividade/thumbnail" . $objAtividade[0]->getImagem();
		                } else {
		                    $imagem = "./assets/images/imagemPadrao.jpg";
		                }
		                ?>	 
		                <span name="imagemLink" id="<?php echo $imagem; ?>" title="Imagem" >
		                    <img name="imagemAtual" src="<?php echo $imagem; ?>" border="0" />
		                </span>
					</div>				
					<div class="form-group">
		                <label>Arquivo Tamanho Máximo: 2MB</label>
		                <span name="arquivoAtual" onClick="fnAbreArquivo('arquivo', './arquivos/atividade/')" style="<?php echo ($objAtividade[0]->getArquivo()) ? 'cursor: pointer; text-decoration: underline;' : '' ?>">
		                    <?php
		                    if ($objAtividade[0]->getArquivo()) {
		                        echo $objAtividade[0]->getArquivo();
		                    } else {
		                        ?>Adicione um arquivo clicando no <img src="./assets/images/img_upload.png" border="0" style="float:none;margin:0;width: 20px;" /><?php
		                    }
		                    ?>                                                    
		                </span>		
					</div>
				</div>        
				</div>
			</div>
		</div>                   
        <?php
    }

    public function telaVisualizarAtividadeProcesso($objAtividade, $processoFluxo) {
    	date_default_timezone_set('America/Sao_Paulo');
    	$dataIn = date("d/m/Y");
    	
    	$objProcessoFluxo = null;
    	$controladorProcesso = new ControladorProcesso();
    	$objProcesso = $controladorProcesso->buscarFluxoProcesso($processoFluxo->getProcesso()->getId());
    	if ($objProcesso != null && $objProcesso[0]->getId() != null) {
    		foreach ($objProcesso as $processo) {
    			if ($processo != null && $processo->getFluxoProcesso() != null) {
    				foreach ($processo->getFluxoProcesso() as $fluxoProcesso) {
    					if($fluxoProcesso->getId() == $processoFluxo->getId()){
    						$objProcessoFluxo = $fluxoProcesso;
    						break;
    					}
    				}
    				break;
    			}
    		}
    	}
    	
    	if ($objProcessoFluxo->getAtividade()->getImagem() == "" || $objProcessoFluxo->getAtividade()->getImagem() == null) {
    		$imagem = "assets/images/atividade.png";
    	} else {
    		$imagem = "imagens/atividade/" . $objProcessoFluxo->getAtividade()->getImagem();
    	}
    	?>
    	<script src="./assets/main/js/popup-upload.js" type="text/javascript"></script>
        <script src="./assets/main/js/jquery.form.js" type="text/javascript" ></script>
        <script type="text/javascript" >
	        $(document).ready(function() {
    	        $('#tooltip').hide();
    	        fncInserirArquivo("form_arquivo", "progress_arquivo", "porcentagem_arquivo", "arquivo", "arquivoAtual", "./arquivos/atividade/", "arquivo", "anexo-btn");

    	        if(detectarMobile() == true){
    				$('.desktop').remove();
    			}

            });

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
            function showInputVencimento(){
                $('#span_vencimento').css('display','none');
				$('#div_input_vencimento').css('display','');
			}

			function slideRight(){
				var leftPos = $('.table-responsive').scrollLeft();
				$(".table-responsive").animate({scrollLeft: leftPos + 999}, 100);
			}
        </script>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">          
			        <div class="card-header d-flex">
			            <h4 class="card-header-title"><img class="" style="width: 32px; height: 33px; <?php echo $estilo; ?>" src="<?php echo $imagem; ?>" /></h4>
			            <div class="toolbar ml-auto">
			            	<a href="#" onclick="getId(this)" funcao="telaTimeLineProcesso" controlador="ControladorProcesso" id="<?php echo $processoFluxo->getProcesso()->getId(); ?>" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
			                <?php
			                if ($objProcessoFluxo->getAtuante() == 1) {
			                ?>
			                    <a href="#" onclick="getId(this)" funcao="desatuarFluxoProcesso" controlador="controladorProcesso" id="<?php echo $objProcessoFluxo->getId(); ?>" retorno="div_central" class="getId btn btn-primary btn-sm" >Desmarcar</a>
			                <?php
			                } else if ($objProcessoFluxo->getAtivo() == 1 && $objProcessoFluxo->getAtuante() != 1) {
			                ?>
			                    <a href="#" onclick="getId(this)" funcao="atuarFluxoProcesso" controlador="controladorProcesso" id="<?php echo $objProcessoFluxo->getId(); ?>" retorno="div_central" class="getId btn btn-primary btn-sm" >Marcar</a>
			                <?php
			                }
			
			                if ($objProcessoFluxo->getAtivo() == 1) {
			                ?>
			                    <a href="#" onclick="getId(this)" funcao="fecharFluxoProcesso" controlador="controladorProcesso" id="<?php echo $objProcessoFluxo->getId(); ?>" retorno="div_central" class="fecharProcesso btn btn-primary btn-sm" >Fechar</a>
			                <?php
			                } else {
			                ?>
			                    <a href="#" onclick="getId(this)" funcao="abrirFluxoProcesso" controlador="controladorProcesso" id="<?php echo $objProcessoFluxo->getId(); ?>" retorno="div_central" class="fecharProcesso btn btn-primary btn-sm" >Abrir</a>
			                <?php
			                }
			                ?>		                      
			            </div>
			        </div>
					
					<div class="card-footer">
						<div class="table-responsive">
							<table id="example" class="tablesorter table table-striped table-bordered second" style="width: 100%">
								<thead>
									<tr>
										<th class="desktop">Código</th>
										<th class="desktop">Data</th>
										<th class="desktop">Icone</th>
										<th>Processo</th>
										<th>Fluxo</th>
										<th>Vencimento</th>
										<th>Valor</th>
									</tr>
								</thead>
								<tbody>
				                    <tr style="text-align:center;">
										<td class="getId dimensions desktop" style="cursor: pointer"
											id="<?php echo $objProcesso[0]->getId(); ?>"
											funcao="telaVisualizarProcesso"
											controlador="ControladorProcesso" retorno="div_central"
											title="<?php echo nl2br($objProcesso[0]->getDescricao()); ?>"><?php echo str_pad($objProcesso[0]->getId(), 5, '0', STR_PAD_LEFT); ?></td>
										<td class="getId dimensions desktop" style="cursor: pointer"
											id="<?php echo $objProcesso[0]->getId(); ?>"
											funcao="telaVisualizarProcesso"
											controlador="ControladorProcesso" retorno="div_central"
											title="<?php echo nl2br($objProcesso[0]->getDescricao()); ?>">
											<?php echo recuperaData($objProcesso[0]->getData()); ?></td>
										<td class="desktop" style="text-align: center;">
											<span>
	                                            <div style="">
													<a class="dimensions"
														atuante="<?php echo $objProcessoFluxo->getAtuante(); ?>"
														style="text-decoration: none;"
														title="<?php echo 'Título: ' . $objProcessoFluxo->getTitulo() . '<br/>Descrição: ' . nl2br($objProcessoFluxo->getDescricao()); ?>">
	                                                    <?php
	                                                    $estilo = '';
	                                                    if ($objProcessoFluxo->getAtividade()->getId() != $objAtividade[0]->getId()) {
	                                                        $estilo = 'opacity: 0.1;z-index: 1;';
	                                                    } else {
	                                                        $estilo = ';z-index: 1;border: 3px solid #00F;cursor:pointer;';
	                                                    }
	                                                    ?>
														<img class="" style="width: 32px; height: 33px; <?php echo $estilo; ?>" src="<?php echo $imagem; ?>" />
													</a>
												</div>
						                    </span>
						                </td>
										<td class="getId dimensions" style="cursor: pointer"
											id="<?php echo $objProcesso[0]->getId(); ?>"
											funcao="telaVisualizarProcesso"
											controlador="ControladorProcesso" retorno="div_central"
											title="<?php echo nl2br($objProcesso[0]->getDescricao()); ?>"><?php echo limitarTexto($objProcesso[0]->getTitulo(), 40); ?></td>
										<td class="getId dimensions" style="cursor: pointer"
											id="<?php echo $objProcesso[0]->getId(); ?>"
											funcao="telaVisualizarProcesso"
											controlador="ControladorProcesso" retorno="div_central"
											title="<?php echo nl2br($objProcesso[0]->getDescricao()); ?>">
											<?php echo ($objProcesso[0]->getFluxo()) ? limitarTexto($objProcesso[0]->getFluxo()->getTitulo(), 40) : ''; ?></td>
										<td class="dimensions" style="cursor: pointer"
											id="<?php echo $objProcesso[0]->getId(); ?>"
											onclick="showInputVencimento();"
											title="<?php echo nl2br($objProcesso[0]->getDescricao()); ?>">
											<?php
												$vencimento = '-';
												$date = strtotime($processo->getData());
												if($objProcessoFluxo->getVencimento() != "" && $objProcessoFluxo->getVencimento() != null && $objProcessoFluxo->getVencimento() != "00"){
													$vencimento = $objProcessoFluxo->getVencimento().'/'.date('m',$date).'/'.date('Y',$date);
												}
											?>
											<span id="span_vencimento"><?php echo $vencimento; ?></span>
											<div id="div_input_vencimento" class="input-group" style="display:none;min-width:100px;max-width:100px;">
			                            		<select id="input_vencimento" name="input_vencimento" class="form-control" style="width:30px;"
			                            		        mes="<?php echo date('m',$date); ?>" ano="<?php echo date('Y',$date); ?>"
			                            		        onchange="inputUpdateProcessoFluxo('<?php echo $processoFluxo->getId(); ?>','v');">
													<option value="">Selecione...</option>
													<?php 
														for($i = 1; $i <=31; $i++){
															$select = ($objProcessoFluxo->getVencimento() == $i)?'selected="selected"':'';
															echo "<option value='".$i."' ".$select." >".$i."</option>";
														}
													?>
												</select>
                                            </div>
										</td>
										<td id="valueChange" class="getId dimensions"
											style="cursor: pointer"
											title="<?php echo nl2br($objProcesso[0]->getDescricao()); ?>">
											<div
												onclick="inputShow(
					                                    '<?php echo $objProcessoFluxo->getId(); ?>',
					                                    '<?php echo $simbolo.valorMonetario($objProcessoFluxo->getValor(),'2');?>',
					                                    '<?php echo $objProcessoFluxo->getPropriedade();?>');slideRight()">
					                                    <?php
					                                    	if($objProcessoFluxo->getPropriedade() == '1'){
						                                    	$simbolo = '';
						                                    }else{
						                                    	$simbolo = '-';
						                                    }
						                                    echo 'R$ '.$simbolo.valorMonetario($objProcessoFluxo->getValor(),'2');
					                                    ?>
					                        </div>
										</td>
									</tr> 
				                </tbody>
							</table>
						</div>
					</div>
						
					<div class="card-body">
						<div class="form-group">
							<label for="nome" class="col-form-label">Titulo Atividade *</label> 
							<div id="div_input_titulo" class="input-group" >
                            	<input value="<?php echo $objProcessoFluxo->getTitulo(); ?>" id="input_titulo" name="input_titulo" type="text" class="form-control">
	                            <div class="input-group-append">
                            		<button onclick="inputUpdateProcessoFluxo('<?php echo $objProcessoFluxo->getId(); ?>','t')" type="button" class="btn btn-primary">Atualizar</button>
                               	</div>
                            </div>
						</div>
						<div class="form-group">
							<label for="descricao">Descrição</label>
							<div id="div_input_descricao" class="input-group" >
							<textarea class="form-control" id="input_descricao" rows="3"><?php echo $objProcessoFluxo->getDescricao(); ?></textarea>
	                            <div class="input-group-append">
                            		<button onclick="inputUpdateProcessoFluxo('<?php echo $objProcessoFluxo->getId(); ?>','d')" type="button" class="btn btn-primary">Atualizar</button>
                               	</div>
                            </div>
						</div>
			            <?php
			            if ($objAtividade != null && $objAtividade[0]->getLink()) {
			            ?>			
						<div class="form-group">
							<label for="link" class="col-form-label">Link:&nbsp;
								<a target="_blank" href="<?php echo $objAtividade[0]->getLink(); ?>"><?php echo $objAtividade[0]->getLink(); ?></a>
							</label> 
						</div>
			            <?php
			            }
			            
			            if ($objAtividade != null && $objAtividade[0]->getArquivo()) {
			            ?>
						<div class="form-group">
							<label for="arquivoAtual" class="col-form-label">Arquivo da atividade disponivel:&nbsp;</label> 
							<input type="hidden" name="arquivo_atividade" id="arquivo_atividade" value="<?php echo $objAtividade[0]->getArquivo(); ?>" /> 
							<span name="arquivoAtual"  style="cursor: pointer;">
			                    <a target="_blank" title="Abrir arquivo: <?php echo $objAtividade[0]->getArquivo(); ?>" style="text-decoration: underline;" href="<?php echo './arquivos/atividade/'.$objAtividade[0]->getArquivo(); ?>"><?php echo $objAtividade[0]->getArquivo(); ?></a> &nbsp;
			                    <img src="assets/images/arrow.png" onClick="fnAbreArquivo('arquivo_atividade', './arquivos/atividade/')" style="cursor: pointer;width: 29px;" title="Download arquivo: <?php echo $objAtividade[0]->getArquivo(); ?>" >
			                </span>
						</div>
						<?php } ?>
					</div>
					<div class="card-footer" id="div_comentarios">
		        		<?php 
			        		$controladorAtividade = new ControladorAtividade();
			        		echo $controladorAtividade->comentariosAtividadeProcesso($processoFluxo->getId(),true);
		        		?>
				    </div>
			        <div class="card-body">
				       	<form action="#" method="post" id="formCadastro" class="">
			                <input type="hidden" name="retorno" id="retorno" value="div_central"/>
			                <input type="hidden" name="controlador" id="controlador" value="ControladorComentarioFluxoProcesso"/>
			                <input type="hidden" name="funcao" id="funcao" value="incluirComentarioFluxoProcesso"/>
			                <input type="hidden" name="mensagem" id="mensagem" value="1"/>
			                <input type="hidden" name="id_processo_fluxo" id="id_fluxo_processo" value="<?php echo $objProcessoFluxo->getId(); ?>" />
			                <input type="hidden" name="id_processo" id="id_processo" value="<?php echo $processoFluxo->getProcesso()->getId(); ?>" />				
			                <input type="hidden" name="id" id="id_atividade" value="<?php echo ($objAtividade != null) ? $objAtividade[0]->getId() : ''; ?>" />  
			                <input type="hidden" name="ativo" id="ativo" value="<?php echo $objProcessoFluxo->getAtivo(); ?>" />
			                <input type="hidden" name="arquivo" id="arquivo" value="" />						
							<div class="form-row">
								<div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
									<label for="fluxo">Data Comentário *</label>
									<div class="input-group date" id="datetimepicker4" data-target-input="nearest">
					                    <input type="text" id="data_comentario" name="data_comentario" onblur="validarCampo(this)" onkeypress="return mascara(event, this, '##/##/####');" maxlength="10"  value="<?php echo $dataIn; ?>" class="form-control datetimepicker-input mgs_alerta" data-target="#datetimepicker4">
					                    <div class="input-group-append" id="datepicker" name="datepicker" data-target="#datetimepicker4" data-toggle="datetimepicker">
					                  		<div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
					                    </div>
					                </div>
								</div>
								<div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
									<label for="descricao">Categoria *</label>
									<select id="categoria_comentario" name="categoria_comentario"  class="mgs_alerta form-control" >
										<option value="0" selected="selected" >Sem Anexo</option>
				                        <option value="1" >Boleto</option>
				                        <option value="2" >Comprovante</option>
				                        <option value="3" >Fatura</option>
				                        <option value="4" >Documento</option>
				                        <option value="5" >Nota Fiscal</option>
				                        <option value="6" >Outros</option>
				        			</select>	
					            </div>
								<div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
									<label for="descricao">Descrição *</label>
									<textarea class="form-control mgs_alerta" id="descricao" name="descricao" rows="1"></textarea>
								</div>
							</div>
						</form>
						<div class="form-row">
							<div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
							    <label>Tamanho Máxima: 2 Megas.</label>&nbsp;&nbsp; 
								<table border="0">
									<tr>
										<td>
											<form action="./post-imagem.php" method="post" id="form_arquivo" style="cursor:pointer;">
												<input name="pastaArquivo" type="hidden" value="./arquivos/atividade/">
												<input name="largura" type="hidden" value="640">
												<input name="opcao" type="hidden" value="1">
												<input name="tipoArq" type="hidden" value="arquivo">
												<input style="width: 30px;" type="file" name="file" class="upload-file" onchange="javascript: fncSubmitArquivo('enviar_arquivo', this);" >
												<input type="submit" id="enviar_arquivo" style="display:none;">
												<img src="./assets/images/img_upload.png" class="upload-button" />
											</form>										
										</td>
										<td>
											<img onclick="fncRemoverArquivo('arquivo', './arquivos/atividade/', 'arquivo', 'arquivoAtual', '');" src="./assets/images/remove.png" border="0" title="Clique para remover" style="cursor:pointer;" class="upload-button" />
										</td>
										<td style="padding-left: 10px;">
				                            <span title="" name="arquivoAtual" id="arquivoAtual" onClick="fnAbreArquivo('arquivo', './arquivos/atividade/')"   >Adicione um arquivo clicando no <img src="./assets/images/img_upload.png" border="0" style="float:none;margin:0;width: 20px;" /></span>
				                            <progress id="progress_arquivo" value="0" max="100" style="display:none;"></progress>
				                            <span id="porcentagem_arquivo" style="display:none;">0%</span>	
										</td>

									</tr>
								</table>
							</div>
						</div>
			        </div>
			        <div class="card-header d-flex">
			            <div class="toolbar ml-auto">
				            <button id="anexo-btn" onclick="fncFormCadastro(this)" class="btn btn-primary btn-sm formCadastro" style="width: 210px;text-align: center;">
				            	<span id="anexo-btn-text" style="display: block;">
				            		Adicionar Comentário/Anexo
				            	</span>
				            	<img id="anexo-btn-img" src="./assets/images/preloader.gif" style="display: none;width: 20px;margin-left: 80px;" />
				            </button>            	
			            </div>
			        </div>	        
				</div>
			</div>
		</div>
        <?php
    }
    
    
    
    public function telaComentariosAtividadeProcesso($processoFluxoId, $isDelete){
        ?>
        <div class="table-responsive">
			<table id="example" class="tablesorter table table-striped table-bordered second" style="width:99%">
        		<tbody>
        <?php
        $controladorComentario = new ControladorComentarioFluxoProcesso();
        $listComentario = $controladorComentario->listarComentarioFluxoProcesso($processoFluxoId);
        
        if ($listComentario) {
            $cont = 0;
            foreach ($listComentario as $comentario) {
                ++$cont;
                ?>
                    <tr>
                        <td id="mobile"style="text-align: center;">
                        	<?php echo $controladorComentario->showIconFile($comentario->getArquivo()); ?>
                        </td>                    
                        <td style="min-width: 300px;"><?php echo ($comentario->getDescricao() != '') ? nl2br($comentario->getDescricao()) : $comentario->getArquivo(); ?></td>
                        <td style="min-width: 170px;"><label ><?php echo recuperaData($comentario->getData()); ?></label></td>
                        <td style="text-align: center;"><?php echo ($comentario->getArquivo() != '') ? '<img src="assets/images/arrow.png" style="cursor: pointer;width: 29px;" title="Download do Arquivo: ' . $comentario->getArquivo() . '" onClick="fnAbreArquivo(\'arquivo' . $cont . '\', \'./arquivos/atividade\')" >' : '-'; ?>
                           <input type="hidden" name="arquivo<?php echo $cont; ?>" id="arquivo<?php echo $cont; ?>" value="<?php echo $comentario->getArquivo(); ?>" /> 
                        </td>
                        <td id="desktop" style="text-align: center;">
                        	<?php echo $controladorComentario->showIconFile($comentario->getArquivo()); ?>
                        </td>
                        <td>
	                        <?php
	                        if($comentario->getArquivo() == '' || $comentario->getArquivo() == null){
	                        	echo 'Sem anexo';
	                        }else{
	                        	switch ($comentario->getCategoria()) {
									case '1' :
										echo 'Boleto';
										break;
									case '2' :
										echo 'Comprovante';
										break;
									case '3' :
										echo 'Fatura';
										break;							
									case '4' :
										echo 'Documento';
										break;
									case '5' :
										echo 'Nota Fiscal';
										break;
									case '6' :
										echo 'Outros';
										break;
									default :
										echo 'Sem anexo';
										break;
		                        } 
	                        }
	                        ?>
                        </td>
                        <?php if($isDelete === true ){ ?>
                        <td style="text-align: center;">
                           <?php echo ($comentario->getDescricao() != '') ? '<img onclick="fcnModalDeleteId(this)" modal="question" funcao="excluirComentarioAtividadeFluxoProcesso" controlador="ControladorComentarioFluxoProcesso" id="'.$comentario->getId().'" processoFluxoId="'.$processoFluxoId.'" retorno="div_comentarios" src="./assets/images/remove.png" style="cursor: pointer;width: 29px;" title="Remover arquivo: ' . $comentario->getArquivo() . '">' : ''; ?>
                           <input type="hidden" name="arquivo<?php echo $cont; ?>" id="arquivo<?php echo $cont; ?>" value="<?php echo $comentario->getArquivo(); ?>" /> 
                        </td>
                        <?php } ?>
                    </tr>
                <?php
	                }
	            }
	            ?>	    				
				</tbody>
			</table>
		</div>
		<script type="text/javascript">
	        if(detectarMobile() == true){
				$('#desktop').remove();
			}else{				
				$('#mobile').remove();
			}		
		</script>     
		<?php 
    }
    
    public function telaComboFluxo(){
    	?>
		<div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
			<label for="pais">Fluxo</label>
			<select id="fluxo" name="fluxo"  class="form-control">
			<?php 
			try {
				$controladorFluxo = new ControladorFluxo();
				$objetos = $controladorFluxo->listarDistinctFluxo();
			} catch (Exception $e) { echo 'erro no listarFluxo'; }
			?>
				<option value="">Selecione...</option>
			<?php 
			 foreach ($objetos as $objetos){
			?>
				<option value="<?php echo $objetos->getId()?>"><?php echo $objetos->getTitulo();?></option>
			<?php                                  	
			 }
			 ?>                                 
			</select>
		</div>			
		<?php     	
    }
    
    public function telaComboProcesso(){
    	?>
		<div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
			<label for="pais">Processo</label>
			<select id="processo" name="processo"  class="form-control">
			<?php 
			try {
				$controladorProcesso = new ControladorProcesso();
				$objetos = $controladorProcesso->listarDistinctProcesso();
			} catch (Exception $e) { echo 'erro no listar Processo'; }
			?>
				<option value="">Selecione...</option>
			<?php 
			 foreach ($objetos as $objetos){
			?>
				<option value="<?php echo $objetos->getId()?>"><?php echo $objetos->getTitulo();?></option>
			<?php                                  	
			 }
			 ?>                                 
			</select>
		</div>			
		<?php  
    }
    
    public function telaComboAtividade(){
    	?>
		<div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
			<label for="pais">Atividade</label>
			<select id="atividade" name="atividade"  class="form-control">
			<?php 
			try {
				$controladorAtividade = new ControladorAtividade();
				$objetos = $controladorAtividade->listarDistinctAtividade();
			} catch (Exception $e) { echo 'erro no listar Atividade'; }
			?>
				<option value="">Selecione...</option>
			<?php 
			 foreach ($objetos as $objetos){
			?>
				<option value="<?php echo $objetos->getId()?>"><?php echo $objetos->getTitulo();?></option>
			<?php                                  	
			 }
			 ?>                                 
			</select>
		</div>			
		<?php  
    }
    
    public function telaListarComentariosAtividadeProcesso($listComentario){
    	?>
		<script type="text/javascript">
			//$.fn.DataTable.ext.pager.numbers_length = 10;
			$.fn.dataTable.moment( 'DD/MM/YYYY' );
			$('.tablesorter').dataTable({
				"sPaginationType": "full_numbers",
				"bFilter": false,
				"bLengthChange" : true,
				"aaSorting": [[1, 'desc']]
			});
            $(document).ready(function() {
	            $('#tooltip').hide();
	            fixTableLayout('example');  
            });

            function showHideFilter(element){
				var isShow = $(element).attr("show");
				if(isShow == 'D'){
					$('#div_filter').slideDown('slow');
					$(element).attr("show", 'U');
				}else if(isShow == 'U'){
					$('#div_filter').slideUp('slow');
					$(element).attr("show", 'D');
				}				
            }

            function hideFilter(){
				$('#div_filter').slideUp('slow');
				$('#btnFilter').attr("show", 'D');
            }
		</script>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">		
				<div class="card-header d-flex">
		            <h4 class="card-header-title">Comentários e Anexos</h4>
		            <div class="toolbar ml-auto">
		            	<a href="#" id="btnFilter" onclick="showHideFilter(this)" show="D" class="btn btn-light btn-sm">Filtro</a>
		             	<a href="#" onclick="fncButtonCadastro(this)" funcao="telaCadastrarAgenda" controlador="ControladorAgenda" retorno="div_central" class="btn btn-primary btn-sm buttonCadastro">Agenda</a>
		            </div>
		        </div>	
		        <div class="card-footer" style="display: none;" id="div_filter">
	        	<form action="#" method="post" id="formCadastro" class="">
		            <input type="hidden" name="retorno" id="retorno" value="div_central"/>
		            <input type="hidden" name="controlador" id="controlador" value="ControladorAtividade"/>
		            <input type="hidden" name="funcao" id="funcao" value="telaListarComentariosAtividadeProcesso"/>
		            <div class="form-group">
						<label for="nome" class="col-form-label">Descrição</label> 
						<input id="descricao" name="descricao" type="text" value="" class="form-control" placeholder="Informe um texto a ser filtrado..." >
					</div>
					<div class="form-row">
						<div class="form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2">
							<label for="anexo">Anexo</label>
							<select id="anexo" name="anexo"  class="form-control" >
								<option value="" selected="selected" >Selecione...</option>
								<option value="1" >Com Anexo</option>
		                        <option value="2" >Sem Anexo</option>
		        			</select>
						</div>
						<?php echo $this->telaComboFluxo(); ?>
					</div>
					<div class="form-row">							
		        		<?php 
			        		echo $this->telaComboProcesso();
			        		echo $this->telaComboAtividade();
		        		?>	
	        		</div>
					<div class="form-group">
						<a href="#" onclick="fncFormCadastro(this); hideFilter();" class="btn btn-secondary btn-sm formCadastro">Filtrar</a>  
					</div>
				</form>	
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table id="example" class="tablesorter table table-striped table-bordered second" style="width:100%">
							<thead>
								<tr>
									<th>Data</th> 
									<th>Fluxo</th> 
									<th>Processo</th> 
									<th>Atividade</th> 
									<th>Descri&ccedil;&atilde;o</th> 
									<th>Download Anexo</th> 
									<th>Link Anexo</th> 
									<th class="sorting_disabled" style="text-align: center;" >A&ccedil;&atilde;o</th> 
								</tr>
							</thead>
							<tbody>
							<?php 
					        if ($listComentario) {
					            $cont = 0;
					            foreach ($listComentario as $comentario) {
					                ++$cont;
					                ?>
					                    <tr>
					                        <td><label style="width: 80px;"><?php echo recuperaData($comentario->getData()); ?></label></td>
					                        <td><?php echo $comentario->getFluxoProcesso()->getTitulo(); ?></td>
					                        <td><?php echo $comentario->getProcesso()->getTitulo(); ?></td>
					                        <td><?php echo $comentario->getFluxoProcesso()->getAtividade()->getTitulo(); ?></td>
					                        <td><?php echo ($comentario->getDescricao() != '') ? nl2br($comentario->getDescricao()) : $comentario->getArquivo(); ?></td>
					                        <td style="text-align: center;"><?php echo ($comentario->getArquivo() != '') ? '<img src="assets/images/arrow.png" style="cursor: pointer;width: 29px;" title="Arquivo: ' . $comentario->getArquivo() . '" onClick="fnAbreArquivo(\'arquivo' . $cont . '\', \'./arquivos/atividade\')" >' : '-'; ?>
					                           <input type="hidden" name="arquivo<?php echo $cont; ?>" id="arquivo<?php echo $cont; ?>" value="<?php echo $comentario->getArquivo(); ?>" /> 
					                        </td>
					                        <td style="text-align: center;">
					                        <?php
					                        	$controladorComentario = new ControladorComentarioFluxoProcesso();
					                        	echo $controladorComentario->showIconFile($comentario->getArquivo());
					                        ?>
					                        </td>
					                        <td style="text-align: center;">
					                           <?php echo ($comentario->getDescricao() != '') ? '<img onclick="fcnModalDeleteId(this)" modal="question" funcao="excluirComentarioAtividadeFluxoProcesso" controlador="ControladorComentarioFluxoProcesso" id="'.$comentario->getId().'" processoFluxoId="'.$processoFluxoId.'" retorno="div_comentarios" src="./assets/images/remove.png" style="cursor: pointer;width: 29px;" title="Remover arquivo: ' . $comentario->getArquivo() . '">' : ''; ?>
					                           <input type="hidden" name="arquivo<?php echo $cont; ?>" id="arquivo<?php echo $cont; ?>" value="<?php echo $comentario->getArquivo(); ?>" /> 
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

}
?>