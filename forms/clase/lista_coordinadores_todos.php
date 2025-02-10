<?php
session_start();
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
header ('Content-type: text/html; charset=utf-8');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$aniolectivo=$_GET['aniolectivo']; 
$sql = "SELECT
  jefearea.idaula,
  jefearea.idmateria,
  jefearea.aniolectivo,
  materia.nombre_materia,
  CONCAT_WS('-', aula.descripcion) AS salon,
  CONCAT_WS(' ', docente.apellido1, docente.apellido2, docente.nombre1, docente.nombre2) AS nombre_docente,
  aula.grado
FROM jefearea
  INNER JOIN materia
    ON jefearea.idmateria = materia.idmateria
  INNER JOIN aula
    ON jefearea.idaula = aula.idaula
  INNER JOIN docente
    ON jefearea.iddocente = docente.iddocente
WHERE jefearea.aniolectivo = '$aniolectivo'
ORDER BY aula.grado,aula.grupo, aula.jornada, materia.nombre_materia";
$consulta = $conx->query($sql);
if(!$consulta){
	die("Error");
}else{
	$arreglo["data"]= array();
	while($data = $conx->records_array_assoc($consulta)){
		$datatemp=array_map('utf8_encode',$data);
		$i=1;
		while($i<4){
			$sql='SELECT * FROM indicadoresboletin WHERE aniolectivo='.$aniolectivo.' and periodo='.$i.'
			and idmateria='.$data['idmateria'].' and grado='.$data['grado'];
			$consulta2 = $conx->query($sql);
			$num=$conx->get_numRecords($consulta2);
			if($num<3 or $num >4){
				$datatemp['comp_seleccionadas'.$i]='<button type="button" class="btn btn-danger">'.$num.'</button>';
			}else{
				$datatemp['comp_seleccionadas'.$i]='<button type="button" class="btn btn-success">'.$num.'</button>';
			}
			$i++;
		}
		$arreglo["data"][]= $datatemp;
	}
	echo json_encode($arreglo);
}
$conx->result_free($consulta);
$conx->close_conex();
    
?>