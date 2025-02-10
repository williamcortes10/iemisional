<?php
	include('../../class/MySqlClass.php');
	include('../../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	$str_search = $_POST['str_search'];
	$sql = "SELECT e.idestudiante , e.nombre1, e.nombre2, e.apellido1, a.idaula, a.grado, a.grupo, m.tipo_matricula, m.aniolectivo, m.periodo 
	FROM estudiante e, matricula m, aula a WHERE 
	(e.idestudiante LIKE '$str_search%' or e.nombre1 LIKE '$str_search%') and m.idestudiante=e.idestudiante 
	and m.idaula=a.idaula ORDER BY idestudiante";
	$consulta = $conx->query($sql);
	if($conx->get_numRecords($consulta)>0){
		echo "<table class='tabla'>";
		echo "<caption class='.estilocelda'>Resultados de busqueda</caption>";
		echo "<thead>";
		echo "<tr>";
		echo "<th>IDENTIFICACION</th><th>ESTUDIANTE</th><th>Tipo MATRICULA</th><th>GRADO</th><th>GRUPO</th><th>PERIODO</th><th>AÑO LECTIVO</th>";
		echo"</tr>";
		echo "</thead>";
		echo "<tbody>";
		while ($row = $conx->records_array($consulta)) {
			echo "<tr>";
			echo "<td>".$row['idestudiante']."</td>";
			echo "<td>".$row['nombre1'].' '.$row['nombre2'].' '.$row['apellido1']."</td>";
			echo "<td>".$row['tipo_matricula']."</td>";
			echo "<td>".$row['grado']."</td>";
			echo "<td>".$row['grupo']."</td>";
			if($row['periodo']==0){
				echo "<td>Todos</td>";
			}elseif($row['periodo']==5){
				echo "<td>ANO LECTIVO</td>";
			}else{
				echo "<td>".$row['periodo']."</td>";
			}
			echo "<td>".$row['aniolectivo']."</td>";


			$id = $row['idestudiante'];
			$tipo_matricula= $row['tipo_matricula'];
			$idaula= $row['idaula'];
			$periodo= $row['periodo'];
			$aniolectivo= $row['aniolectivo'];
			echo "<td> <a onclick='actualizarMatricula(\"$id\",\"$tipo_matricula\", $idaula, $periodo, $aniolectivo)'><img src='../../images/update.ico'  id='back'/></a>";
			echo "</td>";
			echo "<td> <a onclick='eliminarMatricula(\"$id\", \"$tipo_matricula\", $idaula, $periodo, $aniolectivo)'><img src='../../images/delete.png'  id='back'/></a>";
			echo "</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}else {
		echo "<option>No existe criterio de busqueda</option>";

	}


?>