<?php
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$periodo = $_POST['periodo'];
$idmateria = $_POST['idmateria'];
$aniolectivo = $_POST['aniolectivo'];
$docente = $_POST['iddocente'];
$grado = $_POST['grado'];
//area
$sqlarea ="SELECT idarea_fk  FROM materia WHERE idmateria = '$idmateria'";
$qarea = $conx->query($sqlarea);
$rowarea = $conx->records_array($qarea);
$area=$rowarea['idarea_fk'];
/*$sql = "SELECT pc . *, eb.periodo, eb.aniolectivo FROM plan_curricular pc, indicadoresboletin eb
	WHERE eb.iddocente =$docente
	AND eb.idindicador = pc.consecutivo
	AND pc.estandarbc
	IN ( SELECT codigo FROM estandares WHERE idmateria_fk =$idmateria)
	AND eb.aniolectivo =$aniolectivo
	AND eb.periodo =$periodo
	ORDER BY eb.idindicador DESC";*/
$sql = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
and pc.estandarbc=ebc.codigo
and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
and eb.periodo =$periodo and eb.iddocente ='$docente' and eb.grado ='$grado'
and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area AND eb.idmateria=$idmateria
ORDER BY consecutivo DESC";
$consulta = $conx->query($sql);
if($conx->get_numRecords($consulta)>0){
	echo "<table class='table table-hover table-striped' style='text-align:left;'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>Codigo</th>";
	echo "<th>Componente</th>";
	echo "<th>Competencia</th>";
	echo "<th>Grupo de grados</th>";
	echo "<th>Periodo</th>";
	echo "<th>Año lectivo</th>";
	echo "<th>Seleccionar</th>";
	echo"</tr>";
	echo "</thead>";
	echo "<tbody>";
	while ($row = $conx->records_array($consulta)) {
		$id = $row['consecutivo'];
		echo "<tr>";
		echo "<td>".$row['consecutivo']."</td>";
		echo "<td>".utf8_encode($row['descripcion'])."</td>";
		echo "<td>".utf8_encode($row['competencia'])."</td>";
		echo "<td>".$row['grados']."</td>";
		echo "<td>".$row['periodo']."</td>";
		echo "<td>".$row['aniolectivo']."</td>";
		echo "<td><input type='checkbox' id='idcompetencias[]' name='idcompetencias[]' value='$id'></td>";
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";
}else {
?>
	<div class="jumbotron center-block">
	<h2 class='alert alert-danger'>Usted no ha seleccionado competencias para esta asignatura en este periodo</h2>
	<p><a class='btn btn-lg btn-success '  href='desselecionarcompetencia.php' role='button'>Volver</a></p>
	</div>
<?php

}
?>