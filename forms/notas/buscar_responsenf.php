<?php
	include('../../class/MySqlClass.php');
	include("../../class/ultimatemysql/mysql.class.php");
	$conx = new ConxMySQL("localhost","root","","appacademy");
	$conx2 = new MySQL();
	if (! $conx2->Open("appacademy", "localhost", "root", "")) {
		$conx2->Kill();
	}
	$iddocente = $_POST['iddocente'];
	$idaula = $_POST['idaula'];
	$idmateria = $_POST['idmateria'];
	$aniolect = $_POST['aniolect'];
	$numero=0;
	$sql1 = "SELECT * FROM indicadoresboletinnf ib WHERE ib.iddocente=$iddocente 
	AND ib.aniolectivo=$aniolect AND ib.idindicador IN (SELECT idindicador FROM indicadores
	WHERE idmateria=$idmateria AND idaula=$idaula)";
	$consulta1 = $conx->query($sql1);
	$sql = "SELECT e.idestudiante, e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula 
	FROM estudiante e, matricula m  
	WHERE e.idestudiante=m.idestudiante AND e.habilitado='S' 
	AND m.tipo_matricula='R' AND m.aniolectivo='$aniolect' AND m.idaula=$idaula AND m.idaula IN 
	(SELECT c.idaula FROM clase c, indicadoresboletin ib, indicadores i WHERE c.iddocente=$iddocente 
	AND c.idmateria=$idmateria AND c.aniolectivo=$aniolect AND ib.iddocente=c.iddocente 
	AND ib.idindicador=i.idindicador AND i.idmateria= c.idmateria) 
	AND m.idestudiante NOT IN (SELECT n.idestudiante FROM indicadoresestudiantenf n WHERE n.aniolectivo=$aniolect 
	AND n.idindicador NOT IN (SELECT ibn.idindicador FROM indicadoresestudiantenf ibn WHERE ibn.idestudiante=n.idestudiante 
	AND n.idestudiante=e.idestudiante )) 
	ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 ";
	$consulta = $conx->query($sql);
	$sqlperiodo = "SELECT * FROM appconfig WHERE item = 'periodo_hab'";
		if ($conx2->QueryArray($sqlperiodo)) {
			$valor=$conx2->RowCount();
			$conx2->MoveFirst();
			$row = $conx2->Row();
			if($row->valor==4){
				if($conx->get_numRecords($consulta1)>0){
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
							echo "<p>No tiene estudiantes pendientes</p>";
						} 	
					

				}else{
					echo "<p>Para ingresar notas debe seleccionar indicadores</p>";
				}
			}else{
					echo "<span class='small' style='color:red'>Proceso cerrado hasta estar en el 4° periodo</span>";
			}
		}
	


?>