<?php
include('../../class/MySqlClass.php');
$conx = new ConxMySQL("localhost","root","","bdaltono");
mysql_set_charset('utf8',$conx->conexion);
$str_search = $_POST['str_search'];
$periodo = $_POST['periodo'];
$aniolect = $_POST['aniolect'];


$sql = "
SELECT tbestudiante.*, matricula.grado FROM tbestudiante, matricula 
WHERE codest IN
(SELECT codest_fk FROM matricula 
WHERE codest_fk IN
(SELECT codest FROM tbestudiante WHERE codest LIKE '".$str_search."%'  
OR n1 LIKE '".strtoupper($str_search)."%' OR a1 LIKE '".strtoupper($str_search)."%' AND estado='ACT') AND aniolect='$aniolect') 
AND matricula.codest_fk=tbestudiante.codest
ORDER BY n1,n2,a1,a2,matricula.grado DESC";
$consulta = $conx->query($sql);
$fila=1;
if($conx->get_numRecords($consulta)>0){
	echo "<table id='tbresul'>";
	echo "<caption>Resultados</caption>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>CODIGO</th><th>NOMBRES Y APELLIDOS</th><th>GRADO</th>";
	echo "<th></th>";
	echo"</tr>";
	echo "</thead>";
	echo "<tbody>";
	while($records = $conx->records_array($consulta)){
		echo "<tr>";
		echo "<td>".$records['codest']."</td>";
		echo "<td>".strtoupper($records['n1'])." ".strtoupper($records['n2'])." ".strtoupper($records['a1'])." ".strtoupper($records['a2'])."</td>";
		echo "<td>".strtoupper($records['grado'])."</td>";
		$recordsup = $records['codest'];
		$grado=utf8_encode($records['grado']);
		echo "<td><input type='button'  value='Generar boletin' onclick=\"boletinindividual('$recordsup','$periodo','$grado', $aniolect)\"></td>";
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";
	$conx->close_conex();	
}

?>