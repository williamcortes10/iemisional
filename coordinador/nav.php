<nav class="navbar navbar-inverse navbar-fixed-top">
			  <div class="container-fluid">
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
					<li class="active"><a href="<?php echo $base_url;?>/administrador/index.php">Inicio</a></li>
					
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Reportes<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li role="presentation" class='dropdown-header'><b>ESTADISTICAS</b></li>
						  <li><a href='<?php echo $base_url;?>/forms/estadisticas/ccrendaca.php'>Rendimiento académico x desempeño</a></li>
						  <li><a href='<?php echo $base_url;?>/forms/estadisticas/aprobados_reprobados.php'>Aprobados-Reprobados-Recuperan</a></li>
						  <li><a href='<?php echo $base_url;?>/forms/estadisticas/detalleaprobadosreprobadosform.php'>Detalle Aprobados-Reprobados-Recuperan</a></li>
						  <li role="presentation" class="divider"></li>			 
						  <li role="presentation" class='dropdown-header'><b>CALIFICACIONES</b></li>
						  <li><a href="<?php echo $base_url;?>/forms/notas/sintesisxcurso.php">Sintesis</a></li>
						  <li role="presentation" class="divider"></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  <span class="glyphicon glyphicon-user"></span>
						  <?php echo ($user); ?><b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li><a href="<?php echo $base_url; ?>/coordinador/logout.php">Cerrar sesión</a></li>
						</ul>
					</li>
				  </ul>
				</div><!--/.nav-collapse -->
			  </div>
			</nav>