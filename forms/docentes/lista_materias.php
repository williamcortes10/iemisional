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
	while($data = $conx->records_array_assoc($consulta)){
		$arreglo["data"][]= array_map('utf8_encode',$data);
	}
	echo json_encode($arreglo);
}
$conx->result_free($consulta);
$conx->close_conex();
    
?>