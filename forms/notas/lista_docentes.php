<?php
session_start();
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
header ('Content-type: text/html; charset=utf-8');
$idaula=$_POST['aula'];
$idmateria=$_POST['materia'];
$anio_lectivo=$_POST['anio'];
$periodo=$_POST['periodov'];
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$sql="SELECT d.*
	  FROM docente d
	  INNER JOIN clase c
	  ON d.iddocente=c.iddocente
	  WHERE c.idaula='$idaula' AND c.idmateria='$idmateria' AND aniolectivo='$anio_lectivo' AND periodos LIKE '%$periodo%'
	  ORDER BY d.apellido1, d.apellido2, d.nombre1, d.nombre2 ASC";
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
		echo "<td><button iddocente='".$data['iddocente']."' class='calificar btn btn-info' placeholder='Ingresar calificaciones'><i class='glyphicon glyphicon-edit'></i> Calificar</button></td>";
		echo "</tr>";
	}
	if($flag==0){
		echo "<tr><td colspn='6'>Ningún dato disponible en esta tabla</td></tr>";
	}
}
$conx->result_free($consulta);
$conx->close_conex();
    
?>