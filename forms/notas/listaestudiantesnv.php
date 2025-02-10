<?php
include('../../class/MySqlClass.php');
include("../../class/puesto.php");
include('../../bdConfig.php');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$periodo = $_POST['periodo'];
$idmateria = $_POST['idmateria'];
$aniolectivo = $_POST['aniolectivo'];
$iddocente = $_POST['iddocente'];
$limit_end = $_POST['limit_end'];
$init = $_POST['init'];
$idaula = $_POST['idaula'];
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
/*$sqlest = "SELECT e.idestudiante, e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula 
				FROM estudiante e, matricula m  
				WHERE e.idestudiante=m.idestudiante AND e.habilitado='S' 
				AND m.tipo_matricula='N' AND m.aniolectivo='$aniolectivo' AND m.idaula=$idaula AND m.idaula IN 
				(SELECT c.idaula FROM clase c, aula a WHERE c.iddocente='$iddocente'
				AND c.idmateria=$idmateria AND c.aniolectivo=$aniolectivo
				AND c.idaula=a.idaula and a.grado='$grado') AND m.periodo=$periodo
				ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";*/
$sqlest = "SELECT e.idestudiante, e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula 
				FROM estudiante e, matricula m  
				WHERE e.idestudiante=m.idestudiante AND e.habilitado='S' 
				AND m.tipo_matricula='R' AND m.aniolectivo='$aniolectivo' AND m.idaula=$idaula 
				ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
$consulta2 = $conx->query($sqlest);
if($conx->get_numRecords($consulta2)>0){
$consultaest = $conx->query($sqlest);
?>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
<?php
$numreg=1;
while ($row = $conx->records_array($consultaest)) {
	$nombre=$row['apellido1']." ".$row['apellido2']." ".$row['nombre1']." ".$row['nombre2'];
	$id = $row['idestudiante'];
	//---fin verificar si ya se ha calificado
	//verificando si se ingreso nota del estudiante
	$sqldata1 = "SELECT DISTINCT e.idestudiante, e.nombre1, e.nombre2, e.apellido1, e.apellido2, n.* FROM estudiante e, notas n 
	WHERE e.idestudiante='$id' AND e.idestudiante=n.idestudiante  AND n.aniolectivo=$aniolectivo 
	AND n.tipo_nota='N' AND n.periodo=$periodo AND n.idmateria=$idmateria ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
	$consultadata1 = $conx->query($sqldata1);
	$numnota=$conx->get_numRecords($consultadata1);
	//fin verificando nota
	//mensajes 
	$msjest="";
	if($numnota<=0){
		switch($periodo){
					case 1: $promNota= promedioAnioAlg2MateriaNV($id, $idaula, $aniolectivo,1,1,$idmateria); break;
					case 2: $promNota= promedioAnioAlg2MateriaNV($id, $idaula, $aniolectivo,2,2,$idmateria); break;
					case 3: $promNota= promedioAnioAlg2MateriaNV($id, $idaula, $aniolectivo,3,3,$idmateria); break;
					case 4: $promNota= promedioAnioAlg2MateriaNV($id, $idaula, $aniolectivo,4,4,$idmateria); break;
					case 5: $promNota= promedioAnioAlg2MateriaNV($id, $idaula, $aniolectivo,1,2,$idmateria); break;
					case 6: $promNota= promedioAnioAlg2MateriaNV($id, $idaula, $aniolectivo,3,4,$idmateria); break;
					case 7: $promNota= promedioAnioAlg2MateriaNV($id, $idaula, $aniolectivo,1,4,$idmateria); break;
				}
		if($promNota<3.0){
			$msjest="<span class='label label-danger'>Pendiente guardar nota</span>";
		}else{
			$msjest="<span class='label-label-success'><img src='../../images/block.png' width='18' height='18'></img></span>";
		}
	}else{
		$msjest="<span class='label-label-success'><img src='../../images/okcheck.png' width='18' height='18'></img></span>";
	}
	//fin mensajes
	?>
	<div class="panel panel-default">
		<div class="<?php if(($numreg % 2)==0){ echo "btn-info btn-lg";}else{ echo "btn-primary btn-lg";} ?> role="tab" id="est<?php echo $id ?>">
		  <h4 class="panel-title">
			<a role="button" data-toggle="collapse" data-parent="#accordion" 
			href="#collapse<?php echo $numreg ?>" aria-expanded="true" aria-controls="collapse<?php echo $numreg ?>">
			  <?php echo utf8_encode($nombre)."(".$id.")"; ?><?php echo "<span id='info$id'> ".$msjest."</span>";?>
			</a>
		  </h4>
		</div>
		<div id="collapse<?php echo $numreg ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="est<?php echo $id ?>">
		  <div class="panel-body">
			<?php 
		
				$flag=false;
				$escalas=$rcsmax;
				$escalai=$rcbamin;
				
				$colspan=2;
				switch($periodo){
					case 1: $promNota= promedioAnioAlg2MateriaNV($id, $idaula, $aniolectivo,1,1,$idmateria); break;
					case 2: $promNota= promedioAnioAlg2MateriaNV($id, $idaula, $aniolectivo,2,2,$idmateria); break;
					case 3: $promNota= promedioAnioAlg2MateriaNV($id, $idaula, $aniolectivo,3,3,$idmateria); break;
					case 4: $promNota= promedioAnioAlg2MateriaNV($id, $idaula, $aniolectivo,4,4,$idmateria); break;
					case 5: $promNota= promedioAnioAlg2MateriaNV($id, $idaula, $aniolectivo,1,2,$idmateria); break;
					case 6: $promNota= promedioAnioAlg2MateriaNV($id, $idaula, $aniolectivo,3,4,$idmateria); break;
					case 7: $promNota= promedioAnioAlg2MateriaNV($id, $idaula, $aniolectivo,1,4,$idmateria); break;
				}
				
				if($promNota<3.0){
					echo "<form id='notas$id' method='POST'>";
					$sqldata = "SELECT DISTINCT e.idestudiante, e.nombre1, e.nombre2, e.apellido1, e.apellido2, n.* FROM estudiante e, notas n 
					WHERE e.idestudiante='$id' AND e.idestudiante=n.idestudiante  AND n.aniolectivo=$aniolectivo 
					AND n.tipo_nota='N' AND n.periodo=$periodo AND n.idmateria=$idmateria ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
					$consultadata = $conx->query($sqldata);
					if($row = $conx->records_array($consultadata)){
						echo "<table class='table table-bordered table-responsive'>";
						echo "<tr><td>V.N</td><td>Ausencias J</td><td>Ausencias S.J</td></tr>";
						echo "<tr>";
						echo "<td align='center'><input class='form-control' type='text' id='vn$id' name='vn$id' size='2' maxlength='4' value='".$row['vn']."'/></td>";
						echo "<td align='center'><input class='form-control' type='text' id='fj$id' name='fj$id' size='2' maxlength='4' value='".$row['fj']."'/></td>";
						echo "<td align='center'><input class='form-control' type='text' id='fsj$id' name='fsj$id' size='2' maxlength='4' value='".$row['fsj']."'/></td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td align='left' width='300px' colspan='3'>Observaciones:<br/>";
						if($row['observaciones']==NULL){
							echo "<textarea class='form-control' id='obs$id' name='obs$id' cols='110' rows='5' class='toolTip' title='Desactive la casilla para ingresar un aobservación' readonly></textarea>
							<br/><input type='checkbox' id='idestudiante[]' name='idestudiante[]' value='$id' checked >Bloquear escritura";
						}else{
							echo "<textarea id='obs$id' name='obs$id' cols='110' rows='5' class='toolTip' title='Desactive la casilla para ingresar un aobservación' readonly>".$row['observaciones']."</textarea>
							<br/><input type='checkbox' id='idestudiante[]' name='idestudiante[]' value='$id'>Bloquear escritura";
							
						}
						echo "</tr>
						<tr><td colspan='3' align='left'>
						<button type='button' class='btn btn-success' id='btnsave$id'>Guardar</button>
						<button type='button' class='btn btn-warning'  id='btndelete$id'>Borrar Calificación</button>
						<div id='status$id'><div class='alert alert-success' role='alert'>Calificación guardada</div>'</div>
						</td>";
						echo "</tr>";
						
					}else{
						echo "<table class='table table-bordered table-responsive'>";
						echo "<tr><td>V.N</td><td>Ausencias J</td><td>Ausencias S.J</td></tr>";
						echo "<tr>";
						echo "<td align='center'><input type='text' id='vn$id' name='vn$id' size='2' maxlength='4'/></td>";
						echo "<td align='center'><input type='text' id='fj$id' name='fj$id' size='2' maxlength='4'/></td>";
						echo "<td align='center'><input type='text' id='fsj$id' name='fsj$id' size='2' maxlength='4'/></td>";
						echo "</tr>";
						echo "<tr>";
						echo "<td align='left' width='300px' colspan='3'>Observaciones:<br/>
						<textarea id='obs$id' name='obs$id' cols='110' rows='5' class='toolTip' title='Desactive la casilla para ingresar un aobservación' readonly></textarea>
						<br/><input type='checkbox' id='idestudiante[]' name='idestudiante[]' value='$id' checked >Bloquear escritura";
						echo "</tr>
						<tr><td colspan='3' align='left'>
						<button type='button' class='btn btn-success' id='btnsave$id'>Guardar</button>
						<button type='button' class='btn btn-warning'  id='btndelete$id'>Borrar Calificación</button>
						<div id='status$id'><div class='alert alert-danger' role='alert'>Calificación sin guardar</div>'</div>
						</td>";
						echo "</tr>";
					}
					
					echo "</table>";
					echo "
						<input type='hidden' id='id' name='id' value='$id'>
						<input type='hidden' id='periodo' name='periodo' value='$periodo'>
						<input type='hidden' id='idmateria' name='idmateria' value='$idmateria'>
						<input type='hidden' id='idaula' name='idaula' value='$idaula'></td>
						<input type='hidden' id='iddocente' name='iddocente' value='$iddocente'></td>
						<input type='hidden' id='grado' name='grado' value='$grado'></td>
						<input type='hidden' id='aniolectivo' name='aniolectivo' value='$aniolectivo'>";
					echo "</form>";
				}else{
					?>

							<p class="alert alert-info" role="alert">El(la) estudiante no esta perdiendo la asignatura ya que su promedio es <?php echo $promNota;?>. Por lo tanto no se pertime la nivelación.</p>
					<?php
				}
			?>
		  </div>
		</div>
	  </div>
	<?php
	echo "<script>
		$(document).ready(function(){
			$('#vn$id').change(function(e){
				e.preventDefault();
				var num = $('#vn$id').val();
				var valor = parseFloat(num);
				if(isNaN(valor)){
					alert('Debe ingresar un numero');
					$('#vn$id').focus();
					$('#vn$id').val('');
				}else{
					if(valor<$escalai || valor>$escalas){
						alert('La valoración numerica no esta dentro del rango configurado');
						$('#vn$id').focus();
						$('#vn$id').val('');
					}
				}
			});
					
			$('#fj$id').change(function(e){
				e.preventDefault();
				var num = $('#fj$id').val();
				var valor = parseInt(num);
				if(isNaN(valor)){
					alert('Debe ingresar un numero');
					$('#fj$id').focus();
					$('#fj$id').val('0');
				}else{
					if(valor<0){
						alert('El valor ingresado ser mayor o igual a cero');
						$('#fj$id').focus();
						$('#fj$id').val('0');
						
					}
				}
			});
			$('#fsj$id').change(function(e){
				e.preventDefault();
				var num = $('#fsj$id').val();
				var valor = parseInt(num);
				if(isNaN(valor)){
					alert('Debe ingresar un numero');
					$('#fsj$id').focus();
					$('#fsj$id').val('0');
				}else{
					if(valor<0){
						alert('El valor ingresado ser mayor o igual a cero');
						$('#fsj$id').focus();
						$('#fsj$id').val('0');
						
					}
				}
			});
			$('#btnsave$id').click(function(){
				$('#status$id').fadeOut('slow');
				var num = $('#vn$id').val();
				var valor = parseFloat(num);
				if(isNaN(valor)){
					alert('Para guardar debe ingresar la V.N');
					$('#vn$id').focus();
					$('#vn$id').val('');
				}else{
					var url = 'guardarcalificacionnv_response.php'; // El script a dónde se realizará la petición.
					$.ajax({
					   type: 'POST',
					   url: url,
					   data: $('#notas$id').serialize(), // Adjuntar los campos del formulario enviado.
					   success: function(data)
					   {
							$('#status$id').fadeIn();
							$('#status$id').html(data);
							$('#info$id').html('<img src=\"../../images/okcheck.png\" width=\"18\" height=\"18\"></img>');
							
					   }
					 });
						return false; // Evitar ejecutar el submit del formulario.
				}
			});
			$('#btndelete$id').click(function(){
				var url = 'borrarcalificacionesnv.php'; // El script a dónde se realizará la petición.
				$.ajax({
				   type: 'POST',
				   url: url,
				   data: $('#notas$id').serialize(), // Adjuntar los campos del formulario enviado.
				   success: function(data)
				   {
						$('#status$id').fadeIn();
						$('#status$id').html(data);
						$('#info$id').html('<span class=\"label label-danger\">Pendiente guardar nota</span>');
						$('#vn$id').val('');
						$('#fj$id').val('');
						$('#fsj$id').val('');
						$('#obs$id').val('');
						
				   }
				 });
			});
			$('#status$id').show();
		});
	</script>";
	$numreg++;
}
?>
</div>
<?php

}else {
	
?>

	<div class="jumbotron center-block">
		<h2 class='alert alert-danger'>No existen estudiantes matriculados para nivelar en el periodo seleccionado</h2>
		<p><a class='btn btn-lg btn-success '  href='ingresarcalificacionesnv.php' role='button'>Volver</a></p>
		</div>
<?php
}
?>
 <script>
	$("input:checkbox").click(function(){
		var id = $(this).attr("value");
		if($(this).is(":checked")){
			$("#obs"+id).attr('readonly', true);
		}else{
			$("#obs"+id).attr('readonly', false);
			
		}
	});
		
</script>