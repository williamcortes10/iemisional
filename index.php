<?php
//Datos de Configuración de la app
session_start();
include('config/config.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISTEMA ACADEMICO DE CALIFICACIONES - BY WILLIAMCORTES10@GMAIL.COM</title>
 
    <!-- CSS de Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	<!-- Custom styles for this template -->
    <link href="css/index.css" rel="stylesheet">
 
    <!-- librerías opcionales que activan el soporte de HTML5 para IE8 -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	  <nav class="navbar navbar-inverse navbar-fixed-top">
		  <div class="container">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Versión para Smart Phone/Movil</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="#">Celeste 2.0 - <?php echo utf8_encode($ie);?></a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
			  <ul class="nav navbar-nav">
				<li class="active"><a href="index.php">Inicio</a></li>
				<li><a href="#about">Acerca de esta App</a></li>
				<li><a href="#contact">Contactenos</a></li>
			  </ul>
			</div><!--/.nav-collapse -->
		  </div>
		</nav>
		<div class="jumbotron center-block">
			<h1>CELESTE 2.0</h1>
			<p class="lead">“La forma más fácil de administrar sus calificaciones y boletines académicos”</p>
			<!--<p class="lead">“De ante mano pedimos disculpas, pero por motivos de falla critica en el servidor ocacionada por problemas electricos los que habian ingresado se perdieron”</p>
			<p class="lead">“Por lo tanto deben ingresar nuevamente datos del segundo periodo, solicito que se comuniquen al 3168397983 aquellos docentes que ya habian ingresado parte de sus notas.”</p>
			<p class="lead">“De igual forma el sistema de ingreso de notas se hizo más facil y rapido, Muchas gracias.”</p>-->
			<p><a class="btn btn-lg btn-success" href="forms/formlogin/form.php" role="button">Clic aquí para ingresar al sistema</a></p>
		</div>
 
    <!-- Librería jQuery requerida por los plugins de JavaScript -->
    <script src="js/jquery.js"></script>
 
    <!-- Todos los plugins JavaScript de Bootstrap (también puedes
         incluir archivos JavaScript individuales de los únicos
         plugins que utilices) -->
    <script src="js/bootstrap.min.js"></script>
	 <hr>
	<div class='container center-block'>
		<footer>
			<p>&copy; williamcortes10@gmail.com 2015</p>
		</footer>
	</div>
  </body>
</html>
<?php
?>
