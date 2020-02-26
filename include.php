<?php
require_once "classe/Autoload.php";
date_default_timezone_set('America/Sao_Paulo');

require_once "modulo/daoBase.php";
require_once "controle/controladorBase.php";
require_once "view/viewBase.php";
require_once "classe/Campo.php";
require_once "classe/Tela.php";
require_once "classe/BotaoLink.php";

require_once "view/viewAcao.php";
require_once "modulo/daoAcao.php";
require_once "controle/controladorAcao.php";
require_once "classe/Acao.php";

require_once "view/viewClasse.php";
require_once "modulo/daoClasse.php";
require_once "controle/controladorClasse.php";
require_once "classe/Classe.php";

require_once "classe/Login.php";
require_once "controle/controladorLogin.php";
require_once "modulo/daoLogin.php";

require_once "view/viewModulo.php";
require_once "modulo/daoModulo.php";
require_once "controle/controladorModulo.php";
require_once "classe/Modulo.php";

require_once "view/viewUsuario.php";
require_once "modulo/daoUsuario.php";
require_once "controle/controladorUsuario.php";
require_once "classe/Usuario.php";


require_once "lib.php";


require_once "view/viewAtividade.php";
require_once "modulo/daoAtividade.php";
require_once "controle/controladorAtividade.php";
require_once "classe/Atividade.php";


require_once "view/viewFluxo.php";
require_once "modulo/daoFluxo.php";
require_once "controle/controladorFluxo.php";
require_once "classe/Fluxo.php";


require_once "view/viewProcesso.php";
require_once "modulo/daoProcesso.php";
require_once "controle/controladorProcesso.php";
require_once "classe/Processo.php";

require_once "modulo/daoComentarioFluxoProcesso.php";
require_once "controle/controladorComentarioFluxoProcesso.php";
require_once "classe/ComentarioFluxoProcesso.php";

require_once "view/viewAgenda.php";
require_once "modulo/daoAgenda.php";
require_once "controle/controladorAgenda.php";
require_once "classe/Agenda.php";

require_once "view/viewCategoriaAtividade.php";
require_once "modulo/daoCategoriaAtividade.php";
require_once "controle/controladorCategoriaAtividade.php";
require_once "classe/CategoriaAtividade.php";

require_once "view/viewMain.php";
require_once "controle/controladorMain.php";
?>