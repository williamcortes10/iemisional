<?php
	include('../../class/MySqlClass.php');
	include('../../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	$str_search = $_POST['str_search'];
	$sql = "SELECT d.iddocente , d.nombre1, d.nombre2, d.apellido1, d.profesion FROM docente d WHERE 
	d.iddocente LIKE '$str_search%' or d.nombre1 LIKE '$str_search%' or d.nombre2 LIKE '$str_search%' or d.apellido2 LIKE '$str_search%' ORDER BY iddocente";
	$consulta = $conx->query($sql);
	if($conx->get_numRecords($consulta)>0){
		echo "<table class='tabla'>";
		echo "<caption class='.estilocelda'>Resultados de busqueda</caption>";
		echo "<thead>";
		echo "<tr>";
		echo "<th>IDENTIFICACION</th><th>DOCENTE</th><th>PROFESION</th>";
		echo"</tr>";
		echo "</thead>";
		echo "<tbody>";
		while ($row = $conx->records_array($consulta)) {
			echo "<tr>";
			echo "<td>".$row['iddocente']."</td>";
			echo "<td>".$row['nombre1'].' '.$row['nombre2'].' '.$row['apellido1']."</td>";
			echo "<td>".$row['profesion']."</td>";
			$id = $row['iddocente'];
			echo "<td> <a onclick='asignarclase(".$id.")'><img src='../../images/save.JPG'  id='back'/></a>";
			echo "</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}else {
		echo "<option>No existe criterio de busqueda</option>";

	}


?>