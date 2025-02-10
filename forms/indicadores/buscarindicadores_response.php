<?php
	include('../../class/MySqlClass.php');
	$conx = new ConxMySQL("localhost","root","","appacademy");
	$iddocente = $_POST['iddocente'];
	$idmateria = $_POST['idmateria'];
		$sql = "SELECT DISTINCT i.idindicador, i.tipo, i.descripcion, m.nombre_materia  FROM indicadores i, materia m, clase c 
				WHERE ((i.habilitado='S' AND i.compartido='S') OR (i.idpropietario=$iddocente 
				AND i.habilitado='S' AND i.compartido='N')) AND i.idmateria=$idmateria AND c.iddocente=$iddocente
				AND c.idmateria=i.idmateria
				GROUP BY idindicador, idpropietario";
	$consulta = $conx->query($sql);
	if($conx->get_numRecords($consulta)>0){
		echo "<table class='tabla'>";
		echo "<caption class='.estilocelda'>Resultados de busqueda</caption>";
		echo "<thead>";
		echo "<tr>";
		echo "<th>IDINDICADOR</th><th>TIPO</th><th>DESCRIPCION</th><th>MATERIA</th><th></th>";
		echo"</tr>";
		echo "</thead>";
		echo "<tbody>";
		while ($row = $conx->records_array($consulta)) {
			echo "<tr>";
			echo "<td>".$row['idindicador']."</td>";
			echo "<td>".$row['tipo']."</td>";
			echo "<td>".$row['descripcion']."</td>";
			echo "<td>".$row['nombre_materia']."</td>";
			echo "<td> <a onclick='saveIndicador(".$row['idindicador'].", \"".$row['tipo']."\",
			\"".$row['descripcion']."\", \"".$row['nombre_materia']."\")'>Usar</a>";
			echo "</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}else {
		echo "<option>No ha creado indicadores</option>";

	}


?>