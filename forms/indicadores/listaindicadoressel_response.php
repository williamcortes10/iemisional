<?php
	include('../../class/MySqlClass.php');
	$conx = new ConxMySQL("localhost","root","","appacademy");
	$iddocente = $_POST['iddocente'];
	$idaula = $_POST['idaula'];
	$idmateria = $_POST['idmateria'];
	$aniolect = $_POST['aniolect'];
	$periodo = $_POST['periodo'];
	
	if($aniolect<2015 or $idmateria==27)
	{
		/*$sql = "SELECT DISTINCT ib.idindicador, i.tipo, i.descripcion FROM indicadores i, indicadoresboletin ib,  materia m 
		WHERE ib.iddocente=$iddocente AND i.idmateria=$idmateria 
		AND i.idmateria=m.idmateria AND i.idaula=$idaula AND ib.idindicador=i.idindicador 
		ORDER BY ib.idindicador";*/
		$sql= "SELECT i.* FROM indicadores i
		WHERE i.idmateria=$idmateria AND i.idaula=$idaula AND i.idindicador IN(SELECT ib.idindicador FROM indicadoresboletin ib  WHERE ib.iddocente=$iddocente 
		AND ib.aniolectivo=$aniolect AND ib.periodo=$periodo)";

	}else{
		$sql = "SELECT pc. * FROM plan_curricular pc, indicadoresboletin eb
		WHERE eb.iddocente =$iddocente
		AND eb.idindicador = pc.consecutivo
		AND pc.estandarbc
		IN ( SELECT codigo FROM estandares WHERE idmateria_fk =$idmateria AND grado =$idaula)
		AND eb.aniolectivo =$aniolect
		AND eb.periodo =$periodo
		ORDER BY eb.idindicador ASC ";
	
	}
	$consulta = $conx->query($sql);
	if($conx->get_numRecords($consulta)>0){
		if($aniolect<2015 or $idmateria==27)
		{
			echo "<table class='tabla'>";
			echo "<caption class='.estilocelda'>Click en la casilla para seleccionar</caption>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>IDINDICADOR</th><th>TIPO</th><th>DESCRIPCION</th>";
			echo"</tr>";
			echo "</thead>";
			echo "<tbody>";
			while ($row = $conx->records_array($consulta)) {
				echo "<tr>";
				echo "<td>".$row['idindicador']."</td>";
				echo "<td>".$row['tipo']."</td>";
				echo "<td>".$row['descripcion']."</td>";
				$id = $row['idindicador'];
				echo "<td><input type='checkbox' id='indicadores' name='indicadores' value='$id'></td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
		}else{
			echo "<table class='tabla'>";
			echo "<caption class='.estilocelda'>Click en la casilla para seleccionar</caption>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>IDINDICADOR</th><th>DESCRIPCION</th>";
			echo"</tr>";
			echo "</thead>";
			echo "<tbody>";
			while ($row = $conx->records_array($consulta)) {
				echo "<tr>";
				echo "<td>".$row['consecutivo']."</td>";
				echo "<td>".utf8_encode($row['competencia'])."</td>";
				$id = $row['consecutivo'];
				echo "<td><input type='checkbox' id='indicadores' name='indicadores' value='$id'></td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
		}
	}else {
		echo "<p>No ha seleccionado indicadores</p>";

	}


?>