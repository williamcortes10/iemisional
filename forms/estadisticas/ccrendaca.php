<?php
//Datos de Configuración de la app
session_start();
include("../../class/ultimatemysql/mysql.class.php");
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$sql = "SELECT valor FROM appconfig WHERE item='ie'";
$consulta = $conx->query($sql);
$records = $conx->records_array($consulta);
$ie= $records['valor'];
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title><?php echo $ie; ?> - RENDIMIENTO ACADEMICO POR DESEMPEÑOS</title>
        <meta http-equiv="Content-Type" content="text/html; " charset="utf-8"/>
        <meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content=""/>
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
		<link rel="stylesheet" href="../../css/form.css" type="text/css" media="screen"/>
		<link rel="stylesheet" href="../../css/bootstrap.min.css" type="text/css" media="screen"/>
		<script type="text/javascript" src="../../script/jquery-3.1.1.min.js"></script>
		<script src="../../js/jquery.table2excel.js"></script>
		<script src="../../js/bootstrap.min.js"></script>
		<script src="../../js/hc/js/highcharts.js"></script>
		<script src="../../js/hc/js/themes/grid.js"></script>
		<script src="../../js/hc/js/modules/data.js"></script>
		<script src="../../js/hc/js/modules/exporting.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			$("#aniolectdiv").show();
			$("#printer").click(function(event) {
				$("#aniolectdiv").hide();
			
			});
		});
		</script>
	</head>

    <body>
	<?php
		
		
 		$look=false;
		if (isset($_SESSION['k_username'])) {
			$conx2 = new ConxMySQL($dominio,$usuario,$pass,$bd);
			$sql2 = "SELECT idusuario, apellido1, nombre1, tipousuario FROM usuario, docente 
			WHERE idusuario='".$_SESSION['k_username']."' and iddocente=idusuario and (tipousuario='A' OR tipousuario='C')";
			$consulta2 = $conx2->query($sql2);
			if($conx2->get_numRecords($consulta2)>0){
				$records2 = $conx2->records_array($consulta2);
				$look=true;
				
			}
		}else{
			echo "<div class='form'>
					<div id='stylized' class='myform'><h3 align='center' style='color:black'>Debes Loguearte</h3><br/>";
			echo "<span align='center'><a href='../../index.php' align='center'>Regresar</a></span></div></div>";
		}
		if($look){
			$sqlanio = "SELECT * FROM appconfig  WHERE item = 'aniolect'";
			$consultanio = $conx->query($sqlanio);    
			$recordsanio = $conx->records_array($consultanio);
			$aniolectivo=$recordsanio['valor'];
		?>
			
			<div class= "container-fluid">
				<div class="panel panel-primary">
				  <div class="panel-heading">Modifique los campos para obtener resultados...
					<div class="progress progress-striped ">
					  <div class="progress-bar progress-bar-info" role="progressbar" id="myprogressbar"
						   aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"
						   style="width: 0%">0% completado
					  </div>
					</div>
				  </div>
				  <div class="panel-body">
					<form class="form-inline" role="form" method="POST" action="ccrendaca.php">
					  <div class="form-group">
						<label class="sr-only" for="aniolectivo">Año lectivo</label>
						<select class="form-control" id="aniolectivo" name="aniolectivo" placeholder="Seleccione el aÃ±o lectivo">
							<option value="">Año lectivo</option>
							<?php
							for($i=$aniolectivo+1; $i>1990; $i--){
								if($i==$aniolectivo){
									echo "<option value='".$i."'>".$i."</option>";
								}else{
									echo "<option value='".$i."' >".$i."</option>";
								}
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label class="sr-only" for="idaula">Curso</label>
						<select  class="form-control" id='idaula' name='idaula'>";
							<option value=''>Curso</option>
							<?php
							$sql = "SELECT DISTINCT aula.* FROM aula ORDER BY grado,grupo";
							$consulta = $conx->query($sql);    
							while($recordscurso = $conx->records_array($consulta)){
								echo "<option value='".$recordscurso['idaula']."'>".($recordscurso['descripcion']."-G".$recordscurso['grupo']."-".
								$recordscurso['jornada'])."</option>";
							}
							
							?>
						</select>
					</div>
					<div class="form-group">
						<label class="sr-only" for="grado">Grado</label>
						<select  class="form-control" id='grado' name='grado'>";
							<option value=''>Grado</option>
							<?php
							$sql = "SELECT DISTINCT descripcion, grado  FROM aula";
							$consulta = $conx->query($sql);    
							while($recordsgrado = $conx->records_array($consulta)){
								echo "<option value='".$recordsgrado['grado']."'>".($recordsgrado['descripcion'])."</option>";
							}
							
							?>
						</select>
					</div>
					
					<div class="form-group">
						<label class="sr-only" for="asignatura">Asignatura</label>
						<select  class="form-control" id='asignatura' name='asignatura'>";
							<option value=''>Asignatura</option>
							<?php
							$sql = "SELECT DISTINCT mt.nombre_materia,mt.idmateria 
									FROM notas n, materia mt 
									WHERE mt.idmateria=n.idmateria ORDER BY n.idmateria";
							$consulta = $conx->query($sql);    
							while($recordsasignatura = $conx->records_array($consulta)){
								echo "<option value='".$recordsasignatura['idmateria']."'>".($recordsasignatura['nombre_materia'])."</option>";
							}		
							
							?>
						</select>
					</div>
					<div class="form-group">
						<label class="sr-only" for="periodo">Periodo</label>
						<select  class="form-control" id='periodo' name='periodo'>
							<option value=''>Periodo</option>
							<?php
							for($i=1; $i<5; $i++)
							{
								echo "<option value='".$i."'>".$i."</option>";
							}
							?>
							<option value='s1'>Primer semestre</option>
							<option value='s2'>Segundo semestre</option>
							<option value='s3'>Final Trimestral</option>
							<option value='F'>Final</option>
						</select>
					</div>
					<div class="form-group">
						<label class="sr-only" for="grafico">Gráfico</label>
						<select  class="form-control" id='grafico' name='grafico'>
							<option value=''>Tipo de gráfico</option>
							<option value='column'>Columnas</option>
							<option value='columnstack'>Columnas Apiladas</option>
							<option value='bar'>Barras</option>
							<option value='barstack'>Barras Apliladas</option>
							<option value='pie'>Pastel</option>
							<option value='line'>Lineas</option>
						</select>
					</div>
					<div class="form-group">
						<label class="sr-only" for="resultados">Resultados</label>
						<select  class="form-control" id='resultados' name='resultados'>
							<option value=''>Resultados en..</option>
							<option value='num'>Cantidades</option>
							<option value='%'>Porcentajes</option>
						</select>
					</div>
					<button type="submit" class="btn btn-primary" id="ver">
						<span class="glyphicon glyphicon-search"></span> Ver estadistica
					</button>
					<?php
					if($records2['tipousuario']=='A'){
						?>
						<a href="../../administrador/index.php"><span class="glyphicon glyphicon-chevron-left"></span>Regresar</a>
						<?php
					}elseif($records2['tipousuario']=='C'){
						?>
						<a href="../../coordinador/index.php"><span class="glyphicon glyphicon-chevron-left"></span>Regresar</a>
						<?php
					}
					?>
					
					</form>
				  </div>
				</div>
			
			</div>
			<div class="container-fluid">
				<div class="panel panel-default">
				  <div class="panel-body">
					<div id="grafica">
					</div>
					<div class="table-responsive" id="data">
					<table id="datatable" class="table table-hover">
						<thead><tr><th>Asignaturas</th><th title="Desempeño Superior">DS</th><th title="Desempeño Alto">DA</th>
						<th title="Desempeño Básico">DB</th><th title="Desempeño Bajo">Db</th></tr></thead>	
						<?php
						if(isset($_POST['periodo'])){ $periodo=$_POST['periodo'];}else{$periodo=1;}
						if(isset($_POST['idaula'])){ $idaula=$_POST['idaula'];}else{$idaula=1;}
						if(isset($_POST['grado'])){ $grado=$_POST['grado'];}else{$grado="";}
						if(isset($_POST['asignatura'])){ $asignatura=$_POST['asignatura'];}else{$asignatura="";}
						if(isset($_POST['resultados'])){
							if($_POST['resultados']!="num" and $_POST['resultados']!=""){
								$resultados=$_POST['resultados'];
							}else{
								$resultados="";
							}
						}else{$resultados="";}
						if(isset($_POST['aniolectivo'])){ $aniolectivo2=$_POST['aniolectivo'];}else{$aniolectivo2=$aniolectivo;}
						if($aniolectivo2==""){$aniolectivo2=$aniolectivo;}
						
						switch($periodo){
							case 1: $periodotxt="1er corte Semestre 1"; break;
							case 2: $periodotxt="2do corte Semestre 1"; break;
							case 3: $periodotxt="1er corte Semestre 2"; break;
							case 4: $periodotxt="2do corte Semestre 2"; break;
							case 's1': $periodotxt=" Hasta el 2do trimestre";  break;
							case 's3': $periodotxt=" Final Trimestral";  break;
							default: $periodotxt="1er corte Semestre 1"; $periodo=1; break;
						}
						if($idaula!=""){
							$sqlaula = "SELECT DISTINCT aula.* FROM aula WHERE idaula=$idaula ORDER BY grado,grupo";
							$consultaaula = $conx->query($sqlaula);
							if($recordsaula = $conx->records_array($consultaaula)){
								$nombreaula=($recordsaula['descripcion']." Grupo ".$recordsaula['grupo']);
							}
						}else{
							if($grado!=""){
								$sqlgrado = "SELECT DISTINCT aula.* FROM aula WHERE grado=$grado";
								$consultagrado = $conx->query($sqlgrado);
								if($recordsgrado = $conx->records_array($consultagrado)){
									$nombreaula="GRADO ".($recordsgrado['descripcion']);
								}
							}else{
								
							}
						}
						if($idaula!=""){
							switch($periodo){
								case 1:
								case 2:
								case 3:
								case 4:
										$sqlasig = "SELECT DISTINCT mt.nombre_materia,mt.idmateria 
										FROM matricula m ,notas n, materia mt 
										WHERE m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo 
										AND n.periodo=$periodo AND m.idaula=$idaula AND m.tipo_matricula='R' AND m.tipo_matricula=n.tipo_nota
										AND m.aniolectivo=$aniolectivo2 AND mt.idmateria=n.idmateria";
										break;
								case 's1':
										$sqlasig = "SELECT DISTINCT mt.nombre_materia,mt.idmateria 
										FROM matricula m ,notas n, materia mt 
										WHERE m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo 
										AND n.periodo=2 AND m.idaula=$idaula AND m.tipo_matricula='R' AND m.tipo_matricula=n.tipo_nota
										AND m.aniolectivo=$aniolectivo2 AND mt.idmateria=n.idmateria";
										break;
								case 's3':
										$sqlasig = "SELECT DISTINCT mt.nombre_materia,mt.idmateria 
										FROM matricula m ,notas n, materia mt 
										WHERE m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo 
										AND n.periodo=3 AND m.idaula=$idaula AND m.tipo_matricula='R' AND m.tipo_matricula=n.tipo_nota
										AND m.aniolectivo=$aniolectivo2 AND mt.idmateria=n.idmateria";
										
										break;
								default: break;
							}
							
							
						}else{
							if($grado!=""){
								switch($periodo){
									case 1:
									case 2:
									case 3:
									case 4:
											$sqlasig = "SELECT DISTINCT mt.nombre_materia,mt.idmateria 
											FROM matricula m ,notas n, materia mt 
											WHERE m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo 
											AND m.idaula IN (SELECT a.idaula FROM aula a WHERE a.grado='$grado')
											AND n.periodo=$periodo AND m.tipo_matricula='R' AND m.tipo_matricula=n.tipo_nota
											AND m.aniolectivo=$aniolectivo2 AND mt.idmateria=n.idmateria";
											break;
									case 's1':
											$sqlasig = "SELECT DISTINCT mt.nombre_materia,mt.idmateria 
											FROM matricula m ,notas n, materia mt 
											WHERE m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo 
											AND m.idaula IN (SELECT a.idaula FROM aula a WHERE a.grado='$grado')
											AND n.periodo=2 AND m.tipo_matricula='R' AND m.tipo_matricula=n.tipo_nota
											AND m.aniolectivo=$aniolectivo2 AND mt.idmateria=n.idmateria";
									case 's3':
											$sqlasig = "SELECT DISTINCT mt.nombre_materia,mt.idmateria 
											FROM matricula m ,notas n, materia mt 
											WHERE m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo 
											AND m.idaula IN (SELECT a.idaula FROM aula a WHERE a.grado='$grado')
											AND n.periodo=3 AND m.tipo_matricula='R' AND m.tipo_matricula=n.tipo_nota
											AND m.aniolectivo=$aniolectivo2 AND mt.idmateria=n.idmateria";
											break;
									default: break;
								}
							
								
							}else{
								switch($periodo){
									case 1:
									case 2:
									case 3:
									case 4:
											$sqlasig = "SELECT DISTINCT mt.nombre_materia,mt.idmateria 
											FROM matricula m ,notas n, materia mt 
											WHERE m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo 
											AND n.periodo=$periodo AND m.tipo_matricula='R' AND m.tipo_matricula=n.tipo_nota
											AND m.aniolectivo=$aniolectivo2 AND mt.idmateria=n.idmateria";
											break;
									case 's1':
											$sqlasig = "SELECT DISTINCT mt.nombre_materia,mt.idmateria 
											FROM matricula m ,notas n, materia mt 
											WHERE m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo 
											AND n.periodo=2 AND m.tipo_matricula='R' AND m.tipo_matricula=n.tipo_nota
											AND m.aniolectivo=$aniolectivo2 AND mt.idmateria=n.idmateria"; break;
									case 's3':
											$sqlasig = "SELECT DISTINCT mt.nombre_materia,mt.idmateria 
											FROM matricula m ,notas n, materia mt 
											WHERE m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo 
											AND n.periodo=3 AND m.tipo_matricula='R' AND m.tipo_matricula=n.tipo_nota
											AND m.aniolectivo=$aniolectivo2 AND mt.idmateria=n.idmateria"; break;

											default: break;
								}
								
							}
						}
						if($asignatura!=""){
							$sqlasig.=" AND mt.idmateria='$asignatura'";
						}
						$sqlasig.=" ORDER BY n.idmateria";
						
						$consultaasig = $conx->query($sqlasig);
						$barra=0;
						$totalasignaturas=$conx->get_numRecords($consultaasig);
						$porcentaje_barra=100/$totalasignaturas;
						while($recordsasig = $conx->records_array($consultaasig)){
							$idmateria=$recordsasig['idmateria'];
							$nommateria=ucfirst(strtolower($recordsasig['nombre_materia']));
							$desempenos= "SELECT *
									  FROM escala_de_calificacion
									  WHERE escala_de_calificacion.aniolectivo = $aniolectivo2";
							$consultadesempeno = $conx->query($desempenos);
							?>
							<tr><td><?php echo ($nommateria)?></td>
							<?php
							switch($periodo){
								case 1:
								case 2:
								case 3:
								case 4:
										/*$sql_1="SELECT
										  escala_de_calificacion.tipo_escala,
										  COUNT(escala_de_calificacion.tipo_escala) AS cantidad
										FROM notas
										  LEFT OUTER JOIN estudiante
										  ON notas.idestudiante = estudiante.idestudiante
										  LEFT OUTER JOIN matricula
											ON notas.idestudiante = matricula.idestudiante AND notas.tipo_nota = matricula.tipo_matricula AND notas.aniolectivo = matricula.aniolectivo
										  LEFT OUTER JOIN aula
											ON matricula.idaula = aula.idaula
										  LEFT OUTER JOIN escala_de_calificacion
											ON escala_de_calificacion.aniolectivo = notas.aniolectivo
										WHERE
											matricula.tipo_matricula = 'R' AND matricula.aniolectivo = $aniolectivo2 
										AND estudiante.habilitado='S'
										AND notas.idmateria = '$idmateria' AND notas.periodo = $periodo 
										AND notas.vn BETWEEN escala_de_calificacion.rango_inferior AND escala_de_calificacion.rango_superior";*/
										$sql_1="SELECT ROUND( AVG( vn ) , 3 ) AS promedio FROM notas
												  LEFT OUTER JOIN estudiante
												  ON notas.idestudiante = estudiante.idestudiante
												  LEFT OUTER JOIN matricula
													ON notas.idestudiante = matricula.idestudiante AND notas.tipo_nota = matricula.tipo_matricula AND notas.aniolectivo = matricula.aniolectivo
												  LEFT OUTER JOIN aula
													ON matricula.idaula = aula.idaula
												  LEFT OUTER JOIN escala_de_calificacion
													ON escala_de_calificacion.aniolectivo = notas.aniolectivo
												WHERE
													matricula.tipo_matricula = 'R' AND matricula.aniolectivo = $aniolectivo2
												AND estudiante.habilitado='S'
												AND notas.idmateria = '$idmateria' AND notas.periodo = $periodo";
										$sqltotal="SELECT
										  COUNT(notas.idestudiante) AS cantidad
										FROM notas
										  LEFT OUTER JOIN estudiante
										  ON notas.idestudiante = estudiante.idestudiante
										  LEFT OUTER JOIN matricula
											ON notas.idestudiante = matricula.idestudiante AND notas.tipo_nota = matricula.tipo_matricula 
											AND notas.aniolectivo = matricula.aniolectivo 
											WHERE notas.idmateria = '$idmateria' AND notas.periodo = '$periodo' 
											AND notas.tipo_nota = 'R' AND notas.aniolectivo = $aniolectivo
											AND estudiante.habilitado='S'";
										
										break;
								case 's1':
										/*$sql_1="SELECT
										  notas.idestudiante AS cantidad, 
										  AVG(notas.vn)AS prom
										FROM notas
										  LEFT OUTER JOIN estudiante
										  ON notas.idestudiante = estudiante.idestudiante
										  LEFT OUTER JOIN matricula
											ON notas.idestudiante = matricula.idestudiante AND notas.tipo_nota = matricula.tipo_matricula AND notas.aniolectivo = matricula.aniolectivo
										  LEFT OUTER JOIN aula
											ON matricula.idaula = aula.idaula
										  LEFT OUTER JOIN escala_de_calificacion
											ON escala_de_calificacion.aniolectivo = notas.aniolectivo
										WHERE
											matricula.tipo_matricula = 'R' AND matricula.aniolectivo = $aniolectivo2 
										AND estudiante.habilitado='S'
										AND notas.idmateria = '$idmateria' AND notas.periodo <= 2 
										AND prom BETWEEN escala_de_calificacion.rango_inferior AND escala_de_calificacion.rango_superior";*/
										$sql_1="SELECT ROUND( AVG( vn ) , 3 ) AS promedio FROM notas
												  LEFT OUTER JOIN estudiante
												  ON notas.idestudiante = estudiante.idestudiante
												  LEFT OUTER JOIN matricula
													ON notas.idestudiante = matricula.idestudiante AND notas.tipo_nota = matricula.tipo_matricula AND notas.aniolectivo = matricula.aniolectivo
												  LEFT OUTER JOIN aula
													ON matricula.idaula = aula.idaula
												  LEFT OUTER JOIN escala_de_calificacion
													ON escala_de_calificacion.aniolectivo = notas.aniolectivo
												WHERE
													matricula.tipo_matricula = 'R' AND matricula.aniolectivo = $aniolectivo2
												AND estudiante.habilitado='S'
												AND notas.idmateria = '$idmateria' AND notas.periodo <= 2";
												//var_dump($sql_1);
										$sqltotal="SELECT
										  COUNT(notas.idestudiante) AS cantidad
										FROM notas
										  LEFT OUTER JOIN estudiante
										  ON notas.idestudiante = estudiante.idestudiante
										  LEFT OUTER JOIN matricula
											ON notas.idestudiante = matricula.idestudiante AND notas.tipo_nota = matricula.tipo_matricula 
											AND notas.aniolectivo = matricula.aniolectivo 
											WHERE notas.idmateria = '$idmateria' AND notas.periodo = 2 
											AND notas.tipo_nota = 'R' AND notas.aniolectivo = $aniolectivo AND estudiante.habilitado='S'";
										break;
								case 's3':
										
										$sql_1="SELECT ROUND( AVG( vn ) , 3 ) AS promedio FROM notas
												  LEFT OUTER JOIN estudiante
												  ON notas.idestudiante = estudiante.idestudiante
												  LEFT OUTER JOIN matricula
													ON notas.idestudiante = matricula.idestudiante AND notas.tipo_nota = matricula.tipo_matricula AND notas.aniolectivo = matricula.aniolectivo
												  LEFT OUTER JOIN aula
													ON matricula.idaula = aula.idaula
												  LEFT OUTER JOIN escala_de_calificacion
													ON escala_de_calificacion.aniolectivo = notas.aniolectivo
												WHERE
													matricula.tipo_matricula = 'R' AND matricula.aniolectivo = $aniolectivo2
												AND estudiante.habilitado='S'
												AND notas.idmateria = '$idmateria' AND notas.periodo <= 3";
										$sqltotal="SELECT
										  COUNT(notas.idestudiante) AS cantidad
										FROM notas
										  LEFT OUTER JOIN estudiante
										  ON notas.idestudiante = estudiante.idestudiante
										  LEFT OUTER JOIN matricula
											ON notas.idestudiante = matricula.idestudiante AND notas.tipo_nota = matricula.tipo_matricula 
											AND notas.aniolectivo = matricula.aniolectivo 
											WHERE notas.idmateria = '$idmateria' AND notas.periodo = 3 
											AND notas.tipo_nota = 'R' AND notas.aniolectivo = $aniolectivo AND estudiante.habilitado='S'";
										break;
								default: break;
							}
							
							while($recordDesempeno = $conx->records_array($consultadesempeno)){
								$sql=$sql_1;
								if($idaula!=""){
									/*$sql="SELECT count(*) AS cantidad, n.idmateria, sc.tipo_escala FROM matricula m ,notas n, escala_de_calificacion sc 
									WHERE m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo 
									AND n.periodo=$periodo AND m.idaula=$idaula AND m.tipo_matricula='R' AND m.tipo_matricula=n.tipo_nota
									AND m.aniolectivo=$aniolectivo2 AND sc.aniolectivo=m.aniolectivo AND n.idmateria='$idmateria'
									AND (n.vn >=sc.rango_inferior AND n.vn<=sc.rango_superior)";*/
									$sql.=" AND matricula.idaula=$idaula";
									$sqltotal.=" AND matricula.idaula=$idaula";
									
								}else{
									if($grado!=""){
										/*$sql="SELECT count(*) AS cantidad, n.idmateria, sc.tipo_escala FROM matricula m ,notas n, escala_de_calificacion sc 
										WHERE m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo 
										AND m.idaula IN (SELECT a.idaula FROM aula a WHERE a.grado='$grado')
										AND n.periodo=$periodo AND m.tipo_matricula='R' AND m.tipo_matricula=n.tipo_nota
										AND m.aniolectivo=$aniolectivo2 AND sc.aniolectivo=m.aniolectivo AND n.idmateria='$idmateria'
										AND (n.vn >=sc.rango_inferior AND n.vn<=sc.rango_superior)";*/
										$sql.=" AND matricula.idaula IN (SELECT a.idaula FROM aula a WHERE a.grado='$grado')";
										$sqltotal.=" LEFT OUTER JOIN aula
										ON matricula.idaula = aula.idaula AND aula.grado = '$grado'";
									}else{
										
											/*$sql="SELECT count(*) AS cantidad, n.idmateria, sc.tipo_escala FROM matricula m ,notas n, escala_de_calificacion sc 
											WHERE m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo 
											AND n.periodo=$periodo AND m.tipo_matricula='R' AND m.tipo_matricula=n.tipo_nota
											AND m.aniolectivo=$aniolectivo2 AND sc.aniolectivo=m.aniolectivo AND n.idmateria='$idmateria'
											AND (n.vn >=sc.rango_inferior AND n.vn<=sc.rango_superior)";*/
											
									}
								}
								
								//$sql.=" AND escala_de_calificacion.tipo_escala='$desempeno' GROUP BY notas.idestudiante ORDER BY notas.idmateria";
								$sql.=" GROUP BY notas.idestudiante";
								
								$consulta = $conx->query($sql);
								$cantidad=0;
								while($records = $conx->records_array($consulta)){
									if(round($records['promedio'],1)>=$recordDesempeno['rango_inferior'] 
									&& round($records['promedio'],1)<=$recordDesempeno['rango_superior']  ){
										$cantidad++;
									}
									
								}
								?>
								
								<?php
								
								if($cantidad!=0){
									?><td><?php 
									if($resultados=="%"){
										$consultatotal = $conx->query($sqltotal);
										if($recordstotal = $conx->records_array($consultatotal)){
											$total=$recordstotal['cantidad'];
										}else{
											$total=0;
										}
										if($total==0){
											$porcentaje=0;
										}else{
											$porcentaje=number_format(($cantidad*100)/$total,2);
										}
										echo $porcentaje;
									}else{
										echo $cantidad;
									}?></td><?php
								}else{
									?>
									<td>0</td>
									<?php
								}
							}
							$barra+=$porcentaje_barra;
							?>
							<script>$('#myprogressbar').css('width',"<?php echo $barra;?>%");</script>
							<script>$('#myprogressbar').html("<?php echo $barra;?>% completado");</script>
							</tr>
							<?php
						}
						?>
					</table>
					
					<a class="btn btn-success" id="exportar" href="#">Exportar Excel CSV</a>
					</div>
				  </div>
				</div>
			</div>
			<script>
				var chart1;
				$(document).ready(function() {
						
						var chart1 = new Highcharts.Chart({
						data: {
							table: 'datatable'
						},
						chart: {
							renderTo: 'grafica',
							type: '<?php if(isset($_POST['grafico'])){ 
							switch($_POST['grafico']){
								case 'columnstack': $grafico="column"; break;
								case 'barstack': $grafico="bar"; break;
								default: $grafico=$_POST['grafico']; break;
							}
							echo $grafico;}else{echo "";} ?>'
						},
						title: {
							text: '<?php if($asignatura!=""){
										echo utf8_encode(strtoupper($nommateria));
									}?><br/>Rendimiento academico x Desempeños | <?php echo $nombreaula; ?> | <?php echo $periodotxt; ?><br/> Año lectivo <?php echo $aniolectivo2; ?>'
						},
						xAxis: {
							allowDecimals: false,
							title: {
								text: 'Asignaturas'
							}
						},
						yAxis: {
							title: {
								text: 'Estudiantes <?php echo $resultados; ?>'
							}
						},
						plotOptions: {
							series: {
								borderWidth: 0,
								dataLabels: {
									enabled: true,
								format: '<?php if($resultados==""){ echo "{point.y:.0f}";}else{echo "{point.y:.1f}%";}?>'
								},
								<?php
									if(isset($_POST['grafico'])){
										switch($_POST['grafico']){
											case 'columnstack':
											case 'barstack': echo "stacking: 'normal'"; break;
										}
										
									}
								?>
								
							}
						},

						tooltip: {
							headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
							pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b><?php if($resultados==""){ echo "{point.y:.0f}";}else{echo "{point.y:.2f}%";}?></b> <?php
							if(isset($_POST['grafico'])){
										switch($_POST['grafico']){
											case 'columnstack':
											case 'barstack': echo "de {point.stackTotal}"; break;
										}
										
									}
							?>'
						}
					});
					$("#exportar").click(function(){
					  var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
						tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';

						tab_text = tab_text + '<x:Name>Estadistica x Desempeño</x:Name>';

						tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
						tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';

						tab_text = tab_text + "<table border='1px'>";
						tab_text = tab_text + $('#datatable').html();
						tab_text = tab_text + '</table></body></html>';

						var data_type = 'data:application/vnd.ms-excel';
						
						var ua = window.navigator.userAgent;
						var msie = ua.indexOf("MSIE ");
						
						if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
							if (window.navigator.msSaveBlob) {
								var blob = new Blob([tab_text], {
									type: "application/csv;"
								});
								navigator.msSaveBlob(blob, 'RendimientoAca<?php echo $nombreaula; ?>');
							}
						} else {
							$('#exportar').attr('href', data_type + ', ' + encodeURIComponent(tab_text));
							$('#exportar').attr('download', 'RendimientoAca<?php echo $nombreaula.$nommateria; ?>.xls');
						}

					});
				});
				
			</script>
		<?php
		}
		?>
	
	</body>
</html>