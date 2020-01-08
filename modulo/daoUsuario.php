<?php
class DaoUsuario extends DaoBase{

	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

	public function listarUsuario($id = null){
		try {	
			$conexao = $this->ConectarBanco();
			$retorno = array();
			$sql = "SELECT u.id, u.nome, u.imagem, u.login, u.senha, u.status, u.id_perfil
          			FROM tb_workflow_usuario u 
					WHERE u.status = '1'";
			$sql .= ($id != null)?" AND u.id = ".$id:"";
			$sql .= " GROUP BY u.id";
			
			
			$query = mysqli_query($conexao,$sql) or die ('Erro na execução do listar usuario!: '. $sql);
			while($objetoUsuario =  mysqli_fetch_object($query)){
				$usuario = new Usuario();
				$usuario->setId($objetoUsuario->id);
				$usuario->setNome($objetoUsuario->nome);
				$usuario->setImagem($objetoUsuario->imagem);
				$usuario->setLogin($objetoUsuario->login);
				$usuario->setSenha($objetoUsuario->senha);
				$usuario->setPerfil($objetoUsuario->id_perfil);				
				$usuario->setStatus($objetoUsuario->status);
				
				$retorno[] = $usuario; 
			}
				$this->FecharBanco($conexao);
				return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}
	
	
    public function listarUsuarioLogin($id = null){
		try {	
			$retorno = array();
			$conexao = $this->ConectarBanco();
			$sql = "SELECT u.id, u.nome, u.imagem, u.login, u.senha, u.status, u.id_perfil              				
          			FROM tb_workflow_usuario u WHERE u.status = '1'";
			$sql .= ($id != null)?" AND u.id = ".$id:"";
			$sql .= " GROUP BY u.id";
			
			
			$query = mysqli_query($conexao,$sql) or die ('Erro na execução do listar usuario login!');
			while($objetoUsuario =  mysqli_fetch_object($query)){
				$usuario = new Usuario();
				$usuario->setId($objetoUsuario->id);
				$usuario->setNome($objetoUsuario->nome);
				$usuario->setImagem($objetoUsuario->imagem);
				$usuario->setLogin($objetoUsuario->login);
				$usuario->setSenha($objetoUsuario->senha);
				$usuario->setPerfil($objetoUsuario->id_perfil);				
				$usuario->setStatus($objetoUsuario->status);
				
				$retorno = $usuario; 
			}
				$this->FecharBanco($conexao);
				return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}

        
	public function incluirUsuario($usuario){
		try {
			return $this->executar("INSERT INTO ".DaoBase::TABLE_USUARIO." (nome,imagem,login,senha,id_perfil,status) VALUES ('".$usuario->getNome()."','".$usuario->getImagem()."','".$usuario->getLogin()."','".$usuario->getSenha()."','".$usuario->getPerfil()."','".$usuario->getStatus()."')");
		} catch (Exception $e) {
			return $e;
		}
	}

        
	public function alterarUsuario($usuario){
		try {	
			$sql = "UPDATE tb_workflow_usuario SET  
					nome = '".$usuario->getNome()."',
					imagem = '".$usuario->getImagem()."',
					login = '".$usuario->getLogin()."',
					senha = '".$usuario->getSenha()."',
					id_perfil = '".$usuario->getPerfil()."',
					status = '".$usuario->getStatus()."' 
					WHERE id =".$usuario->getId();
			return $this->executar($sql);
		} catch (Exception $e) {
			return $e;
		}
	}

        
	public function excluirUsuario($id){
		try {
			return $this->executar($this->sqlExcluir(DaoBase::TABLE_USUARIO, $id));
		} catch (Exception $e) {
			return $e;
		}

	}



}

?>