<?php
abstract class ViewBase {
	
	const VERDADEIRO = true;
	const FALSO = false;
	const DIV_CENTRAL = 'div_central';
	const MENSAGEM_UM = '1';
	const MENSAGEM_DOIS = '2';
	const BTN_SMALL_LIGHT = 'btn btn-light btn-sm';
	const BTN_SMALL_PRIMARY = 'btn btn-primary btn-sm';
	const CADASTRAR = 'Cadastrar';
	const ALTERAR = 'Alterar';
	
	//input types
	const CODIGO = 'id';
	const TEXT = 'text';
	const TEXT_AREA = 'textarea';
	
	/**
	 * Operação responsavel por montar o script batão de informação de growlUI2
	 * @param $_POST $post
	 * @return string
	 */
	protected function montarGrowlUI($post){
        return ($post) ? "<script type='text/javascript'>$.growlUI2('" . $post . "', '&nbsp;');</script>" : "";
	}
	
	/**
	 * Operação responsavelp por carregar o asteristico para campos obrigatorios conforme definido em cada objeto campo.
	 * @param Campo $campo
	 * @return string
	 */
	protected function getAsterisco($campo) {
		return ($campo->getObrigatorio ()) ? ' *' : '';
	}
	
	/**
	 * Operação responsavelp por carregar a classe css mgs_alerta para campos obrigatorios conforme definido em cada objeto campo.
	 * @param Campo $campo
	 * @return string
	 */
	protected function getMgsAlerta($campo) {
		return ($campo->getObrigatorio ()) ? ' mgs_alerta ' : '';
	}
	
	/**
	 * Operação responsavel por montar o script de aumentativo conforme definido em cada objeto campo
	 * @param Campo $campo
	 * @return string
	 */
	protected function getUpperCase($campo) {
		return ($campo->getUpperCase ()) ? ' onkeyup="this.value=this.value.toUpperCase();" ' : '';
	}
	
	/**
	 * Operação responsavel por montar o botão de acao cadastrar ou alterar
	 * @param String $titulo
	 * @return BotaoLink
	 */
	protected  function montarBotaoAcao($titulo){
		return $this->criarBotaoLinkAcao ( $titulo, 'onclick="fncFormCadastro(this)"' );
	}
	
	/**
	 * Operação responsavel por criar campos que redirecionar para a pagina anterior no topo da pagina
	 * @param String $controlador
	 * @param String $funcao
	 * @return BotaoLink
	 */
	protected function montarBtnVoltar($controlador, $funcao){
		return $this->criarBotaoLinkAcao ( 'Voltar', 'onclick="fncButtonCadastro(this)"', $controlador, $funcao, $this::DIV_CENTRAL );
	}
	
	/**
	 * Operação responsavel por criar campos que redirecionar para a cada de cadastrar no topo da pagina
	 * @param String $controlador
	 * @param String $funcao
	 * @return BotaoLink
	 */
	protected function montarBtnNovo($controlador, $funcao){
		return $this->criarBotaoLinkAcao ( 'Novo', 'onclick="fncButtonCadastro(this)"', $controlador, $funcao, $this::DIV_CENTRAL );
	}
		
	/**
	 * Operação responsavel por montar os botão de redirecionamento Ex: voltar, novo, etc.
	 * @param Tela $tela
	 * @param String $css
	 * @return string
	 */
	protected function montarBotaoRedirect($tela, $css){
		if($tela->getBotaoRedirect()){
			return '<a href="#" '.$tela->getBotaoRedirect()->getAcao().'
												      funcao="'.$tela->getBotaoRedirect()->getFuncao().'"
	                                                  controlador="'.$tela->getBotaoRedirect()->getControlador().'"
	                                                  retorno="'.$tela->getBotaoRedirect()->getRetorno().'"
	                                                  class="'.$css.' buttonCadastro">'.$tela->getBotaoRedirect()->getTitulo().'</a>';
		}
	}
	
	/**
	 * Operação responsavel por montar o botão cadastrar ou alterar padrão do formulario
	 * @param unknown $tela
	 * @return string
	 */
	protected function montarBotaoCadastrarAlterar($tela){
		if($tela->getBotaoCadastrarAlterar()){
			return '<a href="#" '.$tela->getBotaoCadastrarAlterar()->getAcao().' class="btn btn-primary btn-sm formCadastro">'.$tela->getBotaoCadastrarAlterar()->getTitulo().'</a>';
		}
	}
	
	/**
	 * Operação responsavel por montar os inputs padrão dos forms
	 * @param Tela $tela
	 * @param Object $objeto
	 * @return string
	 */
	protected function montarInputsForm($tela, $objeto = null){
		
		$html = '<input type="hidden" name="retorno" id="retorno" value="'.$tela->getRetorno().'"/>
		<input type="hidden" name="controlador" id="controlador" value="'.$tela->getControlador().'"/>
		<input type="hidden" name="funcao" id="funcao" value="'.$tela->getFuncao().'"/>
		<input type="hidden" name="mensagem" id="mensagem" value="'.$tela->getMensagem().'"/>';
		
		if($objeto && $objeto->getId()){
			$html .= '<input type="hidden" name="id" id="id" value="'.$objeto->getId().'"/>';
		}
		
		return $html;
	}
	
	/**
	 * Operação responsavel por inicializar o script das tabelas
	 * @return string
	 */
	protected function montarInitDataTable(){
		return '<script type="text/javascript">
		            $(".tablesorter").dataTable({
		                "sPaginationType": "full_numbers"
		            });
		            $(document).ready(function() {
		                $("#tooltip").hide();
		                fixTableLayout("example");
		            });
		        </script>';
	}
	
	//BLOCO MONTAR INPUTS GERAIS INICIO ***************************************************************
	
	/**
	 * Operação responsavel por montar os inputs que serão exibidos na tela de manter
	 * @param Tela $tela - informações que iram compor a tela, onde tera um array de campos com seus respectivos tipos e valores
	 * @param Object $objeto - objeto que sera carregado ex: update e view
	 * @param boolean $view - booleano responsavel por informar se a tela é update ou view
	 * @return string
	 */
	protected function montarInputs($tela, $objeto, $view){
		$inputs = '';
		foreach ($tela->getCampos() as $campo) {
			$inputs .= $this->checkTipoInput($campo, $objeto, $view);
		}
		return $inputs;
	}
	
	/**
	 * Operação responsavel por checar qual o tipo do input sera carregado no momento.
	 * @param Campo $campo
	 * @param Object $objeto
	 * @param boolean $view
	 * @return string
	 */
	protected function checkTipoInput($campo, $objeto, $view){
		if ($campo->getTipo() == 'textArea') {
			return 'TODO';
		} else {
			return $this->montarInputText($campo, $objeto, $view);
		}
	}
	
	/**
	 * Operação responsavel por montar campos input do tipo text
	 * @param Campo $campo
	 * @param Object $objeto
	 * @param boolean $view
	 * @return string
	 */
	protected function montarInputText($campo, $objeto, $view){
		if($objeto){
			$method = 'get'.ucfirst($campo->getNome());
			if(method_exists(get_class($objeto), $method)){
				$valor = $objeto->$method();
			}
		}
		
		$disabled = ($view)?'disabled="disabled"':'';
		
		return '<div class="card-body">
								<div class="form-group">
									<label for="'.strtolower($campo->getTitulo()).'" class="col-form-label">'.ucfirst($campo->getTitulo()).$this->getAsterisco($campo).' </label>
									<input id="'.strtolower($campo->getNome()).'" name="'.strtolower($campo->getNome()).'" type="text" value="'.$valor.'" '.$disabled.' class="form-control '.$this->getMgsAlerta($campo).'" '.$this->getUpperCase($campo).'>
								</div>
							</div>';
	}
	
	//BLOCO MONTAR INPUTS GERAIS FIM ***************************************************************
	
	//BLOCO MONTAR BOTAO ACAO INICIO ***************************************************************
	/**
	 * Operação responsavel por montar os botões de ação na listagens
	 * @param Tela $tela
	 * @param integer $id
	 * @param boolean $alterar
	 * @param boolean $excluir
	 * @return string
	 */
	protected function montarBtnAcaoListar($tela, $id = null, $alterar = null, $excluir = null){
		$html = '';
		if($alterar || $excluir){
			$html .= '<td style="text-align:center">
						<div class="btn-group ml-auto">
						'.$this->montarBtnAlterarLista($tela, $alterar, $id).$this->montarBtnDeletarLista($tela, $excluir, $id).'
						</div>
					</td>';
		}
		return $html;
	}
	
	/**
	 * Operação responsavel por montar o botão de alterar da listagem
	 * @param Tela $tela
	 * @param boolean $alterar
	 * @param integer $id
	 * @return string
	 */
	protected function montarBtnAlterarLista($tela, $alterar = null, $id = null){
		return ($alterar)?'<button onclick="getId(this)" id="'.$id.'" funcao="'.$tela->getBotaoListarAlterar()->getFuncao().'" controlador="'.$tela->getBotaoListarAlterar()->getControlador().'" retorno="div_central" class="getId btn btn-sm btn-outline-light"><i class="far fa-edit"></i></button>':'';
	}
	
	/**
	 * Operação responsavel por montar o botão de excluir da listagem
	 * @param Tela $tela
	 * @param boolean $excluir
	 * @param integer $id
	 * @return string
	 */
	protected function montarBtnDeletarLista($tela, $excluir = null, $id = null){
		return ($excluir)?'<button onclick="fcnModalDeleteId(this)" modal="question" id="'.$id.'" funcao="'.$tela->getBotaoListarExcluir()->getFuncao().'" controlador="'.$tela->getBotaoListarExcluir()->getControlador().'" retorno="div_central" mensagem="4" class="deleteId btn btn-sm btn-outline-light"><i class="far fa-trash-alt"></i></button>':'';
	}	
	//BLOCO MONTAR BOTAO ACAO FIM ***************************************************************
	
	//CRIAR CLASSES GERAL INICIO ***************************************************************
	
	/**
	 * Operação de criar botão ou link simplicado 
	 * @param String $controlador
	 * @param String $funcao
	 * @return BotaoLink
	 */
	protected function criarBotaoListarAcao($controlador, $funcao) {
		$btnLink = new BotaoLink ();
		$btnLink->setControlador ( $controlador );
		$btnLink->setFuncao ( $funcao );
		return $btnLink;
	}
	
	/**
	 * Operação de criar botão ou link passando todos os parametros necessarios 
	 * @param String $titulo
	 * @param String $acao
	 * @param String $controlador
	 * @param String $funcao
	 * @param String $retorno
	 * @param String $mensagem
	 * @return BotaoLink
	 */
	protected function criarBotaoLinkAcao($titulo, $acao, $controlador = null, $funcao = null, $retorno = null, $mensagem = null) {
		$btnLink = new BotaoLink ();
		$btnLink->setControlador ( $controlador );
		$btnLink->setFuncao ( $funcao );
		$btnLink->setMensagem ( $mensagem );
		$btnLink->setRetorno ( $retorno );
		$btnLink->setAcao ( $acao );
		$btnLink->setTitulo ( $titulo );
		return $btnLink;
	}
	
	/**
	 * Operação responsavel por criar a classe Tela
	 * @param String $controlador
	 * @param String $funcao
	 * @param String $retorno
	 * @param String $mensagem
	 * @param BotaoLink $btnVoltar
	 * @param BotaoLink $btnCadAlt
	 * @param String $titulo
	 * @param Campo[] $campos
	 * @return Tela
	 */
	protected function criarTela($controlador, $funcao, $retorno, $mensagem, $btnVoltar, $btnCadAlt, $titulo, $campos) {
		$tela = new Tela ();
		$tela->setControlador ( $controlador );
		$tela->setFuncao ( $funcao );
		$tela->setMensagem ( $mensagem );
		$tela->setRetorno ( $retorno );
		$tela->setTitulo ( $titulo );
		$tela->setCampos ( $campos );
		$tela->setBotaoRedirect ( $btnVoltar );
		$tela->setBotaoCadastrarAlterar ( $btnCadAlt );
		return $tela;
	}
	
	/**
	 * Operação responsavel por criar a classe Campo
	 * @param String $titulo
	 * @param String $nome
	 * @param String $tipo
	 * @param boolean $obrigatorio
	 * @param boolean $upperCase
	 * @return Campo
	 */
	protected function criarCampo($titulo, $nome, $tipo = null, $obrigatorio = null, $upperCase = null) {
		$campo = new Campo ();
		$campo->setTitulo ( $titulo );
		$campo->setNome ( $nome );
		$campo->setTipo( $tipo );
		$campo->setObrigatorio ( $obrigatorio );
		$campo->setUpperCase ( $upperCase );
		return $campo;
	}
	
	//CRIAR CLASSES GERAL FIM ***************************************************************
	
	//OPERACOES DE MONTATEGEM DE TELA INICIO ***************************************************************
	
	/**
	 * Operação responsavel por criar toda a tela de incluir e alterar padrão
	 * @param unknown $tela
	 * @param unknown $post
	 * @param string $view
	 * @param unknown $objeto
	 */
	protected function criarTelaManter($tela, $post, $view = false, $objeto = null){
		echo $this->montarGrowlUI($post);
		?>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">        
		        <form action="#" method="post" id="formCadastro" class="">
		            <?php echo $this->montarInputsForm($tela, $objeto); ?>
					<div class="card-header d-flex">
			            <h4 class="card-header-title"><?php echo $tela->getTitulo(); ?></h4>
			            <div class="toolbar ml-auto">
			            	<?php 
			            	echo $this->montarBotaoRedirect($tela, $this::BTN_SMALL_LIGHT);
		            		if(!$view){
								echo $this->montarBotaoCadastrarAlterar($tela);
		            		}
			            	?>			            	
			            </div>
		            </div>
		            <?php 
		            echo $this->montarInputs($tela, $objeto, $view);
				 	?>
				</form>
				</div>
			</div>
		</div>				
		<?php 
	}
	
	/**
	 * Operação responsavel por criar toda a tela de listagem padrão
	 * @param Tela $tela
	 * @param Object $objetos
	 * @param boolean $alterar
	 * @param boolean $excluir
	 */
	protected function criarTelaListar($tela, $objetos, $alterar = null, $excluir = null ){
		echo $this->montarInitDataTable();
		?>
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="card">        
				<div class="card-header d-flex">
		            <h4 class="card-header-title"><?php echo $tela->getTitulo(); ?></h4>
		            <div class="toolbar ml-auto">
		            	<?php 	echo $this->montarBotaoRedirect($tela, $this::BTN_SMALL_PRIMARY); ?>
		            </div>
		        </div>		
				<div class="card-body">
					<div class="table-responsive">
						<?php if($tela->getCampos()){ ?>
						<table id="example" class="tablesorter table table-striped table-bordered second" style="width:100%">
							<thead>
								<tr>
									<?php 
									foreach ($tela->getCampos() as $campoTh){
										echo '<th>'.$campoTh->getTitulo().'</th>';
									} 
									
									if($alterar || $excluir){
										echo '<th class="sorting_disabled" style="text-align: center;" >A&ccedil;&atilde;o</th>';
									}
									?> 
								</tr>
							</thead>								
							<?php   
							if ($objetos) {
								echo '<tbody>';
								foreach ($objetos as $objeto) {
									echo '<tr>';
									foreach ($tela->getCampos() as $campo){
										$method = 'get'.ucfirst($campo->getNome());
										if(method_exists(get_class($objeto), $method) ){
											if($campo->getTipo() == $this::CODIGO){
												echo '<td onclick="getId(this)" class="getId" style="cursor:pointer"  id="'.$objeto->getId().'" funcao="'.$tela->getBotaoListarVisualizar()->getFuncao().'" controlador="'.$tela->getBotaoListarVisualizar()->getControlador().'" retorno="div_central">'.str_pad($objeto->$method(), 5, "0", STR_PAD_LEFT).'</td>';
											}else{
												echo '<td onclick="getId(this)" class="getId" style="cursor:pointer"  id="'.$objeto->getId().'" funcao="'.$tela->getBotaoListarVisualizar()->getFuncao().'" controlador="'.$tela->getBotaoListarVisualizar()->getControlador().'" retorno="div_central">'.$objeto->$method().'</td>';
											}
										}										
									}
									echo $this->montarBtnAcaoListar($tela, $objeto->getId(), $alterar, $excluir);
									echo '</tr>';
		                        } 		                    
							echo '</tbody>';
							}   
		                    ?>         		
						</table>
						<?php } ?>
					</div>
				</div>
				</div>
			</div>
		</div>	
	<?php 
	}
	//OPERACOES DE MONTATEGEM DE TELA FIM ***************************************************************
}