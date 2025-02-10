<?php
	include('../../class/MySqlClass.php');
	include('../../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	$str_search = $_POST['str_search'];
	$sql = "SELECT c.iddocente , d.nombre1, d.nombre2, d.apellido1, m.idmateria, m.nombre_materia, a.idaula, a.grado, a.grupo, c.ih, c.aniolectivo FROM `clase` c, docente d, materia m, aula a WHERE 
	(d.iddocente LIKE '$str_search%' or d.nombre1 LIKE '$str_search%') and c.iddocente=d.iddocente and c.idmateria=m.idmateria and c.idaula=a.idaula ORDER BY iddocente";
	$consulta = $conx->query($sql);
	if($conx->get_numRecords($consulta)>0){
		echo "<table class='tabla'>";
		echo "<caption class='.estilocelda'>Resultados de busqueda</caption>";
		echo "<thead>";
		echo "<tr>";
		echo "<th>IDENTIFICACION</th><th>DOCENTE</th><th>Asignatura</th><th>GRADO</th><th>GRUPO</th><th>I.H</th><th>AÑO LECTIVO</th>";
		echo"</tr>";
		echo "</thead>";
		echo "<tbody>";
		while ($row = $conx->records_array($consulta)) {
			echo "<tr>";
			echo "<td>".$row['iddocente']."</td>";
			echo "<td>".$row['nombre1'].' '.$row['nombre2'].' '.$row['apellido1']."</td>";
			echo "<td>".$row['nombre_materia']."</td>";
			echo "<td>".$row['grado']."</td>";
			echo "<td>".$row['grupo']."</td>";
			echo "<td>".$row['ih']."</td>";
			echo "<td>".$row['aniolectivo']."</td>";


			$id = $row['iddocente'];
			$idmateria= $row['idmateria'];
			$idaula= $row['idaula'];
			$ih= $row['ih'];
			$aniolectivo= $row['aniolectivo'];
			echo "<td> <a onclick='actulizarClase(".$id.",".$idmateria.",".$idaula.",".$ih.",".$aniolectivo.")'><img src='../../images/update.ico'  id='back'/></a>";
			echo "</td>";
			echo "<td> <a onclick='eliminarClase(".$id.",".$idmateria.",".$idaula.",".$aniolectivo.")'><img src='../../images/delete.png'  id='back'/></a>";
			echo "</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}else {
		echo "<option>No existe criterio de busqueda</option>";

	}


?>