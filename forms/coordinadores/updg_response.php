<?php
	include('../../class/MySqlClass.php');
	$conx = new ConxMySQL("localhost","root","","appacademy");
	$str_search = $_POST['str_search'];
	$sql = "SELECT a2.*, d.*, c.aniolectivo FROM coordinadoresgrupo c, docente d, aula a2 WHERE 
		c.idaula IN (SELECT a.idaula FROM aula a WHERE a.idaula LIKE '".$str_search."%' 
	OR a.descripcion LIKE '".$str_search."%') AND c.iddocente=d.iddocente AND
	a2.idaula=c.idaula
	ORDER BY c.iddocente ASC ";
	$consulta = $conx->query($sql);
	if($conx->get_numRecords($consulta)>0){
		echo "<br/><br/><br/><table class='tabla'>";
		echo "<caption class='.estilocelda'>Resultados de busqueda</caption>";
		echo "<thead>";
		echo "<tr>";
		echo "<th>DOCENTE</th><th>GRADO ESCOLAR</th><th>AÑO LECTIVO</th>";
		echo "<th></th>";
		echo "<th></th>";
		echo"</tr>";
		echo "</thead>";
		echo "<tbody>";
		while ($row = $conx->records_array($consulta)) {
			echo "<tr>";
			echo "<td>".$row['nombre1']." ".$row['apellido1']."</td>";
			echo "<td>".$row['descripcion']."</td>";
			echo "<td>".$row['aniolectivo']."</td>";
			$id = $row['idaula'];
			$aniolectivo = $row['aniolectivo'];
			echo "<td> <a onclick='updateReg(".$id.",".$aniolectivo.")'><img src='../../images/update.png'  id='back'/></a>";
			echo "</td>";
			echo "<td> <a onclick='delReg(".$id.",".$aniolectivo.")'><img src='../../images/delete.png'  id='back'/></a>";
			echo "</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}else {
		echo "<option>No existe criterio de busqueda</option>";

	}


?>