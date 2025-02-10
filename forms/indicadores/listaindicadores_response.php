<?php
	include('../../class/MySqlClass.php');
	$conx = new ConxMySQL("localhost","root","","appacademy");
	$iddocente = $_POST['iddocente'];
	$idaula = $_POST['idaula'];
	$idmateria = $_POST['idmateria'];
	$aniolect = $_POST['aniolect'];
	//-------------------- nombre materia
	$sql = "SELECT DISTINCT nombre_materia FROM materia 
	WHERE idmateria=$idmateria";
	$consulta = $conx->query($sql);
	$row = $conx->records_array($consulta);
	$nmateria=$row['nombre_materia'];
	
	//-------------------------- nombre aula 
	$sql = "SELECT descripcion FROM aula 
	WHERE idaula=$idaula";
	$consulta = $conx->query($sql);
	$row = $conx->records_array($consulta);
	$naula=$row['descripcion'];
	//-----------------
	if($aniolect<2015 or $idmateria==27){
		$sql = "SELECT * FROM indicadores i, materia m 
		WHERE i.habilitado='S' AND i.idmateria=$idmateria 
		AND i.idmateria=m.idmateria AND i.idaula=$idaula ORDER BY idindicador";
		$consulta = $conx->query($sql);
		if($conx->get_numRecords($consulta)>0){
			echo "<table class='tabla'>";
			echo "<caption class='.estilocelda'>
			Click en la casilla para seleccionar indicadores <br/>grado: $naula -  area: $nmateria</caption>";
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
				echo "<td>".utf8_encode($row['descripcion'])."</td>";
				$id = $row['idindicador'];
				echo "<td><input type='checkbox' id='indicadores' name='indicadores' value='$id'></td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
		}else {
			echo "<p>No ha creado indicadores</p>";

		}
	}else{
		$sql = "SELECT pc.*, eb.descripcion FROM plan_curricular pc, estandares eb 
		WHERE pc.estandarbc IN (SELECT e.codigo  FROM estandares e WHERE e.idmateria_fk = $idmateria AND e.grado = '$idaula') AND eb.codigo=pc.estandarbc
		ORDER BY pc.consecutivo ASC";
		$consulta = $conx->query($sql);
		if($conx->get_numRecords($consulta)>0){
			echo "<table class='tabla'>";
			echo "<caption class='.estilocelda'>
			Click en la casilla para seleccionar indicadores por competencias <br/>grado: $naula -  area: $nmateria</caption>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>IDINDICADOR</th><th>ESTANDAR/DIMENSION</th><th>COMPETENCIA</th><th>ESTRATEGIA DE APRENDIZAJE</th>";
			echo"</tr>";
			echo "</thead>";
			echo "<tbody>";
			while ($row = $conx->records_array($consulta)) {
				echo "<tr>";
				echo "<td>".$row['consecutivo']."</td>";
				echo "<td>".utf8_encode($row['descripcion'])."</td>";
				echo "<td>".utf8_encode($row['competencia'])."</td>";
				echo "<td>".utf8_encode($row['estrategia'])."</td>";
				$id = $row['consecutivo'];
				echo "<td><input type='checkbox' id='indicadores' name='indicadores' value='$id'></td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
		}else {
			echo "<p>No ha creado indicadores</p>";

		}
		
	}
	


?>