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
				
				<h3>Docentes |  Cordinadores de áreas | Reporte </h3>
				<div class="panel panel-danger">
				  <div class="panel-heading">
					<h3 class="panel-title">REPORTE COORDINADORES DE AREA <?php echo strtoupper ($_GET['nombre_materia'])." - AÑO LECTIVO ".$_GET['aniolectivo']; ?></h3>
				  </div>
				  <div class="panel-body">
					<table id="datatable_docentes" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th width="150px">Grado</th>
								<th>Docente</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Grado</th>
								<th>Docente</th>
							</tr>
						</tfoot>
					</table>
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
    <script src="../../plugins/datatables2/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables2/dataTables.buttons.min.js"></script>
    <script src="../../plugins/datatables2/jszip.min.js"></script>
    <script src="../../plugins/datatables2/pdfmake.min.js"></script>
    <script src="../../plugins/datatables2/vfs_fonts.js"></script>
    <script src="../../plugins/datatables2/buttons.html5.min.js"></script>
	<script>
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
			dom: 'Bfrtip',
			buttons: [
				{ extend: 'excelHtml5', footer: false,
					title: 'REPORTE COORDINADORES AREA DE <?php echo strtoupper ($_GET['nombre_materia'])." - AÑO LECTIVO ".$_GET['aniolectivo']; ?>',
					text: '<i class="glyphicon glyphicon-download"></i> EXCEL',
					orientation: 'landscape',
					pageSize:'A4',
				},
				{ extend: 'pdfHtml5', footer: true,
					title: 'REPORTE COORDINADORES AREA DE <?php echo strtoupper ($_GET['nombre_materia'])." - AÑO LECTIVO ".$_GET['aniolectivo']; ?>',
					text: '<i class="glyphicon glyphicon-download"></i> PDF',
					orientation: 'portrait',
					pageSize:'A4',
					customize: function ( doc ) {
						doc.content.splice( 1, 0, {
							margin: [ 0, 0, 0, 12 ],
							alignment: 'center',
							image: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAVUAAAFVCAMAAABo0owcAAAABGdBTUEAALGPC/xhBQAAAwBQTFRFAAAAAgICAwMDBAQEBQUFBgYGBwcHCAgICQkJCgoKCwsLDAwMDQ0NDg4ODw8PEBAQEREREhISExMTFBQUFRUVFhYWFxcXGBgYGhoaGxsbHBwcHR0dHh4eHx8fICAgISEhIiIiJCQkJSUlJiYmJycnKCgoKioqLCwsLS0tLy8vMDAwMTExMjIyMzMzNDQ0NjY2ODg4OTk5Ojo6PT09Pj4+Pz8/QEBAQUFBQ0NDRkZGR0dHSEhISkpKS0tLTU1NTk5OUFBQUVFRVFRUVVVVV1dXWFhYWlpaW1tbXV1dXl5eYGBgYWFhYmJiZWVlaGhoaWlpbGxsbW1tb29vcHBwc3NzdHR0d3d3eHh4enp6e3t7f39/gICAg4ODhoaGh4eHi4uLjo6Oj4+PkpKSlZWVl5eXmpqan5+foqKip6enqqqqr6+vsbGxt7e3v7+/x8fH39/f5+fn7+/v9/f3////AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAWDHVeQAAAQB0Uk5T////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////AFP3ByUAAAAJcEhZcwAADsIAAA7CARUoSoAAAAAYdEVYdFNvZnR3YXJlAHBhaW50Lm5ldCA0LjAuNWWFMmUAAEBcSURBVHhe7X2NdxtHcmevQREAwcGIglakso4Y68JVgtvI9J5DbiQmlhnrfNRKVGRasoWzKdOmYZrObm5P///jVVVX9cdM92Bm0CB17+3vPYkzAObr19X11dU96uKvSI93m9XTyeRop4iHk8kJf/+u4l1k9WTyaCdXszHeOZxM+Zh3C+8Uq+eTh3eYsSa4szM54zO8I3hXWD053GGO2mLr0YTPdfV4F1g9fthlZubG9lfnfNIrxVWz+tW8IlrG1uGVM3uVrJ48SiajRWwf8zWuBlfF6vlhG7vUBOtPrs6EXQ2rh3Ucp+0d8Jwmp3yIxdlkcrizs8W/qkL3CR9y2bgCVo+rCcl3HtX28o8nD3eqtcj6Ef/0UnHZrE4f8uOGsP2knTo8PaqKGrbK4r5oXC6rT6IPPz6KacG/h2+/5+2Lzwd5j8Kpadk5ncQdtEeXrGIvkdXjiH3q7lS67yP4yZi3aYd+DYeF/KeTR5F2yy9VxV4Wq+eRnj/bBUIiu7x9MYAdYrWvcvrg4uLFeDz2lOdJ5FJ3Li/2uhxWp2N+Mg/1fB9kVRicGlYzldEnF1vY7TuDPb0nOApaxPyyeL0MVqehrn/nK/4WXKWDfd4KYaS6qvNab+/DtmY1V8v0CXJOuE27Dk63+RsX+eW4BItn9STAqafljnuq94a3AxipfCCKdaTe06yC0Hbwg10418Z4I7um1C7uA5Y2XvDWxVeBS3cvg9dFs3qyzk/jQCwym5sJfLSuN0MAVvuiWFEBEKvHHTXSH+R0lo+uqSH+hQsua74ZT8p+QfeQv1scFsvqpGyRx+I9ft1b1innCXbxZ7QZArAqinU66MAZkNWX4IbCn6OOiOiK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',
							width: 60,
							height: 60
						} );
					} 
				}
			],
			"destroy":true,
			"order":true,
			"ajax":{
				"method": "GET",
				"url": "lista_coordinadores_id.php?idmateria=<?php echo $_GET['idmateria']; ?>&aniolectivo=<?php echo $_GET['aniolectivo']; ?>"
			},
			"columns":[
				{"data":"salon"},
				{"data":"docente"}
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