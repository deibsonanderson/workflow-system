<?php
class DaoAcao extends DaoBase{

	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

	private function montarClasseAcao($query){
		$ultimo_id = 0;
		$aux = array();
		$retorno = array();	
		
		while($objetoModulo =  mysqli_fetch_object($query)){
			
			if($ultimo_id != $objetoModulo->id_modulo){
				if($ultimo_id != 0){
					$modulo->setClasse($aux);
					$aux = null;
					$retorno[] = $modulo;
				}
				$modulo = new Modulo();
				$modulo->setId($objetoModulo->id_modulo);
				$modulo->setNome($objetoModulo->nome_modulo);
				$modulo->setStatus($objetoModulo->status_modulo);
				
				$ultimo_id = $objetoModulo->id_modulo;
			}
			
			$classe = $this->modelMapper($objetoModulo, new Classe());
			$classe->setPerfil($objetoModulo->id_perfil);
			
			$acao = new Acao();
			$acao->setPerfil($objetoModulo->perfil);
			$classe->setAcao($acao);
			$aux[] = $classe;
		}
		$modulo->setClasse($aux);
		$retorno[] = $modulo;
		
		return $retorno;
	}
	
	public function listarClasseAcao($usuario = null){
		try {
			$sql = "SELECT c.id,c.nome,c.id_perfil,c.controlador,c.funcao,c.status,c.secao,
					       c.id_modulo, m.nome as nome_modulo, m.status as status_modulo,
					       IF(a.perfil IS NULL,'0',a.perfil ) as perfil
					FROM ".DaoBase::TABLE_CLASSE." c
					INNER JOIN ".DaoBase::TABLE_MODULO." m ON (c.id_modulo = m.id)
					LEFT JOIN ".DaoBase::TABLE_ACAO_USUARIO." a ON (a.id_classe = c.id AND a.id_usuario = ".$usuario->getId().")
					WHERE c.status = '1' ORDER BY c.id_modulo ASC, c.nome ASC ";
			
			return $this->montarClasseAcao($this->executar($sql));
		} catch (Exception $e) {
			return $e;
		}
	}	
	
	
	public function incluirClasseAcao($usuario,$post){
		try {	
			$this->executar("DELETE FROM `".DaoBase::TABLE_ACAO_USUARIO."` WHERE `id_usuario` = ".$usuario->getId());
			
			$sql = "INSERT INTO `".DaoBase::TABLE_ACAO_USUARIO."` (`id` , `id_classe` , `id_usuario` , `perfil` , `status` ) VALUES ";
			foreach ($post as $aux){
				$acao = explode("|", $aux);
				$sql .= "( NULL , ".$acao[0].", ".$usuario->getId().", '".$acao[1]."', 1 ),";				 
			}
			$sql = substr($sql, 0, -1);			

			return $this->executar($sql);
		} catch (Exception $e) {
			return $e;
		}
	}
	
	
	public function listarClasseAcaoParaMenu($usuario = null){
		try {	
			$sql = "SELECT c.id,c.nome,c.id_perfil,c.controlador,c.funcao,c.status,c.secao,
					       c.id_modulo, m.nome as nome_modulo, m.status as status_modulo,
					       IF(a.perfil IS NULL,'0',a.perfil ) as perfil
					FROM ".DaoBase::TABLE_CLASSE." c
					INNER JOIN ".DaoBase::TABLE_MODULO." m ON (c.id_modulo = m.id)
					INNER JOIN ".DaoBase::TABLE_ACAO_USUARIO." a ON (a.id_classe = c.id AND a.id_usuario = ".$usuario->getId().")
					WHERE c.status = '1' AND a.perfil <> '0' ORDER BY c.id_modulo, c.id ASC ";
			
			if(mysqli_num_rows($this->executar($sql)) > 0){	
				$retorno = $this->montarClasseAcao($this->executar($sql));
			}	
			
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}	

        
    public function retornaPerfilClasseAcao($usuario, $acao){
		try {	
			
			$query = $this->executar("SELECT aue.perfil
					FROM ".DaoBase::TABLE_ACAO_USUARIO." aue
					WHERE aue.status = 1 AND
					      aue.id_usuario = ".$usuario->getId()."  AND
					      aue.id_classe  = (SELECT id FROM ".DaoBase::TABLE_CLASSE." WHERE status = '1' AND funcao = '".$acao."' )");
			
			if(mysqli_num_rows($query) > 0 && 
					$objetoModulo =  mysqli_fetch_object($query)){	
				$retorno = $objetoModulo->perfil;
			}	
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}	
	
}

?>