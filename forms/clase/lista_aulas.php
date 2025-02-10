<?php
session_start();
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
header ('Content-type: text/html; charset=utf-8');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$sql = "SELECT * FROM aula ORDER BY grado, grupo";
$consulta = $conx->query($sql);
if(!$consulta){
	die("Error");
}else{
	$jsondata["data"]["aulas"] = array();
	while($data = $conx->records_array_assoc($consulta)){
		$jsondata['data']["aulas"][]= $data;
	}
	echo json_encode($jsondata);
}
$conx->result_free($consulta);
$conx->close_conex();
    
?>