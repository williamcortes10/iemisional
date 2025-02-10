<?php
include("../../class/ultimatemysql/mysql.class.php");
include("../../class/MySqlClass.php");
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
AND n.tipo_nota='N' AND n.periodo='$periodo' AND n.idmateria='$idmateria') ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
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
		VALUES ('$id',  '$periodo',  '$vn', '$fj' , '$fsj' ,  '$obs' ,  'N',  '$aniolectivo',  '$idmateria')";
	}else{
		$sql= "INSERT INTO  notas(idestudiante, periodo, vn, fj, fsj, observaciones, tipo_nota, aniolectivo, idmateria)
		VALUES ('$id',  '$periodo',  '$vn', '$fj' , '$fsj' ,  NULL ,  'N',  '$aniolectivo',  '$idmateria')";
	}
	$consulta = $conx->query($sql);
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
		WHERE idestudiante='$id' AND aniolectivo=$aniolectivo AND tipo_nota='N' 
		AND periodo=$periodo AND idmateria=$idmateria";
	}else{
		$sql= "UPDATE notas SET vn=$vn, fj=$fj, fsj=$fsj, observaciones=NULL 
		WHERE idestudiante='$id' AND aniolectivo=$aniolectivo AND tipo_nota='N' 
		AND periodo=$periodo AND idmateria=$idmateria";
	}
	$consulta = $conx->query($sql);
	echo "<div class='alert alert-warning' role='alert'>Calificación Actualizada</div>";
}	

?>