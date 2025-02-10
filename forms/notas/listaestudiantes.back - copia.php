<?php
include('../../class/MySqlClass.php');
$conx = new ConxMySQL("localhost","root","","appacademy");
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
/*$sql = "SELECT pc . *, eb.periodo, eb.aniolectivo FROM plan_curricular pc, indicadoresboletin eb
	WHERE eb.iddocente =$docente
	AND eb.idindicador = pc.consecutivo
	AND pc.estandarbc
	IN ( SELECT codigo FROM estandares WHERE idmateria_fk =$idmateria)
	AND eb.aniolectivo =$aniolectivo
	AND eb.periodo =$periodo
	ORDER BY eb.idindicador DESC";*/
	if($aniolectivo<2016){
		$sql = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
				pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
				FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
				(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
				and pc.estandarbc=ebc.codigo
				and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
				and eb.periodo =$periodo and eb.iddocente ='$iddocente' and eb.grado ='$grado'
				and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
				ORDER BY consecutivo DESC";
	}else{
		$sql = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
				pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
				FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
				(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
				and pc.estandarbc=ebc.codigo
				and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
				and eb.periodo =$periodo and eb.grado ='$grado'
				and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
				ORDER BY consecutivo DESC";
	}
$consulta = $conx->query($sql);
if($conx->get_numRecords($consulta)>0){
	
			if($aniolectivo<2016){
				$sql2 = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
				pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
				FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m, clase c WHERE  
				(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
				and pc.estandarbc=ebc.codigo
				and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
				and eb.periodo =$periodo and eb.iddocente ='$iddocente' and eb.grado ='$grado'
				and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area AND c.iddocente=eb.iddocente 
				AND ( c.periodos LIKE  '%$periodo%' and  c.idmateria=$idmateria)
				AND eb.idmateria=$idmateria
				ORDER BY consecutivo DESC";
			}else{
				$sql2 = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
				pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
				FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m, clase c WHERE  
				(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
				and pc.estandarbc=ebc.codigo
				and eb.idindicador=pc.consecutivo and eb.aniolectivo=$aniolectivo
				and eb.periodo=$periodo and eb.grado ='$grado'
				and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area AND c.iddocente='$iddocente' 
				AND ( c.periodos LIKE  '%$periodo%' and  c.idmateria=$idmateria)
				AND eb.idmateria=$idmateria
				ORDER BY consecutivo DESC";
			}
$consulta2 = $conx->query($sql2);
if($conx->get_numRecords($consulta2)>0){
			if($aniolectivo<2016){
				$sqlest = "SELECT e.idestudiante, e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula 
					FROM estudiante e, matricula m  
					WHERE e.idestudiante=m.idestudiante AND e.habilitado='S' 
					AND m.tipo_matricula='R' AND m.aniolectivo='$aniolectivo' AND m.idaula=$idaula AND m.idaula IN 
					(SELECT c.idaula FROM clase c, indicadoresboletin ib, plan_curricular i, aula a WHERE c.iddocente='$iddocente'
					AND c.idmateria=$idmateria AND c.aniolectivo=$aniolectivo
					AND ib.iddocente=c.iddocente
					AND ib.aniolectivo=c.aniolectivo
					AND ib.periodo=$periodo
					AND ib.idindicador=i.consecutivo
					AND c.idaula=a.idaula and a.grado='$grado' AND a.grado=ib.grado) 
					ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
			}else{
					$sqlest = "SELECT e.idestudiante, e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula 
					FROM estudiante e, matricula m  
					WHERE e.idestudiante=m.idestudiante AND e.habilitado='S' 
					AND m.tipo_matricula='R' AND m.aniolectivo='$aniolectivo' AND m.idaula=$idaula AND m.idaula IN 
					(SELECT DISTINCT a.idaula FROM indicadoresboletin ib, plan_curricular i, aula a WHERE
					ib.idmateria=$idmateria AND ib.aniolectivo=$aniolectivo
					AND ib.periodo=$periodo
					AND ib.idindicador=i.consecutivo
					AND a.grado='$grado' AND a.grado=ib.grado) 
					ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
			}
			$consultaest = $conx->query($sqlest);
?>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
<?php
$numreg=1;
while ($row = $conx->records_array($consultaest)) {
	$nombre=$row['apellido1']." ".$row['apellido2']." ".$row['nombre1']." ".$row['nombre2'];
	$id = $row['idestudiante'];
	//inicio de verificación de calificaciones
	///seleccionando indicadores escogidos por el docenbte en esta area y curso
	if($aniolectivo<2016){
		$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
					pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
					FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
					(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
					and pc.estandarbc=ebc.codigo
					and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
					and eb.periodo =$periodo and eb.iddocente ='$iddocente' and eb.grado ='$grado'
					and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
					ORDER BY consecutivo DESC";
	}else{
		$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
					pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
					FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
					(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
					and pc.estandarbc=ebc.codigo
					and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
					and eb.periodo =$periodo and eb.grado ='$grado'
					and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
					ORDER BY consecutivo DESC";
	}
	$consultaind = $conx->query($sqlind);
	$numind=$conx->get_numRecords($consultaind);
	$numindest=0;
	while ($rowind = $conx->records_array($consultaind)) {
		$sqldelinselect="SELECT * FROM indicadoresestudiante WHERE idindicador='".$rowind['consecutivo']."'
		and aniolectivo=$aniolectivo and periodo=$periodo and idestudiante='$id' and idmateria=$idmateria";
		$consultaindselect = $conx->query($sqldelinselect);
		if($rowindselect = $conx->records_array($consultaindselect)){
			$numindest++;
		}
	}
	
	//---fin verificar si ya se ha calificado
	//verificando si se ingreso nota del estudiante
	$sqldata1 = "SELECT DISTINCT e.idestudiante, e.nombre1, e.nombre2, e.apellido1, e.apellido2, n.* FROM estudiante e, notas n 
	WHERE e.idestudiante='$id' AND e.idestudiante=n.idestudiante  AND n.aniolectivo=$aniolectivo 
	AND n.tipo_nota='R' AND n.periodo=$periodo AND n.idmateria=$idmateria ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
	$consultadata1 = $conx->query($sqldata1);
	$numnota=$conx->get_numRecords($consultadata1);
	//fin verificando nota
	//mensajes 
	$msjest="";
	if($numindest<$numind and $numnota>0){
		$msjest="<span class='label label-warning'>Pendiente guardar competencias</span>";
	}elseif($numindest<$numind and $numnota<=0){
		$msjest="<span class='label label-danger'>Pendiente guardar competencias y nota</span>";
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
			  <?php echo utf8_encode($nombre)."(".$id.")"; ?><?php echo "<span id='info$id'>".$msjest."</span>";?>
			</a>
		  </h4>
		</div>
		<div id="collapse<?php echo $numreg ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="est<?php echo $id ?>">
		  <div class="panel-body">
			<?php 
			echo "<form id='notas$id' method='POST'>
				<table class='table table-bordered table-responsive'>";
				$flag=false;
				$escalas=$rcsmax;
				$escalai=$rcbamin;
				
				$colspan=2;
				echo "<tr><td colspan='3' style='width:400px;'>COMPETENCIA DE APRENDIZAJE</td></tr>";
				$numero=0; 	
				///seleccionando indicadores escogidos por el docenbte en esta area y curso
				if($aniolectivo<2016){
					$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
					pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
					FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
					(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
					and pc.estandarbc=ebc.codigo
					and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
					and eb.periodo =$periodo and eb.iddocente ='$iddocente' and eb.grado ='$grado'
					and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
					ORDER BY consecutivo DESC";
				}else{
					
					$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
					pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
					FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
					(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
					and pc.estandarbc=ebc.codigo
					and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
					and eb.periodo =$periodo and eb.grado ='$grado'
					and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
					ORDER BY consecutivo DESC";
				}
				$consultaind = $conx->query($sqlind);
				$numind=$conx->get_numRecords($consultaind);
				echo "<tr>";
				echo "<td colspan='3'>";
				echo "<table>";
				while ($rowind = $conx->records_array($consultaind)) {
					$sqldelinselect="SELECT * FROM indicadoresestudiante WHERE idindicador='".$rowind['consecutivo']."'
					and aniolectivo=$aniolectivo and periodo=$periodo and idestudiante='$id' and idmateria=$idmateria";
					$consultaindselect = $conx->query($sqldelinselect);
					echo "<tr>";
					echo "<td align='left' style='width:400px;font-size:13px; background-color:#BDBDBD;  border: 1px dashed #C60;'>".utf8_encode($rowind['competencia'])."
					</td>";
					echo "<td><select class='form-control' style='width: 150px; float: right;' id='ci$id-".$rowind['consecutivo']."' name='ci$id-".$rowind['consecutivo']."'>";
					if($rowindselect = $conx->records_array($consultaindselect)){
						if($rowindselect['nivel_aprendizaje']=='F'){
							echo "<option value='F' selected>Fortaleza</option><option value='D'>Debilidad</option>";
						}else{
							echo "<option value='F'>Fortaleza</option><option value='D' selected>Debilidad</option>";	
						}
					}else{	
						echo "<option value='F'>Fortaleza</option><option value='D'>Debilidad</option>
						</select></td>";
					}
					echo "</tr>";
				}
				$sqldata = "SELECT DISTINCT e.idestudiante, e.nombre1, e.nombre2, e.apellido1, e.apellido2, n.* FROM estudiante e, notas n 
				WHERE e.idestudiante='$id' AND e.idestudiante=n.idestudiante  AND n.aniolectivo=$aniolectivo 
				AND n.tipo_nota='R' AND n.periodo=$periodo AND n.idmateria=$idmateria ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
				$consultadata = $conx->query($sqldata);
				if($row = $conx->records_array($consultadata)){
					echo "</table>";
					echo "</td></tr>";
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
					echo "</table>";
					echo "</td></tr>";
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
			?>
		  </div>
		</div>
	  </div>
	<?php
	///seleccionando indicadores escogidos por el docenbte en esta area y curso
	
	
		echo "<script>
			$(document).ready(function(){
				$( '#vn$id' ).keyup(function() {
					var num = this.value;
					var valor = parseFloat(num);
				";
				if($aniolectivo<2016){
					$sqlind2= "SELECT DISTINCT eb.* 
					FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
					(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
					and pc.estandarbc=ebc.codigo
					and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
					and eb.periodo =$periodo and eb.iddocente ='$iddocente' and eb.grado ='$grado'
					and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
					ORDER BY consecutivo DESC";
				}else{
					$sqlind2= "SELECT DISTINCT eb.* 
					FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
					(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
					and pc.estandarbc=ebc.codigo
					and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
					and eb.periodo =$periodo and eb.grado ='$grado'
					and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
					ORDER BY consecutivo DESC";
				}
				$consultaind2 = $conx->query($sqlind2);
				while ($rowind2= $conx->records_array($consultaind2)) {
					$idcomp=$rowind2['idindicador'];
					$categoriaDS=$rowind2['DS'];
					$categoriaDA=$rowind2['DA'];
					$categoriaDB=$rowind2['DB'];
					$categoriaDBA=$rowind2['DBA'];
					echo "if(valor>=$rcsmin && valor<=$rcsmax){";
					if($categoriaDS=='F'){
						echo "$('#ci$id"."-"."$idcomp option[value=F]').attr('selected',true);";
					}elseif($categoriaDS=='D'){
						echo "$('#ci$id"."-"."$idcomp option[value=D]').attr('selected',true);";
					}
					echo "}else if(valor>=$rcamin && valor<=$rcamax){";
					if($categoriaDA=='F'){
						echo "$('#ci$id"."-"."$idcomp option[value=F]').attr('selected',true);";
					}elseif($categoriaDA=='D'){
						echo "$('#ci$id"."-"."$idcomp option[value=D]').attr('selected',true);";
					}
					echo "}else if(valor>=$rcbmin && valor<=$rcbmax){";
					if($categoriaDB=='F'){
						
						echo "$('#ci$id"."-"."$idcomp option[value=F]').attr('selected',true);";
					}elseif($categoriaDB=='D'){
						echo "$('#ci$id"."-"."$idcomp option[value=D]').attr('selected',true);";
					}
					echo "}else if(valor>=$rcbamin && valor<=$rcbamax){";
					if($categoriaDBA=='F'){
						echo "$('#ci$id"."-"."$idcomp option[value=F]').attr('selected',true);";
					}elseif($categoriaDBA=='D'){
						echo "$('#ci$id"."-"."$idcomp option[value=D]').attr('selected',true);";
					}
					echo "}";
				
				}
					
		echo"
				});
			});
		</script>";
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
					var url = 'guardarcalificacion_response.php'; // El script a dónde se realizará la petición.
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
				var url = 'borrarcalificaciones.php'; // El script a dónde se realizará la petición.
				$.ajax({
				   type: 'POST',
				   url: url,
				   data: $('#notas$id').serialize(), // Adjuntar los campos del formulario enviado.
				   success: function(data)
				   {
						$('#status$id').fadeIn();
						$('#status$id').html(data);
						$('#info$id').html('<span class=\"label label-danger\">Pendiente guardar competencias y nota</span>');
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
}else{
		?>
	<div class="jumbotron center-block">
	<h2 class='alert alert-danger'>Usted no esta habilitado para calificar esta asignatura en este periodo</h2>
	<p><a class='btn btn-lg btn-success '  href='ingresarcalificaciones.php' role='button'>Volver</a></p>
	</div>
		
	<?php
}
		
}else {
	
?>
	<?php
	if($aniolectivo<2016){
	?>
	<div class="jumbotron center-block">
		<h2 class='alert alert-danger'>Usted no ha seleccionado competencias para esta asignatura en este periodo</h2>
		<p><a class='btn btn-lg btn-success '  href='ingresarcalificaciones.php' role='button'>Volver</a></p>
	</div>
	<?php
	}else{
		$sqlnom="select distinct d.* FROM docente d, jefearea ja, aula a WHERE
		d.iddocente=ja.iddocente AND ja.idmateria=$idmateria AND ja.aniolectivo=$aniolectivo";
		$consultanom = $conx->query($sqlnom);
		$jefearea='';
		if($conx->get_numRecords($consultanom)>0){
			$records = $conx->records_array($consulta);
			$jefearea=$records['nombre1']." ".$records['apellido1']; 
		}
	?>
	
	<div class="jumbotron center-block">
		<h2 class='alert alert-danger'>El jefe de area no ha seleccionado competencias para esta asignatura en este periodo<br/>JEFE DE AREA: <?php echo $jefearea;?></h2>
		<p><a class='btn btn-lg btn-success '  href='ingresarcalificaciones.php' role='button'>Volver</a></p>
	</div>
<?php
	}
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