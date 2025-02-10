<?php
	include('../../class/MySqlClass.php');
	include('../../bdConfig.php');
	header ('Content-type: text/html; charset=utf-8');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);

	$idaulaant = $_POST['aulaant'];
	$idaulapro = $_POST['aulapro'];
	$aniolect = $_POST['aniolect'];
	$periodo = $_POST['periodo'];
	$aniolectpro = $_POST['aniolectpro'];
	$tipo_matricula	= $_POST['tipo_matricula'];
	$numero=0;
	if($tipo_matricula!='N'){
		$periodo=0;
		$aniolectp=$aniolect+1;
		switch($idaulaant){
			case '0t':
						$sql1 = "SELECT DISTINCT *  FROM matricula m, estudiante e WHERE m.tipo_matricula = 'R' 
						AND m.aniolectivo = '$aniolect' AND m.idaula IN (SELECT b.idaula  FROM aula b WHERE b.grado = 0)  AND m.periodo = periodo
						AND m.idestudiante=e.idestudiante AND m.idestudiante NOT IN (SELECT ma.idestudiante FROM matricula ma WHERE ma.aniolectivo = '$aniolectpro' AND ma.tipo_matricula = 'R') AND e.habilitado='S' AND e.idestudiante order by APELLIDO1, APELLIDO2, NOMBRE1, NOMBRE2";
						break;
			case '1t':
						$sql1 = "SELECT DISTINCT *  FROM matricula m, estudiante e WHERE m.tipo_matricula = 'R' 
						AND m.aniolectivo = '$aniolect' AND m.idaula IN (SELECT b.idaula  FROM aula b WHERE b.grado = 1)  AND m.periodo = periodo
						AND m.idestudiante=e.idestudiante AND m.idestudiante NOT IN (SELECT ma.idestudiante FROM matricula ma WHERE ma.aniolectivo = '$aniolectpro' AND ma.tipo_matricula = 'R') AND e.habilitado='S' AND e.idestudiante order by APELLIDO1, APELLIDO2, NOMBRE1, NOMBRE2";
						break;
			case '2t':
						$sql1 = "SELECT DISTINCT *  FROM matricula m, estudiante e WHERE m.tipo_matricula = 'R' 
						AND m.aniolectivo = '$aniolect' AND m.idaula IN (SELECT b.idaula  FROM aula b WHERE b.grado = 2)  AND m.periodo = periodo
						AND m.idestudiante=e.idestudiante AND m.idestudiante NOT IN (SELECT ma.idestudiante FROM matricula ma WHERE ma.aniolectivo = '$aniolectpro' AND ma.tipo_matricula = 'R') AND e.habilitado='S' AND e.idestudiante order by APELLIDO1, APELLIDO2, NOMBRE1, NOMBRE2";
						break;
			case '3t':
						$sql1 = "SELECT DISTINCT *  FROM matricula m, estudiante e WHERE m.tipo_matricula = 'R' 
						AND m.aniolectivo = '$aniolect' AND m.idaula IN (SELECT b.idaula  FROM aula b WHERE b.grado = 3)  AND m.periodo = periodo
						AND m.idestudiante=e.idestudiante AND m.idestudiante NOT IN (SELECT ma.idestudiante FROM matricula ma WHERE ma.aniolectivo = '$aniolectpro' AND ma.tipo_matricula = 'R') AND e.habilitado='S' AND e.idestudiante order by APELLIDO1, APELLIDO2, NOMBRE1, NOMBRE2";
						break;
			case '4t':
						$sql1 = "SELECT DISTINCT *  FROM matricula m, estudiante e WHERE m.tipo_matricula = 'R' 
						AND m.aniolectivo = '$aniolect' AND m.idaula IN (SELECT b.idaula  FROM aula b WHERE b.grado = 4)  AND m.periodo = periodo
						AND m.idestudiante=e.idestudiante AND m.idestudiante NOT IN (SELECT ma.idestudiante FROM matricula ma WHERE ma.aniolectivo = '$aniolectpro' AND ma.tipo_matricula = 'R') AND e.habilitado='S' AND e.idestudiante order by APELLIDO1, APELLIDO2, NOMBRE1, NOMBRE2";
						break;
			case '5t':
						$sql1 = "SELECT DISTINCT *  FROM matricula m, estudiante e WHERE m.tipo_matricula = 'R' 
						AND m.aniolectivo = '$aniolect' AND m.idaula IN (SELECT b.idaula  FROM aula b WHERE b.grado = 5)  AND m.periodo = periodo
						AND m.idestudiante=e.idestudiante AND m.idestudiante NOT IN (SELECT ma.idestudiante FROM matricula ma WHERE ma.aniolectivo = '$aniolectpro' AND ma.tipo_matricula = 'R') AND e.habilitado='S' AND e.idestudiante order by APELLIDO1, APELLIDO2, NOMBRE1, NOMBRE2";
						break;
			case '6t':
						$sql1 = "SELECT DISTINCT *  FROM matricula m, estudiante e WHERE m.tipo_matricula = 'R' 
						AND m.aniolectivo = '$aniolect' AND m.idaula IN (SELECT b.idaula  FROM aula b WHERE b.grado = 6)  AND m.periodo = periodo
						AND m.idestudiante=e.idestudiante AND m.idestudiante NOT IN (SELECT ma.idestudiante FROM matricula ma WHERE ma.aniolectivo = '$aniolectpro' AND ma.tipo_matricula = 'R') AND e.habilitado='S' AND e.idestudiante order by APELLIDO1, APELLIDO2, NOMBRE1, NOMBRE2";
						break;
			case '7t':
						$sql1 = "SELECT DISTINCT *  FROM matricula m, estudiante e WHERE m.tipo_matricula = 'R' 
						AND m.aniolectivo = '$aniolect' AND m.idaula IN (SELECT b.idaula  FROM aula b WHERE b.grado = 7)  AND m.periodo = periodo
						AND m.idestudiante=e.idestudiante AND m.idestudiante NOT IN (SELECT ma.idestudiante FROM matricula ma WHERE ma.aniolectivo = '$aniolectpro' AND ma.tipo_matricula = 'R') AND e.habilitado='S' AND e.idestudiante order by APELLIDO1, APELLIDO2, NOMBRE1, NOMBRE2";
						break;
			case '8t':
						$sql1 = "SELECT DISTINCT *  FROM matricula m, estudiante e WHERE m.tipo_matricula = 'R' 
						AND m.aniolectivo = '$aniolect' AND m.idaula IN (SELECT b.idaula  FROM aula b WHERE b.grado = 8)  AND m.periodo = periodo
						AND m.idestudiante=e.idestudiante AND m.idestudiante NOT IN (SELECT ma.idestudiante FROM matricula ma WHERE ma.aniolectivo = '$aniolectpro' AND ma.tipo_matricula = 'R') AND e.habilitado='S' AND e.idestudiante order by APELLIDO1, APELLIDO2, NOMBRE1, NOMBRE2";
						break;
			case '9t':
						$sql1 = "SELECT DISTINCT *  FROM matricula m, estudiante e WHERE m.tipo_matricula = 'R' 
						AND m.aniolectivo = '$aniolect' AND m.idaula IN (SELECT b.idaula  FROM aula b WHERE b.grado = 9)  AND m.periodo = periodo
						AND m.idestudiante=e.idestudiante AND m.idestudiante NOT IN (SELECT ma.idestudiante FROM matricula ma WHERE ma.aniolectivo = '$aniolectpro' AND ma.tipo_matricula = 'R') AND e.habilitado='S' AND e.idestudiante order by APELLIDO1, APELLIDO2, NOMBRE1, NOMBRE2";
						break;
			case '10t':
						$sql1 = "SELECT DISTINCT *  FROM matricula m, estudiante e WHERE m.tipo_matricula = 'R' 
						AND m.aniolectivo = '$aniolect' AND m.idaula IN (SELECT b.idaula  FROM aula b WHERE b.grado = 10)  AND m.periodo = periodo
						AND m.idestudiante=e.idestudiante AND m.idestudiante NOT IN (SELECT ma.idestudiante FROM matricula ma WHERE ma.aniolectivo = '$aniolectpro' AND ma.tipo_matricula = 'R') AND e.habilitado='S' AND e.idestudiante order by APELLIDO1, APELLIDO2, NOMBRE1, NOMBRE2";
						break;
			case '11t':
						$sql1 = "SELECT DISTINCT *  FROM matricula m, estudiante e WHERE m.tipo_matricula = 'R' 
						AND m.aniolectivo = '$aniolect' AND m.idaula IN (SELECT b.idaula  FROM aula b WHERE b.grado = 11)  AND m.periodo = periodo
						AND m.idestudiante=e.idestudiante AND m.idestudiante NOT IN (SELECT ma.idestudiante FROM matricula ma WHERE ma.aniolectivo = '$aniolectpro' AND ma.tipo_matricula = 'R') AND e.habilitado='S' AND e.idestudiante order by APELLIDO1, APELLIDO2, NOMBRE1, NOMBRE2";
						break;
			default:
						$sql1 = "SELECT *  FROM matricula m, estudiante e WHERE m.tipo_matricula = 'R' 
						AND m.aniolectivo = '$aniolect' AND m.idaula = $idaulaant AND m.periodo = periodo
						AND m.idestudiante=e.idestudiante AND e.habilitado='S' AND e.idestudiante NOT IN
						(SELECT e.idestudiante  FROM matricula mp, estudiante ep WHERE mp.tipo_matricula = 'R' 
						AND mp.aniolectivo = '$aniolectp' AND mp.idaula = $idaulapro AND mp.periodo = periodo
						AND mp.idestudiante=ep.idestudiante AND e.habilitado='S') order by APELLIDO1, APELLIDO2, NOMBRE1, NOMBRE2";
						break;
		}
		
		
	}else{
		$sql1 = "SELECT *  FROM matricula m, estudiante e WHERE m.tipo_matricula = 'R' 
		AND m.aniolectivo = '$aniolect' AND m.idaula = $idaulaant AND m.periodo = 0
		AND m.idestudiante=e.idestudiante AND e.habilitado='S' AND e.idestudiante NOT IN
		(SELECT ep.idestudiante  FROM matricula mp, estudiante ep WHERE mp.tipo_matricula = 'N' 
		AND mp.aniolectivo = '$aniolect' AND mp.idaula = $idaulapro AND mp.periodo = periodo
		AND mp.idestudiante=ep.idestudiante AND e.habilitado='S') order by APELLIDO1, APELLIDO2, NOMBRE1, NOMBRE2";
	}
	$consulta1 = $conx->query($sql1);
	if($conx->get_numRecords($consulta1)>0){
			echo "<table class='tabla' style='color:black' align='center'>";
			echo "<caption class='.estilocelda'>Click en la casilla para matricular</caption>";
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
			while ($row = $conx->records_array($consulta1)) {
				echo "<tr>";
				echo "<td>".++$numero."</td>";
				echo "<td>".utf8_encode($row['apellido1']." ".$row['apellido2']." ".$row['nombre1']." ".$row['nombre2'])."</td>";
				$id = $row['idestudiante'];
				echo "<td><input type='checkbox' id='idestudiante' name='idestudiante' value='$id'></td>";
				echo "</tr>";
			}
			echo "</tbody>";
			echo "</table>";
	}else{
		echo "<p>No tiene estudiantes pendientes</p>";
	} 		


?>