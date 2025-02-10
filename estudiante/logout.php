<?php
//Datos de Configuración de la app
session_start();
include('../class/MySqlClass.php');
include('../bdConfig.php');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISTEMA ACADEMICO DE CALIFICACIONES - SESIÓN CERRADA</title>
 
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
			session_destroy();
		?>
		<div class="jumbotron center-block">
			<h1 class='alert'>Ha terminado la sesión </h1>
			<p><a class='btn btn-lg btn-success' href='index.php' role='button'>Ir al inicio</a></p>
		</div>
		<?php
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
			<p>&copy; williamcortes10@gmail.com 2015</p>
		</footer>
	</div>
  </body>
</html>
