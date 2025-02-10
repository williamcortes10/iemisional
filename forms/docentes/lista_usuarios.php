<?php
session_start();
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
header ('Content-type: text/html; charset=utf-8');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$sql="SELECT iddocente, concat_ws(' ',apellido1, apellido2, nombre1,nombre2) AS nombre, tipousuario, habilitado
	  FROM docente, usuario WHERE iddocente=idusuario
	  ORDER BY apellido1, apellido2, nombre1, nombre2 ASC";
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