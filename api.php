<?php
error_reporting ( E_ALL & ~ E_NOTICE & ~ E_DEPRECATED );
require_once 'include.php';
const REQUEST_METHOD = 'REQUEST_METHOD';
if (isset ( $_SESSION ["login"] )) {
	if ($_GET ['f'] && $_GET ['c']) {
		
		header ( 'Content-type: application/json' );
		$data = json_decode ( file_get_contents ( "php://input" ) );
		function chamarControle($post, $funcao, $controlador) {
			try {
				$class = new $controlador ();
				return $class->$funcao ( $post );
			} catch ( Exception $e ) {
				return $e;
			}
		}
		function from_camel_case($input) {
			preg_match_all ( '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches );
			$ret = $matches [0];
			foreach ( $ret as &$match ) {
				$match = $match == strtoupper ( $match ) ? strtolower ( $match ) : lcfirst ( $match );
			}
			return implode ( '_', $ret );
		}
		function montarObjetoParaArray($objeto) {
			$array = array ();
			foreach ( get_class_methods ( $objeto ) as $nomeMetodo ) {
				if ('get' == substr ( $nomeMetodo, 0, 3 )) {
					if (! is_object ( $objeto->$nomeMetodo () )) {
						$array [from_camel_case ( substr ( $nomeMetodo, 3 ) )] = $objeto->$nomeMetodo ();
					} else {
						$array [from_camel_case ( substr ( $nomeMetodo, 3 ) )] = montarObjetoParaArray ( $objeto->$nomeMetodo () );
					}
				}
			}
			return $array;
		}
		
		if ($_SERVER [REQUEST_METHOD] === "GET") {
			header ( 'HTTP/1.1 200 OK' );
			
			$results = array ();
			
			$response = chamarControle ( $_GET ["id"], $_GET ['f'], $_GET ['c'] );
			$response = ($_GET ['f'] == 'listarAtividade') ? $response->retorno : $response;
			
			foreach ( $response as $objeto ) {
				$results [] = montarObjetoParaArray ( $objeto );
			}
			
			echo json_encode ( $results );
		} else if ($_SERVER [REQUEST_METHOD] === "POST") {
			header ( 'HTTP/1.1 201 Created' );
			echo json_encode ( $data );
		} else if ($_SERVER [REQUEST_METHOD] === "PUT") {
			header ( 'HTTP/1.1 200 OK' );
			echo json_encode ( $data );
		} else if ($_SERVER [REQUEST_METHOD] === "DELETE") {
			header ( 'HTTP/1.1 204 No Content' );
			echo json_encode ( $data );
		}
	} else {
		?>
		<html>
			<body>
				<a href="http://dicaseprogramacao.com.br/workflowdx/api.php?f=listarAtividade&c=ControladorAtividade">Atividades</a>
				</br>
				<a href="http://dicaseprogramacao.com.br/workflowdx/api.php?f=listarProcesso&c=ControladorProcesso">Processos</a>
				</br>
			</body>
		</html>
<?php
	}
} else {
	echo 'ACESSO NEGADO!';
}
?>
