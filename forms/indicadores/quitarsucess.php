<?php
//Datos de Configuración de la app
session_start();
include("../../class/ultimatemysql/mysql.class.php");
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
$iddocente = $_POST['iddocente'];
$periodo = $_POST['periodo'];
$aniolectivo = $_POST['aniolectivo'];
$idmateria = $_POST['idmateria'];
$grado = $_POST['grado'];
$flag=false;
$numreg=0;
$competencias=$_POST['idcompetencias'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISTEMA ACADEMICO DE CALIFICACIONES - QUITAR COMPETENCIA DE CALIFICACIONES</title>
 
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
			WHERE idusuario='".$_SESSION['k_username']."' and iddocente=idusuario and tipousuario='D'";
			$consulta = $conx->query($sql);
			if($conx->get_numRecords($consulta)>0){
				$records = $conx->records_array($consulta);
				$user=$records['nombre1']." ".$records['apellido1']; 
				$iddocente=$records['iddocente']; 
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
			if($recordsM['valor']=='on')
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
						  <li><a href="../forms/indicadores/nvcompetencia.php">Nueva</a></li>
						  <li><a href="../forms/indicadores/actelimcompetencia.php">Actualizar/Eliminar</a></li>
						  <li><a href="../forms/indicadores/selecionarcompetencia.php">Seleccionar Competencias</a></li>
						  <li><a href="../forms/indicadores/desselecionarcompetencia.php">Quitar Competencias</a></li>
						  <li><a href="../forms/indicadores/categorizarcompetencia.php" class="btn btn-success white-text">Categorizar Competencias</a></li>
						  
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
						  <li role="presentation" class="divider"></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Informes<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li><a href="../notas/listarcalificaciones.php">Generar informe de notas</a></li>
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
			<br/>
			<?php
				if(!$competencias){
					
			?>
				<br/>
				<br/>
				<div class="containertable center-block alert alert-danger">
					Error ! Debe Seleccionar al menos un indicador.
					<p><a class='btn btn-lg btn-success ' href='<?php echo $_SERVER['HTTP_REFERER'];?>' role='button'>Volver</a></p>
				</div>
			<?php

				}else{
					$text= "Las siguientes competencias no se quitaron por que ya fueron usadas para calificar a estudiantes, Codigo(s):";
					$textsucess="Las siguientes competencias se quitaron de las calificaciónes en el $periodo ° periodo,  Codigo(s): ";
					foreach($_POST['idcompetencias'] as $id){
						$values["idindicador"] = MySQL::SQLValue($id);
						$values["iddocente"]  = MySQL::SQLValue($iddocente);
						$values["aniolectivo"] = MySQL::SQLValue($aniolectivo);
						$values["periodo"] = MySQL::SQLValue($periodo);
						$values["grado"] = MySQL::SQLValue($grado);
						$values["idmateria"] = MySQL::SQLValue($idmateria);
						$sqlddelete=MySQL::BuildSQLDelete("indicadoresboletin", $values);
						$sqlduplicateentry = "SELECT * FROM indicadoresboletin ib, 
						indicadoresestudiante ist WHERE ib.idindicador=ist.idindicador 
						and ib.periodo =$periodo and ib.iddocente =$iddocente and ib.idmateria =$idmateria
						and ib.aniolectivo =$aniolectivo and ib.idindicador='$id'
						and ib.periodo =ist.periodo and ib.aniolectivo =ist.aniolectivo and ib.idmateria =ist.idmateria
						and ib.grado IN (SELECT grado FROM matricula m, aula a WHERE m.idestudiante=ist.idestudiante and m.idaula=a.idaula
						and a.grado='$grado' and m.aniolectivo='$aniolectivo' and m.tipo_matricula='R' and m.periodo='R')";
						$consulta1 = $conx->query($sqlduplicateentry);
						if($id!=NULL){
							if($conx->get_numRecords($consulta1)>0){
								$text.="$id, ";
								$flag=true;
							}else{
								$consulta = $conx->query($sqlddelete);
								$numreg++;
								$textsucess.="$id, ";
							}
						}
					}
					if($flag){
					?>
						<br/>
						<br/>
						<div class="containertable center-block alert alert-danger">
							<h4><?php echo $text; ?></h4>
							<p><a class='btn btn-lg btn-success ' href='<?php echo $_SERVER['HTTP_REFERER'];?>' role='button'>Volver</a></p>
						</div>
					<?php 
					}
					if($numreg>0){
					?>
						<br/>
						<br/>
						<div class="containertable center-block alert alert-success">
							<h4><?php echo $textsucess; ?></h4>
							<p><a class='btn btn-lg btn-success ' href='<?php echo $_SERVER['HTTP_REFERER'];?>' role='button'>Volver</a></p>
						</div>
					<?php 
					}
				}

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
