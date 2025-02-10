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
$sqlarea ="SELECT idarea_fk  FROM materia WHERE idmateria = '$idmateria'";
$qarea = $conx->query($sqlarea);
$rowarea = $conx->records_array($qarea);
$area=$rowarea['idarea_fk'];
$vn = (float)str_replace(",",".",$_POST['vn'.trim($id)]);
$fj = $_POST['fj'.trim($id)];
$fsj = $_POST['fsj'.trim($id)];
$obs = $_POST['obs'.trim($id)];
$sqlduplicate="SELECT DISTINCT e.idestudiante, e.nombre1, e.nombre2, e.apellido1, e.apellido2 FROM estudiante e 
WHERE e.idestudiante='$id' AND e.idestudiante IN (SELECT n.idestudiante FROM notas n WHERE n.aniolectivo=$aniolectivo 
AND n.tipo_nota='N' AND n.periodo=$periodo AND n.idmateria=$idmateria) ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
$consultaduplicate = $conx->query($sqlduplicate);
if($row = $conx->records_array($consultaduplicate)){
	$sql= "DELETE FROM notas WHERE idestudiante ='$id' AND aniolectivo=$aniolectivo AND tipo_nota ='N' 
	AND periodo=$periodo AND idmateria=$idmateria";
	$consulta = $conx->query($sql);
	echo "<div class='alert alert-danger' role='alert'>Calificación borrada con exito</div>";
}else{
	echo "<div class='alert alert-danger' role='alert'>No existe calificación</div>";
	
}

?>