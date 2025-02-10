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
						<li class="breadcrumb-item"><a href="#">Docentes</a></li>
						<li class="breadcrumb-item"><a href="#">Información Docente</a></li>
						<li class="breadcrumb-item active" aria-current="page">Nuevo registro</li>
					  </ol>
					</nav>
				<div class="panel panel-danger">
				  <div class="panel-heading">Formulario  - Nuevo Docente</div>
				  <div class="panel-body">
					<form role="form" class="form-horizontal" id='formdocente' name='formdocente' method='post' action='nvdocente_response.php'>
				
						<div class="form-group">
							<label for="iddocente" class="col-sm-2 control-label">Identificación</label>
							<div class="col-sm-4">
							  <input type="text" class="form-control" id="iddocente" name="iddocente" placeholder="Máximo 11 dígitos " maxlength="11">
							</div>
						</div>
						<div class="form-group">
							<label for="apellido1" class="col-sm-2 control-label">Primer Apellido</label>
							<div class="col-sm-4">
								<input type='text' class="form-control" name='apellido1' id='apellido1' size='20' maxlength='20'/>
							</div>
						</div>
						<div class="form-group">
							<label for="apellido2" class="col-sm-2 control-label">Segundo Apellido</label>
							<div class="col-sm-4">
								<input type='text' class="form-control" name='apellido2' id='apellido2' size='20' maxlength='20'/>
							</div>
						</div>
						<div class="form-group">
							<label for="nombre1" class="col-sm-2 control-label">Primer Nombre</label>
							<div class="col-sm-4">
								<input type='text' class="form-control" name='nombre1' id='nombre1' size='20' maxlength='20'/>
							</div>
						</div>
						<div class="form-group">
							<label for="nombre2" class="col-sm-2 control-label">Segundo Nombre</label>
							<div class="col-sm-4">
								<input type='text' class="form-control" name='nombre2' id='nombre2' size='20' maxlength='20'/>
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="col-sm-2 control-label">Email</label>
							<div class="col-sm-4">
								<input type='email' placeholder="minombre@dominio.com" class="form-control" name='email' id='email' size='50' maxlength='20'/>
							</div>
						</div>
						<div class="form-group">
							<label for="profesion" class="col-sm-2 control-label">Nivel Educativo</label>
							<div class="col-sm-4">
								<select class="form-control" id="profesion" name="profesion">
									<option value="Licenciado en Educación">Licenciado(a) en Educación</option>
									<option value="Licenciado en Educación con titulo de posgrado">Licenciado en Educación con titulo de posgrado</option>
									<option value="Profesional no licenciado">Profesional no licenciado</option>
									<option value="Tecnólogo en Educación">Tecnólogo en Educación</option>
									<option value="Normalista superior">Normalista superior</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="escalafon" class="col-sm-2 control-label">Escalafón</label>
							<div class="col-sm-4">
								<select class="form-control" id="escalafon" name="escalafon">
									<option value="">Sin escalafón</option>
									<option value="2A">Grado 2A sin especialización</option>
									<option value="2AE">Grado 2A con especialización</option>
									<option value="3A">Grado 3A con maestria o doctorado</option>
									<?php for($i=1; $i<=14; $i++ ){?>
										<option value="grado<?php echo $i;?>">Grado <?php echo $i;?></option>
									<?php } ?>
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
		$('#formdocente').bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
			// List of fields and their validation rules
			fields: {
				iddocente: {
					validators: {
						notEmpty: {
							message: 'Identificación es requerido'
						},
						stringLength: {
							min: 7,
							max: 11,
							message: 'Identificacion debe tener entre 7 y 11 dígitos'
						},
						numeric: {
                            message: 'Debe ingresar solo números',
                            // The default separators
                        }
					}
				},
				apellido1: {
					validators: {
						notEmpty: {
							message: 'Primer apellido es requerido'
						},
						stringLength: {
							min: 3,
							max: 20,
							message: 'Minimo 3 letras'
						}
					}
				},
				nombre1: {
					validators: {
						notEmpty: {
							message: 'Primer nombre es requerido'
						},
						stringLength: {
							min: 3,
							max: 20,
							message: 'Minimo 3 letras'
						}
					}
				},
				apellido2: {
					validators: {
						
						stringLength: {
							min: 3,
							max: 20,
							message: 'Minimo 3 letras'
						}
					}
				},
				nombre2: {
					validators: {
						
						stringLength: {
							min: 3,
							max: 20,
							message: 'Minimo 3 letras'
						}
					}
				},
				email: {
                    validators: {
                        emailAddress: {
                            message: 'Formato de email no valido'
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
			
			