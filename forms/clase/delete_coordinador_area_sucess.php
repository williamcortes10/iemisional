<?php
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$idmateria = $_POST['d_materia'];
$idaula = $_POST['d_aula'];
$aniolectivo = $_POST['d_aniolect'];
$sql = "DELETE FROM jefearea WHERE idmateria='$idmateria' AND idaula='$idaula' AND aniolectivo='$aniolectivo'";
$consulta = $conx->query($sql);
if($conx->get_affected_rows()>0){
	echo "<span class='small'><i class='glyphicon glyphicon-ok'></i> Registro eliminado con éxito</span>";
}else{
	echo "<span class='small'><i class='glyphicon glyphicon-remove'></i> No se pudo eliminar registro</span>";
}
$conx->close_conex();	
?>