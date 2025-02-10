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


//Recuperamos el numero de decimales configurados para el año lectivo
$sql = "SELECT numero_decimales from redondeo_decimal where anio_lectivo=$aniolectivo LIMIT 1";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$numero_decimales = $records['numero_decimales'];
if(empty($numero_decimales)){
	$numero_decimales = 1;
}
$size_field_vn = 2+$numero_decimales-1;
$maxlength_field_vn = 3+$numero_decimales-1;
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
		//consultando competencias 
		$sql="SELECT DISTINCT i.idmateria, p.competencia, p.consecutivo, i.DS, i.DA, i.DB, i.DBA FROM plan_curricular p 
		JOIN indicadoresboletin i ON p.consecutivo=i.idindicador AND i.aniolectivo='$aniolectivo' AND i.periodo=$periodo AND i.idmateria='$idmateria'
		JOIN aula a ON i.grado=a.grado AND a.idaula='$idaula'";
	}
$consulta = $conx->query($sql);
if($conx->get_numRecords($consulta)>0){
	
$consulta2 = $conx->query($sql);
$numero_competencias_seleccionadas=$conx->get_numRecords($consulta2);
if($numero_competencias_seleccionadas > 0){
			if($aniolectivo<2016){
				// $sqlest = "SELECT e.idestudiante, e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula 
					// FROM estudiante e, matricula m  
					// WHERE e.idestudiante=m.idestudiante AND e.habilitado='S' 
					// AND m.tipo_matricula='R' AND m.aniolectivo='$aniolectivo' AND m.idaula=$idaula AND m.idaula IN 
					// (SELECT c.idaula FROM clase c, indicadoresboletin ib, plan_curricular i, aula a WHERE c.iddocente='$iddocente'
					// AND c.idmateria=$idmateria AND c.aniolectivo=$aniolectivo
					// AND ib.iddocente=c.iddocente
					// AND ib.aniolectivo=c.aniolectivo
					// AND ib.periodo=$periodo
					// AND ib.idindicador=i.consecutivo
					// AND c.idaula=a.idaula and a.grado='$grado' AND a.grado=ib.grado) 
					// ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
					$sqlest = "SELECT DISTINCT
					CONCAT_WS(' ',trim(estudiante.apellido1), trim(estudiante.apellido2), trim(estudiante.nombre1), trim(estudiante.nombre2)) AS nombre_estudiante,estudiante.idestudiante AS id, notas.*						FROM estudiante
					  LEFT JOIN matricula
						ON estudiante.idestudiante = matricula.idestudiante AND estudiante.habilitado='S'
					  LEFT JOIN notas
						ON matricula.idestudiante=notas.idestudiante AND notas.idmateria=$idmateria AND notas.periodo=$periodo AND notas.aniolectivo=matricula.aniolectivo 
						AND matricula.tipo_matricula=notas.tipo_nota
					WHERE
					  matricula.idaula = $idaula AND matricula.aniolectivo = $aniolectivo AND matricula.tipo_matricula='R' ORDER BY nombre_estudiante ASC";
					
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
					CONCAT_WS(' ',trim(estudiante.apellido1), trim(estudiante.apellido2), trim(estudiante.nombre1), trim(estudiante.nombre2)) AS nombre_estudiante,estudiante.idestudiante AS id, notas.*
					FROM estudiante
					  LEFT JOIN matricula
						ON estudiante.idestudiante = matricula.idestudiante AND estudiante.habilitado='S'
					  LEFT JOIN notas
						ON matricula.idestudiante=notas.idestudiante AND notas.idmateria=$idmateria AND notas.periodo=$periodo AND notas.aniolectivo=matricula.aniolectivo 
						AND matricula.tipo_matricula=notas.tipo_nota
					WHERE
					  matricula.idaula = $idaula AND matricula.aniolectivo = $aniolectivo AND matricula.tipo_matricula='R' ORDER BY nombre_estudiante ASC";
					
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
				echo "<td>".($row['competencia'])."</td>";
				echo "<td style='text-align: center;' >".$row['DS']."</td>";
				echo "<td style='text-align: center;' >".$row['DA']."</td>";
				echo "<td style='text-align: center;' >".$row['DB']."</td>";
				echo "<td style='text-align: center;' >".$row['DBA']."</td>";
				echo "</tr>";
				
				
			}
			echo "</tbody>";
			echo "</table></div>";
			if(($numero_competencias_seleccionadas < 3 or $numero_competencias_seleccionadas > 4) && $aniolectivo>2015) {
			
				?>
				<div class="jumbotron center-block">
				<h2 class='alert alert-danger'>Se han seleccionado menos de 3 ó más de 4 competencias para calificar. Comuniquese con el jefe de area para corregir este problema</h2>
				<p><a class='btn btn-lg btn-success '  href='ingresarcalificaciones.php' role='button'>Volver</a></p>
				</div>
					
				<?php		
			}else{
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
					$id = trim($row['id']);
					$nombre=ucwords($row['nombre_estudiante']);
					$nombre=("(".$id.") ".$nombre);
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
					
					if($row['vn']!=null){
						$vn_nota = number_format($row['vn'],$numero_decimales);
						?>
						<td align="left" width="40px">
						<div class="input-group">
					
						<?php
						  echo "<input vn_id_estudiante='$id' vn_nota='$vn_nota' vn_periodo='$periodo' vn_idmateria='$idmateria' vn_idaula='$idaula' vn_iddocente='$iddocente' vn_grado='$grado' vn_aniolectivo='$aniolectivo' class='vn' vn_id='$id'  vn_escalai='$escalai' vn_escalas='$escalas' data-toggle='tooltip' title='Ingrese valor entre $escalai y $escalas' value='".$vn_nota."' type='text' id='vn$id' name='vn$id' size='$size_field_vn' maxlength='$maxlength_field_vn'/ ><span id='infovn$id'  class='input-group-addon infovn'><i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i></span>"; ?>
						</td>
						</div>
						<td align="left" width="40px">
						<div class="input-group">
						<?php echo "<input fj_id_estudiante='$id' fj_periodo='$periodo' fj_idmateria='$idmateria' fj_idaula='$idaula' fj_iddocente='$iddocente' fj_grado='$grado' fj_aniolectivo='$aniolectivo' class='fj' fj_id='$id' fj_escalai='$escalai' fj_escalas='$escalas' data-toggle='tooltip' title='Faltas justificadas' value='".$row['fj']."' type='text' id='fj$id' name='fj$id' size='2' maxlength='2'/><span id='infofj$id' class='input-group-addon'><i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i></span>"; ?>
						</td>
						</div>
						<td align="left" width="40px">
						<div class="input-group">
						<?php echo "<input fsj_id_estudiante='$id' fsj_periodo='$periodo' fsj_idmateria='$idmateria' fsj_idaula='$idaula' fsj_iddocente='$iddocente' fsj_grado='$grado' fsj_aniolectivo='$aniolectivo' class='fsj' fsj_id='$id' fsj_escalai='$escalai' fsj_escalas='$escalas' data-toggle='tooltip' title='Faltas sin justificar' value='".$row['fsj']."' type='text' id='fsj$id' name='fsj$id' size='2' maxlength='2'/><span id='infofsj$id' class='input-group-addon'><i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i></span>"; ?>
						</td>
						</div>
						<td align="left">
						<?php echo "<textarea obs_id_estudiante='$id' obs_periodo='$periodo' obs_idmateria='$idmateria' obs_idaula='$idaula' obs_iddocente='$iddocente' obs_grado='$grado' obs_aniolectivo='$aniolectivo' class='obs' obs_id='$id' obs_escalai='$escalai' obs_escalas='$escalas' id='obs$id' name='obs$id'  cols='50' rows='1' maxlength='60' class='toolTip' data-toggle='tooltip' title='Máximo 60 caracteres'>".$row['observaciones']."</textarea><span id='contador$id' class=''></span>"; ?>
						</td>
						<?php 
						
					}else{
						?>
							<td align="left" width="40px">
							<div class="input-group">
							<?php
							  echo "<input vn_id_estudiante='$id'  vn_nota='' vn_periodo='$periodo' vn_idmateria='$idmateria' vn_idaula='$idaula' vn_iddocente='$iddocente' vn_grado='$grado' vn_aniolectivo='$aniolectivo' class='vn' vn_id='$id' vn_escalai='$escalai' vn_escalas='$escalas' data-toggle='tooltip' title='Ingrese valor entre $escalai y $escalas' class='' type='text' id='vn$id' name='vn$id' size='$size_field_vn' maxlength='$maxlength_field_vn'/><span id='infovn$id'  class='input-group-addon infovn'></span>"; ?>
							</td>
							</div>
							<td align="left" width="40px">
							<div class="input-group">
							<?php echo "<input fj_id_estudiante='$id' fj_periodo='$periodo' fj_idmateria='$idmateria' fj_idaula='$idaula' fj_iddocente='$iddocente' fj_grado='$grado' fj_aniolectivo='$aniolectivo' class='fj' fj_id='$id' fj_escalai='$escalai' fj_escalas='$escalas' data-toggle='tooltip' title='Faltas justificadas' type='text' id='fj$id' name='fj$id' size='2' maxlength='4'/><span id='infofj$id' class='input-group-addon'></span>"; ?>
							</td>
							</div>
							<td align="left" width="40px">
							<div class="input-group">
							<?php echo "<input fsj_id_estudiante='$id' fsj_periodo='$periodo' fsj_idmateria='$idmateria' fsj_idaula='$idaula' fsj_iddocente='$iddocente' fsj_grado='$grado' fsj_aniolectivo='$aniolectivo' class='fsj' fsj_id='$id' fsj_escalai='$escalai' fsj_escalas='$escalas' data-toggle='tooltip' title='Faltas sin justificar' type='text' id='fsj$id' name='fsj$id' size='2' maxlength='4'/><span id='infofsj$id' class='input-group-addon'></span>"; ?>
							</td>
							</div>
							<td align="left">
							<?php echo "<textarea obs_id_estudiante='$id' obs_periodo='$periodo' obs_idmateria='$idmateria' obs_idaula='$idaula' obs_iddocente='$iddocente' obs_grado='$grado' obs_aniolectivo='$aniolectivo' class='obs' obs_id='$id' id='obs$id' name='obs$id' obs_escalai='$escalai' obs_escalas='$escalas' cols='50' rows='1' maxlength='60' class='toolTip' data-toggle='tooltip' title='Máximo 60 caracteres'></textarea><span id='contador$id' class=''></span>"; ?>
							</td>
						<?php 
					}
					?>
					<td>
					<?php
					echo "<button btn_id_estudiante='$id' btn_periodo='$periodo' btn_idmateria='$idmateria' btn_idaula='$idaula' btn_iddocente='$iddocente' btn_grado='$grado' btn_aniolectivo='$aniolectivo' type='button' class='btn btn-danger btndelete'  id='btndelete$id'>Eliminar Calificación</button>";
					?>
					</td>
					</tr>
				<?php
				$numreg++;
				}
				?>
				</table>
				</div>
				<?php
			
			}

	
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
		$sqlnom="SELECT
				  docente.*
				FROM jefearea
				  INNER JOIN docente
					ON jefearea.iddocente = docente.iddocente
				  INNER JOIN aula
					ON aula.idaula = jefearea.idaula
				WHERE jefearea.aniolectivo = $aniolectivo AND jefearea.idmateria = $idmateria AND aula.grado = $grado";
		$consultanom = $conx->query($sqlnom);
		$jefearea='';
		if($conx->get_numRecords($consultanom)>0){
			$records = $conx->records_array($consultanom);
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
	$(document).ready(function(){
		$('[data-toggle=\"tooltip\"]').tooltip();
		$('td input').focus(function(){
			var type=$(this).attr('class');
			var id= $(this).attr(type+'_id');
			$('#tdname'+id).css({'font-weight' : 'bold'});
			$('#vn'+id).css({'background-color' : '#7FFF00'});
			$('#fj'+id).css({'background-color' : '#7FFF00'});
			$('#fsj'+id).css({'background-color' : '#7FFF00'});
			$('#obs'+id).css({'background-color' : '#7FFF00'});
			
			
		});
		$('td input').blur(function(){
			var type=$(this).attr('class');
			var id= $(this).attr(type+'_id')
			$('#tdname'+id).css({'font-weight' : 'normal'});
			$('#vn'+id).css({'background-color' : '#FFFFFF'});
			$('#fj'+id).css({'background-color' : '#FFFFFF'});
			$('#fsj'+id).css({'background-color' : '#FFFFFF'});
			$('#obs'+id).css({'background-color' : '#FFFFFF'});
			
			
		});
		$('td textarea').focus(function(){
			var type=$(this).attr('class');
			var id= $(this).attr(type+'_id');
			$('#tdname'+id).css({'font-weight' : 'bold'});
			$('#vn'+id).css({'background-color' : '#7FFF00'});
			$('#fj'+id).css({'background-color' : '#7FFF00'});
			$('#fsj'+id).css({'background-color' : '#7FFF00'});
			$('#obs'+id).css({'background-color' : '#7FFF00'});
			
			
		});
		$('td textarea').blur(function(){
			var type=$(this).attr('class');
			var id= $(this).attr(type+'_id')
			$('#tdname'+id).css({'font-weight' : 'normal'});
			$('#vn'+id).css({'background-color' : '#FFFFFF'});
			$('#fj'+id).css({'background-color' : '#FFFFFF'});
			$('#fsj'+id).css({'background-color' : '#FFFFFF'});
			$('#obs'+id).css({'background-color' : '#FFFFFF'});
			
			
		});
		/*$('.vn').focusout(function(e) {
				e.preventDefault();
				var type=$(this).attr('class');
				var escalai=$(this).attr('vn_escalai');
				var escalas=$(this).attr('vn_escalas');
				var idestudiante=$(this).attr('vn_id_estudiante');
				var idmateria=$(this).attr('vn_idmateria');
				var periodo=$(this).attr('vn_periodo');
				var idaula=$(this).attr('vn_idaula');
				var iddocente=$(this).attr('vn_iddocente');
				var grado=$(this).attr('vn_grado');
				var aniolectivo=$(this).attr('vn_aniolectivo');
				var type=$(this).attr('class');
				var id= $(this).attr(type+'_id')
				var num = $('#vn'+id).val();
				var valor = parseFloat(num);
				if(isNaN(valor)){
					alert('Debe ingresar un numero');
					$(this).focus();
					$(this).val('0');
				}else{
					if(valor<escalai || valor>escalas){
						alert('La valoración numerica no esta dentro del rango configurado');
						$(this).focus();
						$(this).val('');
					}else{
						if(isNaN(valor)){
							alert('Para guardar debe ingresar la V.N');
							$(this).focus();
							$(this).val('');
						}else{
							if($('#fsj'+idestudiante).val()==''){
								$('#fsj'+idestudiante).val('0');
							}
							if($('#fj'+idestudiante).val()==''){
								$('#fj'+idestudiante).val('0');
							}
							var url = 'guardarcalificacion_response.php'; // El script a dónde se realizará la petición.
							estudianteid = idestudiante;
							periodoid = periodo;
							idmateriaid = idmateria;
							idaulaid = idaula;
							iddocenteid = iddocente;
							gradoid = grado;
							aniolectivoid = aniolectivo;
							$.ajax({
							   type: 'POST',
							   url: url,
							   data: {
								id_ : estudianteid,
								periodo_ : periodoid,
								idmateria_ : idmateriaid,
								idaula_ : idaulaid,
								iddocente_ : iddocenteid,
								grado_ : gradoid,
								aniolectivo_ : aniolectivoid,
								vn : $('#vn'+idestudiante).val(),
								fj : $('#fj'+idestudiante).val(),
								fsj : $('#fsj'+idestudiante).val(),
								obs : $('#obs'+idestudiante).val()}, // Adjuntar los campos del formulario enviado.
								success: function(data){
								$('#infovn'+id).html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
								$('#infovn'+id).fadeOut(200).delay(100).fadeIn(200);
								$('#infofj'+id).html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
								$('#infofj'+id).fadeOut(200).delay(100).fadeIn(200);
								$('#infofsj'+id).html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
								$('#infofsj'+id).fadeOut(200).delay(100).fadeIn(200);
								$('#obs'+id).fadeOut(200).delay(100).fadeIn(200);
								}
							});
						}
					}
				}
					
		});*/
		$('.vn').change(function(e){
				e.preventDefault();
				var type=$(this).attr('class');
				var escalai=$(this).attr('vn_escalai');
				var escalas=$(this).attr('vn_escalas');
				var idestudiante=$(this).attr('vn_id_estudiante');
				var idmateria=$(this).attr('vn_idmateria');
				var periodo=$(this).attr('vn_periodo');
				var idaula=$(this).attr('vn_idaula');
				var iddocente=$(this).attr('vn_iddocente');
				var vn_anterior=$(this).attr('vn_nota');
				var grado=$(this).attr('vn_grado');
				var aniolectivo=$(this).attr('vn_aniolectivo');
				var type=$(this).attr('class');
				var id= $(this).attr(type+'_id').trim();
				var num = $('#vn'+id).val();
				if(isNaN(num)){
					
					alert('Debe ingresar un numero ');
					$(this).focus();
					$(this).val(vn_anterior);
				}else{
					var valor = parseFloat(num);
					if(valor<escalai || valor>escalas){
						alert('La valoración numerica no esta dentro del rango configurado');
						$(this).focus();
						$(this).val(vn_anterior);
					}else{
						if(isNaN(valor)){
							alert('Para guardar debe ingresar la V.N');
							$(this).focus();
							$(this).val('');
						}else{
							if($('#fsj'+idestudiante).val()==''){
								$('#fsj'+idestudiante).val('0');
							}
							if($('#fj'+idestudiante).val()==''){
								$('#fj'+idestudiante).val('0');
							}
							var url = 'guardarcalificacion_response.php'; // El script a dónde se realizará la petición.
							estudianteid = idestudiante;
							periodoid = periodo;
							idmateriaid = idmateria;
							idaulaid = idaula;
							iddocenteid = iddocente;
							gradoid = grado;
							aniolectivoid = aniolectivo;
							console.log('estudianteid:'+estudianteid);
							console.log('periodoid:'+periodoid);
							console.log('idmateriaid:'+idmateriaid);
							console.log('idaulaid:'+idaulaid);
							console.log('iddocenteid:'+iddocenteid);
							console.log('gradoid:'+gradoid);
							console.log('aniolectivoid:'+aniolectivoid);
							$.ajax({
							   type: 'POST',
							   url: url,
							   data: {
								id_ : estudianteid,
								periodo_ : periodoid,
								idmateria_ : idmateriaid,
								idaula_ : idaulaid,
								iddocente_ : iddocenteid,
								grado_ : gradoid,
								aniolectivo_ : aniolectivoid,
								vn : $('#vn'+idestudiante).val(),
								fj : $('#fj'+idestudiante).val(),
								fsj : $('#fsj'+idestudiante).val(),
								obs : $('#obs'+idestudiante).val()}, // Adjuntar los campos del formulario enviado.
								success: function(data){
								$('#infovn'+id).html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
								$('#infovn'+id).fadeOut(200).delay(100).fadeIn(200);
								$('#infofj'+id).html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
								$('#infofj'+id).fadeOut(200).delay(100).fadeIn(200);
								$('#infofsj'+id).html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
								$('#infofsj'+id).fadeOut(200).delay(100).fadeIn(200);
								$('#obs'+id).fadeOut(200).delay(100).fadeIn(200);
								}
							});
						}
					}
				}
					
		});
		$('.fj').change(function(e){
				e.preventDefault();
				var type=$(this).attr('class');
				var escalai=$(this).attr('fj_escalai');
				var escalas=$(this).attr('fj_escalas');
				var idestudiante=$(this).attr('fj_id_estudiante');
				var idmateria=$(this).attr('fj_idmateria');
				var periodo=$(this).attr('fj_periodo');
				var idaula=$(this).attr('fj_idaula');
				var iddocente=$(this).attr('fj_iddocente');
				var grado=$(this).attr('fj_grado');
				var aniolectivo=$(this).attr('fj_aniolectivo');
				var type=$(this).attr('class');
				var id= $(this).attr(type+'_id')
				var num = $('#fj'+id).val();
				var valor = parseFloat(num);
				if(isNaN(valor)){
					alert('Debe ingresar un numero');
					$(this).focus();
					$(this).val('');
				}else{
					if(valor<0){
						alert('El valor ingresado ser mayor o igual a cero');
						$(this).focus();
						$(this).val('');
					}else{
						if($(this).val()==''){
							$(this).val('0');
						}
						if($(this).val()==''){
							$(this).val('0');
						}
						var num = $('#vn'+id).val();
						var valorvn = parseFloat(num);
						if(isNaN(valorvn)){
							alert('Debe ingresar solo numeros en el campo V.N');
							$('#vn'+id).focus();
							$('#vn'+id).val('');
							
						}else{
							if(valorvn<escalai || valorvn>escalas){
								alert('La valoración numerica no esta dentro del rango configurado');
								$('#vn'+id).focus();
								$('#vn'+id).val('');
							}else{
								if(isNaN(valorvn)){
									alert('Para guardar debe ingresar la V.N');
									$('#vn'+id).focus();
									$('#vn'+id).val('');
								}else{
									var url = 'guardarcalificacion_response.php'; // El script a dónde se realizará la petición.
									estudianteid = idestudiante;
									periodoid = periodo;
									idmateriaid = idmateria;
									idaulaid = idaula;
									iddocenteid = iddocente;
									gradoid = grado;
									aniolectivoid = aniolectivo;
									$.ajax({
									   type: 'POST',
									   url: url,
									   data: {
										id_ : estudianteid,
										periodo_ : periodoid,
										idmateria_ : idmateriaid,
										idaula_ : idaulaid,
										iddocente_ : iddocenteid,
										grado_ : gradoid,
										aniolectivo_ : aniolectivoid,
										vn : $('#vn'+idestudiante).val(),
										fj : $('#fj'+idestudiante).val(),
										fsj : $('#fsj'+idestudiante).val(),
										obs : $('#obs'+idestudiante).val()}, // Adjuntar los campos del formulario enviado.
										success: function(data){
										$('#infovn'+id).html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
										$('#infovn'+id).fadeOut(200).delay(100).fadeIn(200);
										$('#infofj'+id).html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
										$('#infofj'+id).fadeOut(200).delay(100).fadeIn(200);
										$('#infofsj'+id).html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
										$('#infofsj'+id).fadeOut(200).delay(100).fadeIn(200);
										$('#obs'+id).fadeOut(200).delay(100).fadeIn(200);
										}
									});
								}
							}
						}
					}
				}
					
		});
		$('.fsj').change(function(e){
				e.preventDefault();
				var type=$(this).attr('class');
				var escalai=$(this).attr('fsj_escalai');
				var escalas=$(this).attr('fsj_escalas');
				var idestudiante=$(this).attr('fsj_id_estudiante');
				var idmateria=$(this).attr('fsj_idmateria');
				var periodo=$(this).attr('fsj_periodo');
				var idaula=$(this).attr('fsj_idaula');
				var iddocente=$(this).attr('fsj_iddocente');
				var grado=$(this).attr('fsj_grado');
				var aniolectivo=$(this).attr('fsj_aniolectivo');
				var type=$(this).attr('class');
				var id= $(this).attr(type+'_id')
				var num = $('#fsj'+id).val();
				var valor = parseFloat(num);
				if(isNaN(valor)){
					alert('Debe ingresar un numero');
					$(this).focus();
					$(this).val('');
				}else{
					if(valor<0){
						alert('El valor ingresado ser mayor o igual a cero');
						$(this).focus();
						$(this).val('');
					}else{
						if($(this).val()==''){
							$(this).val('0');
						}
						if($(this).val()==''){
							$(this).val('0');
						}
						var num = $('#vn'+id).val();
						var valorvn = parseFloat(num);
						if(isNaN(valorvn)){
							alert('Debe ingresar solo numeros en el campo V.N');
							$('#vn'+id).focus();
							$('#vn'+id).val('');
							
						}else{
							if(valorvn<escalai || valorvn>escalas){
								alert('La valoración numerica no esta dentro del rango configurado');
								$('#vn'+id).focus();
								$('#vn'+id).val('');
							}else{
								if(isNaN(valorvn)){
									alert('Para guardar debe ingresar la V.N');
									$('#vn'+id).focus();
									$('#vn'+id).val('');
								}else{
									var url = 'guardarcalificacion_response.php'; // El script a dónde se realizará la petición.
									estudianteid = idestudiante;
									periodoid = periodo;
									idmateriaid = idmateria;
									idaulaid = idaula;
									iddocenteid = iddocente;
									gradoid = grado;
									aniolectivoid = aniolectivo;
									$.ajax({
									   type: 'POST',
									   url: url,
									   data: {
										id_ : estudianteid,
										periodo_ : periodoid,
										idmateria_ : idmateriaid,
										idaula_ : idaulaid,
										iddocente_ : iddocenteid,
										grado_ : gradoid,
										aniolectivo_ : aniolectivoid,
										vn : $('#vn'+idestudiante).val(),
										fj : $('#fj'+idestudiante).val(),
										fsj : $('#fsj'+idestudiante).val(),
										obs : $('#obs'+idestudiante).val()}, // Adjuntar los campos del formulario enviado.
										success: function(data){
										$('#infovn'+id).html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
										$('#infovn'+id).fadeOut(200).delay(100).fadeIn(200);
										$('#infofj'+id).html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
										$('#infofj'+id).fadeOut(200).delay(100).fadeIn(200);
										$('#infofsj'+id).html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
										$('#infofsj'+id).fadeOut(200).delay(100).fadeIn(200);
										$('#obs'+id).fadeOut(200).delay(100).fadeIn(200);
										}
									});
								}
							}
						}
					}
				}
					
		});
		$('.obs').change(function(e){
				e.preventDefault();
				var type=$(this).attr('class');
				var escalai=$(this).attr('obs_escalai');
				var escalas=$(this).attr('obs_escalas');
				var idestudiante=$(this).attr('obs_id_estudiante');
				var idmateria=$(this).attr('obs_idmateria');
				var periodo=$(this).attr('obs_periodo');
				var idaula=$(this).attr('obs_idaula');
				var iddocente=$(this).attr('obs_iddocente');
				var grado=$(this).attr('obs_grado');
				var aniolectivo=$(this).attr('obs_aniolectivo');
				var type=$(this).attr('class');
				var id= $(this).attr(type+'_id')
				var obs = $('#obs'+id).val();
				if(obs!='' || obs==''){
					if($('#fsj'+id).val()==''){
						$('#fsj'+id).val('0');
					}
					if($('#fj'+id).val()==''){
						$('#fj'+id).val('0');
					}
					var num = $('#vn'+id).val();
					var valorvn = parseFloat(num);
					if(isNaN(valorvn)){
						alert('Debe ingresar solo numeros en el campo V.N');
						$('#vn'+id).focus();
						$('#vn'+id).val('');
						
					}else{
						if(valorvn<escalai || valorvn>escalas){
							alert('La valoración numerica no esta dentro del rango configurado');
							$('#vn'+id).focus();
							$('#vn'+id).val('');
						}else{
							if(isNaN(valorvn)){
								alert('Para guardar debe ingresar la V.N');
								$('#vn'+id).focus();
								$('#vn'+id).val('');
							}else{
								var url = 'guardarcalificacion_response.php'; // El script a dónde se realizará la petición.
								estudianteid = idestudiante;
								periodoid = periodo;
								idmateriaid = idmateria;
								idaulaid = idaula;
								iddocenteid = iddocente;
								gradoid = grado;
								aniolectivoid = aniolectivo;
								$.ajax({
								   type: 'POST',
								   url: url,
								   data: {
									id_ : estudianteid,
									periodo_ : periodoid,
									idmateria_ : idmateriaid,
									idaula_ : idaulaid,
									iddocente_ : iddocenteid,
									grado_ : gradoid,
									aniolectivo_ : aniolectivoid,
									vn : $('#vn'+idestudiante).val(),
									fj : $('#fj'+idestudiante).val(),
									fsj : $('#fsj'+idestudiante).val(),
									obs : $('#obs'+idestudiante).val()}, // Adjuntar los campos del formulario enviado.
									success: function(data){
									$('#infovn'+id).html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
									$('#infovn'+id).fadeOut(200).delay(100).fadeIn(200);
									$('#infofj'+id).html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
									$('#infofj'+id).fadeOut(200).delay(100).fadeIn(200);
									$('#infofsj'+id).html('<i class=\"glyphicon glyphicon-ok text-success\" style=\"font-size:10px;\"></i>');
									$('#infofsj'+id).fadeOut(200).delay(100).fadeIn(200);
									$('#obs'+id).fadeOut(200).delay(100).fadeIn(200);
									}
								});
							}
						}
					}
				}
		});
		$('.btndelete').click(function(){
				var url = 'borrarcalificaciones.php'; // El script a dónde se realizará la petición.
				var estudianteid=$(this).attr('btn_id_estudiante');
				var idmateriaid=$(this).attr('btn_idmateria');
				var periodoid=$(this).attr('btn_periodo');
				var idaulaid=$(this).attr('btn_idaula');
				var iddocenteid=$(this).attr('btn_iddocente');
				var gradoid=$(this).attr('btn_grado');
				var aniolectivoid=$(this).attr('btn_aniolectivo');
				var type=$(this).attr('class');
				$.ajax({
				   type: 'POST',
				   url: url,
				   beforeSend:function(){
					   $('#btndelete'+estudianteid).removeClass('btn-danger');
					   $('#btndelete'+estudianteid).addClass('btn-warning');
					   $('#btndelete'+estudianteid).html('<i class=\"glyphicon glyphicon-refresh icon-spinner ico-spin icon-larger\"></i> Eliminando...');
				   },
				   data: {id : estudianteid,
							periodo : periodoid,
							idmateria : idmateriaid,
							idaula : idaulaid,
							iddocente : iddocenteid,
							grado : gradoid,
							aniolectivo : aniolectivoid,
							vn : $('#vn'+estudianteid).val(),
							fj : $('#fj'+estudianteid).val(),
							fsj : $('#fsj'+estudianteid).val(),
							obs : $('#obs'+estudianteid).val()}, // Adjuntar los campos del formulario enviado.
				   success: function(data)
				   {
						$('#btndelete'+estudianteid).removeClass('btn-warning');
					    $('#btndelete'+estudianteid).addClass('btn-danger');
						$('#btndelete'+estudianteid).html('Eliminar Calificación');
						$('#infofsj'+estudianteid).html('');
						$('#infovn'+estudianteid).html('');
						$('#infofj'+estudianteid).html('');
						$('#vn'+estudianteid).val('');
						$('#fj'+estudianteid).val('');
						$('#fsj'+estudianteid).val('');
						$('#obs'+estudianteid).val('');
						
				   }
				 });
				 $('#status'+estudianteid).show();
			});
			
	});