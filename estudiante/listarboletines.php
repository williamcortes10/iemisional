<?php
//Datos de Configuración de la app
session_start();
include('../class/MySqlClass.php');
include('../bdConfig.php');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$look=false;
$sql = "SELECT valor FROM appconfig WHERE item='ie'";
$consulta = $conx->query($sql);
$records = $conx->records_array($consulta);
$ie= $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item='periodo_hab'";
$consulta = $conx->query($sql);
$records = $conx->records_array($consulta);
$periodo_hab= $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item='aniolect'";
$consulta = $conx->query($sql);
$records = $conx->records_array($consulta);
$aniolectivo= $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'pages'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$pages = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'convenciones'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$convencion = $records['valor'];
$sql = "SELECT num_periodos, tipo_periodo FROM periodos_por_anio WHERE anio = '$aniolectivo'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$num_periodos = $records['num_periodos'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISTEMA ACADEMICO DE CALIFICACIONES - PANEL COORDINADOR ACADEMICO</title>
 
    <!-- CSS de Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<!-- Custom styles for this template -->
    <link href="../css/index.css" rel="stylesheet">
 
    <!-- librerías opcionales que activan el soporte de HTML5 para IE8 -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script type="text/javascript">
		
		function generarBoletin(codigo, idaula, aniolectivo){
			$(document).ready(function(){
				periodo=<?php echo $periodo_hab; ?>;
				anioactivo=<?php echo $aniolectivo; ?>;
				numperiodos=<?php echo $num_periodos; ?>;
				papel="legal";
				if(aniolectivo<2016 && aniolectivo!=anioactivo){
					formato="f3";
					periodo=4;
				}else if(aniolectivo<anioactivo){
					formato="f5";
					periodo=3;
				}else if(aniolectivo==anioactivo && periodo!=numperiodos){
					formato="f4";
				}else{
					formato="f5";
				}

				location.href='boletinindividual.php?idestudiante='+codigo+'&aula='+idaula+'&aniolect='+aniolectivo+'&periodo='+periodo+'&formato='+formato+'&papel='+papel;	
			  
			});
		}
		

		</script>
		
  </head>
  <body>
		<?php 
		if (isset($_SESSION['k_username'])) {
			$sql = "SELECT idestudiante,nombre1, apellido1 FROM estudiante WHERE idestudiante='".$_SESSION['k_username']."' 
					AND habilitado='S' LIMIT 1";
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
				<p><a class='btn btn-lg btn-success' href='index.php' role='button'>Ir al inicio</a></p>
			</div>
		<?php
		}
		if($look){
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
					<li class="active"><a href="nav.php">Inicio</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Boletines académicos<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li><a href="<?php echo $base_url;?>/estudiante/listarboletines.php">Generar informe de notas</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  <span class="glyphicon glyphicon-user"></span>
						  <?php echo ($user); ?><b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li><a href="<?php echo $base_url; ?>/estudiante/logout.php">Cerrar sesión</a></li>
						</ul>
					</li>
				  </ul>
				</div><!--/.nav-collapse -->
			  </div>
			</nav>
			<?php
			$str_search = $_SESSION['k_username'];
			include('boletinesestudiante.php'); ?>
		
		<?php
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
			<p>&copy; williamcortes10@gmail.com 2018</p>
		</footer>
	</div>
  </body>
</html>
