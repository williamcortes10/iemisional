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
		<script>
		Highcharts.theme = {
			colors: ['#50B432', '#FF0000', '#FAAC58', '', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
			chart: {
				backgroundColor: {
					linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
					stops: [
						[0, 'rgb(255, 255, 255)'],
						[1, 'rgb(240, 240, 255)']
					]
				},
				borderWidth: 2,
				plotBackgroundColor: 'rgba(255, 255, 255, .9)',
				plotShadow: true,
				plotBorderWidth: 1
			},
			title: {
				style: {
					color: '#000',
					font: 'bold 16px "Trebuchet MS", Verdana, sans-serif'
				}
			},
			subtitle: {
				style: {
					color: '#666666',
					font: 'bold 12px "Trebuchet MS", Verdana, sans-serif'
				}
			},
			xAxis: {
				gridLineWidth: 1,
				lineColor: '#000',
				tickColor: '#000',
				labels: {
					style: {
						color: '#000',
						font: '11px Trebuchet MS, Verdana, sans-serif'
					}
				},
				title: {
					style: {
						color: '#333',
						fontWeight: 'bold',
						fontSize: '12px',
						fontFamily: 'Trebuchet MS, Verdana, sans-serif'

					}
				}
			},
			yAxis: {
				minorTickInterval: 'auto',
				lineColor: '#000',
				lineWidth: 1,
				tickWidth: 1,
				tickColor: '#000',
				labels: {
					style: {
						color: '#000',
						font: '11px Trebuchet MS, Verdana, sans-serif'
					}
				},
				title: {
					style: {
						color: '#333',
						fontWeight: 'bold',
						fontSize: '12px',
						fontFamily: 'Trebuchet MS, Verdana, sans-serif'
					}
				}
			},
			legend: {
				itemStyle: {
					font: '9pt Trebuchet MS, Verdana, sans-serif',
					color: 'black'

				},
				itemHoverStyle: {
					color: '#039'
				},
				itemHiddenStyle: {
					color: 'gray'
				}
			},
			labels: {
				style: {
					color: '#99b'
				}
			},

			navigation: {
				buttonOptions: {
					theme: {
						stroke: '#CCCCCC'
					}
				}
			}
		};

		// Apply the theme
		var highchartsOptions = Highcharts.setOptions(Highcharts.theme);
		</script>
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
			//escala de notas
			$existeescala=0;
			$sqlrc = "SELECT * FROM escala_de_calificacion WHERE aniolectivo = $aniolectivo";
			$consultarc = $conx->query($sqlrc);    
			while($recordsrc = $conx->records_array($consultarc)){

				switch($recordsrc['tipo_escala']){
					case "DS": 	$rcsmin = $recordsrc['rango_inferior'];
								$rcsmax = $recordsrc['rango_superior'];
								break;
							
					case "DA": 	$rcamin = $recordsrc['rango_inferior'];
								$rcamax = $recordsrc['rango_superior'];
								break;
					
					case "DB": 	$rcbmin = $recordsrc['rango_inferior'];
								$rcbmax = $recordsrc['rango_superior'];
								break;
					case "D-": 	$rcbamin = $recordsrc['rango_inferior'];
								$rcbamax = $recordsrc['rango_superior'];
								break;
					default: break;
				}
			}
		?>
			<div class= "container-fluid">
				<div class="panel panel-primary">
				  <div class="panel-heading">Modifique los campos para obtener resultados....</div>
				  <div class="panel-body">
					<form class="form-inline" role="form" method="POST" action="aprobados_reprobados.php">
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
						<label class="sr-only" for="nivel">Agrupar datos</label>
						<select  class="form-control" id='nivel' name='nivel'>";
							<option value=''>Agrupar datos</option>
							<option value='2'>Separar datos</option>
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
						<thead><tr><th>Grados/Cursos</th><th title="">Aprobados</th><th title="">Reprobados</th>
						<th title="">Recuperan</th></tr></thead>	
						<?php
						if(isset($_POST['periodo'])){ $periodo=$_POST['periodo'];}else{$periodo=1;}
						if(isset($_POST['idaula'])){ $idaula=$_POST['idaula'];}else{$idaula="";}
						if(isset($_POST['grado'])){ $grado=$_POST['grado'];}else{$grado="";}
						if(isset($_POST['resultados'])){
							if($_POST['resultados']!="num" and $_POST['resultados']!=""){
								$resultados=$_POST['resultados'];
							}else{
								$resultados="";
							}
						}else{$resultados="";}
						if(isset($_POST['aniolectivo'])){ $aniolectivo2=$_POST['aniolectivo'];}else{$aniolectivo2=$aniolectivo;}
						if($aniolectivo2==""){$aniolectivo2=$aniolectivo;}
						$auxperiodo=$periodo;
						if($periodo=='F' and $aniolectivo2>2016){
							if($aniolectivo2==2020){
								switch($periodo){
									case 1: $periodotxt="1er Trimestre"; break;
									case 2: $periodotxt="2do Trimestre"; break;
									case 3: $periodotxt="3er Trimestre"; break;
									case 'F': $periodotxt="Informe Final"; $periodo=2; break;
									default: $periodotxt="1er Trimestre"; $periodo=1; break;
								}
							}else{
								switch($periodo){
									case 1: $periodotxt="1er Trimestre"; break;
									case 2: $periodotxt="2do Trimestre"; break;
									case 3: $periodotxt="3er Trimestre"; break;
									case 'F': $periodotxt="Informe Final"; $periodo=3; break;
									default: $periodotxt="1er Trimestre"; $periodo=1; break;
								}
							}
						}else{
							if($aniolectivo2>2016){
								switch($periodo){
									case 1: $periodotxt="1er Trimestre"; break;
									case 2: $periodotxt="2do Trimestre"; break;
									case 3: $periodotxt="3er Trimestre"; break;
									case 's1': $periodotxt=" Hasta el 2do trimestre"; $periodo=2;  break;
									case 's3': $periodotxt=" Final Trimestral";  $periodo=3; break;
									default: $periodotxt="1er Trimestre"; $periodo=1; break;
								}
							}else{
								switch($periodo){
									case 1: $periodotxt="1er corte Semestre 1"; break;
									case 2: $periodotxt="2do corte Semestre 1"; break;
									case 3: $periodotxt="1er corte Semestre 2"; break;
									case 4: $periodotxt="2do corte Semestre 2"; break;
									default: $periodotxt="1er corte Semestre 1"; $periodo=1; break;
								}
							}
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
									$nombreaula="Todos los Cursos";
							}
						}
						
						if($idaula!=""){
							$sqlaulaid = "SELECT DISTINCT
							  a.idaula,
							  a.descripcion,
							  a.grupo,
							  a.jornada,
							  a.grado
							FROM matricula m
							  INNER JOIN notas n
								ON m.idestudiante = n.idestudiante AND m.aniolectivo = n.aniolectivo AND m.tipo_matricula = n.tipo_nota
							  INNER JOIN aula a
								ON m.idaula = a.idaula AND a.idaula='$idaula'
							WHERE n.periodo = '$periodo' AND m.tipo_matricula = 'R' AND m.aniolectivo = '$aniolectivo2'";
								/*$sqlaulaid = "SELECT DISTINCT a.idaula, a.descripcion, a.grupo, a.jornada, a.grado 
								FROM matricula m ,notas n, aula a 
								WHERE m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo AND a.idaula='$idaula' 
								AND n.periodo=$periodo AND m.tipo_matricula='R' AND m.tipo_matricula=n.tipo_nota
								AND m.aniolectivo=$aniolectivo2";*/
								
						}else{
							if($grado!=""){
								
								$sqlaulaid= "SELECT DISTINCT
								  a.idaula,
								  a.descripcion,
								  a.grado
								FROM matricula m
								  INNER JOIN notas n
									ON m.idestudiante = n.idestudiante AND m.aniolectivo = n.aniolectivo AND m.tipo_matricula = n.tipo_nota
									AND m.aniolectivo = $aniolectivo2 AND m.tipo_matricula = 'R' AND n.periodo = $periodo
								  INNER JOIN aula a
									ON a.idaula = m.idaula AND a.grado='$grado'";
								/*$sqlaulaid = "SELECT DISTINCT a.idaula, a.descripcion, a.grado 
								FROM matricula m ,notas n, aula a 
								WHERE m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo 
								AND a.idaula IN (SELECT a2.idaula FROM aula a2 WHERE a2.grado='$grado')
								AND n.periodo=$periodo AND m.tipo_matricula='R' AND m.tipo_matricula=n.tipo_nota
								AND m.aniolectivo=$aniolectivo2";*/
								
							}else{
								$sqlaulaid = "SELECT DISTINCT
								  a.idaula,
								  a.descripcion,
								  a.grupo,
								  a.jornada,
								  a.grado
								FROM matricula m
								  INNER JOIN notas n
									ON m.idestudiante = n.idestudiante AND m.aniolectivo = n.aniolectivo AND m.tipo_matricula = n.tipo_nota
								  INNER JOIN aula a
									ON m.idaula = a.idaula
								WHERE n.periodo = '$periodo' AND m.tipo_matricula = 'R' AND m.aniolectivo = '$aniolectivo2'";
								/*$sqlaulaid = "SELECT DISTINCT a.idaula, a.descripcion, a.grupo, a.jornada, a.grado 
								FROM matricula m ,notas n, aula a 
								WHERE m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo
								AND n.periodo=$periodo AND m.tipo_matricula='R' AND m.tipo_matricula=n.tipo_nota
								AND m.aniolectivo=$aniolectivo2";*/
							}
						}
						$sqlaulaid.=" ORDER BY a.grado, a.grupo";
						
						if($grado!=""){
							$sqlaulaid.=" LIMIT 1";
							
						}
						//die ($sqlaulaid);
						$consultaaulaid = $conx->query($sqlaulaid);
						//$desempenos= array('APROBADOS','REPROBADOS','RECUPERAN');
						$bandidaula=0;
						while($recordsaulaid = $conx->records_array($consultaaulaid)){
							if($grado!=""){
								$idaula="";
									$nombreaula="GRADO ".($recordsgrado['descripcion']);
								
							}else{
								if($idaula==""){
									if($grado=="" or $nivel==""){
										$idaula=$recordsaulaid['idaula'];
										$bandidaula=1;
									}
									$nombreaula=ucfirst(strtolower($recordsaulaid['descripcion']))."-G".
									$recordsaulaid['grupo']."-".$recordsaulaid['jornada'];
									$grado2=$recordsaulaid['grado'];							
								}else{
									$idaula=$recordsaulaid['idaula'];
									$nombreaula=ucfirst(strtolower($recordsaulaid['descripcion']))."-G".
									$recordsaulaid['grupo']."-".$recordsaulaid['jornada'];
								}
							}
							
							if($idaula!=""){
									$sqlest ="SELECT DISTINCT
									  e.apellido1,
									  e.apellido2,
									  e.nombre1,
									  e.nombre2,
									  m.idaula,
									  e.idestudiante
									FROM matricula m
									  INNER JOIN notas n
										ON m.idestudiante = n.idestudiante AND m.tipo_matricula = n.tipo_nota AND m.aniolectivo = n.aniolectivo
										AND m.periodo = '0' AND m.aniolectivo = $aniolectivo2 AND m.tipo_matricula = 'R' AND m.idaula = '$idaula' AND n.periodo = $periodo
									  INNER JOIN estudiante e
										ON n.idestudiante = e.idestudiante AND e.habilitado = 'S'
									ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";
									
									/*$sqlest = "SELECT DISTINCT e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula, e.idestudiante 
									FROM estudiante e, notas n, matricula m 
									WHERE e.idestudiante=n.idestudiante AND m.idestudiante=n.idestudiante
									AND m.idaula='$idaula' AND e.habilitado='S' 
									AND n.periodo=$periodo AND m.periodo='0' 
									AND n.aniolectivo=$aniolectivo2 AND m.aniolectivo=n.aniolectivo
									AND m.tipo_matricula='R' AND n.tipo_nota=m.tipo_matricula
									ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";*/
								}else{
									if($grado!=""){
										$sqlest ="SELECT DISTINCT
										  e.apellido1,
										  e.apellido2,
										  e.nombre1,
										  e.nombre2,
										  m.idaula,
										  e.idestudiante
										FROM matricula m
										  INNER JOIN notas n
											ON m.idestudiante = n.idestudiante AND m.tipo_matricula = n.tipo_nota AND m.aniolectivo = n.aniolectivo
											AND m.periodo = '0' AND m.aniolectivo = $aniolectivo2 AND m.tipo_matricula = 'R' AND n.periodo = $periodo
										  INNER JOIN estudiante e
											ON n.idestudiante = e.idestudiante AND e.habilitado = 'S'
										  INNER JOIN aula
											ON aula.idaula = m.idaula AND aula.grado = '$grado'
										ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";
										
										/*$sqlest = "SELECT DISTINCT e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula, e.idestudiante 
										FROM estudiante e, notas n, matricula m 
										WHERE e.idestudiante=n.idestudiante AND m.idestudiante=n.idestudiante
										AND m.idaula IN  (SELECT a2.idaula FROM aula a2 WHERE a2.grado='$grado') AND e.habilitado='S' 
										AND n.periodo=$periodo AND m.periodo='0' 
										AND n.aniolectivo=$aniolectivo2 AND m.aniolectivo=n.aniolectivo
										AND m.tipo_matricula='R' AND n.tipo_nota=m.tipo_matricula
										ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";*/
									}else{
										
										$sqlest ="SELECT DISTINCT
										  e.apellido1,
										  e.apellido2,
										  e.nombre1,
										  e.nombre2,
										  m.idaula,
										  e.idestudiante
										FROM matricula m
										  INNER JOIN notas n
											ON m.idestudiante = n.idestudiante AND m.tipo_matricula = n.tipo_nota AND m.aniolectivo = n.aniolectivo
											AND m.periodo = '0' AND m.aniolectivo = $aniolectivo2 AND m.tipo_matricula = 'R' AND n.periodo = $periodo
										  INNER JOIN estudiante e
											ON n.idestudiante = e.idestudiante AND e.habilitado = 'S'
										  INNER JOIN aula
											ON aula.idaula = m.idaula AND aula.grado = '$grado'
										ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";
										
										/*$sqlest = "SELECT DISTINCT e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula, e.idestudiante 
										FROM estudiante e, notas n, matricula m 
										WHERE e.idestudiante=n.idestudiante AND m.idestudiante=n.idestudiante
										AND m.idaula IN  (SELECT a2.idaula FROM aula a2 WHERE a2.grado='$grado2') AND e.habilitado='S' 
										AND n.periodo=$periodo AND m.periodo='0' 
										AND n.aniolectivo=$aniolectivo2 AND m.aniolectivo=n.aniolectivo
										AND m.tipo_matricula='R' AND n.tipo_nota=m.tipo_matricula
										ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";*/
									}
								}
								//die ($sqlest);
								$consultaest = $conx->query($sqlest);
								$numest = $conx->get_numRecords($consultaest);
								?>
								<tr><td><?php echo ($nombreaula)." ($numest)";?></td>
								<?php
								$aprobados=0;
								$reprobados=0;
								$recuperan=0;
								while($records1 = $conx->records_array($consultaest)){
									if($auxperiodo=="F" and ($aniolectivo2>2016 and $aniolectivo2!=2020)){
										$materiasperdidas=0;
										$sql_area_asignatura="SELECT DISTINCT a.idmateria, ar.idarea, ar.nomarea, a.nombre_materia, n.idestudiante, ROUND( SUM( n.vn )/$periodo , 1 ) AS Nota_Final, n.periodo, n.aniolectivo FROM clase c 
										JOIN materia a ON c.idmateria=a.idmateria AND c.idmateria!=49 AND c.aniolectivo='$aniolectivo2' AND c.idaula='".$records1['idaula']."'
										JOIN notas n ON a.idmateria=n.idmateria AND n.periodo<=$periodo AND n.tipo_nota='R' AND n.aniolectivo=c.aniolectivo AND n.idestudiante='".$records1['idestudiante']."'
										JOIN matricula m ON m.idestudiante=n.idestudiante AND n.tipo_nota=m.tipo_matricula AND n.aniolectivo=m.aniolectivo AND m.idaula=c.idaula
										JOIN area ar ON ar.idarea=a.idarea_fk
										GROUP BY n.idestudiante, n.idmateria ORDER BY ar.nomarea, a.nombre_materia  DESC";
										$consulta_area_asignatura = $conx->query($sql_area_asignatura);
										$id_area="";
										
										while($recordsarea = $conx->records_array($consulta_area_asignatura)){
											if($periodo<4){
												$vnSuma=0;
												$sql_notas="SELECT notas.vn, notas.periodo FROM notas WHERE notas.idestudiante='".$records1['idestudiante']."' 
												AND notas.idmateria='".$recordsarea['idmateria']."' AND notas.tipo_nota='R' AND notas.aniolectivo=$aniolectivo2 
												AND notas.periodo<=$periodo ORDER BY notas.periodo";
												$consulta_notas = $conx->query($sql_notas);
												$numperiodos=0;
												while($fila_notas = $conx->records_array($consulta_notas)){
													$numperiodos++;
													//$promedio_asignatura+=$fila_notas['vn'];
													$sqlrecordNV = "SELECT notas.vn, notas.periodo FROM notas WHERE notas.idestudiante='".$records1['idestudiante']."' 
													AND notas.idmateria='".$recordsarea['idmateria']."' AND notas.tipo_nota='N' AND notas.aniolectivo=$aniolectivo2 
													AND notas.periodo=".$fila_notas['periodo']." ORDER BY notas.periodo";
													$consultarecordNV = $conx->query($sqlrecordNV);
													if($recordsperiodoNV = $conx->records_array($consultarecordNV)){
														if(number_format((float)$recordsperiodoNV['vn'],1,".",",") > number_format((float)$fila_notas['vn'],1,".",",") ){
															$vnSuma+=number_format((float)$recordsperiodoNV['vn'],1,".",",");
														}
													}else{
														$vnSuma+=number_format((float)$fila_notas['vn'],1,".",",");
													}
												}
												$promedioFinal=number_format((float)($vnSuma/$numperiodos),1,".",",");
												$vnSuma=0;
												if($promedioFinal >= (float)$rcbamin and $promedioFinal <= (float)$rcbamax){
													$materiasperdidas++;
												}
											}
										}
										
										if($materiasperdidas>0 and $materiasperdidas <3){
											$recuperan++;		
										}elseif($materiasperdidas>2){
											$reprobados++;
										}elseif($materiasperdidas==0){
											$aprobados++;
										}
											
									}else if ($auxperiodo=="F" and $aniolectivo2==2020){
										$materiasperdidas=0;
										$sql_area_asignatura="SELECT DISTINCT a.idmateria, ar.idarea, ar.nomarea, a.nombre_materia, n.idestudiante,  ROUND(AVG(n.vn), 3) AS Nota_Final, n.periodo, n.aniolectivo FROM clase c 
										JOIN materia a ON c.idmateria=a.idmateria AND c.idmateria!=49 AND c.aniolectivo='$aniolectivo2' AND c.idaula='".$records1['idaula']."'
										JOIN notas n ON a.idmateria=n.idmateria AND n.periodo<=$periodo AND n.tipo_nota='R' AND n.aniolectivo=c.aniolectivo AND n.idestudiante='".$records1['idestudiante']."'
										JOIN matricula m ON m.idestudiante=n.idestudiante AND n.tipo_nota=m.tipo_matricula AND n.aniolectivo=m.aniolectivo AND m.idaula=c.idaula
										JOIN area ar ON ar.idarea=a.idarea_fk
										GROUP BY n.idestudiante, n.idmateria ORDER BY ar.nomarea, a.nombre_materia  DESC";
										$consulta_area_asignatura = $conx->query($sql_area_asignatura);
										$id_area="";
										
										while($recordsarea = $conx->records_array($consulta_area_asignatura)){
											if($periodo<4){
												$vnSuma=0;
												$sql_notas="SELECT notas.vn, notas.periodo FROM notas WHERE notas.idestudiante='".$records1['idestudiante']."' 
												AND notas.idmateria='".$recordsarea['idmateria']."' AND notas.tipo_nota='R' AND notas.aniolectivo=$aniolectivo2 
												AND notas.periodo<=$periodo ORDER BY notas.periodo";
												$consulta_notas = $conx->query($sql_notas);
												$numperiodos=0;
												while($fila_notas = $conx->records_array($consulta_notas)){
													$numperiodos++;
													//$promedio_asignatura+=$fila_notas['vn'];
													$sqlrecordNV = "SELECT notas.vn, notas.periodo FROM notas WHERE notas.idestudiante='".$records1['idestudiante']."' 
													AND notas.idmateria='".$recordsarea['idmateria']."' AND notas.tipo_nota='N' AND notas.aniolectivo=$aniolectivo2 
													AND notas.periodo=".$fila_notas['periodo']." ORDER BY notas.periodo";
													$consultarecordNV = $conx->query($sqlrecordNV);
													if($recordsperiodoNV = $conx->records_array($consultarecordNV)){
														if(number_format((float)$recordsperiodoNV['vn'],1,".",",") > number_format((float)$fila_notas['vn'],1,".",",") ){
															$vnSuma+=number_format((float)$recordsperiodoNV['vn'],1,".",",");
														}
													}else{
														$vnSuma+=number_format((float)$fila_notas['vn'],1,".",",");
													}
												}
												$promedioFinal=number_format((float)($vnSuma/$numperiodos),1,".",",");
												$vnSuma=0;
												if($promedioFinal >= (float)$rcbamin and $promedioFinal <= (float)$rcbamax){
													$materiasperdidas++;
												}
											}
										}
										
										if($materiasperdidas>0 and $materiasperdidas <3){
											$recuperan++;		
										}elseif($materiasperdidas>2){
											$reprobados++;
										}elseif($materiasperdidas==0){
											$aprobados++;
										}
											
									}else{
										/*$sql="SELECT count(*) AS cantidad FROM notas n, escala_de_calificacion sc 
										WHERE sc.aniolectivo=n.aniolectivo AND n.idestudiante='".$records1['idestudiante']."'
										AND n.periodo=$periodo AND n.tipo_nota='R' 
										AND n.aniolectivo=$aniolectivo2
										AND (n.vn >=sc.rango_inferior AND n.vn<=sc.rango_superior) 
										AND sc.tipo_escala='D-' GROUP BY n.idestudiante";*/
										$materiasperdidas=0;
										$sql_area_asignatura="SELECT DISTINCT a.idmateria, ar.idarea, ar.nomarea, a.nombre_materia, n.idestudiante, ROUND(AVG(n.vn), 2) AS Nota_Final, n.periodo, n.aniolectivo FROM clase c 
										JOIN materia a ON c.idmateria=a.idmateria AND c.idmateria!=49 AND c.aniolectivo='$aniolectivo2' AND c.idaula='".$records1['idaula']."'
										JOIN notas n ON a.idmateria=n.idmateria AND n.periodo<=$periodo AND n.tipo_nota='R' AND n.aniolectivo=c.aniolectivo AND n.idestudiante='".$records1['idestudiante']."'
										JOIN matricula m ON m.idestudiante=n.idestudiante AND n.tipo_nota=m.tipo_matricula AND n.aniolectivo=m.aniolectivo AND m.idaula=c.idaula
										JOIN area ar ON ar.idarea=a.idarea_fk
										GROUP BY n.idestudiante, n.idmateria ORDER BY ar.nomarea, a.nombre_materia  DESC";
										$consulta_area_asignatura = $conx->query($sql_area_asignatura);
										$id_area="";
										while($recordsarea = $conx->records_array($consulta_area_asignatura)){
											if(number_format((float)$recordsarea['Nota_Final'],1,".",",") >= (float)$rcbamin and number_format((float)$recordsarea['Nota_Final'],1,".",",") <= (float)$rcbamax){
												$materiasperdidas++;
											}
										}
										if($materiasperdidas>0 and $materiasperdidas <3){
											$recuperan++;		
										}elseif($materiasperdidas>2){
											$reprobados++;
										}elseif($materiasperdidas==0){
											$aprobados++;
										}
									}
									
								}
								if($resultados=="%"){
									$aprobados=number_format(($aprobados*100)/$numest,2);
									$reprobados=number_format(($reprobados*100)/$numest,2);
									$recuperan=number_format(($recuperan*100)/$numest,2);
								}
								?>
								<td><?php echo $aprobados ;?></td><td><?php echo $reprobados ;?></td><td><?php echo $recuperan ;?></td>
								<?php

								
						}
						?>
							</tr>
						</table>
						<?php 
						if($idaula=="" and $grado==""){
							
								$nombreaula="Todos los Cursos";
						}else{
							if($bandidaula==1){ $nombreaula="Todos los Cursos";}
						}?>
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
							text: '<br/>Estudiantes Aprobados, Reprobados y Recuperando | <?php echo ($nombreaula); ?> | <?php echo $periodotxt; ?><br/> Año lectivo <?php echo $aniolectivo2; ?>'
						},
						xAxis: {
							allowDecimals: false,
							title: {
								text: 'Grados/Cursos'
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
							$('#exportar').attr('download', 'RendimientoAca<?php echo $nombreaula?>.xls');
						}

					});
				});
			</script>
		<?php
		}
		?>
	
	</body>
</html>