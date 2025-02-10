<?php
session_start();
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
header ('Content-type: text/html; charset=utf-8');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$iddocente=$_GET['iddocente'];
$aniolectivo=$_GET['aniolectivo']; 
$sql = "SELECT
  clase.idaula,
  clase.idmateria,
  clase.aniolectivo,
  materia.nombre_materia,
  clase.periodos,
  clase.ih,
  clase.porc_valorativo,
  CONCAT_WS('-', aula.descripcion, aula.grupo, aula.jornada) AS salon
FROM clase
  INNER JOIN materia
    ON clase.idmateria = materia.idmateria
  INNER JOIN aula
    ON clase.idaula = aula.idaula
WHERE clase.aniolectivo = '$aniolectivo'
AND clase.iddocente = '$iddocente'
ORDER BY materia.nombre_materia, aula.descripcion,aula.grupo, aula.jornada";
$consulta = $conx->query($sql);
if(!$consulta){
	die("Error");
}else{
	$arreglo= array();
	while($data = $conx->records_array_assoc($consulta)){
		$arreglo["data"][]= $data;
	}
	echo json_encode($arreglo);
}
$conx->result_free($consulta);
$conx->close_conex();
    
?>