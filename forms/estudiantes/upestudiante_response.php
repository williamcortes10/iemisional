<?php
	include('../../class/MySqlClass.php');
	include('../../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	$str_search = $_POST['str_search'];
	$sql = "SELECT DISTINCT e.*,a.*, m.aniolectivo FROM estudiante e, matricula m, aula a WHERE
	(CONCAT_WS(' ',e.idestudiante, e.nombre1, e.nombre2, e.apellido1, e.apellido2) LIKE '%".$str_search."%' OR
	CONCAT_WS(' ',e.idestudiante, e.apellido1, e.apellido2, e.nombre1, e.nombre2) LIKE '%".$str_search."%' OR
	CONCAT_WS(' ',e.idestudiante, e.apellido1, e.nombre1, e.nombre2) LIKE '%".$str_search."%' )
	AND e.idestudiante=m.idestudiante AND m.idaula=a.idaula AND m.tipo_matricula='R' ORDER BY apellido1, apellido2, nombre1, nombre2 DESC";
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
			echo "<td>".utf8_encode($row['nombre1'].' '.$row['nombre2'].' '.$row['apellido1'].' '.$row['apellido2'])."</td>";
			echo "<td>".$row['sexo']."</td>";
			echo "<td>".$row['fechanac']."</td>";
			echo "<td>".$row['telefono']."</td>";
			echo "<td>".$row['direccion']."</td>";
			echo "<td>".$row['habilitado']."</td>";

			$id = $row['idestudiante'];
			echo "<td> <a onclick='updateReg(\"".$id."\")'><img src='../../images/update.png'  id='back'/></a>";
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
	$conx->close_conex();

?>