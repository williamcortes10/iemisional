<?php
//Datos de Configuración de la app
session_start();
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$look=false;
$sql = "SELECT valor FROM appconfig WHERE item='ie'";
$consulta = $conx->query($sql);
$records = $conx->records_array($consulta);
$ie= $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'pages'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$pages = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'convenciones'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$convencion = $records['valor'];

$aniolectivo = $_GET['aniolectivo'];;
$iddocente = $_GET['id'];;
$idmateria=$_GET['idmateria'];
$idaula=$_GET['idaula'];
$sql = "SELECT nombre_materia FROM materia WHERE idmateria = '$idmateria'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$nommateria = $records['nombre_materia'];
$sql = "SELECT descripcion, grupo,grado FROM aula WHERE idaula = '$idaula'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$curso = utf8_encode($records['descripcion']);
//$curso = utf8_encode($records['descripcion'])."-GRUPO ".$records['grupo'];
$grado = $records['grado'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISTEMA ACADEMICO DE CALIFICACIONES - FORMULARIO NUEVA COMPETENCIA</title>
 
    <!-- CSS de Bootstrap -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<!-- Custom styles for this template -->
    <link href="../../css/index.css" rel="stylesheet">
 
    <!-- librerías opcionales que activan el soporte de HTML5 para IE8 -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
		<?php 
		if (isset($_SESSION['k_username'])) {
			$sql = "SELECT idusuario, apellido1, nombre1,iddocente, tipousuario FROM usuario, docente 
			WHERE idusuario='".$_SESSION['k_username']."' and iddocente=idusuario and (tipousuario='D' or tipousuario='A')";
			$consulta = $conx->query($sql);
			if($conx->get_numRecords($consulta)>0){
				$records = $conx->records_array($consulta);
				$user=$records['nombre1']." ".$records['apellido1']; 
				$iddocente=$records['iddocente']; 
				$tipousuario=$records['tipousuario']; 
				$look=true;
			}
		}else{
		?>
			<div class="jumbotron center-block">
				<h1 class='alert alert-danger'>Debe Iniciar Sesión</h1>
				<p><a class='btn btn-lg btn-success' href='../../index.php' role='button'>Ir al inicio</a></p>
			</div>
		<?php
		}
		if($look){
			$sql = "SELECT * FROM appconfig WHERE item = 'index_docen_ca'";
			$consulta = $conx->query($sql);
			$recordsM = $conx->records_array($consulta);
			if($recordsM['valor']=='on' and $tipousuario='D')
			{
		?>
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
					<li class="active"><a href="../../docente/index.php">Inicio</a></li>
					<?php 
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
						  <li><a href="nvcompetencia.php">Nueva</a></li>
						  <li><a href="actelimcompetencia.php">Actualizar/Eliminar</a></li>
						  <li><a href="selecionarcompetencia.php">Seleccionar Competencias</a></li>
						  <li><a href="desselecionarcompetencia.php">Quitar Competencias</a></li>
						  <li><a href="categorizarcompetencia.php" class="btn btn-success white-text">Categorizar Competencias</a></li>
						  
						</ul>
					</li>
					<?php
					}
					?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Calificaciones<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li role="presentation" class="dropdown-header">Regulares</li>
						  <li><a href="../notas/ingresarcalificaciones.php">Ingresar Calificación</a></li>
						  <li><a href="../notas/eliminarcalificaciones.php">Eliminar Calificación</a></li>
						  <li role="presentation" class="divider"></li>
						  <li role="presentation" class="dropdown-header">Nivelación</li>
						  <li><a href="../notas/ingresarcalificacionesnv.php">Ingresar Calificación</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Informes<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li><a href="../notas/listarcalificaciones.php">Generar informe de notas</a></li>
						  <li><a href="../notas/sintesis.php">Sintesis</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  <span class="glyphicon glyphicon-user"></span>
						  <?php echo $user; ?><b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li><a href="../../docente/logout.php">Cerrar sesión</a></li>
						</ul>
					</li>
				  </ul>
				</div><!--/.nav-collapse -->
			  </div>
			</nav>
			<!-- Formulario de login -->
			<div class="forminsert center-block">
				<h3>Nueva competencia en <?php echo $nommateria; ?></h3>
				<h4><?php echo utf8_decode($curso); ?></h4>
				<hr/>
				<form class="form-signin" role="form" action="nvcomptenciaformsucess.php" method='POST' id='frmnvcomp' name='frmnvcomp'>
				<div class="form-group">
				<label class="control-label" for="estbc">Componente de la competencia:</label>
			    <select id='estbc' name='estbc' class="form-control">
						<?php
						$sql = "SELECT *  FROM estandares WHERE idmateria_fk = '$idmateria'";
						$consulta = $conx->query($sql);
						if($conx->get_numRecords($consulta)>0){
							while ($row = $conx->records_array($consulta)) {
								echo "<option value='".$row["codigo"]."'>".
								$row["descripcion"]."</option>";
							}
						} else {
							echo "<option>No se ha configurado estandares</option>";
						}
						?>
				</select>
				</div>
				<div class="form-group">
				<label class="control-label" for="estbc">Descripción de la competencia:</label>
			    <textarea class="form-control" rows="6" id='desestbc' name='desestbc' required autofocus></textarea>
				</div>
				<div class="form-group form-inline">
					<label for="grgradoi">Grupo de grados:</label>
					<select id='grgradoi' name='grgradoi' class="form-control">
					<?php for($i=0; $i<12; $i++){ if($grado==$i){echo "<option value='$i' selected>$i °</option>"; }else{echo "<option value='$i'>$i °</option>";}} ?>
					</select> 
					<label for="grgradof">hasta</label>
					<select id='grgradof' name='grgradof' class="form-control">
					<?php for($i=0; $i<12; $i++){ if($grado==$i){echo "<option value='$i' selected>$i °</option>"; }else{echo "<option value='$i'>$i °</option>";}} ?>
					</select> 
				 </div>
				<input type='hidden' id='idmateria' name='idmateria' value='<?php echo $idmateria; ?>' />
				<input type='hidden' id='iddocente' name='iddocente' value='<?php echo $iddocente; ?>' />
				<input type='hidden' id='idaula' name='idaula' value='<?php echo $idaula; ?>' />
				<input type='hidden' id='grado' name='grado' value='<?php echo $grado; ?>' />
				<input type='hidden' id='aniolectivo' name='aniolectivo' value='<?php echo $aniolectivo; ?>' />
				<button type="submit" class="btn btn-primary">Guardar</button>
				</form>
			 </div>
			<?php

			}else if($tipousuario=='A')
			{
				include('../../administrador/nav.php');
				?>
				<!-- Formulario de login -->
				<div class="forminsert center-block">
					<br/><br/><br/><h3>Nueva competencia en <?php echo $nommateria; ?></h3>
					<h4><?php echo utf8_decode($curso); ?></h4>
					<hr/>
					<form class="form-signin" role="form" action="nvcomptenciaformsucess.php" method='POST' id='frmnvcomp' name='frmnvcomp'>
					<div class="form-group">
					<label class="control-label" for="estbc">Componente de la competencia:</label>
					<select id='estbc' name='estbc' class="form-control">
							<?php
							$sql = "SELECT *  FROM estandares WHERE idmateria_fk = '$idmateria'";
							$consulta = $conx->query($sql);
							if($conx->get_numRecords($consulta)>0){
								while ($row = $conx->records_array($consulta)) {
									echo "<option value='".$row["codigo"]."'>".
									utf8_encode($row["descripcion"])."</option>";
								}
							} else {
								echo "<option>No se ha configurado estandares</option>";
							}
							?>
					</select>
					</div>
					<div class="form-group">
					<label class="control-label" for="estbc">Descripción de la competencia:</label>
					<textarea class="form-control" rows="6" id='desestbc' name='desestbc' required autofocus></textarea>
					</div>
					<div class="form-group form-inline">
						<label for="grgradoi">Grupo de grados:</label>
						<select id='grgradoi' name='grgradoi' class="form-control">
						<?php for($i=0; $i<12; $i++){ if($grado==$i){echo "<option value='$i' selected>$i °</option>"; }else{echo "<option value='$i'>$i °</option>";}} ?>
						</select> 
						<label for="grgradof">hasta</label>
						<select id='grgradof' name='grgradof' class="form-control">
						<?php for($i=0; $i<12; $i++){ if($grado==$i){echo "<option value='$i' selected>$i °</option>"; }else{echo "<option value='$i'>$i °</option>";}} ?>
						</select> 
					 </div>
					<input type='hidden' id='idmateria' name='idmateria' value='<?php echo $idmateria; ?>' />
					<input type='hidden' id='iddocente' name='iddocente' value='<?php echo $iddocente; ?>' />
					<input type='hidden' id='idaula' name='idaula' value='<?php echo $idaula; ?>' />
					<input type='hidden' id='grado' name='grado' value='<?php echo $grado; ?>' />
					<input type='hidden' id='aniolectivo' name='aniolectivo' value='<?php echo $aniolectivo; ?>' />
					<button type="submit" class="btn btn-primary">Guardar</button>
					</form>
				 </div>
				<?php
			}else{
			?>
				<div class="jumbotron center-block">
				<h1 class='alert alert-danger'>El ingreso de competencias está cerrado. <br/> Comuníquese con el administrador</h1>
				<p><a class='btn btn-lg btn-success' href='../../docente/index.php' role='button'>Volver a la página anterior</a></p>
				</div>
			<?php
			}
			
		}
		$conx->close_conex();
			?>
    <!-- Librería jQuery requerida por los plugins de JavaScript -->
    <script src="../../js/jquery.js"></script>
    <script>
	<!-- Validar formulario en el grupo de grados. el inicio no puede ser mayor que el grado final-->
	
	</script>
 
    <!-- Todos los plugins JavaScript de Bootstrap (también puedes
         incluir archivos JavaScript individuales de los únicos
         plugins que utilices) -->
    <script src="../../js/bootstrap.min.js"></script>
	 <hr>
	<div class='container center-block'>
		<footer>
			<p>&copy; williamcortes10@gmail.com 2015</p>
		</footer>
	</div>
  </body>
</html>
