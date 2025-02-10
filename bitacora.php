<?php
/*Log de acceso */
date_default_timezone_set('America/Bogota');

function log_accesos($usuario,$conexion_bd){
	$fecha_hora = date('Y-m-d H:i:s');
	//$fecha_hora= $hoy["mday"]."/".$hoy["mon"]."/".$hoy["year"]." ".$hoy["hours"].":".$hoy["minutes"].":".$hoy["seconds"];
	$direccion_ip= $_SERVER['REMOTE_ADDR']; 
	$isp = gethostbyaddr($direccion_ip);
	$values["usuario"] = MySQL::SQLValue($usuario);
	$values["fecha_hora"]  = MySQL::SQLValue(($fecha_hora));
	$values["direccion_ip"] = MySQL::SQLValue(($direccion_ip));
	$values["isp"] = MySQL::SQLValue(($isp));
	$sqlinsert=MySQL::BuildSQLInsert("log_accesos", $values);
	$consulta = $conexion_bd->query($sqlinsert);
}

function log_acciones($usuario, $accion, $tabla_afectada, $descripcion_de_la_accion, $conexion_bd){
	$fecha_hora = date('Y-m-d H:i:s');
	//$fecha_hora= $hoy["mday"]."/".$hoy["mon"]."/".$hoy["year"]." ".$hoy["hours"].":".$hoy["minutes"].":".$hoy["seconds"];
	$direccion_ip= $_SERVER['REMOTE_ADDR']; 
	$isp = gethostbyaddr($direccion_ip);
	$values["usuario"] = MySQL::SQLValue($usuario);
	$values["fecha_hora"]  = MySQL::SQLValue(($fecha_hora));
	$values["direccion_ip"] = MySQL::SQLValue(($direccion_ip));
	$values["isp"] = MySQL::SQLValue(($isp));
	$values["accion"] = MySQL::SQLValue(($accion));
	$values["tabla_afectada"] = MySQL::SQLValue(($tabla_afectada));
	$values["descripcion_de_la_accion"] = MySQL::SQLValue(utf8_encode($descripcion_de_la_accion));
	$sqlinsert=MySQL::BuildSQLInsert("log_acciones", $values);
	$consulta = $conexion_bd->query($sqlinsert);
}
/*---------------*/
?>
