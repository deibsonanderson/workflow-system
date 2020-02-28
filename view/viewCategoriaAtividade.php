<?php

class ViewCategoriaAtividade extends ViewBase {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }
    
    const CONTROLADOR = 'ControladorCategoriaAtividade';
    const TELA_LISTAR = 'telaListarCategoriaAtividade';
    

    public function telaCadastrarCategoriaAtividade($post) {
    	$tela = $this->criarTela ( 
    			$this::CONTROLADOR, 
    			'incluirCategoriaAtividade', 
    			$this::DIV_CENTRAL, 
    			$this::MENSAGEM_UM, 
    			$this->montarBtnVoltar($this::CONTROLADOR, $this::TELA_LISTAR), 
    			$this->montarBotaoAcao($this::CADASTRAR), 
    			'Cadatro Categoria', 
    			array ( $this->criarCampo ( 'nome', 'nome', $this::TEXT, ViewBase::VERDADEIRO ) ) );
				return $this->criarTelaManter ( $tela, $post, ViewBase::FALSO );
    }

    public function telaListarCategoriaAtividade($objCategoriaAtividade) {
    	$campos = array ( 
    			$this->criarCampo ( 'Codigo', 'id', $this::CODIGO ),
    			$this->criarCampo ( 'Descrição', 'nome', $this::TEXT ));
    	
    	$botoesListar = array($this->criarBotaoListarAcao($this::CONTROLADOR, 'telaAlterarCategoriaAtividade',$this::ALTERAR),
    			$this->criarBotaoListarAcao($this::CONTROLADOR, 'excluirCategoriaAtividade', $this::EXCLUIR),
    			$this->criarBotaoListarAcao($this::CONTROLADOR, 'telaVisualizarCategoriaAtividade', $this::VISUALIZAR));
    	
    	$tela = $this->criarTela (
    			$this::CONTROLADOR,
    			'incluirCategoriaAtividade',
    			$this::DIV_CENTRAL,
    			$this::MENSAGEM_UM,    			
    			$this->montarBtnNovo($this::CONTROLADOR, 'telaCadastrarCategoriaAtividade'),
    			$this->montarBotaoAcao($this::CADASTRAR),
    			'Categorias',
    			$campos,
    			$botoesListar);
    	
    	return $this->criarTelaListar( $tela, $objCategoriaAtividade, ViewBase::VERDADEIRO, ViewBase::VERDADEIRO );
    	
    }

    public function telaAlterarCategoriaAtividade($objCategoriaAtividade) {
    	$tela = $this->criarTela ( 
    			$this::CONTROLADOR, 
    			'alterarCategoriaAtividade', 
    			$this::DIV_CENTRAL,
    			$this::MENSAGEM_DOIS,
    			$this->montarBtnVoltar($this::CONTROLADOR, $this::TELA_LISTAR), 
    			$this->montarBotaoAcao($this::ALTERAR),
    			'Alterar Categoria', 
    			array ( $this->criarCampo ( 'nome', 'nome', $this::TEXT, ViewBase::VERDADEIRO ) ) );
    			return $this->criarTelaManter ( $tela, $post, ViewBase::FALSO, $objCategoriaAtividade[0]);
    }

    public function telaVisualizarCategoriaAtividade($objCategoriaAtividade) {
    	$tela = $this->criarTela ( null, null, null, null,
    			$this->montarBtnVoltar($this::CONTROLADOR, $this::TELA_LISTAR), $this->montarBotaoAcao($this::ALTERAR),
    			'Visualizar Categoria', array ( $this->criarCampo ( 'nome', 'nome', $this::TEXT, ViewBase::VERDADEIRO ) ) );
    			return $this->criarTelaManter ( $tela, $post, ViewBase::VERDADEIRO, $objCategoriaAtividade[0]);
    }

}
?>