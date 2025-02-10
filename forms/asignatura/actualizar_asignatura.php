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
					<li class="breadcrumb-item"><a href="#">Asignaturas</a></li>
					<li class="breadcrumb-item"><a href="#">Asignatura</a></li>
					<li class="breadcrumb-item active" aria-current="page">Actualizar</li>
				  </ol>
				</nav>
				<!-- Modal -->			
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
							<form role="form" class="form-horizontal" id='formasignatura' name='formasignatura' method='post' action='upasignatura_sucess.php'>
								<div class="form-group">
									<label for="idmateria" class="col-sm-4 control-label">Código</label>
									<div class="col-sm-6">
									  <input type="text" class="form-control" id="idmateria" name="idmateria" size='20' maxlength='20' disabled>
									  <input type="hidden" id="idmateria_hidden" name="idmateria_hidden">
									</div>
								</div>
								<div class="form-group">
									<label for="nombre_materia" class="col-sm-4 control-label">Asignatura</label>
									<div class="col-sm-6">
									  <input type="text" class="form-control" id="nombre_materia" name="nombre_materia" size='50' maxlength='100' placeholder="Máximo 100 caracteres">
									</div>
								</div>
								<div class="form-group">
								  <div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-success" data-toggle="modal" data-target="#">Guardar</button>
								  </div>
								  
								</div>
								<p class="alert alert-info" id="info"></p>
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
				<table id="datatable_asignaturas" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Código</th>
							<th>Asignatura</th>
							<th width="100px"></th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th>Código</th>
							<th>Asignatura</th>
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
			var idmateria= $("#editarModal #idmateria").val(data.idmateria);
			var idmateria_hidden = $("#editarModal #idmateria_hidden").val(data.idmateria);
			var nombre_materia= $("#editarModal #nombre_materia").val(data.nombre_materia);
			$('#editarModal').modal("show");
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
		var table = $("#datatable_asignaturas").DataTable({
			"destroy":true,
			"order":true,
			"ajax":{
				"method": "POST",
				"url": "lista_asignaturas.php"
			},
			"columns":[
				{"data":"idmateria"},
				{"data":"nombre_materia"},
				{"defaultContent":"<button class='editar btn btn-primary' placeholder='Editar'><i class='glyphicon glyphicon-edit'></i> Editar</button>"}
			],
			"language": language_espanish
		});
		obtener_data_editar("#datatable_asignaturas tbody",table);		
		
	}
	
	$(document).ready(function() {
		listar();
	});
	
	
	$(document).ready(function() {
		$('#editarModal #nombre_materia').change(function (){
			 $("#editarModal #info").text("");
		});
		
		$('#formasignatura').bootstrapValidator({
            message: 'Este valor es no valido',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
			// List of fields and their validation rules
			fields: {
				idmateria: {
					validators: {
						notEmpty: {
							message: 'Código es requerido'
						},
						stringLength: {
							min: 7,
							max: 11,
							message: 'Código debe tener entre 1 y 3 dígitos'
						},
						numeric: {
                            message: 'Debe ingresar solo números',
                            // The default separators
                        }
					}
				},
				nombre_materia: {
					validators: {
						notEmpty: {
							message: 'Asignatura es requerido'
						},
						stringLength: {
							min: 3,
							max: 20,
							message: 'Minimo 5 letras'
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