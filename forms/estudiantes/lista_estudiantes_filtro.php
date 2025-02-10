<?php
session_start();
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
header ('Content-type: text/html; charset=utf-8');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$str_search = $_POST["source"];
$arreglo["data"]=array();;
$sql="SELECT DISTINCT e.* FROM estudiante e WHERE
	(CONCAT_WS(' ',e.idestudiante, e.nombre1, e.nombre2, e.apellido1, e.apellido2) LIKE '%".$str_search."%' OR
	CONCAT_WS(' ',e.idestudiante, e.apellido1, e.apellido2, e.nombre1, e.nombre2) LIKE '%".$str_search."%' OR
	CONCAT_WS(' ',e.idestudiante, e.apellido1, e.nombre1, e.nombre2) LIKE '%".$str_search."%' )
	ORDER BY apellido1, apellido2, nombre1, nombre2 DESC";
$consulta = $conx->query($sql);
if(!$consulta){
	die("Error");
}else{
	while($data = $conx->records_array_assoc($consulta)){
		$arreglo["data"][]= array_map('utf8_encode',$data);
	}
	
}
echo json_encode($arreglo);
$conx->result_free($consulta);
$conx->close_conex();
    
?>