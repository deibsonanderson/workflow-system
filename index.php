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
				<?php 
				
				if(isset($_GET["i"]) && $_GET["i"] == '1'){
					echo '<span style="color:RED;" class="splash-description">Usuário e/ou senha inválido!</span>';
				} else {	
					echo '<span class="splash-description">Por favor, insira suas informações de usuário.</span>';
				}				
				?>
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
                    <div class="form-group">
                        <!--label class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox"><span class="custom-control-label">Remember Me</span>
                        </label-->
                    </div>
                    <button id="loginbtn" type="button" class="btn btn-primary btn-lg btn-block formLogin">Login</button>
                </form>
            </div>
            <div class="card-footer bg-white p-0  ">
                <!--div class="card-footer-item card-footer-item-bordered">
                    <a href="#" class="footer-link">Create An Account</a></div>
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="#" class="footer-link">Forgot Password</a>
                </div-->
            </div>
        </div>
    </div>
  
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="./assets/vendor/jquery/jquery-3.3.1.min.js"></script>
	<script src="./assets/main/js/lib.js" type="text/javascript" ></script>
    <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			$('#divLogin').css('padding','100px 0 0 '+((screen.width/2)-242)+'px');
		});
		/*
		var mensagem = "<?php echo ($_GET["m"])?$_GET["m"]:"";?>";
		var invalido = "<?php echo ($_GET["i"])?$_GET["i"]:"";?>";  
		if(mensagem != ""){
			//$.grow2UI('Área restrita!', '&nbsp;');	
			//$('#msgSlide').html('<span>Área restrita!</span>');
			//$('#msgSlide').slideDown('slow', function() {
        	//	setTimeout("$('#msgSlide').slideUp('slow')",3000);
	        //});
						
		}else if(invalido != ""){
			//$.grow2UI('Usuário ou senha invalidos!', '&nbsp;');	
			
			$('#msgSlide').html('<span>Usuário ou senha invalidos!</span>');
			$('#msgSlide').slideDown('slow', function() {
	        	setTimeout("$('#msgSlide').slideUp('slow')",3000);
	        });
		}
		*/
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
	</script>
</body>
 
</html>