<?php

class ControladorAgenda {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }

    public function listarAgenda($post = null) {
        try {
            $daoAgenda = new DaoAgenda();
            $retorno = $daoAgenda->listarAgenda(desformataData($post["data"]));
            $daoAgenda->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
	
    public function visualiAgenda($post = null) {
        try {
            $daoAgenda = new DaoAgenda();
            $retorno = $daoAgenda->listarAgenda($post["data"],true);
            //$retorno = $daoAgenda->listarAgenda(desformataData($post["data"]),true);
            $daoAgenda->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }	

    public function incluirAgenda($post) {
        try {
            $agenda = new Agenda();
            $agenda->setDescricao($post["txt_descricao"]);
            $agenda->setArquivo($post["arquivo"]);
            $agenda->setLink($post["link"]);
            //date_default_timezone_set('America/Sao_Paulo');
            $agenda->setData(desformataData($post["txt_data_cad"]));
            $agenda->setStatus('1');
            $daoAgenda = new DaoAgenda();
            
            if ($daoAgenda->incluirAgenda($agenda)) {
                $postVisual = array("data" => $post["txt_data_cad"]);  
                return $this->telaVisualizarAgenda($postVisual);
            }
            $daoAgenda->__destruct();
        } catch (Exception $e) {
            return $e;
        }
    }
    
    public function alterarAgenda($post) {
        try {
            $agenda = new Agenda();
            $agenda->setId($post["id"]);
            $agenda->setAtivo($post["ativo"]);
            $daoAgenda = new DaoAgenda();
            if ($daoAgenda->alterarAgenda($agenda)) {
                $postVisual = array("data" => $post["txt_data_cad"]);  
                return $this->telaVisualizarAgenda($postVisual);
            }
            $daoAgenda->__destruct();
        } catch (Exception $e) {
            return $e;
        }
    }    

    public function ordernarAgenda($post) {
        try {
            $agenda = new Agenda();
            $agenda->setId($post["id"]);
            $agenda->setData(desformataData($post["txt_data_cad"]));
            $agenda->setStatus('1');
            $updateRecordsArray = $post['recordsArray'];
            $daoAgenda = new DaoAgenda();
            if ($daoAgenda->ordernarAgenda($agenda,$updateRecordsArray)) {
                $postVisual = array("data" => $post["txt_data_cad"]);  
                return $this->telaVisualizarAgenda($postVisual);
            }
            $daoAgenda->__destruct();
        } catch (Exception $e) {
            return $e;
        }
    } 
    
    public function excluirAgenda($post) {
        try {
            $id = $post["id"];
            $daoAgenda = new DaoAgenda();
            $daoAgenda->excluirAgenda($id);
            $daoAgenda->__destruct();
            return $this->telaListarAgenda();
        } catch (Exception $e) {
            return $e;
        }
    }

    public function telaCadastrarAgenda($post = null) {
        try {
            $viewAgenda = new ViewAgenda();
            $retorno = $viewAgenda->telaCadastrarAgenda($post);
            $viewAgenda->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    
    public function telaVisualizarAgenda($post = null) {
        try {
            $viewAgenda = new ViewAgenda();
            $retorno = $viewAgenda->telaVisualizarAgenda($this->visualiAgenda($post),$post["data"]);
            $viewAgenda->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
	
	
    public function telaListarAgenda($post = null) {
        try {
            $viewAgenda = new ViewAgenda();
            $retorno = $viewAgenda->telaListarAgenda($this->listarAgenda(null));
            $viewAgenda->__destruct();
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }	

}

?>