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
    <link href="../../plugins/bootstrap-datepicker-master/dist/css/bootstrap-datepicker.min.css" rel="stylesheet" media="screen">
	<!-- CSS de datatables -->
    <link href="../../plugins/datatables/css/jquery.dataTables.min.css" rel="stylesheet" media="screen">
    <link href="../../plugins/datatables/css/dataTables.bootstrap4.min.css" rel="stylesheet" media="screen">
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
			
			<div class="container-fluid">
				
				<br/><br/><br/>
				<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">Estudiantes</a></li>
					<li class="breadcrumb-item"><a href="#">Información estudiante</a></li>
					<li class="breadcrumb-item active" aria-current="page">Actualizar/Eliminar</li>
				  </ol>
				</nav>
				<!-- Modal -->
				<div id="eliminarModal" class="modal fade" role="dialog" aria-labelledby="exampleModalLabel">
				  <div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Eliminar</h4>
					  </div>
					  <form role="form" class="form-horizontal" id='formdocenteEliminar' name='formdocenteEliminar' method='post' action='deletedocensucess.php'>
					  <div class="modal-body">
						
							<input type="hidden" id="str_del" name="str_del">
							<div class="col-md-6 col-md-offset-3">
							<span class="text text-info">Realmente desea eliminar registro ?</span>
							</div><br/>
							<p class="alert alert-info"></p>
					  </div>
					  <div class="modal-footer">
							<button type="submit" class="btn btn-danger" data-toggle="modal" data-target="#">Eliminar</button>					  
							<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					  </div>
					  </form>

					</div>

				  </div>
				</div>
							
				<div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="exampleModalLabel">Editar</h4>
					  </div>
					  <div class="modal-body">
						<div class="panel panel-danger">
						  <div class="panel-heading">Formulario  - Editar datos</div>
						  <div class="panel-body">
							<form role="form" class="form-horizontal" id='formestudiante' name='formestudiante' method='post' action='upestudiante_sucess.php'>
								<div class="form-group">
									<label for="idestudiante" class="col-sm-4 control-label">Identificación</label>
									<div class="col-sm-6">
									  <input type="text" class="form-control" id="idestudiante" name="idestudiante" placeholder="Máximo 11 dígitos " maxlength="11">
									  <input type="hidden" id="older_idestudiante" name="older_idestudiante">
									</div>
								</div>
								<div class="form-group">
									<label for="apellido1" class="col-sm-4 control-label">Primer Apellido</label>
									<div class="col-sm-6">
										<input type='text' class="form-control" name='apellido1' id='apellido1' size='20' maxlength='20'/>
										<input type="hidden" id="older_apellido1" name="older_apellido1">
									</div>
								</div>
								<div class="form-group">
									<label for="apellido2" class="col-sm-4 control-label">Segundo Apellido</label>
									<div class="col-sm-6">
										<input type='text' class="form-control" name='apellido2' id='apellido2' size='20' maxlength='20'/>
										<input type="hidden" id="older_apellido2" name="older_apellido2">
									</div>
								</div>
								<div class="form-group">
									<label for="nombre1" class="col-sm-4 control-label">Primer Nombre</label>
									<div class="col-sm-6">
										<input type='text' class="form-control" name='nombre1' id='nombre1' size='20' maxlength='20'/>
										<input type="hidden" id="older_nombre1" name="older_nombre1">
									</div>
								</div>
								<div class="form-group">
									<label for="nombre2" class="col-sm-4 control-label">Segundo Nombre</label>
									<div class="col-sm-6">
										<input type='text' class="form-control" name='nombre2' id='nombre2' size='20' maxlength='20'/>
										<input type="hidden" id="older_nombre2" name="older_nombre2">
									</div>
								</div>
								<div class="form-group">
									<label for="nombre2" class="col-sm-4 control-label">Fecha de nacimiento</label>
									<div class="col-sm-6">
										<div class='input-group date' id='datepicker'>
											<input type='text' class="form-control" id="fechanac" name="fechanac" placeholder="MM/DD/AAAA"/>
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="telefono" class="col-sm-4 control-label">Teléfono</label>
									<div class="col-sm-6">
										<input type='text' class="form-control" name='telefono' id='telefono' size='20' maxlength='20'/>
									</div>
								</div>
								<div class="form-group">
									<label for="direccion" class="col-sm-4 control-label">Dirección</label>
									<div class="col-sm-6">
										<input type='text' class="form-control" name='direccion' id='direccion' size='20' maxlength='20'/>
									</div>
								</div>
								<div class="form-group">
									<label for="sexo" class="col-sm-4 control-label">Genero</label>
									<div class="col-sm-6">
										<select class="form-control" id="sexo" name="sexo">
											<option value='M'>M</option>
											<option value='F' selected>F</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="habilitado" class="col-sm-4 control-label">Habilitado en el sistema</label>
									<div class="col-sm-6">
										<select class="form-control" id="habilitado" name="habilitado">
											<option value='S'>S</option>
											<option value='N'>N</option>
										</select>
									</div>
								</div>
								
								<div class="form-group">
								  <div class="col-sm-offset-4 col-sm-10">
									<button type="submit" class="btn btn-success" data-toggle="modal" data-target="#">Guardar</button>
								  </div>
								  
								</div>
								<p class="alert alert-info"></p>
					</form>
				  </div>
				</div>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					  </div>
					</div>
				  </div>
				</div>
				<div class="form-group">
					<div class="col-sm-3">
						<input type='text' class="form-control" name='texto_buscar' id='texto_buscar' size='100' maxlength='100' placeholder="Ingrese datos del estudiante"/>
					
					</div>
					<div class="col-sm-3">
						<button  type="button"  class="btn btn-primary" id="btn_buscar">Buscar  <span class="glyphicon glyphicon-search"></span></button>
					</div>
				</div>
				<br/><br/><br/>
				<table id="datatable_estudiantes" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Identificación</th>
							<th>Primer apellido</th>
							<th>Segundo Apellido</th>
							<th>Primer nombre</th>
							<th>Segundo nombre</th>
							<th>Fecha de nacimiento</th>
							<th>Genero</th>
							<th>Teléfono</th>
							<th>Dirección</th>
							<th>Habilitado en el sistema</th>
							<th width="100px"></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>Identificación</th>
							<th>Primer apellido</th>
							<th>Segundo Apellido</th>
							<th>Primer nombre</th>
							<th>Segundo nombre</th>
							<th>Fecha de nacimiento</th>
							<th>Genero</th>
							<th>Teléfono</th>
							<th>Dirección</th>
							<th>Habilitado en el sistema</th>
							<th></th>
						</tr>
					</tfoot>
				</table>
			
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
	
    <script src="../../plugins/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="../../plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script> 
	var obtener_data_editar = function(tbody, table){
		$(tbody).on("click","button.editar", function(){
			
			var data = table.row($(this).parents('tr')).data();
			$('#editarModal .modal-body p').html("")
			var idestudiante= $("#editarModal #idestudiante").val(data.idestudiante);
			var older_idestudiante= $("#editarModal #older_idestudiante").val(data.idestudiante);
			var older_apellido1= $("#editarModal #older_apellido1").val(data.apellido1);
			var older_apellido2= $("#editarModal #older_apellido2").val(data.apellido2);
			var older_nombre1= $("#editarModal #older_nombre1").val(data.nombre1);
			var older_nombre2= $("#editarModal #older_nombre2").val(data.nombre2);
			var apellido1= $("#editarModal #apellido1").val(data.apellido1);
			var apellido2= $("#editarModal #apellido2").val(data.apellido2);
			var nombre1= $("#editarModal #nombre1").val(data.nombre1);
			var nombre2= $("#editarModal #nombre2").val(data.nombre2);
			var direccion= $("#editarModal #direccion").val(data.direccion);
			var telefono= $("#editarModal #telefono").val(data.telefono);
			var fechanac= $("#editarModal #fechanac").val(data.fechanac);
			$('#editarModal #sexo option[value="'+data.sexo+'"]').attr("selected", "selected");
			$('#editarModal #habilitado option[value="'+data.habilitado+'"]').attr("selected", "selected");
			$('#editarModal').modal("show");
		});
	}
	var obtener_id_eliminar = function(tbody, table){
		$(tbody).on("click","button.eliminar", function(){
			var data = table.row($(this).parents('tr')).data();
			$('#eliminarModal .modal-body p').html("")
			var iddocente= $("#eliminarModal #str_del").val(data.idestudiante);
			$('#eliminarModal').modal("show");
		});
	}
	var listar = function(txt) {
		var language_espanish = {
			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
				"sFirst":    "Primero",
				"sLast":     "Último",
				"sNext":     "Siguiente",
				"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
		}
		var table = $("#datatable_estudiantes").DataTable({
			"destroy":true,
			"order":true,
			"ajax":{
				"method": "POST",
				"url": "lista_estudiantes_filtro.php",
				"data":  function ( d ) {
					d.source = txt;
				}
			},
			"columns":[
				{"data":"idestudiante"},
				{"data":"apellido1"},
				{"data":"apellido2"},
				{"data":"nombre1"},
				{"data":"nombre2"},
				{"data":"fechanac"},
				{"data":"sexo"},
				{"data":"telefono"},
				{"data":"direccion"},
				{"data":"habilitado"},
				{"defaultContent":"<button class='editar btn btn-primary' placeholder='Editar'><i class='glyphicon glyphicon-edit'></i></button> <button class='eliminar btn btn-danger' data-toogle='mpdal' data-target='#modalEliminar'><i class='glyphicon glyphicon-trash'></i></button>"}
			],
			"language": language_espanish
		});
		obtener_data_editar("#datatable_estudiantes tbody",table);
		obtener_id_eliminar("#datatable_estudiantes tbody",table);
		
		
	}
	
	$(document).ready(function() {
		listar("Maria");
		$("#btn_buscar").click(function(){
			listar($("#texto_buscar").val());
		});
	});
	
	
	$(document).ready(function() {
		$('#formestudiante').bootstrapValidator({
            message: 'Este valor es no valido',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
			// List of fields and their validation rules
			fields: {
				idestudiante: {
					validators: {
						notEmpty: {
							message: 'Identificación es requerido'
						},
						stringLength: {
							min: 3,
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
				$('#editarModal .modal-body p').html(result);
				listar($("#texto_buscar").val());
            });
        });
		$( "#formdocenteEliminar" ).submit(function( event ) {
		  event.preventDefault();
		  var $form = $(event.target);
		  $.post($form.attr('action'), $form.serialize(), function(result) {
				$('#eliminarModal .modal-body p').html(result);
				listar($("#texto_buscar").val());
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