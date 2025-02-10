<?php
	include("../class/ultimatemysql/mysql.class.php");
	include('../class/MySqlClass.php');
	include('../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	/*$dsmin = $_POST['dsmin'];
	$damin = $_POST['damin'];
	$dbmin = $_POST['dbmin'];
	$dbamin = $_POST['dbamin'];
	$dsmax = $_POST['dsmax'];
	$damax = $_POST['damax'];
	$dbmax = $_POST['dbmax'];
	$dbamax = $_POST['dbamax'];*/
	$aniolectivo = $_POST['aniolectivo'];
	$sql = "SELECT * FROM escala_de_calificacion WHERE aniolectivo=$aniolectivo;";
	$consulta = $conx->query($sql);
	$arreglo = array();
	while($data = $conx->records_array_assoc($consulta)){
		$arreglo[]= array_map('utf8_encode',$data);
	}
	if(isset($arreglo)){
		echo json_encode($arreglo);
	}else{
		echo false;
	}
	
	
?>