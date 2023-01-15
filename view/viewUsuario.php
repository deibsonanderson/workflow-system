<?php

class ViewUsuario {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }

    public function telaCadastrarUsuario() {
        ?>
        <script src="./assets/main/js/popup-upload.js" type="text/javascript"></script>
        <script src="./assets/main/js/jquery.form.js" type="text/javascript" ></script>
        <script type="text/javascript" >
            $(document).ready(function() {                
                fncInserirArquivo("form_imagem", "progress", "porcentagem", "imagem", "imagemAtual", "./imagens/usuario/", "imagem");
            });
        </script>
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">        
		<div class="card-header d-flex">
            <h4 class="card-header-title">Cadatro de Usuário</h4>
            <div class="toolbar ml-auto">
	            <a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarUsuario" controlador="ControladorUsuario" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
	            <a href="#" onclick="fncFormCadastro(this)" class="btn btn-primary btn-sm formCadastro">Cadastrar</a>            	
            </div>
        </div>	
		<div class="card-body">	
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
                                    <input name="pastaArquivo" type="hidden" value="./imagens/usuario/">
                                    <input name="largura" type="hidden" value="640">
                                    <input name="opcao" type="hidden" value="1">
                                    <input name="tipoArq" type="hidden" value="imagem">
                                    <input type="file" name="file" class="upload-file" style="width: 30px;" onchange="javascript: fncSubmitArquivo('enviar', this);" >
                                    <input type="submit" id="enviar" style="display:none;">   
                                    <img src="./assets/images/img_upload.png" class="upload-button" />
                                </form> 
                            </span>
                        </td>
                        <td style="width: 20%">
                            <img onclick="fncRemoverArquivo('imagem', './imagens/usuario', 'imagem', 'imagemAtual', './assets/images/imagemPadrao.jpg');" src="./assets/images/remove.png" border="0" title="Clique para remover" style="cursor:pointer;margin-bottom:7px;" class="upload-button" />
                        </td>
                        <td style="width: 60%">
                            <img id="imagemAtual" name="imagemAtual" src="./assets/images/imagemPadrao.jpg" border="0" style="" />
                            <progress id="progress" value="0" max="100" style="display:none;"></progress>
                            <span id="porcentagem" style="display:none;">0%</span>                            
                        </td>
                    </tr>
                </table>
			</div>				
        	<form action="#" method="post" id="formCadastro" class="">
                <input type="hidden" name="retorno" id="retorno" value="div_central"/>
                <input type="hidden" name="controlador" id="controlador" value="ControladorUsuario"/>
                <input type="hidden" name="funcao" id="funcao" value="incluirUsuario"/>
                <input type="hidden" name="mensagem" id="mensagem" value="1"/>
                <input type="hidden" name="imagem" id="imagem" value="" />						
				<div class="form-group">
					<label for="nome" class="col-form-label">Nome *</label>
					<input id="nome" name="nome" type="text" class="form-control mgs_alerta" onkeyup="this.value=this.value.toUpperCase();">
				</div>
				<div class="form-group">
					<label for="login" class="col-form-label">Login *</label>
					<input id="login" name="login" type="text" class="form-control mgs_alerta" >
				</div>				
				<div class="form-group">
					<label for="senha" class="col-form-label">Senha *</label>
					<input type="password" id="senha" name="senha" class="form-control mgs_alerta" >
				</div>
				<div class="form-group">
					<label for="senha2" class="col-form-label">Repetir a Senha *</label>
					<input type="password" id="senha2" name="senha2" class="form-control mgs_alerta" >
				</div>
				<div class="form-group">
					<label for="perfil">Perfil *</label>
					<select id="perfil" name="perfil"  class="mgs_alerta form-control" >
						<option value="1" >Adiministrador</option>
                        <option value="2" selected="selected" >Usuário</option>
        			</select>						
				</div>					
			</form>				
		</div>
		</div>
	</div>
</div>		
        <?php
    }

    public function telaListarUsuario($objUsuario) {
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
            <h4 class="card-header-title">Usuários</h4>
            <div class="toolbar ml-auto">
            	<a href="#" onclick="fncButtonCadastro(this)" controlador="ControladorUsuario" funcao="telaCadastrarUsuario" retorno="div_central" class="btn btn-primary btn-sm buttonCadastro">Novo</a>
            </div>
        </div>		
		<div class="card-body">
			<div class="table-responsive">
				<table id="example" class="tablesorter table table-striped table-bordered second" style="width:100%">
					<thead>
						<tr>
                            <th>Código</th>
                            <th>Imagem</th>  
                            <th>Nome</th> 
                            <th>Login</th> 							
                            <th class="sorting_disabled" style="text-align: center;" >&nbsp;&nbsp;&nbsp;&nbsp; A&ccedil;&atilde;o &nbsp;&nbsp;&nbsp;&nbsp;</th>  
						</tr>
					</thead>
					<tbody>
                        <?php
                        if ($objUsuario) {
                            foreach ($objUsuario as $usuario) {
                            	$imagem = './assets/images/avatar-1.jpg';
                            	if($usuario->getImagem() != null && $usuario->getImagem() != ''){
                            		$imagem = './imagens/usuario/'.$usuario->getImagem();
                            	}
                            	
                                ?>    
                                <tr> 
                                    <td onclick="getId(this)" class="getId" style="cursor:pointer"  id="<?php echo $usuario->getId(); ?>" funcao="telaVisualizarUsuario" controlador="ControladorUsuario" retorno="div_central"><?php echo str_pad($usuario->getId(), 5, "0", STR_PAD_LEFT); ?></td> 
                                    <td onclick="getId(this)" class="getId" style="cursor:pointer;text-align: center;"  id="<?php echo $usuario->getId(); ?>" funcao="telaVisualizarUsuario" controlador="ControladorUsuario" retorno="div_central"><img src="<?php echo $imagem; ?>" style="width: 38px;"></td> 
                                    <td onclick="getId(this)" class="getId" style="cursor:pointer"  id="<?php echo $usuario->getId(); ?>" funcao="telaVisualizarUsuario" controlador="ControladorUsuario" retorno="div_central"><?php echo $usuario->getNome(); ?></td> 
                                    <td onclick="getId(this)" class="getId" style="cursor:pointer"  id="<?php echo $usuario->getId(); ?>" funcao="telaVisualizarUsuario" controlador="ControladorUsuario" retorno="div_central"><?php echo $usuario->getLogin(); ?></td> 
                                    <td style="text-align:center">
                                    	<div class="btn-group ml-auto">
	                                        <button onclick="getId(this)" id="<?php echo $usuario->getId(); ?>" funcao="telaAlterarUsuario" controlador="ControladorUsuario" retorno="div_central" class="getId btn btn-sm btn-outline-light"><i class="far fa-edit"></i></button>
	                                        <button onclick="fcnModalDeleteId(this)" modal="question" id="<?php echo $usuario->getId(); ?>" funcao="excluirUsuario" controlador="ControladorUsuario" retorno="div_central" mensagem="4" class="deleteId btn btn-sm btn-outline-light"><i class="far fa-trash-alt"></i></button> 
	                                        <button onclick="getId(this)" id="<?php echo $usuario->getId(); ?>" funcao="telaListarAcao" controlador="ControladorAcao"  retorno="div_central" class="getId btn btn-sm btn-outline-light"><i class="far fa-address-card"></i></button>
											<button onclick="getId(this)" id="<?php echo $usuario->getId(); ?>" funcao="telaAlterarSenhaUsuario" controlador="ControladorUsuario" retorno="div_central" class="getId btn btn-sm btn-outline-light"><i class="far fa-edit"></i></button>											
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

    public function telaAlterarUsuario($objUsuario) {
    	if ($objUsuario[0]->getImagem()) {
    		$imagem = "./imagens/usuario/thumbnail" . $objUsuario[0]->getImagem();
    	} else {
    		$imagem = "./assets/images/imagemPadrao.jpg";
    	}
    	?>
        <script src="./assets/main/js/popup-upload.js" type="text/javascript"></script>
        <script src="./assets/main/js/jquery.form.js" type="text/javascript" ></script>
        <script type="text/javascript" >
            $(document).ready(function() {                
                fncInserirArquivo("form_imagem", "progress", "porcentagem", "imagem", "imagemAtual", "./imagens/usuario/", "imagem");
            });
        </script>
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">        
		<div class="card-header d-flex">
            <h4 class="card-header-title">Alterar Usuário</h4>
            <div class="toolbar ml-auto">
	            <a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarUsuario" controlador="ControladorUsuario" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
	            <a href="#" onclick="fncFormCadastro(this)" class="btn btn-primary btn-sm formCadastro">Alterar</a>            	
            </div>
        </div>	
		<div class="card-body">	
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
                                    <input name="pastaArquivo" type="hidden" value="./imagens/usuario/">
                                    <input name="largura" type="hidden" value="640">
                                    <input name="opcao" type="hidden" value="1">
                                    <input name="tipoArq" type="hidden" value="imagem">
                                    <input type="file" name="file" class="upload-file" style="width: 30px;"  onchange="javascript: fncSubmitArquivo('enviar', this);" >
                                    <input type="submit" id="enviar" style="display:none;">   
                                    <img src="./assets/images/img_upload.png" class="upload-button" />
                                </form> 
                            </span>
                        </td>
                        <td style="width: 20%">
                            <img onclick="fncRemoverArquivo('imagem', './imagens/usuario', 'imagem', 'imagemAtual', './assets/images/imagemPadrao.jpg');" src="./assets/images/remove.png" border="0" title="Clique para remover" style="cursor:pointer;margin-bottom:7px;" class="upload-button" />
                        </td>
                        <td style="width: 60%">
                            <img id="imagemAtual" name="imagemAtual" src="<?php echo $imagem; ?>" border="0" style="" />
                            <progress id="progress" value="0" max="100" style="display:none;"></progress>
                            <span id="porcentagem" style="display:none;">0%</span>                            
                        </td>
                    </tr>
                </table>
			</div>				
        	<form action="#" method="post" id="formCadastro" class="">
                <input type="hidden" name="retorno" id="retorno" value="div_central"/>
                <input type="hidden" name="controlador" id="controlador" value="ControladorUsuario"/>
                <input type="hidden" name="funcao" id="funcao" value="alterarUsuario"/>
                <input type="hidden" name="mensagem" id="mensagem" value="2"/>
                <input type="hidden" name="id" id="id" value="<?php echo $objUsuario[0]->getId() ?>"/>
                <input type="hidden" name="imagem" id="imagem" value="<?php echo $objUsuario[0]->getImagem(); ?>" />					
				<div class="form-group">
					<label for="nome" class="col-form-label">Nome *</label>
					<input id="nome" name="nome" type="text" value="<?php echo $objUsuario[0]->getNome(); ?>" class="form-control mgs_alerta" onkeyup="this.value=this.value.toUpperCase();">
				</div>
				<div class="form-group">
					<label for="login" class="col-form-label">Login *</label>
					<input id="login" name="login" type="text" value="<?php echo $objUsuario[0]->getLogin(); ?>" class="form-control mgs_alerta" >
				</div>
				<div class="form-group">
					<label for="popup_vencimento">PopUp à vencer *</label>
					<select id="popup_vencimento" name="popup_vencimento"  class="mgs_alerta form-control" >
                        <?php
                        if ($objUsuario[0]->getPopup_vencimento() == 1) {
                            $selected_1 = 'selected="selected"';
                            $selected_2 = '';
                        } else {
                            $selected_1 = '';
                            $selected_2 = 'selected="selected"';
                        }
                        ?>
                        <option value="1" <?php echo $selected_1; ?> >Ativo</option>
                        <option value="0" <?php echo $selected_2; ?> >Inativo</option>
        			</select>						
				</div>					
				
				<div class="form-group">
					<label for="perfil">Perfil *</label>
					<select id="perfil" name="perfil"  class="mgs_alerta form-control" >
                        <?php
                        if ($objUsuario[0]->getPerfil() == 1) {
                            $selected_1 = 'selected="selected"';
                            $selected_2 = '';
                        } else {
                            $selected_1 = '';
                            $selected_2 = 'selected="selected"';
                        }
                        ?>
                        <option value="1" <?php echo $selected_1; ?> >Adiministrador</option>
                        <option value="2" <?php echo $selected_2; ?> >Usuário</option>
        			</select>						
				</div>					
			</form>				
		</div>
		</div>
	</div>
</div>		        
        <?php
    }

    public function telaVisualizarUsuario($objUsuario) {
        ?>
        <script src="js/popupUpload.js" type="text/javascript"></script>
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
		<div class="card">        
		<div class="card-header d-flex">
            <h4 class="card-header-title">Visualizar Usuário</h4>
            <div class="toolbar ml-auto">
	            <a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarUsuario" controlador="ControladorUsuario" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
            </div>
        </div>	
		<div class="card-body">	
			<div class="form-group">
                <label>Imagem Largura Máxima: 640px</label>&nbsp;&nbsp;
                <?php
                if ($objUsuario[0]->getImagem()) {
                    $imagem = "./imagens/usuario/thumbnail" . $objUsuario[0]->getImagem();
                } else {
                    $imagem = "./assets/images/imagemPadrao.jpg";
                }
                ?>	 
                <span name="imagemLink" id="<?php echo $imagem; ?>" title="Imagem" >
                    <img name="imagemAtual" src="<?php echo $imagem; ?>" border="0" />
                </span>
			</div>				
        	<form action="#" method="post" id="formCadastro" class="">
                <input type="hidden" name="retorno" id="retorno" value="div_central"/>
                <input type="hidden" name="controlador" id="controlador" value="ControladorUsuario"/>
                <input type="hidden" name="funcao" id="funcao" value="alterarUsuario"/>
                <input type="hidden" name="mensagem" id="mensagem" value="2"/>
                <input type="hidden" name="id" id="id" value="<?php echo $objUsuario[0]->getId() ?>"/>
                <input type="hidden" name="imagem" id="imagem" value="<?php echo $objUsuario[0]->getImagem(); ?>" />					
				<div class="form-group">
					<label for="titulo" class="col-form-label">Nome *</label>
					<input id="titulo" name="titulo" disabled type="text" value="<?php echo $objUsuario[0]->getNome(); ?>" class="form-control mgs_alerta" onkeyup="this.value=this.value.toUpperCase();">
				</div>
				<div class="form-group">
					<label for="login" class="col-form-label">Login *</label>
					<input id="login" name="login" type="text" disabled value="<?php echo $objUsuario[0]->getLogin(); ?>" class="form-control mgs_alerta" onkeyup="this.value=this.value.toUpperCase();">
				</div>
				<div class="form-group">
					<label for="popup_vencimento">PopUp à vencer *</label>
					<select id="popup_vencimento" disabled name="popup_vencimento"  class="mgs_alerta form-control" >
                        <?php
                        if ($objUsuario[0]->getPopup_vencimento() == 1) {
                            $selected_1 = 'selected="selected"';
                            $selected_2 = '';
                        } else {
                            $selected_1 = '';
                            $selected_2 = 'selected="selected"';
                        }
                        ?>
                        <option value="1" <?php echo $selected_1; ?> >Ativo</option>
                        <option value="0" <?php echo $selected_2; ?> >Inativo</option>
        			</select>						
				</div>					
				<div class="form-group">
					<label for="perfil">Perfil *</label>
					<select id="perfil" disabled name="perfil"  class="mgs_alerta form-control" >
                        <?php
                        if ($objUsuario[0]->getPerfil() == 1) {
                            $selected_1 = 'selected="selected"';
                            $selected_2 = '';
                        } else {
                            $selected_1 = '';
                            $selected_2 = 'selected="selected"';
                        }
                        ?>
                        <option value="1" <?php echo $selected_1; ?> >Adiministrador</option>
                        <option value="2" <?php echo $selected_2; ?> >Usuário</option>
        			</select>						
				</div>					
			</form>				
		</div>
		</div>
	</div>
</div>		        
        <?php
    }
	
	
    public function telaAlterarSenhaUsuario($objUsuario) {
    	if ($objUsuario[0]->getImagem()) {
    		$imagem = "./imagens/usuario/thumbnail" . $objUsuario[0]->getImagem();
    	} else {
    		$imagem = "./assets/images/imagemPadrao.jpg";
    	}
    	?>
        <script src="./assets/main/js/popup-upload.js" type="text/javascript"></script>
        <script src="./assets/main/js/jquery.form.js" type="text/javascript" ></script>
        <script type="text/javascript" >
            $(document).ready(function() {                
                fncInserirArquivo("form_imagem", "progress", "porcentagem", "imagem", "imagemAtual", "./imagens/usuario/", "imagem");
            });
        </script>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">        
				<div class="card-header d-flex">
					<h4 class="card-header-title">Alterar Senha Usuário</h4>
					<div class="toolbar ml-auto">
						<a href="#" onclick="fncButtonCadastro(this)" funcao="telaListarUsuario" controlador="ControladorUsuario" retorno="div_central" class="btn btn-light btn-sm buttonCadastro">Voltar</a>
						<a href="#" onclick="fncFormCadastro(this)" class="btn btn-primary btn-sm formCadastro">Alterar</a>            	
					</div>
				</div>	
				<div class="card-body">	
					<form action="#" method="post" id="formCadastro" class="">
						<input type="hidden" name="retorno" id="retorno" value="div_central"/>
						<input type="hidden" name="controlador" id="controlador" value="ControladorUsuario"/>
						<input type="hidden" name="funcao" id="funcao" value="alterarSenhaUsuario"/>
						<input type="hidden" name="mensagem" id="mensagem" value="2"/>
						<input type="hidden" name="id" id="id" value="<?php echo $objUsuario[0]->getId() ?>"/>                
						<div class="form-group">
							<label for="senha" class="col-form-label">Senha *</label>
							<input type="password" id="senha" name="senha" class="form-control mgs_alerta">
						</div>
						<div class="form-group">
							<label for="senha2" class="col-form-label">Repetir a Senha *</label>
							<input type="password" id="senha2" name="senha2" class="form-control mgs_alerta" >
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