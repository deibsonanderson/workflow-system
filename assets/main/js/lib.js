// JavaScript 

$(document).ready(function() {

    /*
     Bloco abaixo é responsavel pela navegação das abas ocutando todas e em seguida
     exibindo apenas a clicada! 
     */
    $('.li_aba').on('click', function() {
        $('.div_cad').css('display', 'none'); //tornar todos os elementos invisiveis
        $($(this).attr('rel')).css('display', ''); //tornar visivel apenas o proprio elemento

        $('.li_aba').css('background', '#DFDFDF'); //tornar todas as listar brancas
        $(this).css('background', '#FFFFFF'); //tornar a lista pai do proprio objeto cinza

        $('body,html').animate({
            scrollTop: 0 //Ancora para ficar no topo
        });
    });

    /**
     * Função reponsavel por cadastros de formulario
     */
    $('.formCadastro').on('click', function() {

        valido = true;
        $('#formCadastro').each(function() {
            campos = $(this).serialize();
            retorno = $('[name=retorno]', this).val();
            mensagem = $('[name=mensagem]', this).val();

        });
        //Bloco localiza todos os campos da classo mensagem Aleta e exibe o span correpondente
        $('.mgs_alerta').each(function() {

            if ($(this).val() == '' || $(this).val() == null) {
                valido = false;
                $(this).addClass('error');

                if ($('#span_' + $(this).attr('name'))) {
                    $('#span_' + $(this).attr('name')).css('display', '');
                    msgSlide("14");
                }
            } else {
                $(this).removeClass('error');
                if ($('#span_' + $(this).attr('name'))) {
                    $('#span_' + $(this).attr('name')).css('display', 'none');
                }
            }

            //Esse Bloco valida apenas os campos do tipo senha
            if ($('#senha')) {
                if ($('#senha').val() != $('#senha2').val()) {
                    valido = false;
                    msgSlide("9");
                    $('#senha').addClass('error');
                    $('#senha2').addClass('error');

                    if ($('#span_' + $(this).attr('name'))) {
                        $('#span_' + $(this).attr('name')).css('display', '');
                    }

                }
            }

        });


        //validarData
        $('.data').each(function() {
            if ($(this).val() != '' && $(this).val() != null) {
                if (validarData($(this).val()) == false) {
                    valido = false;
                    $(this).addClass('error');
                    if ($('#span_' + $(this).attr('name'))) {
                        $('#span_' + $(this).attr('name')).css('display', '');
                        //msgSlide("17");						
                    }
                }
            }
        });

        //validarCheckBox
        $('.check-fluxo').each(function() {
            if ($(".check-fluxo:checked").length === 0) {
                valido = false;
                $(this).addClass('error');
                if ($('#span_' + $(this).attr('name'))) {
                    $('#span_' + $(this).attr('name')).css('display', '');
                    msgSlide("18");
                }
            }
        });


        //Caso todos os campos obrigatorios tenham sido preenchido a ação sera execultada
        if (valido == true) {

            $('#' + retorno).css('display', '');
            $.ajax({
                url: 'controlador.php',
                type: 'POST',
                data: campos,
                success: function(result) {
                    $('#' + retorno).html(result);
                },
                beforeSend: function() {
                    $('#loader').css({
                        display: "block"
                    });
                    $('#div-loader').css({
                        opacity: 0.5
                    });

                },
                complete: function() {
                    $('#loader').css({
                        display: "none"
                    });
                    $('#div-loader').css({
                        opacity: 1.0
                    });
                    if (mensagem) {
                        msgSlide(mensagem);
                    }

                }
            });
        }

    });


    /**
     * 
     * Função responsavel por gerar ação atraves de um bottao ou ate mesmo imagem
     */
    $('.buttonCadastro').on('click', function() {
        controlador = $(this).attr('controlador');
        funcao = $(this).attr('funcao');
        retorno = $(this).attr('retorno');


        $.ajax({
            url: 'controlador.php',
            type: 'POST',
            data: 'retorno=' + retorno + '&controlador=' + controlador + '&funcao=' + funcao,
            success: function(result) {
                $('#' + retorno).html(result);
            },
            beforeSend: function() {
                $('#loader').css({
                    display: "block"
                });
                $('#div-loader').css({
                    opacity: 0.5
                });
            },
            complete: function() {
                $('#loader').css({
                    display: "none"
                });
                $('#div-loader').css({
                    opacity: 1.0
                });
                $('#div_a').remove();
                $('#' + retorno).css('display', '');

            }
        });
    });

    /**
     * 
     * Função responsavel por gerar ação atraves de um bottao ou ate mesmo imagem
     */
    $('.buttonMenu').on('click', function() {
        controlador = $(this).attr('controlador');
        funcao = $(this).attr('funcao');
        retorno = $(this).attr('retorno');
        secao = $(this).attr('secao');

        $.ajax({
            url: 'controlador.php',
            type: 'POST',
            data: 'retorno=' + retorno + '&controlador=' + controlador + '&funcao=' + funcao,
            success: function(result) {
                $('#' + retorno).html(result);
            },
            beforeSend: function() {
                $('#loader').css({
                    display: "block"
                });
                $('#div-loader').css({
                    opacity: 0.5
                });
            },
            complete: function() {
                $('#loader').css({
                    display: "none"
                });
                $('#div-loader').css({
                    opacity: 1.0
                });
                $('#div_a').remove();
                $('#' + retorno).css('display', '');

                $('.breadcrumb_menu').css('display', 'none');
                $('.' + secao).css('display', '');

            }
        });
    });

    /**
     * Função responsavel por gerar ação atraves de um bottao ou ate mesmo imagem
     * com o diferencial de enviar apenas o id no caso de edição ou exclusao
     */
    $('.getId').on('click', function() {

        id = $(this).attr('id');
        controlador = $(this).attr('controlador');
        funcao = $(this).attr('funcao');
        retorno = $(this).attr('retorno');
        mensagem = $(this).attr('mensagem');

        $.ajax({
            url: 'controlador.php',
            type: 'POST',
            data: 'retorno=' + retorno + '&controlador=' + controlador + '&funcao=' + funcao + '&id=' + id,
            success: function(result) {
                $('#' + retorno).html(result);
            },
            beforeSend: function() {
                $('#loader').css({
                    display: "block"
                });
                $('#div-loader').css({
                    opacity: 0.5
                });
            },
            complete: function() {
                $('#loader').css({
                    display: "none"
                });
                $('#div-loader').css({
                    opacity: 1.0
                });
                $('#div_a').remove();
                $('#' + retorno).css('display', '');
                if (mensagem) {
                    msgSlide(mensagem);
                }
            }
        });

    });
	
	
    /**
     * Função responsavel por gerar ação atraves de um bottao ou ate mesmo imagem
     * com o diferencial de enviar apenas o id no caso de edição ou exclusao
     */
    $('.getData').on('click', function() {

        data = $(this).attr('data');
        controlador = $(this).attr('controlador');
        funcao = $(this).attr('funcao');
        retorno = $(this).attr('retorno');
        mensagem = $(this).attr('mensagem');

        $.ajax({
            url: 'controlador.php',
            type: 'POST',
            data: 'retorno=' + retorno + '&controlador=' + controlador + '&funcao=' + funcao + '&data=' + data + '&isView=s',
            success: function(result) {
                $('#' + retorno).html(result);
            },
            beforeSend: function() {
                $('#loader').css({
                    display: "block"
                });
                $('#div-loader').css({
                    opacity: 0.5
                });
            },
            complete: function() {
                $('#loader').css({
                    display: "none"
                });
                $('#div-loader').css({
                    opacity: 1.0
                });
                $('#div_a').remove();
                $('#' + retorno).css('display', '');
                if (mensagem) {
                    msgSlide(mensagem);
                }
            }
        });

    });	

    //Esse metodo é utilizado para o Exemplo
    $('.getNovo').on('click', function() {

        value = $('.getAlterar').attr('value');
        if (value != 'nulo') {
            funcao = $(this).attr('funcao');
            array = value.split("|");
            limparCampo(array);

            $('[name=funcao]', '#formCadastro').val(funcao);
            $('[name=mensagem]', '#formCadastro').val('1');
            $('[name=btn-cadastro]', '#formCadastro').val('Incluir');
        }


    });

    /**
     * Esse metodo é utilizado para o Exemplo
     */
    $('.getAlterar').on('click', function() {

        value = $(this).attr('value');
        funcao = $(this).attr('funcao');
        array = value.split("|");

        limparCampo(array);

        for (var i = 0; i < array.length; i++) {
            aux = array[i].split(":");
            obj = $('[name=' + aux[0] + ']', '#formCadastro');

            switch ($(obj).attr('type')) {
                case "checkbox":
                    if (aux[1] != "N") {
                        $('[name=' + aux[0] + ']', '#formCadastro')[0].checked = true;
                    }
                    break;
                case "radio":
                    if (aux[1] != "") {
                        for (var t = 0; t < $('[name=' + aux[0] + ']', '#formCadastro').length; t++) {
                            if ($('[name=' + aux[0] + ']', '#formCadastro')[t].value == aux[1]) {
                                $('[name=' + aux[0] + ']', '#formCadastro')[t].checked = true;
                            }
                        }
                    }
                    break;
                case "hidden":
                    if (aux[1] != "") {
                        if ($(obj).attr('upload') == "imagem") {
                            $('[name=' + aux[0] + ']', '#formCadastro').val(aux[1]);
                            $('[name=' + aux[0] + 'Link]').attr('id', './imagens/' + $(obj).attr('caminho') + '/thumbnail' + aux[1]);
                            $('[name=' + aux[0] + 'Atual]').attr('src', './imagens/' + $(obj).attr('caminho') + '/thumbnail' + aux[1]);
                            $('[name=' + aux[0] + 'Icone]').attr('src', "img/edit-reject.gif");
                        } else if ($(obj).attr('upload') == "arquivo") {
                            $('[name=' + aux[0] + ']', '#formCadastro').val(aux[1]);
                            $('span[name=' + aux[0] + 'Atual]').html('<br />' + aux[1]);
                            $('[name=' + aux[0] + 'Atual]').attr('src', './arquivos/' + $(obj).attr('caminho') + '/' + aux[1]);
                            $('[name=' + aux[0] + 'Icone]').attr('src', "img/edit-reject.gif");
                            $('span[name=' + aux[0] + 'Atual]').css('cursor', 'pointer');
                            $('span[name=' + aux[0] + 'Atual]').css('text-decoration', 'underline');
                        } else {
                            $('[name=' + aux[0] + ']', '#formCadastro').val(aux[1]);
                        }
                    }
                    break;
                default:
                    $('[name=' + aux[0] + ']', '#formCadastro').val(aux[1]);
                    break;
            }
        }

        $('[name=funcao]', '#formCadastro').val(funcao);
        $('[name=mensagem]', '#formCadastro').val('2');
        $('[name=btn-cadastro]', '#formCadastro').val('Atualizar');
    });


    /**
     * Função responsavel por gerar uma tela de confirmação se sim execulta 
     * a ação caso nao apenas fecha a div
     */
    $('.deleteId').on('click', function() {
        $.blockUI({
            message: $('#question'),
            css: {
                width: '275px'
            }
        });
        id = $(this).attr('id');
        controlador = $(this).attr('controlador');
        funcao = $(this).attr('funcao');
        retorno = $(this).attr('retorno');
        mensagem = $(this).attr('mensagem');

        $('#sim').click(function() {
            $('#' + retorno).css('display', '');

            $.ajax({
                url: 'controlador.php',
                type: 'POST',
                data: 'retorno=' + retorno + '&controlador=' + controlador + '&funcao=' + funcao + '&id=' + id,
                success: function(result) {
                    $('#' + retorno).html(result);
                },
                beforeSend: function() {
                    $('#loader').css({
                        display: "block"
                    });
                    $('#div-loader').css({
                        opacity: 0.5
                    });
                },
                complete: function() {
                    $('#loader').css({
                        display: "none"
                    });
                    $('#div-loader').css({
                        opacity: 1.0
                    });
                    $.unblockUI();
                    if (mensagem) {
                        msgSlide(mensagem);
                    }
                }
            });
        });

        $('#nao').click(function() {
            $.unblockUI();
            return false;
        });
    });


    /**
     * Função responsavel por gerar uma tela de confirmação se sim execulta 
     * a ação caso nao apenas fecha a div
     */
    $('.fecharProcesso').on('click', function() {
        $.blockUI({
            message: $('#question-processo'),
            css: {
                width: '275px'
            }
        });
        id = $(this).attr('id');
        controlador = $(this).attr('controlador');
        funcao = $(this).attr('funcao');
        retorno = $(this).attr('retorno');
        mensagem = $(this).attr('mensagem');

        $('#sim-p').click(function() {
            $('#' + retorno).css('display', '');
            $.ajax({
                url: 'controlador.php',
                type: 'POST',
                data: 'retorno=' + retorno + '&controlador=' + controlador + '&funcao=' + funcao + '&id=' + id,
                success: function(result) {
                    $('#' + retorno).html(result);
                },
                beforeSend: function() {

                    $('#loader').css({
                        display: "block"
                    });
                    $('#div-loader').css({
                        opacity: 0.5
                    });
                },
                complete: function() {
                    $('#loader').css({
                        display: "none"
                    });
                    $('#div-loader').css({
                        opacity: 1.0
                    });
                    $.unblockUI();
                    if (mensagem) {
                        msgSlide(mensagem);
                    }
                }
            });
        });

        $('#nao-p').click(function() {
            $.unblockUI();
            return false;
        });
    });


    /**
     * Função responsavel por gerar as mensagem de aleta 
     * atraves do Slide
     * 
     */
    function msgSlide(msg) {
        if (msg != "") {

            switch (msg) {
                case "1":
                    msg1 = "Item inserido com sucesso!";
                    tipo = "check";
                    break;
                case "2":
                    msg1 = "Item editado com sucesso!";
                    tipo = "check";
                    break;
                case "3":
                    msg1 = "É necessário ter inserido pelo menos um item na lista!";
                    tipo = "close";
                    break;
                case "4":
                    msg1 = "Item excluído com sucesso!";
                    tipo = "check";
                    break;
                case "5":
                    msg1 = "Acesso não autorizado favor informar o usuário e senha!";
                    tipo = "close";
                    break;
                case "9":
                    msg1 = "As senhas não coincidem!";
                    tipo = "close";
                    break;
                case "10":
                    msg1 = "Usuário ou senha invalidos!";
                    tipo = "close";
                    break;
                case "12":
                    msg1 = "É necessário cadastrar um Cliente antes!";
                    tipo = "block"
                    break;
                case "13":
                    msg1 = "Arquivo removido com sucesso!";
                    tipo = "check";
                    break;
                case "14":
                    msg1 = "Os Campos obrigatorios deve ser preenchidos!";
                    tipo = "close";
                    break;
                case "15":
                    msg1 = "Movimentação de entrada de produto realizado com sucesso!";
                    tipo = "check";
                    break;
                case "16":
                    msg1 = "Movimentação de saida de produto realizado com sucesso!";
                    tipo = "check";
                    break;
                case "17":
                    msg1 = "A(s) Data(s) deve ser preenchidas corretamente!";
                    tipo = "close";
                    break;
                case "18":
                    msg1 = "Deve-se selecionar pelo menos uma atividade para o fluxo!";
                    tipo = "close";
                    break;

                default:
                    msg1 = msg;
                    break;
            }
        }
        if (tipo == "check") {
            $.growlUI(msg1, '&nbsp;');
        } else if (tipo = "close") {
            $.growlUI2(msg1, '&nbsp;');
        } else if (tipo == "block") {
            //Responsavel por Gerar o Bloqueio completo da Tela
            $.blockUI({
                message: '<h1>Please wait...</h1>',
                title: null,
                draggable: true,
                theme: false,
                css: {
                    padding: 0,
                    margin: 0,
                    width: '30%',
                    top: '40%',
                    left: '35%',
                    textAlign: 'center',
                    color: '#000',
                    border: '3px solid #aaa',
                    backgroundColor: '#fff',
                    cursor: 'wait'
                },
                themedCSS: {
                    width: '30%',
                    top: '40%',
                    left: '35%'
                },
                overlayCSS: {
                    backgroundColor: '#000',
                    opacity: 0.6,
                    cursor: 'wait'
                },
                cursorReset: 'default',
                growlCSS: {
                    width: '350px',
                    top: '10px',
                    left: '',
                    right: '10px',
                    border: 'none',
                    padding: '5px',
                    opacity: 0.6,
                    cursor: null,
                    color: '#fff',
                    backgroundColor: '#000',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px'
                },
                iframeSrc: /^https/i.test(window.location.href || '') ? 'javascript:false' : 'about:blank',
                forceIframe: false,
                baseZ: 1000,
                centerX: true, // <-- only effects element blocking (page block controlled via css above)
                centerY: true,
                allowBodyStretch: true,
                bindEvents: true,
                constrainTabKey: true,
                fadeIn: 200,
                fadeOut: 400,
                timeout: 0,
                showOverlay: true,
                focusInput: true,
                onBlock: null,
                onUnblock: null,
                quirksmodeOffsetHack: 4,
                blockMsgClass: 'blockMsg',
                ignoreIfBlocked: false,
                onOverlayClick: $.unblockUI
            });
        }
        //$('#msgSlide').html('<span>'+msg1+'</span>');
        //$('#msgSlide').slideDown('slow', function() {
        //	setTimeout("$('#msgSlide').slideUp('slow')",3000);
        //});

    }



    /**
     * Função reponsavel validar o login
     */
    $('.formLogin').on('click', function() {

        if ($('#login').val() != "" && $('#senha').val() != "") {

            $('#formLogin').each(function() {
                campos = $(this).serialize();
                retorno = $(this).children('#retorno').val();
                mensagem = $(this).children('#mensagem').val();
            });

            //Caso todos os campos obrigatorios tenham sido preenchido a ação sera execultada

            $.ajax({
                url: 'controlador.php',
                type: 'POST',
                data: campos,
                success: function(result) {
                    $('#' + retorno).html(result);
                },
                beforeSend: function() {
                    $('#loader').css({
                        display: "block"
                    });
                    $('#div-loader').css({
                        opacity: 0.5
                    });
                },
                complete: function() {
                    $('#loader').css({
                        display: "none"
                    });
                    $('#div-loader').css({
                        opacity: 1.0
                    });
                }
            });


        } else {
            $('#formLogin').each(function() {
                mensagem = $(this).children('#mensagem').val();
                $('#msgSlide').html('<span>Usuário ou senha invalidos!</span>');
                $('#msgSlide').slideDown('slow', function() {
                    setTimeout("$('#msgSlide').slideUp('slow')", 3000);
                });
                //msgSlide(mensagem);
            });
        }

    });


    /**
     * Função responsavel por recarregar a tela de listar
     */
    $('.getRecarregar').on('click', function() {

        limite = $(this).attr('limite');
        controlador = $(this).attr('controlador');
        funcao = $(this).attr('funcao');
        retorno = $(this).attr('retorno');
        mensagem = $(this).attr('mensagem');

        $.ajax({
            url: 'controlador.php',
            type: 'POST',
            data: 'retorno=' + retorno + '&controlador=' + controlador + '&funcao=' + funcao + '&limite=' + limite,
            success: function(result) {
                $('#' + retorno).html(result);
            },
            beforeSend: function() {
                $('#loader').css({
                    display: "block"
                });
                $('#div-loader').css({
                    opacity: 0.5
                });
            },
            complete: function() {
                $('#loader').css({
                    display: "none"
                });
                $('#div-loader').css({
                    opacity: 1.0
                });
                $('#div_a').remove();
                $('#' + retorno).css('display', '');
                if (mensagem) {
                    msgSlide(mensagem);
                }
            }
        });

    });

    /**
     * Função responsavel por gerar ação atraves de um bottao ou ate mesmo imagem
     * com o diferencial de enviar apenas o id no caso de edição ou exclusao
     */
    $('.getIdProcesso').on('click', function() {

        id = $(this).attr('id');
        ativo = $(this).attr('ativo');
        atuante = $(this).attr('atuante');
        id_processo = $(this).attr('id_processo');
        id_processo_fluxo = $(this).attr('id_processo_fluxo');
        controlador = $(this).attr('controlador');
        funcao = $(this).attr('funcao');
        retorno = $(this).attr('retorno');
        mensagem = $(this).attr('mensagem');

        $.ajax({
            url: 'controlador.php',
            type: 'POST',
            data: 'retorno=' + retorno + '&controlador=' + controlador + '&funcao=' + funcao + '&id=' + id+'&id_processo='+ id_processo+'&id_processo_fluxo='+ id_processo_fluxo+'&ativo='+ativo+'&atuante='+atuante,
            success: function(result) {
                $('#' + retorno).html(result);
            },
            beforeSend: function() {
                $('#loader').css({
                    display: "block"
                });
                $('#div-loader').css({
                    opacity: 0.5
                });
            },
            complete: function() {
                $('#loader').css({
                    display: "none"
                });
                $('#div-loader').css({
                    opacity: 1.0
                });
                $('#div_a').remove();
                $('#' + retorno).css('display', '');
                if (mensagem) {
                    msgSlide(mensagem);
                }
            }
        });

    });

}); //FIM do documento do ready

/**
 * Função reponsavel Ativar ação de enter no sistema
 */
/*function enterPressed(evn) {
 if (window.event && window.event.keyCode == 13) {
 $('.formCadastro').click();
 } else if (evn && evn.keyCode == 13) {
 $('.formCadastro').click();				   
 }
 }
 document.onkeypress = enterPressed;
 */


/**
 * Função reponsavel por gerar o "Data Picker" no formulário
 */
function setDatePicker(containerElement) {
    var datePicker = $('#' + containerElement);
    datePicker.datepicker({
        showOn: "button",
        buttonImage: "img/calendar.gif",
        buttonImageOnly: true
    });
}


/**
 * Função responsavel por colocar zero a esquerda
 * @param n = valor
 * @param len = quantidade
 * @param padding = simbolo
 * @returns {String}
 */
function pad(n, len, padding) {
    var sign = '', s = n;

    if (typeof n === 'number') {
        sign = n < 0 ? '-' : '';
        s = Math.abs(n).toString();
    }

    if ((len -= s.length) > 0) {
        s = Array(len + 1).join(padding || '0') + s;
    }
    return sign + s;
}


function valorMonetario(valor, conversao) {
    switch (conversao) {
        case "1":
            valor = valor.replace(" ", "");
            valor = valor.replace(".", "");
            valor = valor.replace(",", ".");
            break;

        case "2":
            valor = valor.replace(" ", "");
            valor = valor.replace(",", "");
            valor = valor.replace(".", ",");
            break;
    }
    return valor;
}


function validarData(value) {
    var expReg = /^(([0-2]\d|[3][0-1])\/([0]\d|[1][0-2])\/[1-2][0-9]\d{2})$/;
    var msgErro = 'Formato inválido de data.';
    if ((value.match(expReg)) && (value != '')) {
        return true;
    } else {
        return false;
    }
}


//Função responsavel por exibir e ocultar os itens
var exibir_todos = 'sim';
function exibirOcutarItens(itens, tipo) {
    switch (tipo) {
        case "unitario":
            if ($('.itens_' + itens).attr('visivel') == 'true') {
                $('.itens_' + itens).removeClass('visivel');
                $('.itens_' + itens).addClass('invisivel');
                $('.itens_' + itens).attr('visivel', 'false');
                $('#img_unitario_' + itens).attr('src', 'img/notes-reject.gif');
            } else {
                $('.itens_' + itens).removeClass('invisivel');
                $('.itens_' + itens).addClass('visivel');
                $('.itens_' + itens).attr('visivel', 'true');
                $('#img_unitario_' + itens).attr('src', 'img/notes-add.gif');
            }
            break;
        case "todos":
            if (exibir_todos == 'sim') {
                $('.item').removeClass('visivel');
                $('.item').addClass('invisivel');
                $('.item').attr('visivel', 'false');
                $('.img_todos').attr('src', 'img/notes-reject.gif');
                exibir_todos = 'nao';
            } else {
                $('.item').removeClass('invisivel');
                $('.item').addClass('visivel');
                $('.item').attr('visivel', 'true');
                $('.img_todos').attr('src', 'img/notes-add.gif');
                exibir_todos = 'sim';
            }
            break;
    }
}//Fim da Função responsavel por exibir e ocultar os itens



/**
 * Função responsavel por limpar todos os campos 
 * @param array[0] o nome do campo
 * @param array[1] o valor do campo 
 */
function limparCampo(array) {

    for (var i = 0; i < array.length; i++) {
        aux = array[i].split(":");
        obj = $('[name=' + aux[0] + ']', '#formCadastro');

        switch ($(obj).attr('type')) {
            case "checkbox":
                $('[name=' + aux[0] + ']', '#formCadastro')[0].checked = false;
                break;
            case "radio":
                $('[name=' + aux[0] + ']', '#formCadastro')[0].checked = true;
                break;
            case "hidden":
                if ($(obj).attr('upload') == "imagem") {
                    $('[name=' + aux[0] + ']', '#formCadastro').val('');
                    $('[name=' + aux[0] + 'Link]').attr('id', './img/imagemPadrao.jpg');
                    $('[name=' + aux[0] + 'Atual]').attr('src', './img/imagemPadrao.jpg');
                    $('[name=' + aux[0] + 'Icone]').attr('src', "img/notes-add.gif");
                } else if ($(obj).attr('upload') == "arquivo") {
                    $('[name=' + aux[0] + ']', '#formCadastro').val('');
                    $('span[name=' + aux[0] + 'Atual]').html("<br />Adicione um arquivo clicando no <img src='img/notes-add.gif' border='0' /> ao lado.");

                    $('[name=' + aux[0] + 'Icone]').attr('title', "Clique para adicionar");
                    $('[name=' + aux[0] + 'Icone]').attr('src', "img/notes-add.gif");

                    $('span[name=' + aux[0] + 'Atual]').css('cursor', 'default');
                    $('span[name=' + aux[0] + 'Atual]').css('text-decoration', 'none');
                }
                break;
            default:
                $('[name=' + aux[0] + ']', '#formCadastro').val('');
                break;
        }
    }
}

/**
 * Metodo utilizado pelo forms upload
 * @returns {undefined}
 */
function vaiSubmit() {
    $('#enviar').click();
}