<?php
	include('../../class/MySqlClass.php');
	$conx = new ConxMySQL("localhost","root","","appacademy");
	$iddocente = $_POST['iddocente'];
	$aniolect = $_POST['aniolect'];
	$idaula = $_POST['idaula'];
	echo $idaula;
	$sql = "SELECT c.iddocente, m.idmateria, m.nombre_materia, c.aniolectivo, c.idaula 
	FROM clase c, docente d, materia m 
	WHERE d.iddocente=$iddocente AND c.iddocente=d.iddocente 
	AND c.idmateria=m.idmateria AND c.aniolectivo=$aniolect AND idaula=$idaula";
	$consulta = $conx->query($sql);
	if($conx->get_numRecords($consulta)>0){
		echo "<table class='tabla'>";
		echo "<caption class='.estilocelda'>Resultados de busqueda</caption>";
		echo "<thead>";
		echo "<tr>";
		echo "<th>Asignatura</th>";
		echo"</tr>";
		echo "</thead>";
		echo "<tbody>";
		while ($row = $conx->records_array($consulta)) {
			echo "<tr>";
			echo "<td>".$row['nombre_materia']."</td>";
			$id = $row['iddocente'];
			$idaula = $row['idaula'];
			$idmateria= $row['idmateria'];
			echo "<td> <a onclick='nuevoIndicador(".$id.",".$idmateria.", ".$idaula.")'><img src='../../images/save.jpg'  id='back'/></a>";
			echo "</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}else {
		echo "<option>No se ha asignado carga académica</option>";

	}


?>