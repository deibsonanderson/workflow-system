<?php
abstract class DaoBase {
	
	/**
	 * Tabelas
	 */
	const TABLE_CATEGORIA_ATIVIDADE = 'tb_workflow_categoria_atividade';
	
	/**
	 * Paramentros de configuração do banco de dados
	 */
 	private $local = 'localhost';
 	private $usuario = 'root';
 	private $senha = '';
 	private $banco = 'workflow';
	
	protected function __construct() {
	}
	
	protected function __destruct() {
	}
	
	/**
	 * Operação responsavel por abrir a conexão
	 * @return unknown
	 */
	protected function conectarBanco() {
		try {
			$conexao = mysqli_connect ( $this->local, $this->usuario, $this->senha );
			mysqli_set_charset ( $conexao, 'utf8' );
		} catch ( Exception $e ) {
			echo 'Não foi possível conectar ao banco de dados - error:' . $e;
		}
		try {
			mysqli_select_db ( $conexao, $this->banco );
		} catch ( Exception $e ) {
			echo 'Não foi possível selecionar o banco de dados - error:' . $e . getMessage ();
		}
		return $conexao;
	}
	
	/**
	 * Operação responsavel por fechar a conexão
	 * @param unknown $conexao
	 */
	protected function fecharBanco($conexao) {
		try {
			mysqli_close ( $conexao );
		} catch ( Exception $e ) {
			echo 'Não foi possível fechar a conexão ao banco de dados - error:' . $e . getMessage ();
		}
	}
	
	/**
	 * Operação responsavel por execução das querys
	 * @param unknown $sql
	 * @return unknown
	 */
	protected function executar($sql) {
		try {
			$conexao = $this->ConectarBanco ();
			$retorno = mysqli_query ( $conexao, $sql );
			$this->FecharBanco ( $conexao );
		} catch ( Exception $e ) {
			echo 'Não foi possível executar a operação - error:' . $e . getMessage ();
		}
		return $retorno;
	}

	/**
	 * Essa operação serve para complementar uma checagem do id
	 * @param unknown $id
	 * @param string $schema
	 * @return string
	 */
	protected function montarId($id, $schema = '') {
		try {
			$schema = ($schema != '') ? $schema . '.' : $schema;
			return ($id == null || $id == '') ? '' : ' AND ' . $schema . 'id = ' . $id;
		} catch ( Exception $e ) {
			echo 'Erro na operção checaId - error:' . $e . getMessage ();
		}
	}
	
	/**
	 * Essa operação serve para complementar uma checagem do id do usuario
	 * @param unknown $id_usuario
	 * @param string $schema
	 * @return string
	 */
	protected function montarIdUsuario($id_usuario, $schema = '') {
		try {
			$schema = ($schema != '') ? $schema . '.' : $schema;
			return ($id_usuario == null || $id_usuario == '') ? '' : ' AND ' . $schema . 'id_usuario = ' . $id_usuario;
		} catch ( Exception $e ) {
			echo 'Erro na operção checaIdUsuario - error:' . $e . getMessage ();
		}
	}
	
	/**
	 * Operação responsavel por converter um objeto simples em uma classe simples.
	 * @param unknown $origem
	 * @param unknown $destino
	 * @return unknown
	 */
	protected function modelMapper($origem, $destino){
		foreach($origem as $chave => $valor) {
			$set = 'set'.ucfirst($chave);
			if(method_exists($destino, $set)){
				$destino->$set($valor);
			}
		}
		return $destino;
	}
	
	/**
	 * Essa operação tem como finalidade montar inserções simples.
	 * @param unknown $tabela
	 * @param unknown $objeto
	 * @return string
	 */
	protected function sqlInserir($tabela, $objeto){
		$methods = get_class_methods($objeto);
		$campos = $valores = '';
		foreach($methods as $method) {
			if(strpos($method, 'get') !== false && $method !== 'getId' &&
					$objeto->$method() !== NULL && trim($objeto->$method()) !== ''){
						$campos .= strtolower(str_replace('get','',$method)).',';
						$valores .= "'".$objeto->$method()."',";
			}
		}
		return "INSERT INTO $tabela (".substr($campos, 0, -1).") VALUES (".substr($valores, 0, -1).")";
	} 
	
	/**
	 * Essa operação tem como finalidade montar updates simples.
	 * @param unknown $tabela
	 * @param unknown $objeto
	 * @return string
	 */
	protected function sqlAtualizar($tabela, $objeto){
		$sql = "UPDATE $tabela SET ";
		$methods = get_class_methods($objeto);
		foreach($methods as $method) {
			if(strpos($method, 'get') !== false && $method !== 'getId' && 
					$objeto->$method() !== NULL && trim($objeto->$method()) !== ''){
				$sql .= " ".strtolower(str_replace('get','',$method))." = '".$objeto->$method()."',";
			}
		}
		$sql = substr($sql, 0, -1);
		return $sql .= ' WHERE id = '.$objeto->getId();
	} 
	
	protected function sqlExcluir($tabela, $id){
		return "UPDATE $tabela SET status = '0' WHERE id = $id";
	} 	
	
}
?>