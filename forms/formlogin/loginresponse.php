<?php
//Datos de Configuración de la app
session_start();
include("../../class/ultimatemysql/mysql.class.php");
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
include('../../bitacora.php');
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
				<li class="active"><a href="index.php">Inicio</a></li>
				<li><a href="#about">Acerca de esta App</a></li>
				<li><a href="#contact">Contactenos</a></li>
			  </ul>
			</div><!--/.nav-collapse -->
		  </div>
		</nav>
		<!-- respuesta login -->
		<div class="center-block error-signin">

		  <?php
				if(!empty($_POST['user']) && !empty($_POST['pass']) && !empty($_POST['tp_user'])){
					$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
					$user = $_POST['user'];
					$pass = md5($_POST['pass']);
					$tipo_user = $_POST['tp_user'];
					$sql = "SELECT idusuario, tipousuario FROM usuario WHERE idusuario='".$user."' 
					AND contrasena='".$pass."'"." AND tipousuario='".$tipo_user."' LIMIT 1;";
					$consulta = $conx->query($sql);
					if($conx->get_numRecords($consulta)>0){
						$records = $conx->records_array($consulta);
						if($records['tipousuario']==$tipo_user && $tipo_user=="A"){
							$_SESSION["k_username"] = $user;
							//$sqllog = "INSERT INTO logs_sesions (user,fecha,accion,ipclie) VALUES ('".$_SESSION['k_username']."','".$date."','INICIO DE SESION','".$ip."')";
							//$consulta = $conx->query($sqllog);
							log_accesos($user, $conx);
							header('Location: ../../administrador/index.php');
						}else if($records['tipousuario']==$tipo_user && $tipo_user=="D"){
								$_SESSION["k_password"] = $pass;
								$_SESSION["k_username"] = $user;
								log_accesos($user, $conx);
								header('Location: ../../docente/index.php');
						}else if($records['tipousuario']==$tipo_user && $tipo_user=="S"){
								$_SESSION["k_password"] = $pass;
								$_SESSION["k_username"] = $user;
								log_accesos($user, $conx);
								header('Location: ../../secretaria/index.php');
						}elseif($records['tipousuario']==$tipo_user && $tipo_user=="C"){
								$_SESSION["k_password"] = $pass;
								$_SESSION["k_username"] = $user;
								log_accesos($user, $conx);
								header('Location: ../../coordinador/index.php');
						}else{
							echo "<h1 class='alert alert-danger'>Usuario No existe</h1>";
							echo "<p><a class='btn btn-lg btn-success' href='".$_SERVER['HTTP_REFERER']."' role='button'>Regresar</a></p>";
						}
					}else{
						echo "<h1 class='alert alert-danger'>Usuario No existe</h1>";
						echo "<p><a class='btn btn-lg btn-success' href='".$_SERVER['HTTP_REFERER']."' role='button'>Regresar</a></p>";
					}
					
				}else{
						echo "<h1>Datos incompletos</h1>";
						echo "<p><a class='btn btn-lg btn-success' href='".$_SERVER['HTTP_REFERER']."' role='button'>Regresar</a></p>";
				}
				$conx->close_conex();

			?>

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