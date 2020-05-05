<?php
function normalizaTexto($str){
    $str = strtolower(utf8_decode($str)); $i=1;
    $str = strtr($str, utf8_decode('àáâãäåæçèéêëìíîïñòóôõöøùúûýýÿ'), 'aaaaaaaceeeeiiiinoooooouuuyyy');
    $str = preg_replace("/([^a-z0-9])/",'_',utf8_encode($str));
    while($i>0) $str = str_replace('--','_',$str,$i);
    if (substr($str, -1) == '_') $str = substr($str, 0, -1);
    return $str;
}
//if (isset($_SESSION["login"])) {
$local = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'workflow';



$path = './arquivos/atividade';
	

$conexao = mysqli_connect ( $local, $usuario, $senha );
mysqli_set_charset ( $conexao, 'utf8' );
mysqli_select_db ( $conexao, $banco );

function updateNameFile($conexao,$path){

	$retorno = array ();

	$query = mysqli_query ( $conexao, "SELECT DISTINCT
												wc.id, 
												wc.descricao, 
												wc.categoria, 
												wc.arquivo, 
												wc.old_arquivo, 
												wc.id_processo_fluxo,
												wp.titulo as titulo_processo,
												wpf.titulo_atividade
									   FROM tb_workflow_comentario wc
									   INNER JOIN tb_workflow_processo_fluxo wpf ON wc.id_processo_fluxo = wpf.id 
									   INNER JOIN tb_workflow_processo wp ON wpf.id_processo = wp.id
									   WHERE wc.arquivo IS NOT NULL ");
	$retorno = array();								   
	while ($o = mysqli_fetch_object ( $query ) ) {
		if($o->old_arquivo != null && trim($o->old_arquivo) != ''){
			$c = new stdClass();
			$c->id = $o->id;
			$c->old_name = $o->old_arquivo;	
			$c->categoria = $o->categoria;	
			$c->descricao = $o->descricao;
			$c->titulo_processo = $o->titulo_processo;
			$c->titulo_atividade = $o->titulo_atividade;
			
			$c->new_name = '';
			if($o->titulo_processo != null && trim($o->titulo_processo) != ''){
				$c->new_name .= $o->titulo_processo.'-';
			}		
			if($o->titulo_atividade != null && trim($o->titulo_atividade) != ''){
				$c->new_name .= $o->titulo_atividade.'-';
			}
			if($o->categoria != null && trim($o->categoria) != ''){
				switch($o->categoria){
					case '1':
						$c->new_name .= 'boleto-';						
					break;	
					case '2':
						$c->new_name .= 'comprovante-';
					break;
					case '3':
						$c->new_name .= 'fatura-';
					break;		
				}
			}
			if($o->old_arquivo != null && trim($o->old_arquivo) != ''){
				$c->new_name .= $o->old_arquivo.'-';
			}			
			$c->new_name = normalizaTexto($c->new_name);
			
			$ext = substr($c->new_name, -3);
			$c->new_name = substr($c->new_name, 0, (strlen($c->new_name)-4));
			$c->new_name .= '.'.$ext;
			//$c->exists = file_exists($path.'/'.$o->arquivo);
			$c->msg = null;
			
			$retorno [] = $c;
		}
	}
	return $retorno;
}

function update($com, $conexao) {
	try {
		$sql = "UPDATE tb_workflow_comentario SET arquivo = '".$com->new_name."' WHERE id = " . $com->id . "";
		return mysqli_query($conexao,$sql);
	} catch (Exception $e) {
		return false;
	}
}

function setMsg($com, $m){
	$com->msg = $m;
	echo '<pre>';	
	var_dump($com);
}

$comentarios = updateNameFile($conexao,$path);

echo 'INICIO<br/>';
foreach($comentarios as $com){
	if(file_exists($path.'/'.$com->old_name)){
		if(update($com, $conexao)){	
			if(rename($path.'/'.$com->old_name, $path.'/'.$com->new_name)){
				setMsg($com, 'SUCESSO');	
			}else{
				setMsg($com, 'erro no renomear.');
			}
		}else{
			setMsg($com, 'não atualizou.');
		}
	}else{
		setMsg($com, 'não existe.');
	}	
}
echo 'FIM';

//FIM
mysqli_close ( $conexao );
//} //LOGIN
?>