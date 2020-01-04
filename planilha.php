<?php
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
require_once 'include.php';

// Definimos o nome do arquivo que será exportado
$today = date("d_m_Y_H_i_s");    
$arquivo = 'planilha_'.$today.'.xls';
// Configurações header para forçar o download
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
//header ("Content-type: application/x-msexcel; charset=UTF-8;");
header ("Content-Type: application/vnd.ms-excel; charset=UTF-8;");
header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
header ("Content-Description: PHP Generated Data" );
// Criamos uma tabela HTML com o formato da planilha
$daoProcesso = new DaoProcesso();
$objProcesso = $daoProcesso->buscarFluxoProcesso($_GET["id"], null);

$odd = true;

function addColor($valor){
	$result = "background-color: #F8F8FF";
	if($valor == true){
		$result = "";
	}
	return $result;
}

?>
<table id="example" class="tablesorter table table-striped table-bordered second" style="width:100%;" border="1">
	<thead>
		<tr >
			<th style="background-color:#DCDCDC">T&iacute;tulo</th>
			<th style="background-color:#DCDCDC">Valor</th>
			<th style="background-color:#DCDCDC">Status</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	if ($objProcesso != null && $objProcesso[0]->getFluxoProcesso() != null) {
		$positivo = 0;
		$negativo = 0;
		$aberto = 0;
		$fechado = 0;		
		foreach ($objProcesso[0]->getFluxoProcesso() as $fluxoProcesso) {
			if($fluxoProcesso->getPropriedade() == '1'){
				$positivo += $fluxoProcesso->getValor();
				$sinal = '';
				$colorcss = 'color:BLUE;';
			}else{
				$negativo += $fluxoProcesso->getValor();
				$sinal = '-';
				$colorcss = 'color:RED;';
			}
			if($fluxoProcesso->getAtivo() == '1' ){
				if($fluxoProcesso->getPropriedade() == '1'){
					$aberto += $fluxoProcesso->getValor();
				}else{
					$aberto -= $fluxoProcesso->getValor();
				}
				$colorStatus = 'color:RED;';
			}else{
				if($fluxoProcesso->getPropriedade() == '1'){
					$fechado += $fluxoProcesso->getValor();
				}else{
					$fechado -= $fluxoProcesso->getValor();
				}
				$colorStatus = 'color:BLUE;';
			}						
			?>    
				<tr  >
					<td style="<?php echo addColor($odd);?>"width="400px" ><?php echo utf8_decode(limitarTexto(($fluxoProcesso->getTitulo())?$fluxoProcesso->getTitulo():$fluxoProcesso->getAtividade()->getTitulo(), 100)); ?></td> 
					<td style="<?php echo $colorcss; ?><?php echo addColor($odd);?>" ><?php echo $sinal.moneyFormat($fluxoProcesso->getValor()); ?></td> 
					<td style="text-align: center; <?php echo $colorStatus; ?><?php echo addColor($odd);?>"><?php echo ($fluxoProcesso->getAtivo() == '0')?'Fechado':'Aberto'; ?></td> 
				</tr>	
			<?php
			$odd = !$odd;
		}
		$negativo = $negativo*(-1);
	}
	?>
		<tr >
			<td colspan="3" style="<?php echo addColor($odd); $odd = !$odd; ?>" >&nbsp;</td> 
		</tr>
		<tr style="">
			<td style="<?php echo addColor($odd); ?>" colspan="2">Provis&atilde;o:</td> 
			<td style="<?php echo addColor($odd); $odd = !$odd; ?>" ><?php echo 'R$ '.moneyFormat($objProcesso[0]->getProvisao()); ?></td> 
		</tr >
		<tr style="">
			<td style="<?php echo addColor($odd); ?>" colspan="2">Total Aberto:</td> 
			<td style="color:RED;<?php echo addColor($odd); $odd = !$odd; ?>" ><?php echo 'R$ '.moneyFormat($aberto); ?></td> 
		</tr>
		<tr style="">
			<td style="<?php echo addColor($odd);?>" colspan="2">Total Fechado:</td> 
			<td style="color:BLUE;<?php echo addColor($odd); $odd = !$odd; ?>" ><?php echo 'R$ '.moneyFormat($fechado); ?></td> 
		</tr>		
		<tr style="">
			<td style="<?php echo addColor($odd);?>" colspan="2">Total Positivo:</td> 
			<td style="color:BLUE;<?php echo addColor($odd); $odd = !$odd; ?>" ><?php echo 'R$ '.moneyFormat($positivo); ?></td> 
		</tr>
		<tr style="">
			<td style="<?php echo addColor($odd); ?>" colspan="2">Total Negativo:</td> 
			<td style="color:RED;<?php echo addColor($odd); $odd = !$odd; ?>" ><?php echo 'R$ '.moneyFormat($negativo); ?></td> 
		</tr>  
		<tr style="">
			<td style="<?php echo addColor($odd);?>" colspan="2">Total Geral (Positivo x Negativo):</td> 
			<td style="<?php echo addColor($odd); $odd = !$odd; ?>" ><?php echo 'R$ '.moneyFormat(($positivo+$negativo)); ?></td> 
		</tr>
		<tr style="">
			<td style="<?php echo addColor($odd);?>" colspan="2">Provis&atilde;o x Total Geral:</td> 
			<td style="color:#008000;<?php echo addColor($odd); $odd = !$odd; ?>" ><?php echo 'R$ '.moneyFormat(($objProcesso[0]->getProvisao()+($positivo+$negativo))); ?></td> 
		</tr>     				
	</tbody> 
</table>
<?php
// Envia o conteúdo do arquivo
exit;
?>