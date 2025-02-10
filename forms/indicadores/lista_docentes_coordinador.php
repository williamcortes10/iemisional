<?php
session_start();
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
header ('Content-type: text/html; charset=utf-8');
$idaula=$_POST['aula'];
$idmateria=$_POST['materia'];
$aniolectivo=$_POST['anio'];
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$sql = "SELECT docente.*, aula.idaula
		FROM jefearea
		  INNER JOIN materia
			ON jefearea.idmateria = materia.idmateria
		  INNER JOIN aula
			ON jefearea.idaula = aula.idaula
		  INNER JOIN docente
			ON jefearea.iddocente = docente.iddocente
		WHERE jefearea.aniolectivo = '$aniolectivo'
		AND jefearea.idmateria = '$idmateria'
		AND aula.grado = '$idaula'
		ORDER BY aula.grado,aula.grupo, aula.jornada";
		
$consulta = $conx->query($sql);
if(!$consulta){
	die("Error");
}else{
	$flag=0;
	while($data = $conx->records_array_assoc($consulta)){
		$flag=1;
		echo "<tr>";
		echo "<td>".$data['iddocente']."</td>";
		echo "<td>".utf8_encode($data['apellido1'])."</td>";
		echo "<td>".utf8_encode($data['apellido2'])."</td>";
		echo "<td>".utf8_encode($data['nombre1'])."</td>";
		echo "<td>".utf8_encode($data['nombre2'])."</td>";
		echo "<td><button idaula='".$data['idaula']."' iddocente='".$data['iddocente']."' class='calificar btn btn-info' placeholder='Nueva competencia'><i class='glyphicon glyphicon-edit'></i> Crear competencia</button></td>";
		echo "</tr>";
	}
	if($flag==0){
		echo "<tr><td colspn='6'>Ningún dato disponible en esta tabla</td></tr>";
	}
}
$conx->result_free($consulta);
$conx->close_conex();
    
?>