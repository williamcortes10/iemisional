<?php
//Datos de Configuración de la app
session_start();
include('../class/MySqlClass.php');
include('../bdConfig.php');
$conx = new ConxMySQL("localhost","root","","appacademy");
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
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISTEMA ACADEMICO DE CALIFICACIONES - PANEL SECRETARIA</title>
 
    <!-- CSS de Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<!-- Custom styles for this template -->
    <link href="../css/index.css" rel="stylesheet">
 
    <!-- librerías opcionales que activan el soporte de HTML5 para IE8 -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
		<?php 
		if (isset($_SESSION['k_username'])) {
			$sql = "SELECT idusuario, apellido1, nombre1, tipousuario FROM usuario, docente 
			WHERE idusuario='".$_SESSION['k_username']."' and iddocente=idusuario and tipousuario='S'";
			$consulta = $conx->query($sql);
			if($conx->get_numRecords($consulta)>0){
				$records = $conx->records_array($consulta);
				$user=$records['nombre1']." ".$records['apellido1']; 
				$look=true;
			}
		}else{
		?>
			<div class="jumbotron center-block">
				<h1 class='alert alert-danger'>Debe Iniciar Sesión</h1>
				<p><a class='btn btn-lg btn-success' href='../index.php' role='button'>Ir al inicio</a></p>
			</div>
		<?php
		}
		if($look){
			$sql = "SELECT * FROM appconfig WHERE item = 'index_docen_ful'";
			$consulta = $conx->query($sql);
			$recordsM = $conx->records_array($consulta);
			if($recordsM['valor']=='on' or $recordsM['valor']=='of')
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
					<li class="active"><a href="index.php">Inicio</a></li>
					<!--<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Docentes<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li role="presentation" class="dropdown-header">Información Docente</li>
							<li><a href="../forms/docentes/nuevo_docente.php">Nuevo registro</a></li>
							<li><a href='../forms/docentes/actualizar_docente.php'>Actualizar/Eliminar</a></li>
							<li><a href='../forms/docentes/listado_docentes.php'>Reporte Docentes</a></li>
							<li role="presentation" class="divider"></li>
							<li role="presentation" class="dropdown-header">Intensidad Horaria</li>
							<li><a href='../forms/clase/buscar_docente.php'>Asignar</a></li>
							<li><a href='../forms/clase/buscarupdel_clase.php'>Actualizar/Eliminar</a></li>
							<li><a href='../forms/clase/listado_cargaacademica.php'>Reporte Intensidad Horaria</a></li>
							<li role="presentation" class="divider"></li>
							<li role="presentation" class="dropdown-header">Dinamizadores de grupo</li>
							<li><a href='../forms/coordinadores/buscar_docente.php'>Asignar</a></li>
							<li><a href='../forms/coordinadores/buscarupdel_cg.php'>Actualizar/Eliminar</a></li>
							<li><a href='../forms/coordinadores/listado_coordinadores.php'>Reporte Dinamizadores</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Asignaturas<b class="caret"></b>
						</a>
						<ul class='dropdown-menu'>
							<li role="presentation" class="dropdown-header">Asignaturas</li>
							<li><a href='../forms/asignatura/nueva_asignatura.php'>Nuev registro</a></li>
							<li><a href='../forms/asignatura/actualizar_asignatura.php'>Actualizar</a></li>
						</ul>
					</li>-->
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Estudiante<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li role="presentation" class="dropdown-header">Información Estudiante</li>
							<li><a href='../forms/estudiantes/nuevo_estudiante.php'>Nuevo registro</a></li>
							<li><a href='../forms/estudiantes/actualizar_estudiante.php'>Actualizar/Eliminar</a></li>
							<li><a href='#'>Carga masiva de estudiantes</a></li>
							<li role="presentation" class="divider"></li>
							<li role="presentation" class='dropdown-header'>Matrícula Regular/Nivelación</li>
							<li><a href='../forms/matricula/buscar_estudiante.php'>Nueva individual</a></li>
							<li><a href='../forms/matricula/buscar_grupo_estudiante.php'>Nueva grupo</a></li>
							<li><a href='../forms/matricula/buscarupdel_matricula.php'>Actualizar/Eliminar</a></li>
						</ul>
					</li>
					<!--<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Salones<b class="caret"></b>
						<ul class="dropdown-menu">
							<li><a href='../forms/aula/nueva_aula.php'>Nuevo registro</a></li>
							<li><a href='../forms/aula/actualizar_aula.php'>Actualizar/Eliminar</a></li>
							
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Competencias Académicas<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li><a href="../forms/indicadores/nvcompetencia.php">Nueva</a></li>
						  <li><a href="../forms/indicadores/actelimcompetencia.php">Actualizar/Eliminar</a></li>
						  <li><a href="../forms/indicadores/selecionarcompetencia.php">Seleccionar Competencias</a></li>
						  <li><a href="../forms/indicadores/desselecionarcompetencia.php">Quitar Competencias</a></li>
						  <li><a href="../forms/indicadores/categorizarcompetencia.php" class="btn btn-success white-text">Categorizar Competencias</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Calificaciones<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li role="presentation" class="dropdown-header">Regulares</li>
						  <li><a href="../forms/notas/ingresarcalificaciones.php">Ingresar Calificación</a></li>
						  <li><a href="../forms/notas/eliminarcalificaciones.php">Eliminar Calificación</a></li>
						  <li role="presentation" class="divider"></li>
						  <li role="presentation" class="dropdown-header">Nivelación</li>
						  <li><a href="../forms/notas/ingresarcalificacionesnv.php">Ingresar Calificación</a></li>
						</ul>
					</li>-->
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Reportes<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li role="presentation" class='dropdown-header'>Informe académico</li>
						  <li><a href='<?php echo $base_url;?>/forms/boletines/boletingeneral.php'>Grupo</a></li>
						  <li><a href='<?php echo $base_url;?>/forms/boletines/buscar_estudiante.php'>Individual</a></li>
						  <li role="presentation" class="divider"></li>
						  <li role="presentation" class='dropdown-header'>Certificados</li>
						  <li><a href='<?php echo $base_url;?>/forms/boletines/buscar_estudiantecert.php'>Buscar Estudiante</a></li>
						  <li role="presentation" class="divider"></li>
						  <li role="presentation" class='dropdown-header'>Estadisticas</li>
						  <li><a href='<?php echo $base_url;?>/forms/estadisticas/ccrendaca.php'>Rendimiento académico x desempeño</a></li>
						  <li><a href='<?php echo $base_url;?>/forms/estadisticas/aprobados_reprobados.php'>Aprobados-Reprobados-Recuperan</a></li>
						  <li><a href='<?php echo $base_url;?>/forms/estadisticas/detalleaprobadosreprobadosform.php'>Detalle Aprobados-Reprobados-Recuperan</a></li>
						  <li role="presentation" class='dropdown-header'>Calificaciones</li>
						  <li><a href="<?php echo $base_url;?>/forms/notas/listarcalificaciones.php">Grupo</a></li>
						  <li><a href="<?php echo $base_url;?>/forms/notas/sintesisxcurso.php">Sintesis</a></li>
						  <li role="presentation" class="divider"></li>
						  <li role="presentation" class='dropdown-header'>Otros</li><li role="presentation" class="divider"></li>
						  <li><a href='<?php echo $base_url;?>/forms/aula/listado_salones.php'>Reporte salones</a></li>
						  <li><a href='<?php echo $base_url;?>/forms/matricula/listado_matricular.php'>Reporte matrícula regular</a></li>
						  <li><a href='<?php echo $base_url;?>/forms/matricula/listado_matriculan.php'>Reporte matrícula nivelación</a></li>
						  <li><a href='<?php echo $base_url;?>/forms/estudiantes/listado_estudiantes.php'>Reporte estudiantes</a></li>
						  <li><a href='<?php echo $base_url;?>/forms/asignatura/listado_asignaturas.php'>Reporte de asignaturas</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  <span class="glyphicon glyphicon-user"></span>
						  <?php echo $user; ?><b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li><a href="logout.php">Cerrar sesión</a></li>
						</ul>
					</li>
				  </ul>
				</div><!--/.nav-collapse -->
			  </div>
			</nav>
			<div class="jumbotron center-block">
				<h2 style='color:blue'>Bienvenido(a) <?php echo $user;?></h2>
				<h2>SISTEMA ACADEMICO DE CALIFICACIONES CELESTE 2.0</h2>
				<p class="lead">“La forma más fácil de administrar sus calificaciones y boletines académicos”</p>
			</div>
			<?php
			}else{
			?>
				<!--<div class="jumbotron center-block">
				<h1 class='alert alert-danger'>Sistema Cerrado</h1>
				<p><a class='btn btn-lg btn-success' href='../index.php' role='button'>Ir al inicio</a></p>
				</div>-->
				<div class="jumbotron center-block">
				<h1 class='alert alert-danger'>Sistema cerrado temporalmente por mantenimiento. Intente en unas horas</h1>
				<p><a class='btn btn-lg btn-success' href='../index.php' role='button'>Ir al inicio</a></p>
				</div>
			<?php
			}
		}
		$conx->close_conex();
			?>
 
    <!-- Librería jQuery requerida por los plugins de JavaScript -->
    <script src="../js/jquery.js"></script>
 
    <!-- Todos los plugins JavaScript de Bootstrap (también puedes
         incluir archivos JavaScript individuales de los únicos
         plugins que utilices) -->
    <script src="../js/bootstrap.min.js"></script>
	 <hr>
	<div class='container center-block'>
		<footer>
			<p>&copy; williamcortes10@gmail.com 2016</p>
		</footer>
	</div>
  </body>
</html>
