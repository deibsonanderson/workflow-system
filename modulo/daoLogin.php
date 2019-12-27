<?php
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
class DaoLogin extends DaoBase{

	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

	public function validarLogin($post){
		try {	
			$conexao = $this->ConectarBanco();
			
			$sql = "SELECT id,login,senha FROM tb_workflow_usuario WHERE login = '".$post["login"]."' AND senha = '".$post["senha"]."' AND status = '1'";
			//debug($sql);
			$query = mysqli_query($conexao,$sql) or die ('Erro na execução  do listar!');
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
				$this->FecharBanco($conexao);
				return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}

	public function incluirLogin($login){
		try {	
			$conexao = $this->ConectarBanco();
			$sql = "INSERT INTO tb_workflow_login (id_usuario,data,status) VALUES ('".$login->getUsuario()."',NOW(),'".$login->getStatus()."')";
			$retorno = mysqli_query($conexao,$sql) or die ('Erro na execução  do insert!');
			$this->FecharBanco($conexao);
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}

	
	public function ultimoAcesso($id){
		$conexao = $this->ConectarBanco();
		$sql = "SELECT timediff(NOW(),data) as tempo_de_diferenca FROM tb_workflow_login WHERE id_usuario = '".$id."' ORDER BY id DESC LIMIT 1,1";
		$query = mysqli_query($conexao,$sql) or die ('Erro na execução  do listar!');
		if($obj =  mysqli_fetch_object($query)){
			return $tempo_de_diferenca = $obj->tempo_de_diferenca;
		}
	}
	
}

?>