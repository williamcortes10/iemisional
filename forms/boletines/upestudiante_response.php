<?php
	include('../../class/MySqlClass.php');
	include('../../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	$str_search = $_POST['str_search'];
	$sql = "SELECT DISTINCT e.* ,a.descripcion, a.grupo, a.jornada, a.idaula, m.aniolectivo FROM estudiante e, matricula m, aula a WHERE (e.idestudiante  LIKE '".$str_search."%' 
	OR e.nombre1 LIKE '".$str_search."%'  OR e.nombre2 LIKE '".$str_search."%' OR e.apellido1 LIKE '".$str_search."%' OR e.apellido2 LIKE '".$str_search."%')
	AND e.idestudiante=m.idestudiante AND m.idaula=a.idaula AND m.periodo=0 AND m.tipo_matricula='R' ORDER BY idestudiante DESC";
	$consulta = $conx->query($sql);
	if($conx->get_numRecords($consulta)>0){
		echo "<table class='tabla'>";
		echo "<caption class='.estilocelda'>Resultados de busqueda</caption>";
		echo "<thead>";
		echo "<tr>";
		echo "<th>IDENTIFICACION</th><th>NOMBRES Y APELLIDOS</th>";
		echo "<th>GRADO</th>";
		echo "<th>AÑO LECTIVO</th>";
		echo "<th>GENERAR</th>";
		echo"</tr>";
		echo "</thead>";
		echo "<tbody>";
		while ($row = $conx->records_array($consulta)) {
			echo "<tr>";
			echo "<td>".$row['idestudiante']."</td>";
			echo "<td>".$row['nombre1'].' '.$row['nombre2'].' '.$row['apellido1'].' '.$row['apellido2']."</td>";
			echo "<td>".$row['descripcion']."".$row['grupo']."-".$row['jornada']."</td>";
			echo "<td>".$row['aniolectivo']."</td>";
			
			$id = $row['idestudiante'];
			$idaula = $row['idaula'];
			$aniolectivo = $row['aniolectivo'];
			echo "<td> <a onclick='generarBoletin(\"".$id."\", \"".$idaula."\", \"".$aniolectivo."\")'><img src='../../images/forward.png'  id='back'/></a>";
			echo "</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}else {
		echo "<option>No existe criterio de busqueda</option>";

	}


?>