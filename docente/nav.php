<nav class="navbar navbar-inverse navbar-fixed-top">
			  <div class="container">
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Desplegar navegación</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				  <a class="navbar-brand" href="#">Celeste 2.0 - <?php echo utf8_encode($ie);?></a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
				  <ul class="nav navbar-nav">
					<li class="active"><a href="index.php">Inicio</a></li>
					<?php 
					$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
					$sql = "SELECT * FROM jefearea WHERE 
					iddocente='".$_SESSION['k_username']."' AND aniolectivo=$aniolectivo";
					$consulta = $conx->query($sql);
					if($conx->get_numRecords($consulta)>0){
					?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Competencias Académicas<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li><a href="<?php echo $base_url;?>/forms/indicadores/nvcompetencia.php">Nueva</a></li>
						  <li><a href="<?php echo $base_url;?>/forms/indicadores/actelimcompetencia.php">Actualizar/Eliminar</a></li>
						  <li><a href="<?php echo $base_url;?>/forms/indicadores/selecionarcompetencia.php">Seleccionar Competencias</a></li>
						  <li><a href="<?php echo $base_url;?>/forms/indicadores/desselecionarcompetencia.php">Quitar Competencias</a></li>
						  <li><a href="<?php echo $base_url;?>/forms/indicadores/categorizarcompetencia.php" class="btn btn-success white-text">Categorizar Competencias</a></li>
						  
						</ul>
					</li>
					<?php
					}
					$conx->close_conex();
					?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Calificaciones<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li role="presentation" class="dropdown-header">Regulares</li>
						  <li><a href="<?php echo $base_url;?>/forms/notas/ingresarcalificaciones.php">Ingresar Calificación</a></li>
						  <li role="presentation" class="divider"></li>
						  <li role="presentation" class="dropdown-header">Nivelación</li>
						  <li><a href="<?php echo $base_url;?>/forms/notas/ingresarcalificacionesnv.php">Ingresar Calificación</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Informes<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li><a href="<?php echo $base_url;?>/forms/notas/listarcalificaciones.php">Generar informe de notas</a></li>
						  <li><a href="<?php echo $base_url;?>/forms/notas/sintesis.php">Sintesis</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  <span class="glyphicon glyphicon-user"></span>
						  <?php echo utf8_encode($user); ?><b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li><a href="<?php echo $base_url; ?>/docente/logout.php">Cerrar sesión</a></li>
						</ul>
					</li>
				  </ul>
				</div><!--/.nav-collapse -->
			  </div>
			</nav>