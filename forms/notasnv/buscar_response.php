<?php
	include('../../class/MySqlClass.php');
	$conx = new ConxMySQL("localhost","root","","appacademy");
	$iddocente = $_POST['iddocente'];
	$idaula = $_POST['idaula'];
	$idmateria = $_POST['idmateria'];
	$aniolect = $_POST['aniolect'];
	$periodo = $_POST['periodo'];
	$numero=0;
	$sql = "SELECT e.idestudiante, e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula 
	FROM estudiante e, matricula m 
	WHERE e.idestudiante=m.idestudiante AND e.habilitado='S' 
	AND m.tipo_matricula='N' AND m.aniolectivo=$aniolect AND m.idaula IN 
	(SELECT c.idaula FROM clase c, indicadoresboletin ib, indicadores i WHERE c.iddocente=$iddocente 
	AND c.idmateria=$idmateria AND c.aniolectivo=$aniolect AND ib.iddocente=c.iddocente 
	AND ib.idindicador=i.idindicador AND i.idmateria= c.idmateria) 
	AND m.idestudiante NOT IN (SELECT n.idestudiante FROM notas n WHERE n.aniolectivo=$aniolect 
	AND n.tipo_nota='N' AND n.periodo=$periodo AND n.idmateria=$idmateria) AND m.periodo=$periodo
	ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 ";
	$consulta = $conx->query($sql);
	if($conx->get_numRecords($consulta)>0){
		echo "<table class='tabla'>";
		echo "<caption class='.estilocelda'>Click en la casilla para seleccionar</caption>";
		echo "<thead>";
		echo "<tr>";
		echo "<tr>";
		echo "</tr>";
		echo "<tr>";
		echo "<td colspan='2'>Seleccionar todos:</td><td>
		<input type='checkbox' id='todos' name='todos' onclick='checktodos()'>";
		echo "</td>";
		echo "</tr>";
		echo "<th>Numero</th><th>Estudiante</th><th>Seleccionar</th>";
		echo"</tr>";
		echo "</thead>";
		echo "<tbody>";
		while ($row = $conx->records_array($consulta)) {
			echo "<tr>";
			echo "<td>".++$numero."</td>";
			echo "<td>".$row['apellido1']." ".$row['apellido2']." ".$row['nombre1']." ".$row['nombre2']."</td>";
			$id = $row['idestudiante'];
			echo "<td><input type='checkbox' id='idestudiante' name='idestudiante' value='$id'></td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
	}else {
	$sql = "SELECT * FROM indicadoresboletin ib WHERE ib.iddocente=$iddocente 
	AND ib.aniolectivo=$aniolect AND ib.idindicador IN (SELECT idindicador FROM indicadores
	WHERE idmateria=$idmateria AND idaula=$idaula) AND ib.periodo=$periodo";
	$consulta = $conx->query($sql);
	if($conx->get_numRecords($consulta)>0){
		echo "<p>No tiene estudiantes pendientes</p>";

	}else{
		echo "<p>Para ingresar notas debe seleccionar indicadores</p>";
	}

	}


?>