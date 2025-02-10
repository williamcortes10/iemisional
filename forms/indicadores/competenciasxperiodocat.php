<?php
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$periodo = $_POST['periodo'];
$idmateria = $_POST['idmateria'];
$aniolectivo = $_POST['aniolectivo'];
$docente = $_POST['iddocente'];
$grado = $_POST['grado'];
//escala de notas
$existeescala=0;
$sqlrc = "SELECT * FROM escala_de_calificacion WHERE aniolectivo = $aniolectivo";
$consultarc = $conx->query($sqlrc);    
while($recordsrc = $conx->records_array($consultarc)){

    switch($recordsrc['tipo_escala']){
		case "DS": 	$rcsmin = $recordsrc['rango_inferior'];
					$rcsmax = $recordsrc['rango_superior'];
					break;
				
		case "DA": 	$rcamin = $recordsrc['rango_inferior'];
					$rcamax = $recordsrc['rango_superior'];
					break;
		
		case "DB": 	$rcbmin = $recordsrc['rango_inferior'];
					$rcbmax = $recordsrc['rango_superior'];
					break;
		case "D-": 	$rcbamin = $recordsrc['rango_inferior'];
					$rcbamax = $recordsrc['rango_superior'];
					break;
		default: break;
	}
    $existeescala=1;
}
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
pc.estandarbc, ebc.descripcion, eb.*  
FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
and pc.estandarbc=ebc.codigo
and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
and eb.periodo =$periodo and eb.iddocente ='$docente' and eb.grado ='$grado'
and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area AND eb.idmateria=$idmateria
ORDER BY consecutivo DESC";
$consulta = $conx->query($sql);
if($conx->get_numRecords($consulta)>0){
	echo "<form id='formcompcat' method='POST'>";
	echo "<table class='table table-hover table-striped' style='text-align:left;'>";
	echo "<thead><tr><td colspan='7' align='center' style='font-weight: bold; font-size:18px;'>COMPETENCIAS SELECIONADAS $periodo º PERIODO $aniolectivo</td></tr>";
	echo "</thead>";
	echo "<thead>";
	echo "<tr>";
	echo "<th>Codigo</th>";
	echo "<th>Competencia</th>";
	echo "<th  style='text-align: center;' >DS<br/>($rcsmin - $rcsmax)</th>";
	echo "<th style='text-align: center;'>DA<br/>($rcamin - $rcamax)</th>";
	echo "<th style='text-align: center;'>DB<br/>($rcbmin - $rcbmax)</th>";
	echo "<th style='text-align: center;'>Db<br/>($rcbamin - $rcbamax)</th>";
	echo "<th></th>";
	echo"</tr>";
	echo "</thead>";
	echo "<tbody>";
	while ($row = $conx->records_array($consulta)) {
		$id = $row['consecutivo'];
		echo "<tr>";
		echo "<td>".$row['consecutivo']."</td>";
		echo "<td>".($row['competencia'])."</td>";
		echo "<td>
		<select class='form-control' style='width: 80px; float: right;' id='cids$id' name='cids$id'>";
		if($row['DS']=='SC'){
			//echo "<option value='SC' selected>SC</option>
			echo "<option value='F'>F</option>
			<option value='D'>D</option>";
		}elseif($row['DS']=='F'){
			//echo "<option value='SC'>SC</option>
			echo "<option value='F' selected>F</option>
			<option value='D'>D</option>";
		}elseif($row['DS']=='D'){
			//echo "<option value='SC'>SC</option>
			echo "<option value='F'>F</option>
			<option value='D' selected>D</option>";
		}
		echo "</select></td>";
		echo "<td><select class='form-control' style='width: 80px; float: right;' id='cida$id' name='cida$id'>";
		if($row['DA']=='SC'){
			//echo "<option value='SC' selected>SC</option>
			echo "<option value='F'>F</option>
			<option value='D'>D</option>";
		}elseif($row['DA']=='F'){
			//echo "<option value='SC'>SC</option>
			echo "<option value='F' selected>F</option>
			<option value='D'>D</option>";
		}elseif($row['DA']=='D'){
			//echo "<option value='SC'>SC</option>
			echo "<option value='F'>F</option>
			<option value='D' selected>D</option>";
		}
		echo "</select>
		</form></td>";
		echo "<td><select class='form-control' style='width: 80px; float: right;' id='cidb$id' name='cidb$id'>";
		if($row['DB']=='SC'){
			//echo "<option value='SC' selected>SC</option>
			echo "<option value='F'>F</option>
			<option value='D'>D</option>";
		}elseif($row['DB']=='F'){
			//echo "<option value='SC'>SC</option>
			echo "<option value='F' selected>F</option>
			<option value='D'>D</option>";
		}elseif($row['DB']=='D'){
			//echo "<option value='SC'>SC</option>
			echo "<option value='F'>F</option>
			<option value='D' selected>D</option>";
		}
		echo "</select></td>";
		echo "<td><select class='form-control' style='width: 80px; float: right;' id='cidba$id' name='cidba$id'>";
		if($row['DBA']=='SC'){
			//echo "<option value='SC' selected>SC</option>
			echo "<option value='F'>F</option>
			<option value='D'>D</option>";
		}elseif($row['DBA']=='F'){
			//echo "<option value='SC'>SC</option>
			echo "<option value='F' selected>F</option>
			<option value='D'>D</option>";
		}elseif($row['DBA']=='D'){
			//echo "<option value='SC'>SC</option>
			echo "<option value='F'>F</option>
			<option value='D' selected>D</option>";
		}
		echo "</select></td>";
		echo "<td><button type='button' class='btn btn-danger' id='btnsave$id'>Guardar</button></td>";
		//echo "<td><input type='checkbox' id='idcompetencias[]' name='idcompetencias[]' value='$id'></td>";
		echo "</tr>";
		echo "<script>
		$(document).ready(function(){
			
		$('#btnsave$id').click(function(){
			ds1=  $('#cids$id').val();
			da1=  $('#cida$id').val();
			db1=  $('#cidb$id').val();
			dba1=  $('#cidba$id').val();
			$.post('guardarcategorizacion_response.php',
			{
				idcomp:'$id', ds:ds1,da:da1, db:db1, dba:dba1, periodo:'$periodo', idmateria:'$idmateria'
				, iddocente:'$docente', aniolectivo:'$aniolectivo', grado:'$grado'
			},
			function(data){
				if(data='ok'){
					$('#btnsave$id').fadeOut('slow');
					$('#btnsave$id').removeClass('btn btn-danger');
					$('#btnsave$id').fadeIn('slow');
					$('#btnsave$id').addClass('btn btn-success'); 
					 
				}else{
					$('#btnsave$id').fadeOut('slow');
					$('#btnsave$id').removeClass('btn btn-danger');
					$('#btnsave$id').fadeIn('slow');
					$('#btnsave$id').addClass('btn btn-warning');
				}
			});
			});	
		});
		</script>";
		
	}
	echo "</tbody>";
	echo "</table>";
	echo "</form>";
}else {
?>
	<div class="jumbotron center-block">
	<h2 class='alert alert-danger'>Usted no ha seleccionado competencias para esta asignatura en este periodo</h2>
	<p><a class='btn btn-lg btn-success '  href='categorizarcompetencia.php' role='button'>Volver</a></p>
	</div>
<?php

}
?>
<?php
	
?>