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
$sql = "SELECT * FROM appconfig WHERE item = 'aniolect'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$aniolectivo = $records['valor'];
//$aniolectivo = 2015;
$sql = "SELECT * FROM appconfig WHERE item = 'periodo_hab'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$periodo = $records['valor'];

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISTEMA ACADEMICO DE CALIFICACIONES - SINTESIS CALIFICACIONES</title>
 
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
			WHERE idusuario='".$_SESSION['k_username']."' and iddocente=idusuario and (tipousuario='A' or tipousuario='S')";
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
			$sql = "SELECT * FROM appconfig WHERE item = 'index_docen_ful'";
			$consulta = $conx->query($sql);
			$recordsM = $conx->records_array($consulta);
			if($recordsM['valor']=='on' or $tipousuario=='A')
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
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Reportes<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li role="presentation" class='dropdown-header'>Informe académico</li>
						  <li><a href='../forms/boletines/boletingeneral.php'>Grupo</a></li>
						  <li><a href='../forms/boletines/buscar_estudiante.php'>Individual</a></li>
						  <li role="presentation" class="divider"></li>
						  <li role="presentation" class='dropdown-header'>Certificados</li>
						  <li><a href='../forms/boletines/buscar_estudiantecert.php'>Buscar Estudiante</a></li>
						  <li role="presentation" class="divider"></li>
						  <li role="presentation" class='dropdown-header'>Estadisticas</li>
						  <li><a href='../forms/estadisticas/ccrendaca.php'>Rendimiento académico</a></li>
						  <li><a href='#'>Estudiantes Aprobados</a></li>
						  <li><a href='../forms/estadisticas/listado_reprobados.php'>Estudiantes reprobados</a></li>
						  <li><a href='../forms/estadisticas/estudiantes_recuperan.php'>Estudiantes que recuperan</a></li>
						  <li role="presentation" class='dropdown-header'>Calificaciones</li>
						  <li><a href="../forms/notas/listarcalificaciones.php">Grupo</a></li>
						  <li><a href="../forms/notas/sintesisxcurso.php">Sintesis</a></li>
						  <li role="presentation" class="divider"></li>
						  <li role="presentation" class='dropdown-header'>Otros</li><li role="presentation" class="divider"></li>
						  <li><a href='../forms/aula/listado_aula.php'>Reporte salones</a></li>
						  <li><a href='../forms/matricula/listado_matricular.php'>Reporte matrícula regular</a></li>
						  <li><a href='../forms/matricula/listado_matriculan.php'>Reporte matrícula nivelación</a></li>
						  <li><a href='../forms/estudiantes/listado_estudiantes.php'>Reporte estudiantes</a></li>
						  <li><a href='../forms/asignatura/listado_asignaturas.php'>Reporte de asignaturas</a></li>
						</ul>
					</li>
					
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  <span class="glyphicon glyphicon-user"></span>
						  <?php echo $user; ?><b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li><a href="../../secretaria/logout.php">Cerrar sesión</a></li>
						</ul>
					</li>
				  </ul>
				</div><!--/.nav-collapse -->
			  </div>
			</nav>
			<div class="containertable table-responsive center-block">
		
			<?php
				echo "<h3 style='text-align:center;'>ESTUDIANTES QUE RECUPERAN</h3><hr/>";
				//paginación
				//include("../../class/zebra_pagination/Zebra_Pagination.php"); 
					$sql = "SELECT * FROM aula ORDER BY grado, grupo, jornada ASC";
					$sql_anios_lectivos="SELECT DISTINCT aniolectivo from escala_de_calificacion ORDER BY aniolectivo DESC";
					$consulta = $conx->query($sql);
					$consulta_anios_lectivos = $conx->query($sql_anios_lectivos);
					$sql_materias = "SELECT DISTINCT m.abreviatura, m.idmateria, m.idarea_fk, m.nombre_materia FROM materia m
									LEFT JOIN clase c ON c.idmateria=m.idmateria 
									ORDER BY c.idmateria ASC;";
					$consulta_materias = $conx->query($sql_materias);
					
					?>
					<br/>
					<div class="form-group form-inline">
					<form method='POST' action='listado_recuperan.php'>
					<label for="periodo">Corte:</label>
					<select id='periodo' name='periodo' class="form-control">
					<?php 
						for($i=1; $i<5; $i++){
							echo "<option value='$i'>$i ° Periodo</option>";
						}
						echo "<option value='s1'>1er semestre</option>";
						echo "<option value='s2'>2do semestre</option>";
						echo "<option value='F'>Final</option>";
						
					?>
					</select>
					<label for="aniolectivo">Año lectivo:</label>
					<select id='aniolectivo' name='aniolectivo' class="form-control">
					<?php 
						while ($rowanio = $conx->records_array($consulta_anios_lectivos)) {
							$anio=$rowanio['aniolectivo'];
							echo "<option value='$anio'>$anio</option>";
						}
						
					?>
					</select>
					<label for="idaula">Curso:</label>
					<select id='idaula' name='idaula' class="form-control">
					<?php 
						while ($row = $conx->records_array($consulta)) {
							$idaula = $row['idaula'];
							$curso=utf8_encode($row['descripcion'])."-GRUPO ".$row['grupo']."-".$row['jornada'];
							echo "<option value='$idaula'>$curso</option>";
						}
						
					?>
					</select><br/><br/>
					<label for="idmateria">Asignatura:</label>
					<select id='idmateria' name='idmateria' class="form-control">
					<?php 
						echo "<option value='T'>Todas las asignaturas</option>";
						while ($row = $conx->records_array($consulta_materias)) {
							$idmateria = $row['idmateria'];
							$asignatura=utf8_encode($row['nombre_materia']."[".$row['abreviatura']."]");
							echo "<option value='$idmateria'>$asignatura</option>";
						}
						
					?>
					</select>
					<?php 
						echo "<button type='submit' class='btn btn-primary'><span>Generar listado</span></button>";
					?>
					</form>
					</div>
					
					
					<?php
				
			}else{
			?>
				<div class="jumbotron center-block">
				<h1 class='alert alert-danger'>Sistema Cerrado</h1>
				<p><a class='btn btn-lg btn-success' href='../index.php' role='button'>Ir al inicio</a></p>
				</div>
			<?php
			}
		}
		$conx->close_conex();
			?>
		</div>
    <!-- Librería jQuery requerida por los plugins de JavaScript -->
    <script src="../../js/jquery.js"></script>
	<script>

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
