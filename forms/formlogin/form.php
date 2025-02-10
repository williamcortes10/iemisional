<?php
//Datos de Configuración de la app
include('../../class/MySqlClass.php');
include('../../config/config.php');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
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
$conx->close_conex();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISTEMA ACADEMICO DE CALIFICACIONES - BY WILLIAMCORTES10@GMAIL.COM</title>
 
    <!-- CSS de Bootstrap -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<!-- Custom styles for this template -->
    <link href="../../css/formlogin.css" rel="stylesheet">
 
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
				<li class="active"><a href="../../index.php">Inicio</a></li>
				<li><a href="#about">Acerca de esta App</a></li>
				<li><a href="#contact">Contactenos</a></li>
			  </ul>
			</div><!--/.nav-collapse -->
		  </div>
		</nav>
		<!-- Formulario de login -->
		<div class="container center-block">

		  <form class="form-signin" action="loginresponse.php" method="POST">
			<h2 class="form-signin-heading">Iniciar sesión</h2>
			<label for="user" class="sr-only">Usuario</label>
			<input type="text" id="user" name='user' class="form-control" placeholder="Usuario" required autofocus>
			<label for="pass" class="sr-only">Contraseña</label>
			<input type="password" id="pass" name= 'pass' class="form-control" placeholder="Contraseña" required>
			<select id='tp_user' name='tp_user' class="form-control">
				<option value=''>Clic aquí para seleccionar usuario</option>	
				<option value='D'>Docente</option>	
				<option value='A'>Administrador</option>
				<option value='C'>Coordinador</option>
				<option value='S'>Secretaria</option>
			</select>
			<div class="checkbox">
			  <label>
				<input type="checkbox" value="1" id="sesion" checked> No cerrar sesión
			  </label>
			</div>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Inicia sesión</button>
		  </form>

		</div> <!-- /container -->
 
    <!-- Librería jQuery requerida por los plugins de JavaScript -->
    <script src="../../js/jquery.js"></script>
 
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