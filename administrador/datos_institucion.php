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
$sql = "SELECT valor FROM appconfig WHERE item='nit'";
$consulta = $conx->query($sql);
$records = $conx->records_array($consulta);
$nit= $records['valor'];

$sql = "SELECT valor FROM appconfig WHERE item='nrector'";
$consulta = $conx->query($sql);
$records = $conx->records_array($consulta);
$nrector= $records['valor'];

$sql = "SELECT valor FROM appconfig WHERE item='lema'";
$consulta = $conx->query($sql);
$records = $conx->records_array($consulta);
$lema= ($records['valor']);

$sql = "SELECT valor FROM appconfig WHERE item='resol'";
$consulta = $conx->query($sql);
$records = $conx->records_array($consulta);
$resol= $records['valor'];

$sql = "SELECT valor FROM appconfig WHERE item='telefono'";
$consulta = $conx->query($sql);
$records = $conx->records_array($consulta);
$telefono= $records['valor'];

$sql = "SELECT valor FROM appconfig WHERE item='direccion'";
$consulta = $conx->query($sql);
$records = $conx->records_array($consulta);
$direccion= $records['valor'];

$sql = "SELECT valor FROM appconfig WHERE item='ciudad'";
$consulta = $conx->query($sql);
$records = $conx->records_array($consulta);
$ciudad= $records['valor'];

$sql = "SELECT valor FROM appconfig WHERE item='departamento'";
$consulta = $conx->query($sql);
$records = $conx->records_array($consulta);
$departamento= $records['valor'];

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
					<li class="breadcrumb-item"><a href="#">Datos de la institución</a></li>
					<li class="breadcrumb-item active" aria-current="page">Ver/Modificar</li>
				  </ol>
				</nav>
				<div class="panel panel-danger">
				  <div class="panel-heading">Formulario  - Datos de la institución</div>
				  <div class="panel-body">
					<form role="form" class="form-horizontal" id='forminstitucion' name='forminstitucion' method='post' action='datosinstitucion_response.php'>
				
						<div class="form-group">
							<label for="ie" class="col-sm-4 control-label">Nombre de la institución <em style='color:red;'>*</em></label>
							<div class="col-sm-6">
							  <input type="text" class="form-control" id="ie" name="ie" placeholder="Ingrese el nombre del colegio " maxlength="100" value="<?php echo $ie;?>">
							</div>
						</div>
						<div class="form-group">
							<label for="nit" class="col-sm-4 control-label">Nit <em style='color:red;'>*</em></label>
							<div class="col-sm-6">
							  <input type="text" class="form-control" id="nit" name="nit" placeholder="Ingrese el nit" maxlength="15" value="<?php echo $nit;?>">
							</div>
						</div>
						<div class="form-group">
							<label for="nrector" class="col-sm-4 control-label">Rector(a) <em style='color:red;'>*</em></label>
							<div class="col-sm-6">
							  <input type="text" class="form-control" id="nrector" name="nrector" placeholder="Ingrese el nombre del rector(a) vigente" maxlength="100" value="<?php echo $nrector;?>">
							</div>
						</div>
						<div class="form-group">
							<label for="resol" class="col-sm-4 control-label">Resolución <em style='color:red;'>*</em></label>
							<div class="col-sm-6">
							  <textarea class="form-control" rows="3" id="resol" name="resol" placeholder="Ingrese la resolución que habilita secretaria" maxlength="300"><?php echo ($resol);?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="lema" class="col-sm-4 control-label">Lema <em style='color:red;'>*</em></label>
							<div class="col-sm-6">
							  <textarea class="form-control" rows="3" id="lema" name="lema" placeholder="Lema que identifica a la institución" maxlength="300" ><?php echo ($lema);?></textarea>
							</div>
						</div>
						
						<div class="form-group">
							<label for="telefono" class="col-sm-4 control-label">Telefono</label>
							<div class="col-sm-6">
							  <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono fijo" maxlength="15" value="<?php echo $telefono;?>">
							</div>
						</div>
						<div class="form-group">
							<label for="direccion" class="col-sm-4 control-label">Dirección <em style='color:red;'>*</em></label>
							<div class="col-sm-6">
							  <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección donde esta ubicada la sede principal" maxlength="100" value="<?php echo utf8_encode($direccion);?>">
							</div>
						</div>
						<div class="form-group">
							<label for="ciudad" class="col-sm-4 control-label">Ciudad <em style='color:red;'>*</em></label>
							<div class="col-sm-6">
							  <input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="" maxlength="30" value="<?php echo ($ciudad);?>">
							</div>
						</div>
						<div class="form-group">
							<label for="departamento" class="col-sm-4 control-label">Departamento <em style='color:red;'>*</em></label>
							<div class="col-sm-6">
							  <input type="text" class="form-control" id="departamento" name="departamento" placeholder="" maxlength="30" value="<?php echo ($departamento);?>">
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
				ie: {
					validators: {
						notEmpty: {
							message: 'Nombre de la institución es requerido'
						}
					}
				},
				nit: {
					validators: {
						notEmpty: {
							message: 'Nit es requerido'
						}
					}
				},
				nrector: {
					validators: {
						notEmpty: {
							message: 'Nombre del rector (a) es requerido'
						}
					}
				},
				resol: {
					validators: {
						notEmpty: {
							message: 'Resolución es requerida'
						}
					}
				},
				lema: {
					validators: {
						notEmpty: {
							message: 'Lema es requerida'
						}
					}
				},
				direccion: {
					validators: {
						notEmpty: {
							message: 'Dirección es requerida'
						}
					}
				},
				ciudad: {
					validators: {
						notEmpty: {
							message: 'Ciudad es requerida'
						}
					}
				},
				departamento: {
					validators: {
						notEmpty: {
							message: 'Departamento es requerido'
						}
					}
				},
				telefono: {
					validators: {
						stringLength: {
							min: 7,
							max: 11,
							message: 'Minimo 7 digitos'
						},
						numeric: {
                            message: 'Debe ingresar solo números',
                            // The default separators
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