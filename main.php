<?php
require_once 'include.php';
if (isset($_SESSION["login"])) {
?>
<!doctype html>
<html lang="en">
 
<?php include('head.php') ?>

<body id="loading" class="loading-div">
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    
	<div>
	    <?php
			exibirQuestion("question", "sim", "nao", "Tem certeza que deseja remover?", "* Todos os itens que se relacionam também serão removidos");
		?>
		<div class="dashboard-main-wrapper">
			<!-- ============================================================== -->
			<!-- navbar -->
			<!-- ============================================================== -->
			<?php include('navbar.php') ?>
			<!-- ============================================================== -->
			<!-- end navbar -->
			<!-- ============================================================== -->
			<!-- ============================================================== -->
			<!-- left sidebar -->
			<!-- ============================================================== -->
			<?php include('left_sidebar.php') ?>
			<!-- ============================================================== -->
			<!-- end left sidebar -->
			<!-- ============================================================== -->
			<!-- ============================================================== -->
			<!-- wrapper  -->
			<!-- ============================================================== -->
			<div class="dashboard-wrapper">
				<div class="dashboard-ecommerce">
					<div class="container-fluid dashboard-content ">
						<!-- ============================================================== -->
						<!-- pageheader  -->
						<!-- ============================================================== -->
						<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="page-header">
									<h2 class="pageheader-title">Workflow DX</h2>
								</div>
							</div>
						</div>
						<!-- ============================================================== -->
						<!-- end pageheader  -->
						<!-- ============================================================== -->
						
						
						<!-- ============================================================== -->
						<!-- div central return ajax -->
						<!-- ============================================================== -->
						<article id="div_central"></article>	
						<!-- ============================================================== -->
						<!-- end div central return ajax  -->
						<!-- ============================================================== -->						
					</div>
				</div>
				<!-- ============================================================== -->
				<!-- footer -->
				<!-- ============================================================== -->
				<?php include('footer.php') ?>
				<!-- ============================================================== -->
				<!-- end footer -->
				<!-- ============================================================== -->
			</div>
			<!-- ============================================================== -->
			<!-- end wrapper  -->
			<!-- ============================================================== -->
		</div>
    </div>
	<!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
	<?php 
		include('required.php'); 
		$init = 'controlador=ControladorProcesso&funcao=telaListarProcesso'; 
		if($_SESSION["login"]->getClasse() != null && $_SESSION["login"]->getClasse() != ''){
			try {
				$controladorClasse = new ControladorClasse();
				$objClasse = $controladorClasse->listarClasse($_SESSION["login"]->getClasse());
				$init = 'controlador='.$objClasse[0]->getControlador().'&funcao='.$objClasse[0]->getFuncao().''; 
			} catch (Exception $e) { 
				echo 'erro no listarClasses '; 
			}
		}
		
	?>
	
    <script type = "text/javascript" >
        var var_height = screen.height;
        $(document).ready(function() {
            $('.dimensions').tooltip({
                track: true,
                delay: 0,
                showURL: true,
                opacity: 0.85
            });

            $.ajax({
                url: 'controlador.php',
                type: 'POST',
                data: 'retorno=div_central&<?php echo $init; ?>',
                success: function(result) {
                    $('#div_central').html(result);
                },
                beforeSend: function() {
                	//showLoading();                 
                },
                complete: function() {
                	hideLoading();
                    $('#div_a').remove();
                    $('#div_central').css('display', '');

                }
            });
            $('.column').equalHeight();
            $('#sidebar').css('height', var_height);
            $('#main').css('height', var_height);
        });

        showLoading(); 
    </script>
    <?php 
		if($_SESSION["login"]->getPopup_vencimento() == '1'){
			$controladorMain = new ControladorMain();		
			echo $controladorMain->telaListarAtividadesProcessosHaVencer();
			$_SESSION["login"]->setPopup_vencimento('0');
		}
    ?>	
</body>
 
</html>
<?php
} else {
    echo "<script>javascript:open('index.php?m=1', '_top')</script>";
}
?>