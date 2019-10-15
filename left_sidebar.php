<div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
                    <button id="navbarButton" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Menu
                            </li>
							<li class="nav-item">
								<a class="nav-link active" href="main.php">Dashboard</a>
							</li>
                            
							<?php                
							$controladorAcao = new ControladorAcao();                						
							$objAcao = $controladorAcao->listarClasseAcaoParaMenu($_SESSION["login"]);
											
							if($objAcao){
								foreach ($objAcao as $modulo){
							?>			
									<li class="nav-item ">
										<a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-<?php echo $modulo->getId();?>" aria-controls="submenu-<?php echo $modulo->getId();?>"><i class="fa fa-fw fa-user-circle"></i><?php echo $modulo->getNome(); ?> <span class="badge badge-success">6</span></a>
										<div id="submenu-<?php echo $modulo->getId();?>" class="collapse submenu" style="">
											<ul class="nav flex-column">
												<!-- li onclick="fncButtonMenu(this)" funcao="telaGraficoProcessos" controlador="ControladorProcesso" retorno="div_central" secao="modulo" class="nav-item buttonMenu"><a href="#" class="nav-link">Grafico Processos</a></li-->
												<?php 
												foreach ($modulo->getClasse() as $classe){
													if($classe->getPerfil() == "2" ){
													?>
														<li class="nav-item buttonMenu"
														onclick="fncButtonMenu(this)"
														funcao="<?php echo $classe->getFuncao();?>" 
														controlador="<?php echo $classe->getControlador();?>" 
														retorno="div_central" >
															<a class="nav-link" 
															href="#">
															<?php echo$classe->getNome();?>
															</a>
														</li>
													<?php
													} 
												}
												?>
											</ul>
										</div>
									</li>
							<?php
								}
							}

							if($_SESSION["login"]->getPerfil() == "1"){
							?>
                            <li class="nav-item ">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fa fa-fw fa-user-circle"></i>CADASTROS <span class="badge badge-success">6</span></a>
                                <div id="submenu-3" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
										<li onclick="fncButtonMenu(this)" funcao="telaListarUsuario" controlador="ControladorUsuario" retorno="div_central" secao="usuario" class="nav-item buttonMenu"  ><a href="#" class="nav-link">Usuários</a></li>
										<li onclick="fncButtonMenu(this)" funcao="telaListarClasse" controlador="ControladorClasse" retorno="div_central" secao="classe" class="nav-item buttonMenu"><a href="#" class="nav-link">Classes</a></li>
										<li onclick="fncButtonMenu(this)" funcao="telaListarModulo" controlador="ControladorModulo" retorno="div_central" secao="modulo" class="nav-item buttonMenu"><a href="#" class="nav-link">Módulos</a>
										</li>
                                    </ul>
                                </div>
                            </li>								
							<?php
							}
							?>
							
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        