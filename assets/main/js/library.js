(function () {
    "use strict";

    var treeviewMenu = $('.app-menu');

    // Toggle Sidebar
    $('[data-toggle="sidebar"]').click(function(event) {
        event.preventDefault();
        $('.app').toggleClass('sidenav-toggled');
    });

    // Activate sidebar treeview toggle
    $("[data-toggle='treeview']").click(function(event) {
        event.preventDefault();
        if(!$(this).parent().hasClass('is-expanded')) {
            treeviewMenu.find("[data-toggle='treeview']").parent().removeClass('is-expanded');
        }
        $(this).parent().toggleClass('is-expanded');
    });

    // Set initial active toggle
    $("[data-toggle='treeview.'].is-expanded").parent().toggleClass('is-expanded');

    //Activate bootstrip tooltips
    try{
    	$("[data-toggle='tooltip']").tooltip();
    }catch (e) {}
})();


// JavaScript 

	/**
	 * Função responsavel por gerar ação atraves de um bottao ou ate mesmo imagem
	 * com o diferencial de enviar apenas o id no caso de edição ou exclusao
	 */
	function fcnGetData(element) {
		data = $(element).attr('data');
		controlador = $(element).attr('controlador');
		funcao = $(element).attr('funcao');
		retorno = $(element).attr('retorno');
		mensagem = $(element).attr('mensagem');
	
		$.ajax({
			url : 'controlador.php',
			type : 'POST',
			data : 'retorno=' + retorno + '&controlador=' + controlador
					+ '&funcao=' + funcao + '&data=' + data + '&isView=s',
			success : function(result) {
				$('#' + retorno).html(result);
			},
			beforeSend : function() {
				showLoading();
			},
			complete : function() {
				hideLoading();
				$('#div_a').remove();
				$('#' + retorno).css('display', '');
				if (mensagem) {
					msgSlide(mensagem);
				}
			}
		});
	}	

    /**
	 * Função reponsavel por cadastros de formulario
	 */    
    function fncFormCadastro(element){    

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
                	showLoading();
                },
                complete: function() {
                	hideLoading();
                    if (mensagem) {
                        msgSlide(mensagem);
                    }

                }
            });
        }
    };


    /**
     * 
     * Função responsavel por gerar ação atraves de um bottao ou ate mesmo imagem
     */
    function fncButtonCadastro(element){
        controlador = $(element).attr('controlador');
        funcao = $(element).attr('funcao');
        retorno = $(element).attr('retorno');
        pagina = $(element).attr('pagina')

        $.ajax({
            url: 'controlador.php',
            type: 'POST',
            data: 'retorno=' + retorno + '&controlador=' + controlador + '&funcao=' + funcao + '&pagina='+ pagina,
            success: function(result) {
                $('#' + retorno).html(result);
            },
            beforeSend: function() {
            	showLoading();
            },
            complete: function() {
            	hideLoading();
                $('#div_a').remove();
                $('#' + retorno).css('display', '');

            }
        });
    };

    
    function fcnModalDeleteId(element){
    	var modal = $(element).attr('modal');
    	$.blockUI({
            message: $('#'+modal),
            css: {
                width: '275px'
            }
        });
        $('#question-confirm').attr('idObjeto',$(element).attr('id'));
        $('#question-confirm').attr('controlador',$(element).attr('controlador'));
        $('#question-confirm').attr('funcao',$(element).attr('funcao'));
        $('#question-confirm').attr('retorno',$(element).attr('retorno'));
        $('#question-confirm').attr('mensagem',$(element).attr('mensagem'));
        $('#question-confirm').attr('processoFluxoId',$(element).attr('processoFluxoId'));
    }
    /**
     * Função responsavel por gerar uma tela de confirmação se sim execulta 
     * a ação caso nao apenas fecha a div
     */
    function fncDeleteId(element){
    	id = $(element).attr('idObjeto');
        controlador = $(element).attr('controlador');
        funcao = $(element).attr('funcao');
        retorno = $(element).attr('retorno');
        mensagem = $(element).attr('mensagem');
        processoFluxoId = $(element).attr('processoFluxoId');
        	
        $('#' + retorno).css('display', '');

        $.ajax({
            url: 'controlador.php',
            type: 'POST',
            data: 'retorno=' + retorno + '&controlador=' + controlador + '&funcao=' + funcao + '&id=' + id + '&processoFluxoId='+processoFluxoId,
            success: function(result) {
                $('#' + retorno).html(result);
            },
            beforeSend: function() {
            	showLoading();
            },
            complete: function() {
            	hideLoading();
                $.unblockUI();
                if (mensagem) {
                    msgSlide(mensagem);
                }
            }
        });
    }
    
    function fcnFecharModalQuestion(){
        $.unblockUI();
        return false;    	
    }


    /**
     * Função reponsavel validar o login
     */
    function fncFormLogin(element){

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
                	showLoading();
                },
                complete: function() {
                	hideLoading();
                },
                error: function(){
                	$('#formLogin').each(function() {
                        fncSlideMessageLogin('Usuário ou senha invalidos!');
                    });                	
                }
            });


        } else {
            $('#formLogin').each(function() {
                fncSlideMessageLogin('O Usuário ou senha não podem ser vazios!');
            });
        }
    };
    
    function fncSlideMessageLogin(texto){
        $('#msgSlide').html('<span>'+texto+'</span>');
        $('#msgSlide').slideDown('slow', function() {
            setTimeout("$('#msgSlide').slideUp('slow')", 3000);
        });  
    }


    function fncRecuperarData(data){
        if (data == "" || data == null || data == undefined) {
            return "";
        }
        
        var ano = data.substring(0, 4);
        var mes = data.substring(5, 7);
        var dia = data.substring(8, 11);

        return dia + "/" + mes + "/" + ano;
    }
    
    function fncDesformataData(data){
        if (data == "" || data == null || data == undefined) {
            return "";
        }
        
        var dia = data.substring(0, 2);
        var mes = data.substring(3, 5);
        var ano = data.substring(6, 10);

        return ano + "-" + mes + "-" + dia;    	
    }


    /**
     * 
     * Função responsavel por gerar ação atraves de um bottao ou ate mesmo imagem
     */
    function fncButtonMenu(element){
        controlador = $(element).attr('controlador');
        funcao = $(element).attr('funcao');
        retorno = $(element).attr('retorno');
        secao = $(element).attr('secao');
        
        $.ajax({
            url: 'controlador.php',
            type: 'POST',
            data: 'retorno=' + retorno + '&controlador=' + controlador + '&funcao=' + funcao,
            success: function(result) {
            	$('#navbarButton').click();
                $('#' + retorno).html(result);
            },
            beforeSend: function() {
            	showLoading();
            },
            complete: function() {
            	hideLoading();
                $('#div_a').remove();
                $('#' + retorno).css('display', '');

                $('.breadcrumb_menu').css('display', 'none');
                $('.' + secao).css('display', '');

            }
        });
    };




    /**
     * Função responsavel por gerar ação atraves de um bottao ou ate mesmo imagem
     * com o diferencial de enviar apenas o id no caso de edição ou exclusao
     */
    function getId(element) {

        id = $(element).attr('id');
        controlador = $(element).attr('controlador');
        funcao = $(element).attr('funcao');
        retorno = $(element).attr('retorno');
        mensagem = $(element).attr('mensagem');
        ordem = $(element).attr('ordem');
        $.ajax({
            url: 'controlador.php',
            type: 'POST',
            data: 'retorno=' + retorno + '&controlador=' + controlador + '&funcao=' + funcao + '&id=' + id + '&ordem=' + ordem,
            success: function(result) {
                $('#' + retorno).html(result);
            },
            beforeSend: function() {
            	showLoading();
            },
            complete: function() {
            	hideLoading();
                $('#div_a').remove();
                $('#' + retorno).css('display', '');
                if (mensagem) {
                    msgSlide(mensagem);
                }
            }
        });

    };


    /**
     * Funcção responsavel por recuperar um ID de um Selec / ComboBox
     * @param element
     * @returns
     */
    function getIdSelec(element, paramIn) {

        id = $(element).val();
        controlador = $(element).attr('controlador');
        funcao = $(element).attr('funcao');
        retorno = $(element).attr('retorno');
        mensagem = $(element).attr('mensagem');

        $.ajax({
            url: 'controlador.php',
            type: 'POST',
            data: 'retorno=' + retorno + '&controlador=' + controlador + '&funcao=' + funcao + '&id=' + id + '&param=' + paramIn,
            success: function(result) {
            	$('#' + retorno).html(result);
            },
            beforeSend: function() {
            	showLoading();
            },
            complete: function() {
            	hideLoading();
                $('#' + retorno).css('display', '');
                if (mensagem) {
                    msgSlide(mensagem);
                }
            }
        });

    };
    
    

    /**
     * Função responsavel por gerar ação atraves de um bottao ou ate mesmo imagem
     * com o diferencial de enviar apenas o id no caso de edição ou exclusao
     */
    function getIdProcesso(element) {
        var id = $(element).attr('id');
        var ativo = $(element).attr('ativo');
        var atuante = $(element).attr('atuante');
        var id_processo = $(element).attr('id_processo');
        var id_processo_fluxo = $(element).attr('id_processo_fluxo');
        var titulo_processo_fluxo = $(element).attr('titulo_processo_fluxo');
        var vencimento_processo_fluxo = $(element).attr('vencimento_processo_fluxo');
        var descricao_processo_fluxo = $(element).attr('descricao_processo_fluxo');
        var valor_processo_fluxo = $(element).attr('valor_processo_fluxo');
        controlador = $(element).attr('controlador');
        funcao = $(element).attr('funcao');
        retorno = $(element).attr('retorno');
        mensagem = $(element).attr('mensagem');

        $.ajax({
            url: 'controlador.php',
            type: 'POST',
            data: 'retorno=' + retorno + '&controlador=' + controlador + '&funcao=' + funcao + '&id=' + id+'&id_processo='+ id_processo+'&id_processo_fluxo='+ id_processo_fluxo+'&ativo='+ativo+'&atuante='+atuante+'&titulo_processo_fluxo='+titulo_processo_fluxo+'&vencimento_processo_fluxo='+vencimento_processo_fluxo+'&descricao_processo_fluxo='+descricao_processo_fluxo+'&valor_processo_fluxo='+valor_processo_fluxo,
            success: function(result) {
                $('#' + retorno).html(result);
            },
            beforeSend: function() {
            	showLoading();
            },
            complete: function() {
            	hideLoading();
                $('#div_a').remove();
                $('#' + retorno).css('display', '');
                if (mensagem) {
                    msgSlide(mensagem);
                }
            }
        });
    }
    
    function fncDeleteProcessoFluxo(element){
    	var modal = $(element).attr('modal');
        $.blockUI({
            message: $('#'+modal),
            css: {
                width: '275px'
            }
        });
        var id = $(element).attr('id');
        var id_processo = $(element).attr('id_processo');
        controlador = $(element).attr('controlador');
        funcao = $(element).attr('funcao');
        retorno = $(element).attr('retorno');
        mensagem = $(element).attr('mensagem');
        

        $('#sim').click(function() {
            $('#' + retorno).css('display', '');
            $.ajax({
                url: 'controlador.php',
                type: 'POST',
                data: 'retorno=' + retorno + '&controlador=' + controlador + '&funcao=' + funcao + '&id=' + id+'&id_processo='+ id_processo,
                success: function(result) {
                    $('#' + retorno).html(result);
                },
                beforeSend: function() {
                	showLoading();
                },
                complete: function() {
                	hideLoading();
                    $('#div_a').remove();
                    $('#' + retorno).css('display', '');
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
    }


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
                msg1 = "Houve um erro inesperado!";
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
}



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
        //showOn: "button",
        //buttonImage: "img/calendar.gif",
        //buttonImageOnly: true
    });
}


/**
 * Função reponsavel por gerar o editor de Texto no formulário
 */
function setupTinyMCEMini(readonly) {
    $('textarea.tinymce').tinymce({
        // Location of TinyMCE script
        script_url: 'js/tiny-mce/tiny_mce.js',
        readonly: readonly,
        // General options
        theme: "advanced",
        plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
        // Theme options
        //theme_advanced_buttons1: "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons1: "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull",
        theme_advanced_buttons4: "styleselect,formatselect,fontselect,fontsizeselect",
        //theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code",
        //theme_advanced_buttons3: "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,fullscreen",
        //theme_advanced_buttons4: "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,|,forecolor,backcolor,|,insertdate,inserttime,preview,|,ltr,rtl",
        theme_advanced_toolbar_location: "top",
        theme_advanced_toolbar_align: "left",
        theme_advanced_statusbar_location: "bottom",
        theme_advanced_resizing: false,
        // Example content CSS (should be your site CSS)
        content_css: "css/content.css",
        // Drop lists for link/image/media/template dialogs
        template_external_list_url: "lists/template_list.js",
        external_link_list_url: "lists/link_list.js",
        external_image_list_url: "lists/image_list.js",
        media_external_list_url: "lists/media_list.js",
        // Replace values for the template plugin
        template_replace_values: {
            username: "",
            staffid: ""
        }
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
    valor = (isNaN(valor))?valor:valor.toString();
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
        case "3":
            valor = valor.replace(" ", "");
            valor = valor.replace(",", "");
            valor = valor.replace(".", ",");
        
            if(!valor.includes(",")){
            	valor += ",00";
            }
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

function uploadFile(element,preview,input) {
    var item = {
        imagemName :undefined,
        imagemFile: undefined
    }
    var file = element.files;
    item.imagemName = file[0].name;
    item.imagemFile = file[0];
    var reader = new FileReader();
    reader.onload = function (loadEvent) {
        item.imagem = loadEvent.target.result;
        $('#'+preview).attr('src',item.imagem);
		$('#'+input).val(item.imagem);		
    };
    reader.readAsDataURL(file[0]);
}

function removerFile(preview,input){
	$('#'+preview).attr('src','./img/imagemPadrao.jpg');
	$('#'+input).val('');
}

function fecharBarraLateral(){
    //if(detectarMobile() === true){
    //    $('.app').addClass('sidenav-toggled');
    //}
}


function detectarMobile() {
  var check = false; //wrapper no check
  (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
  return check;
}

String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1).toLowerCase();
}


function inputShow(fluxoProcessoId, valor, propriedade){
	$('#valueChange').html( '<div class="input-group mb-3">'+
						    '<input id="input-valor" type="text" value="'+valor+'" class="form-control money">'+
						    '<div class="input-group-append be-addon">'+
						        '<button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle" aria-expanded="false">Propriedade</button>'+
						        '<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(696px, 41px, 0px); top: 0px; left: 0px; will-change: transform;">'+
						        	'<a href="#" onClick="inputUpdate('+fluxoProcessoId+',\'1\')" class="dropdown-item">Positivo</a>'+
						        	'<a href="#" onClick="inputUpdate('+fluxoProcessoId+',\'0\')" class="dropdown-item">Negativo</a>'+
						        '</div>'+
						    '</div>'+
					    '</div>');
	$('.money').mask('000.000.000.000.000,00', {reverse: true}); 
}

function inputUpdate(fluxoProcessoId,propriedade){
	
	var valor = $('#input-valor').val();
	$('#valueChange').html('<div onclick="inputShow(\''+fluxoProcessoId+'\',\''+valor+'\',\''+propriedade+'\')">R$ '+(propriedade == '1'?'':'-')+valor+'</div>');
    controlador = 'ControladorProcesso';
    funcao = 'atualizarValorFluxoProcesso';
	if(valor == ''){
		msgSlide("14");
	}else{	    
		$.ajax({
	        url: 'controlador.php',
	        type: 'POST',
	        data: 'controlador=' + controlador + '&funcao=' + funcao + '&valor='+ valor + '&id='+ fluxoProcessoId + '&propriedade='+propriedade,
	        success: function(result) {
	            //$('#' + retorno).html(result);
	        },
	        beforeSend: function() {
	        	showLoading();
	        },
	        complete: function() {
	        	hideLoading();
	            $('#div_a').remove();
	            $('#' + retorno).css('display', '');
	
	        },
	        error: function(){
	        	msgSlide("18");
	        }	        
	    });
	}
}

function inputUpdateProcessoFluxo(fluxoProcessoId, tipo){
	
	var valor = $('#input_titulo').val();
	var funcao = 'atualizarTituloFluxoProcesso';
	var mes = '';
	var ano = '';
	if(tipo == 'v'){
		funcao = 'atualizarVencimentoFluxoProcesso';
		valor = $('#input_vencimento').val();
		mes = $('#input_vencimento').attr('mes');
		ano = $('#input_vencimento').attr('ano');
	}else if(tipo == 'd'){
		funcao = 'atualizarDescricaoFluxoProcesso';
		valor = $('#input_descricao').val();
	}
	
	if(tipo != 'v' && valor == ''){
		msgSlide("14");
	}else{	
		$.ajax({
	        url: 'controlador.php',
	        type: 'POST',
	        data: 'controlador=ControladorProcesso&funcao='+funcao+'&valor='+ valor + '&id='+ fluxoProcessoId,
	        success: function(result) {
	            if(tipo == 'v'){
	            	$('#span_vencimento').css('display','');
					$('#div_input_vencimento').css('display','none');
					if(valor == ''){
						$('#span_vencimento').html('-');
					}else{
						$('#span_vencimento').html(pad(valor,1,'0')+'/'+mes+'/'+ano);
					}
	            }
	        },
	        beforeSend: function() {
	        	showLoading();
	        },
	        complete: function() {
	        	hideLoading();
	        },
	        error: function(){
	        	msgSlide("18");
	        }
	    });
	}
}

function fcnScrollTop(){
	$("html, body").animate({ scrollTop: $(document).height()-$(window).height() });
}

function limparListFilter(){
	$('.list-filter').remove();
}

function filtrarTimeline(texto, isDiv){
	limparListFilter();
	$('#filtro').val(texto.trim());

	if(texto === undefined || texto === ''){
		$('.cd-timeline__block').show();
	}else{
		$('.cd-timeline__block').hide();
		$('.cd-timeline__block').each(function() {
			var divs = $(this).children();
			var titulo = $(divs[1]).children().html();
			if(titulo.trim().toUpperCase().indexOf(texto.trim().toUpperCase()) !== -1){
				
				if(isDiv === false){
					var html = '<div class="list-filter col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12" style="background-color: #ffffff;min-height: 2.5rem;border: 1px solid #d2d2e4;padding-top: 8px;" onClick="filtrarTimeline(\''+titulo.trim()+'\', true)" >'+titulo.trim()+'</div>';
					$('#filter').append(html);
				}
				$(this).show();
			}
		});
	}
}

function mascara(e,src,mask){
	_TXT = "";
	if (window.event){
		_TXT = e.keyCode;
	} else if (e.which){
		_TXT = e.which;
	}
	if (_TXT == ""){
		return true;
	}
	if (_TXT > 47 && _TXT < 58) {
		var i = src.value.length;
		var saida = "#"; //mask.substring(0,1);
		var texto = mask.substring(i);
		//alert(texto +" - "+ texto.substring(0,1))
		if (texto.substring(0,1) != saida){
			src.value += texto.substring(0,1);
			if (texto.substring(0,1) == ")"){
				src.value += " ";
			}
		}
		return true;
	} else {
		if (_TXT != 8){
			return false;
		} else {
			return true;
		}
	}
}

function validateDate(data) {
	var RegExPattern = /^((((0?[1-9]|[12]\d|3[01])[\.\-\/](0?[13578]|1[02])      [\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|((0?[1-9]|[12]\d|30)[\.\-\/](0?[13456789]|1[012])[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|((0?[1-9]|1\d|2[0-8])[\.\-\/]0?2[\.\-\/]((1[6-9]|[2-9]\d)?\d{2}))|(29[\.\-\/]0?2[\.\-\/]((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)|00)))|(((0[1-9]|[12]\d|3[01])(0[13578]|1[02])((1[6-9]|[2-9]\d)?\d{2}))|((0[1-9]|[12]\d|30)(0[13456789]|1[012])((1[6-9]|[2-9]\d)?\d{2}))|((0[1-9]|1\d|2[0-8])02((1[6-9]|[2-9]\d)?\d{2}))|(2902((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00)|00))))$/;

	if (!((data.match(RegExPattern)) && (data != ''))) {
		return false;
	} else {
		return true;
	}
}

function findOrigemList(id){
	var result = null; 
	$("#sortable li").each(function( index ) {
	  if($(this).attr("id") == "listArray_"+id){
		  result = index;
		  return false;
	  } 	
	});
	return result;
}

function listUp(id) {
	var origem = findOrigemList(id);
	if(origem != null && origem != 0){
		var destino = parseInt(origem)-1;
		$("#sortable li:eq("+origem+")").after($("#sortable li:eq("+destino+")"));
	}
}

function listDown(id) {
	var origem = findOrigemList(id);
	var total = $("#sortable li");
	if(origem != null && origem != (total.length-1)){
		var destino = parseInt(origem)+1;
		$("#sortable li:eq("+origem+")").before($("#sortable li:eq("+destino+")"));
	}
}


function telaVisualizarEventosAgenda(dateText){
	$.ajax({
		url: 'controlador.php',
		type: 'POST',
		data: 'retorno=div_agenda_retorno&controlador=controladorAgenda&funcao=telaVisualizarEventosAgenda&data=' + dateText,
		success: function(result) {
			$('#div_agenda_retorno').html(result);
		},
		beforeSend: function() {
			showLoading();
		},
		complete: function() {
			hideLoading();
		}
	});
}

function telaVisualizarComentariosAgenda(dateText){
	$.ajax({
		url: 'controlador.php',
		type: 'POST',
		data: 'retorno=div_comentario_retorno&controlador=controladorAgenda&funcao=telaVisualizarComentariosAgenda&data=' + dateText,
		success: function(result) {
			$('#div_comentario_retorno').html(result);
		},
		beforeSend: function() {
			showLoading();
		},
		complete: function() {
			hideLoading();
		}
	});
}

function ordenarAgenda() {
	$("#div_agenda").sortable({opacity: 0.6, cursor: 'move', update: function() {
			var txt_data_cad = document.getElementById("txt_data_cad").value;
			var order = $(this).sortable("serialize") + '&action=updateRecordsListings&txt_data_cad=' + txt_data_cad + '&retorno=div_agenda_retorno&controlador=controladorAgenda&funcao=ordernarAgenda';
			$.ajax({
				url: 'controlador.php',
				type: 'POST',
				data: order,
				success: function(result) {
					//$('#div_agenda_retorno').html(result);
				},
				beforeSend: function() {
					showLoading();
				},
				complete: function() {
					hideLoading();
				}
			});
		}
	});
}

function desativarAgenda(id, ativo) {
	var txt_data_cad = document.getElementById("txt_data_cad").value;
	var dados = 'id=' + id + '&retorno=div_central&controlador=controladorAgenda&funcao=alterarAgenda&txt_data_cad=' + fncDesformataData(txt_data_cad) + '&ativo=' + ativo;
	$.ajax({
		url: 'controlador.php',
		type: 'POST',
		data: dados,
		success: function(result) {
			$('#div_central').html(result);
		},
		beforeSend: function() {
			showLoading();
		},
		complete: function() {
			hideLoading();
		}
	});
}

function incluirAgenda(element){    

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
            	showLoading();
            },
            complete: function() {
            	hideLoading();
                if (mensagem) {
                    msgSlide(mensagem);
                }

            }
        });
    }
};


function removerAgenda(id, arquivo) {
	var txt_data_cad = document.getElementById("txt_data_cad").value;
	var dados = 'id=' + id + '&retorno=div_central&controlador=controladorAgenda&funcao=excluirAgenda&data='+txt_data_cad;
	$.ajax({
		url: 'controlador.php',
		type: 'POST',
		data: dados,
		success: function(result) {
			$.ajax({
		        url: 'popup-upload.php',
		        type: 'GET',
		        data: 'opcao=2&pastaArquivo=./arquivos/agenda/&arquivo=' + arquivo
		    });
			$('#div_central').html(result);
		},
		beforeSend: function() {
			showLoading();
		},
		complete: function() {
			hideLoading();
            if (mensagem) {
                msgSlide("4");
            }
		}
	});
}

function telaModalAgendaProcessoFluxo(info){
	$.ajax({
		url: 'controlador.php',
		type: 'POST',
		data: 'retorno=div_modal_agenda_retorno&controlador=controladorAgenda&funcao=telaModalAgendaProcessoFluxo&id='+info.id+'&id_processo_fluxo='+info.id_processo_fluxo+'&ativo='+info.ativo+'&atuante='+info.atuante+'&id_processo=' + info.id_processo,
		success: function(result) {
			$('#div_modal_agenda_retorno').html(result);
		    $.blockUI({
	            message: $('#modalAgenda'),
	        });
	        $('#closeModalAgenda').click(function() {
	            $.unblockUI();
	            return false;
	        });
	        	
		},
		beforeSend: function() {
			showLoading();
		},
		complete: function() {
			hideLoading();
		}
	});
}

function fncTelaModalComentariosProcessoFluxo(element){
	var id_processo = $(element).attr('id_processo');
	var titulo_processo_fluxo = $(element).attr('titulo_processo_fluxo');
	var id_processo_fluxo = $(element).attr('id_processo_fluxo');	
	$.ajax({
		url: 'controlador.php',
		type: 'POST',
		data: 'retorno=div_modal_timeline_retorno&controlador=controladorProcesso&funcao=telaModalComentariosProcessoFluxo&id='+id_processo+'&titulo_processo_fluxo='+titulo_processo_fluxo+'&id_processo_fluxo='+id_processo_fluxo,
		success: function(result) {
			$('#div_modal_timeline_retorno').html(result);
		    $.blockUI({
	            message: $('#modalTimeLine'),
	        });
	        $('#closeModalTimeLine').click(function() {
	            $.unblockUI();
	            return false;
	        });
		},
		beforeSend: function() {
			//showLoading();
		},
		complete: function() {
			//hideLoading();
		}
	});
}

function fncTelaModalCadastrarProcessoFluxo(element){
	var id_processo = $(element).attr('id_processo');
	$.ajax({
		url: 'controlador.php',
		type: 'POST',
		data: 'retorno=div_modal_timeline_retorno&controlador=controladorProcesso&funcao=telaModalCadastrarProcessoFluxo&id='+id_processo,
		success: function(result) {
			$('#div_modal_timeline_retorno').html(result);
		    $.blockUI({
	            message: $('#modalTimeLine'),
	        });
	        $('#closeModalTimeLine').click(function() {
	            $.unblockUI();
	            return false;
	        });
		},
		beforeSend: function() {
			//showLoading();
		},
		complete: function() {
			//hideLoading();
		}
	});
}

function fixTableLayout(tableName){
    $('#'+tableName+'_wrapper').addClass('form-row');
    $('#'+tableName+'_filter').addClass('form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2');
    $('#'+tableName+'_filter input').addClass('form-control');
    $('#'+tableName+'_length').addClass('form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2');
    $('#'+tableName+'_length select').addClass('form-control');

    $('#'+tableName+'_info').addClass('form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2');
    $('#'+tableName+'_paginate').addClass('form-group col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 mb-2');
    $('#'+tableName+'_paginate').css('padding-top','0.85em');
    $('#'+tableName+'_wrapper').css('margin-left','0');
    $('#'+tableName+'_wrapper').css('margin-right','0');
}

function showLoading(){
	$("#loading").loading('start');
}

function hideLoading(){
	$("#loading").loading('stop');
}

function recalcular(processoFluxoId){
	var totalPositivo = Number.parseFloat(0.0);
	var totalNegativo = Number.parseFloat(0.0);
	var totalAberto = Number.parseFloat(0.0);
	var totalFechado = Number.parseFloat(0.0);    
	$(".valor").each(function() {
		  var valor = $(this).val();
		  var ativo = $(this).attr('ativo');
		  if(valor){	
		  	  valor = valor.replace(",", ".");	
			  if(valor >= 0){
				  totalPositivo += Number.parseFloat(valor);	
              }else{
            	  totalNegativo += Number.parseFloat(valor);
              }
		
			  if(ativo == '1'){
				  totalAberto += Number.parseFloat(valor);	
              }else{
            	  totalFechado += Number.parseFloat(valor);
              }
			  
			  if(valor == '0'){
				  $(this).val("0,00");
			  }
		  }else{
			  $(this).val("0,00");		
	      }
		  
		  if($(this).attr('id') == 'valor_'+processoFluxoId){
			    var propriedade = '0';
			    if(Number.parseFloat(valor) >= 0){
			    	propriedade = '1';
			    }	
			    
		    	var valorUpdate = $(this).val();
				$.ajax({
				    url: 'controlador.php',
				    type: 'POST',
				    data: 'controlador=ControladorProcesso&funcao=atualizarValorFluxoProcesso&valor='+ valorUpdate.replace("-", "") + '&id='+ processoFluxoId + '&propriedade='+propriedade,
				    success: function(result) {
				    	console.log(result);
				    },
				    beforeSend: function() {
				    	showLoading();
				    },
				    complete: function() {
				    	hideLoading();
				    },
				    error: function(){
				    	msgSlide("18");
				    }	        
				});
			  }
	});
    var provisao = $('#provisao').html();
        provisao = provisao.replace(".", "");
        provisao = provisao.replace("R$ ", "");
        provisao = provisao.replace(",", ".");
        provisao = Number.parseFloat(provisao);
    $('#totalAberto').html('R$ '+valorMonetario(totalAberto.toFixed(2),'3'));
    $('#totalFechado').html('R$ '+valorMonetario(totalPositivo.toFixed(2),'3'));
    $('#totalPositivo').html('R$ '+valorMonetario(totalPositivo.toFixed(2),'3'));
    $('#totalNegativo').html('R$ '+valorMonetario(totalNegativo.toFixed(2),'3'));
    $('#totalGeral').html('R$ '+valorMonetario((totalPositivo+totalNegativo).toFixed(2),'3'));
    $('#provisaoTotalGeral').html('R$ '+valorMonetario((provisao+(totalPositivo+totalNegativo)).toFixed(2),'3'));
}

function scrollToSmooth() {
	window.scrollTo({
		top : 0,
		behavior : 'smooth',
	});
}

function fncLimitarTexto(texto, tamanho){
    if (texto && texto.length >= tamanho){
        return str.substring(0, (tamanho-3))+'...';
    } else{
        return texto;
    }
}

function fncSelecionados(elemento){
	if($(elemento).is(':checked')){
		fncEachCheckFluxo(true);
	}else{
		fncEachCheckFluxo(false);
    }				
}

function fncEachCheckFluxo(isHide){
	$('.check-fluxo').each(function() {
		if(isHide == true){
        	if($(this).is(':checked')){
        		$(this).parent().parent().parent().parent().show();
		    }else{
		    	$(this).parent().parent().parent().parent().hide();
		    }
	    }else{
	    	$(this).parent().parent().parent().parent().show();
		}
    });
} 