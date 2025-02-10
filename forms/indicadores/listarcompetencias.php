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
$sql = "SELECT * FROM appconfig WHERE item = 'aniolect'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$aniolectivo = $records['valor'];

$aniolectivo = $_GET['aniolectivo'];;
$iddocente = $_GET['id'];;
$idmateria=$_GET['idmateria'];
$idaula=$_GET['idaula'];
$sql = "SELECT nombre_materia FROM materia WHERE idmateria = '$idmateria'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$nommateria = $records['nombre_materia'];
$sql = "SELECT descripcion, grupo, grado FROM aula WHERE idaula = '$idaula'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$curso = utf8_encode($records['descripcion']);
$grado = $records['grado'];
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISTEMA ACADEMICO DE CALIFICACIONES - ACTUALIZAR/ELEIMINAR COMPETENCIA</title>
 
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
			<div class="containertable table-responsive center-block">
			<?php
				$sql = "SELECT consecutivo, descripcion, grados, competencia FROM plan_curricular, estandares WHERE gradounico = '$grado' AND iddocente = '$iddocente' 
				and estandarbc=codigo and idmateria_fk='$idmateria'ORDER BY consecutivo DESC";
				$consulta = $conx->query($sql);
				echo "<h3 style='text-align:center;'>ACTUALIZAR O ELEIMINAR COMPETENCIAS</h3> <hr/><h4>COMPETENCIAS CREADAS POR $user EN ".utf8_encode($nommateria)." DE $curso</h4>";
				if($conx->get_numRecords($consulta)>0){
					echo "<table class='table table-hover' style='text-align:left;'>";
					echo "<thead>";
					echo "<tr>";
					echo "<th>Codigo</th>";
					echo "<th>Componente</th>";
					echo "<th>Competencia</th>";
					echo "<th>Grupo de grados</th>";
					echo "<th></th>";
					echo "<th></th>";
					echo"</tr>";
					echo "</thead>";
					echo "<tbody>";
					while ($row = $conx->records_array($consulta)) {
						$id = $row['consecutivo'];
						echo "<tr>";
						echo "<td>".$row['consecutivo']."</td>";
						echo "<td>".utf8_encode($row['descripcion'])."</td>";
						echo "<td>".utf8_encode($row['competencia'])."</td>";
						echo "<td>".$row['grados']."</td>";
						echo "<td><a class='btn btn-warning' href='actcomptenciaform.php?id=$id&iddocente=$iddocente&idmateria=$idmateria&aniolectivo=$aniolectivo'><span>Actualizar</span></a></td>";
						echo "<td><a class='btn btn-danger' onclick='eliminar(".$id.",".$iddocente.")'><span>Eliminar</span></a></td>";
						echo "</tr>";
					}
					echo "</tbody>";
					echo "</table>";
				}else {
				?>
					<div class="jumbotron center-block">
					<h2 class='alert alert-danger'>Usted no ha creado competencias para esta asignatura</h2>
					<p><a class='btn btn-lg btn-success '  href='actelimcompetencia.php' role='button'>Volver</a></p>
					</div>
				<?php

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
		</div>
    <!-- Librería jQuery requerida por los plugins de JavaScript -->
    <script src="../../js/jquery.js"></script>
    <script>
		function eliminar(id,iddocente){
			$(document).ready(function(){
				if(confirm("Realmente desea eliminar competencia?")){
					location.href='elimcomptenciaformsucess.php?id='+id+'&iddocente='+iddocente;	
				}
			});
		}
		
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
