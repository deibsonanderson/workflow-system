<?php

class DaoAtividade extends Dados {

    //construtor
    public function __construct() {
        
    }

    //destruidor
    public function __destruct() {
        
    }
    
    public function listarDistinctAtividade() {
    	try {
    		$retorno = array();
    		$conexao = $this->ConectarBanco();
    		$sql = "SELECT DISTINCT id,titulo FROM tb_workflow_atividade WHERE status = '1' AND id_usuario = " . $_SESSION["login"]->getId();
    		$query = mysqli_query($conexao,$sql) or die('Erro na execução  do listar!');
    		while ($objetoAtividade = mysqli_fetch_object($query)) {
    			$atividade = new Atividade();
    			$atividade->setId($objetoAtividade->id);
    			$atividade->setTitulo($objetoAtividade->titulo);
    			$retorno[] = $atividade;
    		}
    		$this->FecharBanco($conexao);
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }
    
    public function listarAtividade($id = null, $id_usuario = null, $pag = null) {
        try {
            $retorno = array();
            $paginado = new stdClass();
            
            $conexao = $this->ConectarBanco();
            $sql = "SELECT a.id,a.titulo,a.descricao,a.link,a.arquivo,a.imagem,a.valor,a.propriedade,a.status,
                    a.id_categoria,LPAD(a.vencimento, 2, 0) as vencimento,c.nome as nome_categoria, c.status as status_categoria 
					FROM tb_workflow_atividade a 
					INNER JOIN tb_workflow_categoria_atividade c ON (a.id_categoria = c.id)
					WHERE a.status = '1' ";
			$sql .= ($id_usuario != null) ? " AND a.id_usuario = " . $id_usuario : "";
            $sql .= ($id != null) ? " AND a.id = " . $id : "";
            /*if($pag != null){
            	$cmd = "select * from tb_workflow_atividade a INNER JOIN tb_workflow_categoria_atividade c ON (a.id_categoria = c.id) WHERE a.status = '1' AND a.id_usuario = " . $id_usuario;
            	$total = mysqli_num_rows(mysqli_query($conexao, $cmd));
            	$registros = 10;
            	$numPaginas = ceil($total/$registros);
            	$inicio = ($registros*$pag)-$registros; 
            	$sql .=  " LIMIT $inicio,$registros ";
            }*/
            
            $query = mysqli_query($conexao,$sql) or die('Erro na execução  do listar!');
            while ($objetoAtividade = mysqli_fetch_object($query)) {
                $atividade = new Atividade();
                $atividade->setId($objetoAtividade->id);
                $atividade->setTitulo($objetoAtividade->titulo);
                $atividade->setStatus($objetoAtividade->status);
                $atividade->setDescricao($objetoAtividade->descricao);
                $atividade->setLink($objetoAtividade->link);
                $atividade->setArquivo($objetoAtividade->arquivo);
                $atividade->setImagem($objetoAtividade->imagem);                
                $atividade->setValor($objetoAtividade->valor);
                $atividade->setPropriedade($objetoAtividade->propriedade);
                $atividade->setVencimento($objetoAtividade->vencimento);
                
                
                $categoria = new CategoriaAtividade();
                $categoria->setId($objetoAtividade->id_categoria);
                $categoria->setNome($objetoAtividade->nome_categoria);
                $categoria->setStatus($objetoAtividade->status_categoria);
                $atividade->setCategoria($categoria);

                $retorno[] = $atividade;
            }            
            $this->FecharBanco($conexao);
            
            $paginado->retorno = $retorno;
            $paginado->numPaginas = $numPaginas;
            $paginado->registros = $registros;
            $paginado->total = $total;
            $paginado->inicio = $inicio;
            
            return $paginado;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    
    public function listarAtividadeByCategoria($id = null, $id_usuario = null) {
    	try {
    		$retorno = array();
    		$conexao = $this->ConectarBanco();
    		$sql = "SELECT id,titulo,descricao,link,arquivo,imagem,valor,propriedade,status,id_categoria,vencimento FROM tb_workflow_atividade WHERE status = '1' ";
			$sql .= ($id_usuario != null) ? " AND id_usuario = " . $id_usuario : "";
    		$sql .= ($id != null) ? " AND id_categoria = " . $id : "";
    		
    		$query = mysqli_query($conexao,$sql) or die('Erro na execução  do listar!');
    		while ($objetoAtividade = mysqli_fetch_object($query)) {
    			$atividade = new Atividade();
    			$atividade->setId($objetoAtividade->id);
    			$atividade->setTitulo($objetoAtividade->titulo);
    			$atividade->setStatus($objetoAtividade->status);
    			$atividade->setDescricao($objetoAtividade->descricao);
    			$atividade->setLink($objetoAtividade->link);
    			$atividade->setArquivo($objetoAtividade->arquivo);
    			$atividade->setImagem($objetoAtividade->imagem);
    			$atividade->setValor($objetoAtividade->valor);
    			$atividade->setPropriedade($objetoAtividade->propriedade);
    			$atividade->setCategoria($objetoAtividade->id_categoria);
    			$atividade->setVencimento($objetoAtividade->vencimento);
    			
    			$retorno[] = $atividade;
    		}
    		$this->FecharBanco($conexao);
    		return $retorno;
    	} catch (Exception $e) {
    		return $e;
    	}
    }

    public function incluirAtividade($atividade) {
        try {
            $conexao = $this->ConectarBanco();
            $sql = "INSERT INTO tb_workflow_atividade(titulo,imagem,arquivo, descricao,link, valor, propriedade,id_categoria,id_usuario,vencimento, status) VALUES ('" . $atividade->getTitulo() . "','" . $atividade->getImagem() . "','" . $atividade->getArquivo() . "','" . $atividade->getDescricao() . "','"  . $atividade->getLink() . "','" . $atividade->getValor() . "','" . $atividade->getPropriedade() . "','" . $atividade->getCategoria() . "','" . $atividade->getUsuario()->getId() . "','" . $atividade->getVencimento() . "','" . $atividade->getStatus() . "')";
            $retorno = mysqli_query($conexao,$sql) or die('Erro na execução  do insert!');
            $this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function alterarAtividade($atividade) {
        try {
            $conexao = $this->ConectarBanco();
            $sql = "UPDATE tb_workflow_atividade SET vencimento = '" . $atividade->getVencimento() . "', titulo = '" . $atividade->getTitulo() . "', valor = '" . $atividade->getValor() . "', propriedade = '" . $atividade->getPropriedade() . "', link = '" . $atividade->getLink() . "', imagem = '" . $atividade->getImagem() . "', arquivo = '" . $atividade->getArquivo() . "', descricao = '" . $atividade->getDescricao() . "', id_categoria = '" . $atividade->getCategoria() . "',status = '" . $atividade->getStatus() . "' WHERE id =" . $atividade->getId() . "";
            $retorno = mysqli_query($conexao,$sql) or die('Erro na execução  do update!');
            $this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function excluirAtividade($id) {
        try {
            $conexao = $this->ConectarBanco();

            $sql = "UPDATE tb_workflow_atividade SET status = '0' WHERE id = " . $id . "";
            $retorno = mysqli_query($conexao,$sql) or die('Erro na execução  do delet atividade!');

            $this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
    
    
    public function buscarAtividade($id = null, $id_usuario = null) {
        try {
            $retorno = array();
            $conexao = $this->ConectarBanco();
            $sql = "SELECT a.id,a.titulo,a.descricao,a.link,a.arquivo,a.imagem,a.valor,a.propriedade,a.status,LPAD(a.vencimento, 2, 0) as vencimento,
                    a.id_categoria,c.nome as nome_categoria, c.status as status_categoria 
					FROM tb_workflow_atividade a 
					INNER JOIN tb_workflow_categoria_atividade c ON (a.id_categoria = c.id) ";
			$sql .= ($id_usuario != null) ? " AND a.id_usuario = " . $id_usuario : "";		
            $sql .= ($id != null) ? " WHERE a.id = " . $id : "";
            $query = mysqli_query($conexao,$sql) or die('Erro na execução  do listar!');
            while ($objetoAtividade = mysqli_fetch_object($query)) {
                $atividade = new Atividade();
                $atividade->setId($objetoAtividade->id);
                $atividade->setTitulo($objetoAtividade->titulo);
                $atividade->setStatus($objetoAtividade->status);
                $atividade->setDescricao($objetoAtividade->descricao);
                $atividade->setLink($objetoAtividade->link);
                $atividade->setArquivo($objetoAtividade->arquivo);
                $atividade->setImagem($objetoAtividade->imagem);		
                $atividade->setValor($objetoAtividade->valor);
                $atividade->setPropriedade($objetoAtividade->propriedade);
                $atividade->setVencimento($objetoAtividade->vencimento);
                
                $categoria = new CategoriaAtividade();
                $categoria->setId($objetoAtividade->id_categoria);
                $categoria->setNome($objetoAtividade->nome_categoria);
                $categoria->setStatus($objetoAtividade->status_categoria);
                $atividade->setCategoria($categoria);
                
                $retorno[] = $atividade;
            }            
            $this->FecharBanco($conexao);
            return $retorno;
        } catch (Exception $e) {
            return $e;
        }
    }
    

}

?>