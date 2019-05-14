<?php

function selecao($valor1, $valor2) {
    $selecao = "";
    if (($valor1 == "" && $valor2 == 1) || ($valor1 == $valor2)) {
        $selecao = "selected='selected'";
    }
    return $selecao;
}

function destacarQtdEstoque($qtdMinimo, $qtdAtual) {

    if ((int) $qtdMinimo > 0) {
        if ((int) $qtdAtual <= (int) $qtdMinim) {
            $color = "color: #FF0000;";
        } else {
            $color = "color: #0000FF;";
        }
    } else {
        $color = "color: #000000;";
    }
    return $color;
}

function montaSelectEstados($valorSelecao) {
    $selectEstados .= "<option value='AC' " . selecao('AC', $valorSelecao) . ">AC</option>";
    $selectEstados .= "<option value='AL' " . selecao('AL', $valorSelecao) . ">AL</option>";
    $selectEstados .= "<option value='AM' " . selecao('AM', $valorSelecao) . ">AM</option>";
    $selectEstados .= "<option value='AP' " . selecao('AP', $valorSelecao) . ">AP</option>";
    $selectEstados .= "<option value='BA' " . selecao('BA', $valorSelecao) . ">BA</option>";
    $selectEstados .= "<option value='CE' " . selecao('CE', $valorSelecao) . ">CE</option>";
    $selectEstados .= "<option value='DF' " . selecao('DF', $valorSelecao) . ">DF</option>";
    $selectEstados .= "<option value='ES' " . selecao('ES', $valorSelecao) . ">ES</option>";
    $selectEstados .= "<option value='GO' " . selecao('GO', $valorSelecao) . ">GO</option>";
    $selectEstados .= "<option value='MA' " . selecao('MA', $valorSelecao) . ">MA</option>";
    $selectEstados .= "<option value='MG' " . selecao('MG', $valorSelecao) . ">MG</option>";
    $selectEstados .= "<option value='MS' " . selecao('MS', $valorSelecao) . ">MS</option>";
    $selectEstados .= "<option value='MT' " . selecao('MT', $valorSelecao) . ">MT</option>";
    $selectEstados .= "<option value='PA' " . selecao('PA', $valorSelecao) . ">PA</option>";
    $selectEstados .= "<option value='PB' " . selecao('PB', $valorSelecao) . ">PB</option>";
    $selectEstados .= "<option value='PE' " . selecao('PE', $valorSelecao) . ">PE</option>";
    $selectEstados .= "<option value='PI' " . selecao('PI', $valorSelecao) . ">PI</option>";
    $selectEstados .= "<option value='PR' " . selecao('PR', $valorSelecao) . ">PR</option>";
    $selectEstados .= "<option value='RJ' " . selecao('RJ', $valorSelecao) . ">RJ</option>";
    $selectEstados .= "<option value='RN' " . selecao('RN', $valorSelecao) . ">RN</option>";
    $selectEstados .= "<option value='RO' " . selecao('RO', $valorSelecao) . ">RO</option>";
    $selectEstados .= "<option value='RR' " . selecao('RR', $valorSelecao) . ">RR</option>";
    $selectEstados .= "<option value='RS' " . selecao('RS', $valorSelecao) . ">RS</option>";
    $selectEstados .= "<option value='SC' " . selecao('SC', $valorSelecao) . ">SC</option>";
    $selectEstados .= "<option value='SE' " . selecao('SE', $valorSelecao) . ">SE</option>";
    $selectEstados .= "<option value='SP' " . selecao('SP', $valorSelecao) . ">SP</option>";
    $selectEstados .= "<option value='TO' " . selecao('TO', $valorSelecao) . ">TO</option>";
    return $selectEstados;
}

function valor01($valor) {
    $valor1 = $valor;
    switch ($valor) {
        case "0": $valor1 = "00";
            break;
        case "1": $valor1 = "01";
            break;
        case "2": $valor1 = "02";
            break;
        case "3": $valor1 = "03";
            break;
        case "4": $valor1 = "04";
            break;
        case "5": $valor1 = "05";
            break;
        case "6": $valor1 = "06";
            break;
        case "7": $valor1 = "07";
            break;
        case "8": $valor1 = "08";
            break;
        case "9": $valor1 = "09";
            break;
    }
    return $valor1;
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
    }
    return $valor;
}

/**
 * 
 * Função reponsavel Retornar a String que reprensenta o Sexo
 * @param unknown_type $string
 * @param unknown_type $conversao
 */
function retornarSexo($sexo) {
    if ($sexo) {
        switch ($sexo) {
            case "M":
                $sexo = "Masculino";
                break;
            case "F":
                $sexo = "Feminino";
                break;
        }
        return $sexo;
    }
}

function retornarSexoAnimal($sexo) {
    if ($sexo) {
        switch ($sexo) {
            case "M":
                $sexo = "Macho";
                break;
            case "F":
                $sexo = "Fêmia";
                break;
        }
        return $sexo;
    }
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

function recuperaData($date) {
    if ($date == "") {
        return "";
    }
    $ano = substr($date, 0, 4);
    $mes = substr($date, 5, 2);
    $dia = substr($date, 8, 2);

    return $dia . "/" . $mes . "/" . $ano;
}

function recuperaDataHora($date) {
    if ($date == "") {
        return "";
    }
    $ano = substr($date, 0, 4);
    $mes = substr($date, 5, 2);
    $dia = substr($date, 8, 2);
    $hora = substr($date, 10, 9);
    return $dia . "/" . $mes . "/" . $ano . " " . $hora;
}

function montaEstadoCivil($valorSelecao) {
    $selectEstados .= "<option value='S' " . selecao('S', $valorSelecao) . ">SOLTEIRO(A)</option>";
    $selectEstados .= "<option value='C' " . selecao('C', $valorSelecao) . ">CASADO(A)</option>";
    $selectEstados .= "<option value='E' " . selecao('E', $valorSelecao) . ">SEPARADO(A)</option>";
    $selectEstados .= "<option value='D' " . selecao('D', $valorSelecao) . ">DIVORCIADO(A)</option>";
    $selectEstados .= "<option value='V' " . selecao('V', $valorSelecao) . ">VIÚVO(A)</option>";
    return $selectEstados;
}

function montaMes($valorSelecao) {
    $selectMes .= "<option value='01' " . selecao('01', $valorSelecao) . ">JANEIRO</option>";
    $selectMes .= "<option value='02' " . selecao('02', $valorSelecao) . ">FEVEREIRO</option>";
    $selectMes .= "<option value='03' " . selecao('03', $valorSelecao) . ">MARÇO</option>";
    $selectMes .= "<option value='04' " . selecao('04', $valorSelecao) . ">ABRIL</option>";
    $selectMes .= "<option value='05' " . selecao('05', $valorSelecao) . ">MAIO</option>";
    $selectMes .= "<option value='06' " . selecao('06', $valorSelecao) . ">JUNHO</option>";
    $selectMes .= "<option value='07' " . selecao('07', $valorSelecao) . ">JULHO</option>";
    $selectMes .= "<option value='08' " . selecao('08', $valorSelecao) . ">AGOSTO</option>";
    $selectMes .= "<option value='09' " . selecao('09', $valorSelecao) . ">SETEMBRO</option>";
    $selectMes .= "<option value='10' " . selecao('10', $valorSelecao) . ">OUTUBRO</option>";
    $selectMes .= "<option value='11' " . selecao('11', $valorSelecao) . ">NOVEMBRO</option>";
    $selectMes .= "<option value='12' " . selecao('12', $valorSelecao) . ">DEZEMBRO</option>";

    return $selectMes;
}

function recuperarEstadoCivil($estadoCivil) {
    switch ($estadoCivil) {
        case "S":
            $retorno = "SOLTEIRO(A)";
            break;
        case "C":
            $retorno = "CASADO(A)";
            break;
        case "E":
            $retorno = "SEPARADO(A)";
            break;
        case "D":
            $retorno = "DIVORCIADO(A)";
            break;
        case "V":
            $retorno = "VIÚVO(A)";
            break;
    }
    return $retorno;
}

function limitarTexto($string, $tamanho, $encode = 'UTF-8') {
    if (strlen($string) > $tamanho)
        $string = mb_substr($string, 0, $tamanho - 3, $encode) . '...';
    else
        $string = mb_substr($string, 0, $tamanho, $encode);

    return $string;
}

function zeroEsquerda($string) {
    if ($string) {
        $restante = (int) (5 - strlen($string));
        if ($restante > 0) {
            for ($i = 0; $i < $restante; $i++) {
                $retorno .= "0";
            }
        }
    }
    return $retorno . $string;
}

/**
 * Função responsavel por geração do gráfico no formato barra
 * Deve-se utilizar o formato abaixo respeitando a quantidade de ambos 
 *  var dados = [250, 350, 450];
 *  var ticks = ['March', 'April', 'May'];
 * @param $serie -> é a informação do assunto aqual esta sendo analizado
 * @param $dados -> a massa de dados necessario para exibição dos graficos 
 * @param $ticks -> são os labels das etiquetas que representa cada barra
 */
function exibirGraficoBarra($dados, $serie = null, $ticks, $label = null) {
    ?>
    <link rel="stylesheet" type="text/css" href="js/jqplot.1.0.8/jquery.jqplot.min.css" /> 
    <!--[if lt IE 9]><script language="javascript" type="text/javascript" src="js/jqplot.1.0.8/excanvas.min.js"></script><![endif]-->
    <script language="javascript" type="text/javascript" src="js/jqplot.1.0.8/jquery.jqplot.min.js"></script>
    <script language="javascript" type="text/javascript" src="js/jqplot.1.0.8/plugins/jqplot.barRenderer.min.js"></script>
    <script language="javascript" type="text/javascript" src="js/jqplot.1.0.8/plugins/jqplot.categoryAxisRenderer.min.js"></script>
    <div id="bar-chart" class="dashboard-long" ></div>
    <script type="text/javascript">
                $("#div_central").css("display", "");
                $(document).ready(function () {
        var plot1 = $.jqplot("bar-chart", [<?php echo $dados; ?>], {
        seriesDefaults: {
        renderer: $.jqplot.BarRenderer,
                rendererOptions: { fillToZero: true }
        },
    <?php
    if ($label) {
        ?>
            series: [
            { label: <?php echo $serie; ?> }
            ], show: false,
        <?php
    }
    ?>
        legend: {
        show: true,
                placement: "insideGrid"
        },
                axes: {
                xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                        ticks: <?php echo $ticks; ?>
                },
                        yaxis: {
                        pad: 1.05,
                                tickOptions: { formatString: "R$ %d   " }
                        }
                }
        });
        });</script>
    <?php
}

/**
 * Função responsavel por geração do gráfico no formato linha
 * Deve-se utilizar o formato abaixo respeitando a quantidade de ambos 
 *  var dados = [250, 350, 450];
 *  var ticks = ['March', 'April', 'May'];
 * @param $titulo -> é a informação do assunto aqual esta sendo analizado
 * @param $label_x -> é a informação do valor x aqual esta sendo exibido no plano cartesiano 
 * @param $label_y -> é a informação do valor y aqual esta sendo exibido no plano cartesiano
 * @param $dados -> a massa de dados necessario para exibição dos graficos 
 * @param $ticks -> são os labels das etiquetas que representa cada barra
 */
function exibirGraficoLinha($titulo, $dados, $label_x, $label_y, $ticks) {
    ?>
    <div id="chart1" class="dashboard-long" style="width:99%" ></div>
    <link rel="stylesheet" type="text/css" href="js/jqplot.1.0.8/jquery.jqplot.min.css" />
    <script type="text/javascript" src="js/jqplot.1.0.8/jquery.jqplot.min.js"></script>
    <script type="text/javascript" src="js/jqplot.1.0.8/plugins/jqplot.canvasTextRenderer.min.js"></script>
    <script type="text/javascript" src="js/jqplot.1.0.8/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>		
    <script type="text/javascript">
                $("#div_central").css("display", "");
                $(document).ready(function () {
        var plot2 = $.jqplot ("chart1", [<?php echo $dados; ?>], {
        title: "<?php echo $titulo; ?>",
                axesDefaults: {
                labelRenderer: $.jqplot.CanvasAxisLabelRenderer
                },
                seriesDefaults: {
                rendererOptions: {
                smooth: false
                }
                },
                legend: {
                background: "white",
                        textColor: "black",
                        fontFamily: "Times New Roman",
                        border: "1px solid black"
                },
                axes: {
                xaxis: {
                label: "<?php echo $label_x; ?>",
                        pad: 0,
                        ticks: <?php echo $ticks; ?>,
                        tickOptions: { formatString: "R$ %d   " }
                },
                        yaxis: {
                        label: "<?php echo $label_y; ?>"
                        }
                },
                axesStyles: {
                borderWidth: 0,
                        ticks: {
                        fontSize: "12pt",
                                fontFamily: "Times New Roman",
                                textColor: "black"
                        },
                        label: {
                        fontFamily: "Times New Roman",
                                textColor: "black"
                        }
                }
        });
        });</script>	    
    <?php
}

/**
 * Função responsavel por geração do gráfico no formato pizza
 * Deve-se utilizar o formato abaixo respeitando a quantidade de ambos 
 * var dados = [['March',250], ['April',350], ['May',450]];
 * @param $dados -> a massa de dados necessario para exibição dos graficos 
 */
function exibirGraficoPizza($dados) {
    ?>
    <script type="text/javascript" src="js/jqplot.1.0.8/jquery.jqplot.min.js"></script>
    <script type="text/javascript" src="js/jqplot.1.0.8/plugins/jqplot.pieRenderer.min.js"></script>
    <link rel="stylesheet" type="text/css" href="js/jqplot.1.0.8/jquery.jqplot.min.css" />
    <div id="pie1" class="dashboard-full" style="width:99%" ></div>
    <script type="text/javascript">
                $("#div_central").css("display", "");
                $(document).ready(function(){
        var plot1 = $.jqplot("pie1", [<?php echo $dados; ?>], {
        gridPadding: {top:0, bottom:38, left:0, right:0},
                seriesDefaults:{
                renderer:$.jqplot.PieRenderer,
                        trendline:{ show:true },
                        rendererOptions: { padding: 8, showDataLabels: true }
                },
                legend:{
                show:true,
                        placement: "inside",
                        rendererOptions: {
                        numberRows: 31
                        },
                        location:"e",
                        marginTop: "15px"
                },
                axesStyles: {
                borderWidth: 0,
                        ticks: {
                        fontSize: "12pt",
                                fontFamily: "Times New Roman",
                                textColor: "black"
                        },
                        label: {
                        fontFamily: "Times New Roman",
                                textColor: "black"
                        }
                }
        });
        });</script>
    <?php
}

function exibirQuestion($identificador,$sim,$nao, $titulo, $frase) {
    ?>
		<!-- Modal -->
		<div class="modal" id="<?php echo $identificador; ?>" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel"><?php echo $titulo; ?></h5>
		        <!-- button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button-->
		      </div>
		      <div class="modal-body">
		        <?php echo $frase; ?>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" id="<?php echo $nao; ?>" >Não</button>
		        <button type="button" class="btn btn-primary" id="<?php echo $sim; ?>" >Sim</button>
		      </div>
		    </div>
		  </div>
		</div>		    
    <?php 
}

?>