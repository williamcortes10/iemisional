<?php
session_start();
include('../../class/puesto.php');
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
$p=$_POST["periodo"];
$al=$_POST["aniolect"];
$aniolectivo=$al;
$idaula = $_POST['aula'];
$periodo= $_POST['periodo'];
$aniolect= $_POST['aniolect'];
$tpuser= $_POST['tpuser'];
$sql = "SELECT num_periodos, tipo_periodo FROM periodos_por_anio WHERE anio = '$aniolect'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$num_periodos = $records['num_periodos'];
$periodo=$num_periodos;

//aula
$sqlaaula = "SELECT descripcion, idaula, grado, grupo, jornada FROM aula WHERE idaula = $idaula";
$consultaaula = $conx->query($sqlaaula);    
$recordsaula = $conx->records_array($consultaaula);
if($recordsaula['jornada']=="M"){
	$jornada="MAÑANA";
}else{
	$jornada="TARDE";
}
$grado2=($recordsaula['descripcion'])."-".$recordsaula['grupo']."-".$jornada;
$grado=$recordsaula['grado'];
$idaula=$recordsaula['idaula'];
//aula
$sqlaaula = "SELECT descripcion, idaula, grado FROM aula WHERE idaula = $idaula";
$consultaaula = $conx->query($sqlaaula);    
$recordsaula = $conx->records_array($consultaaula);
$grado=$recordsaula['descripcion'];
$grado_int=$recordsaula['grado'];
$idaula=$recordsaula['idaula'];

?>
<html>
<head>
<title><?php echo $ie."-PROMEDIOS GRADO $grado2-PERIODO $p - $al"; ?></title>
<link  href="http://fonts.googleapis.com/css?family=Cabin+Sketch:bold" rel="stylesheet" type="text/css" >
<link  href="http://fonts.googleapis.com/css?family=Lobster:regular" rel="stylesheet" type="text/css" >
<link  href="http://fonts.googleapis.com/css?family=Tangerine:regular,bold" rel="stylesheet" type="text/css" >

<link rel="stylesheet" type="text/css" href="../../css/boletin.css" media="print, screen">
</head>
<body>
<div>
	<?php

	//escala de notas
	$existeescala=0;
	$sqlrc = "SELECT * FROM escala_de_calificacion WHERE aniolectivo = $aniolect";
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
		$existeescala=1;
	}

	$look=false;
	if (isset($_SESSION['k_username'])) {
		$conx2 = new ConxMySQL($dominio,$usuario,$pass,$bd);
		$sql2 = "SELECT idusuario, apellido1, nombre1, tipousuario FROM usuario, docente 
		WHERE idusuario='".$_SESSION['k_username']."' and iddocente=idusuario and (tipousuario='D' OR tipousuario='A' OR tipousuario='S')";
		$consulta2 = $conx2->query($sql2);
		if($conx2->get_numRecords($consulta2)>0){
			$records2 = $conx2->records_array($consulta2);
			$look=true;
			
		}
	}else{
		echo "<div class='form'>
				<div id='stylized' class='myform'><h3 align='center' style='color:black'>Debes Loguearte</h3><br/>";
		echo "<span align='center'><a href='../index.php' align='center'>Regresar</a></span></div></div>";
	}		
	$sqlest = "SELECT e.nombre1, e.nombre2, e.apellido1, e.apellido2, e.idestudiante FROM estudiante e
			LEFT JOIN  matricula m ON m.idestudiante=e.idestudiante 
			WHERE m.idaula='$idaula' AND m.aniolectivo=$aniolect AND m.tipo_matricula='R' AND e.habilitado='S' AND m.periodo='0'
			ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
				
	$reporte=" AÑO LECTIVO ".$aniolect;
	echo "<br/><table class='resultadoasig'><th colspan='3'>INFORME DE ESTUDIANTES APROBADOS Y REPROBADOS  GRADO $grado2 <br/> $reporte</th><tr><td><b>ESTUDIANTE</td><td><b>ESTADO</td><td><b>ASIGNATURAS REPROBADAS</td></tr>";
	$consulta1 = $conx->query($sqlest);
	while($records1 = $conx->records_array($consulta1)){
		echo "
		<tr >
			<td colspan='' class='fonttitle7'   style='width:45%'>".($records1['nombre1'])." ".($records1['nombre2'])." ".($records1['apellido1'])." ".($records1['apellido2']);
		echo "</td>";                
		//VERIFICAR ESTADO DE ASIGNATURAS
		$materiasperdidas=0;
		$sql_area_asignatura="SELECT DISTINCT m.abreviatura, m.idmateria, m.idarea_fk, m.nombre_materia FROM materia m
								LEFT JOIN clase c ON c.idmateria=m.idmateria 
								WHERE c.idaula = '$idaula' AND c.aniolectivo = '$aniolect'
								ORDER BY c.idmateria ASC;";
		$consulta_area_asignatura = $conx->query($sql_area_asignatura);
		$id_area="";
		$asignaturas="";
		while($recordsarea = $conx->records_array($consulta_area_asignatura)){
			$area=$recordsarea['idarea_fk'];
			$idestudiante=$records1['idestudiante'];
			$idmateria=$recordsarea['idmateria'];
			if ($p=="s1"){
				$nota=promedioParcialMateria($idestudiante, $idaula, $aniolect, $idmateria,2);
				$sqlrecordNV = "SELECT notas.vn, notas.periodo FROM notas WHERE notas.idestudiante='$idestudiante' 
				AND notas.idmateria='$idmateria' AND notas.tipo_nota='N' AND notas.aniolectivo=$aniolect 
				AND notas.periodo=2 ORDER BY notas.periodo";
				$consultarecordNV = $conx->query($sqlrecordNV);
				if($recordsperiodoNV = $conx->records_array($consultarecordNV)){
					if(number_format((float)$recordsperiodoNV['vn'],1,".",",") > number_format((float)$nota,1,".",",") ){
						$nota=number_format((float)$recordsperiodoNV['vn'],1,".",",");
					}
				}
				$promedioFinal=$nota;
				if($promedioFinal >= (float)$rcbamin and $promedioFinal <= (float)$rcbamax){
					$materiasperdidas++;
					$asignaturas.=$recordsarea['nombre_materia']." - ";
				}
				
			}else{
				$nota=promedioAnioSemMateria($idestudiante, $idaula, $aniolect, $idmateria);
				$sqlrecordNV = "SELECT notas.vn, notas.periodo FROM notas WHERE notas.idestudiante='$idestudiante' 
				AND notas.idmateria='$idmateria' AND notas.tipo_nota='N' AND notas.aniolectivo=$aniolect 
				AND notas.periodo=7 ORDER BY notas.periodo";
				$consultarecordNV = $conx->query($sqlrecordNV);
				if($recordsperiodoNV = $conx->records_array($consultarecordNV)){
					if(number_format((float)$recordsperiodoNV['vn'],1,".",",") > number_format((float)$nota,1,".",",") ){
						$nota=number_format((float)$recordsperiodoNV['vn'],1,".",",");
					}
				}
				$promedioFinal=$nota;
				if($promedioFinal >= (float)$rcbamin and $promedioFinal <= (float)$rcbamax){
					$materiasperdidas++;
					$asignaturas.=$recordsarea['nombre_materia']." - ";
				}
			}
		}
		if($materiasperdidas>0 and $materiasperdidas <3){
			$estadoP="RECUPERA";		
		}elseif($materiasperdidas>2){
			$estadoP="REPROBADO";
		}elseif($materiasperdidas==0){
			$estadoP="APROBADO";
		}
		echo "<td> $estadoP</td><td>".($asignaturas)."</td>";
			echo "</tr>";
	}
		
	echo "</table>";
	if($tpuser=='A'){
		?>
		<a href="../../administrador/index.php"><span class="glyphicon glyphicon-chevron-left"></span>Regresar</a>
		<?php
	}elseif($tpuser=='C'){
		?>
		<a href="../../coordinador/index.php"><span class="glyphicon glyphicon-chevron-left"></span>Regresar</a>
		<?php
	}
				   
	$conx->close_conex();
	?>
</body>
</html>