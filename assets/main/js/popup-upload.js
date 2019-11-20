//Bloco responsavel por enviar os dados do item.

function fncSubmitArquivo(btnSubmit,objeto) {
    var tamanhoMaximo = (2 * 1024 * 1024);
    var tamanhoArquivo = parseInt(objeto.files[0].size);
    if(tamanhoArquivo > tamanhoMaximo){
        alert('Tamanho máximo do arquivo excedido! Tamanho máximo permitido: 2 MB.');
    }else{
        $('#' + btnSubmit).click();
    }
}

function fncInserirArquivo(fomulario, progress, porcentagem, inputFile, arquivoExibicao, caminhoArquivo, tipoArquivo, button) {
    if (fomulario === null) {
        alert('O ID do formulario não foi informado');
    } else {
        $('#' + fomulario).ajaxForm({
            uploadProgress: function(event, position, total, percentComplete) {
                $('#' + progress).css('display', '');
                $('#' + porcentagem).css('display', '');
                $('#' + arquivoExibicao).css('display', 'none');
                $('#' + progress).attr('value', percentComplete);
                $('#' + porcentagem).html(percentComplete + '%');
                
                if(button != null && button != 'undefined'){
                	$('#'+button).attr("disabled", true);
                	$('#'+button+'-img').css("display", 'block');
                	$('#'+button+'-text').css("display", 'none');
                }                
                $('#loader').css({display: "block"});
            },
            success: function(data) {
                if(button != null && button != 'undefined'){
                	$('#'+button).attr("disabled", false);
                	$('#'+button+'-img').css("display", 'none');
                	$('#'+button+'-text').css("display", 'block');
                	
                }
                $('#loader').css({display: "none"});
                
            	$('#' + progress).attr('value', '100');
                $('#' + progress).css('display', 'none');
                $('#' + porcentagem).css('display', 'none');
                $('#' + arquivoExibicao).css('display', '');
                //Bloco do HTML com o retorno do nome da imagem
                $('#' + inputFile).val(data);
                $('#' + arquivoExibicao).attr('title', data);
                if (tipoArquivo === "imagem") {
                    
                    $('#' + arquivoExibicao).attr('src', caminhoArquivo + 'thumbnail' + data);
                    
                } else if (tipoArquivo === "arquivo") {
                	if(data.length >= 30){
                        data = data.substring(0, 25)+'...';
                    }
                    $('#' + arquivoExibicao).html('<br />'+data);
                    $('#' + arquivoExibicao).css('cursor', 'pointer');
                    $('#' + arquivoExibicao).css('text-decoration', 'underline');

                }

            }
        });
    }
}

function fncRemoverArquivo(inputFile, caminhoArquivo, tipoArquivo, arquivoExibicao, imagemDefault) {

    arquivo = $('#' + inputFile).val();
    if (arquivo === "")
        return;
    if (!confirm("Tem certeza que deseja realizar a EXCLUSÃO deste arquivo?"))
        return;

    $('#' + inputFile).val("");
    if (tipoArquivo === "imagem") {
        $('#' + arquivoExibicao).attr('src', imagemDefault);
        $('#' + arquivoExibicao).css('display', '');
        $('#' + arquivoExibicao).attr('title', '');
        
    } else if (tipoArquivo === "arquivo") {
    	$('#' + arquivoExibicao).attr('title', '');
        $('#' + arquivoExibicao).html("<br />Adicione um arquivo clicando no <img src='./assets/images/img_upload.png' border='0' style='float:none;margin:0;width: 20px;' /> ao lado.");
        $('#' + arquivoExibicao).css('cursor', 'default');
        $('#' + arquivoExibicao).css('text-decoration', 'none');        
    }

    $.ajax({
        url: 'popup-upload.php',
        type: 'GET',
        data: 'opcao=2&pastaArquivo=' + caminhoArquivo + '&arquivo=' + arquivo
    });
}

function fncAbreArquivoPagina(arquivo,local){
        if (arquivo === "") return;
        window.location = 'download_doc.php?d='+local+'&f='+arquivo;
}

function fnAbreArquivo(campo, local) {
    arquivo = $('#' + campo).val();
    if (arquivo === "")
        return;
    window.location = 'download_doc.php?d=' + local + '&f=' + arquivo;
}

function fncRemoverArquivoAuto(inputFile, caminhoArquivo, tipoArquivo, arquivoExibicao, imagemDefault) {

    arquivo = $('#' + inputFile).val();

    $('#' + inputFile).val("");
    if (tipoArquivo === "imagem") {
        $('#' + arquivoExibicao).attr('src', imagemDefault);
       
    } else if (tipoArquivo === "arquivo") {
        $('#' + arquivoExibicao).html("<br />Adicione um arquivo clicando no <img src='./assets/images/img_upload.png' border='0' style='float:none;margin:0;width: 20px;' /> ao lado.");
        $('#' + arquivoExibicao).css('cursor', 'default');
        $('#' + arquivoExibicao).css('text-decoration', 'none');        
    }

    $.ajax({
        url: 'popup-upload.php',
        type: 'GET',
        data: 'opcao=2&pastaArquivo=' + caminhoArquivo + '&arquivo=' + arquivo
    });
}
