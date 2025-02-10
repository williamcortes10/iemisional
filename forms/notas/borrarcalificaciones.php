<?php
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$id = $_POST['id'];
$periodo = $_POST['periodo'];
$idmateria = $_POST['idmateria'];
$idaula = $_POST['idaula'];
$iddocente = $_POST['iddocente'];
$aniolectivo = $_POST['aniolectivo'];
$grado = $_POST['grado'];
//area
$sqlarea ="SELECT idarea_fk  FROM materia WHERE idmateria = '$idmateria' limit 1";
$qarea = $conx->query($sqlarea);
$rowarea = $conx->records_array($qarea);
$area=$rowarea['idarea_fk'];
$vn = (float)str_replace(",",".",$_POST['vn']);
$fj = $_POST['fj'];
$fsj = $_POST['fsj'];
$obs = $_POST['obs'];
$sqlduplicate="SELECT DISTINCT e.idestudiante, e.nombre1, e.nombre2, e.apellido1, e.apellido2 FROM estudiante e 
WHERE e.idestudiante='$id' AND e.idestudiante IN (SELECT n.idestudiante FROM notas n WHERE n.aniolectivo=$aniolectivo 
AND n.tipo_nota='R' AND n.periodo=$periodo AND n.idmateria=$idmateria) ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
$consultaduplicate = $conx->query($sqlduplicate);
if($row = $conx->records_array($consultaduplicate)){
	$sql= "DELETE FROM notas WHERE idestudiante ='$id' AND aniolectivo=$aniolectivo AND tipo_nota ='R' 
	AND periodo=$periodo AND idmateria=$idmateria";
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
		$sqldelinselect="SELECT * FROM indicadoresestudiante WHERE idindicador='$consecutivo'
		and aniolectivo=$aniolectivo and periodo=$periodo and idestudiante='$id' and idmateria=$idmateria";
		$consultaindselect = $conx->query($sqldelinselect);
		if($rowindselect = $conx->records_array($consultaindselect)){
			$sqldelinde="DELETE FROM indicadoresestudiante WHERE idindicador = '$consecutivo' 
			AND idestudiante = '$id' AND aniolectivo = '$aniolectivo' AND periodo = '$periodo' AND idmateria=$idmateria";
			$consultadelinde = $conx->query($sqldelinde);
		}
	}
}else{
	
}
$conx->close_conex();

?>