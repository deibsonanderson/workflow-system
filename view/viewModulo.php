<?php

class ViewModulo extends ViewBase {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }
    
    const CONTROLADOR = 'ControladorModulo';
    const TELA_LISTAR = 'telaListarModulo';

    public function telaCadastrarModulo($post) {
    	
    	$tela = $this->criarTela (
    			$this::CONTROLADOR,
    			'incluirModulo',
    			$this::DIV_CENTRAL,
    			$this::MENSAGEM_UM,
    			$this->montarBtnVoltar($this::CONTROLADOR, $this::TELA_LISTAR),
    			$this->montarBotaoAcao($this::CADASTRAR),
    			'Cadatro Módulos',
    			array ( $this->criarCampo ( 'nome', 'nome', $this::TEXT, ViewBase::VERDADEIRO, ViewBase::VERDADEIRO ) ) );
    	return $this->criarTelaManter ( $tela, $post, ViewBase::FALSO );
    }

    public function telaListarModulo($objModulo) {
    	$campos = array (
    			$this->criarCampo ( 'Codigo', 'id', $this::CODIGO ),
    			$this->criarCampo ( 'Nome', 'nome', $this::TEXT ));
    	
    	$botoesListar = array($this->criarBotaoListarAcao($this::CONTROLADOR, 'telaAlterarModulo',$this::ALTERAR),
    			$this->criarBotaoListarAcao($this::CONTROLADOR, 'excluirModulo', $this::EXCLUIR),
    			$this->criarBotaoListarAcao($this::CONTROLADOR, 'telaVisualizarModulo', $this::VISUALIZAR));
    	
    	$tela = $this->criarTela (
    			$this::CONTROLADOR,
    			'incluirModulo',
    			$this::DIV_CENTRAL,
    			$this::MENSAGEM_UM,
    			$this->montarBtnNovo($this::CONTROLADOR, 'telaCadastrarModulo'),
    			$this->montarBotaoAcao($this::CADASTRAR),
    			'Modulos',
    			$campos,
    			$botoesListar);
    	
    	return $this->criarTelaListar( $tela, $objModulo, ViewBase::VERDADEIRO, ViewBase::VERDADEIRO );
    }

    public function telaAlterarModulo($objModulo) {
    	$tela = $this->criarTela (
    			$this::CONTROLADOR,
    			'alterarModulo',
    			$this::DIV_CENTRAL,
    			$this::MENSAGEM_DOIS,
    			$this->montarBtnVoltar($this::CONTROLADOR, $this::TELA_LISTAR),
    			$this->montarBotaoAcao($this::ALTERAR),
    			'Alterar Modelo',
    			array ( $this->criarCampo ( 'nome', 'nome', $this::TEXT, ViewBase::VERDADEIRO ) ) );
    	return $this->criarTelaManter ( $tela, $post, ViewBase::FALSO, $objModulo[0]);
    }

    public function telaVisualizarModulo($objModulo) {
    	$tela = $this->criarTela ( null, null, null, null,
    			$this->montarBtnVoltar($this::CONTROLADOR, $this::TELA_LISTAR), $this->montarBotaoAcao($this::ALTERAR),
    			'Visualizar Modulo', array ( $this->criarCampo ( 'nome', 'nome', $this::TEXT, ViewBase::VERDADEIRO ) ) );
    			return $this->criarTelaManter ( $tela, $post, ViewBase::VERDADEIRO, $objModulo[0]);
    }

}
?>