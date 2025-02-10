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

$sql = "SELECT valor FROM appconfig WHERE item='aniolect'";
$consulta = $conx->query($sql);
$records = $conx->records_array($consulta);
$aniolectivo= $records['valor'];

$sql = "SELECT num_periodos, tipo_periodo, activo, periodo_nivelaciones FROM periodos_por_anio WHERE anio = '$aniolectivo'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$numero_periodos = $records['num_periodos'];
$periodo_nivelaciones = $records['periodo_nivelaciones'];
$tipo_periodo = $records['tipo_periodo'];
$activo = $records['activo'];

$sql = "SELECT valor FROM appconfig WHERE item = 'periodo_hab'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$periodo_hab = $records['valor'];




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
					<li class="breadcrumb-item"><a href="#">Periodo académico activo</a></li>
					<li class="breadcrumb-item active" aria-current="page">Ver/Modificar</li>
				  </ol>
				</nav>
				<div class="panel panel-danger">
				  <div class="panel-heading">Formulario  - Periodo académico activo</div>
				  <div class="panel-body">
					<form role="form" class="form-horizontal" id='forminstitucion' name='forminstitucion' method='post' action='periodo_academico_activo_response.php'>
				
						<div class="form-group">
							<label for="ie" class="col-sm-4 control-label">Año lectivo <em style='color:red;'>*</em></label>
							<div class="col-sm-6">
								<select class="form-control" id="aniolectivo" name="aniolectivo">
								<?php for($anio=date("Y"); $anio>=2000; $anio--){
										if($anio==$aniolectivo){
											?>
											<option value="<?php echo $anio;?>" selected><?php echo $anio;?></option>
											<?php
										}else{
											?>
											<option value="<?php echo $anio;?>" ><?php echo $anio;?></option>
											<?php
										}
								}?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="nit" class="col-sm-4 control-label">Periodo habilitado <em style='color:red;'>*</em></label>
							<div class="col-sm-6">
							  <select class="form-control" id="periodo_hab" name="periodo_hab">
								<?php for($periodo=1; $periodo<5; $periodo++){
										if($periodo==$periodo_hab){
											?>
											<option value="<?php echo $periodo;?>" selected><?php echo $periodo;?></option>
											<?php
										}else{
											?>
											<option value="<?php echo $periodo;?>" ><?php echo $periodo;?></option>
											<?php
										}
								}?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="nit" class="col-sm-4 control-label">Número de periodos<em style='color:red;'>*</em></label>
							<div class="col-sm-6">
							  <select class="form-control" id="numero_periodos" name="numero_periodos">
								<?php for($periodo=1; $periodo<5; $periodo++){
										if($periodo==$numero_periodos){
											?>
											<option value="<?php echo $periodo;?>" selected><?php echo $periodo;?></option>
											<?php
										}else{
											?>
											<option value="<?php echo $periodo;?>" ><?php echo $periodo;?></option>
											<?php
										}
								}?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="nit" class="col-sm-4 control-label">Periodo habilitado para nivelaciones <em style='color:red;'>*</em></label>
							<div class="col-sm-6">
							  <select class="form-control" id="periodon" name="periodon">
								<?php for($periodon=1; $periodon<5; $periodon++){
										if($periodon==$periodo_nivelaciones){
											?>
											<option value="<?php echo $periodon;?>" selected><?php echo $periodon;?></option>
											<?php
										}else{
											?>
											<option value="<?php echo $periodon;?>" ><?php echo $periodon;?></option>
											<?php
										}
								}?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="nit" class="col-sm-4 control-label">Activo <em style='color:red;'>*</em></label>
							<div class="col-sm-6">
							  <select class="form-control" id="activo" name="activo">
								<?php 
										if($periodo_activo==1){
											?>
											<option value="<?php echo $periodo_activo;?>" selected>Si</option>
											<option value="0">No</option>
											<?php
										}else{
											?>
											<option value="<?php echo $periodo_activo;?>" selected>No</option>
											<option value="1">Si</option>
											<?php
										}
								?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="nit" class="col-sm-4 control-label">Tipo Periodo <em style='color:red;'>*</em></label>
							<div class="col-sm-6">
							  <select class="form-control" id="tipo_periodo" name="tipo_periodo">
								<?php 
										if($tipo_periodo=="S"){
											?>
											<option value="<?php echo $tipo_periodo;?>" selected>Semeste</option>
											<option value="T">Trimestre</option>
											<?php
										}else{
											?>
											<option value="<?php echo $tipo_periodo;?>" selected>Trimestre</option>
											<option value="S">Semeste</option>
											<?php
										}
								?>
								</select>
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
    <script src="../js/bootstrap.min.js"></script>
    <script src="../plugins/validator.io/js/bootstrapValidator.min.js"></script>
    <script src="../plugins/validator.io/js/language/es_ES.js"></script>
	<script> 
	$(document).ready(function() {
		$('#forminstitucion').bootstrapValidator({
            message: 'Valor no valido',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
			// List of fields and their validation rules
			fields: {
				aniolectivo: {
					validators: {
						notEmpty: {
							message: 'Debe seleccionar el año lectivo'
						}
					}
				},
				periodo_hab: {
					validators: {
						notEmpty: {
							message: 'Debe seleccionar periodo académico'
						}
					}
				},
				periodon: {
					validators: {
						notEmpty: {
							message: 'Debe seleccionar periodo habilitado para nivelaciones'
						}
					}
				}
			}
		}).on('success.form.bv', function(e) {
            // Prevent form submission
            e.preventDefault();
			
            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

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
			
			