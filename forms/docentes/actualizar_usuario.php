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
			
			<div class="container">
				
				<br/><br/><br/>
				<nav aria-label="breadcrumb">
				  <ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">Docentes</a></li>
					<li class="breadcrumb-item"><a href="#">Información Docente</a></li>
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
					  <form role="form" class="form-horizontal" id='formdocenteEliminar' name='formdocenteEliminar' method='post' action='deleteusuariosucess.php'>
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
						  <div class="panel-heading">Formulario  - Editar Usuario</div>
						  <div class="panel-body">
							<form role="form" class="form-horizontal" id='formdocente' name='formdocente' method='post' action='upusuario_sucess.php'>
								<div class="form-group">
									<label for="idusuario" class="col-sm-3 control-label">Usuario</label>
									<div class="col-sm-8">
										<select class="form-control" id="idusuario" name="idusuario">									
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="tipousuario" class="col-sm-3 control-label">Tipo de usuario</label>
									<div class="col-sm-4">
										<select class="form-control" id="tipousuario" name="tipousuario">
											<option value="D">Docente</option>
											<option value="A">Administrador</option>
											<option value="C">Coordinador(a)</option>
											<option value="S">Secretaria</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="pass" class="col-sm-3 control-label">Contraseña</label>
									<div class="col-sm-8">
										<input type='password' placeholder="Ingrese su contraseña" class="form-control" name='pass' id='pass' size='20' maxlength='20'/>
										<span class="help-block">Le recomendamos usar números y letras para mayor seguridad</span>
									</div>
								</div>
								<div class="form-group">
									<label for="habilitado" class="col-sm-3 control-label">Usuario Activo</label>
									<div class="col-sm-4">
										<select class="form-control" id="habilitado" name="habilitado">
											<option value="S">Si</option>
											<option value="N">No</option>
										</select>
									</div>
								</div>
								<div class="form-group">
								  <div class="col-sm-offset-2 col-sm-10">
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
				<table id="datatable_docentes" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Identificación</th>
							<th>Nombre</th>
							<th>Tipo Usuario</th>
							<th>Activo</th>
							<th width="100px"></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>Identificación</th>
							<th>Nombre</th>
							<th>Tipo Usuario</th>
							<th>Activo</th>
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
    <script src="../../plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script> 
	var obtener_data_editar = function(tbody, table){
		$(tbody).on("click","button.editar", function(){
			var data = table.row($(this).parents('tr')).data();
			$('#editarModal .modal-body p').html("")
			var idusuario= $("#editarModal #idusuario").val(data.iddocente);
			$("#editarModal #idusuario").append('<option value="' + data.iddocente + '">' + data.nombre +' ( CC '+data.iddocente+')'+'</option>');
			$('#editarModal #tipousuario option[value="'+data.tipousuario+'"]').attr("selected", "selected");
			$('#editarModal #habilitado option[value="'+data.habilitado+'"]').attr("selected", "selected");
			$('#editarModal').modal("show");
		});
	}
	var obtener_id_eliminar = function(tbody, table){
		$(tbody).on("click","button.eliminar", function(){
			var data = table.row($(this).parents('tr')).data();
			$('#eliminarModal .modal-body p').html("")
			var iddocente= $("#eliminarModal #str_del").val(data.iddocente);
			$('#eliminarModal').modal("show");
		});
	}
	var listar = function() {
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
		var table = $("#datatable_docentes").DataTable({
			"destroy":true,
			"order":true,
			"ajax":{
				"method": "POST",
				"url": "lista_usuarios.php"
			},
			"columns":[
				{"data":"iddocente"},
				{"data":"nombre"},
				{"data":"tipousuario"},
				{"data":"habilitado"},
				{"defaultContent":"<button class='editar btn btn-primary' placeholder='Editar'><i class='glyphicon glyphicon-edit'></i></button> <button class='eliminar btn btn-danger' data-toogle='mpdal' data-target='#modalEliminar'><i class='glyphicon glyphicon-trash'></i></button>"}
			],
			"language": language_espanish
		});
		obtener_data_editar("#datatable_docentes tbody",table);
		obtener_id_eliminar("#datatable_docentes tbody",table);
		
		
	}
	
	$(document).ready(function() {
		listar();
		$('.modal').on('hidden.bs.modal', function(e)
		{ 
			$(this).removeData();
		}) ;
	});
	
	
	$(document).ready(function() {
		$('#formdocente').bootstrapValidator({
            message: 'Este valor es no valido',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
			// List of fields and their validation rules
			fields: {
				pass: {
					validators: {
						stringLength: {
							min: 6,
							message: 'contaseña debe tener mínimo 6 carateres'
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
				listar();
            });
        });
		$( "#formdocenteEliminar" ).submit(function( event ) {
		  event.preventDefault();
		  var $form = $(event.target);
		  $.post($form.attr('action'), $form.serialize(), function(result) {
				$('#eliminarModal .modal-body p').html(result);
				listar();
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
			
			