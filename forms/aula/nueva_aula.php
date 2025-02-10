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
	<!-- CSS de Validator.io -->
    <link href="../../plugins/validator.io/css/bootstrapValidator.min.css" rel="stylesheet" media="screen">
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
						<li class="breadcrumb-item"><a href="#">Salones</a></li>
						<li class="breadcrumb-item active" aria-current="page">Nuevo registro</li>
					  </ol>
					</nav>
				<div class="panel panel-danger">
				  <div class="panel-heading">Formulario  - Nuevo Salón</div>
				  <div class="panel-body">
					<form role="form" class="form-horizontal" id='formsalon' name='formsalon' method='post' action='nvaula_response.php'>
				
						<div class="form-group">
							<label for="grado" class="col-sm-2 control-label">Grado</label>
							<div class="col-sm-4">
								<select class="form-control" id="grado" name="grado">
									<option value='1'>0</option>
									<option value='1'>1</option>
									<option value='2'>2</option>
									<option value='3'>3</option>
									<option value='4'>4</option>
									<option value='5'>5</option>
									<option value='6'>6</option>
									<option value='7'>7</option>
									<option value='8'>8</option>
									<option value='9'>9</option>
									<option value='10'>10</option>
									<option value='11'>11</option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label for="descripcion" class="col-sm-2 control-label">Grado, en letras</label>
							<div class="col-sm-4">
								<input type='text' class="form-control" name='descripcion' id='descripcion' size='20' maxlength='20'/>
							</div>
						</div>
						
						<div class="form-group">
							<label for="grupo" class="col-sm-2 control-label">Grupo</label>
							<div class="col-sm-4">
								<select class="form-control" id="grupo" name="grupo">
									<option value='1'>1</option>
									<option value='2'>2</option>
									<option value='3'>3</option>
									<option value='4'>4</option>
									<option value='5'>5</option>
									<option value='6'>6</option>
									<option value='7'>7</option>
									<option value='8'>8</option>
									<option value='9'>9</option>
									<option value='10'>10</option>
									<option value='11'>11</option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
						  <div class="col-sm-offset-2 col-sm-10">
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
    <script src="../../js/jquery.js"></script>
 
    <!-- Todos los plugins JavaScript de Bootstrap (también puedes
         incluir archivos JavaScript individuales de los únicos
         plugins que utilices) -->
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../plugins/validator.io/js/bootstrapValidator.min.js"></script>
    <script src="../../plugins/validator.io/js/language/es_ES.js"></script>
	<script> 
	$(document).ready(function() {
		$('#formsalon').bootstrapValidator({
            message: 'Valor no valido',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
			// List of fields and their validation rules
			fields: {
				grado: {
					validators: {
						notEmpty: {
							message: 'Grado es requerido'
						}
					}
				},
				descripcion: {
					validators: {
						notEmpty: {
							message: 'Grado en lestras, es requerido'
						},
						stringLength: {
							min: 3,
							max: 20,
							message: 'Minimo 3 letras'
						}
					}
				},
				grupo: {
					validators: {
						notEmpty: {
							message: 'grupo es requerido'
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