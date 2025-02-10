<?php
	include('../../class/MySqlClass.php');
	include('../../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	$str_search = $_POST['str_search'];
	$sql = "SELECT * FROM aula WHERE idaula LIKE '".$str_search."%' OR descripcion LIKE '".$str_search."%' ORDER BY idaula ASC";
	$consulta = $conx->query($sql);
	if($conx->get_numRecords($consulta)>0){
		echo "<br/><br/><br/><table class='tabla'>";
		echo "<caption class='.estilocelda'>Resultados de busqueda</caption>";
		echo "<thead>";
		echo "<tr>";
		echo "<th>IDAULA</th><th>GRADO</th><th>GRUPO</th><th>NOMBRE AULA</th><th>JORNADA</th>";
		echo "<th></th>";
		echo"</tr>";
		echo "</thead>";
		echo "<tbody>";
		while ($row = $conx->records_array($consulta)) {
			echo "<tr>";
			echo "<td>".$row['idaula']."</td>";
			echo "<td>".$row['grado']."</td>";
			echo "<td>".$row['grupo']."</td>";
			echo "<td>".utf8_encode($row['descripcion'])."</td>";
			echo "<td>".$row['jornada']."</td>";
			$id = $row['idaula'];
			echo "<td> <a onclick='updateReg(".$id.")'><img src='../../images/update.png'  id='back'/></a>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}else {
		echo "<option>No existe criterio de busqueda</option>";

	}


?>