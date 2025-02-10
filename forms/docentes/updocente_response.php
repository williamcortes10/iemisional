<?php
	include('../../class/MySqlClass.php');
	$conx = new ConxMySQL("localhost","root","","appacademy");
	$str_search = $_POST['str_search'];
	$sql = "SELECT iddocente, nombre1, nombre2, apellido1, profesion, email FROM docente WHERE iddocente LIKE '".$str_search."%' OR nombre1 LIKE '".$str_search."%' ORDER BY iddocente DESC";
	$consulta = $conx->query($sql);
	if($conx->get_numRecords($consulta)>0){
		echo "<table class='tabla'>";
		echo "<caption class='.estilocelda'>Resultados de busqueda</caption>";
		echo "<thead>";
		echo "<tr>";
		echo "<th>IDENTIFICACION</th><th>NOMBRES Y APELLIDOS</th><th>PROFESION</th><th>EMAIL</th>";
		echo "<th></th>";
		echo"</tr>";
		echo "</thead>";
		echo "<tbody>";
		while ($row = $conx->records_array($consulta)) {
			echo "<tr>";
			echo "<td>".$row['iddocente']."</td>";
			echo "<td>".$row['nombre1'].' '.$row['nombre2'].' '.$row['apellido1']."</td>";
			echo "<td>".$row['profesion']."</td>";
			echo "<td>".$row['email']."</td>";
			$id = $row['iddocente'];
			echo "<td> <a onclick='updateReg(".$id.")'><img src='../../images/update.png'  id='back'/></a>";
			echo "</td>";
			echo "<td> <a onclick='deleteReg(".$id.")'><img src='../../images/delete.png'  id='back'/></a>";
			echo "</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}else {
		echo "<option>No existe criterio de busqueda</option>";

	}


?>