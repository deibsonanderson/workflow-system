<?php
class DaoUsuario extends DaoBase{

	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

	public function listarUsuario($id = null){
		try {
			$query = $this->executar($this->sqlSelect(
					DaoBase::TABLE_USUARIO, array('id', 'nome', 'imagem', 'login', 'senha', 'status', 'id_perfil', 'popup_vencimento', 'classe', 'auto_anexo', 'auto_close'), false)
					.$this->montarId($id));
			while($objetoUsuario =  mysqli_fetch_object($query)){
				$usuario = $this->modelMapper($objetoUsuario, new Usuario());
				$usuario->setPerfil($objetoUsuario->id_perfil);
				$retorno[] = $usuario; 
			}
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}
	
	
    public function listarUsuarioLogin($id = null){
		try {
			$retorno = null;
			$usuario = $this->listarUsuario($id);
			if(count($usuario) > 0){
				$retorno = $usuario[0];
			}
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}

        
	public function incluirUsuario($usuario){
		try {
			return $this->executar("INSERT INTO ".DaoBase::TABLE_USUARIO." (nome,imagem,login,senha,id_perfil,classe, popup_vencimento,status) VALUES ('".$usuario->getNome()."','".$usuario->getImagem()."','".$usuario->getLogin()."','".$usuario->getSenha()."','".$usuario->getPerfil()."',10,1,'".$usuario->getStatus()."')");
		} catch (Exception $e) {
			return $e;
		}
	}

        
	public function alterarUsuario($usuario){
		try {	
			$sql = "UPDATE ".DaoBase::TABLE_USUARIO." SET  
					nome = '".$usuario->getNome()."',
					imagem = '".$usuario->getImagem()."',
					login = '".$usuario->getLogin()."',
					popup_vencimento = '".$usuario->getPopup_vencimento()."',
					id_perfil = '".$usuario->getPerfil()."',
					status = '".$usuario->getStatus()."', 
                    auto_anexo = '".$usuario->getAuto_anexo()."',
                    auto_close = '".$usuario->getAuto_close()."',
					classe = '".$usuario->getClasse()."' 
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
		
	public function alterarSenhaUsuario($usuario){
		try {	
			$sql = "UPDATE ".DaoBase::TABLE_USUARIO." SET  
					senha = '".$usuario->getSenha()."'
					WHERE id =".$usuario->getId();
			return $this->executar($sql);
		} catch (Exception $e) {
			return $e;
		}
	}



}

?>