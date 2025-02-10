<?php
	include('../../class/MySqlClass.php');
	$conx = new ConxMySQL("localhost","root","","appacademy");
	$iddocente = $_POST['iddocente'];
	$idaula = $_POST['idaula'];
	$idmateria = $_POST['idmateria'];
	$aniolect = $_POST['aniolect'];
	$sql = "SELECT * FROM indicadores i, materia m 
	WHERE i.idpropietario=$iddocente AND i.idmateria=$idmateria 
	AND i.idmateria=m.idmateria AND i.idaula=$idaula ORDER BY idindicador";
	$consulta = $conx->query($sql);
	if($conx->get_numRecords($consulta)>0){
		echo "<table class='tabla'>";
		echo "<caption class='.estilocelda'>Resultados de busqueda</caption>";
		echo "<thead>";
		echo "<tr>";
		echo "<th>IDINDICADOR</th><th>TIPO</th><th>DESCRIPCION</th>";
		echo "<th>HABILITADO</th><th>COMPARTIDO</th>";
		echo"</tr>";
		echo "</thead>";
		echo "<tbody>";
		while ($row = $conx->records_array($consulta)) {
			echo "<tr>";
			echo "<td>".$row['idindicador']."</td>";
			echo "<td>".$row['tipo']."</td>";
			echo "<td>".$row['descripcion']."</td>";
			echo "<td>".$row['habilitado']."</td>";
			echo "<td>".$row['compartido']."</td>";
			$id = $row['idindicador'];
			$sqlduplicateentry = "SELECT * FROM  indicadoresboletin WHERE idindicador='".$row['idindicador']."'";
			$consulta1 = $conx->query($sqlduplicateentry);
			if($conx->get_numRecords($consulta1)>0){
				$existe='S';
			}else{
				$existe='N';
			}
			echo "<td> <a onclick='actualizarIndicador(".$id.", ".$aniolect.")'><img src='../../images/update.ico'  id='back'/></a>";
			echo "</td>";
			echo "<td> <a onclick='eliminarIndicador(".$id.", \"".$existe."\")'><img src='../../images/delete.png'  id='back'/></a>";
			echo "</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}else {
		echo "<p>No ha creado indicadores</p>";

	}


?>