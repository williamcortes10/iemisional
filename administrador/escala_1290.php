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
$lema= $records['valor'];

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
    <link href="../../css/bootstrap.min.css" rel="stylesheet" media="screen">
	<!-- CSS de Validator.io -->
    <link href="../../plugins/validator.io/css/bootstrapValidator.min.css" rel="stylesheet" media="screen">
	<!-- Custom styles for this template -->
    <link href="../../css/index.css" rel="stylesheet">
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
					<li class="active"><a href="index.php">Inicio</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Configuración<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li role="presentation" class="dropdown-header">Datos de la institución</li>	
							<li><a href="datos_institucion.php">Ver/Modificar</a></li>
							<li role="presentation" class="dropdown-header">Escala de calificación 1290</li>	
							<li><a href="../forms/docentes/nuevo_docente.php">Nuevo +</a></li>
							<li><a href="../forms/docentes/nuevo_docente.php">Ver/Modificar</a></li>
							<li role="presentation" class="dropdown-header">Periodo académico activo</li>	
							<li><a href="../forms/docentes/nuevo_docente.php">Ver/Modificar</a></li>
							
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Docentes<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li role="presentation" class="dropdown-header">Información Docente</li>
							<li><a href="../forms/docentes/nuevo_docente.php">Nuevo registro</a></li>
							<li><a href='../forms/docentes/actualizar_docente.php'>Actualizar/Eliminar</a></li>
							<li><a href='../forms/docentes/listado_docentes.php'>Reporte Docentes</a></li>
							<li role="presentation" class="divider"></li>
							<li role="presentation" class="dropdown-header">Intensidad Horaria</li>
							<li><a href='../forms/clase/buscar_docente.php'>Asignar</a></li>
							<li><a href='../forms/clase/buscarupdel_clase.php'>Actualizar/Eliminar</a></li>
							<li><a href='../forms/clase/listado_cargaacademica.php'>Reporte Intensidad Horaria</a></li>
							<li role="presentation" class="divider"></li>
							<li role="presentation" class="dropdown-header">Dinamizadores de grupo</li>
							<li><a href='../forms/coordinadores/buscar_docente.php'>Asignar</a></li>
							<li><a href='../forms/coordinadores/buscarupdel_cg.php'>Actualizar/Eliminar</a></li>
							<li><a href='../forms/coordinadores/listado_coordinadores.php'>Reporte Dinamizadores</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Asignaturas<b class="caret"></b>
						</a>
						<ul class='dropdown-menu'>
							<li role="presentation" class="dropdown-header">Asignaturas</li>
							<li><a href='../forms/asignatura/nueva_asignatura.php'>Nuev registro</a></li>
							<li><a href='../forms/asignatura/actualizar_asignatura.php'>Actualizar</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Estudiante<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li role="presentation" class="dropdown-header">Información Estudiante</li>
							<li><a href='../forms/estudiantes/nuevo_estudiante.php'>Nuevo registro</a></li>
							<li><a href='../forms/estudiantes/actualizar_estudiante.php'>Actualizar/Eliminar</a></li>
							<li><a href='#'>Carga masiva de estudiantes</a></li>
							<li role="presentation" class="divider"></li>
							<li role="presentation" class='dropdown-header'>Matrícula Regular/Nivelación</li>
							<li><a href='../forms/matricula/buscar_estudiante.php'>Nueva individual</a></li>
							<li><a href='../forms/matricula/buscar_grupo_estudiante.php'>Nueva grupo</a></li>
							<li><a href='../forms/matricula/buscarupdel_matricula.php'>Actualizar/Eliminar</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Salones<b class="caret"></b>
						<ul class="dropdown-menu">
							<li><a href='../forms/aula/nueva_aula.php'>Nuevo registro</a></li>
							<li><a href='../forms/aula/actualizar_aula.php'>Actualizar/Eliminar</a></li>
							
						</ul>
					</li>
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
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Calificaciones<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li role="presentation" class="dropdown-header">Regulares</li>
						  <li><a href="../forms/notas/buscar_estudiante.php">Ingresar Calificación</a></li>
						  <!--<li><a href="../forms/notas/eliminarcalificaciones.php">Eliminar Calificación</a></li>
						  <li role="presentation" class="divider"></li>
						  <li role="presentation" class="dropdown-header">Nivelación</li>
						  <li><a href="../forms/notas/ingresarcalificacionesnv.php">Ingresar Calificación</a></li>-->
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Reportes<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li role="presentation" class='dropdown-header'>Informe académico</li>
						  <li><a href='../forms/boletines/boletingeneral.php'>Grupo</a></li>
						  <li><a href='../forms/boletines/buscar_estudiante.php'>Individual</a></li>
						  <li role="presentation" class="divider"></li>
						  <li role="presentation" class='dropdown-header'>Certificados</li>
						  <li><a href='../forms/boletines/buscar_estudiantecert.php'>Buscar Estudiante</a></li>
						  <li role="presentation" class="divider"></li>
						  <li role="presentation" class='dropdown-header'>Estadisticas</li>
						  <li><a href='../forms/estadisticas/ccrendaca.php'>Rendimiento académico x desempeño</a></li>
						  <li><a href='../forms/estadisticas/ccrendacacompetencias.php'>Rendimiento académico x competencias</a></li>
						  <li><a href='../forms/estadisticas/aprobados_reprobados.php'>Estudiantes Aprobados y Reprobados</a></li>
						  <li><a href='../forms/estadisticas/aprobados_reprobados_recuperan.php'>Aprobados-Reprobados-Recuperan</a></li>
						  <li role="presentation" class='dropdown-header'>Calificaciones</li>
						  <li><a href="../forms/notas/listarcalificaciones.php">Grupo</a></li>
						  <li><a href="../forms/notas/sintesisxcurso.php">Sintesis</a></li>
						  <li role="presentation" class="divider"></li>
						  <li role="presentation" class='dropdown-header'>Otros</li><li role="presentation" class="divider"></li>
						  <li><a href='../forms/aula/listado_aula.php'>Reporte salones</a></li>
						  <li><a href='../forms/matricula/listado_matricular.php'>Reporte matrícula regular</a></li>
						  <li><a href='../forms/matricula/listado_matriculan.php'>Reporte matrícula nivelación</a></li>
						  <li><a href='../forms/estudiantes/listado_estudiantes.php'>Reporte estudiantes</a></li>
						  <li><a href='../forms/asignatura/listado_asignaturas.php'>Reporte de asignaturas</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  <span class="glyphicon glyphicon-user"></span>
						  <?php echo $user; ?><b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li><a href="logout.php">Cerrar sesión</a></li>
						</ul>
					</li>
				  </ul>
				</div><!--/.nav-collapse -->
			  </div>
			</nav>
			<div class="container"><br/><br/>
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
				<h3>Configuración  | Escala de calificación 1290 | Nueva escala de calificación</h3>
				<div class="panel panel-danger">
				  <div class="panel-heading">Formulario  - Rango de notas para desempeños</div>
				  <div class="panel-body">
					<form role="form" class="form-horizontal" id='formescala' name='formescala' method='post' action='datosinstitucion_response.php'>
				
						<div class="row"> 
						<div class="col-sm-5 col-sm-offset-3">
							<table class="table table-bordered table-responsive">
							<thead>
								<tr class="bnt btn-primary text-center"><td class='col-sm-2'>DESEMPEÑO</td><td class='col-sm-1'>MIN</td><td class='col-sm-1'>MAX</td></tr>
							</thead>
							<tbody>
							  <tr>
							  <tr>
								<td class="text-center"><strong>DESEMPEÑO BAJO (Db)</strong></td>
								<td class="text-center"><input id="dbamin" name="dbamin" type="text" class="form-control" placeholder="MIN" size="3" maxlength="3"></td>
								<td class="text-center"><input id="dbamax" name="dbamax"  type="text" class="form-control" placeholder="MAX" size="3" maxlength="3"></td>
							  </tr>
							  <tr>
								<td class="text-center"><strong>DESEMPEÑO BÁSICO (DB)</strong></td>
								<td class="text-center"><input id="dbmin" name="dbmin" type="text" class="form-control" placeholder="MIN" size="3" maxlength="3"></td>
								<td class="text-center"><input id="dbmax" name="dbmax"  type="text" class="form-control" placeholder="MAX" size="3" maxlength="3"></td>
							  </tr>
							  <tr>
								<td class="text-center"><strong>DESEMPEÑO ALTO (DA)</strong></td>
								<td class="text-center"><input id="damin" name="damin" type="text" class="form-control" placeholder="MIN" size="3" maxlength="3"></td>
								<td class="text-center"><input id="damax" name="damax"  type="text" class="form-control" placeholder="MAX" size="3" maxlength="3"></td>
							  </tr>
							  <tr>
								<td class="text-center"><strong>DESEMPEÑO SUPERIOR (DS)</strong></td>
								<td class="text-center"><input id="dsmin" name="dsmin" type="text" class="form-control" placeholder="MIN" size="3" maxlength="3"></td>
								<td class="text-center"><input id="dsmax" name="dsmax"  type="text" class="form-control" placeholder="MAX" size="3" maxlength="3"></td>
							  </tr>
								<td class="text-center"><strong>AÑO LECTIVO</strong></td>
								<td class="text-center" colspan="2">
									<select id="aniolectivo" name="aniolectivo" class="form-control">
										<option>
										<?php 
											for($i=1900; $i<=2100; $i++ ){
												if($i==date("Y")){
													?>
													<option selected><?php echo $i;?></option>
													<?php
												}else{
													?>
													<option><?php echo $i;?></option>
													<?php
												}
											}
										?>
										</option>
									</select>
									
								</td>
							  </tr>
							  <tr>
								<td class="text-center" colspan="3">
									<button type="submit" class="btn btn-success col-sm-12" data-toggle="modal" data-target="#">Guardar</button>
								</td>
							  </tr>
							  <tr>
							</tbody>
							</table>
							
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
		
		$("#dbamax" ).change(function() {
			$("#dbamax").attr("value",parseFloat($("#dbamax").val()).toFixed(1));
			dbamax=parseFloat($('#dbamax').val());
			dbamin=parseFloat($('#dbamin').val());
			if(dbamax>dbamin){
				$("#dbmin").attr("value",parseFloat(dbamax+0.1).toFixed(1));
			}else{
				alert("El valor máximo del desempeño bajo no puede menor que el valor mínimo");
				$('#dbamax').val("").focus();
			}
			
		});
		$("#dbamin" ).change(function() {
			$("#dbamin").attr("value",parseFloat($("#dbamin").val()).toFixed(1));		
		});
		$("#dbmax" ).change(function() {
			dbmax=parseFloat($('#dbmax').val());
			dbmin=parseFloat($('#dbmin').val());
			if(dbmax>dbmin){
				$("#damin").attr("value",parseFloat(dbmax+0.1).toFixed(1));
			}else{
				alert("El valor máximo del desempeño básico no puede menor que el valor mínimo");
				$('#dbmax').val("").focus();
			}
			
		});
		$("#damax" ).change(function() {
			damax=parseFloat($('#damax').val());
			damin=parseFloat($('#damin').val());
			if(damax>damin){
				$("#dsmin").attr("value",parseFloat(damax+0.1).toFixed(1));
			}else{
				alert("El valor máximo del desempeño alto no puede menor que el valor mínimo");
				$('#damax').val("").focus();
			}
			
		});
		$("#dsmax" ).change(function() {
			dsmax=parseFloat($('#dsmax').val());
			dsmin=parseFloat($('#dsmin').val());
			if(dsmax>dsmin){
			}else{
				alert("El valor máximo del desempeño superior no puede menor que el valor mínimo");
				$('#dsmax').val("").focus();
			}
			
		});
		$('#formescala').bootstrapValidator({
            message: 'Valor no valido',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
			// List of fields and their validation rules
			fields: {
				dsmax: {
					validators: {
						notEmpty: {
							message: 'DS: MAX es requerido'
						},
						stringLength: {
							min: 1,
							max: 3,
							message: 'Minimo 1 digito, ,máximo 3'
						},
						numeric: {
                            message: 'Debe ingresar solo números',
                            // The default separators
                        }
					}
				},
				dsmin: {
					validators: {
						notEmpty: {
							message: 'DS: MIN es requerido'
						},
						stringLength: {
							min: 1,
							max: 3,
							message: 'DS: Minimo 1 digito, ,máximo 3'
						},
						numeric: {
                            message: 'DS: Debe ingresar solo números',
                            // The default separators
                        }
					}
				},
				damax: {
					validators: {
						notEmpty: {
							message: 'DA: MAX es requerido'
						},
						stringLength: {
							min: 1,
							max: 3,
							message: 'DA: Minimo 1 digito, ,máximo 3'
						},
						numeric: {
                            message: 'DA: Debe ingresar solo números',
                            // The default separators
                        }
					}
				},
				damin: {
					validators: {
						notEmpty: {
							message: 'DA: MIN es requerido'
						},
						stringLength: {
							min: 1,
							max: 3,
							message: 'DA: Minimo 1 digito, ,máximo 3'
						},
						numeric: {
                            message: 'DA: Debe ingresar solo números',
                            // The default separators
                        }
					}
				},
				dbmax: {
					validators: {
						notEmpty: {
							message: 'DB: MAX es requerido'
						},
						stringLength: {
							min: 1,
							max: 3,
							message: 'DB: Minimo 1 digito, ,máximo 3'
						},
						numeric: {
                            message: 'DB: Debe ingresar solo números',
                            // The default separators
                        }
					}
				},
				dbmin: {
					validators: {
						notEmpty: {
							message: 'DB: MIN es requerido'
						},
						stringLength: {
							min: 1,
							max: 3,
							message: 'DB: Minimo 1 digito, ,máximo 3'
						},
						numeric: {
                            message: 'DB: Debe ingresar solo números',
                            // The default separators
                        }
					}
				},
				dbamax: {
					validators: {
						notEmpty: {
							message: 'Db: MAX es requerido'
						},
						stringLength: {
							min: 1,
							max: 3,
							message: 'Db: Minimo 1 digito, ,máximo 3'
						},
						numeric: {
                            message: 'Db: Debe ingresar solo números',
                            // The default separators
                        }
					}
				},
				dbamin: {
					validators: {
						notEmpty: {
							message: 'Db: MIN es requerido'
						},
						stringLength: {
							min: 1,
							max: 3,
							message: 'Db: Minimo 1 digito, ,máximo 3'
						},
						numeric: {
                            message: 'Db: Debe ingresar solo números',
                            // The default separators
                        }
					}
				},
				
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
			
			