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
    <title>SISTEMA ACADEMICO DE CALIFICACIONES - PANEL ADMINISTRADOR - CALIFICACIONES</title>
 
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
				
				<h3>Calificaciones | Regulares | Duplicar Calificación</h3>
				<table id="datatable_docentes" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th colspan="6">Area/Asignatura:<select id='idmateria' name='idmateria' class='form-control' placeholder='Area/Asignatura'><?php 
						$sql = "SELECT DISTINCT idmateria, nombre_materia, abreviatura
						FROM materia ORDER BY nombre_materia";
						$consulta = $conx->query($sql);
						while ($row = $conx->records_array($consulta)) {
							$abreviatura = utf8_encode($row['abreviatura']);
							$idmateria= $row['idmateria'];
							$nombre_materia=utf8_encode($row['nombre_materia']);
							echo "<option value='$idmateria'>$nombre_materia ($abreviatura)</option>";
						}
						?></select>     Aula:<select id='idaula' name='idaula' class='form-control' placeholder='Salón'><?php 
						$sql = "SELECT DISTINCT idaula, grado, grupo, descripcion, jornada
						FROM aula ORDER BY grado, grupo";
						$consulta = $conx->query($sql);
						while ($row = $conx->records_array($consulta)) {
							$grupo = utf8_encode($row['grupo']);
							$idaula= $row['idaula'];
							$descripcion=utf8_encode($row['descripcion']);
							$jornada=utf8_encode($row['jornada']);
							switch($jornada){
								case 'M': $jornada='MAÑANA'; break;
								case 'T': $jornada='TARDE'; break;
							}
						
							echo "<option value='$idaula'>$descripcion - Grupo $grupo - $jornada</option>";
						}
						?></select></th>
					</tr>
					
					<tr>
						<th colspan='6'>
							Periodo que tiene calificaciones:<select id='periodoant' name='periodoant' class='form-control' placeholder='Corte ó Periodo'>
							<option value="1">1T Primer trimestre</option>
							<option value="2">2T Primer trimestre</option>
							<option value="3">3T Primer trimestre</option>
							<option value="1">1C Primer semestre</option>
							<option value="2">2C Primer semestre</option>
							<option value="3">1C Segundo semestre</option>
							<option value="4">2C Segundo semestre</option></select>    Año lectivo de calificaciones:<select id='aniolectivoant' name='aniolectivoant' class='form-control' placeholder='Año lectivo'><?php for($i=date("Y"); $i>2010; $i--){?><option value='<?php echo $i; ?>'><?php echo $i; ?></option><?php } ?></select>
						</th>
					</tr>
					<tr>
						<th colspan='6'>
							Periodo que se enviarán las calificaciones:<select id='periodopost' name='periodopost' class='form-control' placeholder='Corte ó Periodo'>
							<option value="1">1T Primer trimestre</option>
							<option value="2">2T Primer trimestre</option>
							<option value="3">3T Primer trimestre</option>
							<option value="1">1C Primer semestre</option>
							<option value="2">2C Primer semestre</option>
							<option value="3">1C Segundo semestre</option>
							<option value="4">2C Segundo semestre</option></select>    Año lectivo que se enviarán calificaciones:<select id='aniolectivopost' name='aniolectivopost' class='form-control' placeholder='Año lectivo'><?php for($i=date("Y"); $i>2010; $i--){?><option value='<?php echo $i; ?>'><?php echo $i; ?></option><?php } ?></select>
						</th>
					</tr>
					<tr class="bg-info">
						<th colspan='6' class="text-center"><h4>Resultados Docente</h4></th>
					</tr>
					<tr>
						<th>Identificación</th>
						<th>Primer apellido</th>
						<th>Segundo Apellido</th>
						<th>Primer nombre</th>
						<th>Segundo nombre</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<div id='data'></div>
				</tbody>
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
	$( document ).ajaxStart(function() {
	  $("tbody").html('<tr><td colspan="6"><strong>Cargando......</strong></td></tr>');
	});
	$( "#idmateria" ).change(function() {
	  $.post( "lista_docentes_duplicar.php", { materia: $('#idmateria').val(), aula: $('#idaula').val(),anio: $('#aniolectivopost').val(),  periodov: $('#periodopost').val()})
		.done(function( data ) {
			$('tbody').html(data);
	  });
	});
	$( "#idaula" ).change(function() {
	  $.post( "lista_docentes_duplicar.php", { materia: $('#idmateria').val(), aula: $('#idaula').val(), anio: $('#aniolectivopost').val(),  periodov: $('#periodopost').val()})
		.done(function( data ) {
			$('tbody').html(data);
	  });
	});
	$( "#aniolectivopost" ).change(function() {
	  $.post( "lista_docentes_duplicar.php", { materia: $('#idmateria').val(), aula: $('#idaula').val(), anio: $('#aniolectivopost').val(),  periodov: $('#periodopost').val()})
		.done(function( data ) {
			$('tbody').html(data);
	  });
	});
	$( "#periodopost" ).change(function() {
	  $.post( "lista_docentes_duplicar.php", { materia: $('#idmateria').val(), aula: $('#idaula').val(), anio: $('#aniolectivopost').val(),  periodov: $('#periodopost').val()})
		.done(function( data ) {
			$('tbody').html(data);
	  });
	});
	var obtener_data_docente = function(tbody, table){
		$(tbody).on("click","button.calificar", function(){
			var id = $(this).attr('iddocente');
			var aniolectivoant=$("#aniolectivoant").val();
			var aniolectivopost=$("#aniolectivopost").val();
			var idmateria = $('#idmateria').val();
			var idaula = $('#idaula').val();
			var periodoant = $('#periodoant').val();
			var periodopost = $('#periodopost').val();
			window.open("copiar_calificacionesxestudiante.php?id="+id+"&idmateria="+idmateria+"&idaula="+idaula+"&aniolectivopost="+aniolectivopost+"&periodopost="+periodopost+"&aniolectivoant="+aniolectivoant+"&periodoant="+periodoant);
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
			"columns":[
				{"data":"iddocente"},
				{"data":"apellido1"},
				{"data":"apellido2"},
				{"data":"nombre1"},
				{"data":"nombre2"},
				{"defaultContent":"<button class='ver_clases btn btn-success' placeholder='Ingresar calificaciones'><i class='glyphicon glyphicon-edit'></i> Duplicar</button>"}
			],
			"language": language_espanish
		});
		obtener_data_docente("#datatable_docentes tbody",table);
		
		
	}
	
	$(document).ready(function() {
		listar();
		
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