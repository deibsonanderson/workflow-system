<?php
error_reporting (E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
require_once 'include.php';

// Definimos o nome do arquivo que será exportado
$arquivo = 'planilha.xls';
// Configurações header para forçar o download
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel; charset=UTF-8;");
header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
header ("Content-Description: PHP Generated Data" );
// Criamos uma tabela HTML com o formato da planilha
$daoProcesso = new DaoProcesso();
$objProcesso = $daoProcesso->buscarFluxoProcesso($_GET["id"], null);
?>
<table id="example" class="tablesorter table table-striped table-bordered second" style="width:100%;" border="1">
	<thead>
		<tr>
			<th>T&iacute;tulo</th>
			<th>Valor</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	if ($objProcesso != null && $objProcesso[0]->getFluxoProcesso() != null) {
		$positivo = 0;
		$negativo = 0;
		
		foreach ($objProcesso[0]->getFluxoProcesso() as $fluxoProcesso) {
			if($fluxoProcesso->getAtividade()->getPropriedade() == '1'){
				$positivo += $fluxoProcesso->getAtividade()->getValor();
				$sinal = '';
				$colorcss = 'color:BLUE;';
			}else{
				$negativo += $fluxoProcesso->getAtividade()->getValor();
				$sinal = '-';
				$colorcss = 'color:RED;';
			}
			
			?>    
				<tr>
					<td width="400px" ><?php echo utf8_decode(limitarTexto($fluxoProcesso->getAtividade()->getTitulo(), 30)); ?></td> 
					<td style="<?php echo $colorcss; ?>" ><?php echo $sinal.valorMonetario($fluxoProcesso->getAtividade()->getValor(),'2'); ?></td> 
					<td style="text-align: center;"><?php echo ($fluxoProcesso->getAtivo() == '0')?'Fechado':'Aberto'; ?></td> 
				</tr>	
			<?php
		}
		$negativo = $negativo*(-1);
	}
	?>
		<tr>
			<td style="" colspan="3">&nbsp;</td> 
		</tr>
		<tr>
			<td style="" colspan="2">Provis&atilde;o:</td> 
			<td style="" ><?php echo 'R$ '.valorMonetario($objProcesso[0]->getProvisao(),'2'); ?></td> 
		</tr>
		<tr>
			<td style="" colspan="2">Total Positivo:</td> 
			<td style="" ><?php echo 'R$ '.valorMonetario($positivo,'2'); ?></td> 
		</tr>
		<tr>
			<td style="" colspan="2">Total Negativo:</td> 
			<td style="" ><?php echo 'R$ '.valorMonetario($negativo,'2'); ?></td> 
		</tr>  
		<tr>
			<td style="" colspan="2">Total Geral:</td> 
			<td style="" ><?php echo 'R$ '.valorMonetario(($positivo+$negativo),'2'); ?></td> 
		</tr>
		<tr>
			<td style="" colspan="2">Provis&atilde;o x Total Geral:</td> 
			<td style="" ><?php echo 'R$ '.valorMonetario(($objProcesso[0]->getProvisao()+($positivo+$negativo)),'2'); ?></td> 
		</tr>     				
	</tbody> 
</table>
<?php
// Envia o conteúdo do arquivo
exit;
?>