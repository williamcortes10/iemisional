<?php
include('../../class/MySqlClass.php');
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
$sqlrc = "SELECT tipo_escala, rango_inferior, rango_superior, aniolectivo FROM escala_de_calificacion WHERE aniolectivo = $aniolectivo";
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
				pc.estandarbc, ebc.descripcion, eb.* 
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
					/*$sqlest = "SELECT e.idestudiante, e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula 
					FROM estudiante e, matricula m  
					WHERE e.idestudiante=m.idestudiante AND e.habilitado='S' 
					AND m.tipo_matricula='R' AND m.aniolectivo='$aniolectivo' AND m.idaula=$idaula AND m.idaula IN 
					(SELECT DISTINCT a.idaula FROM indicadoresboletin ib, plan_curricular i, aula a WHERE
					ib.idmateria=$idmateria AND ib.aniolectivo=$aniolectivo
					AND ib.periodo=$periodo
					AND ib.idindicador=i.consecutivo
					AND a.grado='$grado' AND a.grado=ib.grado) 
					ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";*/
					$sqlest = "SELECT DISTINCT 
					e.apellido1, e.apellido2, 
					e.nombre1, e.nombre2, m.idaula, e.idestudiante 
					FROM estudiante e
					LEFT JOIN matricula m
					ON e.idestudiante=m.idestudiante
					WHERE m.aniolectivo=$aniolectivo
					AND m.idaula=$idaula
					AND m.tipo_matricula='R'
					AND m.periodo=0
					AND e.habilitado='S'
					ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC
					";
					
			}
			$consultaest = $conx->query($sqlest);
			echo "<div id='tablacompetencias'><table class='table table-hover table-striped' style='text-align:left;'>";
			echo "<thead><tr><td colspan='7' align='center' style='font-weight: bold; font-size:18px;'>COMPETENCIAS SELECIONADAS $periodo ° PERIODO $aniolectivo</td></tr>";
			echo "</thead>";
			echo "<thead>";
			echo "<tr>";
			echo "<th>Codigo</th>";
			echo "<th width='60%'>Competencia</th>";
			echo "<th  style='text-align: center;' >DS<br/>($rcsmin - $rcsmax)</th>";
			echo "<th style='text-align: center;'>DA<br/>($rcamin - $rcamax)</th>";
			echo "<th style='text-align: center;'>DB<br/>($rcbmin - $rcbmax)</th>";
			echo "<th style='text-align: center;'>Db<br/>($rcbamin - $rcbamax)</th>";
			echo "<th></th>";
			echo"</tr>";
			echo "</thead>";
			echo "<tbody>";
			while ($row = $conx->records_array($consulta2)) {
				$id = $row['consecutivo'];
				echo "<tr>";
				echo "<td>".$row['consecutivo']."</td>";
				echo "<td>".utf8_encode($row['competencia'])."</td>";
				echo "<td style='text-align: center;' >".$row['DS']."</td>";
				echo "<td style='text-align: center;' >".$row['DA']."</td>";
				echo "<td style='text-align: center;' >".$row['DB']."</td>";
				echo "<td style='text-align: center;' >".$row['DBA']."</td>";
				echo "</tr>";
				
				
			}
			echo "</tbody>";
			echo "</table></div>";
?>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
<?php
$numreg=1;
?>
<table class='table table-bordered table-responsive scroll'>
<tr>
	<th>Nro.</th><th>Estudiante</th><th title="Valoración Númerica">Nota (V.N)</th><th title="Faltas Justificadas">F.J</th><th title="Faltas Sin Justificar">F.S.J</th><th>Observaciones</th><th></th>
</tr>
<?php
while ($row = $conx->records_array($consultaest)) {
	$id = $row['idestudiante'];
	$nombre=ucwords($row['apellido1'])." ".$row['apellido2']." ".$row['nombre1']." ".$row['nombre2'];
	$nombre=utf8_encode("(".$id.") ".$nombre);
		$flag=false;
		$escalas=$rcsmax;
		$escalai=$rcbamin;
		$colspan=2;
		$numero=0; 
		?>
		<tr>
			<td align="left"><?php echo $numreg;?></td>
			<td id="tdname<?php echo $id;?>" align="left" style="text-transform: capitalize;" width="450px"><?php echo $nombre;?></td>
		<?php
		/*$sqldata = "SELECT DISTINCT e.idestudiante, e.nombre1, e.nombre2, e.apellido1, e.apellido2, n.* FROM estudiante e, notas n 
		WHERE e.idestudiante='$id' AND e.idestudiante=n.idestudiante  AND n.aniolectivo=$aniolectivo 
		AND n.tipo_nota='R' AND n.periodo=$periodo AND n.idmateria=$idmateria ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";*/
		$sqldata = "SELECT DISTINCT e.idestudiante, e.nombre1, e.nombre2, e.apellido1, e.apellido2, n.* FROM estudiante e
		LEFT JOIN notas n ON n.idestudiante=e.idestudiante
		WHERE e.idestudiante='$id' AND n.aniolectivo=$aniolectivo 
		AND n.tipo_nota='R' AND n.periodo=$periodo AND n.idmateria=$idmateria ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
		$consultadata = $conx->query($sqldata);
		if($row = $conx->records_array($consultadata)){
			?>
				<td align="left" width="40px">
				<div class="input-group">
				<?php
				  echo "<input data-toggle='tooltip' title='Ingese un valor entre $escalai y $escalas' value='".$row['vn']."' type='text' id='vn$id' name='vn$id' size='2' maxlength='4'/ ><span id='infovn$id'  class='input-group-addon'><i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i></span>"; ?>
				</td>
				</div>
				<td align="left" width="40px">
				<div class="input-group">
				<?php echo "<input data-toggle='tooltip' title='Faltas justificadas' value='".$row['fj']."' type='text' id='fj$id' name='fj$id' size='2' maxlength='4'/><span id='infofj$id' class='input-group-addon'><i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i></span>"; ?>
				</td>
				</div>
				<td align="left" width="40px">
				<div class="input-group">
				<?php echo "<input data-toggle='tooltip' title='Faltas sin justificar' value='".$row['fsj']."' type='text' id='fsj$id' name='fsj$id' size='2' maxlength='4'/><span id='infofsj$id' class='input-group-addon'><i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i></span>"; ?>
				</td>
				</div>
				<td align="left">
				<?php echo "<textarea id='obs$id' name='obs$id' cols='50' rows='1' maxlength='60' class='toolTip' data-toggle='tooltip' title='Máximo 60 caracteres'>".$row['observaciones']."</textarea><span id='contador$id' class=''></span>"; ?>
				</td>
			<?php 
			
		}else{
			?>
				<td align="left" width="40px">
				<div class="input-group">
				<?php
				  echo "<input data-toggle='tooltip' title='Ingese un valor entre $escalai y $escalas' class='' type='text' id='vn$id' name='vn$id' size='2' maxlength='4'/><span id='infovn$id'  class='input-group-addon'></span>"; ?>
				</td>
				</div>
				<td align="left" width="40px">
				<div class="input-group">
				<?php echo "<input data-toggle='tooltip' title='Faltas justificadas' type='text' id='fj$id' name='fj$id' size='2' maxlength='4'/><span id='infofj$id' class='input-group-addon'></span>"; ?>
				</td>
				</div>
				<td align="left" width="40px">
				<div class="input-group">
				<?php echo "<input data-toggle='tooltip' title='Faltas sin justificar' type='text' id='fsj$id' name='fsj$id' size='2' maxlength='4'/><span id='infofsj$id' class='input-group-addon'></span>"; ?>
				</td>
				</div>
				<td align="left">
				<?php echo "<textarea id='obs$id' name='obs$id' cols='50' rows='1' maxlength='60' class='toolTip' data-toggle='tooltip' title='Máximo 60 caracteres'></textarea><span id='contador$id' class=''></span>"; ?>
				</td>
			<?php 
		}
		
	echo "
		<input type='hidden' id='estudiante$id' name='estudiante$id' value='$id'>
		<input type='hidden' id='periodo$id' name='periodo$id' value='$periodo'>
		<input type='hidden' id='idmateria$id' name='idmateria$id' value='$idmateria'>
		<input type='hidden' id='idaula$id' name='idaula$id' value='$idaula'></td>
		<input type='hidden' id='iddocente$id' name='iddocente$id' value='$iddocente'></td>
		<input type='hidden' id='grado$id' name='grado$id' value='$grado'></td>
		<input type='hidden' id='aniolectivo$id' name='aniolectivo$id' value='$aniolectivo'>";
		?>
		<td>
		<button type='button' class='btn btn-danger'  id='<?php echo "btndelete$id";?>'>Eliminar Calificación</button>
		</td>
		</tr>
		<?php
	echo "<script>
		$(document).ready(function(){
			$('[data-toggle=\"tooltip\"]').tooltip();
			$('#vn$id').focus(
				function(){
					$('#tdname$id').css({'font-weight' : 'bold'});
					$('#vn$id').css({'background-color' : '#7FFF00'});
					$('#fj$id').css({'background-color' : '#7FFF00'});
					$('#fsj$id').css({'background-color' : '#7FFF00'});
					$('#obs$id').css({'background-color' : '#7FFF00'});
				});

				$('#vn$id').blur(
				function(){
					$('#tdname$id').css({'font-weight' : 'normal'});
					$(this).css({'background-color' : '#FFFFFF'});
					$('#vn$id').css({'background-color' : '#FFFFFF'});
					$('#fj$id').css({'background-color' : '#FFFFFF'});
					$('#fsj$id').css({'background-color' : '#FFFFFF'});
					$('#obs$id').css({'background-color' : '#FFFFFF'});
			});
			$('#fj$id').focus(
				function(){
					$('#tdname$id').css({'font-weight' : 'bold'});
					$('#vn$id').css({'background-color' : '#7FFF00'});
					$('#fj$id').css({'background-color' : '#7FFF00'});
					$('#fsj$id').css({'background-color' : '#7FFF00'});
					$('#obs$id').css({'background-color' : '#7FFF00'});
				});

				$('#fj$id').blur(
				function(){
					$('#tdname$id').css({'font-weight' : 'normal'});
					$(this).css({'background-color' : '#FFFFFF'});
					$('#vn$id').css({'background-color' : '#FFFFFF'});
					$('#fj$id').css({'background-color' : '#FFFFFF'});
					$('#fsj$id').css({'background-color' : '#FFFFFF'});
					$('#obs$id').css({'background-color' : '#FFFFFF'});
			});
			$('#fsj$id').focus(
				function(){
					$('#tdname$id').css({'font-weight' : 'bold'});
					$('#vn$id').css({'background-color' : '#7FFF00'});
					$('#fj$id').css({'background-color' : '#7FFF00'});
					$('#fsj$id').css({'background-color' : '#7FFF00'});
					$('#obs$id').css({'background-color' : '#7FFF00'});
				});

				$('#fsj$id').blur(
				function(){
					$('#tdname$id').css({'font-weight' : 'normal'});
					$('#vn$id').css({'background-color' : '#FFFFFF'});
					$('#fj$id').css({'background-color' : '#FFFFFF'});
					$('#fsj$id').css({'background-color' : '#FFFFFF'});
					$('#obs$id').css({'background-color' : '#FFFFFF'});
			});
			$('#obs$id').focus(
				function(){
					$('#tdname$id').css({'font-weight' : 'bold'});
					$('#vn$id').css({'background-color' : '#7FFF00'});
					$('#fj$id').css({'background-color' : '#7FFF00'});
					$('#fsj$id').css({'background-color' : '#7FFF00'});
					$('#obs$id').css({'background-color' : '#7FFF00'});
				});

				$('#obs$id').blur(
				function(){
					$('#tdname$id').css({'font-weight' : 'normal'});
					$('#vn$id').css({'background-color' : '#FFFFFF'});
					$('#fj$id').css({'background-color' : '#FFFFFF'});
					$('#fsj$id').css({'background-color' : '#FFFFFF'});
					$('#obs$id').css({'background-color' : '#FFFFFF'});
					$('#contador$id').html('');
			});
			$('#obs$id').keyup(
				function(){
					var max_chars = $('#obs$id').prop('maxlength');;
					var chars = $(this).val().length;
					var diff = max_chars - chars;
					$('#contador$id').html(diff+' caracteres.');   
								
			});
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
					}else{
						if(isNaN(valor)){
							alert('Para guardar debe ingresar la V.N');
							$('#vn$id').focus();
							$('#vn$id').val('');
						}else{
							if($('#fsj$id').val()==''){
								$('#fsj$id').val('0');
							}
							if($('#fj$id').val()==''){
									$('#fj$id').val('0');
							}
							var url = 'guardarcalificacion_response.php'; // El script a dónde se realizará la petición.
							estudianteid = $('#estudiante$id').val();
							periodoid = $('#periodo$id').val();
							idmateriaid = $('#idmateria$id').val();
							idaulaid = $('#idaula$id').val();
							iddocenteid = $('#iddocente$id').val();
							gradoid = $('#grado$id').val();
							aniolectivoid = $('#aniolectivo$id').val();
							$.ajax({
							   type: 'POST',
							   url: url,
							   data: {id : estudianteid,
								periodo : periodoid,
								idmateria : idmateriaid,
								idaula : idaulaid,
								iddocente : iddocenteid,
								grado : gradoid,
								aniolectivo : aniolectivoid,
								vn$id : $('#vn$id').val(),
								fj$id : $('#fj$id').val(),
								fsj$id : $('#fsj$id').val(),
								obs$id : $('#obs$id').val()}, // Adjuntar los campos del formulario enviado.
								success: function(data){
								$('#infovn$id').html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
								$('#infovn$id').fadeOut(200).delay(100).fadeIn(200);
								$('#infofj$id').html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
								$('#infofj$id').fadeOut(200).delay(100).fadeIn(200);
								$('#infofsj$id').html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
								$('#infofsj$id').fadeOut(200).delay(100).fadeIn(200);
								$('#obs$id').fadeOut(200).delay(100).fadeIn(200);
								}
							});
							
						}
					}
				}
			});
					
			$('#fj$id').change(function(e){
				e.preventDefault();
				var num = $('#fj$id').val();
				var valor = parseInt(num);
				if(isNaN(valor)){
					alert('Debe ingresar numeros en el campo F.J');
					$('#fj$id').focus();
					$('#fj$id').val('0');
				}else{
					if(valor<0){
						alert('El valor ingresado ser mayor o igual a cero');
						$('#fj$id').focus();
						$('#fj$id').val('0');
						
					}else{
						var num = $('#vn$id').val();
						var valorvn = parseFloat(num);
						if(isNaN(valorvn)){
							alert('Debe ingresar solo numeros en el campo V.N');
							$('#vn$id').focus();
							$('#vn$id').val('');
							
						}else{
							if(valorvn<$escalai || valorvn>$escalas){
								alert('La valoración numerica no esta dentro del rango configurado');
								$('#vn$id').focus();
								$('#vn$id').val('');
							}else{
								if(isNaN(valorvn)){
									alert('Para guardar debe ingresar la V.N');
									$('#vn$id').focus();
									$('#vn$id').val('');
								}else{
									var url = 'guardarcalificacion_response.php'; // El script a dónde se realizará la petición.
									estudianteid = $('#estudiante$id').val();
									periodoid = $('#periodo$id').val();
									idmateriaid = $('#idmateria$id').val();
									idaulaid = $('#idaula$id').val();
									iddocenteid = $('#iddocente$id').val();
									gradoid = $('#grado$id').val();
									aniolectivoid = $('#aniolectivo$id').val();
									if($('#fsj$id').val()==''){
										$('#fsj$id').val('0');
									}
									if($('#fj$id').val()==''){
											$('#fj$id').val('0');
									}
									$.ajax({
									   type: 'POST',
									   url: url,
									   data: {id : estudianteid,
										periodo : periodoid,
										idmateria : idmateriaid,
										idaula : idaulaid,
										iddocente : iddocenteid,
										grado : gradoid,
										aniolectivo : aniolectivoid,
										vn$id : $('#vn$id').val(),
										fj$id : $('#fj$id').val(),
										fsj$id : $('#fsj$id').val(),
										obs$id : $('#obs$id').val()}, // Adjuntar los campos del formulario enviado.
										success: function(data){
										$('#infovn$id').html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
										$('#infovn$id').fadeOut(200).delay(100).fadeIn(200);
										$('#infofj$id').html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
										$('#infofj$id').fadeOut(200).delay(100).fadeIn(200);
										$('#infofsj$id').html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
										$('#infofsj$id').fadeOut(200).delay(100).fadeIn(200);
										$('#obs$id').fadeOut(200).delay(100).fadeIn(200);
										}
									});
								}
							}
						}
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
						
					}else{
						if($('#fsj$id').val()==''){
								$('#fsj$id').val('0');
						}
						if($('#fj$id').val()==''){
								$('#fj$id').val('0');
						}
						var num = $('#vn$id').val();
						var valorvn = parseFloat(num);
						if(isNaN(valorvn)){
							alert('Debe ingresar solo numeros en el campo V.N');
							$('#vn$id').focus();
							$('#vn$id').val('');
							
						}else{
							if(valorvn<$escalai || valorvn>$escalas){
								alert('La valoración numerica no esta dentro del rango configurado');
								$('#vn$id').focus();
								$('#vn$id').val('');
							}else{
								if(isNaN(valorvn)){
									alert('Para guardar debe ingresar la V.N');
									$('#vn$id').focus();
									$('#vn$id').val('');
								}else{
									var url = 'guardarcalificacion_response.php'; // El script a dónde se realizará la petición.
									estudianteid = $('#estudiante$id').val();
									periodoid = $('#periodo$id').val();
									idmateriaid = $('#idmateria$id').val();
									idaulaid = $('#idaula$id').val();
									iddocenteid = $('#iddocente$id').val();
									gradoid = $('#grado$id').val();
									aniolectivoid = $('#aniolectivo$id').val();
									$.ajax({
									   type: 'POST',
									   url: url,
									   data: {id : estudianteid,
										periodo : periodoid,
										idmateria : idmateriaid,
										idaula : idaulaid,
										iddocente : iddocenteid,
										grado : gradoid,
										aniolectivo : aniolectivoid,
										vn$id : $('#vn$id').val(),
										fj$id : $('#fj$id').val(),
										fsj$id : $('#fsj$id').val(),
										obs$id : $('#obs$id').val()}, // Adjuntar los campos del formulario enviado.
										success: function(data){
										$('#infovn$id').html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
										$('#infovn$id').fadeOut(200).delay(100).fadeIn(200);
										$('#infofj$id').html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
										$('#infofj$id').fadeOut(200).delay(100).fadeIn(200);
										$('#infofsj$id').html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
										$('#infofsj$id').fadeOut(200).delay(100).fadeIn(200);
										$('#obs$id').fadeOut(200).delay(100).fadeIn(200);
										}
									});
								}
							}
						}
					}
				}
			});
			$('#obs$id').change(function(e){
				e.preventDefault();
				var obs = $('#obs$id').val();
				if(obs!=''){
					if($('#fsj$id').val()==''){
							$('#fsj$id').val('0');
					}
					if($('#fj$id').val()==''){
							$('#fj$id').val('0');
					}
					var num = $('#vn$id').val();
					var valorvn = parseFloat(num);
					if(isNaN(valorvn)){
						alert('Debe ingresar solo numeros en el campo V.N');
						$('#vn$id').focus();
						$('#vn$id').val('');
						
					}else{
						if(valorvn<$escalai || valorvn>$escalas){
							alert('La valoración numerica no esta dentro del rango configurado');
							$('#vn$id').focus();
							$('#vn$id').val('');
						}else{
							if(isNaN(valorvn)){
								alert('Para guardar debe ingresar la V.N');
								$('#vn$id').focus();
								$('#vn$id').val('');
							}else{
								var url = 'guardarcalificacion_response.php'; // El script a dónde se realizará la petición.
								estudianteid = $('#estudiante$id').val();
								periodoid = $('#periodo$id').val();
								idmateriaid = $('#idmateria$id').val();
								idaulaid = $('#idaula$id').val();
								iddocenteid = $('#iddocente$id').val();
								gradoid = $('#grado$id').val();
								aniolectivoid = $('#aniolectivo$id').val();
								$.ajax({
								   type: 'POST',
								   url: url,
								   data: {id : estudianteid,
									periodo : periodoid,
									idmateria : idmateriaid,
									idaula : idaulaid,
									iddocente : iddocenteid,
									grado : gradoid,
									aniolectivo : aniolectivoid,
									vn$id : $('#vn$id').val(),
									fj$id : $('#fj$id').val(),
									fsj$id : $('#fsj$id').val(),
									obs$id : $('#obs$id').val()}, // Adjuntar los campos del formulario enviado.
									success: function(data){
									$('#infovn$id').html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
									$('#infovn$id').fadeOut(200).delay(100).fadeIn(200);
									$('#infofj$id').html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
									$('#infofj$id').fadeOut(200).delay(100).fadeIn(200);
									$('#infofsj$id').html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
									$('#infofsj$id').fadeOut(200).delay(100).fadeIn(200);
									$('#obs$id').fadeOut(200).delay(100).fadeIn(200);
									}
								});
							}
						}
					}
				}
			});
			$('#btndelete$id').click(function(){
				var url = 'borrarcalificaciones.php'; // El script a dónde se realizará la petición.
				estudianteid = $('#estudiante$id').val();
				periodoid = $('#periodo$id').val();
				idmateriaid = $('#idmateria$id').val();
				idaulaid = $('#idaula$id').val();
				iddocenteid = $('#iddocente$id').val();
				gradoid = $('#grado$id').val();
				aniolectivoid = $('#aniolectivo$id').val();
				$.ajax({
				   type: 'POST',
				   url: url,
				   beforeSend:function(){
					   $('#btndelete$id').removeClass('btn-danger');
					   $('#btndelete$id').addClass('btn-warning');
					   $('#btndelete$id').html('<i class=\"glyphicon glyphicon-refresh icon-spinner ico-spin icon-larger\"></i> Eliminando...');
				   },
				   data: {id : estudianteid,
							periodo : periodoid,
							idmateria : idmateriaid,
							idaula : idaulaid,
							iddocente : iddocenteid,
							grado : gradoid,
							aniolectivo : aniolectivoid,
							vn$id : $('#vn$id').val(),
							fj$id : $('#fj$id').val(),
							fsj$id : $('#fsj$id').val(),
							obs$id : $('#obs$id').val()}, // Adjuntar los campos del formulario enviado.
				   success: function(data)
				   {
						$('#btndelete$id').removeClass('btn-warning');
					    $('#btndelete$id').addClass('btn-danger');
						$('#btndelete$id').html('Eliminar Calificación');
						$('#infofsj$id').html('');
						$('#infovn$id').html('');
						$('#infofj$id').html('');
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
</table>
<?php
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
$conx->close_conex();
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
	//$('.scroll').slimScroll({
    //});