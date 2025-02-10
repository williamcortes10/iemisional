<?php
include("../../class/ultimatemysql/mysql.class.php");
include("../../class/MySqlClass.php");
$conx = new ConxMySQL("localhost","root","","appacademy");
$id = $_POST['id'];
$periodo = $_POST['periodo'];
$idmateria = $_POST['idmateria'];
$idaula = $_POST['idaula'];
$iddocente = $_POST['iddocente'];
$aniolectivo = $_POST['aniolectivo'];
$grado = $_POST['grado'];
//area
$sqlarea ="SELECT idarea_fk  FROM materia WHERE idmateria = '$idmateria'";
$qarea = $conx->query($sqlarea);
$rowarea = $conx->records_array($qarea);
$area=$rowarea['idarea_fk'];
$vn = (float)str_replace(",",".",$_POST['vn'.trim($id)]);
$fj = $_POST['fj'.trim($id)];
$fsj = $_POST['fsj'.trim($id)];
$obs = $_POST['obs'.trim($id)];
$reg=0;
$sqlduplicate="SELECT DISTINCT e.idestudiante, e.nombre1, e.nombre2, e.apellido1, e.apellido2 FROM estudiante e 
WHERE e.idestudiante='$id' AND e.idestudiante NOT IN (SELECT n.idestudiante FROM notas n WHERE n.aniolectivo=$aniolectivo 
AND n.tipo_nota='R' AND n.periodo='$periodo' AND n.idmateria='$idmateria') ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
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
	/*$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
				pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
				FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
				(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
				and pc.estandarbc=ebc.codigo
				and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
				and eb.periodo =$periodo and eb.iddocente =$iddocente and eb.grado ='$grado'
				and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
				ORDER BY consecutivo DESC";*/
	if($aniolectivo<2016){
		$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
		pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
		FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
		(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
		and pc.estandarbc=ebc.codigo
		and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
		and eb.periodo =$periodo and eb.iddocente =$iddocente and eb.grado ='$grado'
		and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
		ORDER BY consecutivo DESC";
	}else{
		$sqlind= "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
		pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
		FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
		(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
		and pc.estandarbc=ebc.codigo
		and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
		and eb.periodo =$periodo and eb.grado ='$grado'
		and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
		ORDER BY consecutivo DESC";
	}
	$consultaind = $conx->query($sqlind);
	while ($rowind = $conx->records_array($consultaind)) {
		$consecutivo=$rowind['consecutivo'];
		if(!empty($_POST['ci'.trim($id).'-'.$consecutivo])){
			$nivel_aprendizaje=$_POST['ci'.trim($id).'-'.$consecutivo];
			$sqlindinsert = "INSERT INTO indicadoresestudiante (idindicador, idestudiante, aniolectivo, periodo,nivel_aprendizaje, idmateria) 
			VALUES ('$consecutivo', '$id', '$aniolectivo', '$periodo','$nivel_aprendizaje','$idmateria')";
			$consultaindinsert = $conx->query($sqlindinsert);
		}
	}
	echo "<div class='alert alert-success' role='alert'>Calificación guardada</div>";
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
	
	if($aniolectivo<2016){
		$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
		pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
		FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
		(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
		and pc.estandarbc=ebc.codigo
		and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
		and eb.periodo =$periodo and eb.iddocente =$iddocente and eb.grado ='$grado'
		and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
		ORDER BY consecutivo DESC";
	}else{
		$sqlind= "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
		pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
		FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
		(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
		and pc.estandarbc=ebc.codigo
		and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
		and eb.periodo =$periodo and eb.grado ='$grado'
		and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
		ORDER BY consecutivo DESC";
	}
	$consultaind = $conx->query($sqlind);
	while ($rowind = $conx->records_array($consultaind)) {
		$consecutivo=$rowind['consecutivo'];
		if(!empty($_POST['ci'.trim($id).'-'.$consecutivo])){
			$nivel_aprendizaje=$_POST['ci'.trim($id).'-'.$consecutivo];
			$sqlduplicate="SELECT * FROM indicadoresestudiante WHERE idindicador = '$consecutivo' AND idestudiante = '$id' 
			AND aniolectivo = $aniolectivo AND periodo = $periodo AND idmateria=$idmateria ";
			$consultaduplicate = $conx->query($sqlduplicate);
			if($row = $conx->records_array($consultaduplicate)){
				$sqlupdate= "UPDATE indicadoresestudiante SET nivel_aprendizaje = '$nivel_aprendizaje' 
				WHERE idindicador = '$consecutivo' AND idestudiante = '$id' AND aniolectivo = $aniolectivo AND idmateria=$idmateria 
				AND periodo = $periodo";
				$consulta = $conx->query($sqlupdate);
			}else{
				$sqlindinsert = "INSERT INTO indicadoresestudiante (idindicador, idestudiante, aniolectivo, periodo,nivel_aprendizaje, idmateria) 
				VALUES ('$consecutivo', '$id', '$aniolectivo', '$periodo','$nivel_aprendizaje', '$idmateria')";
				$consultaindinsert = $conx->query($sqlindinsert);
				
			}
			
		}
	}
	echo "<div class='alert alert-warning' role='alert'>Calificación Actualizada</div>";
}	

?>