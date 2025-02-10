<?php
session_start();
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
header ('Content-type: text/html; charset=utf-8');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$sql = "SELECT idmateria, nombre_materia FROM materia ORDER BY nombre_materia";

$consulta = $conx->query($sql);
if(!$consulta){
	die("Error");
}else{
	$jsondata["data"]["materias"] = array();
	while($data = $conx->records_array_assoc($consulta)){
		$jsondata['data']["materias"][]= $data;
	}
	echo json_encode($jsondata);
}
$conx->result_free($consulta);
$conx->close_conex();
    
?>