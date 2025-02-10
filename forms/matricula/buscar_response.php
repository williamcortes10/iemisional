<?php
	include('../../class/MySqlClass.php');
	include('../../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	$str_search = $_POST['str_search'];
	$sql = "SELECT * FROM estudiante WHERE 
	idestudiante LIKE '$str_search%' or nombre1 LIKE '$str_search%' or nombre2 LIKE '$str_search%' or apellido1 LIKE '$str_search%' ORDER BY idestudiante";
	$consulta = $conx->query($sql);
	if($conx->get_numRecords($consulta)>0){
		echo "<table class='tabla'>";
		echo "<caption class='.estilocelda'>Resultados de busqueda</caption>";
		echo "<thead>";
		echo "<tr>";
		echo "<th>IDENTIFICACION</th><th>NOMBRES Y APELLIDOS</th><th>SEXO</th><th>FECHA NACIMIENTO</th>
		<th>TELEFONO</th><th>DIRECCION</th><th>HABILITADO</th>";
		echo "<th></th>";
		echo"</tr>";
		echo "</thead>";
		echo "<tbody>";
		while ($row = $conx->records_array($consulta)) {
			echo "<tr>";
			echo "<td>".$row['idestudiante']."</td>";
			echo "<td>".$row['nombre1'].' '.$row['nombre2'].' '.$row['apellido1']."</td>";
			echo "<td>".$row['sexo']."</td>";
			echo "<td>".$row['fechanac']."</td>";
			echo "<td>".$row['telefono']."</td>";
			echo "<td>".$row['direccion']."</td>";
			echo "<td>".$row['habilitado']."</td>";

			$id = $row['idestudiante'];
			echo "<td> <a onclick='matricula(\"".$id."\")'><img src='../../images/save.JPG'  id='back'/></a>";
			echo "</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}else {
		echo "<option>No existe criterio de busqueda</option>";

	}


?>