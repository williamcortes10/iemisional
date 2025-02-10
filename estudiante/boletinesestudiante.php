<?php
	$sql = "SELECT DISTINCT e.* ,a.descripcion, a.grupo, a.jornada, a.idaula, m.aniolectivo FROM estudiante e, matricula m, aula a WHERE
	e.idestudiante = '$str_search' AND e.idestudiante=m.idestudiante AND m.idaula=a.idaula AND m.periodo=0 AND m.tipo_matricula='R' ORDER BY aniolectivo DESC";
	$consulta = $conx->query($sql);
	if($conx->get_numRecords($consulta)>0){
		echo "<table class='table'>";
		echo "<caption class='.estilocelda'>Resultados de busqueda</caption>";
		echo "<thead>";
		echo "<tr>";
		echo "<th scope='col'>NOMBRES Y APELLIDOS</th>";
		echo "<th scope='col'>GRADO</th>";
		echo "<th scope='col'>AÑO LECTIVO</th>";
		echo "<th scope='col'></th>";
		echo"</tr>";
		echo "</thead>";
		echo "<tbody>";
		while ($row = $conx->records_array($consulta)) {
			if($row['aniolectivo']==$aniolectivo){
			echo "<tr>";
			echo "<td scope='row'>".$row['nombre1'].' '.$row['nombre2'].' '.$row['apellido1'].' '.$row['apellido2']."</td>";
			echo "<td scope='row'>".$row['descripcion']."".$row['grupo']."-".$row['jornada']."</td>";
			echo "<td scope='row'>".$row['aniolectivo']."</td>";
			/*?>
			<td scope='row'>
			<select id="<?php echo $row['aniolectivo'];?>-periodo">
				<?php for($i=1;$i<5;$i++){?>
					<option value="<?php echo $i;?>"><?php echo $i;?></option>
				<?php }?>
			</select>
			</td>
			<?php*/
			$id = $row['idestudiante'];
			$idaula = $row['idaula'];
			$aniolectivo = $row['aniolectivo'];
			
			echo "<td> <a class='btn btn-primary' onclick='generarBoletin(\"".$id."\", \"".$idaula."\", \"".$aniolectivo."\")'>Generar Boletín</a>";
			echo "</td>";
			echo "</tr>";
			}
		}
		echo "</tbody>";
		echo "</table>";
	}else {
		echo "<option>No existen boletines</option>";

	}


?>