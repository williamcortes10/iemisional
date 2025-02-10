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
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISTEMA ACADEMICO DE CALIFICACIONES - PANEL ADMINISTRADOR</title>
 
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
			$sql = "SELECT idusuario, apellido1, nombre1, tipousuario FROM usuario, docente 
			WHERE idusuario='".$_SESSION['k_username']."' and iddocente=idusuario and tipousuario='A'";
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
				include('../../administrador/nav.php');
		?>
			
			<div class="container"><br/><br/>
			<h3>Reportes | Informe académico | Grupo</h3>
			<p>Complete datos para generar boletin</p>
			<form role="form" class="form-horizontal" id='formupuser' name='formupuser' method='post' action='boletingeneralimppdf.php'>
				
				<div class="form-group">
					<label class="control-label col-sm-2" for="aula">Grado escolar
					</label>
					<div class="col-sm-10">
					<select  id='aula' name='aula' class="form-control">";
					<?php
					$sql = "SELECT * FROM aula";
					$consultaaulas = $conx->query($sql);
					if ($conx->get_numRecords($consultaaulas)>0) {
						while ($row = $conx->records_array($consultaaulas)) {
							echo "<option value='".$row['idaula']."'>".
							($row['descripcion'])."-Grupo ".$row['grupo']."-".$row['jornada']."</option>";
							
						}
							
					} else {
						echo "<option>No se ha configurado cursos</option>";
					}
					?>
					</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="aniolect">Año lectivo
					</label>
					<div class="col-sm-10">
					<select  id='aniolect' name='aniolect' class="form-control">";
						<?php
						$fechahoy=date("Y");
						for($ano=2030; $ano>1990; $ano--){
							if ($ano==$fechahoy) {
								echo "<option value='".$ano."' selected>".$ano."</option>";
							}else {
								echo "<option value='".$ano."'>".$ano."</option>";
							}
						}
						?>
					</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="periodo">Periodo
					</label>
					<div class="col-sm-10">
					<select  id='periodo' name='periodo' class="form-control">";
						<?php
						$sqlperiodohab = "SELECT * FROM appconfig WHERE item = 'periodo_hab'";
						$qperiodohab = $conx->query($sqlperiodohab);
						$rowperiodo = $conx->records_array($qperiodohab);
						$periodo=$rowperiodo['valor'];
						
						for($i=1; $i<5; $i++){
							if ($i==$periodo) {
								echo "<option value='".$i."' selected>".$i."</option>";
							}else {
								echo "<option value='".$i."'>".$i."</option>";
							}
						}
						?>
					</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="periodo">Formato boletin
					</label>
					<div class="col-sm-10">
					<select  id='formato' name='formato' class="form-control">
					  <option value='f2' >Formato por competencias con historico (Semestral antes de 2018)</option>
					  <option value='f4' >Formato por competencias con historico</option>
					  <!--<option value='f3' >Formato por competencias FINAL</option>-->
					  <option value='f5' >Formato por competencias FINAL</option>
					</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="periodo">Tamaño papel
					</label>
					<div class="col-sm-10">
					<select  id='papel' name='papel' class="form-control">";
						<option value='letter' selected>CARTA</option>
						<option value='legal'>LEGAL</option>
					</select>
					</div>
				</div>
				<div class="form-group">
				  <div class="col-sm-offset-2 col-sm-10">
					<button type="button" class="btn btn-success" id="html">Generar HTML</button>
					<button type="button" class="btn btn-info" id="pdf">Generar PDF</button>
				  </div>
				</div>
				</form>
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
    <script src="../../js/jquery.js"></script>
 
    <!-- Todos los plugins JavaScript de Bootstrap (también puedes
         incluir archivos JavaScript individuales de los únicos
         plugins que utilices) -->
    <script src="../../js/bootstrap.min.js"></script>
	 <hr>
	<div class='container center-block'>
		<footer>
			<p>&copy; williamcortes10@gmail.com 2016</p>
		</footer>
	</div>
  </body>
</html>
<script>
$( "#pdf" ).click(function( event ) {
	$( "#formupuser" ).attr("action", "boletinpdf.php");
	$( "#formupuser" ).submit();
});

$( "#html" ).click(function( event ) {
  $( "#formupuser" ).submit();
});
</script>


			
			