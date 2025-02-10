<?php
session_start();
include('../../class/puesto.php');
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$look=false;
$sql = "SELECT valor FROM appconfig WHERE item='ie'";
$consulta = $conx->query($sql);
$records = $conx->records_array($consulta);
$ie= $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'pages'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$pages = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'convenciones'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$convencion = $records['valor'];
$p=$_POST["periodo"];
$al=$_POST["aniolect"];
$aniolectivo=$al;
$papel=$_POST["papel"];
$idaula = $_POST['aula'];
$periodo= $_POST['periodo'];
$aniolect= $_POST['aniolect'];
$formato= $_POST['formato'];
$sql = "SELECT num_periodos, tipo_periodo FROM periodos_por_anio WHERE anio = '$aniolect'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$num_periodos = $records['num_periodos'];
$tipo_periodo = $records['tipo_periodo'];

//aula
$sqlaaula = "SELECT descripcion, idaula, grado, grupo, jornada FROM aula WHERE idaula = $idaula";
$consultaaula = $conx->query($sqlaaula);    
$recordsaula = $conx->records_array($consultaaula);
if($recordsaula['jornada']=="M"){
	$jornada="MAÑANA";
}else{
	$jornada="TARDE";
}
$grado2=($recordsaula['descripcion'])."-".$recordsaula['grupo']."-".$jornada;
$grado=$recordsaula['grado'];
$idaula=$recordsaula['idaula'];

//Recuperamos el numero de decimales configurados para el año lectivo
$sql = "SELECT numero_decimales from redondeo_decimal where anio_lectivo=$aniolect LIMIT 1";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$numero_decimales = $records['numero_decimales'];
if(empty($numero_decimales)){
	$numero_decimales = 1;
}

?>
<html>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html;" />
<head>
<title><?php echo "BOLETIN GRADO ".($grado2)."-PERIODO $p - $al"; ?></title>
<link  href="http://fonts.googleapis.com/css?family=Cabin+Sketch:bold" rel="stylesheet" type="text/css" >
<link  href="http://fonts.googleapis.com/css?family=Lobster:regular" rel="stylesheet" type="text/css" >
<link  href="http://fonts.googleapis.com/css?family=Tangerine:regular,bold" rel="stylesheet" type="text/css" >
<!-- Custom styles for this template -->
<link rel="stylesheet" type="text/css" href="../../css/boletin.css" media="print, screen">
<style type="text/css" media="print">
@page{
   size:Legal portrait;
   margin: 10mm 0 20mm 0;
  
}
.modal {
     display: none;
     position: absolute;
     top: 25%;
     left: 25%;
     width: 50%;
     height: 50%;
     padding: 16px;
     background: #fff;
     color: #333;
     z-index:1002;
     overflow: auto;
}

</style>
<script src="../../js/jquery.js"></script>
<script src="../../js/jquery-modal-master/jquery.modal.js"></script>
<script type='text/javascript'>
$('#ex1').modal('show');
window.onload = detectarCarga;
function detectarCarga(){
document.getElementById("imgLOAD").style.display="none";
}
</script>
<!-- Todos los plugins JavaScript de Bootstrap (también puedes
	 incluir archivos JavaScript individuales de los únicos
	 plugins que utilices) -->
</head>
<?php
if($grado==0){
 echo "<body background='../../images/kg.jpg'>";
}else{
 echo "<body >";
}?>
<div>
<?php
//include("../../class/phpdocx/classes/createDocx.inc");
//$docx = new CreateDocx();


//-----------------------------datos basicos de colegio

$sql = "SELECT valor FROM appconfig WHERE item = 'nrector'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$nrector = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'nca'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$nca = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'Lema'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$lema = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'ciudad'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$ciudad = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'departamento'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$departamento = $records['valor'];

$localizacion=$ciudad." ".$departamento;

//-----------------------------------------------------
//mysql_set_charset('utf8',$conx->conexion);

function String_oracion($string){
 $stringReturn="";
 $arraySplit = explode('.', $string);
 for($i=0; $i<count($arraySplit); $i++){
	
	//$stringReturn[$i]=ucfirst($arraySplit[$i]);
	$arraySplit[$i]=ucfirst(strtolower(trim($arraySplit[$i])));
 }
 $stringReturn = implode(". ", $arraySplit);
 $stringReturn=str_replace("Ó","ó",$stringReturn);
 $stringReturn=str_replace("Í","í",$stringReturn);
 $stringReturn=str_replace("Á","á",$stringReturn);
 $stringReturn=str_replace("É","é",$stringReturn);
 $stringReturn=str_replace("Ú","ú",$stringReturn);
 $stringReturn=str_replace("Ñ","ñ",$stringReturn);
 $stringReturn=str_replace(" dios"," DIOS",$stringReturn);
 $stringReturn=str_replace(" jesús"," JESÚS",$stringReturn);
 return $stringReturn;
}

//escala de notas
$existeescala=0;
$sqlrc = "SELECT * FROM escala_de_calificacion WHERE aniolectivo = $aniolect";
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

//$conx->close_conex();
//----------------------------------------------------------------------------------
if($existeescala==1){
	
    if($formato=="f2"){
		
		    ?>
			<div id="ex1" style="">
			<div id="imgLOAD" style="text-align:center;" class="modal">
			<b>Gerenando Boletines...</b>
			<img src="../../images/loadingbar-blue.gif" /> Boletin <span id="boletingenerado"></span> DE <span id="totalboletines"></span>
			</div>
			</div>
			<?php
			$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
			if (isset($_POST['idestudiante'])) {
				$sqlest = "SELECT DISTINCT e.idestudiante, e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula 
							FROM estudiante e
							INNER JOIN matricula m ON e.idestudiante=m.idestudiante
							INNER JOIN notas n ON m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo AND m.tipo_matricula=n.tipo_nota
							WHERE m.aniolectivo=$aniolect AND m.idaula=$idaula AND m.tipo_matricula='R' AND m.periodo=0
							AND n.periodo=$periodo AND e.idestudiante='".$_POST['idestudiante']."'
							ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";
				
			}else{
				$sqlest = "SELECT DISTINCT 
							e.apellido1, e.apellido2, 
							e.nombre1, e.nombre2, m.idaula, e.idestudiante 
							FROM estudiante e
							INNER JOIN matricula m
							ON e.idestudiante=m.idestudiante AND m.idaula=$idaula
							AND m.tipo_matricula='R' AND m.periodo=0 AND m.aniolectivo=$aniolect
							AND e.habilitado='S'
							INNER JOIN notas n ON m.idestudiante=n.idestudiante
							AND m.aniolectivo=n.aniolectivo
							AND n.tipo_nota=m.tipo_matricula AND n.periodo=$periodo
							ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";
			}

        	$consultaest = $conx->query($sqlest);
			$numest = $conx->get_numRecords($consultaest);
			$totalest = $conx->get_numRecords($consultaest);
			//
			$tabla_promedios=tabla_promedios($idaula, $aniolect, $periodo);
            while($records1 = $conx->records_array($consultaest)){
				$msjBoletin= ($totalest-$numest)+1;
				echo "<script>$('#boletingenerado').text($msjBoletin); $('#totalboletines').text($totalest);</script>";
				$contmat=0;
            	switch($periodo){
					case 1: $corte="1ER CORTE PRIMER SEMESTRE"; break;
					case 2: $corte="2DO CORTE PRIMER SEMESTRE"; 
							$puestosem=puestoAnioAlg2($records1['idestudiante'], $idaula, $aniolect, 1, 2);
							$promediosem=promedioAnioAlg2($records1['idestudiante'], $idaula, $aniolect, 1, 2);
							break;
							
					case 3: $corte="1ER CORTE SEGUNDO SEMESTRE"; break;
					case 4: $corte="2DO CORTE SEGUNDO SEMESTRE"; 
							$puestosem=puestoAnioAlg2($records1['idestudiante'], $idaula, $aniolect, 3, 4);
							$promediosem=promedioAnioAlg2($records1['idestudiante'], $idaula, $aniolect, 3, 4);
							break;
				}
				echo 
                "<div class='fondo'><div style='line-height:7px;'>
                <table class='normal'>
                        <tr>
                            <td width='100px' align='left' rowspan='' valign='top'>
                                <span  class='blocktext'><img  src='../../images/logocol.png' width='95' height='95'/></span>
                            </td>
                            <td style='font-family: Arial, Helvetica, sans-serif;font-size:12px; font-style:italic;'><strong>INSTITUCIÓN EDUCATIVA MISIONAL SANTA TERESITA<br/>
								 San Andrés de Tumaco D.E.<br/>
								 NIT: 840.000.320-1      REGISTRO DANE: 152835001568      ICFES: 118117</strong><br/>
								Institución Educativa de Educación Preescolar, Primaria, Básica y Media Vocacional<br/>
								Aprobado mediante Resoluciones: 1325 del 24 de Julio de 2001 Básica Primaria, 1972 del 5 de<br/>
								Octubre 2001 Básica Secundaria y 4075 del 27 de Diciembre de 2002 Media Vocacional<br/>
								<strong>“HOY MEJOR QUE AYER, SIEMPRE LO MEJOR”</strong><br/><br/>
                            </td>
                        </tr>
                        <tr>
							<td colspan='2'><strong>INFORME ACADÉMICO<br/>$corte</strong>	
							</td>
                        </tr>
                        
                </table>
            	</div>";
				
				//$puestoperiodo=puestoPeriodoAlg2($records1['idestudiante'], $idaula, $aniolect, $periodo);
				//$promedioperiodo=promedioPeriodoAlg2($records1['idestudiante'], $idaula, $aniolect, $periodo);
				$promedioperiodo=promedioPeriodoAlg2($records1['idestudiante'], $idaula, $aniolect, $periodo);
				$puestoperiodo=array_search($promedioperiodo,$tabla_promedios)+1;
				$nombre_estudiante=strtoupper(
				($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".$records1['apellido2']));
            	echo "<table class='alumno'>
            	<tr >
            	<td colspan='' class='fonttitle7'   style=''><strong>ESTUDIANTE</strong><BR/>".$nombre_estudiante."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>CODIGO</strong><BR/>".$records1['idestudiante']."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>CURSO</strong><BR/>".$grado2."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>AÑO LECTIVO</strong><BR/>".$aniolect."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>PUESTO</strong><BR/>$puestoperiodo</td>
				<td colspan='' class='fonttitle7'   style=''><strong>PROMEDIO</strong><BR/>$promedioperiodo</td>
            	</tr>
            	</table>";
				   
                //----------------------------------------------------
                //Generar resultados por Area/asignatura
				
				$caracteresxlinea = 98;
				if($papel=='letter'){
					$lineasxhoja=61;
				}elseif($papel=='legal'){
					$lineasxhoja=80;
				}else{
					$lineasxhoja=61;
				}
				$lineascabezera=14;
				$lineaspie=14;
				$lineasimpresas=$lineascabezera;
				if($periodo<3){$spansem=2;}else{$spansem=4;}
				$colspan=4+$spansem+$periodo;
				$colspanNV=0;
				$sql_area_asignatura="SELECT DISTINCT a.idmateria, ar.idarea, ar.nomarea, a.nombre_materia, concat_ws(' ', d.nombre1, d.nombre2, d.apellido1, d.apellido2) AS nombre_docente, c.ih, n.idestudiante, n.vn, n.periodo, n.fj, n.fsj, n.observaciones, n.aniolectivo FROM clase c 
				JOIN materia a ON c.idmateria=a.idmateria AND c.idmateria!=49 AND c.aniolectivo='$aniolect' AND c.idaula='$idaula' AND c.periodos LIKE '%$periodo%'
				JOIN notas n ON a.idmateria=n.idmateria AND n.periodo=$periodo AND n.tipo_nota='R' AND n.aniolectivo=c.aniolectivo AND n.idestudiante='".$records1['idestudiante']."'
				JOIN matricula m ON m.idestudiante=n.idestudiante AND n.tipo_nota=m.tipo_matricula AND n.aniolectivo=m.aniolectivo AND m.idaula=c.idaula
				JOIN area ar ON ar.idarea=a.idarea_fk
				JOIN docente d ON c.iddocente=d.iddocente  
				ORDER BY ar.nomarea, a.nombre_materia  DESC";
				$consulta_area_asignatura = $conx->query($sql_area_asignatura);
				$id_area="";
				$pagina=0;
            	while($recordsarea = $conx->records_array($consulta_area_asignatura)){
					$sqlrecordNV = "SELECT notas.vn, notas.periodo FROM notas WHERE notas.idestudiante='".$records1['idestudiante']."' 
							AND notas.idmateria='".$recordsarea['idmateria']."' AND notas.tipo_nota='N' AND notas.aniolectivo=$aniolect 
							AND notas.periodo<=$periodo ORDER BY notas.periodo";
					$consultsqlrecordNV = $conx->query($sqlrecordNV);
					$colspanNV = $conx->get_numRecords($consultsqlrecordNV);
						
					$colspanArea=$colspan+$colspanNV;
					if(($lineasimpresas)>=$lineasxhoja){
						//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";														
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						$lineasimpresas=4;
						echo "<span class='Estilo7c'> CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
					}
					if($recordsarea['idarea']!=$id_area){
						echo "<br/><table class='area'>
						<tr >
						<th class='fonttitle7'   style='' colspan='' >".
							strtoupper(($recordsarea['nomarea']))."
						</th>
						</tr></table>";
						$id_area=$recordsarea['idarea'];
					}
					
					$lineasimpresas++;
					if(($lineasimpresas+3)>=$lineasxhoja){
						echo "</table>";
						//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>$lineasimpresas PAGINA $pagina DE $numapaginas</span>";								
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
					}
					echo "<table class='area'>";
					echo "<tr class='asignatura'>
					<td width='*%' ><strong>ASIGNATURA:</strong> ".strtoupper(($recordsarea['nombre_materia']))."
					<br/><strong>DOCENTE:</strong> ".strtoupper(($recordsarea['nombre_docente']))."</td>
					<td width='3%' style='text-align:center; '><strong>I.H</strong><br/> ".$recordsarea['ih']."</td>
					<td width='3%' style='text-align:center; '><strong>A.J</strong><br/> ".$recordsarea['ih']."</td>
					<td width='3%' style='text-align:center; '><strong>A.S.J</strong><br/> ".$recordsarea['ih']."</td>";
					$promedioAcomulado=0;
					if($periodo<5){
						$vnSuma=0;
						$sql_notas="SELECT notas.vn, notas.periodo FROM notas WHERE notas.idestudiante='".$records1['idestudiante']."' 
						AND notas.idmateria='".$recordsarea['idmateria']."' AND notas.tipo_nota='R' AND notas.aniolectivo=$aniolect 
						AND notas.periodo<=$periodo ORDER BY notas.periodo";
						$consulta_notas = $conx->query($sql_notas);
						while($fila_notas = $conx->records_array($consulta_notas)){
							switch($fila_notas['periodo']){
								case 1:
								case 3:	$corte3='1 C'; break;
								case 2:
								case 4:	$corte3='2 C'; break;
							}
							//$promedio_asignatura+=$fila_notas['vn'];
							echo "<td width='3%' valign='center' style='text-align:center;'><strong>".$corte3." </strong><br/>".number_format((float)$fila_notas['vn'],1,".",",")."</td>";
							$sqlrecordNV = "SELECT notas.vn, notas.periodo FROM notas WHERE notas.idestudiante='".$records1['idestudiante']."' 
							AND notas.idmateria='".$recordsarea['idmateria']."' AND notas.tipo_nota='N' AND notas.aniolectivo=$aniolect 
							AND notas.periodo=".$fila_notas['periodo']." ORDER BY notas.periodo";
							$consultarecordNV = $conx->query($sqlrecordNV);
							if($recordsperiodoNV = $conx->records_array($consultarecordNV)){
								switch($fila_notas['periodo']){
									case 1:
									case 3:
									case 2:
									case 4:	$corte2='NV'; break;
								}
								if(number_format((float)$recordsperiodoNV['vn'],1,".",",") > number_format((float)$fila_notas['vn'],1,".",",") ){
									$vnSuma+=number_format((float)$recordsperiodoNV['vn'],1,".",",");
								}
								
								echo "<td width='3%' valign='center' style='text-align:center;'><strong>$corte2</strong><br/>".number_format((float)$recordsperiodoNV['vn'],1,".",",")."</td>";
							}else{
								$vnSuma+=number_format((float)$fila_notas['vn'],1,".",",");
							}
							if($fila_notas['periodo']==2){
								$promedioFinal=number_format((float)($vnSuma/2),1,".",",");
								$vnSuma=0;
								if($promedioFinal >= (float)$rcbamin and $promedioFinal <= (float)$rcbamax){
									$desempenoFinal="Db"; 
								}elseif($promedioFinal >= (float)$rcbmin and $promedioFinal <= (float)$rcbmax){
									$desempenoFinal="DB";
								}elseif($promedioFinal >= (float)$rcamin and $promedioFinal <= (float)$rcamax){
									$desempenoFinal="DA";
								}elseif($promedioFinal >= (float)$rcsmin and $promedioFinal <= (float)$rcsmax){
									$desempenoFinal="DS";
								}
								echo "<td width='6%' nowrap valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>1 SEM</strong><br>".number_format((float)$promedioFinal,1,".",",")."</td>";
								echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>".$desempenoFinal."</strong></td>";
							}elseif($fila_notas['periodo']==1 and $fila_notas['periodo']==$periodo){
								$promedioFinal=number_format((float)($vnSuma/1),1,".",",");
								$vnSuma=0;
								if($promedioFinal >= (float)$rcbamin and $promedioFinal <= (float)$rcbamax){
									$desempenoFinal="Db"; 
								}elseif($promedioFinal >= (float)$rcbmin and $promedioFinal <= (float)$rcbmax){
									$desempenoFinal="DB";
								}elseif($promedioFinal >= (float)$rcamin and $promedioFinal <= (float)$rcamax){
									$desempenoFinal="DA";
								}elseif($promedioFinal >= (float)$rcsmin and $promedioFinal <= (float)$rcsmax){
									$desempenoFinal="DS";
								}
								echo "<td width='6%' nowrap valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>1 SEM</strong><br>".number_format((float)$promedioFinal,1,".",",")."</td>";
								echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>".$desempenoFinal."</strong></td>";
							}
							if($fila_notas['periodo']==4){
								$promedioFinal=number_format((float)($vnSuma/2),1,".",",");
								$vnSuma=0;
								if($promedioFinal >= (float)$rcbamin and $promedioFinal <= (float)$rcbamax){
									$desempenoFinal="Db"; 
								}elseif($promedioFinal >= (float)$rcbmin and $promedioFinal <= (float)$rcbmax){
									$desempenoFinal="DB";
								}elseif($promedioFinal >= (float)$rcamin and $promedioFinal <= (float)$rcamax){
									$desempenoFinal="DA";
								}elseif($promedioFinal >= (float)$rcsmin and $promedioFinal <= (float)$rcsmax){
									$desempenoFinal="DS";
								}
								echo "<td width='6%' nowrap valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>2 SEM</strong><br>".number_format((float)$promedioFinal,1,".",",")."</td>";
								echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>".$desempenoFinal."</strong></td>";
							}elseif($fila_notas['periodo']==3 and $fila_notas['periodo']==$periodo){
								$promedioFinal=number_format((float)($vnSuma/1),1,".",",");
								$vnSuma=0;
								if($promedioFinal >= (float)$rcbamin and $promedioFinal <= (float)$rcbamax){
									$desempenoFinal="Db"; 
								}elseif($promedioFinal >= (float)$rcbmin and $promedioFinal <= (float)$rcbmax){
									$desempenoFinal="DB";
								}elseif($promedioFinal >= (float)$rcamin and $promedioFinal <= (float)$rcamax){
									$desempenoFinal="DA";
								}elseif($promedioFinal >= (float)$rcsmin and $promedioFinal <= (float)$rcsmax){
									$desempenoFinal="DS";
								}
								echo "<td width='6%' nowrap valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>2 SEM</strong><br>".number_format((float)$promedioFinal,1,".",",")."</td>";
								echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>".$desempenoFinal."</strong></td>";
							}
							
						}
					}	
					echo "</tr>";
					$lineasimpresas+=2;
						
						if($aniolectivo<2016){
							$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
							pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
							FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
							(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
							and pc.estandarbc=ebc.codigo
							and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
							and eb.periodo =$periodo and eb.iddocente =$iddocente and eb.grado ='$grado'
							and ebc.idmateria_fk=m.idmateria and m.idarea_fk='".$recordsarea['idarea']."' and eb.idmateria=$idmateria
							ORDER BY consecutivo DESC";
						}else{
							//consultando competencias 
							$sqlind="SELECT DISTINCT i.idmateria, p.competencia, p.consecutivo, i.DS, i.DA, i.DB, i.DBA FROM plan_curricular p 
										JOIN indicadoresboletin i ON p.consecutivo=i.idindicador AND i.aniolectivo='$aniolect' AND i.periodo=$periodo AND i.idmateria='".$recordsarea['idmateria']."'
										JOIN aula a ON i.grado=a.grado AND a.idaula='$idaula'";
						}
						$consultaind = $conx->query($sqlind);
						$numind=$conx->get_numRecords($consulta);
						$colspan2=$colspan-2;
						if(($lineasimpresas)>=$lineasxhoja){
							echo "</table>";
							//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";														
							echo "<h1 class='SaltoDePagina'></h1>";
							$pagina++;
							if (($pagina%2)==0){
								echo"<br/><br/><br/><br/><br/>";
							}
							$lineasimpresas=4;
							echo "<table class='area'><tr>";
							for($i=1; $i<=$periodo+6; $i++){
								echo "<td></td>";
							}
							echo "</tr>";
							echo "
							<tr><td style='border-top: 1px solid black;' colspan='$colspan2' ><strong>COMPETENCIAS $corte</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>FORTALEZA</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>DEBILIDAD</strong></td></tr>";
							echo "<span class='Estilo7c'> CONTINUACIÓN INFORME ACADÉMICO DE ".
							$nombre_estudiante."  $corte</span><br/><br/>";
						}else{
							echo "<tr><td style='border-top: 1px solid black;' colspan='$colspan2' ><strong>COMPETENCIAS $corte</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>FORTALEZA</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>DEBILIDAD</strong></td></tr>";
						}
						$lineasimpresas+=1;
						while ($rowind = $conx->records_array($consultaind)) {
							$sqldelinselect="SELECT * FROM indicadoresestudiante WHERE idindicador='".$rowind['consecutivo']."'
							and aniolectivo=$aniolect and periodo=$periodo and idestudiante='".$records1['idestudiante']."'";
							$consultaindselect = $conx->query($sqldelinselect);
							
							if($rowindselect = $conx->records_array($consultaindselect)){
								$cadena = $rowind['competencia'];
								$numlineasind=ceil(strlen($cadena)/$caracteresxlinea);
								$lineasimpresas+=$numlineasind;
								if(($lineasimpresas)>=$lineasxhoja){
									echo "</table>";
									//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";								
									echo "<h1 class='SaltoDePagina'></h1>";
									$pagina++;
									if (($pagina%2)==0){
										echo"<br/><br/><br/><br/><br/>";
									}
									echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
									$nombre_estudiante."  $corte</span><br/><br/>";
									echo "<table class='area'><tr><td width='48%'></td>";
									for($i=1; $i<=$periodo+5; $i++){
										
										echo "<td ></td>";
									}
									echo "</tr>";
									echo "<tr>";
									echo "<td align='left' style='font-family: \"Courier New\", Courier, monospace;
									font-style: normal; fon-size:12px' colspan='$colspan2' rowspan=''>".(($rowind['competencia']))."</td>";
									if($rowindselect['nivel_aprendizaje']=='F'){
										echo "<td align='center' rowspan='' width='6%' ><img src='../../images/F.png' width='15' height='15' ></img></td><td rowspan='' width='78px'></td>";
									}else{
										echo "<td rowspan='' width='6%'></td><td align='center' rowspan='' width='78px'><img src='../../images/D.png' width='15' height='15'></img></td>";
									}
									echo "</tr>";
									$lineasimpresas=4;
								}else{
									echo "<tr>";
									echo "<td align='left' style='font-family: \"Courier New\", Courier, monospace;
									font-style: normal; fon-size:12px' colspan='$colspan2'>".(($rowind['competencia']))."</td>";
									if($rowindselect['nivel_aprendizaje']=='F'){
										echo "<td width='6%' align='center' ><img src='../../images/F.png' width='15' height='15' ></img></td><td></td>";
									}else{
										echo "<td></td><td width='6%' align='center'><img src='../../images/D.png' width='15' height='15'></img></td>";
									}
									echo "</tr>";
								}
								
							}
					
						}
							
					if(($lineasimpresas)>=($lineasxhoja)){
						echo "</table>";
						//echo "<span style='text-align:right; text-align:right; margin-left:810px; position:relative;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
					}else{
						echo "</table>";
					}
						
				}
				
				//Generar resultados COMPORTAMIENTO
				if(($lineasimpresas+4)>=($lineasxhoja)){
						echo "</table>";
						//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)!=0){
							echo"<br/><br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
				}
            	echo "<br/><br/><table class='area'>";
				
					$sql="SELECT DISTINCT a.idmateria, ar.idarea, ar.nomarea, a.nombre_materia, concat_ws(' ', d.nombre1, d.nombre2, d.apellido1, d.apellido2) AS nombre_docente, c.ih, n.idestudiante, n.vn, n.periodo, n.fj, n.fsj, n.observaciones, n.aniolectivo FROM clase c 
					JOIN materia a ON c.idmateria=a.idmateria AND c.idmateria=49 AND c.aniolectivo='$aniolect' AND c.idaula='$idaula' AND c.periodos LIKE '%$periodo%'
					JOIN notas n ON a.idmateria=n.idmateria AND n.periodo=$periodo AND n.tipo_nota='R' AND n.aniolectivo=c.aniolectivo AND n.idestudiante='".$records1['idestudiante']."'
					JOIN matricula m ON m.idestudiante=n.idestudiante AND n.tipo_nota=m.tipo_matricula AND n.aniolectivo=m.aniolectivo AND m.idaula=c.idaula
					JOIN area ar ON ar.idarea=a.idarea_fk
					JOIN docente d ON c.iddocente=d.iddocente  
					ORDER BY ar.nomarea, a.nombre_materia  DESC";
					$consulta2 = $conx->query($sql);
					$colspan2=1;
					$lineasimpresas+=2;
					while($records2 = $conx->records_array($consulta2)){
						$dinamizador=($records2['nombre_docente']);
						echo "<tr><th colspan='3'>".($records2['nombre_materia'])."</th></tr>";
						echo "<tr class='asignatura'>
						<td width='400px' colspan='3'><strong>DINAMIZADOR(A):</strong> ".strtoupper(($records2['nombre_docente']))."</td>";
						echo "</tr>";
						$lineasimpresas+=2;
						///seleccionando indicadores escogidos por el docenbte en esta area y curso
						
						if($aniolectivo<2016){
							$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
							pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
							FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
							(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
							and pc.estandarbc=ebc.codigo
							and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolect
							and eb.periodo =$periodo and eb.iddocente =$iddocente and eb.grado ='$grado'
							and ebc.idmateria_fk=m.idmateria and m.idarea_fk='20'
							ORDER BY consecutivo DESC";
						}else{
							//consultando competencias 
							$sqlind="SELECT DISTINCT i.idmateria, p.competencia, p.consecutivo, i.DS, i.DA, i.DB, i.DBA FROM plan_curricular p 
							JOIN indicadoresboletin i ON p.consecutivo=i.idindicador AND i.aniolectivo='$aniolect' AND i.periodo=$periodo AND i.idmateria='".$records2['idmateria']."'
							JOIN aula a ON i.grado=a.grado AND a.idaula='$idaula'";
							
						}
						$consultaind = $conx->query($sqlind);
						$numind=$conx->get_numRecords($consultaind);
						$colspan2=1;
						if(($lineasimpresas+7)>=($lineasxhoja)){
							echo "</table>";
							//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";														
							echo "<h1 class='SaltoDePagina'></h1>";
							$pagina++;
							if (($pagina%2)==0){
								echo"<br/><br/><br/><br/><br/>";
							}
							echo "<table class='area'><tr>";
							for($i=1; $i<=3; $i++){
								echo "<td width='6%'></td>";
							}
							echo "</tr>";
							echo "
							<tr><td style='border-top: 1px solid black;' colspan='$colspan2' width='70%'><strong>ACTITUDES $corte</strong></td>
							<td width='6%' valign='center' style='text-align:center; border-top: 1px solid black;'><strong>FORTALEZA</strong></td>
							<td width='6%' valign='center' style='text-align:center; border-top: 1px solid black;'><strong>DEBILIDAD</strong></td></tr>";
							echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
							$nombre_estudiante."  $corte</span><br/><br/>";
							$lineasimpresas=4;
						}else{
							echo "<tr><td style='border-top: 1px solid black;' colspan='$colspan2'><strong>ACTITUDES $corte</strong></td>
							<td width='6%' valign='center' style='text-align:center; border-top: 1px solid black;'><strong>FORTALEZA</strong></td>
							<td width='6%' valign='center' style='text-align:center; border-top: 1px solid black;'><strong>DEBILIDAD</strong></td></tr>";
						}
						while ($rowind = $conx->records_array($consultaind)) {
							$sqldelinselect="SELECT * FROM indicadoresestudiante WHERE idindicador='".$rowind['consecutivo']."'
							and aniolectivo=$aniolect and periodo=$periodo and idestudiante='".$records1['idestudiante']."'";
							$consultaindselect = $conx->query($sqldelinselect);
							
							if($rowindselect = $conx->records_array($consultaindselect)){
								$cadena = $rowind['competencia'];
								$numlineasind=ceil(strlen($cadena)/$caracteresxlinea);
								$lineasimpresas+=$numlineasind;
								if(($lineasimpresas+4)>=($lineasxhoja)){
									echo "</table>";
									//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";								
									echo "<h1 class='SaltoDePagina'></h1>";
									$pagina++;
									if (($pagina%2)==0){
										echo"<br/><br/><br/><br/><br/>";
									}
									echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
									$nombre_estudiante."  $corte</span><br/><br/>";
									echo "<table class='area'><tr><td width='400px'></td>";
									for($i=1; $i<=2; $i++){
										
										echo "<td width='6%' ></td>";
									}
									echo "</tr>";
									echo "<tr>";
									echo "<td align='left' style='font-family: \"Courier New\", Courier, monospace;
									font-style: normal; fon-size:12px' colspan='$colspan2' rowspan='' width='80%>".(($rowind['competencia']))."</td>";
									if($rowindselect['nivel_aprendizaje']=='F'){
										echo "<td width='6%' align='center' rowspan='' width='78px' ><img src='../../images/F.png' width='15' height='15' ></img></td><td rowspan='' width='78px'></td>";
									}else{
										echo "<td width='6%' rowspan='' width='78px'></td><td align='center' rowspan='' width='78px'><img src='../../images/D.png' width='15' height='15'></img></td>";
									}
									echo "</tr>";
									$lineasimpresas=4;
								}else{
									echo "<tr>";
									echo "<td align='left' style='font-family: \"Courier New\", Courier, monospace;
									font-style: normal;' colspan='$colspan2'>".(($rowind['competencia']))."</td>";
									if($rowindselect['nivel_aprendizaje']=='F'){
										echo "<td width='6%' align='center' ><img src='../../images/F.png' width='15' height='15' ></img></td><td width='6%'></td>";
									}else{
										echo "<td width='6%' ></td><td width='6%' align='center'><img src='../../images/D.png' width='15' height='15'></img></td>";
									}
									echo "</tr>";
								}
								
					
						}
							
					}
					if(($pagina%2)==0){
						$lineasimpresas+=7;
					}
					if(($lineasimpresas)>=($lineasxhoja)){
						echo "</table>";
						//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=3;
					}else{
						echo "</table>";
					}
						
				}
				
				//observaciones generales
				echo "
				<br/><br/>
				<table class='alumno' border='0' cellspacing='5px' >
			   <tr >
			   <th colspan='2'>
				   <p class='Estilo5' align='center'>OBSERVACIONES GENERALES</p>
			   </th>
			   </tr>
			   <tr class='asignatura'>
				<td width='30%' align='left' class='Estilo6'>ASIGNATURA</td>
				<td  align='left' class='Estilo6' >OBSERVACIÓN</td>
			   </tr>";
				$lineasimpresas+=2;
				
									
				$sqlog = "SELECT DISTINCT a.nombre_materia, n.observaciones 
				FROM materia a, notas n WHERE n.idestudiante=".$records1['idestudiante']." AND a.idmateria=n.idmateria 
				AND periodo='$periodo' AND n.aniolectivo=$aniolect 
				AND n.tipo_nota='R' AND n.observaciones IS NOT NULL
				ORDER BY a.nombre_materia ASC";
				$consultaog = $conx->query($sqlog);
				while($recordsog = $conx->records_array($consultaog)){
					if($recordsog['observaciones']!=NULL){
						 $observaciones=$recordsog['observaciones'];
						 $existe = strrpos($observaciones, ".");
						 if($existe==false ){
								$observaciones.=".";
						 }
						 $numlineasobs=0;
						 $cadena = $recordsog['observaciones'];
						 $numlineasobs+=ceil(strlen($cadena)/$caracteresxlinea);
						 $lineasimpresas+=$numlineasobs;
						 if(($lineasimpresas)>=89){
							echo "</table>";
							//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";								
							echo "<h1 class='SaltoDePagina'></h1>";
							$pagina++;
							if (($pagina%2)==0){
								echo"<br/><br/><br/><br/><br/>";
							}
							echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
							$nombre_estudiante."  $corte</span><br/><br/>";
							echo "<table class='alumno' border='0' cellspacing='5px' >";
							echo "<tr>
							<td  width='30%' align='center' class='Estilo1'>".strtoupper(($recordsog['nombre_materia']))."</td>
						   <td align='left' valign='top' style='line-height:15px; text-align:justify; font-family: \"Courier New\", Courier, monospace;
									font-style: normal;'>
							<span class='' >".utf8_decode(
							String_oracion($observaciones))."</span>&nbsp;
							</td>
							</tr>";
							$lineasimpresas=4;
						}else{
							echo "<tr>
							<td  class='Estilo1'>".strtoupper($recordsog['nombre_materia'])."</td>
						   <td align='left' valign='top' style='line-height:15px; text-align:justify; font-family: \"Courier New\", Courier, monospace;
									font-style: normal;'>
							<span class='' >".utf8_decode(
							String_oracion($observaciones))."</span>&nbsp;
							</td>
							</tr>";
						}
						
					}
				}
				echo "</table>";
				$lineasimpresas+1;
				if($lineasimpresas>=89){
						//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
				}
				//---------------------------CONVENCIONES
				echo "
				<br/><div class='firma'>
				<table class='convenciones'>
				<tr>
					<td width='150px' colspan='6' valign='center' style='text-align:center; background:#E5E5E5;'>CONVENCIONES</td>
				</tr>";
				$lineasimpresas++;
				if(($lineasimpresas)>=($lineasxhoja) or $lineasimpresas>=89){
						//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
				}
				echo "<tr>
					<td width='45' valign='top'>DS</td>
					<td width='161' valign='top' class='Estilo7'>Desempeño Superior [".number_format((float)$rcsmin,1,'.',',')." a ".number_format((float)$rcsmax,1,'.',',')."]</td>
					<td width='45' valign='top'>DA</td>
					<td width='161' valign='top' class='Estilo7'>Desempeño Alto [".number_format((float)$rcamin,1,'.',',')." a ".number_format((float)$rcamax,1,'.',',')."]</td>
					<td width='45' valign='top'>A.J</td>
					<td width='161' valign='top' class='Estilo7'>Ausencias con justificación</td>
				</tr>";
				$lineasimpresas++;
				if(($lineasimpresas)>=($lineasxhoja) or $lineasimpresas>=89){
						//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
				}
				
				echo "<tr>
					<td width='45' valign='top'>DB</td>
					<td width='161' valign='top' class='Estilo7'>Desempeño Básico [".number_format((float)$rcbmin,1,'.',',')." a ".number_format((float)$rcbmax,1,'.',',')."]</td>
					<td width='45' valign='top'>Db</td>
					<td width='161' valign='top' class='Estilo7'>Desempeño Bajo [".number_format((float)$rcbamin,1,'.',',')." a ".number_format((float)$rcbamax,1,'.',',')."]</td>
					<td width='45' valign='top'>A.S.J</td>
					<td width='161' valign='top' class='Estilo7' >Ausencias sin justificación</td>
					
				</tr>";
				$lineasimpresas++;
				if(($lineasimpresas)>=($lineasxhoja) or $lineasimpresas>=89){
						//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
				}
				echo "<tr>
					<td width='45' valign='top'>1 C</td>
					<td width='161' valign='top' class='Estilo7' >Primer Corte</td>
					<td width='45' valign='top'>2 C</td>
					<td width='161' valign='top' class='Estilo7'>Segundo Corte</td>
					<td width='45' valign='top'>I.H</td>
					<td width='161' valign='top' class='Estilo7' >Intensidad Horaria</td>
				</tr>";
				$lineasimpresas++;
				if(($lineasimpresas)>=($lineasxhoja) or $lineasimpresas>=89){
						//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
				}
				echo "<tr>
					
					<td width='45' valign='top'>1 SEM</td>
					<td width='161' valign='top' class='Estilo7' >Promedio 1er Semestre</td>
					<td width='45' valign='top'>2 SEM</td>
					<td width='161' valign='top' class='Estilo7'>Promedio 2do Semestre</td>
					<td width='45' valign='top'>D</td>
					<td width='161' valign='top' class='Estilo7' >Definitiva</td>
				</tr>
				</table></div>"; 
				
				if($periodo==4){
					echo 
					"<div style='line-height:7px;'>
					<br/><br/><br/><br/><br/><br/><br/>
							<tr>
								<td width='50%' align='center'>
									<span align='center' class='blocktext' style='text-decoration:overline; font-weight:bold' >Padre de Familia o Acudiente</span>
								</td>
								<td align='center'>
									<span class='blocktext' style='text-decoration:overline; font-weight:bold'>$dinamizador</span>
									<br/><span align='center' class='blocktext' >Director(a) de Grupo</span>
								</td>
							</tr>
					</table>
					</div>";
			   
			   }else{
					echo 
					"<div style='line-height:7px;'>
					<br/><br/><br/><br/><br/><br/><br/>
					<table class='firma' border='0'>
							<tr>
								<td width='50%' align='center'>
									<span class='blocktext' style='text-decoration:overline; font-weight:bold'>$dinamizador</span>
									<br/><span align='center' class='blocktext' >Dinamizador(a) de Curso</span>
				
								</td>
								<td align='center'>
									<br/><span align='center' class='blocktext' style='text-decoration:overline; font-weight:bold' >Padre de Familia o Acudiente</span>
								</td>
							</tr>
					</table>
					</div>";
			   }
				//echo "</div><br/><span style='text-align:right; margin-left:810px; position:relative;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
				$par=($pagina%2);
				if($numest>1){
					echo "<h1 class='SaltoDePagina'></h1>";
					
					if ( $par!=0 and $numest!=1 and $pagina>1){
						echo "<h1 class='SaltoDePagina'><span style='color:white'>CONTINUACIÓN INFORME ACADÉMICO DE ".
									$nombre_estudiante." $corte</span></h1>";
					}elseif($pagina==1){
						echo "<h1 class='SaltoDePagina'><span style='color:white'>CONTINUACIÓN INFORME ACADÉMICO DE ".
									$nombre_estudiante." $corte</span></h1>";
					}
				}
				$numest--;
				if ( $par!=0 and $numest==0 and $pagina>1){
					echo "<h1 class='SaltoDePagina'><span style='color:white'>CONTINUACIÓN INFORME ACADÉMICO DE ".
								strtoupper($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
								$records1['apellido2'])." $corte</span></h1>";
				}elseif($pagina==1){
					echo "<h1 class='SaltoDePagina'><span style='color:white'>CONTINUACIÓN INFORME ACADÉMICO DE ".
								$nombre_estudiante." $corte</span></h1>";
				}

				
				
				
				
				//-------------------------------FIN LADO B------------------------------------------------  
			}
			
	}elseif($formato=="f4"){
	// Formato por competencias con historico 
		    ?>
			<div id="ex1" style="">
			<div id="imgLOAD" style="text-align:center;" class="modal">
			<b>Gerenando Boletines...</b>
			<img src="../../images/loadingbar-blue.gif" /> Boletin <span id="boletingenerado"></span> DE <span id="totalboletines"></span>
			</div>
			</div>
			<?php
			$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
			$conx2 = new ConxMySQL($dominio,$usuario,$pass,$bd);
			$conx3 = new ConxMySQL($dominio,$usuario,$pass,$bd);
			if (isset($_POST['idestudiante'])) {
				$sqlest = "SELECT DISTINCT e.idestudiante, e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula 
							FROM estudiante e
							INNER JOIN matricula m ON e.idestudiante=m.idestudiante
							INNER JOIN notas n ON m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo AND m.tipo_matricula=n.tipo_nota
							WHERE m.aniolectivo=$aniolect AND m.idaula=$idaula AND m.tipo_matricula='R' AND m.periodo=0
							AND n.periodo=$periodo AND e.idestudiante='".$_POST['idestudiante']."'
							ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";
				
			}else{
				$sqlest = "SELECT DISTINCT 
							e.apellido1, e.apellido2, 
							e.nombre1, e.nombre2, m.idaula, e.idestudiante 
							FROM estudiante e
							INNER JOIN matricula m
							ON e.idestudiante=m.idestudiante AND m.idaula=$idaula
							AND m.tipo_matricula='R' AND m.periodo=0 AND m.aniolectivo=$aniolect
							AND e.habilitado='S'
							INNER JOIN notas n ON m.idestudiante=n.idestudiante
							AND m.aniolectivo=n.aniolectivo
							AND n.tipo_nota=m.tipo_matricula AND n.periodo=$periodo
							ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";
			}

        	$consultaest = $conx->query($sqlest);
			$numest = $conx->get_numRecords($consultaest);
			$totalest = $conx->get_numRecords($consultaest);
			//
			$total_materias=numero_asignaturas_salon($idaula, $aniolect);
			//$tabla_promedios=tabla_promedios_con_comportamiento($idaula, $aniolect, $periodo,"N",$total_materias);
			// Llamar al procedimiento almacenado para consultar notas del salón
			$sql = "CALL ConsultarNotas($total_materias, $numero_decimales, $aniolect, $idaula, $periodo, '')";
			//agrupar resultados de notas
			$resultado = mysqli_query($conx2->getConexion(), $sql);
			if ($resultado) {
				$resultados = $conx2->records_array_assoc_all($resultado);
				// Array para almacenar los resultados agrupados por nombre
				$resultados_agrupados = array();

				// Iterar sobre los resultados y agruparlos por nombre
				// Recorrer los resultados y agruparlos por nombre y materia
				foreach ($resultados as $fila) {
					$nombre = $fila['nombre'];
					$materia = $fila['idmateria'];
					// Verificar si ya existe una entrada para este nombre en el array
					if (!isset($resultados_agrupados[$nombre])) {
						$resultados_agrupados[$nombre] = array();
					}
					// Verificar si ya existe una entrada para esta materia en el array del nombre actual
					if (!isset($resultados_agrupados[$nombre][$materia])) {
						$resultados_agrupados[$nombre][$materia] = array();
					}
					// Agregar la fila a la entrada correspondiente
					$resultados_agrupados[$nombre][$materia][] = $fila;
				}
				$numreg = count($resultados_agrupados);
			}
			$notas_porcentuales=obtenerNotas_porcentuales($aniolect, $periodo, $idaula, $numero_decimales);
			
            while($records1 = $conx->records_array($consultaest)){
				$msjBoletin= ($totalest-$numest)+1;
				echo "<script>$('#boletingenerado').text($msjBoletin); $('#totalboletines').text($totalest);</script>";
				$contmat=0;
            	switch($periodo){
					case 1: $corte="1ER"; break;
					case 2: $corte="2DO"; break;							
					case 3: $corte="3ER"; break;
				}
				switch($tipo_periodo){
					case 'T': $corte.=" TRIMESTRE"; break;
					case 'S': $corte.=" SEMESTRE"; break;							
				}
				echo 
                "<div class='fondo'><div style='line-height:7px;'>
                <table class='normal'>
                        <tr>
                            <td width='100px' align='left' rowspan='' valign='top'>
                                <span  class='blocktext'><img  src='../../images/logocol.png' width='95' height='95'/></span>
                            </td>
                            <td style='font-family: Arial, Helvetica, sans-serif;font-size:12px; font-style:italic;'><strong>INSTITUCIÓN EDUCATIVA MISIONAL SANTA TERESITA<br/>
								 San Andrés de Tumaco D.E.<br/>
								 NIT: 840.000.320-1      REGISTRO DANE: 152835001568      ICFES: 118117</strong><br/>
								Institución Educativa de Educación Preescolar, Primaria, Básica y Media Vocacional<br/>
								Aprobado mediante Resoluciones: 1325 del 24 de Julio de 2001 Básica Primaria, 1972 del 5 de<br/>
								Octubre 2001 Básica Secundaria y 4075 del 27 de Diciembre de 2002 Media Vocacional<br/>
								<strong>“HOY MEJOR QUE AYER, SIEMPRE LO MEJOR”</strong><br/><br/>
                            </td>
                        </tr>
                        <tr>
							<td colspan='2'><strong>INFORME ACADÉMICO<br/>$corte</strong>	
							</td>
                        </tr>
                        
                </table>
            	</div>";
				
				//$puestoperiodo=puestoPeriodoAlg2($records1['idestudiante'], $idaula, $aniolect, $periodo);
				//$promedioperiodo=promedioPeriodoAlg2($records1['idestudiante'], $idaula, $aniolect, $periodo);
				
				//recuperamos el puesto y promedio
				$puesto_promedio = encontrarPuestoYPromedioPorId($resultados_agrupados, $records1['idestudiante']);
				$puestoperiodo = $puesto_promedio['puesto'];
				$promedioperiodo = $puesto_promedio['promedio'];
				$nombre_estudiante=strtoupper(
				($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".$records1['apellido2']));
            	echo "<table class='alumno'>
            	<tr >
            	<td colspan='' class='fonttitle7'   style=''><strong>ESTUDIANTE</strong><BR/>".$nombre_estudiante."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>CODIGO</strong><BR/>".$records1['idestudiante']."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>CURSO</strong><BR/>".$grado2."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>AÑO LECTIVO</strong><BR/>".$aniolect."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>PUESTO</strong><BR/>$puestoperiodo</td>
				<td colspan='' class='fonttitle7'   style=''><strong>PROMEDIO</strong><BR/>$promedioperiodo</td>
            	</tr>
            	</table>";
				   
                //----------------------------------------------------
                //Generar resultados por Area/asignatura
				
				$caracteresxlinea = 98;
				if($papel=='letter'){
					$lineasxhoja=61;
				}elseif($papel=='legal'){
					$lineasxhoja=80;
				}else{
					$lineasxhoja=61;
				}
				$lineascabezera=14;
				$lineaspie=14;
				$lineasimpresas=$lineascabezera;
				if($periodo<3){$spansem=2;}else{$spansem=4;}
				$colspan=4+$spansem+$periodo;
				$colspanNV=0;
				$sql_area_asignatura="SELECT DISTINCT a.idmateria, ar.idarea, ar.nomarea, a.nombre_materia, concat_ws(' ', d.nombre1, d.nombre2, d.apellido1, d.apellido2) AS nombre_docente, c.ih, n.idestudiante, n.vn, n.periodo, n.fj, n.fsj, n.observaciones, n.aniolectivo FROM clase c 
				JOIN materia a ON c.idmateria=a.idmateria AND c.idmateria!=49 AND c.aniolectivo='$aniolect' AND c.idaula='$idaula' AND c.periodos LIKE '%$periodo%'
				JOIN notas n ON a.idmateria=n.idmateria AND n.periodo=$periodo AND n.tipo_nota='R' AND n.aniolectivo=c.aniolectivo AND n.idestudiante='".$records1['idestudiante']."'
				JOIN matricula m ON m.idestudiante=n.idestudiante AND n.tipo_nota=m.tipo_matricula AND n.aniolectivo=m.aniolectivo AND m.idaula=c.idaula
				JOIN area ar ON ar.idarea=a.idarea_fk
				JOIN docente d ON c.iddocente=d.iddocente  
				ORDER BY ar.nomarea, a.nombre_materia  DESC";
				$consulta_area_asignatura = $conx->query($sql_area_asignatura);
				$id_area="";
				$pagina=1;
            	while($recordsarea = $conx->records_array($consulta_area_asignatura)){
					$sqlrecordNV = "SELECT notas.vn, notas.periodo FROM notas WHERE notas.idestudiante='".$records1['idestudiante']."' 
							AND notas.idmateria='".$recordsarea['idmateria']."' AND notas.tipo_nota='N' AND notas.aniolectivo=$aniolect 
							AND notas.periodo<=$periodo ORDER BY notas.periodo";
					$consultsqlrecordNV = $conx->query($sqlrecordNV);
					$colspanNV = $conx->get_numRecords($consultsqlrecordNV);
						
					$colspanArea=$colspan+$colspanNV;
					if(($lineasimpresas)>=$lineasxhoja){
						//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";														
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/>";
						}
						$lineasimpresas=4;
						echo "<span class='Estilo7c'> CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
					}
					$calificacion_area= obtenerNotaPorcentualArea($notas_porcentuales, $records1['idestudiante'], $recordsarea['idarea'], $periodo);
					$calificacion_asignatura = obtenerNotaPorcentualMateria($notas_porcentuales, $records1['idestudiante'], $recordsarea['idmateria'], $periodo);
					$notaporcentual_asignatura="";
					$porcentaje_calificado="";
					if(!empty($calificacion_asignatura)){
						$notaporcentual_asignatura=$calificacion_asignatura['notaporcentual'];
						$porcentaje_calificado=$calificacion_asignatura['porcentaje'];						
					}
					if($recordsarea['idarea']!=$id_area){
						echo "<br/><table class='area'>
						<tr >
						<th class='fonttitle7'   style='' colspan='' width='20%' >".
							strtoupper(($recordsarea['nomarea']))."
						</th>";
						if(!empty($calificacion_area)){
							echo "<th width='10%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>NOTA: ".$calificacion_area['nota_area']."</strong></th>";
							if($calificacion_area['nota_area'] >= (float)$rcbamin and $calificacion_area['nota_area'] <= (float)$rcbamax){
								$desempenoFinal="Dba"; 
							}elseif($calificacion_area['nota_area'] >= (float)$rcbmin and $calificacion_area['nota_area'] <= (float)$rcbmax){
								$desempenoFinal="DB";
							}elseif($calificacion_area['nota_area'] >= (float)$rcamin and $calificacion_area['nota_area'] <= (float)$rcamax){
								$desempenoFinal="DA";
							}elseif($calificacion_area['nota_area'] >= (float)$rcsmin and $calificacion_area['nota_area'] <= (float)$rcsmax){
								$desempenoFinal="DS";
							}
							echo "<th width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>".$desempenoFinal."</strong></th>";
							echo "<th width='60%'></th>";
						}
						echo "</tr></table>";
						$id_area=$recordsarea['idarea'];
					}
					
					$lineasimpresas++;
					if(($lineasimpresas+3)>=$lineasxhoja){
						echo "</table>";
						//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>$lineasimpresas PAGINA $pagina DE $numapaginas</span>";								
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
					}
					echo "<table class='area'>";
					echo "<tr class='asignatura'>";
					?>
					<td width='*%'><strong>ASIGNATURA:</strong> <?php echo strtoupper($recordsarea['nombre_materia']) . (!empty($porcentaje_calificado) ? " ".$porcentaje_calificado."%" : ""); ?>
					<br/><strong>DOCENTE:</strong> <?php echo strtoupper($recordsarea['nombre_docente']); ?></td>
					<?php
					
					ECHO "<td width='3%' style='text-align:center; '><strong>I.H</strong><br/> ".$recordsarea['ih']."</td>
					<td width='3%' style='text-align:center; '><strong>A.J</strong><br/> ".$recordsarea['fj']."</td>
					<td width='3%' style='text-align:center; '><strong>A.S.J</strong><br/> ".$recordsarea['fsj']."</td>";
					
					$promedioAcomulado=0;
					if($periodo<5){
						$vnSuma=0;
						$sql_notas="SELECT notas.vn, notas.periodo FROM notas WHERE notas.idestudiante='".$records1['idestudiante']."' 
						AND notas.idmateria='".$recordsarea['idmateria']."' AND notas.tipo_nota='R' AND notas.aniolectivo=$aniolect 
						AND notas.periodo<=$periodo ORDER BY notas.periodo";
						$consulta_notas = $conx->query($sql_notas);
						$numperiodos=0;
						while($fila_notas = $conx->records_array($consulta_notas)){
							$numperiodos++;
							switch($fila_notas['periodo']){
								case 1: $corte3='1 T'; break;
								case 2:	$corte3='2 T'; break;
								case 3: $corte3='3 T'; break;
							}
							$notas_porcentuales=obtenerNotas_porcentuales($aniolect, $fila_notas['periodo'], $idaula, $numero_decimales);
							$calificacion_asignatura = obtenerNotaPorcentualMateria($notas_porcentuales, $records1['idestudiante'], $recordsarea['idmateria'], $fila_notas['periodo']);
							$notaporcentual_asignatura="";
							$porcentaje_calificado="";
							if(!empty($calificacion_asignatura)){
								$notaporcentual_asignatura=$calificacion_asignatura['notaporcentual'];
								$porcentaje_calificado=$calificacion_asignatura['porcentaje'];						
							}
							//$promedio_asignatura+=$fila_notas['vn'];
							echo "<td width='3%' valign='center' style='text-align:center;'><strong>".$corte3." </strong><br/>".number_format(round((float)$fila_notas['vn'], $numero_decimales),$numero_decimales,".",",").(!empty($notaporcentual_asignatura)? "[".$notaporcentual_asignatura."]":"")."</td>";

							$sqlrecordNV = "SELECT notas.vn, notas.periodo FROM notas WHERE notas.idestudiante='".$records1['idestudiante']."' 
							AND notas.idmateria='".$recordsarea['idmateria']."' AND notas.tipo_nota='N' AND notas.aniolectivo=$aniolect 
							AND notas.periodo=".$fila_notas['periodo']." ORDER BY notas.periodo";
							$consultarecordNV = $conx->query($sqlrecordNV);
							if($recordsperiodoNV = $conx->records_array($consultarecordNV)){
								switch($fila_notas['periodo']){
									case 1:
									case 3:
									case 2:
									case 4:	$corte2='NV'; break;
								}
								if(number_format((float)$recordsperiodoNV['vn'],1,".",",") > number_format((float)$fila_notas['vn'],1,".",",") ){
									$vnSuma+=number_format((float)$recordsperiodoNV['vn'],1,".",",");
								}
								// if(number_format(round((float)$recordsperiodoNV['vn'], $numero_decimales),$numero_decimales,".",",") > number_format(round((float)$fila_notas['vn'], $numero_decimales),$numero_decimales,".",",") ){
									// $vnSuma+=number_format(round((float)$recordsperiodoNV['vn'], $numero_decimales),$numero_decimales,".",",");
								// }
								
								echo "<td width='3%' valign='center' style='text-align:center;'><strong>$corte2</strong><br/>".number_format(round((float)$recordsperiodoNV['vn'], $numero_decimales),$numero_decimales,".",",")."</td>";
								
							}else{
								//if(!empty($calificacion_asignatura)){
								//	$vnSuma+=number_format(round((float)(!empty($notaporcentual_asignatura)? $notaporcentual_asignatura:0), $numero_decimales),$numero_decimales,".",",");
								//}
								//else{
									//$vnSuma+=number_format(round((float)$fila_notas['vn'], $numero_decimales),$numero_decimales,".",",");
								//}
								$vnSuma+=number_format(round((float)$fila_notas['vn'], $numero_decimales),$numero_decimales,".",",");
							}
						}
						//if(!empty($calificacion_asignatura)){
						//	$promedioFinal=number_format(round((float)($vnSuma), $numero_decimales),$numero_decimales,".",",");
						//}else{
						
							$promedioFinal=number_format(round((float)($vnSuma/$numperiodos), $numero_decimales),$numero_decimales,".",",");
						//}
						$vnSuma=0;
						
						$promedioFinal = (float)$promedioFinal;

						// Convertimos todas las variables a float una sola vez
						$rcbamin = (float)$rcbamin;
						$rcbamax = (float)$rcbamax;
						$rcbmin = (float)$rcbmin;
						$rcbmax = (float)$rcbmax;
						$rcamin = (float)$rcamin;
						$rcamax = (float)$rcamax;
						$rcsmin = (float)$rcsmin;
						$rcsmax = (float)$rcsmax;
						
						// Definir los rangos y sus desempeños en un array
						$rangos = [
							'Dba' => [$rcbamin, $rcbamax],
							'DB'  => [$rcbmin, $rcbmax],
							'DA'  => [$rcamin, $rcamax],
							'DS'  => [$rcsmin, $rcsmax]
						];
						
						// Inicializar la variable de desempeño final
						$desempenoFinal = null;

						// Iterar sobre los rangos y asignar el desempeño correspondiente
						foreach ($rangos as $desempeno => [$min, $max]) {
							if ($promedioFinal >= $min && $promedioFinal <= $max) {
								$desempenoFinal = $desempeno;
								
								break; // Rompemos el bucle una vez que encontramos el rango correcto
							}
						}
												
						
						
						
						echo "<td width='6%' nowrap valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>PARCIAL</strong><br>".number_format(round((float)$promedioFinal, $numero_decimales),$numero_decimales ,".",",")."</td>";
						
						if($grado==0){
							switch($desempenoFinal){
								case 'DS': 
											echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><img src='../../images/superiorkg.png' width='30' height='30'></td>";
											break;
								case 'DA': 
											echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><img src='../../images/altokg.png' width='30' height='30'></td>";
											break;
								case 'DB': 
											echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><img src='../../images/basicokg.png' width='30' height='30'></td>";
											break;
								default: 
											echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><img src='../../images/bajokg.png' width='30' height='30'></td>";
											break;
							}
						}else{
							echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>".$desempenoFinal."</strong></td>";
						}
						
					}	
					echo "</tr>";
					$lineasimpresas+=2;
						
					if($aniolectivo<2016){
						$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
						pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
						FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
						(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
						and pc.estandarbc=ebc.codigo
						and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
						and eb.periodo =$periodo and eb.iddocente =$iddocente and eb.grado ='$grado'
						and ebc.idmateria_fk=m.idmateria and m.idarea_fk='".$recordsarea['idarea']."' and eb.idmateria=$idmateria
						ORDER BY consecutivo DESC";
					}else{
						//consultando competencias 
						$sqlind="SELECT DISTINCT i.idmateria, p.competencia, p.consecutivo, i.DS, i.DA, i.DB, i.DBA FROM plan_curricular p 
									JOIN indicadoresboletin i ON p.consecutivo=i.idindicador AND i.aniolectivo='$aniolect' AND i.periodo=$periodo AND i.idmateria='".$recordsarea['idmateria']."'
									JOIN aula a ON i.grado=a.grado AND a.idaula='$idaula'";
					}
					$consultaind = $conx->query($sqlind);
					$numind=$conx->get_numRecords($consulta);
					$colspan2=$colspan-2;
					if(($lineasimpresas)>=$lineasxhoja){
						echo "</table>";
						//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";														
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/>";
						}
						$lineasimpresas=4;
						echo "<table class='area'><tr>";
						for($i=1; $i<=$periodo+6; $i++){
							echo "<td></td>";
						}
						echo "</tr>";
						echo "
						<tr><td style='border-top: 1px solid black;' colspan='$colspan2' ><strong>COMPETENCIAS $corte</strong></td>
						<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>FORTALEZA</strong></td>
						<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>DEBILIDAD</strong></td></tr>";
						echo "<span class='Estilo7c'> CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
					}else{
						echo "<tr><td style='border-top: 1px solid black;' colspan='$colspan2' ><strong>COMPETENCIAS $corte </strong></td>
						<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>FORTALEZA</strong></td>
						<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>DEBILIDAD</strong></td></tr>";
					}
					$lineasimpresas+=1;
					while ($rowind = $conx->records_array($consultaind)) {
						$sqldelinselect="SELECT * FROM indicadoresestudiante WHERE idindicador='".$rowind['consecutivo']."'
						and aniolectivo=$aniolect and periodo=$periodo and idestudiante='".$records1['idestudiante']."'";
						$consultaindselect = $conx->query($sqldelinselect);
						
						if($rowindselect = $conx->records_array($consultaindselect)){
							$cadena = $rowind['competencia'];
							$numlineasind=ceil(strlen($cadena)/$caracteresxlinea);
							$lineasimpresas+=$numlineasind;
							if(($lineasimpresas)>=$lineasxhoja){
								echo "</table>";
								//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";								
								echo "<h1 class='SaltoDePagina'></h1>";
								$pagina++;
								if (($pagina%2)==0){
									echo"<br/><br/><br/><br/>";
								}
								echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
								$nombre_estudiante."  $corte</span><br/><br/>";
								echo "<table class='area'><tr><td width='48%'></td>";
								for($i=1; $i<=$periodo+5; $i++){
									
									echo "<td ></td>";
								}
								echo "</tr>";
								echo "<tr>";
								echo "<td align='left' style='font-family: \"Courier New\", Courier, monospace;
								font-style: normal; fon-size:12px' colspan='$colspan2' rowspan=''>".(($rowind['competencia']))."</td>";
								if($rowindselect['nivel_aprendizaje']=='F'){
									echo "<td align='center' rowspan='' width='6%' ><img src='../../images/F.png' width='15' height='15' ></img></td><td rowspan='' width='78px'></td>";
								}else{
									echo "<td rowspan='' width='6%'></td><td align='center' rowspan='' width='78px'><img src='../../images/D.png' width='15' height='15'></img></td>";
								}
								echo "</tr>";
								$lineasimpresas=4;
							}else{
								echo "<tr>";
								echo "<td align='left' style='font-family: \"Courier New\", Courier, monospace;
								font-style: normal; fon-size:12px' colspan='$colspan2'>".(($rowind['competencia']))."</td>";
								if($rowindselect['nivel_aprendizaje']=='F'){
									echo "<td width='6%' align='center' ><img src='../../images/F.png' width='15' height='15' ></img></td><td></td>";
								}else{
									echo "<td></td><td width='6%' align='center'><img src='../../images/D.png' width='15' height='15'></img></td>";
								}
								echo "</tr>";
							}
							
						}
				
					}
						
					if(($lineasimpresas)>=($lineasxhoja)){
						echo "</table>";
						//echo "<span style='text-align:right; text-align:right; margin-left:810px; position:relative;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
					}else{
						echo "</table>";
					}
						
				}
				
				//Generar resultados COMPORTAMIENTO
				if(($lineasimpresas+4)>=($lineasxhoja)){
						echo "</table>";
						//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)!=0){
							echo"<br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
				}
            	echo "<br/><table class='area'>";
				
					$sql="SELECT DISTINCT a.idmateria, ar.idarea, ar.nomarea, a.nombre_materia, concat_ws(' ', d.nombre1, d.nombre2, d.apellido1, d.apellido2) AS nombre_docente, c.ih, n.idestudiante, n.vn, n.periodo, n.fj, n.fsj, n.observaciones, n.aniolectivo FROM clase c 
					JOIN materia a ON c.idmateria=a.idmateria AND c.idmateria=49 AND c.aniolectivo='$aniolect' AND c.idaula='$idaula' AND c.periodos LIKE '%$periodo%'
					JOIN notas n ON a.idmateria=n.idmateria AND n.periodo=$periodo AND n.tipo_nota='R' AND n.aniolectivo=c.aniolectivo AND n.idestudiante='".$records1['idestudiante']."'
					JOIN matricula m ON m.idestudiante=n.idestudiante AND n.tipo_nota=m.tipo_matricula AND n.aniolectivo=m.aniolectivo AND m.idaula=c.idaula
					JOIN area ar ON ar.idarea=a.idarea_fk
					JOIN docente d ON c.iddocente=d.iddocente  
					ORDER BY ar.nomarea, a.nombre_materia  DESC";
					$consulta2 = $conx->query($sql);
					$colspan2=1;
					$lineasimpresas+=1;
					while($records2 = $conx->records_array($consulta2)){
						$nota_asignatura=number_format(round($records2['vn'], $numero_decimales), $numero_decimales, '.',',');
						if($nota_asignatura >= (float)$rcbamin and $nota_asignatura <= (float)$rcbamax){
							$desempeno_asignatura="Db"; 
						}elseif($nota_asignatura >= (float)$rcbmin and $nota_asignatura <= (float)$rcbmax){
							$desempeno_asignatura="DB";
						}elseif($nota_asignatura >= (float)$rcamin and $nota_asignatura <= (float)$rcamax){
							$desempeno_asignatura="DA";
						}elseif($nota_asignatura >= (float)$rcsmin and $nota_asignatura <= (float)$rcsmax){
							$desempeno_asignatura="DS";
						}
						$dinamizador=($records2['nombre_docente']);
						echo "<br/><table class='area'>
						<tr >
						<th class='fonttitle7'   style='' colspan='' >COMPORTAMIENTO</th>
						</tr></table>";
						echo "<table class='area'>";
						echo "<tr class='asignatura'>
							<td width='*%' colspan='".($periodo+4)."' ><strong>DINAMIZADOR:</strong> ".strtoupper($dinamizador)."</td>
							<td width='6%' nowrap valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>".number_format(round((float)$nota_asignatura, $numero_decimales),$numero_decimales,".",",")."</strong></td>";
						if($grado==0){
							
							switch($desempeno_asignatura){
								case 'DS': 
											echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><img src='../../images/superiorkg.png' width='39' height='40'></td>";
											break;
								case 'DA': 
											echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><img src='../../images/altokg.png' width='39' height='40'></td>";
											break;
								case 'DB': 
											echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><img src='../../images/basicokg.png' width='39' height='40'></td>";
											break;
								default: 
											echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><img src='../../images/bajokg.png' width='39' height='40'></td>";
											break;
							}
							$lineasimpresas+=4;
						}else{
							echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>$desempeno_asignatura</strong></td>";
							$lineasimpresas+=2;
						}
							
						echo "</tr>";
						
						$lineasimpresas+=2;
						///seleccionando indicadores escogidos por el docenbte en esta area y curso
						
						if($aniolectivo<2016){
							$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
							pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
							FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
							(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
							and pc.estandarbc=ebc.codigo
							and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolect
							and eb.periodo =$periodo and eb.iddocente =$iddocente and eb.grado ='$grado'
							and ebc.idmateria_fk=m.idmateria and m.idarea_fk='20'
							ORDER BY consecutivo DESC";
						}else{
							//consultando competencias 
							$sqlind="SELECT DISTINCT i.idmateria, p.competencia, p.consecutivo, i.DS, i.DA, i.DB, i.DBA FROM plan_curricular p 
							JOIN indicadoresboletin i ON p.consecutivo=i.idindicador AND i.aniolectivo='$aniolect' AND i.periodo=$periodo AND i.idmateria='".$records2['idmateria']."'
							JOIN aula a ON i.grado=a.grado AND a.idaula='$idaula'";
							
						}
						$consultaind = $conx->query($sqlind);
						$numind=$conx->get_numRecords($consultaind);
						$colspan2=1;
						if(($lineasimpresas+7)>=($lineasxhoja)){
							echo "</table>";
							//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";														
							echo "<h1 class='SaltoDePagina'></h1>";
							$pagina++;
							if (($pagina%2)==0){
								echo"<br/><br/><br/><br/>";
							}
							echo "<table class='area'>";
							echo "<tr class='asignatura'>";
						
							echo "<tr><td style='border-top: 1px solid black;' colspan='".($periodo+4)."' ><strong>ACTITUDES $corte</strong></td>
								<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>FORTALEZA</strong></td>
								<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>DEBILIDAD</strong></td></tr>";
							echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
							$nombre_estudiante."  $corte</span><br/><br/>";
							$lineasimpresas=4;
						}else{
							echo "<tr><td style='border-top: 1px solid black;' colspan='".($periodo+4)."' ><strong>ACTITUDES $corte</strong></td>
								<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>FORTALEZA</strong></td>
								<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>DEBILIDAD</strong></td></tr>";
							
						}
						while ($rowind = $conx->records_array($consultaind)) {
							$sqldelinselect="SELECT * FROM indicadoresestudiante WHERE idindicador='".$rowind['consecutivo']."'
							and aniolectivo=$aniolect and periodo=$periodo and idestudiante='".$records1['idestudiante']."'";
							$consultaindselect = $conx->query($sqldelinselect);
							
							if($rowindselect = $conx->records_array($consultaindselect)){
								$cadena = $rowind['competencia'];
								$numlineasind=ceil(strlen($cadena)/$caracteresxlinea);
								$lineasimpresas+=$numlineasind;
								if(($lineasimpresas+4)>=($lineasxhoja)){
									echo "</table>";
									//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";								
									echo "<h1 class='SaltoDePagina'></h1>";
									$pagina++;
									if (($pagina%2)==0){
										echo"<br/><br/><br/><br/><br/>";
									}
									echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
									$nombre_estudiante."  $corte</span><br/><br/>";
									echo "<table class='area'>";
									echo "<tr>";
									echo "<td align='left' style='font-family: \"Courier New\", Courier, monospace;
									font-style: normal; fon-size:12px' colspan='".($periodo+4)."'>".(($rowind['competencia']))."</td>";
									if($rowindselect['nivel_aprendizaje']==='F'){
										echo "<td width='6%' align='center' ><img src='../../images/F.png' width='15' height='15' ></img></td><td></td>";
									}else{
										echo "<td></td><td width='6%' align='center'><img src='../../images/D.png' width='15' height='15'></img></td>";
									}
									echo "</tr>";
									$lineasimpresas=4;
								}else{
									echo "<td align='left' style='font-family: \"Courier New\", Courier, monospace;
									font-style: normal; fon-size:12px' colspan='".($periodo+4)."'>".(($rowind['competencia']))."</td>";
									if($rowindselect['nivel_aprendizaje']=='F'){
										echo "<td width='6%' align='center' ><img src='../../images/F.png' width='15' height='15' ></img></td><td width='6%'></td>";
									}else{
										echo "<td width='6%' ></td><td width='6%' align='center'><img src='../../images/D.png' width='15' height='15'></img></td>";
									}
									echo "</tr>";
								}
								
					
						}
							
					}
					if(($pagina%2)==0){
						$lineasimpresas+=7;
					}
					if(($lineasimpresas)>=($lineasxhoja)){
						echo "</table>";
						//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=3;
					}else{
						echo "</table>";
					}
						
				}
				
				//observaciones generales
				echo "
				<br/>
				<table class='alumno' border='0' cellspacing='5px' >
			   <tr >
			   <th colspan='2'>
				   <p class='Estilo5' align='center'>OBSERVACIONES GENERALES</p>
			   </th>
			   </tr>
			   <tr class='asignatura'>
				<td width='30%' align='left' class='Estilo6'>ASIGNATURA</td>
				<td  align='left' class='Estilo6' >OBSERVACIÓN</td>
			   </tr>";
				$lineasimpresas+=1;
				
									
				$sqlog = "SELECT DISTINCT a.nombre_materia, n.observaciones 
				FROM materia a, notas n WHERE n.idestudiante=".$records1['idestudiante']." AND a.idmateria=n.idmateria 
				AND periodo='$periodo' AND n.aniolectivo=$aniolect 
				AND n.tipo_nota='R' AND n.observaciones IS NOT NULL
				ORDER BY a.nombre_materia ASC";
				$consultaog = $conx->query($sqlog);
				while($recordsog = $conx->records_array($consultaog)){
					if($recordsog['observaciones']!=NULL){
						 $observaciones=$recordsog['observaciones'];
						 $existe = strrpos($observaciones, ".");
						 if($existe==false ){
								$observaciones.=".";
						 }
						 $numlineasobs=0;
						 $cadena = $recordsog['observaciones'];
						 $numlineasobs+=ceil(strlen($cadena)/$caracteresxlinea);
						 $lineasimpresas+=$numlineasobs;
						 if(($lineasimpresas)>=89){
							echo "</table>";
							//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";								
							echo "<h1 class='SaltoDePagina'></h1>";
							$pagina++;
							if (($pagina%2)==0){
								echo"<br/><br/><br/><br/><br/>";
							}
							echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
							$nombre_estudiante."  $corte</span><br/><br/>";
							echo "<table class='alumno' border='0' cellspacing='5px' >";
							echo "<tr>
							<td  width='30%' align='center' class='Estilo1'>".strtoupper(($recordsog['nombre_materia']))."</td>
						   <td align='left' valign='top' style='line-height:15px; text-align:justify; font-family: \"Courier New\", Courier, monospace;
									font-style: normal;'>
							<span class='' >".utf8_decode(
							String_oracion($observaciones))."</span>&nbsp;
							</td>
							</tr>";
							$lineasimpresas=4;
						}else{
							echo "<tr>
							<td  class='Estilo1'>".strtoupper(($recordsog['nombre_materia']))."</td>
						   <td align='left' valign='top' style='line-height:15px; text-align:justify; font-family: \"Courier New\", Courier, monospace;
									font-style: normal;'>
							<span class='' >".utf8_decode(
							String_oracion($observaciones))."</span>&nbsp;
							</td>
							</tr>";
						}
						
					}
				}
				echo "</table>";
				$lineasimpresas+1;
				if($lineasimpresas>=89){
						//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'> CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
				}
				//---------------------------CONVENCIONES
				echo "
				<br/><div class='firma'>
				<table class='convenciones'>
				<tr>
					<td width='150px' colspan='6' valign='center' style='text-align:center; background:#E5E5E5;'>CONVENCIONES</td>
				</tr>";
				$lineasimpresas++;
				if(($lineasimpresas)>=($lineasxhoja) or $lineasimpresas>=80){
						//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>$lineasimpresas CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
				}
				if($grado==0){
					echo "<tr>
					<td width='45' valign='top'><img src='../../images/superiorkg.png' width='25' height='25'></td>
					<td width='161' valign='center' class='Estilo7'>Desempeño Superior [".number_format((float)$rcsmin,1,'.',',')." a ".number_format((float)$rcsmax,1,'.',',')."]</td>
					<td width='45' valign='top'><img src='../../images/altokg.png' width='25' height='25'></td>
					<td width='161' valign='center' class='Estilo7'>Desempeño Alto [".number_format((float)$rcamin,1,'.',',')." a ".number_format((float)$rcamax,1,'.',',')."]</td>
					<td width='45' valign='center'>A.J</td>
					<td width='161' valign='center' class='Estilo7'>Ausencias con justificación</td>
					</tr>";
				}else{
					echo "<tr>
					<td width='45' valign='top'>DS</td>
					<td width='161' valign='center' class='Estilo7'>Desempeño Superior [".number_format((float)$rcsmin,1,'.',',')." a ".number_format((float)$rcsmax,1,'.',',')."]</td>
					<td width='45' valign='top'>DA</td>
					<td width='161' valign='center' class='Estilo7'>Desempeño Alto [".number_format((float)$rcamin,1,'.',',')." a ".number_format((float)$rcamax,1,'.',',')."]</td>
					<td width='45' valign='top'>A.J</td>
					<td width='161' valign='top' class='Estilo7'>Ausencias con justificación</td>
					</tr>";
				}
				
				$lineasimpresas++;
				if(($lineasimpresas)>=($lineasxhoja) or $lineasimpresas>=89){
						//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
				}
				if($grado==0){
					echo "<tr>
					<td width='45' valign='top'><img src='../../images/basicokg.png' width='25' height='25'></td>
					<td width='161' valign='center' class='Estilo7'>Desempeño Básico [".number_format((float)$rcbmin,1,'.',',')." a ".number_format((float)$rcbmax,1,'.',',')."]</td>
					<td width='45' valign='top'><img src='../../images/bajokg.png' width='25' height='25'></td>
					<td width='161' valign='center' class='Estilo7'>Desempeño Bajo [".number_format((float)$rcbamin,1,'.',',')." a ".number_format((float)$rcbamax,1,'.',',')."]</td>
					<td width='45' valign='center'>A.S.J</td>
					<td width='161' valign='center' class='Estilo7' >Ausencias sin justificación</td>
					
					</tr>";
				}else{
					echo "<tr>
					<td width='45' valign='top'>DB</td>
					<td width='161' valign='top' class='Estilo7'>Desempeño Básico [".number_format((float)$rcbmin,1,'.',',')." a ".number_format((float)$rcbmax,1,'.',',')."]</td>
					<td width='45' valign='top'>Db</td>
					<td width='161' valign='top' class='Estilo7'>Desempeño Bajo [".number_format((float)$rcbamin,1,'.',',')." a ".number_format((float)$rcbamax,1,'.',',')."]</td>
					<td width='45' valign='top'>A.S.J</td>
					<td width='161' valign='top' class='Estilo7' >Ausencias sin justificación</td>
					
					</tr>";
				}
				$lineasimpresas++;
				if(($lineasimpresas)>=($lineasxhoja) or $lineasimpresas>=89){
						//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
				}
				echo "<tr>
					<td width='45' valign='top'>1 T</td>
					<td width='161' valign='top' class='Estilo7' >Primer Trimestre</td>
					<td width='45' valign='top'>2 T</td>
					<td width='161' valign='top' class='Estilo7'>Segundo Trimestre</td>
					<td width='45' valign='top'>I.H</td>
					<td width='161' valign='top' class='Estilo7' >Intensidad Horaria</td>
				</tr>";
				$lineasimpresas++;
				if(($lineasimpresas)>=($lineasxhoja) or $lineasimpresas>=89){
						//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
				}
				echo "<tr>
					
					<td width='45' valign='top'>3 T</td>
					<td width='161' valign='top' class='Estilo7' >Tercer Trimestre</td>
					<td width='45' valign='top'>D</td>
					<td width='161' valign='top' class='Estilo7'>Definitiva</td>
					<td width='45' valign='top'></td>
					<td width='161' valign='top' class='Estilo7' ></td>
				</tr>
				</table></div>"; 
				
				if($periodo==4){
					echo 
					"<div style='line-height:7px;'>
					<br/><br/><br/><br/><br/><br/><br/>
							<tr>
								<td width='50%' align='center'>
									<span align='center' class='blocktext' style='text-decoration:overline; font-weight:bold' >Padre de Familia o Acudiente</span>
								</td>
								<td align='center'>
									<span class='blocktext' style='text-decoration:overline; font-weight:bold'>$dinamizador</span>
									<br/><span align='center' class='blocktext' >Director(a) de Grupo</span>
								</td>
							</tr>
					</table>
					</div>";
			   
			   }else{
					echo 
					"<div style='line-height:7px;'>
					<br/><br/><br/><br/><br/><br/><br/>
					<table class='firma' border='0'>
							<tr>
								<td width='50%' align='center'>
									<span class='blocktext' style='text-decoration:overline; font-weight:bold'>$dinamizador</span>
									<br/><span align='center' class='blocktext' >Dinamizador(a) de Curso</span>
				
								</td>
								<td align='center'>
									<br/><span align='center' class='blocktext' style='text-decoration:overline; font-weight:bold' >Padre de Familia o Acudiente</span>
								</td>
							</tr>
					</table>
					</div>";
			   }
				//echo "</div><br/><span style='text-align:right; margin-left:810px; position:relative;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
				$par=($pagina%2);
				if($numest>1){
					echo "<h1 class='SaltoDePagina'></h1>";
					
					if ( $par!=0 and $numest!=1 and $pagina>1){
						echo "<h1 class='SaltoDePagina'><span style='color:white'>CONTINUACIÓN INFORME ACADÉMICO DE ".
									$nombre_estudiante." $corte</span></h1>";
					}elseif($pagina==1){
						echo "<h1 class='SaltoDePagina'><span style='color:white'>CONTINUACIÓN INFORME ACADÉMICO DE ".
								$nombre_estudiante." $corte</span></h1>";
					}
				}
				$numest--;
				if ( $par!=0 and $numest==0 and $pagina>1){
					echo "<h1 class='SaltoDePagina'><span style='color:white'>CONTINUACIÓN INFORME ACADÉMICO DE ".
								strtoupper($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
								$records1['apellido2'])." $corte</span></h1>";
				}elseif($pagina==1 and $numest==0){
					echo "<h1 class='SaltoDePagina'><span style='color:white'>CONTINUACIÓN INFORME ACADÉMICO DE ".
								$nombre_estudiante." $corte</span></h1>";
				}

				
				
				

				
				//-------------------------------FIN LADO B------------------------------------------------  
			}
			$conx->result_free($consulta);
			$conx->result_free($consulta_area_asignatura);
			$conx->result_free($consultaest);
			$conx->result_free($consulta2);
			$conx->result_free($consultaaula);
			$conx->result_free($consultaind);
			
			
			
	}elseif($formato=="f3" and $periodo==4 ){
		
            if (isset($_POST['idestudiante'])) {
				$sqlest = "SELECT DISTINCT e.idestudiante, e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula 
							FROM estudiante e
							INNER JOIN matricula m ON e.idestudiante=m.idestudiante
							INNER JOIN notas n ON m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo AND m.tipo_matricula=n.tipo_nota
							WHERE m.aniolectivo=$aniolect AND m.idaula=$idaula AND m.tipo_matricula='R' AND m.periodo=0
							AND n.periodo=$periodo AND e.idestudiante='".$_POST['idestudiante']."'
							ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";
				
			}else{
				$sqlest = "SELECT DISTINCT 
							e.apellido1, e.apellido2, 
							e.nombre1, e.nombre2, m.idaula, e.idestudiante 
							FROM estudiante e
							LEFT JOIN matricula m
							ON e.idestudiante=m.idestudiante
							LEFT JOIN notas n ON m.idestudiante=n.idestudiante
							AND m.aniolectivo=n.aniolectivo
							AND n.tipo_nota=m.tipo_matricula
							WHERE m.aniolectivo=$aniolect
							AND m.idaula=$idaula
							AND m.tipo_matricula='R'
							AND m.periodo=0
							AND n.periodo=$periodo
							AND e.habilitado='S'
							ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";
			}
			 ?>
			<div id="ex1" style="">
			<div id="imgLOAD" style="text-align:center;" class="modal">
			<b>Gerenando Boletines...</b>
			<img src="../../images/loadingbar-blue.gif" /> Boletin <span id="boletingenerado"></span> DE <span id="totalboletines"></span>
			</div>
			</div>
			<?php
			$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
        	$consultaest = $conx->query($sqlest);
			$numest = $conx->get_numRecords($consultaest);
			$totalest = $conx->get_numRecords($consultaest);
			//
            while($records1 = $conx->records_array($consultaest)){
				$msjBoletin= ($totalest-$numest)+1;
				echo "<script>$('#boletingenerado').text($msjBoletin); $('#totalboletines').text($totalest);</script>";
				$contmat=0;
            	switch($periodo){
					case 1: $corte="1ER CORTE PRIMER SEMESTRE"; break;
					case 2: $corte="2DO CORTE PRIMER SEMESTRE"; 
							//$puestosem=puestoAnioAlg2($records1['idestudiante'], $idaula, $aniolect, 1, 2);
							//$promediosem=promedioAnioAlg2($records1['idestudiante'], $idaula, $aniolect, 1, 2);
							break;
							
					case 3: $corte="1ER CORTE SEGUNDO SEMESTRE"; break;
					case 4: $corte="2DO CORTE SEGUNDO SEMESTRE"; 
							//$puestosem=puestoAnioAlg2($records1['idestudiante'], $idaula, $aniolect, 3, 4);
							//$promediosem=promedioAnioAlg2($records1['idestudiante'], $idaula, $aniolect, 3, 4);
							break;
				}
				echo 
                "<div class='fondo'><div style='line-height:7px;'>
                <table class='normal'>
                        <tr>
                            <td width='100px' align='left' rowspan='' valign='top'>
                                <span  class='blocktext'><img  src='../../images/logocol.png' width='95' height='95'/></span>
                            </td>
                            <td style='font-family: Arial, Helvetica, sans-serif;font-size:12px; font-style:italic;'><strong>INSTITUCIÓN EDUCATIVA MISIONAL SANTA TERESITA<br/>
								 San Andrés de Tumaco D.E.<br/>
								 NIT: 840.000.320-1      REGISTRO DANE: 152835001568      ICFES: 118117</strong><br/>
								Institución Educativa de Educación Preescolar, Primaria, Básica y Media Vocacional<br/>
								Aprobado mediante Resoluciones: 1325 del 24 de Julio de 2001 Básica Primaria, 1972 del 5 de<br/>
								Octubre 2001 Básica Secundaria y 4075 del 27 de Diciembre de 2002 Media Vocacional<br/>
								<strong>“HOY MEJOR QUE AYER, SIEMPRE LO MEJOR”</strong><br/><br/>
                            </td>
                        </tr>
                        <tr>
							<td colspan='2'><strong>INFORME ACADÉMICO FINAL</strong>	
							</td>
                        </tr>
                        
                </table>
            	</div>";
				
				$puestoanio=puestoAnioSem($records1['idestudiante'], $idaula, $aniolect);
				$peromedioanio=promedioAnioSem($records1['idestudiante'], $idaula, $aniolect);
				$nombre_estudiante=strtoupper(
				($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".$records1['apellido2']));
				$materiasperdidas=0;
            	echo "<table class='alumno'>
            	<tr >
            	<td colspan='' class='fonttitle7'   style=''><strong>ESTUDIANTE</strong><BR/>".$nombre_estudiante."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>CODIGO</strong><BR/>".$records1['idestudiante']."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>CURSO</strong><BR/>".$grado2."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>AÑO LECTIVO</strong><BR/>".$aniolect."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>PUESTO</strong><BR/>".$puestoanio."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>PROMEDIO</strong><BR/>$peromedioanio</td>
            	</tr>
            	</table>";
				   
                //----------------------------------------------------
                //Generar resultados por Area/asignatura
				$sqlarea = "SELECT DISTINCT a.idarea, a.nomarea 
				FROM area a
				LEFT JOIN materia m ON a.idarea=m.idarea_fk
				LEFT JOIN clase c ON m.idmateria=c.idmateria
				LEFT JOIN notas n ON c.idmateria=n.idmateria
				AND c.aniolectivo=n.aniolectivo
				WHERE c.idmateria!=49
				AND c.aniolectivo=$aniolectivo
				AND c.idaula=$idaula
				AND n.tipo_nota='R'
				AND n.periodo=$periodo
				AND n.idestudiante='".$records1['idestudiante']."'
				ORDER BY a.nomarea ASC";
				$sqlasig = "SELECT DISTINCT m.nombre_materia
				FROM materia m
				LEFT JOIN clase c ON m.idmateria=c.idmateria
				LEFT JOIN notas n ON c.idmateria=n.idmateria
				AND c.aniolectivo=n.aniolectivo
				WHERE c.aniolectivo=$aniolect
				AND c.idaula=$idaula
				AND n.tipo_nota='R'
				AND n.periodo=$periodo
				AND n.idestudiante='".$records1['idestudiante']."'ORDER BY m.nombre_materia ASC";
				$sqldelindest="SELECT DISTINCT p.competencia FROM plan_curricular p
				LEFT JOIN indicadoresestudiante ie ON ie.idindicador=p.consecutivo
				LEFT JOIN notas n ON ie.idestudiante=n.idestudiante
				AND ie.aniolectivo=n.aniolectivo
				AND ie.periodo=n.periodo
				AND ie.idmateria=n.idmateria
				LEFT JOIN indicadoresboletin ib ON ie.idindicador=ib.idindicador
				AND ie.aniolectivo=ib.aniolectivo
				AND ie.periodo=ib.periodo
				LEFT JOIN aula a ON a.grado=ib.grado
				WHERE n.periodo=$periodo
				AND n.aniolectivo=$aniolect
				AND n.tipo_nota='R'
				AND n.idestudiante='".$records1['idestudiante']."'
				AND a.idaula=$idaula";
				$sqldelindestobs="SELECT DISTINCT n.observaciones
				FROM notas n
				LEFT JOIN materia m ON n.idmateria=m.idmateria
				WHERE n.aniolectivo=$aniolect
				AND n.tipo_nota='R'
				AND n.periodo=$periodo
				AND n.idestudiante='".$records1['idestudiante']."'
				AND n.observaciones!=null";
				$consultaindestobs = $conx->query($sqldelindestobs);
				$consultaindest = $conx->query($sqldelindest);
				$caracteresxlinea = 98;
				if($papel=='letter'){
					$lineasxhoja=60;
				}elseif($papel=='legal'){
					$lineasxhoja=77;
				}else{
					$lineasxhoja=60;
				}
				$numlineasind=0;
				while($recordsindest = $conx->records_array($consultaindest)){
					$cadena = $recordsindest['competencia'];
					$numlineasind+=ceil(strlen($cadena)/$caracteresxlinea);
				}
				
				$numlineasobs=2;
				while($recordsindestobs = $conx->records_array($consultaindestobs)){
					if($recordsindestobs['observaciones']!=NULL){
						$cadena = $recordsindestobs['observaciones'];
						$numlineasobs+=ceil(strlen($cadena)/$caracteresxlinea);
					}
				}
				$consultaasig = $conx->query($sqlasig);
            	$consultaarea = $conx->query($sqlarea);	
				$numareas = $conx->get_numRecords($consultaarea);
				$numasig = $conx->get_numRecords($consultaasig);
				$lineascabezera=14;
				$lineaspie=18;
				$totallineas=($numareas*2)+($numasig*3)+$lineascabezera+$lineaspie+$numlineasind+$numlineasobs;
				$pagina=1;
				$totalpages=$totallineas/$lineasxhoja;
				if($totalpages<=1.25){$numapaginas=1;}else{$numapaginas=ceil($totallineas/($lineasxhoja));}
				if($numapaginas>1){
					$lineasextras=$numapaginas*4;
					$totallineas+=$lineasextras;
					$numapaginas=ceil($totallineas/($lineasxhoja));
				}
				$numapaginas=round($totalpages,0,PHP_ROUND_HALF_UP);
				$lineasimpresas=$lineascabezera;
				if($periodo<3){$spansem=2;}else{$spansem=4;}
				$colspan=7+$spansem;
            	while($recordsarea = $conx->records_array($consultaarea)){
					
					//$colspanArea=$colspan+$colspanNV;
					
					$lineasimpresas++;
					$sql = "SELECT DISTINCT mt.nombre_materia, n.* 
					FROM materia mt
					INNER JOIN notas n ON mt.idmateria=n.idmateria  WHERE n.idestudiante='".$records1['idestudiante']."' 
					AND mt.idarea_fk=".$recordsarea['idarea']." AND n.periodo=$periodo  AND n.aniolectivo=$aniolect 
					AND n.tipo_nota='R' ORDER BY mt.nombre_materia ASC";
					$consulta2 = $conx->query($sql);
					
					while($records2 = $conx->records_array($consulta2)){
						$idmateria=$records2['idmateria'];
						$colspanNV=0;
						for($i=3; $i<=$periodo+3; $i++){
							$sqlrecordNV = "SELECT DISTINCT mt.nombre_materia, n.* 
								FROM materia mt
								INNER JOIN notas n ON mt.idmateria=n.idmateria  WHERE n.idestudiante='".$records1['idestudiante']."' 
								AND n.idmateria=".$records2['idmateria']." AND n.periodo=$i  AND n.aniolectivo=$aniolect 
								AND n.tipo_nota='N'";
							$consultarecordNV = $conx->query($sqlrecordNV);
							if($recordsperiodoNV = $conx->records_array($consultarecordNV)){
								$colspanNV++;
							}
						}
						$colspanArea=$colspan+$colspanNV;
						echo "<br/><table class='area'>
						<tr >
						<th class='fonttitle7'   style='' colspan='$colspanArea' >".
							strtoupper(($recordsarea['nomarea']))."
						</th>
						</tr>";
						//docente que tiene la materia 
						$sqld = "SELECT DISTINCT c.ih, c.porc_valorativo, d. * 
						FROM clase c, docente d
						WHERE c.idmateria=  '".$records2['idmateria']."'
						AND c.idaula = $idaula
						AND c.aniolectivo =  $aniolect
						AND c.periodos LIKE '%$periodo%'
						AND c.iddocente = d.iddocente";
						$consultad = $conx->query($sqld);
						$recordsd = $conx->records_array($consultad);
						$docente = $recordsd['nombre1']." ".$recordsd['nombre2']." ".$recordsd['apellido1']." ".$recordsd['apellido2'];
						$ih = $recordsd['ih'];
						$iddocente = $recordsd['iddocente'];
						$sqlasistencia = "SELECT SUM(fj) AS faltasj , SUM(fsj) AS faltasfsj 
						FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
						AND mt.idmateria=n.idmateria AND mt.idmateria=".$records2['idmateria']." AND (n.periodo>=1 AND n.periodo<=$periodo) AND n.aniolectivo=$aniolect 
						AND n.tipo_nota='R' ORDER BY mt.nombre_materia ASC";
						$consultaasistencia = $conx->query($sqlasistencia);
						$recordsasistencia = $conx->records_array($consultaasistencia);
						$fj=$recordsasistencia['faltasj'];
						$fsj=$recordsasistencia['faltasfsj'];
						$vn=$records2['vn'];
						echo "<tr class='asignatura'>
						<td width='*%' ><strong>ASIGNATURA:</strong> ".strtoupper(($records2['nombre_materia']))."
						<br/><strong>DOCENTE:</strong> ".strtoupper(($docente))."</td>
						<td width='3%' style='text-align:center; '><strong>I.H</strong><br/> $ih</td>";
						
						$promedioAcomulado=0;
						if($periodo<5){
							for($i=1; $i<=$periodo; $i++){
								if($i>2){
									$sqlrecord = "SELECT DISTINCT mt.nombre_materia, n.* 
									FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
									AND mt.idmateria=n.idmateria AND n.idmateria='".$records2['idmateria']."' AND n.periodo=$i  AND n.aniolectivo=$aniolect 
									AND n.tipo_nota='R'";
									$consultarecord = $conx->query($sqlrecord);
									if($recordsperiodo = $conx->records_array($consultarecord)){
										//$promedioAcomulado+=number_format((float)$recordsperiodo['vn'],1,".",",");
										switch($i){
											case 3:	$corte2='1 C'; break;
											case 4:	$corte2='2 C'; break;
										}
										echo "<td width='3%' valign='center' style='text-align:center;'><strong>$corte2</strong><br/>".number_format((float)$recordsperiodo['vn'],1,".",",")."</td>";
									}else{
										echo "<td width='3%'></td>";
									}
									$sqlrecordNV = "SELECT DISTINCT mt.nombre_materia, n.* 
									FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
									AND mt.idmateria=n.idmateria AND n.idmateria='".$records2['idmateria']."' AND n.periodo=$i  AND n.aniolectivo=$aniolect 
									AND n.tipo_nota='N'";
									$consultarecordNV = $conx->query($sqlrecordNV);
									if($recordsperiodoNV = $conx->records_array($consultarecordNV)){
										//$promedioAcomulado+=number_format((float)$recordsperiodo['vn'],1,".",",");
										switch($i){
											case 1:
											case 3:
											case 2:
											case 4:	$corte2='NV'; break;
										}
										echo "<td width='3%' valign='center' style='text-align:center;'><strong>$corte2</strong><br/>".number_format((float)$recordsperiodoNV['vn'],1,".",",")."</td>";
									}
								}
								
								if($i==2){
									//$promedioFinal=number_format((float)$promedioAcomulado/$periodo,1,".",",");
									$promedioFinal=promedioAnioAlg2MateriaNV($records1['idestudiante'], $idaula, $aniolect, 1, 2,$records2['idmateria']);
									
									echo "<td width='6%' nowrap valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>1 SEM</strong><br>".number_format((float)$promedioFinal,1,".",",")."</td>";
									$sqlrecordNVSEM = "SELECT DISTINCT mt.nombre_materia, n.* 
									FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
									AND mt.idmateria=n.idmateria AND n.idmateria='".$records2['idmateria']."' AND n.periodo=5  AND n.aniolectivo=$aniolect 
									AND n.tipo_nota='N'";
									$consultarecordNVSEM = $conx->query($sqlrecordNVSEM);
									$nvSEM1=0;
									if($recordsperiodoNVSEM = $conx->records_array($consultarecordNVSEM)){
										$nvSEM1=number_format((float)$recordsperiodoNVSEM['vn'],1,".",",");
										echo "<td width='6%' nowrap valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>NV 1SEM</strong><br/>".$nvSEM1."</td>";
									}
								}
								if($i==4){
									//$promedioFinal=number_format((float)$promedioAcomulado/$periodo,1,".",",");
									$promedioFinal=promedioAnioAlg2MateriaNV($records1['idestudiante'], $idaula, $aniolect, 3, 4,$records2['idmateria']);									
									echo "<td width='6%' nowrap valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>2 SEM</strong><br>".number_format((float)$promedioFinal,1,".",",")."</td>";
									$sqlrecordNVSEM = "SELECT DISTINCT mt.nombre_materia, n.* 
									FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
									AND mt.idmateria=n.idmateria AND n.idmateria='".$records2['idmateria']."' AND n.periodo=6  AND n.aniolectivo=$aniolect 
									AND n.tipo_nota='N'";
									$consultarecordNVSEM = $conx->query($sqlrecordNVSEM);
									$nvSEM2=0;
									if($recordsperiodoNVSEM = $conx->records_array($consultarecordNVSEM)){
										$nvSEM2=number_format((float)$recordsperiodoNVSEM['vn'],1,".",",");
										echo "<td width='6%' nowrap valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>NV 1SEM</strong><br/>".$nvSEM2."</td>";
									}
									echo "<td width='3%' style='text-align:center; '><strong>A.J</strong><br/> $fj</td>
									<td width='3%' style='text-align:center; '><strong>A.S.J</strong><br/> $fsj</td>";
									//FINAL
									$promedioFinal1=promedioAnioAlg2MateriaNV($records1['idestudiante'], $idaula, $aniolect, 1, 2,$records2['idmateria']);
									$promedioFinal2=promedioAnioAlg2MateriaNV($records1['idestudiante'], $idaula, $aniolect, 3, 4,$records2['idmateria']);
									if($nvSEM1>$promedioFinal1){
										$promedioFinal1=$nvSEM1;
									}
									if($nvSEM2>$promedioFinal2){
										$promedioFinal2=$nvSEM2;
									}
									$aprobacion="";
									$promedioFinal = round(($promedioFinal1+$promedioFinal2)/2,1, PHP_ROUND_HALF_UP);
									echo "<td width='6%' nowrap valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>NOTA FINAL</strong><br>".number_format((float)$promedioFinal,1,".",",")."</td>";
									$sqlrecordNVFINAL = "SELECT DISTINCT mt.nombre_materia, n.* 
									FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
									AND mt.idmateria=n.idmateria AND n.idmateria='".$records2['idmateria']."' AND n.periodo=7  AND n.aniolectivo=$aniolect 
									AND n.tipo_nota='N'";
									$consultarecordNFINAL = $conx->query($sqlrecordNVFINAL);
									$nvFINAL=0;
									if($recordsperiodoNVFINAL = $conx->records_array($consultarecordNFINAL)){
										$nvFINAL=number_format((float)$recordsperiodoNVFINAL['vn'],1,".",",");
										echo "<td width='6%' nowrap valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>NV FINAL</strong><br/>".$nvFINAL."</td>";
									}
									if($promedioFinal<$nvFINAL){
										$promedioFinal=$nvFINAL;
									}
									if($promedioFinal >= (float)$rcbamin and $promedioFinal <= (float)$rcbamax){
										$desempenoFinal="Db"; 
										$aprobacion="NO APROBADA";
										$materiasperdidas++;
									}elseif($promedioFinal >= (float)$rcbmin and $promedioFinal <= (float)$rcbmax){
										$desempenoFinal="DB";
										$aprobacion="APROBADA";
									}elseif($promedioFinal >= (float)$rcamin and $promedioFinal <= (float)$rcamax){
										$desempenoFinal="DA";
										$aprobacion="APROBADA";
									}elseif($promedioFinal >= (float)$rcsmin and $promedioFinal <= (float)$rcsmax){
										$desempenoFinal="DS";
										$aprobacion="APROBADA";
									}
									echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>DES.FINAL</strong><br>".$desempenoFinal."</td>";
									echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>".$aprobacion."</strong></td>";
								}
							}
							
						}
						echo "</tr>";
						$lineasimpresas+=2;
						///seleccionando indicadores escogidos por el docenbte en esta area y curso
						if($aniolectivo<2016){
							$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
							pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
							FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
							(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
							and pc.estandarbc=ebc.codigo
							and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
							and eb.periodo =$periodo and eb.iddocente =$iddocente and eb.grado ='$grado'
							and ebc.idmateria_fk=m.idmateria and m.idarea_fk='".$recordsarea['idarea']."' and eb.idmateria=$idmateria
							ORDER BY consecutivo DESC";
						}else{
							$sqlind= "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
							pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
							FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
							(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
							and pc.estandarbc=ebc.codigo
							and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
							and eb.periodo =$periodo and eb.grado ='$grado'
							and ebc.idmateria_fk=m.idmateria and m.idarea_fk='".$recordsarea['idarea']."' and eb.idmateria=$idmateria
							ORDER BY consecutivo DESC";
						}
						$consultaind = $conx->query($sqlind);
						$numind=$conx->get_numRecords($consulta);
						$colspan2=$colspan-2+$colspanNV;
						if(($lineasimpresas+7)>=$lineasxhoja){
							echo "</table>";
							echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";														
							echo "<h1 class='SaltoDePagina'></h1>";
							$pagina++;
							if (($pagina%2)==0){
								echo"<br/><br/><br/><br/><br/>";
							}
							$lineasimpresas=4;
							echo "<table class='area'><tr>";
							for($i=1; $i<=$periodo+6; $i++){
								echo "<td></td>";
							}
							echo "</tr>";
							echo "
							<tr><td style='border-top: 1px solid black;' colspan='$colspan2' ><strong>COMPETENCIAS $corte</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>FORTALEZA</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>DEBILIDAD</strong></td></tr>";
							echo "<span class='Estilo7c'> CONTINUACIÓN INFORME ACADÉMICO DE ".
							$nombre_estudiante."  $corte</span><br/><br/>";
						}else{
							echo "<tr><td style='border-top: 1px solid black;' colspan='$colspan2' ><strong>COMPETENCIAS $corte</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>FORTALEZA</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>DEBILIDAD</strong></td></tr>";
						}
						$lineasimpresas+=1;
						while ($rowind = $conx->records_array($consultaind)) {
							$sqldelinselect="SELECT * FROM indicadoresestudiante WHERE idindicador='".$rowind['consecutivo']."'
							and aniolectivo=$aniolect and periodo=$periodo and idestudiante='".$records1['idestudiante']."'";
							$consultaindselect = $conx->query($sqldelinselect);
							
							if($rowindselect = $conx->records_array($consultaindselect)){
								$cadena = $rowind['competencia'];
								$numlineasind=ceil(strlen($cadena)/$caracteresxlinea);
								$lineasimpresas+=$numlineasind;
								if(($lineasimpresas+4)>=$lineasxhoja){
									echo "</table>";
									//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";								
									echo "<h1 class='SaltoDePagina'></h1>";
									$pagina++;
									if (($pagina%2)==0){
										echo"<br/><br/><br/><br/><br/>";
									}
									echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
									($nombre_estudiante)."  $corte</span><br/><br/>";
									echo "<table class='area'><tr><td width='48%'></td>";
									for($i=1; $i<=$periodo+5; $i++){
										
										echo "<td ></td>";
									}
									echo "</tr>";
									echo "<tr>";
									echo "<td align='left' style='font-family: \"Courier New\", Courier, monospace;
									font-style: normal; fon-size:12px' colspan='$colspan2' rowspan=''>".($rowind['competencia'])."</td>";
									if($rowindselect['nivel_aprendizaje']=='F'){
										echo "<td align='center' rowspan='' width='6%' ><img src='../../images/F.png' width='15' height='15' ></img></td><td rowspan='' width='78px'></td>";
									}else{
										echo "<td rowspan='' width='6%'></td><td align='center' rowspan='' width='78px'><img src='../../images/D.png' width='15' height='15'></img></td>";
									}
									echo "</tr>";
									$lineasimpresas=4;
								}else{
									echo "<tr>";
									echo "<td align='left' style='font-family: \"Courier New\", Courier, monospace;
									font-style: normal; fon-size:12px' colspan='$colspan2'>".($rowind['competencia'])."</td>";
									if($rowindselect['nivel_aprendizaje']=='F'){
										echo "<td width='6%' align='center' ><img src='../../images/F.png' width='15' height='15' ></img></td><td></td>";
									}else{
										echo "<td></td><td width='6%' align='center'><img src='../../images/D.png' width='15' height='15'></img></td>";
									}
									echo "</tr>";
								}
								
							}
					
						}
							
					}
					if(($lineasimpresas+4)>=($lineasxhoja)){
						echo "</table>";
						//echo "<span style='text-align:right; text-align:right; margin-left:810px; position:relative;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
					}else{
						echo "</table>";
					}
						
				}
				
				//Generar resultados COMPORTAMIENTO
				if(($lineasimpresas+4)>=($lineasxhoja)){
						echo "</table>";
						echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)!=0){
							echo"<br/><br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
				}
            	echo "<br/><table class='area'>";
					$sql = "SELECT DISTINCT mt.nombre_materia, n.* 
					FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
					AND mt.idmateria=n.idmateria AND mt.idmateria=49 AND n.periodo=$periodo  AND n.aniolectivo=$aniolect 
					AND n.tipo_nota='R' ORDER BY mt.nombre_materia ASC";
					$consulta2 = $conx->query($sql);
					$colspan2=1;
					$lineasimpresas+=2;
					while($records2 = $conx->records_array($consulta2)){
						//docente que tiene la materia 
						$sqld = "SELECT DISTINCT c.ih, c.porc_valorativo, d. * 
						FROM clase c, docente d
						WHERE c.idmateria=49
						AND c.idaula = $idaula
						AND c.aniolectivo =  $aniolect
						AND c.iddocente = d.iddocente";
						$consultad = $conx->query($sqld);
						$recordsd = $conx->records_array($consultad);
						$docente = $recordsd['nombre1']." ".$recordsd['nombre2']." ".$recordsd['apellido1']." ".$recordsd['apellido2'];
						$iddocente = $recordsd['iddocente'];
						echo "<tr><th colspan='3'>".$records2['nombre_materia']."</th></tr>";
						echo "<tr class='asignatura'>
						<td width='400px' colspan='3'><strong>DINAMIZADOR(A):</strong> ".strtoupper(($docente))."</td>";
						echo "</tr>";
						$lineasimpresas+=2;
						///seleccionando indicadores escogidos por el docenbte en esta area y curso
						if($aniolectivo<2016){
							$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
							pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
							FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
							(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
							and pc.estandarbc=ebc.codigo
							and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolect
							and eb.periodo =$periodo and eb.iddocente =$iddocente and eb.grado ='$grado'
							and ebc.idmateria_fk=m.idmateria and m.idarea_fk='20'
							ORDER BY consecutivo DESC";
						}else{
							$sqlind= "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
							pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
							FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
							(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
							and pc.estandarbc=ebc.codigo
							and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
							and eb.periodo =$periodo and eb.grado ='$grado'
							and ebc.idmateria_fk=m.idmateria and m.idarea_fk='20' and eb.idmateria=49
							ORDER BY consecutivo DESC";
							
						}
						$consultaind = $conx->query($sqlind);
						$numind=$conx->get_numRecords($consulta);
						$colspan2=1;
						if(($lineasimpresas+7)>=($lineasxhoja)){
							echo "</table>";
							//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";														
							echo "<h1 class='SaltoDePagina'></h1>";
							$pagina++;
							if (($pagina%2)==0){
								echo"<br/><br/><br/><br/><br/>";
							}
							echo "<table class='area'><tr>";
							for($i=1; $i<=3; $i++){
								echo "<td width='6%'></td>";
							}
							echo "</tr>";
							echo "
							<tr><td style='border-top: 1px solid black;' colspan='$colspan2' ><strong>ACTITUDES $corte</strong></td>
							<td width='6%' valign='center' style='text-align:center; border-top: 1px solid black;'><strong>FORTALEZA</strong></td>
							<td width='6%' valign='center' style='text-align:center; border-top: 1px solid black;'><strong>DEBILIDAD</strong></td></tr>";
							echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
							$nombre_estudiante."  $corte</span><br/><br/>";
							$lineasimpresas=4;
						}else{
							echo "<tr><td style='border-top: 1px solid black;' colspan='$colspan2' ><strong>ACTITUDES $corte</strong></td>
							<td width='6%' valign='center' style='text-align:center; border-top: 1px solid black;'><strong>FORTALEZA</strong></td>
							<td width='6%' valign='center' style='text-align:center; border-top: 1px solid black;'><strong>DEBILIDAD</strong></td></tr>";
						}
						while ($rowind = $conx->records_array($consultaind)) {
							$sqldelinselect="SELECT * FROM indicadoresestudiante WHERE idindicador='".$rowind['consecutivo']."'
							and aniolectivo=$aniolect and periodo=$periodo and idestudiante='".$records1['idestudiante']."'";
							$consultaindselect = $conx->query($sqldelinselect);
							
							if($rowindselect = $conx->records_array($consultaindselect)){
								$cadena = $rowind['competencia'];
								$numlineasind=ceil(strlen($cadena)/$caracteresxlinea);
								$lineasimpresas+=$numlineasind;
								if(($lineasimpresas+4)>=($lineasxhoja)){
									echo "</table>";
									//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";								
									echo "<h1 class='SaltoDePagina'></h1>";
									$pagina++;
									if (($pagina%2)==0){
										echo"<br/><br/><br/><br/><br/>";
									}
									echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
									$nombre_estudiante."  $corte</span><br/><br/>";
									echo "<table class='area'><tr><td width='400px'></td>";
									for($i=1; $i<=2; $i++){
										
										echo "<td width='6%' ></td>";
									}
									echo "</tr>";
									echo "<tr>";
									echo "<td align='left' style='font-family: \"Courier New\", Courier, monospace;
									font-style: normal; fon-size:12px' colspan='$colspan2' rowspan=''>".($rowind['competencia'])."</td>";
									if($rowindselect['nivel_aprendizaje']=='F'){
										echo "<td width='6%' align='center' rowspan='' width='78px' ><img src='../../images/F.png' width='15' height='15' ></img></td><td rowspan='' width='78px'></td>";
									}else{
										echo "<td width='6%' rowspan='' width='78px'></td><td align='center' rowspan='' width='78px'><img src='../../images/D.png' width='15' height='15'></img></td>";
									}
									echo "</tr>";
									$lineasimpresas=4;
								}else{
									echo "<tr>";
									echo "<td align='left' style='font-family: \"Courier New\", Courier, monospace;
									font-style: normal;' colspan='$colspan2'>".($rowind['competencia'])."</td>";
									if($rowindselect['nivel_aprendizaje']=='F'){
										echo "<td width='6%' align='center' ><img src='../../images/F.png' width='15' height='15' ></img></td><td width='6%'></td>";
									}else{
										echo "<td width='6%' ></td><td width='6%' align='center'><img src='../../images/D.png' width='15' height='15'></img></td>";
									}
									echo "</tr>";
								}
								
					
						}
							
					}
					if(($lineasimpresas+4)>=($lineasxhoja)){
						echo "</table>";
						echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=3;
					}else{
						echo "</table>";
					}
						
				}
				
				//observaciones generales
				if(($lineasimpresas+4)>=$lineasxhoja){
					//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";								
					echo "<h1 class='SaltoDePagina'></h1>";
					$pagina++;
					if (($pagina%2)==0){
						echo"<br/><br/><br/><br/><br/>";
					}
					echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
					$nombre_estudiante."  $corte</span><br/><br/>";
					$lineasimpresas=4;
				}
				echo "
				<br/><table class='alumno' border='0' cellspacing='5px' >
			   <tr >
			   <th colspan='2'>
				   <p class='Estilo5' align='center'>OBSERVACIONES GENERALES</p>
			   </th>
			   </tr>
			   <tr class='asignatura'>
				<td width='30%' align='left' class='Estilo6'>ASIGNATURA</td>
				<td  align='left' class='Estilo6' >OBSERVACIÓN</td>
			   </tr>";
				$lineasimpresas+=2;
									
				$sqlog = "SELECT DISTINCT a.nombre_materia, n.* 
				FROM materia a, notas n WHERE n.idestudiante=".$records1['idestudiante']." AND a.idmateria=n.idmateria 
				AND periodo='$periodo' AND n.aniolectivo=$aniolect 
				AND n.tipo_nota='R'
				ORDER BY a.nombre_materia ASC";
				$consultaog = $conx->query($sqlog);
				while($recordsog = $conx->records_array($consultaog)){
					if($recordsog['observaciones']!=NULL){
						 $observaciones=$recordsog['observaciones'];
						 $existe = strrpos($observaciones, ".");
						 if($existe==false ){
								$observaciones.=".";
						 }
						 $numlineasobs=0;
						 $cadena = $recordsog['observaciones'];
						 $numlineasobs+=ceil(strlen($cadena)/$caracteresxlinea);
						 $lineasimpresas+=$numlineasobs;
						 if(($lineasimpresas)>=($lineasxhoja)){
							echo "</table>";
							//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";								
							echo "<h1 class='SaltoDePagina'></h1>";
							$pagina++;
							if (($pagina%2)==0){
								echo"<br/><br/><br/><br/><br/>";
							}
							echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
							$nombre_estudiante."  $corte</span><br/><br/>";
							echo "<table class='alumno' border='0' cellspacing='5px' >";
							echo "<tr>
							<td  width='30%' align='center' class='Estilo1'>".strtoupper(($recordsog['nombre_materia']))."</td>
						   <td align='left' valign='top' style='line-height:15px; text-align:justify; font-family: \"Courier New\", Courier, monospace;
									font-style: normal;'>
							<span class='' >".utf8_decode(String_oracion($observaciones))."</span>&nbsp;
							</td>
							</tr>";
							$lineasimpresas=4;
						}else{
							echo "<tr>
							<td  class='Estilo1'>".strtoupper(($recordsog['nombre_materia']))."</td>
						   <td align='left' valign='top' style='line-height:15px; text-align:justify; font-family: \"Courier New\", Courier, monospace;
									font-style: normal;'>
							<span class='' >".utf8_decode(String_oracion($observaciones))."</span>&nbsp;
							</td>
							</tr>";
						}
						
					}
				}
				echo "</table>";
				$lineasimpresas+1;
				if(($lineasimpresas+4)>=($lineasxhoja)){
						//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
				}
				if($materiasperdidas>0 and $materiasperdidas <3){
						$estadoP= "<span style='color:red;'>"."PROMOCION PENDIENTE,"."</span> Tiene $materiasperdidas área(s) reprobada(s)";
				}elseif($materiasperdidas>2){
						  $estadoP= "<span style='color:red;'>"."DEBE REPETIR EL GRADO, "."</span> Tiene $materiasperdidas área(s) reprobada(s).";
				}elseif($materiasperdidas==0){
						$estadoP= "FUE PROMOVIDO(A)";
						switch($grado){
						 case 0: $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO PRIMERO"; break;
						 case 1: $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO SEGUNDO"; break;
						 case 2: $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO TERCERO"; break;
						 case 3: $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO CUARTO"; break;
						 case 4: $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO QUINTO"; break;
						 case 5: $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO SEXTO"; break;
						 case 6: $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO SEPTIMO"; break;
						 case 7: $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO OCTAVO"; break;
						 case 8: $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO NOVENO"; break;
						 case 9: $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO DECIMO"; break;
						 case 10: $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO ONCE"; break;
						 case 11: $estadoP="<span style='color:blue;'>GRADUADO(A)"; break;
						 default: $estadoP=""; break;
												
						}
						if($grado!=11){ $estadoP.=" SEGÚN LO ESTABLECIDO EN EL S.I.E DE LA INSTITUCIÓN";}
				}

echo "<br/><table class='resultadoasig'>";
if($periodo==4){
	echo "<tr><td style='text-align:left; font:12px 	arial,sans-serif;'>
	<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >$estadoP</span></td></tr>";
}
echo "</table>";
$lineasimpresas+=2;
if(($lineasimpresas+4)>=($lineasxhoja)){
		//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
		echo "<h1 class='SaltoDePagina'></h1>";
		$pagina++;
		if (($pagina%2)==0){
			echo"<br/><br/><br/><br/><br/>";
		}
		echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
		strtoupper($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
		$records1['apellido2'])."  $corte</span><br/><br/>";
		$lineasimpresas=4;
}
//---------------------------CONVENCIONES
				echo "
				<br/><div class='firma'>
				<table class='convenciones'>
				<tr>
					<td width='150px' colspan='6' valign='center' style='text-align:center; background:#E5E5E5;'>CONVENCIONES</td>
				</tr>
				<tr>
					<td width='45' valign='top'>DS</td>
					<td width='161' valign='top' class='Estilo7'>Desempeño Superior [".number_format((float)$rcsmin,1,'.',',')." a ".number_format((float)$rcsmax,1,'.',',')."]</td>
					<td width='45' valign='top'>DA</td>
					<td width='161' valign='top' class='Estilo7'>Desempeño Alto [".number_format((float)$rcamin,1,'.',',')." a ".number_format((float)$rcamax,1,'.',',')."]</td>
					<td width='45' valign='top'>A.J</td>
					<td width='161' valign='top' class='Estilo7'>Ausencias con justificación</td>
				</tr>
				<tr>
					<td width='45' valign='top'>DB</td>
					<td width='161' valign='top' class='Estilo7'>Desempeño Básico [".number_format((float)$rcbmin,1,'.',',')." a ".number_format((float)$rcbmax,1,'.',',')."]</td>
					<td width='45' valign='top'>Db</td>
					<td width='161' valign='top' class='Estilo7'>Desempeño Bajo [".number_format((float)$rcbamin,1,'.',',')." a ".number_format((float)$rcbamax,1,'.',',')."]</td>
					<td width='45' valign='top'>A.S.J</td>
					<td width='161' valign='top' class='Estilo7' >Ausencias sin justificación</td>
					
				</tr>
				<tr>
					<td width='45' valign='top'>1 C</td>
					<td width='161' valign='top' class='Estilo7' >Primer Corte</td>
					<td width='45' valign='top'>2 C</td>
					<td width='161' valign='top' class='Estilo7'>Segundo Corte</td>
					<td width='45' valign='top'>I.H</td>
					<td width='161' valign='top' class='Estilo7' >Intensidad Horaria</td>
				</tr>
				<tr>
					
					<td width='45' valign='top'>1 SEM</td>
					<td width='161' valign='top' class='Estilo7' >Promedio 1er Semestre</td>
					<td width='45' valign='top'>2 SEM</td>
					<td width='161' valign='top' class='Estilo7'>Promedio 2do Semestre</td>
					<td width='45' valign='top'>D</td>
					<td width='161' valign='top' class='Estilo7' >Definitiva</td>
				</tr>
				</table></div>"; 
				$sqldg = "SELECT DISTINCT d.* 
				FROM clase c, docente d
				WHERE c.idaula = $idaula
				AND c.aniolectivo =  $aniolect
				AND c.idmateria =  49
				AND c.periodos LIKE '%$periodo%'
				AND c.iddocente=d.iddocente";
				$consultadg = $conx->query($sqldg);
				$recordsdg = $conx->records_array($consultadg);
				$docentedg = $recordsdg['apellido1']." ".$recordsdg['apellido2']." ".$recordsdg['nombre1']." ".$recordsdg['nombre2'];				
				$docentedg= ($docentedg);
				$sqlrector= "SELECT *  FROM appconfig WHERE item LIKE 'nrector'";
				$consultarector = $conx->query($sqlrector);
				$recordsrector = $conx->records_array($consultarector);
				$rector = $recordsrector['valor'];				
				if($periodo==4){
					echo 
					"<div style='line-height:7px;'>
					<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
					<table class='firma' border='0'>
							<tr>
								<td width='50%' align='center'>
									<span class='blocktext' style='text-decoration:overline; font-weight:bold'>$rector</span>
									<br/><span align='center' class='blocktext' >Rector(a)</span>
				
								</td>
								<td width='50%' align='center'>
									<span class='blocktext' style='text-decoration:overline; font-weight:bold'>$docentedg</span>
									<br/><span align='center' class='blocktext' >Dinamizador(a) de Curso</span>
				
								</td>
							</tr>
					</table>
					</div>";
			   
			   }else{
					echo 
					"<div style='line-height:7px;'>
					<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
					<table class='firma' border='0'>
							<tr>
								<td width='50%' align='center'>
									<span class='blocktext' style='text-decoration:overline; font-weight:bold'>$docentedg</span>
									<br/><span align='center' class='blocktext' >Dinamizador(a) de Curso</span>
				
								</td>
								<td align='center'>
									<br/><span align='center' class='blocktext' style='text-decoration:overline; font-weight:bold' >Padre de Familia o Acudiente</span>
								</td>
							</tr>
					</table>
					</div>";
			   }
				//echo "</div><span style='text-align:right; margin-left:810px; position:relative;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
				/*
				if($numest>1){
					echo "<h1 class='SaltoDePagina'></h1>";
					if (($numapaginas%2)!=0 and $numest!=1 and $numapaginas>1){
						echo "<h1 class='SaltoDePagina'><span style='color:white'>CONTINUACIÓN INFORME ACADÉMICO DE ".
							$nombre_estudiante." $corte</span></h1>";
					}
				}
				$numest--;*/
				$par=($pagina%2);
				if($numest>1){
					echo "<h1 class='SaltoDePagina'></h1>";
					
					if ( $par!=0 and $numest!=1 and $pagina>1){
						echo "<h1 class='SaltoDePagina'><span style='color:white'>CONTINUACIÓN INFORME ACADÉMICO DE ".
									$nombre_estudiante." $corte</span></h1>";
					}
				}
				$numest--;
				if ( $par!=0 and $numest==0 and $pagina>1){
					echo "<h1 class='SaltoDePagina'><span style='color:white'>CONTINUACIÓN INFORME ACADÉMICO DE ".
								strtoupper($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
								$records1['apellido2'])." $corte</span></h1>";
				}
				

				
				//-------------------------------FIN LADO B------------------------------------------------  
			}
			
			
	}elseif($formato=="f5" and $periodo==$num_periodos){
		    ?>
			<div id="ex1" style="">
			<div id="imgLOAD" style="text-align:center;" class="modal">
			<b>Gerenando Boletines...</b>
			<img src="../../images/loadingbar-blue.gif" /> Boletin <span id="boletingenerado"></span> DE <span id="totalboletines"></span>
			</div>
			</div>
			<?php
			$conx2 = new ConxMySQL($dominio,$usuario,$pass,$bd);
			$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
			if (isset($_POST['idestudiante'])) {
				$sqlest = "SELECT DISTINCT e.idestudiante, e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula 
							FROM estudiante e
							INNER JOIN matricula m ON e.idestudiante=m.idestudiante
							INNER JOIN notas n ON m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo AND m.tipo_matricula=n.tipo_nota
							WHERE m.aniolectivo=$aniolect AND m.idaula=$idaula AND m.tipo_matricula='R' AND m.periodo=0
							AND n.periodo=$periodo AND e.idestudiante='".$_POST['idestudiante']."'
							ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";
				
			}else{
				$sqlest = "SELECT DISTINCT 
							e.apellido1, e.apellido2, 
							e.nombre1, e.nombre2, m.idaula, e.idestudiante 
							FROM estudiante e
							INNER JOIN matricula m
							ON e.idestudiante=m.idestudiante AND m.idaula=$idaula
							AND m.tipo_matricula='R' AND m.periodo=0 AND m.aniolectivo=$aniolect
							AND e.habilitado='S'
							INNER JOIN notas n ON m.idestudiante=n.idestudiante
							AND m.aniolectivo=n.aniolectivo
							AND n.tipo_nota=m.tipo_matricula AND n.periodo=$periodo
							ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";
			}
			
        	$consultaest = $conx->query($sqlest);
			$numest = $conx->get_numRecords($consultaest);
			$totalest = $conx->get_numRecords($consultaest);
			//
			$total_materias=numero_asignaturas_salon($idaula, $aniolect);
			$tabla_promedios=tabla_promedios_con_comportamiento($idaula, $aniolect, $periodo,"S",$total_materias);
			$total_materias=numero_asignaturas_salon($idaula, $aniolect);
			// Llamar al procedimiento almacenado para consultar notas del salón
			$sql = "CALL ConsultarNotas($total_materias, $numero_decimales, $aniolect, $idaula, $periodo, 'S')";
			//agrupar resultados de notas
			$resultado = mysqli_query($conx2->getConexion(), $sql);
			if ($resultado) {
				$resultados = $conx2->records_array_assoc_all($resultado);
				// Array para almacenar los resultados agrupados por nombre
				$resultados_agrupados = array();

				// Iterar sobre los resultados y agruparlos por nombre
				// Recorrer los resultados y agruparlos por nombre y materia
				foreach ($resultados as $fila) {
					$nombre = $fila['nombre'];
					$materia = $fila['idmateria'];
					// Verificar si ya existe una entrada para este nombre en el array
					if (!isset($resultados_agrupados[$nombre])) {
						$resultados_agrupados[$nombre] = array();
					}
					// Verificar si ya existe una entrada para esta materia en el array del nombre actual
					if (!isset($resultados_agrupados[$nombre][$materia])) {
						$resultados_agrupados[$nombre][$materia] = array();
					}
					// Agregar la fila a la entrada correspondiente
					$resultados_agrupados[$nombre][$materia][] = $fila;
				}
				$numreg = count($resultados_agrupados);
			}
			$notas_porcentuales=obtenerNotas_porcentuales($aniolect, $periodo, $idaula, $numero_decimales);
            while($records1 = $conx->records_array($consultaest)){
				$msjBoletin= ($totalest-$numest)+1;
				echo "<script>$('#boletingenerado').text($msjBoletin); $('#totalboletines').text($totalest);</script>";
				$contmat=0;
            	switch($periodo){
					case 1: $corte="1ER"; break;
					case 2: $corte="2DO"; break;							
					case 3: $corte="3ER"; break;
				}
				switch($tipo_periodo){
					case 'T': $corte.=" TRIMESTRE"; break;
					case 'S': $corte.=" SEMESTRE"; break;							
				}
				echo 
                "<div class='fondo'><div style='line-height:7px;'>
                <table class='normal'>
                        <tr>
                            <td width='100px' align='left' rowspan='' valign='top'>
                                <span  class='blocktext'><img  src='../../images/logocol.png' width='95' height='95'/></span>
                            </td>
                            <td style='font-family: Arial, Helvetica, sans-serif;font-size:12px; font-style:italic;'><strong>INSTITUCIÓN EDUCATIVA MISIONAL SANTA TERESITA<br/>
								 San Andrés de Tumaco D.E.<br/>
								 NIT: 840.000.320-1      REGISTRO DANE: 152835001568      ICFES: 118117</strong><br/>
								Institución Educativa de Educación Preescolar, Primaria, Básica y Media Vocacional<br/>
								Aprobado mediante Resoluciones: 1325 del 24 de Julio de 2001 Básica Primaria, 1972 del 5 de<br/>
								Octubre 2001 Básica Secundaria y 4075 del 27 de Diciembre de 2002 Media Vocacional<br/>
								<strong>“HOY MEJOR QUE AYER, SIEMPRE LO MEJOR”</strong><br/><br/>
                            </td>
                        </tr>
                        <tr>
							<td colspan='2'><strong>INFORME ACADÉMICO<br/>$corte Y FINAL</strong>	
							</td>
                        </tr>
                        
                </table>
            	</div>";
				
				//$puestoperiodo=puestoPeriodoAlg2($records1['idestudiante'], $idaula, $aniolect, $periodo);
				//$promedioperiodo=promedioPeriodoAlg2($records1['idestudiante'], $idaula, $aniolect, $periodo);
				//$promedioperiodo=promedio_periodo_con_comportamiento($records1['idestudiante'], $idaula, $aniolect, $periodo, 'S',$total_materias);
				//$puestoperiodo=array_search($promedioperiodo,$tabla_promedios)+1;
				//recuperamos el puesto y promedio
				$puesto_promedio = encontrarPuestoYPromedioPorId($resultados_agrupados, $records1['idestudiante']);
				$puestoperiodo = $puesto_promedio['puesto'];
				$promedioperiodo = $puesto_promedio['promedio'];
				$nombre_estudiante=strtoupper(
				($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".$records1['apellido2']));
				$materiasperdidas=0;
				$materiasperdidas_con_recuperacion=0;
            	echo "<table class='alumno'>
            	<tr >
            	<td colspan='' class='fonttitle7'   style=''><strong>ESTUDIANTE</strong><BR/>".$nombre_estudiante."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>CODIGO</strong><BR/>".$records1['idestudiante']."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>CURSO</strong><BR/>".$grado2."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>AÑO LECTIVO</strong><BR/>".$aniolect."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>PUESTO</strong><BR/>$puestoperiodo</td>
				<td colspan='' class='fonttitle7'   style=''><strong>PROMEDIO</strong><BR/>$promedioperiodo</td>
            	</tr>
            	</table>";
				   
                //----------------------------------------------------
                //Generar resultados por Area/asignatura
				
				$caracteresxlinea = 98;
				if($papel=='letter'){
					$lineasxhoja=61;
				}elseif($papel=='legal'){
					$lineasxhoja=90;
				}else{
					$lineasxhoja=61;
				}
				$lineascabezera=14;
				$lineaspie=14;
				$lineasimpresas=$lineascabezera;
				if($periodo<$num_periodos){$spansem=2;}else{$spansem=4;}
				$colspan=4+$spansem+$periodo;
				$colspanNV=0;
				if($aniolectivo >= 2024){
					$sql_area_asignatura="SELECT DISTINCT a.idmateria, ar.idarea, CASE ar.nomarea WHEN 'CONVIVENCIAL' THEN 'COMPORTAMIENTO' ELSE ar.nomarea END AS nomarea, a.nombre_materia, concat_ws(' ', d.nombre1, d.nombre2, d.apellido1, d.apellido2) AS nombre_docente, c.ih, n.idestudiante, n.vn, n.periodo, n.fj, n.fsj, n.observaciones, n.aniolectivo FROM clase c 
					JOIN materia a ON c.idmateria=a.idmateria AND c.aniolectivo='$aniolect' AND c.idaula='$idaula' AND c.periodos LIKE '%$periodo%'
					JOIN notas n ON a.idmateria=n.idmateria AND n.periodo=$periodo AND n.tipo_nota='R' AND n.aniolectivo=c.aniolectivo AND n.idestudiante='".$records1['idestudiante']."'
					JOIN matricula m ON m.idestudiante=n.idestudiante AND n.tipo_nota=m.tipo_matricula AND n.aniolectivo=m.aniolectivo AND m.idaula=c.idaula
					JOIN area ar ON ar.idarea=a.idarea_fk
					JOIN docente d ON c.iddocente=d.iddocente  
					ORDER BY 
						CASE 
							WHEN a.idmateria = 49 THEN 2
							ELSE 1
						END,
						ar.nomarea, a.nombre_materia  DESC";
				}else{
										$sql_area_asignatura="SELECT DISTINCT a.idmateria, ar.idarea, ar.nomarea, a.nombre_materia, concat_ws(' ', d.nombre1, d.nombre2, d.apellido1, d.apellido2) AS nombre_docente, c.ih, n.idestudiante, n.vn, n.periodo, n.fj, n.fsj, n.observaciones, n.aniolectivo FROM clase c 
					JOIN materia a ON c.idmateria=a.idmateria AND a.idmateria != 49 AND c.aniolectivo='$aniolect' AND c.idaula='$idaula' AND c.periodos LIKE '%$periodo%'
					JOIN notas n ON a.idmateria=n.idmateria AND n.periodo=$periodo AND n.tipo_nota='R' AND n.aniolectivo=c.aniolectivo AND n.idestudiante='".$records1['idestudiante']."'
					JOIN matricula m ON m.idestudiante=n.idestudiante AND n.tipo_nota=m.tipo_matricula AND n.aniolectivo=m.aniolectivo AND m.idaula=c.idaula
					JOIN area ar ON ar.idarea=a.idarea_fk
					JOIN docente d ON c.iddocente=d.iddocente  
					ORDER BY 
						ar.nomarea, a.nombre_materia  DESC";

				}
				$consulta_area_asignatura = $conx->query($sql_area_asignatura);
				$id_area="";
				$pagina=1;
				$total_materias_calificadas=$conx->get_numRecords($consulta_area_asignatura);
            	while($recordsarea = $conx->records_array($consulta_area_asignatura)){
					$sqlrecordNV = "SELECT notas.vn, notas.periodo FROM notas WHERE notas.idestudiante='".$records1['idestudiante']."' 
							AND notas.idmateria='".$recordsarea['idmateria']."' AND notas.tipo_nota='N' AND notas.aniolectivo=$aniolect 
							AND notas.periodo<=7 ORDER BY notas.periodo";
					$consultsqlrecordNV = $conx->query($sqlrecordNV);
					$colspanNV = $conx->get_numRecords($consultsqlrecordNV);
						
					$colspanArea=$colspan+$colspanNV;
					if(($lineasimpresas)>=$lineasxhoja){
						//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";														
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						$lineasimpresas=4;
						echo "<span class='Estilo7c'> CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
					}
					$calificacion_area= obtenerNotaPorcentualArea($notas_porcentuales, $records1['idestudiante'], $recordsarea['idarea'], $periodo);
					$calificacion_asignatura = obtenerNotaPorcentualMateria($notas_porcentuales, $records1['idestudiante'], $recordsarea['idmateria'], $periodo);
					$notaporcentual_asignatura="";
					$porcentaje_calificado="";
					if(!empty($calificacion_asignatura)){
						$notaporcentual_asignatura=$calificacion_asignatura['notaporcentual'];
						$porcentaje_calificado=$calificacion_asignatura['porcentaje'];						
					}
					if($recordsarea['idarea']!=$id_area){
						if($recordsarea["idmateria"]==49){
							echo "<br />";
						}
						echo "<table class='area'>
						<tr >
						<th class='fonttitle7'   style='' colspan='' >".
							strtoupper(($recordsarea['nomarea']))."
						</th>";
						if(!empty($calificacion_area)){
							echo "<th width='10%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>NOTA: ".$calificacion_area['nota_area']."</strong></th>";
							if($calificacion_area['nota_area'] >= (float)$rcbamin and $calificacion_area['nota_area'] <= (float)$rcbamax){
								$desempenoFinal="Dba"; 
							}elseif($calificacion_area['nota_area'] >= (float)$rcbmin and $calificacion_area['nota_area'] <= (float)$rcbmax){
								$desempenoFinal="DB";
							}elseif($calificacion_area['nota_area'] >= (float)$rcamin and $calificacion_area['nota_area'] <= (float)$rcamax){
								$desempenoFinal="DA";
							}elseif($calificacion_area['nota_area'] >= (float)$rcsmin and $calificacion_area['nota_area'] <= (float)$rcsmax){
								$desempenoFinal="DS";
							}
							echo "<th width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>".$desempenoFinal."</strong></th>";
							echo "<th width='60%'></th>";
						}
						echo "</tr></table>";
						$id_area=$recordsarea['idarea'];
					}
					
					$lineasimpresas++;
					if(($lineasimpresas+3)>=$lineasxhoja){
						echo "</table>";
						//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>$lineasimpresas PAGINA $pagina DE $numapaginas</span>";								
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
					}
					echo "<table class='area'>";
					echo "<tr class='asignatura'>";
					if($recordsarea['idmateria']!=49){
					?>
					<td width='*%'><strong>ASIGNATURA:</strong> <?php echo strtoupper($recordsarea['nombre_materia']) . (!empty($porcentaje_calificado) ? " ".$porcentaje_calificado."%" : ""); ?>
					<br/><strong>DOCENTE:</strong> <?php echo strtoupper($recordsarea['nombre_docente']); ?></td>
					<?php
					}else{
						$dinamizador=($recordsarea['nombre_docente']);
					?>
					<td width='*%' colspan='3'>
					<br/><strong>DINAMIZADOR:</strong> <?php echo strtoupper($recordsarea['nombre_docente']); ?></td>
					<?php
					}
					
					//<td width='*%' ><strong>ASIGNATURA:</strong> ".strtoupper(($recordsarea['nombre_materia']))."
					//<br/><strong>DOCENTE:</strong> ".strtoupper(($recordsarea['nombre_docente']))."</td>
					echo "<td width='3%' style='text-align:center; '><strong>I.H</strong><br/> ".$recordsarea['ih']."</td>
					<td width='3%' style='text-align:center; '><strong>A.J</strong><br/> ".$recordsarea['fj']."</td>
					<td width='3%' style='text-align:center; '><strong>A.S.J</strong><br/> ".$recordsarea['fsj']."</td>";
					$promedioAcomulado=0;
					if($periodo<4){
						$vnSuma=0;
						$sql_notas="SELECT notas.vn, notas.periodo FROM notas WHERE notas.idestudiante='".$records1['idestudiante']."' 
						AND notas.idmateria='".$recordsarea['idmateria']."' AND notas.tipo_nota='R' AND notas.aniolectivo=$aniolect 
						AND notas.periodo<=$periodo ORDER BY notas.periodo";
						$consulta_notas = $conx->query($sql_notas);
						$numperiodos=0;
						while($fila_notas = $conx->records_array($consulta_notas)){
							$numperiodos++;
							switch($fila_notas['periodo']){
								case 1: $corte3='1 '.$tipo_periodo; break;
								case 2:	$corte3='2 '.$tipo_periodo; break;
								case 3: $corte3='3 '.$tipo_periodo; break;
								
							}
							// if($fila_notas['periodo']!=$numperiodos){
								// echo "<td width='3%' valign='center' style='text-align:center;'><strong>".$numperiodos." $tipo_periodo</strong><br/><img src='../../images/D.png' width='15' height='15'></img></td>";
							// }
							// //$promedio_asignatura+=$fila_notas['vn'];
							// echo "<td width='3%' valign='center' style='text-align:center;'><strong>".$corte3." </strong><br/>".number_format((float)$fila_notas['vn'],1,".",",")."</td>";
							$notas_porcentuales=obtenerNotas_porcentuales($aniolect, $fila_notas['periodo'], $idaula, $numero_decimales);
							$calificacion_asignatura = obtenerNotaPorcentualMateria($notas_porcentuales, $records1['idestudiante'], $recordsarea['idmateria'], $fila_notas['periodo']);
							$notaporcentual_asignatura="";
							$porcentaje_calificado="";
							if(!empty($calificacion_asignatura)){
								$notaporcentual_asignatura=$calificacion_asignatura['notaporcentual'];
								$porcentaje_calificado=$calificacion_asignatura['porcentaje'];						
							}
							//$promedio_asignatura+=$fila_notas['vn'];
							echo "<td width='3%' valign='center' style='text-align:center;'><strong>".$corte3." </strong><br/>".number_format(round((float)$fila_notas['vn'], $numero_decimales),$numero_decimales,".",",").(!empty($notaporcentual_asignatura)? "[".$notaporcentual_asignatura."]":"")."</td>";

							$sqlrecordNV = "SELECT notas.vn, notas.periodo FROM notas WHERE notas.idestudiante='".$records1['idestudiante']."' 
							AND notas.idmateria='".$recordsarea['idmateria']."' AND notas.tipo_nota='N' AND notas.aniolectivo=$aniolect 
							AND notas.periodo=".$fila_notas['periodo']." ORDER BY notas.periodo";
							$consultarecordNV = $conx->query($sqlrecordNV);

							if($recordsperiodoNV = $conx->records_array($consultarecordNV)){
								switch($fila_notas['periodo']){
									case 1:
									case 3:
									case 2:
									case 4:	$corte2='NV'; break;
								}
								// if(number_format((float)$recordsperiodoNV['vn'],1,".",",") > number_format((float)$fila_notas['vn'],1,".",",") ){
									// $vnSuma+=number_format((float)$recordsperiodoNV['vn'],1,".",",");
								// }
								if(number_format(round((float)$recordsperiodoNV['vn'], $numero_decimales),$numero_decimales,".",",") > number_format(round((float)$fila_notas['vn'], $numero_decimales),$numero_decimales,".",",") ){
									$vnSuma+=number_format(round((float)$recordsperiodoNV['vn'], $numero_decimales),$numero_decimales,".",",");
								}
								echo "<td width='3%' valign='center' style='text-align:center;'><strong>$corte2</strong><br/>".number_format(round((float)$recordsperiodoNV['vn'], $numero_decimales),$numero_decimales,".",",")."</td>";
							}else{
								//$vnSuma+=number_format((float)$fila_notas['vn'],1,".",",");
								$vnSuma+=number_format(round((float)$fila_notas['vn'], $numero_decimales),$numero_decimales,".",",");
							}
						}
						$promedioFinal=number_format(round((float)($vnSuma/$numperiodos), 1),$numero_decimales,".",",");
						//$promedioFinal=number_format((float)($vnSuma/$num_periodos),1,".",",");
						$vnSuma=0;
						$promedioFinal = (float)$promedioFinal;
						
						// Convertimos todas las variables a float una sola vez
						$rcbamin = (float)$rcbamin;
						$rcbamax = (float)$rcbamax;
						$rcbmin = (float)$rcbmin;
						$rcbmax = (float)$rcbmax;
						$rcamin = (float)$rcamin;
						$rcamax = (float)$rcamax;
						$rcsmin = (float)$rcsmin;
						$rcsmax = (float)$rcsmax;
						
						// Definir los rangos y sus desempeños en un array
						$rangos = [
							'Dba' => [$rcbamin, $rcbamax],
							'DB'  => [$rcbmin, $rcbmax],
							'DA'  => [$rcamin, $rcamax],
							'DS'  => [$rcsmin, $rcsmax]
						];
						
						// Inicializar la variable de desempeño final
						$desempenoFinal = null;

						// Iterar sobre los rangos y asignar el desempeño correspondiente
						foreach ($rangos as $desempeno => [$min, $max]) {
							if ($promedioFinal >= $min && $promedioFinal <= $max) {
								$desempenoFinal = $desempeno;
								
								break; // Rompemos el bucle una vez que encontramos el rango correcto
							}
						}
												
						
						
						
						echo "<td width='6%' nowrap valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>FINAL</strong><br>".number_format(round((float)$promedioFinal, $numero_decimales),$numero_decimales ,".",",")."</td>";
						
						$sqlrecordNV = "SELECT notas.vn, notas.periodo FROM notas WHERE notas.idestudiante='".$records1['idestudiante']."' 
						AND notas.idmateria='".$recordsarea['idmateria']."' AND notas.tipo_nota='N' AND notas.aniolectivo=$aniolect 
						AND notas.periodo=7 ORDER BY notas.periodo";
						$consultarecordNV = $conx->query($sqlrecordNV);
						$asignatura_con_recuperacion_final=FALSE;
						if($recordsperiodoNV = $conx->records_array($consultarecordNV)){
							$asignatura_con_recuperacion_final=TRUE;
							if(number_format((float)$recordsperiodoNV['vn'],1,".",",") > number_format((float)$promedioFinal,1,".",",") ){
								//$promedioFinal=number_format((float)$recordsperiodoNV['vn'],1,".",",");
								$promedioFinal=number_format(round((float)$recordsperiodoNV['vn'], $numero_decimales),$numero_decimales,".",",");
							}
							echo "<td width='6%' nowrap valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>NV</strong><br>".number_format((float)$recordsperiodoNV['vn'],1,".",",")."</td>";
						}
						if($promedioFinal >= (float)$rcbamin and $promedioFinal <= (float)$rcbamax){
							$desempenoFinal="Dba"; 
							$aprobacion="NO APROBADA";
							$materiasperdidas++;
							if($asignatura_con_recuperacion_final){
								$materiasperdidas_con_recuperacion++;
							}
						}elseif($promedioFinal >= (float)$rcbmin and $promedioFinal <= (float)$rcbmax){
							$desempenoFinal="DB";
							$aprobacion="APROBADA";
						}elseif($promedioFinal >= (float)$rcamin and $promedioFinal <= (float)$rcamax){
							$desempenoFinal="DA";
							$aprobacion="APROBADA";
						}elseif($promedioFinal >= (float)$rcsmin and $promedioFinal <= (float)$rcsmax){
							$desempenoFinal="DS";
							$aprobacion="APROBADA";
						}
						
						if($grado==0){
							switch($desempenoFinal){
								case 'DS': 
											echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><img src='../../images/superiorkg.png' width='30' height='30'></td>";
											break;
								case 'DA': 
											echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><img src='../../images/altokg.png' width='30' height='30'></td>";
											break;
								case 'DB': 
											echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><img src='../../images/basicokg.png' width='30' height='30'></td>";
											break;
								default: 
											echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><img src='../../images/bajokg.png' width='30' height='30'></td>";
											break;
							}
							if($recordsarea["idmateria"]!=49){
								echo "<td colspan='2' width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>".$aprobacion."</strong></td>";
							}

						}else{
							echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>".$desempenoFinal."</strong></td>";
							if($recordsarea["idmateria"]!=49){				
								echo "<td colspan='2' width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>".$aprobacion."</strong></td>";
							}
						}
						
					}	
					echo "</tr>";
					$lineasimpresas+=2;
					if($aniolectivo<2016){
						$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
						pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
						FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
						(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
						and pc.estandarbc=ebc.codigo
						and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
						and eb.periodo =$periodo and eb.iddocente =$iddocente and eb.grado ='$grado'
						and ebc.idmateria_fk=m.idmateria and m.idarea_fk='".$recordsarea['idarea']."' and eb.idmateria=$idmateria
						ORDER BY consecutivo DESC";
					}else{
						//consultando competencias 
						$sqlind="SELECT DISTINCT i.idmateria, p.competencia, p.consecutivo, i.DS, i.DA, i.DB, i.DBA FROM plan_curricular p 
									JOIN indicadoresboletin i ON p.consecutivo=i.idindicador AND i.aniolectivo='$aniolect' AND i.periodo=$periodo AND i.idmateria='".$recordsarea['idmateria']."'
									JOIN aula a ON i.grado=a.grado AND a.idaula='$idaula'";
					}
					$consultaind = $conx->query($sqlind);
					$numind=$conx->get_numRecords($consulta);
					$colspan2=$colspan-2;
					if(($lineasimpresas)>=$lineasxhoja){
						echo "</table>";
						//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";														
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						$lineasimpresas=4;
						echo "<table class='area'><tr>";
						for($i=1; $i<=$periodo+6; $i++){
							echo "<td></td>";
						}
						echo "</tr>";
						if($recordsarea["idmateria"]!=49){
							echo "
							<tr><td style='border-top: 1px solid black;' colspan='$colspan2' ><strong>COMPETENCIAS $corte</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>FORTALEZA</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>DEBILIDAD</strong></td></tr>";
						}
						echo "<span class='Estilo7c'> CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
					}else{
						if($recordsarea["idmateria"]!=49){
							echo "<tr><td style='border-top: 1px solid black;' colspan='$colspan2' ><strong>COMPETENCIAS $corte</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>FORTALEZA</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>DEBILIDAD</strong></td></tr>";
						}
					}
					$lineasimpresas+=1;
					while ($rowind = $conx->records_array($consultaind)) {
						$sqldelinselect="SELECT * FROM indicadoresestudiante WHERE idindicador='".$rowind['consecutivo']."'
						and aniolectivo=$aniolect and periodo=$periodo and idestudiante='".$records1['idestudiante']."'";
						$consultaindselect = $conx->query($sqldelinselect);
						
						if($rowindselect = $conx->records_array($consultaindselect)){
							$cadena = $rowind['competencia'];
							$numlineasind=ceil(strlen($cadena)/$caracteresxlinea);
							$lineasimpresas+=$numlineasind;
							if(($lineasimpresas)>=$lineasxhoja){
								echo "</table>";
								//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";								
								echo "<h1 class='SaltoDePagina'></h1>";
								$pagina++;
								if (($pagina%2)==0){
									echo"<br/><br/><br/><br/><br/>";
								}
								echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
								$nombre_estudiante."  $corte</span><br/><br/>";
								if($recordsarea["idmateria"]!=49){
									echo "<table class='area'><tr><td width='48%'></td>";
									for($i=1; $i<=$periodo+5; $i++){
										
										echo "<td ></td>";
									}
									echo "</tr>";
									echo "<tr>";
									echo "<td align='left' style='font-family: \"Courier New\", Courier, monospace;
									font-style: normal; fon-size:12px' colspan='$colspan2' rowspan=''>".(($rowind['competencia']))."</td>";
									if($rowindselect['nivel_aprendizaje']=='F'){
										echo "<td align='center' rowspan='' width='6%' ><img src='../../images/F.png' width='15' height='15' ></img></td><td rowspan='' width='78px'></td>";
									}else{
										echo "<td rowspan='' width='6%'></td><td align='center' rowspan='' width='78px'><img src='../../images/D.png' width='15' height='15'></img></td>";
									}
									echo "</tr>";
									$lineasimpresas=4;
								}
							}else{
								if($recordsarea["idmateria"]!=49){
									echo "<tr>";
									echo "<td align='left' style='font-family: \"Courier New\", Courier, monospace;
									font-style: normal; fon-size:12px' colspan='$colspan2'>".(($rowind['competencia']))."</td>";
									if($rowindselect['nivel_aprendizaje']=='F'){
										echo "<td width='6%' align='center' ><img src='../../images/F.png' width='15' height='15' ></img></td><td></td>";
									}else{
										echo "<td></td><td width='6%' align='center'><img src='../../images/D.png' width='15' height='15'></img></td>";
									}
									echo "</tr>";
								}
							}
							
						}
				
					}
						
					if(($lineasimpresas)>=($lineasxhoja)){
						echo "</table>";
						//echo "<span style='text-align:right; text-align:right; margin-left:810px; position:relative;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
					}else{
						echo "</table>";
					}
						
				}
				//Generar resultados COMPORTAMIENTO
				if($aniolectivo<2024){
					if(($lineasimpresas+4)>=($lineasxhoja)){
							echo "</table>";
							//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
							echo "<h1 class='SaltoDePagina'></h1>";
							$pagina++;
							if (($pagina%2)!=0){
								echo"<br/><br/><br/><br/><br/>";
							}
							echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
							$nombre_estudiante."  $corte</span><br/><br/>";
							$lineasimpresas=4;
					}
					echo "<br/><table class='area'>";
						$sql="SELECT DISTINCT a.idmateria, ar.idarea, ar.nomarea, a.nombre_materia, concat_ws(' ', d.nombre1, d.nombre2, d.apellido1, d.apellido2) AS nombre_docente, c.ih, n.idestudiante, n.vn, n.periodo, n.fj, n.fsj, n.observaciones, n.aniolectivo FROM clase c 
						JOIN materia a ON c.idmateria=a.idmateria AND c.idmateria=49 AND c.aniolectivo='$aniolect' AND c.idaula='$idaula' AND c.periodos LIKE '%$periodo%'
						JOIN notas n ON a.idmateria=n.idmateria AND n.periodo=$periodo AND n.tipo_nota='R' AND n.aniolectivo=c.aniolectivo AND n.idestudiante='".$records1['idestudiante']."'
						JOIN matricula m ON m.idestudiante=n.idestudiante AND n.tipo_nota=m.tipo_matricula AND n.aniolectivo=m.aniolectivo AND m.idaula=c.idaula
						JOIN area ar ON ar.idarea=a.idarea_fk
						JOIN docente d ON c.iddocente=d.iddocente  
						ORDER BY ar.nomarea, a.nombre_materia  DESC";
						$consulta2 = $conx->query($sql);
						$colspan2=1;
						$lineasimpresas+=1;
						while($records2 = $conx->records_array($consulta2)){
							$nota_asignatura=$records2['vn'];
							if($nota_asignatura >= (float)$rcbamin and $nota_asignatura <= (float)$rcbamax){
								$desempeno_asignatura="Db"; 
							}elseif($nota_asignatura >= (float)$rcbmin and $nota_asignatura <= (float)$rcbmax){
								$desempeno_asignatura="DB";
							}elseif($nota_asignatura >= (float)$rcamin and $nota_asignatura <= (float)$rcamax){
								$desempeno_asignatura="DA";
							}elseif($nota_asignatura >= (float)$rcsmin and $nota_asignatura <= (float)$rcsmax){
								$desempeno_asignatura="DS";
							}
							$dinamizador=($records2['nombre_docente']);
							echo "<br/><table class='area'>
							<tr >
							<th class='fonttitle7'   style='' colspan='' >COMPORTAMIENTO</th>
							</tr></table>";
							echo "<table class='area'>";
							echo "<tr class='asignatura'>
								<td width='*%' colspan='".($periodo+4)."' ><strong>DINAMIZADOR:</strong> ".strtoupper($dinamizador)."</td>
								<td width='6%' nowrap valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>".number_format((float)$nota_asignatura,1,".",",")."</strong></td>";
							if($grado==0){
								switch($desempeno_asignatura){
									case 'DS': 
												echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><img src='../../images/superiorkg.png' width='39' height='40'></td>";
												break;
									case 'DA': 
												echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><img src='../../images/altokg.png' width='39' height='40'></td>";
												break;
									case 'DB': 
												echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><img src='../../images/basicokg.png' width='39' height='40'></td>";
												break;
									default: 
												echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><img src='../../images/bajokg.png' width='39' height='40'></td>";
												break;
								}
								$lineasimpresas+=4;
							}else{
								echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>$desempeno_asignatura</strong></td>";
								$lineasimpresas+=2;
							}
								
							echo "</tr>";
							$lineasimpresas+=2;
							///seleccionando indicadores escogidos por el docenbte en esta area y curso
							if($aniolectivo<2016){
								$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
								pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
								FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
								(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
								and pc.estandarbc=ebc.codigo
								and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolect
								and eb.periodo =$periodo and eb.iddocente =$iddocente and eb.grado ='$grado'
								and ebc.idmateria_fk=m.idmateria and m.idarea_fk='20'
								ORDER BY consecutivo DESC";
							}else{
								//consultando competencias 
								$sqlind="SELECT DISTINCT i.idmateria, p.competencia, p.consecutivo, i.DS, i.DA, i.DB, i.DBA FROM plan_curricular p 
								JOIN indicadoresboletin i ON p.consecutivo=i.idindicador AND i.aniolectivo='$aniolect' AND i.periodo=$periodo AND i.idmateria='".$records2['idmateria']."'
								JOIN aula a ON i.grado=a.grado AND a.idaula='$idaula'";
								
							}
							$consultaind = $conx->query($sqlind);
							$numind=$conx->get_numRecords($consultaind);
							$colspan2=1;
							if(($lineasimpresas+7)>=($lineasxhoja)){
								echo "</table>";
								//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";														
								echo "<h1 class='SaltoDePagina'></h1>";
								$pagina++;
								if (($pagina%2)==0){
									echo"<br/><br/><br/><br/><br/>";
								}
								echo "<table class='area'>";
								echo "<tr class='asignatura'>";
							
								echo "<tr><td style='border-top: 1px solid black;' colspan='".($periodo+4)."' ><strong>ACTITUDES $corte</strong></td>
									<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>FORTALEZA</strong></td>
									<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>DEBILIDAD</strong></td></tr>";
								echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
								$nombre_estudiante."  $corte</span><br/><br/>";
								$lineasimpresas=4;
							}else{
								echo "<tr><td style='border-top: 1px solid black;' colspan='".($periodo+4)."' ><strong>ACTITUDES $corte</strong></td>
									<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>FORTALEZA</strong></td>
									<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>DEBILIDAD</strong></td></tr>";
								
							}
							while ($rowind = $conx->records_array($consultaind)) {
								$sqldelinselect="SELECT * FROM indicadoresestudiante WHERE idindicador='".$rowind['consecutivo']."'
								and aniolectivo=$aniolect and periodo=$periodo and idestudiante='".$records1['idestudiante']."'";
								$consultaindselect = $conx->query($sqldelinselect);
								
								if($rowindselect = $conx->records_array($consultaindselect)){
									$cadena = $rowind['competencia'];
									$numlineasind=ceil(strlen($cadena)/$caracteresxlinea);
									$lineasimpresas+=$numlineasind;
									if(($lineasimpresas+4)>=($lineasxhoja)){
										echo "</table>";
										//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";								
										echo "<h1 class='SaltoDePagina'></h1>";
										$pagina++;
										if (($pagina%2)==0){
											echo"<br/><br/><br/><br/><br/>";
										}
										echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
										$nombre_estudiante."  $corte</span><br/><br/>";
										echo "<table class='area'>";
										echo "<tr>";
										echo "<td align='left' style='font-family: \"Courier New\", Courier, monospace;
										font-style: normal; fon-size:12px' colspan='".($periodo+4)."'>".(($rowind['competencia']))."</td>";
										if($rowindselect['nivel_aprendizaje']==='F'){
											echo "<td width='6%' align='center' ><img src='../../images/F.png' width='15' height='15' ></img></td><td></td>";
										}else{
											echo "<td></td><td width='6%' align='center'><img src='../../images/D.png' width='15' height='15'></img></td>";
										}
										echo "</tr>";
										$lineasimpresas=4;
									}else{
										echo "<td align='left' style='font-family: \"Courier New\", Courier, monospace;
										font-style: normal; fon-size:12px' colspan='".($periodo+4)."'>".(($rowind['competencia']))."</td>";
										if($rowindselect['nivel_aprendizaje']=='F'){
											echo "<td width='6%' align='center' ><img src='../../images/F.png' width='15' height='15' ></img></td><td width='6%'></td>";
										}else{
											echo "<td width='6%' ></td><td width='6%' align='center'><img src='../../images/D.png' width='15' height='15'></img></td>";
										}
										echo "</tr>";
									}
									
						
							}
								
						}
						if(($pagina%2)==0){
							$lineasimpresas+=7;
						}
						if(($lineasimpresas)>=($lineasxhoja)){
							echo "</table>";
							//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
							echo "<h1 class='SaltoDePagina'></h1>";
							$pagina++;
							if (($pagina%2)==0){
								echo"<br/><br/><br/><br/><br/>";
							}
							echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
							$nombre_estudiante."  $corte</span><br/><br/>";
							$lineasimpresas=3;
						}else{
							echo "</table>";
						}
							
					}
				}
				//observaciones generales
				echo "
				<br/>
				<table class='alumno' border='0' cellspacing='5px' >
			   <tr >
			   <th colspan='2'>
				   <p class='Estilo5' align='center'>OBSERVACIONES GENERALES</p>
			   </th>
			   </tr>
			   <tr class='asignatura'>
				<td width='30%' align='left' class='Estilo6'>ASIGNATURA</td>
				<td  align='left' class='Estilo6' >OBSERVACIÓN</td>
			   </tr>";
				$lineasimpresas+=1;
				
									
				$sqlog = "SELECT DISTINCT a.nombre_materia, n.observaciones 
				FROM materia a, notas n WHERE n.idestudiante=".$records1['idestudiante']." AND a.idmateria=n.idmateria 
				AND periodo='$periodo' AND n.aniolectivo=$aniolect 
				AND n.tipo_nota='R' AND n.observaciones IS NOT NULL
				ORDER BY a.nombre_materia ASC";
				$consultaog = $conx->query($sqlog);
				while($recordsog = $conx->records_array($consultaog)){
					if($recordsog['observaciones']!=NULL){
						 $observaciones=$recordsog['observaciones'];
						 $existe = strrpos($observaciones, ".");
						 if($existe==false ){
								$observaciones.=".";
						 }
						 $numlineasobs=0;
						 $cadena = $recordsog['observaciones'];
						 $numlineasobs+=ceil(strlen($cadena)/$caracteresxlinea);
						 $lineasimpresas+=$numlineasobs;
						 if(($lineasimpresas)>=89){
							echo "</table>";
							//echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";								
							echo "<h1 class='SaltoDePagina'></h1>";
							$pagina++;
							if (($pagina%2)==0){
								echo"<br/><br/><br/><br/><br/>";
							}
							echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
							$nombre_estudiante."  $corte</span><br/><br/>";
							echo "<table class='alumno' border='0' cellspacing='5px' >";
							echo "<tr>
							<td  width='30%' align='center' class='Estilo1'>".strtoupper(($recordsog['nombre_materia']))."</td>
						   <td align='left' valign='top' style='line-height:15px; text-align:justify; font-family: \"Courier New\", Courier, monospace;
									font-style: normal;'>
							<span class='' >".utf8_decode(
							String_oracion($observaciones))."</span>&nbsp;
							</td>
							</tr>";
							$lineasimpresas=4;
						}else{
							echo "<tr>
							<td  class='Estilo1'>".strtoupper(($recordsog['nombre_materia']))."</td>
						   <td align='left' valign='top' style='line-height:15px; text-align:justify; font-family: \"Courier New\", Courier, monospace;
									font-style: normal;'>
							<span class='' >".utf8_decode(
							String_oracion($observaciones))."</span>&nbsp;
							</td>
							</tr>";
						}
						
					}
				}
				echo "</table>";
				$lineasimpresas+1;
				if($lineasimpresas>=89){
						//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
				}
				//Condiciones de promocion
				$sql = "SELECT asignaturas_perdidas_sin_recuperacion, asignaturas_perdidas_con_recuperacion FROM condiciones_promocion WHERE aniolectivo = $aniolectivo";
				$result_promocion = $conx->query($sql);
				
				//
				if($result_promocion){
					while($row = $conx->records_array($result_promocion)){
						$asignaturas_perdidas_sin_recuperacion = $row['asignaturas_perdidas_sin_recuperacion'];
						$asignaturas_perdidas_con_recuperacion = $row['asignaturas_perdidas_con_recuperacion'];
					}
					if($materiasperdidas>0 and $materiasperdidas <$asignaturas_perdidas_sin_recuperacion and $materiasperdidas_con_recuperacion<$asignaturas_perdidas_con_recuperacion){
						$estadoP= "FUE PROMOVIDA(O)";
						switch($grado){
							 case 0: $estadoP="<span style='color:red;'>".$estadoP." AL GRADO PRIMERO </span> Tiene $materiasperdidas área(s) reprobada(s)"; break;
							 case 1: $estadoP="<span style='color:red;'>".$estadoP." AL GRADO SEGUNDO </span> Tiene $materiasperdidas área(s) reprobada(s)"; break;
							 case 2: $estadoP="<span style='color:red;'>".$estadoP." AL GRADO TERCERO </span> Tiene $materiasperdidas área(s) reprobada(s)"; break;
							 case 3: $estadoP="<span style='color:red;'>".$estadoP." AL GRADO CUARTO </span> Tiene $materiasperdidas área(s) reprobada(s)"; break;
							 case 4: $estadoP="<span style='color:red;'>".$estadoP." AL GRADO QUINTO </span> Tiene $materiasperdidas área(s) reprobada(s)"; break;
							 case 5: $estadoP="<span style='color:red;'>".$estadoP." AL GRADO SEXTO </span> Tiene $materiasperdidas área(s) reprobada(s)"; break;
							 case 6: $estadoP="<span style='color:red;'>".$estadoP." AL GRADO SEPTIMO </span> Tiene $materiasperdidas área(s) reprobada(s)"; break;
							 case 7: $estadoP="<span style='color:red;'>".$estadoP." AL GRADO OCTAVO </span> Tiene $materiasperdidas área(s) reprobada(s)"; break;
							 case 8: $estadoP="<span style='color:red;'>".$estadoP." AL GRADO NOVENO </span> Tiene $materiasperdidas área(s) reprobada(s)"; break;
							 case 9: $estadoP="<span style='color:red;'>".$estadoP." AL GRADO DECIMO </span> Tiene $materiasperdidas área(s) reprobada(s)"; break;
							 case 10: $estadoP="<span style='color:red;'>".$estadoP." AL GRADO ONCE </span> Tiene $materiasperdidas área(s) reprobada(s)"; break;
							 case 11: if($materiasperdidas>=0){$estadoP="<span style='color:red;'>Para graduarse debe recuperar materias no aprobadas</span>";}else{ $estadoP="<span style='color:red;'>GRADUADO(A) </span>";} break;
							 default: $estadoP=""; break;
												
						}
						if($grado!=11){ $estadoP.=" SEGÚN LO ESTABLECIDO EN EL S.I.E DE LA INSTITUCIÓN";}
				}elseif($materiasperdidas>=$asignaturas_perdidas_sin_recuperacion or $materiasperdidas_con_recuperacion>=$asignaturas_perdidas_con_recuperacion){
						  $estadoP= "<span style='color:red;'>"."DEBE REPETIR EL GRADO, "."</span> Tiene $materiasperdidas área(s) reprobada(s).";
				}elseif($materiasperdidas==0){
						$estadoP= "FUE PROMOVIDA(O)";
						switch($grado){
						 case 0: $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO PRIMERO"; break;
						 case 1: $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO SEGUNDO"; break;
						 case 2: $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO TERCERO"; break;
						 case 3: $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO CUARTO"; break;
						 case 4: $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO QUINTO"; break;
						 case 5: $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO SEXTO"; break;
						 case 6: $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO SEPTIMO"; break;
						 case 7: $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO OCTAVO"; break;
						 case 8: $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO NOVENO"; break;
						 case 9: $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO DECIMO"; break;
						 case 10: $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO ONCE"; break;
						 case 11: $estadoP="<span style='color:blue;'>GRADUADO(A)"; break;
						 default: $estadoP=""; break;
												
						}
						if($grado!=11){ $estadoP.=" SEGÚN LO ESTABLECIDO EN EL S.I.E DE LA INSTITUCIÓN";}
				}
				}
				

				echo "<br/><table class='resultadoasig'>";
				if($total_materias_calificadas<$total_materias-1){
					$estadoP="<span style='color:red;'>NO SE PUEDE ESTABLECER ESTADO DE PROMOCION. FALTA CALIFICAR ALGUNAS ASIGNATURAS</span>";
				}
				if($periodo==$num_periodos){
					echo "<tr><td style='text-align:left; font:12px 	arial,sans-serif;'>
					<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >$estadoP</span></td></tr>";
				}
				echo "</table>";
				$lineasimpresas+=2;
				
				if($lineasimpresas>=89){
						//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
				}
				//---------------------------CONVENCIONES
				switch($tipo_periodo){
					case 'T': $tipo_periodo_texto=" Trimestre"; break;
					case 'S': $tipo_periodo_texto=" Semestre"; break;							
				}
				echo "
				<br/><div class='firma'>
				<table class='convenciones'>
				<tr>
					<td width='150px' colspan='6' valign='center' style='text-align:center; background:#E5E5E5;'>CONVENCIONES</td>
				</tr>";
				$lineasimpresas+=2;
				if($lineasimpresas>=80){
						//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
				}
				if($grado==0){
					echo "<tr>
					<td width='45' valign='top'><img src='../../images/superiorkg.png' width='25' height='25'></td>
					<td width='161' valign='center' class='Estilo7'>Desempeño Superior [".number_format((float)$rcsmin,1,'.',',')." a ".number_format((float)$rcsmax,1,'.',',')."]</td>
					<td width='45' valign='top'><img src='../../images/altokg.png' width='25' height='25'></td>
					<td width='161' valign='center' class='Estilo7'>Desempeño Alto [".number_format((float)$rcamin,1,'.',',')." a ".number_format((float)$rcamax,1,'.',',')."]</td>
					<td width='45' valign='center'>A.J</td>
					<td width='161' valign='center' class='Estilo7'>Ausencias con justificación</td>
					</tr>";
				}else{
					echo "<tr>
					<td width='45' valign='top'>DS</td>
					<td width='161' valign='center' class='Estilo7'>Desempeño Superior [".number_format((float)$rcsmin,1,'.',',')." a ".number_format((float)$rcsmax,1,'.',',')."]</td>
					<td width='45' valign='top'>DA</td>
					<td width='161' valign='center' class='Estilo7'>Desempeño Alto [".number_format((float)$rcamin,1,'.',',')." a ".number_format((float)$rcamax,1,'.',',')."]</td>
					<td width='45' valign='top'>A.J</td>
					<td width='161' valign='top' class='Estilo7'>Ausencias con justificación</td>
					</tr>";
				}
				
				$lineasimpresas+=2;
				if( $lineasimpresas>=80){
						//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
				}
				if($grado==0){
					echo "<tr>
					<td width='45' valign='top'><img src='../../images/basicokg.png' width='25' height='25'></td>
					<td width='161' valign='center' class='Estilo7'>Desempeño Básico [".number_format((float)$rcbmin,1,'.',',')." a ".number_format((float)$rcbmax,1,'.',',')."]</td>
					<td width='45' valign='top'><img src='../../images/bajokg.png' width='25' height='25'></td>
					<td width='161' valign='center' class='Estilo7'>Desempeño Bajo [".number_format((float)$rcbamin,1,'.',',')." a ".number_format((float)$rcbamax,1,'.',',')."]</td>
					<td width='45' valign='center'>A.S.J</td>
					<td width='161' valign='center' class='Estilo7' >Ausencias sin justificación</td>
					
					</tr>";
				}else{
					echo "<tr>
					<td width='45' valign='top'>DB</td>
					<td width='161' valign='top' class='Estilo7'>Desempeño Básico [".number_format((float)$rcbmin,1,'.',',')." a ".number_format((float)$rcbmax,1,'.',',')."]</td>
					<td width='45' valign='top'>Db</td>
					<td width='161' valign='top' class='Estilo7'>Desempeño Bajo [".number_format((float)$rcbamin,1,'.',',')." a ".number_format((float)$rcbamax,1,'.',',')."]</td>
					<td width='45' valign='top'>A.S.J</td>
					<td width='161' valign='top' class='Estilo7' >Ausencias sin justificación</td>
					
					</tr>";
				}
				$lineasimpresas+=2;
				if($lineasimpresas>=80){
						//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
				}
				echo "<tr>
					<td width='45' valign='top'>1 $tipo_periodo</td>
					<td width='161' valign='top' class='Estilo7' >Primer $tipo_periodo_texto</td>
					<td width='45' valign='top'>2 $tipo_periodo</td>
					<td width='161' valign='top' class='Estilo7'>Segundo $tipo_periodo_texto</td>
					<td width='45' valign='top'>I.H</td>
					<td width='161' valign='top' class='Estilo7' >Intensidad Horaria</td>
				</tr>";
				$lineasimpresas+=2;
				if($lineasimpresas>=80){
						//echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						$nombre_estudiante."  $corte</span><br/><br/>";
						$lineasimpresas=4;
				}
				echo "<tr>
					
					<td width='45' valign='top'>3 $tipo_periodo</td>
					<td width='161' valign='top' class='Estilo7' >Tercer $tipo_periodo_texto</td>
					<td width='45' valign='top'>D</td>
					<td width='161' valign='top' class='Estilo7'>Definitiva</td>
					<td width='45' valign='top'></td>
					<td width='161' valign='top' class='Estilo7' ></td>
				</tr>
				</table></div>"; 
				$sqlrector= "SELECT *  FROM appconfig WHERE item LIKE 'nrector'";
				$consultarector = $conx->query($sqlrector);
				$recordsrector = $conx->records_array($consultarector);
				$rector = $recordsrector['valor'];
				if($periodo==$num_periodos){
					echo 
					"<div style='line-height:7px;'>
					<br/><br/><br/><br/><br/><br/><br/>
					<table class='firma' border='0'>
							<tr>
								<td width='50%' align='center'>
									<span class='blocktext' style='text-decoration:overline; font-weight:bold'>$rector</span>
									<br/><span align='center' class='blocktext' >Rector(a)</span>
								</td>
								<td width='50%' align='center'>
									<span class='blocktext' style='text-decoration:overline; font-weight:bold'>$dinamizador</span>
									<br/><span align='center' class='blocktext' >Dinamizador(a) de Curso</span>
								</td>
							</tr>
					</table>
					</div>";
			   
			   }else{
					echo 
					"<div style='line-height:7px;'>
					<br/><br/><br/><br/><br/><br/><br/>
					<table class='firma' border='0'>
							<tr>
								<td width='50%' align='center'>
									<span class='blocktext' style='text-decoration:overline; font-weight:bold'>$dinamizador</span>
									<br/><span align='center' class='blocktext' >Dinamizador(a) de Curso</span>
				
								</td>
								<td align='center'>
									<br/><span align='center' class='blocktext' style='text-decoration:overline; font-weight:bold' >Padre de Familia o Acudiente</span>
								</td>
							</tr>
					</table>
					</div>";
			   }
				//echo "</div><br/><span style='text-align:right; margin-left:810px; position:relative;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
				$par=($pagina%2);
				if($numest>1){
					echo "<h1 class='SaltoDePagina'></h1>";
					
					if ( $par!=0 and $numest!=1 and $pagina>1){
						echo "<h1 class='SaltoDePagina'><span style='color:white'>CONTINUACIÓN INFORME ACADÉMICO DE ".
									$nombre_estudiante." $corte</span></h1>";
					}elseif($pagina==1){
						echo "<h1 class='SaltoDePagina'><span style='color:white'>CONTINUACIÓN INFORME ACADÉMICO DE ".
								$nombre_estudiante." $corte</span></h1>";
					}
				}
				$numest--;
				if ( $par!=0 and $numest==0 and $pagina>1){
					echo "<h1 class='SaltoDePagina'><span style='color:white'>CONTINUACIÓN INFORME ACADÉMICO DE ".
								strtoupper($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
								$records1['apellido2'])." $corte</span></h1>";
				}elseif($pagina==1 and $numest==0){
					echo "<h1 class='SaltoDePagina'><span style='color:white'>CONTINUACIÓN INFORME ACADÉMICO DE ".
								$nombre_estudiante." $corte</span></h1>";
				}

				
				
				

				
				//-------------------------------FIN LADO B------------------------------------------------  
			}
			
			
			
	}else{
		echo "No se pueden Generar Boletines por que no existen rango de notas para el año lectivo $aniolect <br/> para configurar presione <a href='../../configuration.php'>aqui</a>";
	}
	$conx->close_conex();
}	
?>

</body>
</html>