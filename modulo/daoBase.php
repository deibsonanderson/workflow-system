<?php
abstract class DaoBase {
	
	/**
	 * Tabelas
	 */
	const TABLE_CATEGORIA_ATIVIDADE = 'tb_workflow_categoria_atividade';
	const TABLE_ACAO_USUARIO = 'tb_workflow_acao_usuario';
	const TABLE_AGENDA = 'tb_workflow_agenda';
	const TABLE_ATIVIDADE = 'tb_workflow_atividade';
	const TABLE_CLASSE   = 'tb_workflow_classe';
	const TABLE_COMENTARIO = 'tb_workflow_comentario';
	const TABLE_FLUXO = 'tb_workflow_fluxo';
	const TABLE_LOGIN = 'tb_workflow_login';
	const TABLE_MODULO = 'tb_workflow_modulo';
	const TABLE_PAIS = 'tb_workflow_pais';
	const TABLE_PROCESSO = 'tb_workflow_processo';
	const TABLE_PROCESSO_FLUXO = 'tb_workflow_processo_fluxo';
	const TABLE_TITULO_FLUXO = 'tb_workflow_titulo_fluxo';
	const TABLE_USUARIO = 'tb_workflow_usuario';

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
	 * @return DataSource
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
	 * @param DataSource $conexao
	 */
	protected function fecharBanco($conexao) {
		try {
			mysqli_close ( $conexao );
		} catch ( Exception $e ) {
			echo 'Não foi possível fechar a conexão ao banco de dados - error:' . $e . getMessage ();
		}
	}
	
	/**
	 * Operação responsavel por execução da query
	 * @param String $sql
	 * @return $query
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
	 * Operação responsavel por execução da query
	 * @param String $sql
	 * @return array
	 */
	protected function executarQuery($sql, $classe) {
		try {
			$retorno = array ();
			$query = $this->executar($sql);
			while ( $objeto = mysqli_fetch_object ( $query ) ) {
				$retorno [] = $this->modelMapper($objeto, new $classe());
			}
		} catch ( Exception $e ) {
			echo 'Não foi possível executar a operação - error:' . $e . getMessage ();
		}
		return $retorno;
	}
	
	/**
	 * Operação responsavel por execução das querys
	 * @param array(String) $sql
	 * @return array
	 */
	protected function executarMulti($sqls) {
		try {
			$conexao = $this->ConectarBanco ();
			foreach ($sqls as $sql){
				$retorno[] = mysqli_query ( $conexao, $sql );
			}
			$this->FecharBanco ( $conexao );
		} catch ( Exception $e ) {
			echo 'Não foi possível executar a operação - error:' . $e . getMessage ();
		}
		return $retorno;
	}

	/**
	 * Essa operação serve para complementar uma checagem do id
	 * @param Integer $id
	 * @param String $schema
	 * @return string
	 */
	protected function montarId($id, $schema = '') {
		try {
			$schema = ($schema != '') ? $schema . '.' : $schema;
			return ($id == null || $id == '') ? '' : ' AND ' . $schema . 'id = ' . $id;
		} catch ( Exception $e ) {
			echo 'Erro na operção montarId - error:' . $e . getMessage ();
		}
	}
	
	/**
	 * Essa operação serve para complementar uma checagem do id do usuario
	 * @param Integer $id_usuario
	 * @param String $schema
	 * @return string
	 */
	protected function montarIdUsuario($id_usuario, $schema = '') {
		try {
			$schema = ($schema != '') ? $schema . '.' : $schema;
			return ($id_usuario == null || $id_usuario == '') ? '' : ' AND ' . $schema . 'id_usuario = ' . $id_usuario;
		} catch ( Exception $e ) {
			echo 'Erro na operção montarIdUsuario - error:' . $e . getMessage ();
		}
	}
	
	/**
	 * Essa operação serve para complementar uma checagem do id do usuario
	 * @param String $data
	 * @param String $schema
	 * @return string
	 */
	protected function montarData($data, $schema = '') {
		try {
			$schema = ($schema != '') ? $schema . '.' : $schema;
			return ($data == null || $data == '') ? '' : ' AND ' . $schema . 'data = "' . $data.'"';
		} catch ( Exception $e ) {
			echo 'Erro na operção montarData - error:' . $e . getMessage ();
		}
	}
	
	/**
	 * Operação responsavel por converter um objeto simples em uma classe simples.
	 * @param strClass $origem
	 * @param Class $destino
	 * @return $destino
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
	 * @param String $tabela
	 * @param Objeto $objeto
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
	 * @param String $tabela
	 * @param Objeto $objeto
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
	
	/**
	 * Operação responsável por gerar sql de atualização costumizada com base nos campos pegando direto no objeto
	 * @param String $tabela
	 * @param Object $objeto
	 * @param array $valores
	 * @throws Exception
	 * @return string|Exception
	 */
	protected function sqlAtualizarCustom($tabela, $objeto, $campos){
		$sql = "UPDATE $tabela SET ";
		foreach($campos as $campo) {
			$method = 'get'.ucfirst($campo);
			$sql .= " ".strtolower($campo)." = '".$objeto->$method()."',";
		}
		$sql = substr($sql, 0, -1);
		return $sql .= ' WHERE id = '.$objeto->getId();
	}
	
	/**
	 * Operação responsável por gerar sql de atualização costumizada usando campos e valores 
	 * @param String $tabela
	 * @param integer $id
	 * @param array $campos
	 * @param array $valores
	 * @throws Exception
	 * @return string|Exception
	 */
	protected function sqlAtualizarMultiCustom($tabela, $id, $campos, $valores){
		try {
			if(count($campos) > 0 && count($valores) > 0){
				$sql = "UPDATE $tabela SET ";
				for($i=0; $i < count($campos); $i++) {
					$sql .= " ".strtolower($campos[$i])." = '".$valores[$i]."',";
				}
				$sql = substr($sql, 0, -1).' WHERE id = '.$id;
			}else{
				throw new Exception('valores ou campos inválidos','500');
			}
			return $sql;
		} catch (Exception $e) {
			return $e;
		}
	}
	
	/**
	 * Operação responsavel por montar um select basico
	 * @param Sring $tabela
	 * @param Array $campos
	 * @return string
	 */
	protected function sqlSelect($tabela, $campos, $isDistinct){
		$sql = "SELECT ";
		$sql .= ($isDistinct === true)?'DISTINCT ':'';
		foreach($campos as $campo) {
			$sql .= " ".strtolower($campo).",";
		}
		$sql = substr($sql, 0, -1);
		return $sql .= " FROM $tabela WHERE status = '1' ";
	} 
	
	/**
	 * Operação responsavel pela exclusão logica
	 * @param String $tabela
	 * @param Integer $id
	 * @return string
	 */
	protected function sqlExcluir($tabela, $id){
		return "UPDATE $tabela SET status = '0' WHERE id = $id";
	} 	
	
}
?>