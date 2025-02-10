<?php
session_start();
include('../../class/MySqlClass.php');
include("../../class/ultimatemysql/mysql.class.php");
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
        <title><?php echo $ie; ?> - RENDIMIENTO ACADEMICO POR COMPETENCIAS</title>
        <meta http-equiv="Content-Type" content="text/html; " charset="utf-8"/>
        <meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content=""/>
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
		<link rel="stylesheet" href="../../css/form.css" type="text/css" media="screen"/>
		<link rel="stylesheet" href="../../css/bootstrap.min.css" type="text/css" media="screen"/>
		<script type="text/javascript" src="../../script/jquery.min.js"></script>
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
		
		if (! $conx3->Open($bd, $dominio, $usuario, $pass)) {
			$conx3->Kill();
		}
 		$look=false;
		if (isset($_SESSION['k_username'])) {
			$conx2 = new ConxMySQL($dominio,$usuario,$pass,$bd);
			$sql2 = "SELECT idusuario, apellido1, nombre1, tipousuario FROM usuario, docente 
			WHERE idusuario='".$_SESSION['k_username']."' and iddocente=idusuario and (tipousuario='D' OR tipousuario='A')";
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
			$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
			$sqlanio = "SELECT * FROM appconfig  WHERE item = 'aniolect'";
			$consultanio = $conx->query($sqlanio);    
			$recordsanio = $conx->records_array($consultanio);
			$aniolectivo=$recordsanio['valor'];
		?>
			<div class= "container-fluid">
				<div class="panel panel-primary">
				  <div class="panel-heading">Modifique los campos para obtener resultados....</div>
				  <div class="panel-body">
					<form class="form-inline" role="form" method="POST" action="ccrendacacompetencias.php">
					  <div class="form-group">
						<label class="sr-only" for="aniolectivo">Año lectivo</label>
						<select class="form-control" id="aniolectivo" name="aniolectivo" placeholder="Seleccione el aÃ±o lectivo">
							<option value="">Año lectivo</option>
							<?php
							for($i=$aniolectivo; $i>1990; $i--){
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
							if ($conx3->QueryArray($sql)) {
								$conx3->MoveFirst();
								while (! $conx3->EndOfSeek()) {
									$row3 = $conx3->Row();
									echo "<option value='".$row3->idaula."'>".
									utf8_encode($row3->descripcion)."-G".$row3->grupo."-".
									$row3->jornada."</option>";
									
								}
									
							} else {
								echo "<option value='null'>No se han creado grados</option>";
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
							if ($conx3->QueryArray($sql)) {
								$conx3->MoveFirst();
								while (! $conx3->EndOfSeek()) {
									$row3 = $conx3->Row();
									echo "<option value='".$row3->grado."'>".
									utf8_encode($row3->descripcion)."</option>";
									
								}
									
							} else {
								echo "<option value='null'>No se han creado grados</option>";
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
							if ($conx3->QueryArray($sql)) {
								$conx3->MoveFirst();
								while (! $conx3->EndOfSeek()) {
									$row3 = $conx3->Row();
									echo "<option value='".$row3->idmateria."'>".
									utf8_encode($row3->nombre_materia)."</option>";
									
								}
									
							} else {
								echo "<option value='null'>No se han creado asignaturas</option>";
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
					<a href="../../administrador/index.php"><span class="glyphicon glyphicon-chevron-left"></span>Regresar</a>
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
						<thead><tr><th>Estandares</th><th title="">Competencias</th><th title=""># Estudiantes que asimilan Competencia</th>
						<th title=""># Estudiantes con dificultades en en la competencia</th></tr></thead>	
						<?php
						if(isset($_POST['periodo'])){ $periodo=$_POST['periodo'];}else{$periodo=1;}
						if(isset($_POST['idaula'])){ $idaula=$_POST['idaula'];}else{$idaula="";}
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
							default: $periodotxt="1er corte Semestre 1"; $periodo=1; break;
						}
						if($idaula!=""){
							$sqlaula = "SELECT DISTINCT aula.* FROM aula WHERE idaula=$idaula ORDER BY grado,grupo";
							$consultaaula = $conx->query($sqlaula);
							if($recordsaula = $conx->records_array($consultaaula)){
								$nombreaula=utf8_encode($recordsaula['descripcion']." Grupo ".$recordsaula['grupo']);
							}
						}else{
							if($grado!=""){
								$sqlgrado = "SELECT DISTINCT aula.* FROM aula WHERE grado=$grado";
								$consultagrado = $conx->query($sqlgrado);
								if($recordsgrado = $conx->records_array($consultagrado)){
									$nombreaula="GRADO ".utf8_encode($recordsgrado['descripcion']);
								}
							}else{
								$nombreaula="Todos los Cursos";
							}
						}
						if($idaula!=""){
							$sqlestandarbc="SELECT DISTINCT e.codigo, e.descripcion, e.idmateria_fk, 
							m.nombre_materia, i.grado, i.aniolectivo FROM estandares e, materia m, jefearea j, 
							indicadoresboletin i, plan_curricular p  WHERE
							m.idmateria=e.idmateria_fk AND e.idmateria_fk=j.idmateria 
							AND j.iddocente=i.iddocente AND j.aniolectivo=i.aniolectivo
							AND j.idmateria=i.idmateria AND i.periodo=$periodo AND i.grado IN (SELECT a.grado FROM aula a WHERE a.idaula=$idaula) 
							AND i.idindicador=p.consecutivo AND p.estandarbc=e.codigo AND i.aniolectivo=$aniolectivo2";
						}else{
							if($grado!=""){
								$sqlestandarbc="SELECT DISTINCT e.codigo, e.descripcion, e.idmateria_fk, 
								m.nombre_materia, i.grado, i.aniolectivo FROM estandares e, materia m, jefearea j, 
								indicadoresboletin i, plan_curricular p  WHERE
								m.idmateria=e.idmateria_fk AND e.idmateria_fk=j.idmateria 
								AND j.iddocente=i.iddocente AND j.aniolectivo=i.aniolectivo
								AND j.idmateria=i.idmateria AND i.periodo=$periodo AND i.grado=$grado 
								AND i.idindicador=p.consecutivo AND p.estandarbc=e.codigo AND i.aniolectivo=$aniolectivo2";
							}else{
								$sqlestandarbc="SELECT DISTINCT e.codigo, e.descripcion, e.idmateria_fk, 
								m.nombre_materia, i.grado, i.aniolectivo FROM estandares e, materia m, jefearea j, 
								indicadoresboletin i, plan_curricular p  WHERE
								m.idmateria=e.idmateria_fk AND e.idmateria_fk=j.idmateria 
								AND j.iddocente=i.iddocente AND j.aniolectivo=i.aniolectivo
								AND j.idmateria=i.idmateria AND i.periodo=$periodo AND i.grado=0 
								AND i.idindicador=p.consecutivo AND p.estandarbc=e.codigo AND i.aniolectivo=$aniolectivo2";
							}
						}
						if($asignatura!=""){
							$sqlestandarbc.=" AND m.idmateria='$asignatura'";
						}
						$sqlestandarbc.=" ORDER BY m.idmateria";
						$consultaestandarbc = $conx->query($sqlestandarbc);
						while($recordsestandarbc = $conx->records_array($consultaestandarbc)){
								$sqlcompetencia="SELECT DISTINCT p.consecutivo, p.competencia 
								FROM estandares e, indicadoresboletin i, plan_curricular p  WHERE
								i.idmateria=".$recordsestandarbc['idmateria_fk']." AND i.periodo=$periodo 
								AND i.grado=".$recordsestandarbc['grado']." 
								AND i.idindicador=p.consecutivo AND p.estandarbc=e.codigo 
								AND i.aniolectivo=".$recordsestandarbc['aniolectivo']." ORDER BY p.consecutivo";
								$consultacompetencia = $conx->query($sqlcompetencia);
								$numcompetencia = $conx->get_numRecords($consultacompetencia);
							?>
							<tr><td rowspan='<?php echo $numcompetencia; ?>'><?php echo $recordsestandarbc['descripcion']; ?></td>
							<td rowspan='<?php echo $numcompetencia; ?>'>
							<?php
							while($recordscompetencia = $conx->records_array($consultacompetencia)){
								echo "*".$recordscompetencia['competencia'];
							}
							?>
							</td>
							<?php
							?>
							<td rowspan='<?php echo $numcompetencia; ?>'></td><td rowspan='<?php echo $numcompetencia; ?>'></td></tr>
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
			</script>
		<?php
		}
		?>
	
	</body>
</html>