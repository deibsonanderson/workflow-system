<?php

function selecao($valor1, $valor2) {
    $selecao = "";
    if (($valor1 == "") || ($valor1 == $valor2)) {
        $selecao = "selected='selected'";
    }
    return $selecao;
}

/**
 * Função reponsavel para converter de Float para Monetario ou Monetario para Float
 * @author Deibson Anderson
 * @param $valor
 * @param $conversão 1 para versao US 2 para versão BR
 * @throws 
 * @return retorna o valor convertido.
 * @version 1.0.0
 * @since 1.1.6
 */
function valorMonetario($valor, $conversao) {
    switch ($conversao) {
        case "1":
            $valor = str_replace(" ", "", $valor);
            $valor = str_replace(".", "", $valor);
            $valor = str_replace(",", ".", $valor);
            break;

        case "2":
            $valor = str_replace(" ", "", $valor);
            $valor = str_replace(",", "", $valor);
            $valor = str_replace(".", ",", $valor);
            break;
        case "3":
        	$valor = str_replace(" ", "", $valor);
        	$valor = str_replace(",", "", $valor);
        	break;
    }
    return $valor;
}

function moneyFormat($number){
	return number_format($number, 2, ',', '.');  
}

function desformataData($date) {

    if ($date == "") {
        return "";
    }
    $ano = substr($date, 6, 4);
    $mes = substr($date, 3, 2);
    $dia = substr($date, 0, 2);
    return $ano . "-" . $mes . "-" . $dia;
}

function validarDate($date){
	if ($date == "") {
		return false;
	}
	$ano = substr($date, 6, 4);
	$mes = substr($date, 3, 2);
	$dia = substr($date, 0, 2);
	return checkdate($mes,$dia,$ano);
}

function recuperaData($date) {
    if ($date == "") {
        return "";
    }
    $ano = substr($date, 0, 4);
    $mes = substr($date, 5, 2);
    $dia = substr($date, 8, 2);

    return $dia . "/" . $mes . "/" . $ano;
}

function limitarTexto($string, $tamanho, $encode = 'UTF-8') {
    if (strlen($string) > $tamanho)
        $string = mb_substr($string, 0, $tamanho - 3, $encode) . '...';
    else
        $string = mb_substr($string, 0, $tamanho, $encode);

    return $string;
}

function exibirQuestion($identificador,$sim,$nao, $titulo, $frase) {
    ?>
		<!-- Modal -->
		<div class="modal" id="<?php echo $identificador; ?>" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel"><?php echo $titulo; ?></h5>
		      </div>
		      <div class="modal-body">
		        <?php echo $frase; ?>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" onclick="fcnFecharModalQuestion()" id="question-not-confirm" ><?php echo $nao; ?></button>
		        <button type="button" class="btn btn-primary" onclick="fncDeleteId(this)" id="question-confirm" ><?php echo $sim; ?></button>
		      </div>
		    </div>
		  </div>
		</div>		    
    <?php 
}


function paginacao($pagina,$numPaginas,$funcao,$controlador,$retorno){
	?>
<div class="text-center">
	<nav aria-label="Page navigation">
		<ul class="pagination">
			<li class="page-item <?php echo ($pagina <= 1)?'disabled':'';?>"><a
				class="page-link" href="#" onclick="fncButtonCadastro(this)"
				pagina="<?php echo ($pagina <= 1)?1:($pagina-1); ?>"
				funcao="<?php echo $funcao; ?>"
				controlador="<?php echo $controlador; ?>"
				retorno="<?php echo $retorno; ?>">Anterior</a></li>
						    <?php 
			for($i=1; $i <= $numPaginas; $i++){
		    ?>
		    <li class="page-item <?php echo ($pagina == $i)?'active':''; ?>"><a
				class="page-link" href="#" onclick="fncButtonCadastro(this)"
				pagina="<?php echo $i; ?>" funcao="<?php echo $funcao; ?>"
				controlador="<?php echo $controlador; ?>"
				retorno="<?php echo $retorno; ?>"><?php echo $i;?></a></li>
			<?php } ?>
		    <li
				class="page-item <?php echo ($pagina >= $numPaginas)?'disabled':'';?>">
				<a class="page-link" href="#" onclick="fncButtonCadastro(this)"
				pagina="<?php echo ($pagina >= $numPaginas)?$numPaginas:($pagina+1); ?>"
				funcao="<?php echo $funcao; ?>"
				controlador="<?php echo $controlador; ?>"
				retorno="<?php echo $retorno; ?>">Próximo</a>
			</li>
		</ul>
	</nav>
</div>
<?php
}

?>