﻿<?php
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
//aula
$sqlaaula = "SELECT descripcion, idaula, grado, grupo, jornada FROM aula WHERE idaula = $idaula";
$consultaaula = $conx->query($sqlaaula);    
$recordsaula = $conx->records_array($consultaaula);
if($recordsaula['jornada']=="M"){
	$jornada="MAÑANA";
}else{
	$jornada="TARDE";
}
$grado2=utf8_encode($recordsaula['descripcion'])."-".$recordsaula['grupo']."-".$jornada;
$grado=$recordsaula['grado'];
$idaula=$recordsaula['idaula'];
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
<body>
<div>
<?php
//include("../../class/phpdocx/classes/createDocx.inc");
//$docx = new CreateDocx();
$text = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, ' .
'sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut ' .
'enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut' .
'aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit ' .
'in voluptate velit esse cillum dolore eu fugiat nulla pariatur. ' .
'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui ' .
'officia deserunt mollit anim id est laborum.';
$paramsText = array(
'b' => 'single',
'font' => 'Arial'
);

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
				utf8_encode($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".$records1['apellido2']));
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
					$lineasxhoja=61;
				}elseif($papel=='legal'){
					$lineasxhoja=80;
				}else{
					$lineasxhoja=61;
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
				$lineaspie=14;
				$totallineas=($numareas*2)+($numasig*3)+$lineascabezera+$lineaspie+$numlineasind+$numlineasobs;
				$pagina=1;
				$totalpages=$totallineas/$lineasxhoja;
				if($totalpages<=1.25){$numapaginas=1;}else{$numapaginas=ceil($totallineas/($lineasxhoja));}
				if($numapaginas>1){
					$lineasextras=$numapaginas*4;
					$totallineas+=$lineasextras;
					$numapaginas=ceil($totallineas/($lineasxhoja));
				}
				$lineasimpresas=$lineascabezera;
				if($periodo<3){$spansem=2;}else{$spansem=4;}
				$colspan=4+$spansem+$periodo;
				$colspanNV=0;
				
            	while($recordsarea = $conx->records_array($consultaarea)){
					for($i=1; $i<=$periodo; $i++){
						$sqlrecordNV = "SELECT DISTINCT mt.nombre_materia
						FROM materia mt
						LEFT JOIN  notas n  ON mt.idmateria=n.idmateria
						WHERE n.idestudiante=".$records1['idestudiante']." 
						AND mt.idarea_fk=".$recordsarea['idarea']." AND n.periodo=$i  AND n.aniolectivo=$aniolect 
						AND n.tipo_nota='N'";
						$consultsqlrecordNV = $conx->query($sqlrecordNV);
						$colspanNV = $conx->get_numRecords($consultsqlrecordNV);
						
					}
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
					}else{
						echo "<br/><table class='area'>
						<tr >
						<th class='fonttitle7'   style='' colspan='$colspanArea' >".
							strtoupper(utf8_encode($recordsarea['nomarea']))."
						</th>
						</tr>";
					}
					
					$lineasimpresas++;
					$sql = "SELECT DISTINCT m.nombre_materia, n.*
					FROM materia m
					LEFT JOIN notas n ON m.idmateria=n.idmateria
					WHERE n.aniolectivo=$aniolect
					AND n.tipo_nota='R'
					AND n.periodo=$periodo
					AND m.idarea_fk='".$recordsarea['idarea']."' 
					AND n.idestudiante='".$records1['idestudiante']."' 
					ORDER BY m.nombre_materia ASC";
					$consulta2 = $conx->query($sql);
					
					while($records2 = $conx->records_array($consulta2)){
						//docente que tiene la materia 
						$idmateria=$records2['idmateria'];
						$sqld = "SELECT DISTINCT c.ih, c.porc_valorativo, d. * 
						FROM clase c
						LEFT JOIN docente d ON c.iddocente = d.iddocente
						WHERE c.idmateria=  '".$records2['idmateria']."'
						AND c.idaula = $idaula
						AND c.aniolectivo =  $aniolect
						AND c.periodos LIKE '%$periodo%'
						LIMIT 1";
						$consultad = $conx->query($sqld);
						$recordsd = $conx->records_array($consultad);
						$docente = $recordsd['nombre1']." ".$recordsd['nombre2']." ".$recordsd['apellido1']." ".$recordsd['apellido2'];
						$docente= utf8_encode($docente);
						$ih = $recordsd['ih'];
						$iddocente = $recordsd['iddocente'];
						$fj=$records2['fj'];
						$fsj=$records2['fsj'];
						//$vn=$records2['vn'];
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
							echo "<table class='area'>";
							echo "<tr class='asignatura'>
							<td width='*%' ><strong>ASIGNATURA:</strong> ".strtoupper(utf8_encode($records2['nombre_materia']))."
							<br/><strong>DOCENTE:</strong> ".strtoupper($docente)."</td>
							<td width='3%' style='text-align:center; '><strong>I.H</strong><br/> $ih</td>
							<td width='3%' style='text-align:center; '><strong>A.J</strong><br/> $fj</td>
							<td width='3%' style='text-align:center; '><strong>A.S.J</strong><br/> $fsj</td>";
							$promedioAcomulado=0;
							if($periodo<5){
								$vnSuma=0;
								for($i=1; $i<=$periodo; $i++){
									$sqlrecord = "SELECT DISTINCT n.vn 
									FROM notas n
									LEFT JOIN materia mt ON n.idmateria=mt.idmateria 
									WHERE n.idestudiante=".$records1['idestudiante']." 
									AND n.idmateria='".$records2['idmateria']."' AND n.periodo=$i  AND n.aniolectivo=$aniolect 
									AND n.tipo_nota='R'";
									$consultarecord = $conx->query($sqlrecord);
									if($recordsperiodo = $conx->records_array($consultarecord)){
										//$promedioAcomulado+=number_format((float)$recordsperiodo['vn'],1,".",",");
										switch($i){
											case 1:
											case 3:	$corte2='1 C'; break;
											case 2:
											case 4:	$corte2='2 C'; break;
										}
										
										echo "<td width='3%' valign='center' style='text-align:center;'><strong>$corte2</strong><br/>".number_format((float)$recordsperiodo['vn'],1,".",",")."</td>";
									}else{
										echo "<td width='3%'></td>";
									}
									$sqlrecordNV = "SELECT DISTINCT n.vn 
									FROM notas n
									LEFT JOIN materia mt ON n.idmateria=mt.idmateria 
									WHERE n.idestudiante=".$records1['idestudiante']." 
									AND n.idmateria='".$records2['idmateria']."' AND n.periodo=$i  AND n.aniolectivo=$aniolect 
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
										if(number_format((float)$recordsperiodoNV['vn'],1,".",",") > number_format((float)$recordsperiodo['vn'],1,".",",") ){
											$vnSuma+=number_format((float)$recordsperiodoNV['vn'],1,".",",");
										}
										
										echo "<td width='3%' valign='center' style='text-align:center;'><strong>$corte2</strong><br/>".number_format((float)$recordsperiodoNV['vn'],1,".",",")."</td>";
									}else{
										$vnSuma+=number_format((float)$recordsperiodo['vn'],1,".",",");
									}
									if($i==2){
										//$promedioFinal=number_format((float)$promedioAcomulado/$periodo,1,".",",");
										//$promedioFinal=promedioAnioAlg2Materia($records1['idestudiante'], $idaula, $aniolect, 1, $i,$records2['idmateria']);
										$promedioFinal=number_format((float)($vnSuma/$i),1,".",",");
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
									}elseif($periodo==1 and $periodo==$i){
										//$promedioFinal=promedioAnioAlg2Materia($records1['idestudiante'], $idaula, $aniolect, 1, $i,$records2['idmateria']);
										$promedioFinal=number_format((float)($vnSuma/$i),1,".",",");
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
									if($i==4){
										//$promedioFinal=number_format((float)$promedioAcomulado/$periodo,1,".",",");
										//$promedioFinal=promedioAnioAlg2Materia($records1['idestudiante'], $idaula, $aniolect, 3, 4,$records2['idmateria']);
										$promedioFinal=number_format((float)($vnSuma/2),1,".",",");
										$vnsuma=0;
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
									}elseif($periodo==3 and $periodo==$i){
										//$promedioFinal=promedioAnioAlg2Materia($records1['idestudiante'], $idaula, $aniolect, 3, $i,$records2['idmateria']);
										$promedioFinal=number_format((float)($vnSuma/1),1,".",",");
										$vnsuma=0;
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
							$lineasimpresas=4;
						}else{
							echo "<tr class='asignatura'>
							<td width='*%' ><strong>ASIGNATURA:</strong> ".strtoupper(utf8_encode($records2['nombre_materia']))."
							<br/><strong>DOCENTE:</strong> ".strtoupper($docente)."</td>
							<td width='3%' style='text-align:center; '><strong>I.H</strong><br/> $ih</td>
							<td width='3%' style='text-align:center; '><strong>A.J</strong><br/> $fj</td>
							<td width='3%' style='text-align:center; '><strong>A.S.J</strong><br/> $fsj</td>";
							$promedioAcomulado=0;
							if($periodo<5){
								for($i=1; $i<=$periodo; $i++){
									$sqlrecord = "SELECT DISTINCT n.vn 
									FROM notas n
									LEFT JOIN materia mt ON n.idmateria=mt.idmateria 
									WHERE n.idestudiante=".$records1['idestudiante']." 
									AND n.idmateria='".$records2['idmateria']."' AND n.periodo=$i  AND n.aniolectivo=$aniolect 
									AND n.tipo_nota='R'";
									$consultarecord = $conx->query($sqlrecord);
									if($recordsperiodo = $conx->records_array($consultarecord)){
										//$promedioAcomulado+=number_format((float)$recordsperiodo['vn'],1,".",",");
										switch($i){
											case 1:
											case 3:	$corte2='1 C'; break;
											case 2:
											case 4:	$corte2='2 C'; break;
										}
										echo "<td width='3%' valign='center' style='text-align:center;'><strong>$corte2</strong><br/>".number_format((float)$recordsperiodo['vn'],1,".",",")."</td>";
									}else{
										echo "<td width='3%'></td>";
									}
									$sqlrecordNV = "SELECT DISTINCT n.vn 
									FROM notas n
									LEFT JOIN materia mt ON n.idmateria=mt.idmateria 
									WHERE n.idestudiante=".$records1['idestudiante']." 
									AND n.idmateria='".$records2['idmateria']."' AND n.periodo=$i  AND n.aniolectivo=$aniolect 
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
									if($i==2){
										//$promedioFinal=number_format((float)$promedioAcomulado/$periodo,1,".",",");
										$promedioFinal=promedioAnioAlg2Materia($records1['idestudiante'], $idaula, $aniolect, 1, $i,$records2['idmateria']);
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
									}elseif($periodo==1 and $periodo==$i){
										$promedioFinal=promedioAnioAlg2Materia($records1['idestudiante'], $idaula, $aniolect, 1, $i,$records2['idmateria']);
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
									if($i==4){
										//$promedioFinal=number_format((float)$promedioAcomulado/$periodo,1,".",",");
										$promedioFinal=promedioAnioAlg2Materia($records1['idestudiante'], $idaula, $aniolect, 3, 4,$records2['idmateria']);
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
									}elseif($periodo==3 and $periodo==$i){
										$promedioFinal=promedioAnioAlg2Materia($records1['idestudiante'], $idaula, $aniolect, 3, $i,$records2['idmateria']);
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
						}
						$lineasimpresas+=2;
						///seleccionando indicadores escogidos por el docenbte en esta area y curso
						/*$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
						pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
						FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
						(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
						and pc.estandarbc=ebc.codigo
						and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolect
						and eb.periodo =$periodo and eb.iddocente =$iddocente and eb.grado ='$grado'
						and ebc.idmateria_fk=m.idmateria and m.idarea_fk='".$recordsarea['idarea']."'
						ORDER BY consecutivo DESC";*/
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
									font-style: normal; fon-size:12px' colspan='$colspan2' rowspan=''>".(utf8_encode($rowind['competencia']))."</td>";
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
									font-style: normal; fon-size:12px' colspan='$colspan2'>".(utf8_encode($rowind['competencia']))."</td>";
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
						FROM clase c
						LEFT JOIN docente d ON c.iddocente = d.iddocente
						WHERE c.idmateria=49
						AND c.idaula = $idaula
						AND c.aniolectivo =  $aniolect
						AND c.periodos LIKE '%$periodo%'
						LIMIT 1";
						$consultad = $conx->query($sqld);
						$recordsd = $conx->records_array($consultad);
						$docente = utf8_encode($recordsd['nombre1']." ".$recordsd['nombre2']." ".$recordsd['apellido1']." ".$recordsd['apellido2']);;
						$iddocente = $recordsd['iddocente'];
						echo "<tr><th colspan='3'>".utf8_encode($records2['nombre_materia'])."</th></tr>";
						echo "<tr class='asignatura'>
						<td width='400px' colspan='3'><strong>DINAMIZADOR(A):</strong> ".strtoupper($docente)."</td>";
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
									font-style: normal; fon-size:12px' colspan='$colspan2' rowspan='' width='80%>".(utf8_encode($rowind['competencia']))."</td>";
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
									font-style: normal;' colspan='$colspan2'>".(utf8_encode($rowind['competencia']))."</td>";
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
							<td  width='30%' align='center' class='Estilo1'>".strtoupper(utf8_encode($recordsog['nombre_materia']))."</td>
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
				$docentedg= utf8_encode($docentedg);
				if($periodo==4){
					echo 
					"<div style='line-height:7px;'>
					<br/><br/><br/><br/><br/><br/><br/>
							<tr>
								<td width='50%' align='center'>
									<span align='center' class='blocktext' style='text-decoration:overline; font-weight:bold' >Padre de Familia o Acudiente</span>
								</td>
								<td align='center'>
									<span class='blocktext' style='text-decoration:overline; font-weight:bold'>$docentedg</span>
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
				//echo "</div><br/><span style='text-align:right; margin-left:810px; position:relative;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
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
			
			
	}if($formato=="f4"){
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
							LEFT JOIN matricula m ON e.idestudiante=m.idestudiante
							LEFT JOIN notas n ON m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo AND m.tipo_matricula=n.tipo_nota
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

        	$consultaest = $conx->query($sqlest);
			$numest = $conx->get_numRecords($consultaest);
			$totalest = $conx->get_numRecords($consultaest);
			//
			$tabla_promedios=tabla_promedios_con_comportamiento($idaula, $aniolect, $periodo);
            while($records1 = $conx->records_array($consultaest)){
				$msjBoletin= ($totalest-$numest)+1;
				echo "<script>$('#boletingenerado').text($msjBoletin); $('#totalboletines').text($totalest);</script>";
				$contmat=0;
            	switch($periodo){
					case 1: $corte="1ER TRIMESTRE"; break;
					case 2: $corte="2DO TRIMESTRE"; break;							
					case 3: $corte="3ER TRIMESTRE"; break;
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
				$promedioperiodo=promedio_periodo_con_comportamiento($records1['idestudiante'], $idaula, $aniolect, $periodo);
				$puestoperiodo=array_search($promedioperiodo,$tabla_promedios)+1;
				$nombre_estudiante=strtoupper(
				utf8_encode($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".$records1['apellido2']));
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
				$sql_area_asignatura="SELECT DISTINCT a.idmateria, ar.idarea, ar.nomarea, a.nombre_materia, concat_ws(' ', d.nombre1, d.nombre2, d.apellido1, d.apellido2) AS nombre_docente, c.ih, n.idestudiante, n.vn, n.periodo, n.fj, n.fsj, n.observaciones, n.aniolectivo FROM clase c 
				JOIN materia a ON c.idmateria=a.idmateria AND c.idmateria!=49 AND c.aniolectivo='$aniolect' AND c.idaula='$idaula' AND c.periodos LIKE '%$periodo%'
				JOIN notas n ON a.idmateria=n.idmateria AND n.periodo=1 AND n.tipo_nota='R' AND n.aniolectivo=c.aniolectivo AND n.idestudiante='".$records1['idestudiante']."'
				JOIN matricula m ON m.idestudiante=n.idestudiante AND n.tipo_nota=m.tipo_matricula AND n.aniolectivo=m.aniolectivo AND m.idaula=c.idaula
				JOIN area ar ON ar.idarea=a.idarea_fk
				JOIN docente d ON c.iddocente=d.iddocente  
				ORDER BY ar.nomarea, a.nombre_materia  DESC";
				$consulta_area_asignatura = $conx->query($sql_area_asignatura);
				$id_area="";
				while($fila_asignatura = $conx->records_array($consulta_area_asignatura)){
				
					if($fila_asignatura['idarea']!=$id_area){
						echo "<br/><table class='area'>
						<tr >
						<th class='fonttitle7'   style='' colspan='' >".
							strtoupper(utf8_encode($fila_asignatura['nomarea']))."
						</th>
						</tr></table>";
						$id_area=$fila_asignatura['idarea'];
					}
					echo "<table class='area'>";
					echo "<tr class='asignatura'>
						<td width='*%' ><strong>ASIGNATURA:</strong> ".strtoupper(utf8_encode($fila_asignatura['nombre_materia']))."
						<br/><strong>DOCENTE:</strong> ".strtoupper(utf8_encode($fila_asignatura['nombre_docente']))."</td>
						<td width='3%' style='text-align:center; '><strong>I.H</strong><br/> ".$fila_asignatura['ih']."</td>
						<td width='3%' style='text-align:center; '><strong>A.J</strong><br/> ".$fila_asignatura['fj']."</td>
						<td width='3%' style='text-align:center; '><strong>A.S.J</strong><br/> ".$fila_asignatura['fsj']."</td>";
						
					$sql_notas="SELECT notas.vn, notas.periodo FROM notas WHERE notas.idestudiante='".$records1['idestudiante']."' 
					AND notas.idmateria='".$fila_asignatura['idmateria']."' AND notas.tipo_nota='R' AND notas.aniolectivo=$aniolect AND notas.periodo<=$periodo";
					$consulta_notas = $conx->query($sql_notas);
					$promedio_asignatura=0;
					$nota_asignatura=$fila_asignatura['vn'];
					if($nota_asignatura >= (float)$rcbamin and $nota_asignatura <= (float)$rcbamax){
						$desempeno_asignatura="Dba"; 
					}elseif($nota_asignatura >= (float)$rcbmin and $nota_asignatura <= (float)$rcbmax){
						$desempeno_asignatura="DB";
					}elseif($nota_asignatura >= (float)$rcamin and $nota_asignatura <= (float)$rcamax){
						$desempeno_asignatura="DA";
					}elseif($nota_asignatura >= (float)$rcsmin and $nota_asignatura <= (float)$rcsmax){
						$desempeno_asignatura="DS";
					}
					while($fila_notas = $conx->records_array($consulta_notas)){
						$promedio_asignatura+=$fila_notas['vn'];
						echo "<td width='3%' valign='center' style='text-align:center;'><strong>".$fila_notas['periodo']." T</strong><br/>".number_format((float)$fila_notas['vn'],1,".",",")."</td>";
					}
					$promedio_asignatura=round(($promedio_asignatura/$periodo),1);
					
					echo "<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>$desempeno_asignatura</strong></td>";
					echo "<td width='6%' nowrap valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>PARCIAL</strong><br>".number_format((float)$promedio_asignatura,1,".",",")."</td>";
					echo "</tr>";
					
					echo "<tr><td style='border-top: 1px solid black;' colspan='".($periodo+4)."' ><strong>COMPETENCIAS $corte</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>FORTALEZA</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>DEBILIDAD</strong></td></tr>";
					//consultando competencias 
					$sql_competencias="SELECT DISTINCT i.idmateria, p.competencia, i.DS, i.DA, i.DB, i.DBA FROM plan_curricular p 
										JOIN indicadoresboletin i ON p.consecutivo=i.idindicador AND i.aniolectivo='$aniolect' AND i.periodo=$periodo AND i.idmateria='".$fila_asignatura['idmateria']."'
										JOIN aula a ON i.grado=a.grado AND a.idaula='$idaula'";
					$consulta_competencias = $conx->query($sql_competencias);
					
					while($fila_competencia = $conx->records_array($consulta_competencias)){
						
						echo "<tr>";
						echo "<td align='left' style='font-family: \"Courier New\", Courier, monospace;
						font-style: normal; fon-size:12px' colspan='".($periodo+4)."'>".(utf8_encode($fila_competencia['competencia']))."</td>";
						switch($desempeno_asignatura){
							case 'DS': $nivel_aprendizaje= $fila_competencia['DS']; break;
							case 'DA': $nivel_aprendizaje= $fila_competencia['DA']; break;
							case 'DB': $nivel_aprendizaje= $fila_competencia['DB']; break;
							case 'Dba': $nivel_aprendizaje= $fila_competencia['DBA']; break;
						}
						
						
						if($nivel_aprendizaje==='F'){
							echo "<td width='6%' align='center' ><img src='../../images/F.png' width='15' height='15' ></img></td><td></td>";
						}else{
							echo "<td></td><td width='6%' align='center'><img src='../../images/D.png' width='15' height='15'></img></td>";
						}
						echo "</tr>";
					}
					echo "</table>";
				}	
				$conx->result_free($consulta_area_asignatura);				
				//Generar resultados comportamiento
				$sql_area_asignatura="SELECT DISTINCT a.idmateria, ar.idarea, ar.nomarea, a.nombre_materia, concat_ws(' ', d.nombre1, d.nombre2, d.apellido1, d.apellido2) AS nombre_docente, c.ih, n.idestudiante, n.vn, n.periodo, n.fj, n.fsj, n.observaciones, n.aniolectivo FROM clase c 
				JOIN materia a ON c.idmateria=a.idmateria AND c.idmateria=49 AND c.aniolectivo='$aniolect' AND c.idaula='$idaula' AND c.periodos LIKE '%$periodo%'
				JOIN notas n ON a.idmateria=n.idmateria AND n.periodo=1 AND n.tipo_nota='R' AND n.aniolectivo=c.aniolectivo AND n.idestudiante='".$records1['idestudiante']."'
				JOIN matricula m ON m.idestudiante=n.idestudiante AND n.tipo_nota=m.tipo_matricula AND n.aniolectivo=m.aniolectivo AND m.idaula=c.idaula
				JOIN area ar ON ar.idarea=a.idarea_fk
				JOIN docente d ON c.iddocente=d.iddocente  
				ORDER BY ar.nomarea, a.nombre_materia  DESC";
				$consulta_area_asignatura = $conx->query($sql_area_asignatura);
				while($fila_asignatura = $conx->records_array($consulta_area_asignatura)){
					$nota_asignatura=$fila_asignatura['vn'];
					if($nota_asignatura >= (float)$rcbamin and $nota_asignatura <= (float)$rcbamax){
						$desempeno_asignatura="Dba"; 
					}elseif($nota_asignatura >= (float)$rcbmin and $nota_asignatura <= (float)$rcbmax){
						$desempeno_asignatura="DB";
					}elseif($nota_asignatura >= (float)$rcamin and $nota_asignatura <= (float)$rcamax){
						$desempeno_asignatura="DA";
					}elseif($nota_asignatura >= (float)$rcsmin and $nota_asignatura <= (float)$rcsmax){
						$desempeno_asignatura="DS";
					}
						echo "<br/><table class='area'>
						<tr >
						<th class='fonttitle7'   style='' colspan='' >".
							strtoupper(utf8_encode($fila_asignatura['nombre_materia']))."
						</th>
						</tr></table>";
					echo "<table class='area'>";
					echo "<tr class='asignatura'>
						<td width='*%' colspan='".($periodo+4)."' ><strong>DINAMIZADOR:</strong> ".strtoupper(utf8_encode($fila_asignatura['nombre_docente']))."</td>
						<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>$desempeno_asignatura</strong></td>
						<td width='6%' nowrap valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>".number_format((float)$nota_asignatura,1,".",",")."</strong></td>";
					echo "</tr>";
					
					echo "<tr><td style='border-top: 1px solid black;' colspan='".($periodo+4)."' ><strong>ACTITUDES $corte</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>FORTALEZA</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>DEBILIDAD</strong></td></tr>";
					//consultando competencias 
					$sql_competencias="SELECT DISTINCT i.idmateria, p.competencia, i.DS, i.DA, i.DB, i.DBA FROM plan_curricular p 
										JOIN indicadoresboletin i ON p.consecutivo=i.idindicador AND i.aniolectivo='$aniolect' AND i.periodo=$periodo AND i.idmateria='".$fila_asignatura['idmateria']."'
										JOIN aula a ON i.grado=a.grado AND a.idaula='$idaula'";
					$consulta_competencias = $conx->query($sql_competencias);
					
					while($fila_competencia = $conx->records_array($consulta_competencias)){
						
						echo "<tr>";
						echo "<td align='left' style='font-family: \"Courier New\", Courier, monospace;
						font-style: normal; fon-size:12px' colspan='".($periodo+4)."'>".(utf8_encode($fila_competencia['competencia']))."</td>";
						switch($desempeno_asignatura){
							case 'DS': $nivel_aprendizaje= $fila_competencia['DS']; break;
							case 'DA': $nivel_aprendizaje= $fila_competencia['DA']; break;
							case 'DB': $nivel_aprendizaje= $fila_competencia['DB']; break;
							case 'Dba': $nivel_aprendizaje= $fila_competencia['DBA']; break;
						}
						
						
						if($nivel_aprendizaje==='F'){
							echo "<td width='6%' align='center' ><img src='../../images/F.png' width='15' height='15' ></img></td><td></td>";
						}else{
							echo "<td></td><td width='6%' align='center'><img src='../../images/D.png' width='15' height='15'></img></td>";
						}
						echo "</tr>";
					}
					echo "</table>";
				}
				//$conx->result_free($consulta_area_asignatura);
				$numest--;	
				echo "<h1 class='SaltoDePaginaTimestre'></h1>";
							
            }
				
			//$conx->result_free($consultaest);
			
			
			
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
				utf8_encode($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".$records1['apellido2']));
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
							strtoupper(utf8_encode($recordsarea['nomarea']))."
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
						<td width='*%' ><strong>ASIGNATURA:</strong> ".strtoupper(utf8_encode($records2['nombre_materia']))."
						<br/><strong>DOCENTE:</strong> ".strtoupper(utf8_encode($docente))."</td>
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
									utf8_encode($nombre_estudiante)."  $corte</span><br/><br/>";
									echo "<table class='area'><tr><td width='48%'></td>";
									for($i=1; $i<=$periodo+5; $i++){
										
										echo "<td ></td>";
									}
									echo "</tr>";
									echo "<tr>";
									echo "<td align='left' style='font-family: \"Courier New\", Courier, monospace;
									font-style: normal; fon-size:12px' colspan='$colspan2' rowspan=''>".utf8_encode($rowind['competencia'])."</td>";
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
									font-style: normal; fon-size:12px' colspan='$colspan2'>".utf8_encode($rowind['competencia'])."</td>";
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
						<td width='400px' colspan='3'><strong>DINAMIZADOR(A):</strong> ".strtoupper(utf8_encode($docente))."</td>";
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
									font-style: normal; fon-size:12px' colspan='$colspan2' rowspan=''>".utf8_encode($rowind['competencia'])."</td>";
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
									font-style: normal;' colspan='$colspan2'>".utf8_encode($rowind['competencia'])."</td>";
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
							<td  width='30%' align='center' class='Estilo1'>".strtoupper(utf8_encode($recordsog['nombre_materia']))."</td>
						   <td align='left' valign='top' style='line-height:15px; text-align:justify; font-family: \"Courier New\", Courier, monospace;
									font-style: normal;'>
							<span class='' >".utf8_decode(String_oracion($observaciones))."</span>&nbsp;
							</td>
							</tr>";
							$lineasimpresas=4;
						}else{
							echo "<tr>
							<td  class='Estilo1'>".strtoupper(utf8_encode($recordsog['nombre_materia']))."</td>
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
				$docentedg= utf8_encode($docentedg);
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
			
			
	}

	
}else{
    echo "No se pueden Generar Boletines por que no existen rango de notas para el año lectivo $aniolect <br/> para configurar presione <a href='../../configuration.php'>aqui</a>";
}
	$conx->close_conex();	
?>

</body>
</html>