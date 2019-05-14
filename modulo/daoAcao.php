<?php
class DaoAcao extends Dados{

	//construtor
	public function __construct(){}

	//destruidor
	public function __destruct(){}

		
	
	public function listarClasseAcao($usuario = null){
		try {
			$aux = array();
			$retorno = array();	
			$conexao = $this->ConectarBanco();
			$sql = "SELECT c.id,c.nome,c.id_perfil,c.controlador,c.funcao,c.status,c.secao,
					       c.id_modulo, m.nome as nome_modulo, m.status as status_modulo,
					       IF(a.perfil IS NULL,'0',a.perfil ) as perfil
					FROM tb_workflow_classe c
					INNER JOIN tb_workflow_modulo m ON (c.id_modulo = m.id)
					LEFT JOIN tb_workflow_acao_usuario a ON (a.id_classe = c.id AND a.id_usuario = ".$usuario->getId().")
					WHERE c.status = '1' ORDER BY c.id_modulo ";
			
			$query = mysqli_query($conexao,$sql) or die ('Erro na execução do listar acao!');
			$ultimo_id = 0;

			
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
				
				$classe = new Classe();
				$classe->setId($objetoModulo->id);
				$classe->setNome($objetoModulo->nome);
				$classe->setFuncao($objetoModulo->funcao);
				$classe->setControlador($objetoModulo->controlador);
                                $classe->setSecao($objetoModulo->secao);
				$classe->setPerfil($objetoModulo->id_perfil);
				$classe->setStatus($objetoModulo->status);
				
				$acao = new Acao();
				$acao->setPerfil($objetoModulo->perfil);
				$classe->setAcao($acao);
				$aux[] = $classe;
			}
			$modulo->setClasse($aux);
			$retorno[] = $modulo;
			
                        $this->FecharBanco($conexao);
			
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}	
	
	
	public function incluirClasseAcao($usuario,$post){
		try {	
			$conexao = $this->ConectarBanco();
			
                        $sql_remove = "DELETE FROM `tb_workflow_acao_usuario` WHERE `id_usuario` = ".$usuario->getId()."";
                        $remove = mysqli_query($conexao, $sql_remove) or die ('Erro na execução do delet!');
			
			
			$sql = "INSERT INTO `tb_workflow_acao_usuario` (
                                                            `id` ,
                                                            `id_classe` ,
                                                            `id_usuario` ,
                                                            `perfil` ,
                                                            `status`
                                                            )
                                                            VALUES";
								
			foreach ($post as $aux){
				$acao = explode("|", $aux);
				$sql .= "( NULL , ".$acao[0].", ".$usuario->getId().", '".$acao[1]."', 1 ),";				 
			}
			$sql = substr($sql, 0, -1);			
			
			$retorno = mysqli_query($conexao,$sql) or die ('Erro na execução  do insert!');
			
			$this->FecharBanco($conexao);
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}
	
	
	public function listarClasseAcaoParaMenu($usuario = null){
		try {	
			$retorno = array();
			$aux = array();
			$conexao = $this->ConectarBanco();
			$sql = "SELECT c.id,c.nome,c.id_perfil,c.controlador,c.funcao,c.status,c.secao,
					       c.id_modulo, m.nome as nome_modulo, m.status as status_modulo,
					       IF(a.perfil IS NULL,'0',a.perfil ) as perfil
					FROM tb_workflow_classe c
					INNER JOIN tb_workflow_modulo m ON (c.id_modulo = m.id)
					INNER JOIN tb_workflow_acao_usuario a ON (a.id_classe = c.id AND a.id_usuario = ".$usuario->getId().")
					WHERE c.status = '1' AND a.perfil <> '0'";
			
			$query = mysqli_query($conexao,$sql) or die ('Erro na execução do listarClasseAcaoParaMenu!: '.$sql);
			$ultimo_id = 0;
			
			if(mysqli_num_rows($query) > 0){	
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
					
					$classe = new Classe();
					$classe->setId($objetoModulo->id);
					$classe->setNome($objetoModulo->nome);
					$classe->setFuncao($objetoModulo->funcao);
					$classe->setControlador($objetoModulo->controlador);
					$classe->setPerfil($objetoModulo->id_perfil);
					$classe->setStatus($objetoModulo->status);
					$classe->setSecao($objetoModulo->secao);
                                        
					$acao = new Acao();
					$acao->setPerfil($objetoModulo->perfil);
					$classe->setAcao($acao);
					$aux[] = $classe;
				}
				$modulo->setClasse($aux);
				$retorno[] = $modulo;
			}	
			
			$this->FecharBanco($conexao);
			
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}	

        
        public function retornaPerfilClasseAcao($usuario = null,$acao){
		try {	
			$conexao = $this->ConectarBanco();
			$sql = "SELECT aue.perfil 
					FROM tb_workflow_acao_usuario aue
					WHERE aue.status = 1 AND 
					      aue.id_usuario = ".$usuario->getId()."  AND 
					      aue.id_classe  = (SELECT id FROM tb_workflow_classe WHERE status = '1' AND funcao LIKE '%".$acao."%' )";
			
			
			$query = mysqli_query($conexao,$sql) or die ('Erro na execução do listar!');
			$ultimo_id = 0;
			
			if(mysqli_num_rows($query) > 0){	
				if($objetoModulo =  mysqli_fetch_object($query)){
					$retorno = $objetoModulo->perfil;
				}				
			}	
			
			$this->FecharBanco($conexao);
			
			return $retorno;
		} catch (Exception $e) {
			return $e;
		}
	}	
	
}

?>