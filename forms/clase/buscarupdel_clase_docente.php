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
			
			<div class="container"><br/><br/>
			<!-- Modal -->
				<div id="eliminarModal" class="modal fade" role="dialog">
				  <div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Eliminar</h4>
					  </div>
					  <form role="form" class="form-horizontal" id='formClaseEliminar' name='formClaseEliminar' method='post' action='deleteclasesucess.php'>
					  <div class="modal-body">				
							<input type="hidden" id="d_iddocente" name="d_iddocente" value="<?php echo $_GET['iddocente']; ?>">
							<input type="hidden" id="d_aula" name="d_aula">
							<input type="hidden" id="d_materia" name="d_materia">
							<input type="hidden" id="d_aniolect" name="d_aniolect">
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
				<div class="modal fade" id="editarClaseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="exampleModalLabel">Editar</h4>
					  </div>
					  <div class="modal-body">
						<div class="panel panel-danger">
						  <div class="panel-heading">Formulario  - Editar Clase</div>
						  <div class="panel-body">
							<form role="form" class="form-horizontal" id='formEditarClase' name='formEditarClase' method='post' action='actualizarclase_sucess.php'>
										<input type="hidden" id="iddocente" name="iddocente" value="<?php echo $_GET['iddocente']; ?>">
										<input type="hidden" id="aula" name="aula">
										<input type="hidden" id="materia" name="materia">
										<div class="form-group">
											<label for="docente" class="col-sm-4 control-label">Docente</label>
											<div class="col-sm-7">
											  <input type="text" class="form-control" id="docente" name="docente" placeholder="" value="<?php echo $_GET['nombre']; ?>" readonly>
											</div>
										</div>
										<div class="form-group">
											<label for="asignatura" class="col-sm-4 control-label">Asignatura</label>
											<div class="col-sm-7">
												<input type="text" class="form-control" id="asignatura" name="asignatura" placeholder="" readonly>
											</div>
										</div>
										<div class="form-group">
											<label for="salon" class="col-sm-4 control-label">Salón</label>
											<div class="col-sm-7">
												<input type="text" class="form-control" id="salon" name="salon" placeholder="" readonly>
											</div>
										</div>
										
										<div class="form-group">
											<label for="ih" class="col-sm-4 control-label">Intensidad Horaria</label>
											<div class="col-sm-7">
												<select class="form-control" id="ih" name="ih">
												 <?php 
													for($i=1; $i<10; $i++) {
														echo "<option value='".$i."'>".$i."</option>";
													}
												 ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="aniolect" class="col-sm-4 control-label">Año lectivo</label>
											<div class="col-sm-7">
												<input type="text" class="form-control" id="aniolect" name="aniolect" placeholder="" readonly>
											</div>
										</div>
										<div class="form-group">
											<label for="periodos" class="col-sm-4 control-label">Cortes a calificar</label>
											<div class="col-sm-8">
												<input type="checkbox" name="periodos[]" value="1"><label>1C Primer Semestre</label><br/>
												<input type="checkbox" name="periodos[]" value="2"><label>2C Primer Semestre</label><br/>
												<input type="checkbox" name="periodos[]" value="3"><label>1C Segundo Semestre</label><br/>
												<input type="checkbox" name="periodos[]" value="4"><label>2C Segundo Semestre</label>
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
				<h3>Docentes | Intensidad Horaria | Actualizar/Eliminar</h3>
				<h3 class="col-md-10 col-md-offset-2"><?php echo $_GET['nombre']." - AÑO LECTIVO ".$_GET['aniolectivo']; ?></h3><hr>
				<table id="datatable_docentes" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Código Salón</th>
						<th width="150px">Salón</th>
						<th>Código Asignatura</th>
						<th width="150px">Asignatura</th>
						<th>Cortes a calificar</th>
						<th>Intensidad Horaria</th>
						<th>Año Lectivo</th>
						<th width="80px"></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Código Salón</th>
						<th>Salón</th>
						<th>Código Asignatura</th>
						<th>Asignatura</th>
						<th>Cortes a calificar</th>
						<th>Intensidad Horaria</th>
						<th>Año Lectivo</th>
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
			$("#formEditarClase #materia").val(data.idmateria);
			$("#formEditarClase #aula").val(data.idaula);
			$("#formEditarClase #asignatura").val(data.nombre_materia);
			$("#formEditarClase #salon").val(data.salon);
			$("#formEditarClase #aniolect").val(data.aniolectivo);
			$('#formEditarClase #ih option[value="'+data.ih+'"]').attr("selected", "selected");		
			$('input[name="periodos[]"]').each(function() {
					this.checked = false;
			});
			$('input[name="periodos[]"]').each(function() {
				var periodos = data.periodos;
				var isFound = periodos.indexOf($(this).val());
				if(isFound>=0){
					this.checked = true;
				}
				
			});
			$('#editarClaseModal .modal-body p').html("")
			$('#editarClaseModal').modal("show");
		});
	}
	var obtener_clase_eliminar = function(tbody, table){
		$(tbody).on("click","button.eliminar", function(){
			var data = table.row($(this).parents('tr')).data();
			$("#formClaseEliminar #d_materia").val(data.idmateria);
			$("#formClaseEliminar #d_aula").val(data.idaula);
			$("#formClaseEliminar #d_aniolect").val(data.aniolectivo);
			$('#eliminarModal .modal-body p').html("")
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
			"sSearch":         "Buscar clase:",
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
				"method": "GET",
				"url": "lista_clases_id.php?iddocente=<?php echo $_GET['iddocente']; ?>&aniolectivo=<?php echo $_GET['aniolectivo']; ?>"
			},
			"columns":[
				{"data":"idaula"},
				{"data":"salon"},
				{"data":"idmateria"},
				{"data":"nombre_materia"},
				{"data":"periodos"},
				{"data":"ih"},
				{"data":"aniolectivo"},
				{"defaultContent":"<button class='editar btn btn-primary' placeholder='Editar'><i class='glyphicon glyphicon-edit'></i></button> <button class='eliminar btn btn-danger' data-toogle='mpdal' data-target='#modalEliminar'><i class='glyphicon glyphicon-trash'></i></button>"}
			],
			"language": language_espanish
		});
		obtener_data_editar("#datatable_docentes tbody",table);
		obtener_clase_eliminar("#datatable_docentes tbody",table);
		
	}
	
	
	$(document).ready(function() {
		listar();
		$( "#formEditarClase" ).submit(function( event ) {
		  event.preventDefault();
		  var $form = $(event.target);
		  $.post($form.attr('action'), $form.serialize(), function(result) {
				$('#editarClaseModal .modal-body p').html(result).fadeOut(300).fadeIn(300);
				listar();
          });
		});
	});
	$( "#formClaseEliminar" ).submit(function( event ) {
		  event.preventDefault();
		  var $form = $(event.target);
		  $.post($form.attr('action'), $form.serialize(), function(result) {
				$('#eliminarModal .modal-body p').html(result);
				listar();
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