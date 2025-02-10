<?php
session_start();
include("../../class/ultimatemysql/mysql.class.php");
//Datos de Configuración de la app
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
$idmateria = $_POST['idmateria'];
$periodo = $_POST['periodo'];
$aniolectivo = $_POST['aniolectivo'];
$grado = $_POST['grado'];
$idaula = $_POST['idaula'];
$flag=false;
$numreg=0;
$competencias=$_POST['idcompetencias'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="text/html; charset=UTF-8" />
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
				<p><a class='btn btn-lg btn-success' href='../../index.php' role='button'>Ir al inicio</a></p>
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
					$text= "Las siguientes competencias no se guardaron por que ya fueron seleccionados ";
					$textsucess="Las siguientes competencias se guardaron para calificar en el $periodo ° periodo, ";
					foreach($_POST['idcompetencias'] as $id){
						$values["idindicador"] = MySQL::SQLValue($id);
						$values["iddocente"]  = MySQL::SQLValue($iddocente);
						$values["aniolectivo"] = MySQL::SQLValue($aniolectivo);
						$values["periodo"] = MySQL::SQLValue($periodo);
						$values["grado"] = MySQL::SQLValue($grado);
						$values["idmateria"] = MySQL::SQLValue($idmateria);
						$sqlinsert=MySQL::BuildSQLInsert("indicadoresboletin", $values);
						//verificando si ya existe el indicador en la  tabla indicadoresboletin
						$where = MySQL::BuildSQLWhereClause($values);
						$sqlduplicateentry = "SELECT * FROM indicadoresboletin $where";
						$consulta1 = $conx->query($sqlduplicateentry);
						if($id!=NULL){
							if($conx->get_numRecords($consulta1)>0){
								$text.="Codigo(s): $id, ";
								$flag=true;
							}else{
								$consulta = $conx->query($sqlinsert);
								$numreg++;
								$textsucess.="Codigo(s): $id, ";
								
							}
						}
					}
					if($flag){
					?>
						<br/>
						<br/>
						<div class="containertable center-block alert alert-danger">
							<h4><?php echo $text; ?></h4>
							<p></p>
						</div>
					<?php 
					}
					if($numreg>0){
					?>
						<br/>
						<br/>
						<div class="containertable center-block alert alert-success">
							<h4><?php 
							$textsucess.="<br/> Para agilizar el  proceso de calidicaciòn se recomienda categorizar las competencias.<br/> ir al siguiente enlace: 
							<a href='listarcompetenciasseleccionadacat.php?id=$iddocente&idmateria=$idmateria&idaula=$idaula&aniolectivo=$aniolectivo' class='btn btn-success white-text'>Categorizar Competencias</a><br/>";
							echo $textsucess; ?></h4>
							<p><a class='btn btn-lg btn-success ' href='<?php echo $_SERVER['HTTP_REFERER'];?>' role='button'>Volver</a></p>
						</div>
					<?php 
					}
					
				}
			

			}else{
			?>
				<div class="jumbotron center-block">
				<h1 class='alert alert-danger'>Sistema Cerrado</h1>
				<p><a class='btn btn-lg btn-success' href='../../index.php' role='button'>Ir al inicio</a></p>
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
