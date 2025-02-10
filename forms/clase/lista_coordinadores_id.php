<?php
session_start();
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
header ('Content-type: text/html; charset=utf-8');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$idmateria=$_GET['idmateria'];
$aniolectivo=$_GET['aniolectivo']; 

$sql = "SELECT
		  jefearea.idaula,
		  jefearea.idmateria,
		  jefearea.aniolectivo,
		  materia.nombre_materia,
		  CONCAT_WS('-', aula.descripcion) AS salon,
		  CONCAT_WS(' ', docente.apellido1, docente.apellido2, docente.nombre1, docente.nombre2) AS docente
		FROM jefearea
		  INNER JOIN materia
			ON jefearea.idmateria = materia.idmateria
		  INNER JOIN aula
			ON jefearea.idaula = aula.idaula
		  INNER JOIN docente
			ON jefearea.iddocente = docente.iddocente
		WHERE jefearea.aniolectivo = '$aniolectivo'
		AND jefearea.idmateria = '$idmateria'
		ORDER BY aula.grado,aula.grupo, aula.jornada";
$consulta = $conx->query($sql);
if(!$consulta){
	die("Error");
}else{
	$arreglo["data"]= array();
	while($data = $conx->records_array_assoc($consulta)){
		$arreglo["data"][]= array_map('utf8_encode',$data);
	}
	echo json_encode($arreglo);
}
$conx->result_free($consulta);
$conx->close_conex();
    
?>