<?php
//Datos de Configuración de la app
session_start();
include("../../class/ultimatemysql/mysql.class.php");
include('../../bdConfig.php');
include('../../class/MySqlClass.php');
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
$sql = "SELECT * FROM appconfig WHERE item = 'aniolect'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$aniolectivo = $records['valor'];
$sql = "SELECT * FROM appconfig WHERE item = 'periodon'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$periodoh = $records['valor'];

$aniolectivo = $_GET['aniolectivo'];;
$iddocente = $_GET['id'];;
$idmateria=$_GET['idmateria'];
$idaula=$_GET['idaula'];
$sql = "SELECT nombre_materia FROM materia WHERE idmateria = '$idmateria'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$nommateria = $records['nombre_materia'];
$sql = "SELECT descripcion, grupo, grado FROM aula WHERE idaula = '$idaula'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$curso = utf8_encode($records['descripcion']." - GRUPO ".$records['grupo']);
$grado = $records['grado'];
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISTEMA ACADEMICO DE CALIFICACIONES - CALIFICAR NIVELACION ESTUDIANTES <?php echo $nommateria." GRADO ".$grado."°"; ?></title>
 
    <!-- CSS de Bootstrap -->
    <link href="../../css/bootstrap.min.css" rel="stylesheet" media="screen">
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
			$sql = "SELECT idusuario, apellido1, nombre1,iddocente, tipousuario FROM usuario, docente 
			WHERE idusuario='".$_SESSION['k_username']."' and iddocente=idusuario and (tipousuario='D' or tipousuario='A')";
			$consulta = $conx->query($sql);
			if($conx->get_numRecords($consulta)>0){
				$records = $conx->records_array($consulta);
				$user=$records['nombre1']." ".$records['apellido1']; 
				$iddocentesesion=$records['iddocente']; 
				$tipousuario=$records['tipousuario']; 
				$look=true;
			}
		}else{
		?>
			<div class="jumbotron center-block">
				<h1 class='alert alert-danger'>Debe Iniciar Sesión</h1>
				<p><a class='btn btn-lg btn-success' href='../../index.php' role='button'>Ir al inicio</a></p>
			</div>
		<?php
		}
		if($look){
			$sql = "SELECT * FROM appconfig WHERE item = 'index_docen_ful'";
			$consulta = $conx->query($sql);
			$recordsM = $conx->records_array($consulta);
			
			if($recordsM['valor']=='on' or $tipousuario=='A' )
			{
			if ($tipousuario=='A'){}
			else{			
			echo "<nav class='navbar navbar-inverse navbar-fixed-top'>
			  <div class='container'>
				<div class='navbar-header'>
				  <button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#navbar' aria-expanded='false' aria-controls='navbar'>
					<span class='sr-only'>Desplegar navegación</span>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
				  </button>
				  <a class='navbar-brand' href='#'>Celeste 2.0 - $ie</a>
				</div>
				<div id='navbar' class='collapse navbar-collapse'>
				  <ul class='nav navbar-nav'>
					<li class='active'><a href='../../docente/index.php'>Inicio</a></li>";
					$sql = "SELECT * FROM jefearea WHERE 
					iddocente='".$_SESSION['k_username']."' AND aniolectivo=$aniolectivo";
					$consulta = $conx->query($sql);
					if($conx->get_numRecords($consulta)>0){
					?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Competencias Académicas<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li><a href="../indicadores/nvcompetencia.php">Nueva</a></li>
						  <li><a href="../indicadores/actelimcompetencia.php">Actualizar/Eliminar</a></li>
						  <li><a href="../indicadores/selecionarcompetencia.php">Seleccionar Competencias</a></li>
						  <li><a href="../indicadores/desselecionarcompetencia.php">Quitar Competencias</a></li>
						  <li><a href="../indicadores/categorizarcompetencia.php" class="btn btn-success white-text">Categorizar Competencias</a></li>
						  
						</ul>
					</li>
					<?php
					}
					echo "<li class='dropdown'>
						<a href='#' class='dropdown-toggle' data-toggle='dropdown'>
						  Calificaciones<b class='caret'></b>
						</a>
						<ul class='dropdown-menu'>
						  <li role='presentation' class='dropdown-header'>Regulares</li>
						  <li><a href='ingresarcalificaciones.php'>Ingresar Calificación</a></li>
						  <li><a href='eliminarcalificaciones.php'>Eliminar Calificación</a></li>
						  <li role='presentation' class='divider'></li>
						  <li role='presentation' class='dropdown-header'>Nivelación</li>
						  <li><a href='ingresarcalificacionesnv.php'>Ingresar Calificación</a></li>
						</ul>
					</li>
					<li class='dropdown'>
						<a href='#' class='dropdown-toggle' data-toggle='dropdown'>
						  Informes<b class='caret'></b>
						</a>
						<ul class='dropdown-menu'>
						  <li><a href='listarcalificaciones.php'>Generar informe de notas</a></li>
						  <li><a href='sintesis.php'>Sintesis</a></li>
						</ul>
					</li>
					<li class='dropdown'>
						<a href='#' class='dropdown-toggle' data-toggle='dropdown'>
						  <span class='glyphicon glyphicon-user'></span>
						  $user<b class='caret'></b>
						</a>
						<ul class='dropdown-menu'>
						  <li><a href='../../docente/logout.php'>Cerrar sesión</a></li>
						</ul>
					</li>
				  </ul>
				</div><!--/.nav-collapse -->
			  </div>
			</nav>";
			}
			?>
			<div class="containertablecalificar table-responsive center-block">
			<form class="form-signin" role="form" action="" method='POST' id='frmcompseleccionada' name='frmcompseleccionada'>
			<?php
			if (isset($_GET['pag'])){
			 //$ini=$_GET['pag'] ;
			 $ini='t' ;
			}else{
			 //$ini=1;
			 $ini='t' ;
			}
			if (isset($_GET['periodo'])){
			 $periodo=$_GET['periodo'] ;
			}else{
			 //$periodo=1;
			 $periodo=$periodoh;
			}
			$sqlest = "SELECT e.idestudiante, e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula 
				FROM estudiante e, matricula m  
				WHERE e.idestudiante=m.idestudiante AND e.habilitado='S' 
				AND m.tipo_matricula='N' AND m.aniolectivo='$aniolectivo' AND m.idaula=$idaula AND m.idaula IN 
				(SELECT c.idaula FROM clase c, aula a WHERE c.iddocente='$iddocente'
				AND c.idmateria=$idmateria AND c.aniolectivo=$aniolectivo
				AND c.idaula=a.idaula and a.grado='$grado') AND m.periodo=$periodo
				ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
			$consulta = $conx->query($sqlest);
			$count=$conx->get_numRecords($consulta);
			/*$limit_end = $count;
			$ini=1;*/
			if($ini=='t'){
				$limit_end = $count;
				$ini=1;
			}elseif($ini=='r'){
				$limit_end = 5;
				$ini=1;
			}else{
				$limit_end = 5;
				if (isset($_GET['pag'])){
				 //$ini=$_GET['pag'] ;
				 $ini='t' ;
				}else{
				 //$ini=1;
				 $ini='t';
				}
				
			}
			if($limit_end>$count){
				$limit_end = $count;
			}
			if($limit_end==0){
				$limit_end = 1;
			}
			$init =($ini-1)*$limit_end;
			$total = ceil($count/$limit_end);
			$url = basename($_SERVER ["PHP_SELF"]);
			$url.="?id=$iddocente&idmateria=$idmateria&idaula=$idaula&aniolectivo=$aniolectivo";
			echo "<h3 style='text-align:center;'>INGRESAR CALIFICACIONES DE NIVELACION</h3><hr/>";
			echo "<h4>".utf8_encode($nommateria)." DE $curso</h4>";
			?>
				<div class="form-group form-inline">
					<label for="periodo">Periodos habilitados para calificar:</label>
					<select id='periodo' name='periodo' class="form-control">
					<?php //for($i=1; $i<5; $i++){ if($periodo==$i){echo "<option value='$i' selected>$i °</option>"; }else{echo "<option value='$i'>$i °</option>";}} 
					//ubicando periodos habilitado para el docente es esta materia
					if($tipousuario=='A'){
						for($p=1; $p<8; $p++){
							if($p==$periodo){
									if($p=="5"){
										echo "<option value='".$p."' selected>1er SEMESTRE</option>";
									}elseif($p=="6"){
										echo "<option value='".$p."' selected>2do SEMESTRE</option>";
									}elseif($p=="7"){
										echo "<option value='".$p."' selected>FINAL</option>";
									}else{						
										echo "<option value='".$p."'>".$p."</option>";

									}
							}else{
										echo "<option value='5' >1er SEMESTRE</option>";
										echo "<option value='6' >2do SEMESTRE</option>";
										echo "<option value='7' >FINAL</option>";

							}
						}	
					}else{
						echo "<option value='5' >1er SEMESTRE</option>";
						echo "<option value='6' >2do SEMESTRE</option>";
						echo "<option value='7' >FINAL</option>";
					}
					?>
					</select>
					<label for="aniolectivo">Año lectivo</label>
					<input input class="form-control" type='text' id='aniolectivo' name='aniolectivo' value='<?php echo $aniolectivo; ?>' disabled/>
					<input type='hidden' id='iddocente' name='iddocente' value='<?php echo $iddocente; ?>' />
					<input type='hidden' id='aniolectivo' name='aniolectivo' value='<?php echo $aniolectivo; ?>' />
					<input type='hidden' id='idaula' name='idaula' value='<?php echo $idaula; ?>' />
					<input type='hidden' id='grado' name='grado' value='<?php echo $grado; ?>' />
					<input type='hidden' id='idmateria' name='idmateria' value='<?php echo $idmateria; ?>' />
					<input type='hidden' id='init' name='init' value='<?php echo $init; ?>' />
					<input type='hidden' id='limit_end' name='limit_end' value='<?php echo $limit_end; ?>' />
					<button type="button" class="btn btn-default" id='buscar'>Buscar Estudiantes &raquo;</button>
				 </div>
				 <div id="cargando" style="color: white; background-color:red;" class='panel-heading'>Cargando...</div>
				 <div class="containertable table-responsive center-block" id='busqueda'>
				 </div>
				 <ul class="pagination">
				  <?php 
				  echo "<li><a href='$url&pag=r'>Reiniciar</a></li>";
				  if(($ini-1) == 0){
					echo "<li><a href='#'>&laquo;</a></li>";
				  }else{
					echo "<li ><a  href='$url&pag=".($ini-1)."&periodo=$periodo'><b>&laquo;</b></a></li>";
				  }
				  for($k=1; $k <= $total; $k++){
					if($ini == $k){
						echo "<li class='active'><a href='#'><b>".$k."</b></a></li>";
					}else{
						echo "<li><a href='$url&pag=$k&periodo=$periodo'>".$k."</a></li>";
					}
				  }
				  if($ini == $total){
					echo"<li><a href='#'>&raquo;</a></li>";
				  }else{
					 echo "<li><a  href='$url&pag=".($ini+1)."&periodo=$periodo'><b>&raquo;
					</b></a></li>";
				  }
				  echo"<li><a href='$url&pag=t&periodo=$periodo'>Todos</a></li>";
				  ?>
				</ul>
			<?php
			}else{
			?>
				
				<div class="jumbotron center-block">
				<h1 class='alert alert-danger'>Sistema Cerrado</h1>
				<p><a class='btn btn-lg btn-success' href='../../index.php' role='button'>Ir al inicio</a></p>
				</div>
			<?php
			}
		}
		$conx->close_conex();
			?>
		</form>
		<br/>
		<div id="myModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><img src="../../images/icon_attention.gif" alt="" style="width:50px;height:50px"></h4>
			  </div>
			  <div class="modal-body">
				<p class='alert-danger'>No ha seleccionado competencias.</p>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</div>

		  </div>
		</div>
		</div>
    <!-- Librería jQuery requerida por los plugins de JavaScript -->
    <script src="../../js/jquery.js"></script>
    <script>
		$(document).ready(function(){
				$("#frmcompseleccionada").submit(function(event) {
			
					// stop form from submitting normally
						
					// get some values from elements on the page:
					//armando array de indicadores
					/*var val = $('#idcompetencias:checked').map(function(i,n) {
						return $(n).val();
					}).get(); //get converts it to an array         
					periodo1=$("#periodo").val();
					aniolect1=$("#aniolectivo").val();
					if($.isEmptyObject(val)){
						//si el objeto esta vacío ejecutamos este codigo
						//alert("No ha seleccionado competencias");
						$('#myModal').modal('show');
						event.preventDefault(); 
					}else{
						
					}*/
					var fields = $('input[name="idcompetencias[]"]:checked').length > 0;
					if (fields<= 0){
						$('#myModal').modal('show');
							event.preventDefault();
						
					}
					/*$("#idcompetencias").each(function(index){
						if ($(this).is(":checked"))
							$('#myModal').modal('show');
							event.preventDefault();
						{
						}else{
							$('#myModal').modal('show');
							event.preventDefault();
						}
						
					});*/
					
				});
				$("#buscar").click(function(){
					// action goes here!!
					grado1=$("#grado").val();
					idaula1=$("#idaula").val();
					idmateria1=$("#idmateria").val();
					iddocente1=$("#iddocente").val();
					aniolectivo1=$("#aniolectivo").val();
					periodo1=$("#periodo").val();
					init1=$("#init").val();
					limit_end1=$("#limit_end").val();
					$("#cargando").html("<strong>Cargando.....</strong>");
					//$("#cargando").css("display", "inline");
					$("#cargando").fadeIn("1000");
					$("#busqueda").animate({opacity: '0.4'}, "slow");
					$("#busqueda").fadeOut("1000");
					$.post("listaestudiantesnv.php",{
						grado: grado1,
						idaula: idaula1,
						idmateria: idmateria1,
						iddocente: iddocente1,
						aniolectivo: aniolectivo1,
						periodo: periodo1,
						init: init1,
						limit_end: limit_end1,
					}, 
					function(data, status){
						if(periodo1=="5"){
							$("#cargando").html("<strong>ESTUDIANTES HABILITADAS PARA NIVELAR EL 1er SEMESTRE</strong>");
						}else if(periodo1=="6"){
							$("#cargando").html("<strong>ESTUDIANTES HABILITADAS PARA NIVELAR EL 2do SEMESTRE</strong>");
						}else if(periodo1=="7"){
							$("#cargando").html("<strong>ESTUDIANTES HABILITADAS PARA NIVELAR AÑO LECTIVO</strong>");
						}else{						
							$("#cargando").html("<strong>ESTUDIANTES HABILITADAS PARA NIVELAR EL "+periodo1+"° PERIODO 	</strong>");

						}
						$("#busqueda").html(data);
						$("#busqueda").fadeIn("1000");
						$("#busqueda").animate({opacity: '1'}, "slow");
						
					});
				});
				
				/*if(confirm("Realmente desea eliminar competencia?")){
					location.href='elimcomptenciaformsucess.php?id='+id+'&iddocente='+iddocente;	
				}*/
		});
		$(document).ready(function(){
			// action goes here!!
			grado1=$("#grado").val();
			idaula1=$("#idaula").val();
			idmateria1=$("#idmateria").val();
			iddocente1=$("#iddocente").val();
			aniolectivo1=$("#aniolectivo").val();
			periodo1=$("#periodo").val();
			init1=$("#init").val();
			limit_end1=$("#limit_end").val();
			$("#cargando").html("<strong>Cargando.....</strong>");
			//$("#cargando").css("display", "inline");
			$("#cargando").fadeIn("1000");
			$("#busqueda").animate({opacity: '0.4'}, "slow");
			$("#busqueda").fadeOut("1000");
			$.post("listaestudiantesnv.php",{
				grado: grado1,
				idaula: idaula1,
				idmateria: idmateria1,
				iddocente: iddocente1,
				aniolectivo: aniolectivo1,
				periodo: periodo1,
				init: init1,
				limit_end: limit_end1,
			}, 
			function(data, status){
				if(periodo1=="5"){
					$("#cargando").html("<strong>ESTUDIANTES HABILITADAS PARA NIVELAR EL 1er SEMESTRE</strong>");
				}else if(periodo1=="6"){
					$("#cargando").html("<strong>ESTUDIANTES HABILITADAS PARA NIVELAR EL 2do SEMESTRE</strong>");
				}else if(periodo1=="7"){
					$("#cargando").html("<strong>ESTUDIANTES HABILITADAS PARA NIVELAR AÑO LECTIVO</strong>");
				}else{						
					$("#cargando").html("<strong>ESTUDIANTES HABILITADAS PARA NIVELAR EL "+periodo1+"° PERIODO 	</strong>");

				}
				$("#busqueda").html(data);
				$("#busqueda").fadeIn("1000");
				$("#busqueda").animate({opacity: '1'}, "slow");
						
				$("#busqueda").html(data);
				$("#busqueda").fadeIn("1000");
				$("#busqueda").animate({opacity: '1'}, "slow");
			});
		});
	</script>
 
    <!-- Todos los plugins JavaScript de Bootstrap (también puedes
         incluir archivos JavaScript individuales de los únicos
         plugins que utilices) -->
    <script src="../../js/bootstrap.min.js"></script>
	<hr>
	<div class='container center-block'>
		<footer>
			<p>&copy; williamcortes10@gmail.com 2015</p>
		</footer>
	</div>
  </body>
</html>
