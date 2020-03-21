<?php

class DaoAtividade extends DaoBase {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }
    
    public function listarDistinctAtividade() {
    	try {
    		return $this->executarQuery(
    				$this->sqlSelect(DaoBase::TABLE_ATIVIDADE, array('id', 'titulo'), true).    				
    				$this->montarIdUsuario($_SESSION["login"]->getId()),'Atividade');
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function listarAtividade($id = null, $id_usuario = null, $pag = null) {
        try {
            $retorno = array();
            $paginado = new stdClass();
            /* TODO prototipo de paginacao
            if($pag != null){
            	$cmd = "select * from tb_workflow_atividade a INNER JOIN tb_workflow_categoria_atividade c ON (a.id_categoria = c.id) WHERE a.status = '1' AND a.id_usuario = " . $id_usuario;
            	$total = mysqli_num_rows(mysqli_query($conexao, $cmd));
            	$registros = 10;
            	$numPaginas = ceil($total/$registros);
            	$inicio = ($registros*$pag)-$registros; 
            	$sql .=  " LIMIT $inicio,$registros ";
            }*/
            
            $paginado->retorno = $this->mountarListarQueryAtividade(
            		$this->executar($this->mountarSQLQueryAtividade($id, $id_usuario, true)));
            /* TODO prototipo de paginacao
             $paginado->numPaginas = $numPaginas;
             $paginado->registros = $registros;
             $paginado->total = $total;
             $paginado->inicio = $inicio;
            */
            return $paginado;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    
    public function listarAtividadeByCategoria($id = null, $id_usuario = null) {
    	try {
    		$sql = ($id != null) ? " AND id_categoria = " . $id : "";
			$sql .= " ORDER BY vencimento ASC ";
    		return $this->executarQuery($this->sqlSelect(DaoBase::TABLE_ATIVIDADE, 
    						array('id', 'titulo','descricao','link','arquivo','imagem','valor','fixa','propriedade','status','id_categoria','vencimento'), 
    						false).$this->montarIdUsuario($id_usuario).$sql, 'Atividade');
    	} catch (Exception $e) {
    		return $e;
    	}
    }

    public function incluirAtividade($atividade) {
        try {
            return $this->executar("INSERT INTO ".DaoBase::TABLE_ATIVIDADE."(titulo,imagem,arquivo, descricao,link, valor, propriedade,id_categoria,id_usuario,vencimento,fixa, status) VALUES ('" . $atividade->getTitulo() . "','" . $atividade->getImagem() . "','" . $atividade->getArquivo() . "','" . $atividade->getDescricao() . "','"  . $atividade->getLink() . "','" . $atividade->getValor() . "','" . $atividade->getPropriedade() . "','" . $atividade->getCategoria() . "','" . $atividade->getUsuario()->getId() . "','" . $atividade->getVencimento() . "','" . $atividade->getFixa() . "','" . $atividade->getStatus() . "')");
        } catch (Exception $e) {
            return $e;
        }
    }

    public function alterarAtividade($atividade) {
        try {
            return $this->executar("UPDATE ".DaoBase::TABLE_ATIVIDADE." SET vencimento = '" . $atividade->getVencimento() . "', fixa = '" . $atividade->getFixa() . "', titulo = '" . $atividade->getTitulo() . "', valor = '" . $atividade->getValor() . "', propriedade = '" . $atividade->getPropriedade() . "', link = '" . $atividade->getLink() . "', imagem = '" . $atividade->getImagem() . "', arquivo = '" . $atividade->getArquivo() . "', descricao = '" . $atividade->getDescricao() . "', id_categoria = '" . $atividade->getCategoria() . "',status = '" . $atividade->getStatus() . "' WHERE id =" . $atividade->getId() . "");
        } catch (Exception $e) {
            return $e;
        }
    }

    public function excluirAtividade($id) {
        try {
            return $this->executar($this->sqlExcluir(DaoBase::TABLE_ATIVIDADE, $id));
        } catch (Exception $e) {
            return $e;
        }
    }
    
    
    public function buscarAtividade($id = null, $id_usuario = null) {
        try {
            return  $this->mountarListarQueryAtividade(
            			$this->executar($this->mountarSQLQueryAtividade($id, $id_usuario, false)));
        } catch (Exception $e) {
            return $e;
        }
    }
    
    private function mountarSQLQueryAtividade($id = null, $id_usuario = null,$isAtivo = true){
    	$sql = "SELECT a.id,a.titulo,a.descricao,a.link,a.arquivo,a.imagem,a.valor,a.propriedade,a.status,LPAD(a.vencimento, 2, 0) as vencimento,
                    a.id_categoria,a.fixa,c.nome as nome_categoria, c.status as status_categoria
					FROM ".DaoBase::TABLE_ATIVIDADE." a
					INNER JOIN ".DaoBase::TABLE_CATEGORIA_ATIVIDADE." c ON (a.id_categoria = c.id) WHERE a.id IS NOT NULL ";
    	if($isAtivo === true){
    		$sql .= " AND a.status = '1' ";
    	}
    	return $sql.$this->montarId($id, 'a').$this->montarIdUsuario($id_usuario, 'a');
    }
    
    private function mountarListarQueryAtividade($query){
    	$retorno = array();
    	while ($objetoAtividade = mysqli_fetch_object($query)) {
    		$atividade = $this->modelMapper($objetoAtividade, new Atividade());
    		
    		$categoria = new CategoriaAtividade();
    		$categoria->setId($objetoAtividade->id_categoria);
    		$categoria->setNome($objetoAtividade->nome_categoria);
    		$categoria->setStatus($objetoAtividade->status_categoria);
    		$atividade->setCategoria($categoria);
    		
    		$retorno[] = $atividade;
    	}
    	return $retorno;
    }

}

?>