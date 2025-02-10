<?php
session_start();
//Datos de Configuración de la app
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
$sql = "SELECT * FROM appconfig WHERE item = 'aniolect'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$aniolectivo = $records['valor'];
$sql = "SELECT * FROM appconfig WHERE item = 'periodo_hab'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$periodo = $records['valor'];
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
$curso = ($records['descripcion']);
$grado = $records['grado'];
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISTEMA ACADEMICO DE CALIFICACIONES - SELECCIONAR COMPETENCIA <?php echo $nommateria." GRADO ".$grado."°"; ?></title>
 
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
			WHERE idusuario='".$_SESSION['k_username']."' and iddocente=idusuario and tipousuario='D'";
			$consulta = $conx->query($sql);
			if($conx->get_numRecords($consulta)>0){
				$records = $conx->records_array($consulta);
				$user=$records['nombre1']." ".$records['apellido1']; 
				$iddocente=$records['iddocente']; 
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
			$sql2 = "SELECT * FROM jefearea WHERE 
			iddocente='".$_SESSION['k_username']."' AND aniolectivo=$aniolectivo";
			$consulta2 = $conx->query($sql2);
			$jefearea=$conx->get_numRecords($consulta2);
			if($recordsM['valor']=='on' and $jefearea>0)
			{
		?>
			<nav class="navbar navbar-inverse navbar-fixed-top">
			  <div class="container">
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Desplegar navegación</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				  <a class="navbar-brand" href="#">Celeste 2.0 - <?php echo ($ie);?></a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
				  <ul class="nav navbar-nav">
					<li class="active"><a href="../../docente/index.php">Inicio</a></li>
					<?php 
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
						  <li><a href="nvcompetencia.php">Nueva</a></li>
						  <li><a href="actelimcompetencia.php">Actualizar/Eliminar</a></li>
						  <li><a href="selecionarcompetencia.php">Seleccionar Competencias</a></li>
						  <li><a href="desselecionarcompetencia.php">Quitar Competencias</a></li>
						  <li><a href="categorizarcompetencia.php" class="btn btn-success white-text">Categorizar Competencias</a></li>
						  
						</ul>
					</li>
					<?php
					}
					?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Calificaciones<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li role="presentation" class="dropdown-header">Regulares</li>
						  <li><a href="../notas/ingresarcalificaciones.php">Ingresar Calificación</a></li>
						  <li><a href="../notas/eliminarcalificaciones.php">Eliminar Calificación</a></li>
						  <li role="presentation" class="divider"></li>
						  <li role="presentation" class="dropdown-header">Nivelación</li>
						  <li><a href="../notas/ingresarcalificacionesnv.php">Ingresar Calificación</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Informes<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li><a href="../notas/listarcalificaciones.php">Generar informe de notas</a></li>
						  <li><a href="../notas/sintesis.php">Sintesis</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  <span class="glyphicon glyphicon-user"></span>
						  <?php echo $user; ?><b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li><a href="../../docente/logout.php">Cerrar sesión</a></li>
						</ul>
					</li>
				  </ul>
				</div><!--/.nav-collapse -->
			  </div>
			</nav>
			<div class="containertable table-responsive center-block">
			<form class="form-signin" role="form" action="competenciaseleccionsucess.php" method='POST' id='frmcompseleccionada' name='frmcompseleccionada'>
			<?php
				if (isset($_GET['filtrocodigo'])){
					 $filtrocodigo=$_GET['filtrocodigo'] ;
					 
				}else{
					 $filtrocodigo='' ;
				}
				if (isset($_GET['filtrocomponente'])){
				 
					 $filtro=$_GET['filtrocomponente'] ;
				}else{
				 
					 $filtro='' ;
				}
				$url = basename($_SERVER ["PHP_SELF"]);
				$url.="?id=$iddocente&idmateria=$idmateria&idaula=$idaula&aniolectivo=$aniolectivo";
				if($filtrocodigo!=null or $filtrocodigo!=''){
					$sql = "SELECT DISTINCT consecutivo, grados, competencia, estandarbc, descripcion FROM plan_curricular, estandares, materia WHERE  
					(gradoinicio<='$grado' and gradofinal>='$grado') and estandarbc=codigo AND idmateria_fk=idmateria AND consecutivo='$filtrocodigo'
						AND idarea_fk IN (select idarea_fk from materia WHERE idmateria='$idmateria') ORDER BY consecutivo DESC";
				}elseif($filtro!='' and $filtro!='Todos' and $filtro!=null){
						$sql = "SELECT DISTINCT consecutivo, grados, competencia, estandarbc, descripcion FROM plan_curricular, estandares, materia WHERE  
						(gradoinicio<='$grado' and gradofinal>='$grado') and estandarbc=codigo and estandarbc='$filtro' AND idmateria_fk=idmateria
						AND idarea_fk IN (select idarea_fk from materia WHERE idmateria='$idmateria') ORDER BY consecutivo DESC";
				}else{
					$sql = "SELECT DISTINCT consecutivo, grados, competencia, estandarbc, descripcion FROM plan_curricular, estandares, materia WHERE  
					(gradoinicio<='$grado' and gradofinal>='$grado') and estandarbc=codigo AND idmateria_fk=idmateria
						AND idarea_fk IN (select idarea_fk from materia WHERE idmateria='$idmateria') ORDER BY consecutivo DESC";
				}
				$consulta = $conx->query($sql);
				echo "<h3 style='text-align:center;'>SELECCIONAR COMPETENCIAS</h3><hr/><h4>COMPETENCIAS HABILITADAS PARA ".($nommateria)." DE $curso</h4>";
				?>
				<div class="form-group form-inline">
					<label for="periodo">Periodo permitidos para calificar:</label>
					<select id='periodo' name='periodo' class="form-control">
					<?php //for($i=1; $i<5; $i++){ if($periodo==$i){echo "<option value='$i' selected>$i °</option>"; }else{echo "<option value='$i'>$i °</option>";}}
					//ubicando periodos habilitado para el docente es esta materia
					if($aniolectivo<2016){
						$sqlp = "SELECT c.periodos FROM clase c
						WHERE c.iddocente='$iddocente' AND c.idmateria=$idmateria AND c.aniolectivo='$aniolectivo' AND c.idaula=$idaula";
						$consultap = $conx->query($sqlp);
						if ($rowp = $conx->records_array($consultap)) {
							$periodos = $rowp['periodos'];
							$periodos = explode(',',$periodos);
							foreach($periodos as $valor ){
								if($valor <= $periodo){
									if($valor==$periodo){echo "<option value='$valor' selected>$valor °</option>"; }else{echo "<option value='$valor'>$valor °</option>";}
								}
							}
						}
					}else{
						for($valor=1; $valor<=4; $valor++){
							if($valor==$periodo){
								echo "<option value='$valor' selected>$valor °</option>";
							}else{
								echo "<option value='$valor'>$valor °</option>";
							}
						}
					}
					?>
					</select>
					<label for="aniolectivo">Año lectivo</label>
					<input input class="form-control" type='text' id='aniolectivo' name='aniolectivo' value='<?php echo $aniolectivo; ?>' disabled/>
					<input type='hidden' id='iddocente' name='iddocente' value='<?php echo $iddocente; ?>' />
					<input type='hidden' id='idmateria' name='idmateria' value='<?php echo $idmateria; ?>' />
					<input type='hidden' id='aniolectivo' name='aniolectivo' value='<?php echo $aniolectivo; ?>' />
					<input type='hidden' id='idaula' name='idaula' value='<?php echo $idaula; ?>' />
					<input type='hidden' id='url' name='url' value='<?php echo $url; ?>' />
					<input type='hidden' id='grado' name='grado' value='<?php echo $grado; ?>' />
					<br/><select id='filtrocomponente' name='filtrocomponente' class="form-control">
					    <?php
							$sqlcomponente="SELECT codigo, descripcion, nombre_materia FROM estandares, materia 
							WHERE idmateria_fk=idmateria and idarea_fk IN (select idarea_fk from materia WHERE idmateria='$idmateria')
							ORDER BY estandares.descripcion ASC";
							$consultacomponete = $conx->query($sqlcomponente);
							if($conx->get_numRecords($consultacomponete)>0){
								echo "<option value='Todos'>Todos los componentes</option>";
								while ($rowcomp = $conx->records_array($consultacomponete)) {
									$codigocomp = $rowcomp['codigo'];
									$descripcion = $rowcomp['descripcion'];
									$nombre_materia = $rowcomp['nombre_materia'];
									echo "<option value='$codigocomp'>".($descripcion)."(".($nombre_materia).")</option>";
								}
								
							}else{
								echo "<option value=''>No se han creado estandares</option>";
							}
						?>
					</select>
					<input  class="form-control" id="consecutivo" name="consecutivo" type="text" placeholder="Ingrese código">
					<button type="button" class="btn btn-default" id='buscar'>Buscar&raquo;</button>
					<button type="submit" class="btn btn-primary">Guardar</button>
				 </div>
				<?php
				
				if($conx->get_numRecords($consulta)>0){
					/* capturar variable por método GET */
					if (isset($_GET['pag'])){
					 $ini=$_GET['pag'] ;
					}else{
					 $ini=1;
					}
					$count=$conx->get_numRecords($consulta);
					if($ini=='t'){
						$limit_end = $count;
						$ini=1;
					}elseif($ini=='r'){
						$limit_end = 10;
						$ini=1;
					}else{
						$limit_end = 10;
						if (isset($_GET['pag'])){
						 $ini=$_GET['pag'] ;
						}else{
						 $ini=1;
						}
						
					}
					if($limit_end>$count){
						$limit_end = $count;
					}
					$init =($ini-1)*$limit_end;
					$total = ceil($count/$limit_end);
					$url = basename($_SERVER ["PHP_SELF"]);
					$url.="?id=$iddocente&idmateria=$idmateria&idaula=$idaula&aniolectivo=$aniolectivo&filtrocomponente=$filtro&filtrocodigo=$filtrocodigo";
					if($filtrocodigo!='' and $filtrocodigo!=null){
						$sql = "SELECT DISTINCT consecutivo, grados, competencia, estandarbc, descripcion, nombre_materia FROM plan_curricular, estandares, materia WHERE  
						(gradoinicio<='$grado' and gradofinal>='$grado') and estandarbc=codigo and consecutivo='$filtrocodigo' AND idmateria_fk=idmateria
						AND idarea_fk IN (select idarea_fk from materia WHERE idmateria='$idmateria') ORDER BY consecutivo DESC
						LIMIT $init, $limit_end";
						
					}elseif($filtro!='' and $filtro!='Todos' and $filtro!=null){
						$sql = "SELECT DISTINCT consecutivo, grados, competencia, estandarbc, descripcion, nombre_materia FROM plan_curricular, estandares, materia WHERE  
						(gradoinicio<='$grado' and gradofinal>='$grado') and estandarbc=codigo and estandarbc='$filtro' AND idmateria_fk=idmateria
						AND idarea_fk IN (select idarea_fk from materia WHERE idmateria='$idmateria') ORDER BY consecutivo DESC
						LIMIT $init, $limit_end";
					}else{
						$sql = "SELECT DISTINCT consecutivo, grados, competencia, estandarbc, descripcion, nombre_materia FROM plan_curricular, estandares, materia WHERE  
						(gradoinicio<='$grado' and gradofinal>='$grado') and estandarbc=codigo AND idmateria_fk=idmateria
						AND idarea_fk IN (select idarea_fk from materia WHERE idmateria='$idmateria') ORDER BY consecutivo DESC
						LIMIT $init, $limit_end";
					}
					$consulta = $conx->query($sql);
					echo "<table class='table table-hover table-striped' style='text-align:left;'>";
					echo "<thead>";
					echo "<tr>";
					echo "<th>Codigo</th>";
					echo "<th>Componente</th>";
					echo "<th>Competencia</th>";
					echo "<th>Grupo de grados</th>";
					echo "<th>Seleccionar</th>";
					echo"</tr>";
					echo "</thead>";
					echo "<tbody>";
					while ($row = $conx->records_array($consulta)) {
						$id = $row['consecutivo'];
						echo "<tr>";
						echo "<td>".$row['consecutivo']."</td>";
						echo "<td>".($row['descripcion'])."(".($row['nombre_materia']).")</td>";
						echo "<td>".($row['competencia'])."</td>";
						echo "<td>".$row['grados']."</td>";
						echo "<td><input type='checkbox' id='idcompetencias[]' name='idcompetencias[]' value='$id'></td>";
						echo "</tr>";
					}
					echo "</tbody>";
					echo "</table>";
					?>
					<ul class="pagination">
					  <?php 
					  echo "<li><a href='$url&pag=r'>Reiniciar</a></li>";
					  if(($ini-1) == 0){
						echo "<li><a href='#'>&laquo;</a></li>";
					  }else{
						echo "<li><a href='$url&pag=".($ini-1)."'><b>&laquo;</b></a></li>";
					  }
					  for($k=1; $k <= $total; $k++){
						if($ini == $k){
							echo "<li class='active'><a href='#'><b>".$k."</b></a></li>";
						}else{
							echo "<li><a href='$url&pag=$k'>".$k."</a></li>";
						}
					  }
					  if($ini == $total){
						echo"<li><a href='#'>&raquo;</a></li>";
					  }else{
						 echo "<li><a href='$url&pag=".($ini+1)."'><b>&raquo;
						</b></a></li>";
					  }
					  echo"<li><a href='$url&pag=t'>Todos</a></li>";
					  ?>
					</ul>
					<?php
				}elseif($filtrocodigo!='' and $filtrocodigo!=null){
				?>
					<div class="jumbotron center-block">
					<h2 class='alert alert-danger'>El codigo <?php echo $filtrocodigo;?> que ingresaste no pertecene al area en este grupo de grados</h2>
					<p><a class='btn btn-lg btn-success '  href='selecionarcompetencia.php' role='button'>Volver</a></p>
					</div>
				<?php
				}else {
				?>
					<div class="jumbotron center-block">
					<h2 class='alert alert-danger'>Usted no ha creado competencias para esta asignatura</h2>
					<p><a class='btn btn-lg btn-success '  href='selecionarcompetencia.php' role='button'>Volver</a></p>
					</div>
				<?php

				}
			}else{
				if($recordsM['valor']!='on'){
				?>
				<div class="jumbotron center-block">
				<h1 class='alert alert-danger'>Sistema Cerrado</h1>
				<p><a class='btn btn-lg btn-success' href='../../index.php' role='button'>Ir al inicio</a></p>
				</div>
				<?php
				}else{
					if($jefearea<=0){
					?>
					<div class="jumbotron center-block">
					<h1 class='alert alert-danger'>Esta función no esta habilitada para ti.</h1>
					<p><a class='btn btn-lg btn-success' href='../../docente/index.php' role='button'>Ir al inicio</a></p>
					</div>
					<?php
					}
					
				}
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
				/*if(confirm("Realmente desea eliminar competencia?")){
					location.href='elimcomptenciaformsucess.php?id='+id+'&iddocente='+iddocente;	
				}*/
				$("#buscar").click(function(){
					// action goes here!!
					url=$("#url").val();
					url+="&filtrocomponente="+$("#filtrocomponente").val()+"&filtrocodigo="+$("#consecutivo").val();
					location.href=url;
				
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
