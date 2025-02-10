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
        <title><?php echo $ie; ?> - ESTUDIANTES APROBADOS | REPROBADOS | RECUPERAN</title>
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
			WHERE idusuario='".$_SESSION['k_username']."' and iddocente=idusuario and (tipousuario='D' OR tipousuario='A' OR tipousuario='C' OR tipousuario='S')";
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
					<form class="form-inline" role="form" method="POST" action="aprobados_reprobados_recuperan.php">
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
					<table id="estadistica" class="table table-hover">
						<thead><tr><th>Grado_Grupo</th><th>Total Alumnos</th><th title="">Aprobados</th><th title="">Reprobados</th>
						<th title="">Recuperan</th></tr></thead>
						<?php
						if(!empty($_POST['aniolectivo'])){
							$aniolectivo=$_POST['aniolectivo'];
						}
						$sql="SELECT COUNT(matricula.idestudiante) AS total_estudiantes, 
							   CONCAT(aula.descripcion, '-Grupo_', aula.grupo) AS salon, aula.idaula
							   FROM aula
								  INNER JOIN matricula
									ON aula.idaula = matricula.idaula
								WHERE matricula.aniolectivo = 2016 AND matricula.periodo = 0
								GROUP BY aula.idaula,
										 aula.grupo
								ORDER BY aula.grado, aula.grupo";
						$salones = $conx->query($sql);
						while($query_result = $conx->records_array($salones)){
							$materias_perdidas=0;
							$total_aprobados=0;
							$total_reprobados=0;
							$total_recuperan=0;
							$conxtmp = new ConxMySQL($dominio,$usuario,$pass,$bd);
							$sqltmp='DROP VIEW IF EXISTS notas_semestrales;';
							$consultatmp1 = $conxtmp->query($sqltmp);
							$sqltmp="CREATE VIEW notas_semestrales AS (SELECT
									  notas.idestudiante,
									  notas.idmateria,
									  1 AS semestre,
									  ROUND(AVG(notas.vn), 2) AS promedio,
									  notas.aniolectivo
									FROM matricula
									  INNER JOIN notas
										ON matricula.idestudiante = notas.idestudiante AND matricula.aniolectivo = notas.aniolectivo
									WHERE matricula.periodo = 0 AND matricula.tipo_matricula = 'R' AND matricula.aniolectivo = $aniolectivo AND matricula.idaula = ".$query_result['idaula']." AND 
									  (notas.periodo >= 1 AND notas.periodo<=2)
									GROUP BY notas.idestudiante,
											 notas.idmateria) UNION (SELECT
									  notas.idestudiante,
									  notas.idmateria,
									  2 AS semestre,
									  ROUND(AVG(notas.vn), 2) AS promedio,
									  notas.aniolectivo
									FROM matricula
									  INNER JOIN notas
										ON matricula.idestudiante = notas.idestudiante AND matricula.aniolectivo = notas.aniolectivo
									WHERE matricula.periodo = 0 AND matricula.tipo_matricula = 'R' AND matricula.aniolectivo = $aniolectivo AND matricula.idaula = ".$query_result['idaula']." AND 
									  (notas.periodo >= 3 AND notas.periodo<=4)
									GROUP BY notas.idestudiante,
											 notas.idmateria);";
							$consultatmp2 = $conxtmp->query($sqltmp);
							$sqltmp="DROP VIEW IF EXISTS notas_finales;";
							$consultatmp3 = $conxtmp->query($sqltmp);
							$sqltmp="CREATE VIEW notas_finales AS SELECT
									  notas_semestrales.idestudiante,
									  notas_semestrales.idmateria,
									  ROUND(AVG(notas_semestrales.promedio), 1) AS promedio,
									  notas_semestrales.aniolectivo
									FROM notas_semestrales
									WHERE notas_semestrales.aniolectivo = $aniolectivo
									GROUP BY notas_semestrales.idestudiante,
											 notas_semestrales.idmateria;";
							$consultatmp4 = $conxtmp->query($sqltmp);
							$sqltmp="SELECT idestudiante, COUNT(idmateria) AS cant_materias FROM 
							notas_finales  WHERE promedio<3 GROUP BY idestudiante HAVING (cant_materias>0 AND cant_materias<3)";
							$consultatmp8=$conxtmp->query($sqltmp);
							$total_recuperan = $conxtmp->get_numRecords($consultatmp8);
							$sqltmp="SELECT idestudiante, COUNT(idmateria) AS cant_materias FROM 
							notas_finales  WHERE promedio<3 GROUP BY idestudiante HAVING (cant_materias>=3)";
							$consultatmp9=$conxtmp->query($sqltmp);
							$total_reprobados= $conxtmp->get_numRecords($consultatmp9);
							$total_aprobados=$query_result['total_estudiantes']-($total_recuperan+$total_reprobados);
							$sqltmp="DROP VIEW IF EXISTS notas_finales;";
							$consultatmp10=$conxtmp->query($sqltmp);
							$sqltmp="DROP VIEW IF EXISTS notas_semestrales;";
							$consultatmp11=$conxtmp->query($sqltmp);
							$conxtmp->close_conex();
							?>
							<tr>
								<td><?php echo utf8_encode($query_result['salon']);?></td><td><?php echo $query_result['total_estudiantes'];?></td><td><?php echo $total_aprobados; ?></td><td><?php echo $total_reprobados; ?></td><td><?php echo $total_recuperan; ?></td>
							</tr>
						<?php
							
						}
						?>
						</table>
					</div>
				  </div>
				</div>
			</div>
			
				
		<?php
		}
		?>
	
	</body>
</html>