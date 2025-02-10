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
$sql = "SELECT * FROM appconfig WHERE item = 'periodo_hab'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$periodoh = $records['valor'];
//$periodoh = 1;
$periodos = $records['valor'];
$conx->close_conex();


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISTEMA ACADEMICO DE CALIFICACIONES - INGRESAR CALIFICACIONES</title>
 
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
			$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
			$sql = "SELECT idusuario, apellido1, nombre1,iddocente, tipousuario FROM usuario, docente 
			WHERE idusuario='".$_SESSION['k_username']."' and iddocente=idusuario and tipousuario='D' LIMIT 1";
			$consulta = $conx->query($sql);
			if($conx->get_numRecords($consulta)>0){
				$records = $conx->records_array($consulta);
				$user=$records['nombre1']." ".$records['apellido1']; 
				$iddocente=$records['iddocente']; 
				$tipousuario=$records['tipousuario']; 
				$look=true;
			}
			$conx->close_conex();
		}else{
		?>
			<div class="jumbotron center-block">
				<h1 class='alert alert-danger'>Debe Iniciar Sesión</h1>
				<p><a class='btn btn-lg btn-success' href='../../index.php' role='button'>Ir al inicio</a></p>
			</div>
		<?php
		}
		if($look){
			$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
			$sql = "SELECT * FROM appconfig WHERE item = 'index_docen_nt' LIMIT 1";
			$consulta = $conx->query($sql);
			$recordsM = $conx->records_array($consulta);
			if($recordsM['valor']=='on' or $tipousuario=='A')
			{
				include('../../docente/nav.php');
		?>
			
			<div class="containertable table-responsive center-block">
			<?php
				//paginación
				//include("../../class/zebra_pagination/Zebra_Pagination.php"); 
				if (isset($_GET['periodo'])){
					 $periodoh=$_GET['periodo'] ;
					 //$periodo=$periodoh;
					 
				}else{
					//$periodo=$periodoh ;
					$periodo=$periodoh ;
					
				}
				if($iddocente=="27502480"){
					$periodoh=1;	
				}
				//$periodo=$periodoh ;
				//-----------------------------------------
				$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
				$sql = "SELECT c.iddocente, m.idmateria, m.nombre_materia, c.aniolectivo, a.idaula, a.descripcion, a.grupo
				FROM clase c, docente d, materia m, aula a
				WHERE d.iddocente='$iddocente' AND c.iddocente=d.iddocente 
				AND c.idmateria=m.idmateria AND c.aniolectivo='$aniolectivo' AND c.idaula=a.idaula AND c.periodos LIKE '%".$periodoh."%' ORDER BY a.grado,a.grupo";
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
					?>
					<br/>
					<div class="form-group form-inline">
					<label for="periodo">Periodo:</label>
					<select id='periodo' name='periodo' class="form-control">
					<?php 
					if($tipousuario=='A'){
						for($i=1; $i<5; $i++){ if($periodo==$i){echo "<option value='$i' selected>$i °</option>"; }else{echo "<option value='$i'>$i °</option>";}}
					}else{
						// //for($i=1; $i==$periodoh; $i++){ 
						// if($periodoh==$i){echo "<option value='$i' selected>$i °</option>"; }else{echo "<option value='$i'>$i °</option>";}}
						echo "<option value='$periodoh' selected>$periodoh °</option>";
					} ?>
					</select>
					<label for="aniolectivo">Año lectivo</label>
					<input input class="form-control" type='text' id='aniolectivo' name='aniolectivo' value='<?php echo $aniolectivo; ?>' disabled/>
					</div>
					<?php
					$sql = "SELECT DISTINCT c.iddocente, m.idmateria, m.nombre_materia, c.aniolectivo, a.idaula, a.descripcion, a.grupo
					FROM clase c, docente d, materia m, aula a
					WHERE d.iddocente='$iddocente' AND c.iddocente=d.iddocente 
					AND c.idmateria=m.idmateria AND c.aniolectivo='$aniolectivo' AND c.idaula=a.idaula AND c.periodos LIKE '%".$periodoh."%' ORDER BY a.grado,a.grupo
					LIMIT $init, $limit_end";
					$consulta = $conx->query($sql);
					echo "<h3 style='text-align:center;'>INGRESAR CALIFICACIONES</h3><hr/>";
					echo "<h3 style='text-align:center;'>INTENSIDAD HORARIA AÑO LECTIVO $aniolectivo</h3>";
					echo "<table class='table table-hover' style='text-align:left;'>";
					echo "<thead>";
					echo "<tr>";
					echo "<th>Asignatura</th>";
					echo "<th>Curso</th>";
					echo "<th></th>";
					echo"</tr>";
					echo "</thead>";
					echo "<tbody>";
					while ($row = $conx->records_array($consulta)) {
						$id = $row['iddocente'];
						$idaula = $row['idaula'];
						$idmateria= $row['idmateria'];
						echo "<tr>";
						echo "<td>".($row['nombre_materia'])."</td>";
						echo "<td>".($row['descripcion'])."-GRUPO ".$row['grupo']."</td>";
						echo "<td><a class='btn btn-primary' href='calificacionesxestudiante.php?id=$id&idmateria=$idmateria&idaula=$idaula&aniolectivo=$aniolectivo&periodo=$periodoh'><span>Listar estudiantes</span></a></td>";
						echo "</tr>";
					}
					echo "</tbody>";
					echo "</table>";
					?>
					<ul class="pagination">
					  <?php 
					  echo "<li><a href='$url?pag=r&periodo=$periodo''>Reiniciar</a></li>";
					  if(($ini-1) == 0){
						echo "<li><a href='#'>&laquo;</a></li>";
					  }else{
						echo "<li><a href='$url?pag=".($ini-1)."&periodo=$periodo''><b>&laquo;</b></a></li>";
					  }
					  for($k=1; $k <= $total; $k++){
						if($ini == $k){
							echo "<li class='active'><a href='#'><b>".$k."</b></a></li>";
						}else{
							echo "<li><a href='$url?pag=$k&periodo=$periodo''>".$k."</a></li>";
						}
					  }
					  if($ini == $total){
						echo"<li><a href='#'>&raquo;</a></li>";
					  }else{
						 echo "<li><a href='$url?pag=".($ini+1)."&periodo=$periodo''><b>&raquo;
						</b></a></li>";
					  }
					  echo"<li><a href='$url?pag=t&periodo=$periodo''>Todos</a></li>";
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
				<h1 class='alert alert-danger'>El ingreso de calificaciones está cerrado. <br/> Comuníquese con el administrador</h1>
				<p><a class='btn btn-lg btn-success' href='../../docente/index.php' role='button'>Volver a la página anterior</a></p>
				</div>
			<?php
			}
			
		}
		$conx->close_conex();
			?>
		</div>
    <!-- Librería jQuery requerida por los plugins de JavaScript -->
    <script src="../../js/jquery.js"></script>
 
    <!-- Todos los plugins JavaScript de Bootstrap (también puedes
         incluir archivos JavaScript individuales de los únicos
         plugins que utilices) -->
    <script src="../../js/bootstrap.min.js"></script>
	<script>
			
		$(document).ready(function(){
			$("#periodo").change(function (){
				periodo=$("#periodo").val();
				location.href="<?php echo basename($_SERVER ["PHP_SELF"]);?>?periodo="+periodo;
			});
				
		});

	</script>
	 <hr>
	<div class='container center-block'>
		<footer>
			<p>&copy; williamcortes10@gmail.com 2015</p>
		</footer>
	</div>
  </body>
</html>
