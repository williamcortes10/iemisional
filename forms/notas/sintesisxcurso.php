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
$sql = "SELECT * FROM appconfig WHERE item = 'aniolect'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$aniolectivo = $records['valor'];
//$aniolectivo = 2015;
$sql = "SELECT * FROM appconfig WHERE item = 'periodo_hab'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$periodo = $records['valor'];
if (isset($_GET['periodo'])){
	 $periodo=$_GET['periodo'] ;
}
if (isset($_GET['aniolectivo'])){
	 $aniolectivo=$_GET['aniolectivo'] ;
}
$sql = "SELECT num_periodos, tipo_periodo FROM periodos_por_anio WHERE anio = '$aniolectivo'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$num_periodos = $records['num_periodos'];
$tipo_periodo = $records['tipo_periodo'];

$sql = "SELECT DISTINCT anio FROM periodos_por_anio ORDER BY anio DESC";
$consulta = $conx->query($sql);  
$anios = array();  
while($periodos_por_anio = $conx->records_array($consulta)){
	array_push($anios, $periodos_por_anio['anio']);
}
sort($anios);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISTEMA ACADEMICO DE CALIFICACIONES - SINTESIS CALIFICACIONES</title>
 
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
			WHERE idusuario='".$_SESSION['k_username']."' and iddocente=idusuario and (tipousuario='A' or tipousuario='S' or tipousuario='C')";
			$consulta = $conx->query($sql);
			if($conx->get_numRecords($consulta)>0){
				$records = $conx->records_array($consulta);
				$user=$records['nombre1']." ".$records['apellido1']; 
				$iddocente=$records['iddocente']; 
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
			if($recordsM['valor']=='on' and $tipousuario=='D')
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
				  <a class="navbar-brand" href="#">Celeste 2.0 - <?php echo utf8_encode($ie);?></a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
				  <ul class="nav navbar-nav">
					<li class="active"><a href="../../docente/index.php">Inicio</a></li>
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
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Calificaciones<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li role="presentation" class="dropdown-header">Regulares</li>
						  <li><a href="ingresarcalificaciones.php">Ingresar Calificación</a></li>
						  <li><a href="eliminarcalificaciones.php">Eliminar Calificación</a></li>
						  <li role="presentation" class="divider"></li>
						  <li role='presentation' class='dropdown-header'>Nivelación</li>
						  <li><a href='ingresarcalificacionesnv.php'>Ingresar Calificación</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						  Informes<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
						  <li><a href="listarcalificaciones.php">Generar informe de notas</a></li>
						  <li><a href="sintesis.php">Sintesis</a></li>
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
			<br/>
			<div class="containertable table-responsive center-block" >
			<?php
				//paginación
				//include("../../class/zebra_pagination/Zebra_Pagination.php"); 
				
				
				if ($periodo=='s1' or $periodo=='s2' or $periodo=='F'){
					
					$periodod = $num_periodos;
					$sql = "SELECT   c.iddocente, c.aniolectivo,c.idaula, a.descripcion, a.grupo, a.jornada
						FROM clase c
						LEFT JOIN aula a ON c.idaula=a.idaula
						WHERE
						c.idmateria='49' AND c.aniolectivo='$aniolectivo' AND c.periodos LIKE '%$periodod%' ORDER BY a.grado,a.grupo";
						
				}else{
					$periodod = $periodo;
					$sql = "SELECT   c.iddocente, c.aniolectivo,c.idaula, a.descripcion, a.grupo, a.jornada
						FROM clase c
						LEFT JOIN aula a ON c.idaula=a.idaula
						WHERE
						c.idmateria='49' AND c.aniolectivo='$aniolectivo' AND c.periodos LIKE '%".$periodod."%' ORDER BY a.grado,a.grupo";
				}
				
				$consulta = $conx->query($sql);
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
						$limit_end = 20;
						$ini=1;
					}else{
						$limit_end = 20;
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
					if ($periodo=='s1' or $periodo=='s2' or $periodo=='F'){
						$periodod = $num_periodos;
						$sql = "SELECT   c.iddocente, c.aniolectivo,c.idaula, a.descripcion, a.grupo, a.jornada
						FROM clase c
						LEFT JOIN aula a ON c.idaula=a.idaula
						WHERE
						c.idmateria='49' AND c.aniolectivo='$aniolectivo' AND c.periodos LIKE '%$periodod%' ORDER BY a.grado,a.grupo
						LIMIT $init, $limit_end";
					}else{
						$periodod = $periodo;
						$sql = "SELECT   c.iddocente, c.aniolectivo,c.idaula, a.descripcion, a.grupo, a.jornada
						FROM clase c
						LEFT JOIN aula a ON c.idaula=a.idaula
						WHERE
						c.idmateria='49' AND c.aniolectivo='$aniolectivo' AND c.periodos LIKE '%".$periodod."%' ORDER BY a.grado,a.grupo
						LIMIT $init, $limit_end";
					}
					
					$consulta = $conx->query($sql);
					?>
					<div class="form-group form-inline">
					<label for="periodo">Periodo:</label>
					<select id='periodo' name='periodo' class="form-control">
					<?php for($i=1; $i<=$num_periodos; $i++){ if($periodo==$i && $periodo!='s1'){echo "<option value='$i' selected>$i °</option>"; }else{echo "<option value='$i'>$i °</option>";}} ?>
					<?php 
							if($periodo=='F')
							{ 
								echo "<option value='F' selected>Final</option>"; 
							}else{
								echo "<option value='F'>Final</option>";
							}
					?>
					</select>
					<label for="aniolectivo">Año lectivo</label>
					<input input class="form-control" type='text' id='aniolectivo' name='aniolectivo' value='<?php echo $aniolectivo; ?>'/>
					</div>
					<br/>
					<br/>
					<br/>
					<?php
					
					echo "<h3 style='text-align:center;'>SINTESIS DE CALIFICACIONES</h3><hr/>";
					echo "<h3 style='text-align:center;'>GRUPOS EN LOS QUE ES DINAMIZADOR AÑO LECTIVO $aniolectivo</h3>";

					echo "<table class='table table-hover' style='text-align:left;'>";
					echo "<thead>";
					echo "<tr>";
					echo "<th>Curso</th>";
					echo "<th></th>";
					echo"</tr>";
					echo "</thead>";
					echo "<tbody>";
					while ($row = $conx->records_array($consulta)) {
						$id = $row['iddocente'];
						$idaula = $row['idaula'];
						echo "<tr>";
						echo "<td>".($row['descripcion'])."-GRUPO ".$row['grupo']."-".$row['jornada']."</td>";
						echo "<td><a class='btn btn-primary' href='javascript:generarsintesis($id,$idaula)'><span>Generar Sintesis</span></a></td>";
						echo "</tr>";
					}
					echo "</tbody>";
					echo "</table>";
					?>
					<ul class="pagination">
					  <?php 
					  echo "<li><a href='$url?pag=r&periodo=$periodo'>Reiniciar</a></li>";
					  if(($ini-1) == 0){
						echo "<li><a href='#'>&laquo;</a></li>";
					  }else{
						echo "<li><a href='$url?pag=".($ini-1)."&periodo=$periodo'><b>&laquo;</b></a></li>";
					  }
					  for($k=1; $k <= $total; $k++){
						if($ini == $k){
							echo "<li class='active'><a href='#'><b>".$k."</b></a></li>";
						}else{
							echo "<li><a href='$url?pag=$k&periodo=$periodo'>".$k."</a></li>";
						}
					  }
					  if($ini == $total){
						echo"<li><a href='#'>&raquo;</a></li>";
					  }else{
						 echo "<li><a href='$url?pag=".($ini+1)."&periodo=$periodo'><b>&raquo;
						</b></a></li>";
					  }
					  echo"<li><a href='$url?pag=t&periodo=$periodo'>Todos</a></li>";
					  ?>
					</ul>
					<?php
				}else {
				?>
					<div class="jumbotron center-block">
					<h1 class='alert alert-danger'>No se le ha asignado intensidad horaria</h1>
					</div>
				<?php

				}
			}elseif($tipousuario=='A'){
				include('../../administrador/nav.php');
				?>
				
				<div class="containertable table-responsive center-block">
			<?php
				//paginación
				//include("../../class/zebra_pagination/Zebra_Pagination.php"); 
				if ($periodo=='s1' or $periodo=='s2' or $periodo=='F'){
					
					$periodod = $num_periodos;
					$sql = "SELECT   c.iddocente, c.aniolectivo,c.idaula, a.descripcion, a.grupo, a.jornada
						FROM clase c
						LEFT JOIN aula a ON c.idaula=a.idaula
						WHERE
						c.idmateria='49' AND c.aniolectivo='$aniolectivo' AND c.periodos LIKE '%$periodod%' ORDER BY a.grado,a.grupo";
				}else{
					$periodod = $periodo;
					$sql = "SELECT   c.iddocente, c.aniolectivo,c.idaula, a.descripcion, a.grupo, a.jornada
						FROM clase c
						LEFT JOIN aula a ON c.idaula=a.idaula
						WHERE
						c.idmateria='49' AND c.aniolectivo='$aniolectivo' AND c.periodos LIKE '%".$periodod."%' ORDER BY a.grado,a.grupo";
				}
				
				$consulta = $conx->query($sql);
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
						$limit_end = 20;
						$ini=1;
					}else{
						$limit_end = 20;
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
					if ($periodo=='s1' or $periodo=='s2' or $periodo=='F'){
						
						$periodod = $num_periodos;
						$sql = "SELECT   c.iddocente, c.aniolectivo,c.idaula, a.descripcion, a.grupo, a.jornada
						FROM clase c
						LEFT JOIN aula a ON c.idaula=a.idaula
						WHERE
						c.idmateria='49' AND c.aniolectivo='$aniolectivo' AND c.periodos LIKE '%$periodod%' ORDER BY a.grado,a.grupo
						LIMIT $init, $limit_end";
					}else{
						$periodod = $periodo;
						$sql = "SELECT   c.iddocente, c.aniolectivo,c.idaula, a.descripcion, a.grupo, a.jornada
						FROM clase c
						LEFT JOIN aula a ON c.idaula=a.idaula
						WHERE
						c.idmateria='49' AND c.aniolectivo='$aniolectivo' AND c.periodos LIKE '%".$periodod."%' ORDER BY a.grado,a.grupo
						LIMIT $init, $limit_end";
					}
					$consulta = $conx->query($sql);
					?>
					<br/>
					<div class="form-group form-inline" style="margin-top: 100px">
					<label for="periodo">Periodo:</label>
					<select id='periodo' name='periodo' class="form-control" title='Seleccione periodo'>
					<?php 
						for($i=1; $i<=$num_periodos; $i++){
							switch($tipo_periodo){
								case 'T': $tipo_periodo='Trimestre'; break;
								case 'P': $tipo_periodo='Periodo'; break;
								case 'S': $tipo_periodo='Semestre'; break;
							}	
							if($periodo==$i && $periodo!='s1'){
								echo "<option value='$i' selected>$i ° $tipo_periodo</option>"; 
							//}elseif($periodo=='s1'){
							//	echo "<option value='s1' selected>Semestre</option>";
							}else{
								echo "<option value='$i'>$i ° $tipo_periodo</option>";
							}
							
						}
						if($aniolectivo<=2016){
							if($periodo=='s1'){ 
								echo "<option value='s1' selected>Semestre 1</option>"; 
							}else{
								echo "<option value='s1'>Semestre 1</option>"; 
							}
							if($periodo=='s2'){ 
								echo "<option value='s2' selected>Semestre 2</option>"; 
							}else{
								echo "<option value='s2'>Semestre 2</option>"; 
							}
						}						
						if($periodo=='F'){ 
							echo "<option value='F' selected>Final</option>"; 
						}else{
							echo "<option value='F'>Final</option>";
						}
						if($periodo=='s1' && $tipo_periodo!='Semestre' && $tipo_periodo!='Periodo' ){
							echo "<option value='s1' selected>Semestre</option>";
						}elseif($tipo_periodo!='Semestre' && $tipo_periodo!='Periodo' ){
							echo "<option value='s1'>Semestre</option>";
						}
					?>
					</select>
					<label for="aniolectivo">Año lectivo</label>
					<select id='aniolectivo' name='aniolectivo' class="form-control" title='Seleccione año lectivo'>
						
						<?php
						foreach($anios as $clave=>$valor){
							if($aniolectivo==$valor){ 
								echo "<option value='$valor' selected>$valor</option>"; 
							}else{
								echo "<option value='$valor'>$valor</option>";
							}
						}
							
						?>
					</select>					
					</div>
					<?php
					echo "<h3 style='text-align:center;'>SINTESIS DE CALIFICACIONES </h3><hr/>";

					echo "<table class='table table-hover' style='text-align:left;'>";
					echo "<thead>";
					echo "<tr>";
					echo "<th>Curso</th>";
					echo "<th></th>";
					echo"</tr>";
					echo "</thead>";
					echo "<tbody>";
					while ($row = $conx->records_array($consulta)) {
						$id = $row['iddocente'];
						$idaula = $row['idaula'];
						echo "<tr>";
						echo "<td>".($row['descripcion'])."-GRUPO ".$row['grupo']."-".$row['jornada']."</td>";
						echo "<td><a class='btn btn-primary' href='javascript:generarsintesis($id,$idaula)'><span>Generar Sintesis</span></a></td>";
						echo "</tr>";
					}
					echo "</tbody>";
					echo "</table>";
					?>
					<ul class="pagination">
					  <?php 
					  echo "<li><a href='$url?pag=r&periodo=$periodo'>Reiniciar</a></li>";
					  if(($ini-1) == 0){
						echo "<li><a href='#'>&laquo;</a></li>";
					  }else{
						echo "<li><a href='$url?pag=".($ini-1)."&periodo=$periodo&aniolectivo=$aniolectivo'><b>&laquo;</b></a></li>";
					  }
					  for($k=1; $k <= $total; $k++){
						if($ini == $k){
							echo "<li class='active'><a href='#'><b>".$k."</b></a></li>";
						}else{
							echo "<li><a href='$url?pag=$k&periodo=$periodo&aniolectivo=$aniolectivo'>".$k."</a></li>";
						}
					  }
					  if($ini == $total){
						echo"<li><a href='#'>&raquo;</a></li>";
					  }else{
						 echo "<li><a href='$url?pag=".($ini+1)."&periodo=$periodo&aniolectivo=$aniolectivo'><b>&raquo;
						</b></a></li>";
					  }
					  echo"<li><a href='$url?pag=t&periodo=$periodo&aniolectivo=$aniolectivo'>Todos</a></li>";
					  ?>
					</ul>
					<?php
				}else {
				?>
					<div class="jumbotron center-block">
					<h1 class='alert alert-danger'>No se le ha asignado intensidad horaria</h1>
					</div>
				<?php

				}
			}elseif($tipousuario=='C'){
				include('../../coordinador/nav.php');
				?>
				
				<div class="containertable table-responsive center-block">
			<?php
				//paginación
				//include("../../class/zebra_pagination/Zebra_Pagination.php"); 
				
				
				if ($periodo=='s1' or $periodo=='s2' or $periodo=='F'){
					$periodod = $num_periodos;
					$sql = "SELECT   c.iddocente, c.aniolectivo,c.idaula, a.descripcion, a.grupo, a.jornada
						FROM clase c
						LEFT JOIN aula a ON c.idaula=a.idaula
						WHERE
						c.idmateria='49' AND c.aniolectivo='$aniolectivo' AND c.periodos LIKE '%$periodod%' ORDER BY a.grado,a.grupo";
				}else{
					$periodod = $periodo;
					$sql = "SELECT   c.iddocente, c.aniolectivo,c.idaula, a.descripcion, a.grupo, a.jornada
						FROM clase c
						LEFT JOIN aula a ON c.idaula=a.idaula
						WHERE
						c.idmateria='49' AND c.aniolectivo='$aniolectivo' AND c.periodos LIKE '%".$periodod."%' ORDER BY a.grado,a.grupo";
				}
				
				$consulta = $conx->query($sql);
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
						$limit_end = 20;
						$ini=1;
					}else{
						$limit_end = 20;
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
					if ($periodo=='s1' or $periodo=='s2' or $periodo=='F'){
						
						$periodod = $num_periodos;
						$sql = "SELECT   c.iddocente, c.aniolectivo,c.idaula, a.descripcion, a.grupo, a.jornada
						FROM clase c
						LEFT JOIN aula a ON c.idaula=a.idaula
						WHERE
						c.idmateria='49' AND c.aniolectivo='$aniolectivo' AND c.periodos LIKE '%$periodod%' ORDER BY a.grado,a.grupo
						LIMIT $init, $limit_end";
					}else{
						$periodod = $periodo;
						$sql = "SELECT   c.iddocente, c.aniolectivo,c.idaula, a.descripcion, a.grupo, a.jornada
						FROM clase c
						LEFT JOIN aula a ON c.idaula=a.idaula
						WHERE
						c.idmateria='49' AND c.aniolectivo='$aniolectivo' AND c.periodos LIKE '%".$periodod."%' ORDER BY a.grado,a.grupo
						LIMIT $init, $limit_end";
					}
					
					$consulta = $conx->query($sql);
					?>
					<br/>
					<div class="form-group form-inline" style="margin-top: 100px">
					<label for="periodo">Periodo:</label>
					<select id='periodo' name='periodo' class="form-control" title='Seleccione periodo'>
					<?php 
						for($i=1; $i<=$num_periodos; $i++){
							switch($tipo_periodo){
								case 'T': $tipo_periodo='Trimestre'; break;
								case 'P': $tipo_periodo='Periodo'; break;
								case 'S': $tipo_periodo='Semestre'; break;
							}	
							if($periodo==$i){
								echo "<option value='$i' selected>$i ° $tipo_periodo</option>"; 
							}else{
								echo "<option value='$i'>$i ° $tipo_periodo</option>";
							}
							
						}
						if($aniolectivo<=2016){
							if($periodo=='s1'){ 
								echo "<option value='s1' selected>Semestre 1</option>"; 
							}else{
								echo "<option value='s1'>Semestre 1</option>"; 
							}
							if($periodo=='s2'){ 
								echo "<option value='s2' selected>Semestre 2</option>"; 
							}else{
								echo "<option value='s2'>Semestre 2</option>"; 
							}
						}						
						if($periodo=='F'){ 
							echo "<option value='s1'>Semestre</option>";
							echo "<option value='F' selected>Final</option>"; 
						}else{
							echo "<option value='s1'>Semestre</option>";
							echo "<option value='F'>Final</option>";
						}
					?>
					</select>
					<label for="aniolectivo">Año lectivo</label>
					<select id='aniolectivo' name='aniolectivo' class="form-control" title='Seleccione año lectivo'>
						
						<?php
						foreach($anios as $clave=>$valor){
							if($aniolectivo==$valor){ 
								echo "<option value='$valor' selected>$valor</option>"; 
							}else{
								echo "<option value='$valor'>$valor</option>";
							}
						}
							
						?>
					</select>
					</div>
					<?php
					echo "<h3 style='text-align:center;'>SINTESIS DE CALIFICACIONES</h3><hr/>";

					echo "<table class='table table-hover' style='text-align:left;'>";
					echo "<thead>";
					echo "<tr>";
					echo "<th>Curso</th>";
					echo "<th></th>";
					echo"</tr>";
					echo "</thead>";
					echo "<tbody>";
					while ($row = $conx->records_array($consulta)) {
						$id = $row['iddocente'];
						$idaula = $row['idaula'];
						echo "<tr>";
						echo "<td>".($row['descripcion'])."-GRUPO ".$row['grupo']."-".$row['jornada']."</td>";
						echo "<td><a class='btn btn-primary' href='javascript:generarsintesis($id,$idaula)'><span>Generar Sintesis</span></a></td>";
						echo "</tr>";
					}
					echo "</tbody>";
					echo "</table>";
					?>
					<ul class="pagination">
					  <?php 
					  echo "<li><a href='$url?pag=r&periodo=$periodo'>Reiniciar</a></li>";
					  if(($ini-1) == 0){
						echo "<li><a href='#'>&laquo;</a></li>";
					  }else{
						echo "<li><a href='$url?pag=".($ini-1)."&periodo=$periodo'><b>&laquo;</b></a></li>";
					  }
					  for($k=1; $k <= $total; $k++){
						if($ini == $k){
							echo "<li class='active'><a href='#'><b>".$k."</b></a></li>";
						}else{
							echo "<li><a href='$url?pag=$k&periodo=$periodo'>".$k."</a></li>";
						}
					  }
					  if($ini == $total){
						echo"<li><a href='#'>&raquo;</a></li>";
					  }else{
						 echo "<li><a href='$url?pag=".($ini+1)."&periodo=$periodo'><b>&raquo;
						</b></a></li>";
					  }
					  echo"<li><a href='$url?pag=t&periodo=$periodo'>Todos</a></li>";
					  ?>
					</ul>
					<?php
				}else {
				?>
					<div class="jumbotron center-block">
					<h1 class='alert alert-danger'>No se le ha asignado intensidad horaria</h1>
					</div>
				<?php

				}
			}else{
			?>
				<div class="jumbotron center-block">
				<h1 class='alert alert-danger'>Sistema Cerrado</h1>
				<p><a class='btn btn-lg btn-success' href='../index.php' role='button'>Ir al inicio</a></p>
				</div>
			<?php
			}
		}
		$conx->close_conex();
			?>
		</div>
    <!-- Librería jQuery requerida por los plugins de JavaScript -->
    <script src="../../js/jquery.js"></script>
	<script>
		function generarsintesis(id, idaula){
			$(document).ready(function(){
				periodo=$("#periodo").val();
				aniolectivo=$("#aniolectivo").val();
				location.href = "generarsintesis.php?id="+id+"&idaula="+idaula+
				"&aniolectivo="+aniolectivo+"&periodo="+periodo;
			});
		}
		$("#periodo").change(function (){
			periodo=$("#periodo").val();
			aniolectivo=$("#aniolectivo").val();
			location.href="<?php echo basename($_SERVER ["PHP_SELF"]);?>?periodo="+periodo+"&aniolectivo="+aniolectivo;
		});
		$("#aniolectivo").change(function (){
			periodo=$("#periodo").val();
			aniolectivo=$("#aniolectivo").val();
			location.href="<?php echo basename($_SERVER ["PHP_SELF"]);?>?periodo="+periodo+"&aniolectivo="+aniolectivo;
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
