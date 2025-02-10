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
					<li class="breadcrumb-item"><a href="#">Coordinadores de áreas</a></li>
					<li class="breadcrumb-item active" aria-current="page">Asignar</li>
				  </ol>
				</nav>
				<div class="modal fade" id="nuevaClaseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="exampleModalLabel">Asignar área</h4>
					  </div>
					  <div class="modal-body">
						<div class="panel panel-danger">
						  <div class="panel-heading">Formulario</div>
						  <div class="panel-body">
							<form role="form" class="form-horizontal" id='formNvClase' name='formNvClase' method='post' action='asignararea_response.php'>
								<input type="hidden" class="form-control" id="iddocente" name="iddocente">
								<div class="form-group">
									<label for="docente" class="col-sm-4 control-label">Docente</label>
									<div class="col-sm-7">
									  <input type="text" class="form-control" id="docente" name="docente" placeholder="Máximo 11 dígitos " readonly>
									</div>
								</div>
								<div class="form-group">
									<label for="idmateria" class="col-sm-4 control-label">Asignatura</label>
									<div class="col-sm-7">
										<select class="form-control" id="idmateria" name="idmateria">
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="idaula" class="col-sm-4 control-label">Salón</label>
									<div class="col-sm-7">
										<select class="form-control" id="idaula" name="idaula">
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="aniolect" class="col-sm-4 control-label">Año lectivo</label>
									<div class="col-sm-7">
										<select class="form-control" id="aniolect" name="aniolect">
										 <?php 
											$sqlaniolect = "SELECT * FROM appconfig WHERE item = 'aniolect'";
											$consulta = $conx->query($sqlaniolect);
											$data = $consulta->fetch_assoc();
											for($i=2030; $i>= ($data['valor']-10); $i--){
												if($data["valor"]==$i){
													echo "<option value='".$i."' selected>".$i."</option>";
												}else{
													echo "<option value='".$i."'>".$i."</option>";
												}
											}
											
										 ?>
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
							<th>Primer apellido</th>
							<th>Segundo Apellido</th>
							<th>Primer nombre</th>
							<th>Segundo nombre</th>
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
	var obtener_data_nuevo = function(tbody, table){
		$(tbody).on("click","button.nuevo", function(){
			var data = table.row($(this).parents('tr')).data();
			var docente= $("#formNvClase #docente").val(data.apellido1+" "+data.apellido2+" "+data.nombre1+" "+data.nombre2);
			var iddocente= $("#formNvClase #iddocente").val(data.iddocente);
			$('#nuevaClaseModal .modal-body p').html("")
			$('#nuevaClaseModal').modal("show");
		});
	}
	var listar_materias = function(){
		var asignaturas = $("#idmateria");
		asignaturas.find('option').remove();
		$.post('lista_materias.php', function(response) {
			$.each(response.data.materias, function(key, value){ // indice, valor
				asignaturas.append('<option value="' + value["idmateria"] + '">' + value["nombre_materia"]+ '</option>');
			})
		}, 'json');
		asignaturas.prop('disabled', false);
	}
	var listar_aulas = function(){
		var aulas = $("#idaula");
		aulas.find('option').remove();
		$.post('lista_aulas.php', function(response) {
			$.each(response.data.aulas, function(key, value){ // indice, valor
				switch(value["jornada"]){
					case "M": var jornada="Mañana"; break;
					case "T": var jornada="Tarde"; break;
				}
				aulas.append('<option value="' + value["idaula"] + '">' + value["descripcion"]+ " Grupo "+ value["grupo"]+" "+jornada+'</option>');
			})
		}, 'json');
		aulas.prop('disabled', false);
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
			"sSearch":         "Buscar docente:",
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
				"url": "../docentes/lista_docentes.php"
			},
			"columns":[
				{"data":"iddocente"},
				{"data":"apellido1"},
				{"data":"apellido2"},
				{"data":"nombre1"},
				{"data":"nombre2"},
				{"defaultContent":"<button class='nuevo btn btn-primary' placeholder='Asignar área'><i class='glyphicon glyphicon-book'></i> Asignar área</button>"}
			],
			"language": language_espanish
		});
		obtener_data_nuevo("#datatable_docentes tbody",table);
		
		
	}
	
	$(document).on("ready", function(){
		
		
	});
	
	
	$(document).ready(function() {
		listar();
		listar_materias();
		listar_aulas();
		$( "#formNvClase" ).submit(function( event ) {
		  event.preventDefault();
		  var $form = $(event.target);
		  $.post($form.attr('action'), $form.serialize(), function(result) {
				$('#nuevaClaseModal .modal-body p').html(result).fadeOut(300).fadeIn(300);
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