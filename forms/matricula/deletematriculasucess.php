<?php
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$idestudiante = $_POST['idestudiante'];
$tm = $_POST['tm'];
$idaula = $_POST['aula'];
$periodo = $_POST['periodo'];
$aniolectivo = $_POST['aniolect'];
if($tm!='R'){
	$sql = "DELETE FROM matricula WHERE idestudiante='$idestudiante' AND tipo_matricula='$tm' AND
	 idaula='$idaula' AND aniolectivo='$aniolectivo' AND periodo='$periodo'";
	$consulta = $conx->query($sql);
	echo "Registro Borrado con exito";
}elseif($tm=='R'){
	$sql = "DELETE FROM matricula WHERE idestudiante='$idestudiante' AND tipo_matricula='$tm' AND
	 idaula='$idaula' AND aniolectivo='$aniolectivo' AND periodo='$periodo'";
	$consulta = $conx->query($sql);$sql = "DELETE FROM matricula WHERE idestudiante='$idestudiante' AND tipo_matricula='N' 
	AND aniolectivo='$aniolectivo'";
	$consulta = $conx->query($sql);
	echo "Registros Borrados con exito";
}
$conx->close_conex();	
?>