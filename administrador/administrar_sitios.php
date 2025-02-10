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

$sql = "SELECT valor FROM appconfig WHERE item='index_docen_nv'";
$consulta = $conx->query($sql);
$records = $conx->records_array($consulta);
$index_docen_nv= $records['valor'];

$sql = "SELECT valor FROM appconfig WHERE item = 'index_docen_nt'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$index_docen_nt = $records['valor'];

$sql = "SELECT valor FROM appconfig WHERE item = 'index_docen_ful'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$index_docen_ful = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'index_estudiant'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$index_estudiant = $records['valor'];

$sql = "SELECT valor FROM appconfig WHERE item = 'index_docen_ca'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$index_docen_ca = $records['valor'];

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISTEMA ACADEMICO DE CALIFICACIONES - PANEL ADMINISTRADOR</title>
 
    <!-- CSS de Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../css/bootstrap-toggle.min.css" rel="stylesheet" media="screen">
	<!-- CSS de Validator.io -->
    <link href="../plugins/validator.io/css/bootstrapValidator.min.css" rel="stylesheet" media="screen">
	<!-- Custom styles for this template -->
    <link href="../css/index.css" rel="stylesheet">
	<style>
	@media (max-width: 900px) { 
            .nav navbar-nav{
                    text-align: center;
                   }
}
	</style>
 
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
				include('nav.php');
		?>
			
			<div class="container">
				<!-- Modal -->
				  <div class="modal fade" id="myModal" role="dialog">
					<div class="modal-dialog modal-xs">
					  <div class="modal-content">
						<div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title"><i class='glyphicon glyphicon-info-sign'></i> Atención</h4>
						</div>
						<div class="modal-body">
						  <p></p>
						</div>
						<div class="modal-footer">
						  <button type="button" class="btn btn-default" data-dismiss="modal">cerrar</button>
						</div>
					  </div>
					</div>
				  </div>
				  <br/><br/><br/>
				<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">Configuración</a></li>
					<li class="breadcrumb-item"><a href="#">Acceso a sitios</a></li>
					<li class="breadcrumb-item active" aria-current="page">Administrar</li>
				  </ol>
				</nav>
				<div class="panel panel-danger">
				  <div class="panel-heading">Formulario  - Administar acceso a sitios</div>
				  <div class="panel-body">
					<form role="form" class="form-horizontal" id='forminstitucion' name='forminstitucion' method='post' action='administrar_sitios_response.php'>
				
						<div class="form-group">
							<label for="ie" class="col-sm-4 control-label">Acceso a la plataforma para docentes<em style='color:red;'>*</em></label>
							<div class="col-sm-6">
							<?php 
							if($index_docen_ful=="on"){
								?>
								<input id="index_docen_ful" name="index_docen_ful" type="checkbox" checked data-toggle="toggle" data-size="small">
								<?php
							}else{
								?>
								<input id="index_docen_ful" name="index_docen_ful" type="checkbox" data-toggle="toggle" data-size="small">
								<?php
							}
							?>
							
							</div>
						</div>
						<div class="form-group">
							<label for="ie" class="col-sm-4 control-label">Acceso a la plataforma para estudiantes<em style='color:red;'>*</em></label>
							<div class="col-sm-6">
							<?php 
							if($index_estudiant=="on"){
								?>
								<input id="index_estudiant" name="index_estudiant" type="checkbox" checked data-toggle="toggle" data-size="small">
								<?php
							}else{
								?>
								<input id="index_estudiant" name="index_estudiant" type="checkbox" data-toggle="toggle" data-size="small">
								<?php
							}
							?>
							
							</div>
						</div>
						<div class="form-group">
							<label for="ie" class="col-sm-4 control-label">Permitir ingreso de calificaciones<em style='color:red;'>*</em></label>
							<div class="col-sm-6">
							<?php 
							if($index_docen_nt=="on"){
								?>
							<input id="index_docen_nt" name="index_docen_nt" type="checkbox" checked data-toggle="toggle" data-size="small">
								<?php
							}else{
								?>
								<input id="index_docen_nt" name="index_docen_nt" type="checkbox" data-toggle="toggle" data-size="small">
								<?php
							}?>
							</div>
						</div>
						<div class="form-group">
							<label for="ie" class="col-sm-4 control-label">Permitir ingreso de competencias académicas<em style='color:red;'>*</em></label>
							<div class="col-sm-6">
							<?php 
							if($index_docen_ca=="on"){
								?>
							<input id="index_docen_ca" name="index_docen_ca" type="checkbox" checked data-toggle="toggle" data-size="small">
								<?php
							}else{
								?>
								<input id="index_docen_ca" name="index_docen_ca" type="checkbox" data-toggle="toggle" data-size="small">
								<?php
							}?>
							</div>
						</div>
						<div class="form-group">
							<label for="ie" class="col-sm-4 control-label">Permitir ingreso de nivelaciones<em style='color:red;'>*</em></label>
							<div class="col-sm-6">
							<?php 
							if($index_docen_nv=="on"){
								?>
							<input id="index_docen_nv" name="index_docen_nv" type="checkbox" checked data-toggle="toggle" data-size="small">
								<?php
							}else{
								?>
								<input id="index_docen_nv" name="index_docen_nv" type="checkbox" data-toggle="toggle" data-size="small">
								<?php
							}?>
							</div>
						</div>
						
						
						<div class="form-group">
						  <div class="col-sm-offset-4 col-sm-10">
							<button type="submit" class="btn btn-success" data-toggle="modal" data-target="#">Guardar</button>
						  </div>
						</div>
					</form>
				  </div>
				</div>
			
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
    <script src="../js/jquery.js"></script>
 
    <!-- Todos los plugins JavaScript de Bootstrap (también puedes
         incluir archivos JavaScript individuales de los únicos
         plugins que utilices) -->
    <script src="../js/bootstrap-toggle.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../plugins/validator.io/js/bootstrapValidator.min.js"></script>
    <script src="../plugins/validator.io/js/language/es_ES.js"></script>
	<script> 
	$(document).ready(function() {
		$( "#forminstitucion" ).submit(function( event ) {
 
			  // Stop form from submitting normally
			  event.preventDefault();
			 
			  // Get some values from elements on the page:
			  var $form = $( this );

				// Use Ajax to submit form data
				$.post($form.attr('action'), $form.serialize(), function(result) {
					$('#myModal .modal-body p').html(result)
					$("#myModal").modal();
				});
        });
	});
	</script>
	 <hr>
	<div class='container center-block'>
		<footer>
			<p>&copy; williamcortes10@gmail.com 2016</p>
		</footer>
	</div>
  </body>
</html>
			
			