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
	const VISUALIZAR = 'Visualizar';
	const EXCLUIR = 'Excluir';
	
	//input types
	const CODIGO = 'id';
	const TEXT = 'text';
	const TEXT_AREA = 'textarea';
	const LISTAGEM = 'listagem';
	
	/**
	 * Operacao responsavel por montar o script batão de informacao de growlUI2
	 * @param $_POST $post
	 * @return string
	 */
	protected function montarGrowlUI($post){
        return ($post) ? "<script type='text/javascript'>$.growlUI2('" . $post . "', '&nbsp;');</script>" : "";
	}
	
	/**
	 * Operacao responsavelp por carregar o asteristico para campos obrigatorios conforme definido em cada objeto campo.
	 * @param Campo $campo
	 * @return string
	 */
	protected function getAsterisco($campo) {
		return ($campo->getObrigatorio ()) ? ' *' : '';
	}
	
	/**
	 * Operacao responsavelp por carregar a classe css mgs_alerta para campos obrigatorios conforme definido em cada objeto campo.
	 * @param Campo $campo
	 * @return string
	 */
	protected function getMgsAlerta($campo) {
		return ($campo->getObrigatorio ()) ? ' mgs_alerta ' : '';
	}
	
	/**
	 * Operacao responsavel por montar o script de aumentativo conforme definido em cada objeto campo
	 * @param Campo $campo
	 * @return string
	 */
	protected function getUpperCase($campo) {
		return ($campo->getUpperCase ()) ? ' onkeyup="this.value=this.value.toUpperCase();" ' : '';
	}
	
	/**
	 * Operacao responsavel por montar o botão de acao cadastrar ou alterar
	 * @param String $titulo
	 * @return BotaoLink
	 */
	protected  function montarBotaoAcao($titulo){
		return $this->criarBotaoLinkAcao ( $titulo, 'onclick="fncFormCadastro(this)"' );
	}
	
	/**
	 * Operacao responsavel por criar campos que redirecionar para a pagina anterior no topo da pagina
	 * @param String $controlador
	 * @param String $funcao
	 * @return BotaoLink
	 */
	protected function montarBtnVoltar($controlador, $funcao){
		return $this->criarBotaoLinkAcao ( 'Voltar', 'onclick="fncButtonCadastro(this)"', $controlador, $funcao, $this::DIV_CENTRAL );
	}
	
	/**
	 * Operacao responsavel por criar campos que redirecionar para a cada de cadastrar no topo da pagina
	 * @param String $controlador
	 * @param String $funcao
	 * @return BotaoLink
	 */
	protected function montarBtnNovo($controlador, $funcao){
		return $this->criarBotaoLinkAcao ( 'Novo', 'onclick="fncButtonCadastro(this)"', $controlador, $funcao, $this::DIV_CENTRAL );
	}
		
	/**
	 * Operacao responsavel por montar os botão de redirecionamento Ex: voltar, novo, etc.
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
	 * Operacao responsavel por montar o botão cadastrar ou alterar padrão do formulario
	 * @param unknown $tela
	 * @return string
	 */
	protected function montarBotaoCadastrarAlterar($tela){
		if($tela->getBotaoCadastrarAlterar()){
			return '<a href="#" '.$tela->getBotaoCadastrarAlterar()->getAcao().' class="btn btn-primary btn-sm formCadastro">'.$tela->getBotaoCadastrarAlterar()->getTitulo().'</a>';
		}
	}
	
	/**
	 * Operacao responsavel por montar os inputs padrão dos forms
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
	 * Operacao responsavel por inicializar o script das tabelas
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
	 * Operacao responsavel por montar os inputs que serão exibidos na tela de manter
	 * @param Tela $tela - informações que iram compor a tela, onde tera um array de campos com seus respectivos tipos e valores
	 * @param Object $objeto - objeto que sera carregado ex: update e view
	 * @param boolean $view - booleano responsavel por informar se a tela é update ou view
	 * @return string
	 */
	protected function montarInputs($tela, $objeto, $view, $id = null){
		$inputs = '';
		foreach ($tela->getCampos() as $campo) {
			$inputs .= $this->checkTipoInput($campo, $objeto, $view, $id);
		}
		return $inputs;
	}
	
	/**
	 * Operacao responsavel por checar qual o tipo do input sera carregado no momento.
	 * @param Campo $campo
	 * @param Object $objeto
	 * @param boolean $view
	 * @return string
	 */
	protected function checkTipoInput($campo, $objeto, $view, $id = null){
		if ($campo->getTipo() == $this::TEXT_AREA) {
			return 'TODO';
		} else if ($campo->getTipo() == $this::LISTAGEM) {
			return $this->montarSelectBasico($campo, $id, $view);
		} else if ($campo->getTipo() == $this::TEXT){
			return $this->montarInputText($campo, $objeto, $view);
		}
	}
	
	/**
	 * Operacao responsavel por montar campos input do tipo text
	 * @param Campo $campo
	 * @param Object $objeto
	 * @param boolean $view
	 * @return string
	 */
	protected function montarInputText($campo, $objeto, $view){
		if($objeto){
			if($campo->getAtribudo()){
				$method = 'get'.ucfirst($campo->getAtribudo());
			}else{
				$method = 'get'.ucfirst($campo->getNome());
			}			
			if(method_exists(get_class($objeto), $method)){
				$valor = $objeto->$method();
			}
		}
		
		$disabled = ($view)?'disabled="disabled"':'';
		
		return '
								<div class="form-group">
									<label for="'.strtolower($campo->getTitulo()).'" class="col-form-label">'.ucfirst($campo->getTitulo()).$this->getAsterisco($campo).' </label>
									<input id="'.strtolower($campo->getNome()).'" name="'.strtolower($campo->getNome()).'" type="text" value="'.$valor.'" '.$disabled.' class="form-control '.$this->getMgsAlerta($campo).'" '.$this->getUpperCase($campo).'>
								</div>';
	}
	
	/**
	 * Operacao responsavel por montar campos input select baico de um objeto relacionado
	 * @param unknown $campo
	 * @param unknown $id
	 * @param unknown $view
	 * @return string
	 */	
	function montarSelectBasico($campo, $id, $view = null){
		$disabled = ($view)?' disabled="disabled" ':'';
		$html = '<div class="form-group">
                      <label for="modulo">'.ucfirst($campo->getTitulo()).$this->getAsterisco($campo).'</label>
					  <select id="'.strtolower($campo->getNome()).'" name="'.strtolower($campo->getNome()).'" '.$disabled.' class="'.$this->getMgsAlerta($campo).' form-control">
					  		<option value="">Selecione...</option>';
							$controlador = $campo->getControlador();
							$funcao = $campo->getFuncao();
							
							$c = new $controlador();
							$objeto = $c->$funcao();

							$atributo = 'get'.ucfirst($campo->getAtribudo());
							foreach ($objeto as $objeto){
								$selected = ($objeto->getId() == $id)?' selected="selected" ':'';
								$html .= '<option value="'.$objeto->getId().'" '.$selected.' >'.$objeto->$atributo().'</option>';
							}
		
		$html .= ' 	  </select>
				 </div>';
		return $html;
	}
	
	//BLOCO MONTAR INPUTS GERAIS FIM ***************************************************************
	
	//BLOCO MONTAR BOTAO ACAO INICIO ***************************************************************
	/**
	 * Operacao responsavel por montar os botões de acao na listagens
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
						'.$this->montarBtnAlterarLista($tela, $id).$this->montarBtnDeletarLista($tela, $id).'
						</div>
					</td>';
		}
		return $html;
	}
	
	/**
	 * Operacao responsavel por montar o botão de alterar da listagem
	 * @param Tela $tela
	 * @param integer $id
	 * @return string
	 */
	protected function montarBtnAlterarLista($tela, $id = null){
		if($tela->getBotoesListar()){
			foreach ($tela->getBotoesListar() as $botaoLink){
				if($botaoLink->getTipo() == $this::ALTERAR){
					return '<button onclick="getId(this)" id="'.$id.'" funcao="'.$botaoLink->getFuncao().'" controlador="'.$botaoLink->getControlador().'" retorno="div_central" class="getId btn btn-sm btn-outline-light"><i class="far fa-edit"></i></button>';
				}
			}
		}
	}
	
	/**
	 * Operacao responsavel por montar o botão de excluir da listagem
	 * @param Tela $tela
	 * @param integer $id
	 * @return string
	 */
	protected function montarBtnDeletarLista($tela, $id = null){
		if($tela->getBotoesListar()){
			foreach ($tela->getBotoesListar() as $botaoLink){
				if($botaoLink->getTipo() == $this::EXCLUIR){
					return '<button onclick="fcnModalDeleteId(this)" modal="question" id="'.$id.'" funcao="'.$botaoLink->getFuncao().'" controlador="'.$botaoLink->getControlador().'" retorno="div_central" mensagem="4" class="deleteId btn btn-sm btn-outline-light"><i class="far fa-trash-alt"></i></button>';
				}
			}
		}
	}	
	//BLOCO MONTAR BOTAO ACAO FIM ***************************************************************
	
	//CRIAR CLASSES GERAL INICIO ***************************************************************
	
	/**
	 * Operacao de criar botão ou link simplicado 
	 * @param String $controlador
	 * @param String $funcao
	 * @return BotaoLink
	 */
	protected function criarBotaoListarAcao($controlador, $funcao, $tipo = null) {
		$btnLink = new BotaoLink ();
		$btnLink->setControlador ( $controlador );
		$btnLink->setFuncao ( $funcao );
		$btnLink->setTipo($tipo);
		return $btnLink;
	}
	
	/**
	 * Operacao de criar botão ou link passando todos os parametros necessarios 
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
	 * Operacao responsavel por criar a classe Tela
	 * @param String $controlador
	 * @param String $funcao
	 * @param String $retorno
	 * @param String $mensagem
	 * @param BotaoLink $btnVoltar
	 * @param BotaoLink $btnCadAlt
	 * @param String $titulo
	 * @param Campo[] $campos
	 * @param BotaoLink[] $botoesListar;
	 * @return Tela
	 */
	protected function criarTela($controlador, $funcao, $retorno, $mensagem, $btnVoltar, $btnCadAlt, $titulo, $campos, $botoesListar = null) {
		$tela = new Tela ();
		$tela->setControlador ( $controlador );
		$tela->setFuncao ( $funcao );
		$tela->setMensagem ( $mensagem );
		$tela->setRetorno ( $retorno );
		$tela->setTitulo ( $titulo );
		$tela->setCampos ( $campos );
		$tela->setBotaoRedirect ( $btnVoltar );
		$tela->setBotaoCadastrarAlterar ( $btnCadAlt );
		$tela->setBotoesListar($botoesListar);
		return $tela;
	}
	
	/**
	 * Operacao responsavel por criar a classe Campo
	 * @param String $titulo
	 * @param String $nome
	 * @param String $tipo
	 * @param boolean $obrigatorio
	 * @param boolean $upperCase
	 * @return Campo
	 */
	protected function criarCampo($titulo, $nome, $tipo = null, $obrigatorio = null, $upperCase = null, $atributo = null) {
		$campo = new Campo ();
		$campo->setTitulo ( $titulo );
		$campo->setNome ( $nome );
		$campo->setTipo( $tipo );
		$campo->setObrigatorio ( $obrigatorio );
		$campo->setUpperCase ( $upperCase );
		$campo->setAtributo($atributo);
		return $campo;
	}
	
	//CRIAR CLASSES GERAL FIM ******************************************************************************
	
	//BLOCO MONTAR TABLES GERAIS INICIO ********************************************************************
	
	/**
	 * Operacao responsavel por carregar o cabecalho das tabelas
	 * @param Tela $tela
	 * @param boolean $alterar
	 * @param boolean $excluir
	 * @return string
	 */
	protected function montarTabelaHead($tela, $alterar = null, $excluir = null){
		$html = '<thead><tr>';
		
		foreach ($tela->getCampos() as $campo){
			$html .= '<th>'.$campo->getTitulo().'</th>';
		}
		
		if($alterar || $excluir){
			$html .= '<th class="sorting_disabled" style="text-align: center;" >A&ccedil;&atilde;o</th>';
		}
		
		return $html .= '</tr></thead>';
	}
	
	/**
	 * Operacao responsavel por carregar o corpo das tabelas
	 * @param Tela $tela
	 * @param Object $objetos
	 * @param boolean $alterar
	 * @param boolean $excluir
	 * @return string
	 */
	protected function montarTabelaCorpo($tela, $objetos, $alterar = null, $excluir = null ){
		$html = '';
		if ($objetos) {
			$html .= '<tbody>';
			foreach ($objetos as $objeto) {
				$html .= '<tr>';
				foreach ($tela->getCampos() as $campo){
					$method = 'get'.ucfirst($campo->getNome());
					if(method_exists(get_class($objeto), $method) ){
						if($campo->getTipo() == $this::CODIGO){
							$html .= '<td '.$this->montarTdVisualizar($id, $tela).' >'.str_pad($objeto->$method(), 5, "0", STR_PAD_LEFT).'</td>';
						}else{
							$html .= '<td '.$this->montarTdVisualizar($id, $tela).' >'.$objeto->$method().'</td>';
						}
					}
				}
				$html .= $this->montarBtnAcaoListar($tela, $objeto->getId(), $alterar, $excluir);
				$html .= '</tr>';
			}
			$html .= '</tbody>';
		}
		return $html;
	}
	
	protected function montarTdVisualizar($id, $tela ){
		if($tela->getBotoesListar()){
			foreach ($tela->getBotoesListar() as $botaoLink){
				if($botaoLink->getTipo() == $this::VISUALIZAR){
					return 'onclick="getId(this)" class="getId" style="cursor:pointer"  id="'.$id.'" funcao="'.$botaoLink->getFuncao().'" controlador="'.$botaoLink->getControlador().'" retorno="div_central"';
				}
			}
		}
	}
	
	//BLOCO MONTAR TABLES GERAIS FIM ***********************************************************************
	
	
	//OPERACOES DE MONTATEGEM DE TELA INICIO ***************************************************************
	
	/**
	 * Operacao responsavel por criar toda a tela de incluir e alterar padrão
	 * @param Table $tela
	 * @param $_POST $post
	 * @param string $view
	 * @param unknown $objeto
	 */
	protected function criarTelaManter($tela, $post, $view = false, $objeto = null, $id = null){
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
		            <div class="card-body">
		            <?php 
		            echo $this->montarInputs($tela, $objeto, $view, $id);
				 	?>
				 	</div>
				</form>
				</div>
			</div>
		</div>				
		<?php 
	}
	
	/**
	 * Operacao responsavel por criar toda a tela de listagem padrão
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
								<?php 
									echo $this->montarTabelaHead($tela, $alterar, $excluir); 
									echo $this->montarTabelaCorpo($tela, $objetos, $alterar, $excluir);
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