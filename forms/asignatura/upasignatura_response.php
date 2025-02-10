<?php
	include('../../class/MySqlClass.php');
	$conx = new ConxMySQL("localhost","root","","appacademy");
	$str_search = $_POST['str_search'];
	$sql = "SELECT idmateria, nombre_materia FROM materia WHERE idmateria LIKE '".$str_search."%' OR nombre_materia LIKE '".$str_search."%' ORDER BY idmateria ASC";
	$consulta = $conx->query($sql);
	if($conx->get_numRecords($consulta)>0){
		echo "<br/><br/><br/><table class='tabla'>";
		echo "<caption class='.estilocelda'>Resultados de busqueda</caption>";
		echo "<thead>";
		echo "<tr>";
		echo "<th>CODIGO</th><th>NOMBRE ASIGNATURA</th>";
		echo "<th></th>";
		echo"</tr>";
		echo "</thead>";
		echo "<tbody>";
		while ($row = $conx->records_array($consulta)) {
			echo "<tr>";
			echo "<td>".$row['idmateria']."</td>";
			echo "<td>".$row['nombre_materia']."</td>";
			$id = $row['idmateria'];
			echo "<td> <a onclick='updateReg(".$id.")'><img src='../../images/update.png'  id='back'/></a>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}else {
		echo "<option>No existe criterio de busqueda</option>";

	}


?>