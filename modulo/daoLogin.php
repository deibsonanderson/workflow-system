<?php
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
class DaoLogin extends DaoBase{

	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

	public function validarLogin($post){
		try {	
			$query = $this->executar("SELECT id,login,senha FROM ".DaoBase::TABLE_USUARIO." WHERE login = '".$post["login"]."' AND senha = '".$post["senha"]."' AND status = '1'");
			if(mysqli_num_rows($query) == 1){
				$obj =  mysqli_fetch_object($query);
				
				$controladorUsuario = new ControladorUsuario();
				$objUsuario = $controladorUsuario->listarUsuarioLogin($obj->id);	
				
				$_SESSION["login"] = $objUsuario; 
				$_SESSION["mensagem"] = "1";
				
				$retorno = 1;
			}else{
				$retorno = null;
			}
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}

	public function incluirLogin($login){
		try {	
			return $this->executar("INSERT INTO ".DaoBase::TABLE_LOGIN." (id_usuario,data,status) VALUES ('".$login->getUsuario()."',NOW(),'".$login->getStatus()."')");
		} catch (Exception $e) {
			return $e;
		}
	}

}

?>