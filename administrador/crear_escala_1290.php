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
					<li class="breadcrumb-item"><a href="#">Escala de calificación 1290</a></li>
					<li class="breadcrumb-item active" aria-current="page">Nueva escala de calificación</li>
				  </ol>
				</nav>
				<div class="panel panel-danger">
				  <div class="panel-heading">Formulario  - Nueva escala 1290</div>
				  <div class="panel-body">
					<form role="form" class="form-horizontal" id='forminstitucion' name='forminstitucion' method='post' action='crear_escala_1290_response.php'>
				
						<table class="table table-bordered table-striped table-responsive">
						  <thead>
							<tr>
								<th scope="col">AÑO LECTIVO</th>
								<th scope="col">
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
								</th>
							</tr>
							<tr>
								<th scope="col" class="text-righ">DESEMPEÑO</th>
								<th scope="col">RANGO</th>
							</tr>
						  </thead>
						  <tbody>
							<tr>
							  <th scope="row">Desempeño Superior</th>
								<td>
									<div class="form-group">
										<label for="ie" class="col-sm-1 control-label">Mínimo<em style='color:red;'>*</em></label>
										<div class="col-sm-3">
											<select class="form-control" id="dsmin" name="dsmin">
											<?php for($dsmin=10.0; $dsmin>=1.0; $dsmin-=0.1){
												?>
												<option value="<?php echo $dsmin;?>" ><?php echo number_format($dsmin,1);?></option>
												<?php
											}?>
											</select>
										</div>
										<label for="ie" class="col-sm-1 control-label">Máximo<em style='color:red;'>*</em></label>
											<div class="col-sm-3">
												<select class="form-control" id="dsmax" name="dsmax">
											<?php for($dsmax=10.0; $dsmax>=1.0; $dsmax-=0.1){
												?>
												<option value="<?php echo $dsmax;?>" ><?php echo number_format($dsmax,1);?></option>
												<?php
											}?>
											</select>
										</div>
									</div>
							  </td>
							</tr>
							<tr>
							  <th scope="row">Desempeño Alto</th>
								<td>
									<div class="form-group">
										<label for="ie" class="col-sm-1 control-label">Mínimo<em style='color:red;'>*</em></label>
										<div class="col-sm-3">
											<select class="form-control" id="damin" name="damin">
											<?php for($damin=10.0; $damin>=1.0; $damin-=0.1){
												?>
												<option value="<?php echo $damin;?>" ><?php echo number_format($damin,1);?></option>
												<?php
											}?>
											</select>
										</div>
										<label for="ie" class="col-sm-1 control-label">Máximo<em style='color:red;'>*</em></label>
											<div class="col-sm-3">
												<select class="form-control" id="damax" name="damax">
											<?php for($damax=10.0; $damax>=1.0; $damax-=0.1){
												?>
												<option value="<?php echo $damax;?>" ><?php echo number_format($damax,1);?></option>
												<?php
											}?>
											</select>
										</div>
									</div>
							  </td>
							</tr>
							<tr>
							  <th scope="row">Desempeño Básico</th>
								<td>
									<div class="form-group">
										<label for="ie" class="col-sm-1 control-label">Mínimo<em style='color:red;'>*</em></label>
										<div class="col-sm-3">
											<select class="form-control" id="dbmin" name="dbmin">
											<?php for($dbmin=10.0; $dbmin>=1.0; $dbmin-=0.1){
												?>
												<option value="<?php echo $dbmin;?>" ><?php echo number_format($dbmin,1);?></option>
												<?php
											}?>
											</select>
										</div>
										<label for="ie" class="col-sm-1 control-label">Máximo<em style='color:red;'>*</em></label>
											<div class="col-sm-3">
												<select class="form-control" id="dbmax" name="dbmax">
											<?php for($dbmax=10.0; $dbmax>=1.0; $dbmax-=0.1){
												?>
												<option value="<?php echo $dbmax;?>" ><?php echo number_format($dbmax,1);?></option>
												<?php
											}?>
											</select>
										</div>
									</div>
							  </td>
							</tr>
							<tr>
							  <th scope="row">Desempeño Bajo</th>
								<td>
									<div class="form-group">
										<label for="ie" class="col-sm-1 control-label">Mínimo<em style='color:red;'>*</em></label>
										<div class="col-sm-3">
											<select class="form-control" id="dbamin" name="dbamin">
											<?php for($dbamin=10.0; $dbamin>=1.0; $dbamin-=0.1){
												?>
												<option value="<?php echo $dbamin;?>" ><?php echo number_format($dbamin,1);?></option>
												<?php
											}?>
											</select>
										</div>
										<label for="ie" class="col-sm-1 control-label">Máximo<em style='color:red;'>*</em></label>
											<div class="col-sm-3">
												<select class="form-control" id="dbamax" name="dbamax">
											<?php for($dbamax=10.0; $dbamax>=1.0; $dbamax-=0.1){
												?>
												<option value="<?php echo $dbamax;?>" ><?php echo number_format($dbamax,1);?></option>
												<?php
											}?>
											</select>
										</div>
									</div>
							  </td>
							</tr>
							<tr>
								<td colspan="2">
									<div class="form-group">
									  <div class="col-sm-offset-5 col-sm-12">
										<button type="submit" class="btn btn-success" data-toggle="modal" data-target="#">Guardar</button>
									  </div>
									</div>
								</td>
							</tr>
							
						  </tbody>
						</table>
						
						
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
			fields: {
				dsmin: {
					validators: {
						notEmpty: {
							message: 'Debe seleccionar un valor'
						}
					}
				},
				dsmax: {
					validators: {
						notEmpty: {
							message: 'Debe seleccionar un valor'
						}
					}
				},
				damin: {
					validators: {
						notEmpty: {
							message: 'Debe seleccionar un valor'
						}
					}
				},
				damax: {
					validators: {
						notEmpty: {
							message: 'Debe seleccionar un valor'
						}
					}
				},
				dbmin: {
					validators: {
						notEmpty: {
							message: 'Debe seleccionar un valor'
						}
					}
				},
				dbmax: {
					validators: {
						notEmpty: {
							message: 'Debe seleccionar un valor'
						}
					}
				},
				dbamin: {
					validators: {
						notEmpty: {
							message: 'Debe seleccionar un valor'
						}
					}
				},
				dbamax: {
					validators: {
						notEmpty: {
							message: 'Debe seleccionar un valor'
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
			
			