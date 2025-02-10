<?php
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
include("../../class/puesto.php");
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$id = trim($_POST['id_']);
$periodo = $_POST['periodo_'];
$idmateria = $_POST['idmateria_'];
$idaula = $_POST['idaula_'];
$iddocente = $_POST['iddocente_'];
$aniolectivo = $_POST['aniolectivo_'];
$grado = $_POST['grado_'];
//escala de notas
$existeescala=0;
$sqlrc = "SELECT * FROM escala_de_calificacion WHERE aniolectivo = $aniolectivo";
$consultarc = $conx->query($sqlrc); 

//Recuperamos el numero de decimales configurados para el año lectivo
$sql = "SELECT numero_decimales from redondeo_decimal where anio_lectivo=$aniolectivo LIMIT 1";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$numero_decimales = $records['numero_decimales'];
if(empty($numero_decimales)){
	$numero_decimales = 1;
}
$totalasignaturas=numero_asignaturas_salon($idaula, $aniolectivo);

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

//area
$sqlarea ="SELECT idarea_fk  FROM materia WHERE idmateria = '$idmateria' limit 1";
$qarea = $conx->query($sqlarea);
$rowarea = $conx->records_array($qarea);
$area=$rowarea['idarea_fk'];
$vn = (float)str_replace(",",".",$_POST['vn']);
$fj = $_POST['fj'];
$fsj = $_POST['fsj'];
$obs = $_POST['obs'];
$reg=0;

// $sqlduplicate="SELECT DISTINCT e.idestudiante, e.nombre1, e.nombre2, e.apellido1, e.apellido2 FROM estudiante e 
// WHERE e.idestudiante='$id' AND e.idestudiante NOT IN (SELECT n.idestudiante FROM notas n WHERE n.aniolectivo=$aniolectivo 
// AND n.tipo_nota='R' AND n.periodo='$periodo' AND n.idmateria='$idmateria') ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
$sqlduplicate="SELECT e.idestudiante, e.nombre1, e.nombre2, e.apellido1, e.apellido2
FROM estudiante e
LEFT JOIN notas n ON e.idestudiante = n.idestudiante 
    AND n.aniolectivo = $aniolectivo 
    AND n.tipo_nota = 'R' 
    AND n.periodo = '$periodo' 
    AND n.idmateria = '$idmateria'
WHERE e.idestudiante = '$id' 
AND n.idestudiante IS NULL";
$consultaduplicate = $conx->query($sqlduplicate);
if($row = $conx->records_array($consultaduplicate)){
	if($fj==""){
		$fj=0;
	}
	if($fsj==""){
		$fsj=0;
	}

	if($obs!=""){
		$sql= "INSERT INTO  notas(idestudiante, periodo, vn, fj, fsj, observaciones, tipo_nota, aniolectivo, idmateria)
		VALUES ('$id',  '$periodo',  '$vn', '$fj' , '$fsj' ,  '$obs' ,  'R',  '$aniolectivo',  '$idmateria')";
	}else{
		$sql= "INSERT INTO  notas(idestudiante, periodo, vn, fj, fsj, observaciones, tipo_nota, aniolectivo, idmateria)
		VALUES ('$id',  '$periodo',  '$vn', '$fj' , '$fsj' ,  NULL ,  'R',  '$aniolectivo',  '$idmateria')";
	}
	$consulta = $conx->query($sql);
	if($aniolectivo<2016){
		$sqlind2= "SELECT DISTINCT eb.* 
		FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
		(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
		and pc.estandarbc=ebc.codigo
		and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
		and eb.periodo =$periodo and eb.iddocente ='$iddocente' and eb.grado ='$grado'
		and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
		ORDER BY consecutivo DESC";
	}else{
		$sqlind2= "SELECT DISTINCT eb.* 
		FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
		(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
		and pc.estandarbc=ebc.codigo
		and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
		and eb.periodo =$periodo and eb.grado ='$grado'
		and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
		ORDER BY consecutivo DESC";
	}
	$consultaind2 = $conx->query($sqlind2);
	while ($rowind2= $conx->records_array($consultaind2)) {
		$consecutivo=$rowind2['idindicador'];
		if($vn>=$rcsmin && $vn<=$rcsmax){
			$nivel_aprendizaje=$rowind2['DS'];
		}else if($vn>=$rcamin && $vn<=$rcamax){
			$nivel_aprendizaje=$rowind2['DA'];
		}else if($vn>=$rcbmin && $vn<=$rcbmax){
			$nivel_aprendizaje=$rowind2['DB'];
		}else if($vn>=$rcbamin && $vn<=$rcbamax){
			$nivel_aprendizaje=$rowind2['DBA'];
		}
		$sqlindinsert = "INSERT INTO indicadoresestudiante (idindicador, idestudiante, aniolectivo, periodo,nivel_aprendizaje, idmateria) 
						 VALUES ('$consecutivo', '$id', '$aniolectivo', '$periodo','$nivel_aprendizaje','$idmateria')";
		$consultaindinsert = $conx->query($sqlindinsert);
		if(!$consultaindinsert){
			$sql= "UPDATE indicadoresestudiante SET nivel_aprendizaje='$nivel_aprendizaje' 
			WHERE idestudiante='$id' AND aniolectivo=$aniolectivo
			AND periodo=$periodo AND idmateria=$idmateria AND idindicador=$consecutivo";
			$consulta = $conx->query($sql);
		}	
	
	}
}else{
	if($fj==""){
		$fj=0;
	}
	if($fsj==""){
		$fsj=0;
	}
	
	if($obs!=""){
		$sql= "UPDATE notas SET vn=$vn, fj=$fj, fsj=$fsj, observaciones='$obs' 
		WHERE idestudiante='$id' AND aniolectivo=$aniolectivo AND tipo_nota='R' 
		AND periodo=$periodo AND idmateria=$idmateria";
	}else{
		$sql= "UPDATE notas SET vn=$vn, fj=$fj, fsj=$fsj, observaciones=NULL 
		WHERE idestudiante='$id' AND aniolectivo=$aniolectivo AND tipo_nota='R' 
		AND periodo=$periodo AND idmateria=$idmateria";
	}
	$consulta = $conx->query($sql);
	// Llamar al procedimiento almacenado
	$sql = "CALL ConsultarNotasJson($totalasignaturas, $numero_decimales, $aniolectivo, $idaula, $periodo, '', $id);";
	//$consulta = $conx2->query($sql);
	$resultado = mysqli_query($conx->conexion, $sql);

	if($aniolectivo<2016){
		$sqlind2= "SELECT DISTINCT eb.* 
		FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
		(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
		and pc.estandarbc=ebc.codigo
		and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
		and eb.periodo =$periodo and eb.iddocente ='$iddocente' and eb.grado ='$grado'
		and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
		ORDER BY consecutivo DESC";
	}else{
		$sqlind2= "SELECT DISTINCT eb.* 
		FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
		(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
		and pc.estandarbc=ebc.codigo
		and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
		and eb.periodo =$periodo and eb.grado ='$grado'
		and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
		ORDER BY consecutivo DESC";
	}
	$consultaind2 = $conx->query($sqlind2);
	while ($rowind2= $conx->records_array($consultaind2)) {
		$consecutivo=$rowind2['idindicador'];
		if($vn>=$rcsmin && $vn<=$rcsmax){
			$nivel_aprendizaje=$rowind2['DS'];
		}else if($vn>=$rcamin && $vn<=$rcamax){
			$nivel_aprendizaje=$rowind2['DA'];
		}else if($vn>=$rcbmin && $vn<=$rcbmax){
			$nivel_aprendizaje=$rowind2['DB'];
		}else if($vn>=$rcbamin && $vn<=$rcbamax){
			$nivel_aprendizaje=$rowind2['DBA'];
		}
		$sqlindinsert = "INSERT INTO indicadoresestudiante (idindicador, idestudiante, aniolectivo, periodo,nivel_aprendizaje, idmateria) 
						 VALUES ('$consecutivo', '$id', '$aniolectivo', '$periodo','$nivel_aprendizaje','$idmateria')";
		$consultaindinsert = $conx->query($sqlindinsert);
		if(!$consultaindinsert){
			$sql= "UPDATE indicadoresestudiante SET nivel_aprendizaje='$nivel_aprendizaje' 
			WHERE idestudiante='$id' AND aniolectivo=$aniolectivo
			AND periodo=$periodo AND idmateria=$idmateria AND idindicador=$consecutivo";
			$consulta = $conx->query($sql);
		}	
	}
}	
$conx->close_conex();
?>