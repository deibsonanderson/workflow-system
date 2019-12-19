<?php
session_start();
unset($_SESSION["login"]);
?>
<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="./assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/libs/css/style.css">
    <link rel="stylesheet" href="./assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="./assets/main/css/jquery-loading/loading.css">
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
	<div id="msgSlide" class="msgSlide"></div>
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center">
				<a href="./index.php"><img class="logo-img" src="./assets/images/logo.png" alt="logo"></a>
			</div>
            <div class="card-body">
				<form action="login.php" method="post" name="formLogin" id="formLogin" >
					<input type="hidden" name="retorno" id="retorno" value="msgSlide"/>
					<input type="hidden" name="controlador" id="controlador" value="ControladorLogin"/>
					<input type="hidden" name="funcao" id="funcao" value="validarLogin"/>
					<input type="hidden" name="mensagem" id="mensagem" value="10"/>
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="login" id="login" type="text" placeholder="Username" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg" name="senha" id="senha" type="password" placeholder="Password">
                    </div>
                    <div class="form-group"></div>
                    <button id="loginbtn" onclick="fncFormLogin(this)" type="button" class="btn btn-primary btn-lg btn-block formLogin">Login</button>
                </form>
            </div>
            <div class="card-footer bg-white p-0  "></div>
        </div>
    </div>
  
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="./assets/vendor/jquery/jquery-3.3.1.min.js"></script>
	<script src="./assets/main/js/library.js" type="text/javascript" ></script>
    <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="./assets/main/js/jquery-loading/loading.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			$('#divLogin').css('padding','100px 0 0 '+((screen.width/2)-242)+'px');
		});
	</script>
	<script language="JavaScript">
		function enterPressed(evn) {
			if (window.event && window.event.keyCode == 13) {
			 	$('.formLogin').click();
			} else if (evn && evn.keyCode == 13) {
				$('.formLogin').click();				   
			}
		}
		document.onkeypress = enterPressed;
		<?php 
		if(isset($_GET["i"]) && $_GET["i"] == "1"){
			?>
				fncSlideMessageLogin("Usuário ou senha invalidos!");
		<?php 
		} 				
		?>
	</script>
</body>
 
</html>