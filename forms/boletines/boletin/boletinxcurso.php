<html>
<head>
<title>-CTMATT-</title>
<link  href="http://fonts.googleapis.com/css?family=Cabin+Sketch:bold" rel="stylesheet" type="text/css" >
<link  href="http://fonts.googleapis.com/css?family=Lobster:regular" rel="stylesheet" type="text/css" >
<link  href="http://fonts.googleapis.com/css?family=Tangerine:regular,bold" rel="stylesheet" type="text/css" >

<link rel="stylesheet" type="text/css" href="../../css/listcurso.css" media="all">
</head>
<body>
<div class="cabecera1">
<?php
include('../../class/MySqlClass.php');
$conx = new ConxMySQL("localhost","root","","bdaltono");
//mysql_set_charset('utf8',$conx->conexion);
$grado = utf8_decode($_POST['grado']);
$periodo= $_POST['periodo'];
$formato= trim($_POST['formato']);
$aniolect= trim($_POST['aniolect']);
function String_oracion($string){
 $stringReturn="";
 $arraySplit = explode('.', $string);
 for($i=0; $i<count($arraySplit); $i++){
	
	$arraySplit[$i]=ucfirst($arraySplit[$i]);
 }
 $stringReturn = implode(".", $arraySplit);
 return $stringReturn;
}
if($formato=="f1"){
//-------------------------------------------------------LADO A------------------------------------
$sql = "SELECT DISTINCT e.a1, e.a2, e.n1, e.n2, m.grado, e.codest FROM tbestudiante e, tbnotas n, matricula m 
	WHERE e.codest=n.codest_fk AND m.grado='$grado' AND e.estado='ACT' AND n.periodo=$periodo AND n.aniolect=$aniolect 
    AND m.codest_fk=n.codest_fk AND n.aniolect=m.aniolect ORDER BY e.a1, e.a2, e.n1, e.n2 DESC";
	$consulta1 = $conx->query($sql);
	while($records1 = $conx->records_array($consulta1)){

	echo "<div style='line-height:7px; '><br/><br/><br/><br/>
							<span class='Estilo2 blocktext' align='center'>Colegio&nbsp;&nbsp;T&eacute;cnico&nbsp;&nbsp;Militar </span><br/><br/><br/>
							<span class='Estilo4c blocktext' align='center'>&quot;Almirante Tono Tumaco S.A.S&quot;</span><br/>
							<span class='Estilo1 blocktext' align='center'>Nit: 900.300282-2</span><br/>
							<span class='Estilo1 blocktext' align='center'>EDUCACI&Oacute;N PREESCOLAR, BASICA Y MEDIA</span><br/>
							<span class='Estilo1 blocktext' align='center'>Resoluci&oacute;n Ministerio de Educaci&oacute;n Nacional</span><br/>
							<span class='Estilo1 blocktext' align='center'>Secretaria de Educaci&oacute;n Municipal N&deg; 1002 de Dic. 22 de 2009</span><br/>
							<span class='Estilo1 blocktext' align='center'>Concepto Batall&oacute;n No. 70:00829MDN—CG—CARMA—CIMAR</span><br/>
							<span class='Estilo1 blocktext' align='center'>REG: MERCANTIL: 24033-16</span><br/>
							<span class='Estilo1 blocktext' align='center'>C&oacute;digo DANE: 349935487701 </span><br/>
						  <span align='center' class='blocktext'><img  src='ESCUDO TRASNPARENTE.png' width='80' height='80'/></span>
	<p class='fonttitle6'>INFORME VALORATIVO</p>
	</div>";
	echo "<table class='boletin'>
	<tr >
	<th colspan='14' class='fonttitle7'   style='width:80%'>CADETE:
	<span style='font:12px Lucida Calligraphy;  margin-left:50px; font-weight:bold;'>".$records1['a1']." ".$records1['a2']." ".$records1['n1']." ".$records1['n2']."</span></th>
	<th scope='col' colspan='1' class='fonttitle7' >AÑO ESCOLAR: ".$aniolect."</th>
	</tr>
	<tr >
	<th scope='col' colspan='14' class='fonttitle7' >GRADO: ".$records1['grado']."</th>
	<th scope='col' colspan='1' class='fonttitle7' >PERIODO: $periodo</th>
	</tr>
	</table>
	<table class='boletin'>
	<tr>
	<th scope='col' colspan='6' class='fonttitle8' rowspan='2' style='width:24%'>ASIGNATURAS </th>
	<th scope='col' colspan='2' class='fonttitle4b' >DESEMPEÑO</th>
	<th scope='col' colspan='3' class='fonttitle4b' >FALTAS</th>
	<th scope='col' colspan='4' class='fonttitle8' rowspan='2'>INDICADORES DE DESEMPEÑO </th>
	</tr>
	<tr>
	<td class='fonttitle4b' >V.N
	</td>
	<td class='fonttitle4b' >D
	</td>
	<td class='fonttitle4b' >J
	</td>
	<td class='fonttitle4b' >S.J
	</td>
	<td class='fonttitle4b' >T
	</td>
	</tr>";
	$sql = "SELECT DISTINCT a.nasig, n.* 
	FROM tbasignatura a, tbnotas n WHERE n.codest_fk=".$records1['codest']." AND a.codasig=n.codasig_fk AND periodo='$periodo'  AND aniolect=$aniolect AND a.Tipo='ACA' ORDER BY a.nasig ASC";
	$consulta2 = $conx->query($sql);
	
	$numasig=0;
	$sumDS=0;
	$sumDA=0;
	$sumDB=0;
	$sumDb=0;
	$porcDS=0;
	$porcDA=0;
	$porcDB=0;
	$porcDb=0;

	while($records2 = $conx->records_array($consulta2)){
	$numasig++;
	if($records2['desempeno']=='D-'){
		$desempeno="Db";
	}else{
		$desempeno=$records2['desempeno'];
	}

	switch($records2['comportamiento']){
		case "DS": $sumDS++; break;
		case "DA": $sumDA++; break;
		case "DB": $sumDB++; break;
		case "D-": $sumDb++; break;
		default:
	}
		echo"<tr>
		<td scope='col' colspan='6' class='fonttitle7' >".$records2['nasig']."</td>
		<td scope='col' class='fonttitle9b' >".number_format((float)$records2['vn'],1,".",",")."</td>
		<td scope='col' class='fonttitle9b' >".$desempeno."</td>
		<td scope='col' class='fonttitle9b' >".$records2['fj']."</td>
		<td scope='col' class='fonttitle9b' >".$records2['fsj']."</td>
		<td scope='col' class='fonttitle9b' >".$records2['ft']."</td>
		<td scope='col' colspan='4' class='fonttitle10b' ><div align='justify'>";
		$gradotemp = $records1['grado'];
		
		$sql = "SELECT DISTINCT descripcion 
		FROM tbindcdesempeno WHERE codasig_fk=".$records2['codasig_fk']." AND grado='".$gradotemp."' AND tipo='".$records2['desempeno']."' 
		 AND periodo=".$records2['periodo']." AND estado='HA' AND aniolect=$aniolect";
		$consulta3 = $conx->query($sql);
		while($records3 = $conx->records_array($consulta3)){
		$desc=String_oracion($records3['descripcion']);
		//$desc=ucfirst($desc);
		echo $desc." ";
		}
		echo "
		</div></td>
		</tr>";
		
	}
	$porcDS=round(($sumDS*100)/$numasig);
	$porcDA=round(($sumDA*100)/$numasig);
	$porcDB=round(($sumDB*100)/$numasig);
	$porcDb=round(($sumDb*100)/$numasig);
	$comportamiento="";
	if($porcDS>$porcDA && $porcDS>$porcDB && $porcDS>$porcDb){
		if($porcDS>89 && $porcDS<101){
			$comportamiento="DS";
		}else{
			$comportamiento="DA";
		}
	}else if($porcDA>$porcDS && $porcDA>$porcDB && $porcDA>$porcDb){
		if($porcDA>49 && $porcDA<101){
			$comportamiento="DA";
		}else{
			$comportamiento="DB";
		}
	}else if($porcDB>$porcDS && $porcDB>$porcDA && $porcDB>$porcDb){
			$comportamiento="DB";
	}else if($porcDb>$porcDS && $porcDb>$porcDA && $porcDb>$porcDB){
		if($porcDb>60 && $porcDb<101){
			$comportamiento="Db";
		}else{
			$comportamiento="DB";
		}
	}
	if($comportamiento==""){
		$comportamiento="DB";
	}

	echo "<tr>
		<td scope='col' colspan='6' class='fonttitle7' >COMPORTAMIENTO</td>
		<td scope='col' colspan='10	' class='fonttitle8' >$comportamiento</td>
		</tr>";
	$sql3 = "SELECT DISTINCT descripcion 
		FROM tbcomportamiento WHERE tipo='$comportamiento' ORDER BY descripcion ASC";
		$consulta3 = $conx->query($sql3);
	echo "<tr>
		<td scope='col' colspan='16' style='text-align:left; font:12px 	arial,sans-serif;'><span style='font:12px bold 	arial,sans-serif; font-weight:bold;'>OBSERVACIONES:</span> ";
		while($records4 = $conx->records_array($consulta3)){
		echo String_oracion($records4['descripcion'])." ";
		
		}
	$sqlTasig = "SELECT DISTINCT codasig_fk FROM `tbasign_asignatura` WHERE `grado`='$grado'";
	$consultaTasig= $conx->query($sqlTasig);
	$numasigProm= $conx->get_numRecords($consultaTasig);
	$sqlpuesto = "SELECT AVG( vn ) AS promedio, SUM( vn ) AS sumnotas, `codest_fk` 
	FROM tbnotas, tbestudiante WHERE grado='$grado' AND codest_fk=codest AND periodo='$periodo' AND estado='ACT'
    AND aniolect=$aniolect 
	GROUP BY codest_fk
	ORDER BY promedio DESC";
	$sqlpuestoanio = "SELECT ROUND(AVG( vn ),3) AS promedio, SUM( vn ) AS sumnotas, `codest_fk`, tbestudiante.n1, tbestudiante.a1"
    . "	FROM tbnotas, tbestudiante WHERE grado='$grado' AND codest_fk=codest AND estado='ACT'"
    . "	AND aniolect=$aniolect GROUP BY codest_fk"
    . "	ORDER BY promedio DESC";
	$consultapuesto = $conx->query($sqlpuesto);
	$consultapuestoanio = $conx->query($sqlpuestoanio);
	$puesto=1;
	$puestoanio=1;
	$numest= $conx->get_numRecords($consultapuesto);
	$notaEstAnt=0;
	while($recordspuesto = $conx->records_array($consultapuesto)){
		if(!($records1['codest']==$recordspuesto['codest_fk'])){
			$puesto++;
		}else{
			if($periodo=='1' or $periodo=='2'){
				$promedio=$recordspuesto['sumnotas']/($numasigProm-1);
			}else{
				$promedio=$recordspuesto['promedio'];
			}
			break;
		}
	}
	if($periodo=4){
		while($recordspuestoanio = $conx->records_array($consultapuestoanio)){
			if(!($records1['codest']==$recordspuestoanio['codest_fk'])){
				$puestoanio++;
			}else{
				$promedioanio=$recordspuestoanio['promedio'];
				break;
			}
		}
	}

	echo "
		</td>
		</tr>";
	if($periodo=4){
		echo "<tr><td scope='col' colspan='11' style='text-align:left; font:12px 	arial,sans-serif;' rowspan='2'>
		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >PROMEDIO GENERAL PERIODO:</span> ".number_format((float)$promedio,2,".",",")." 
		<span style='font:12px bold 	arial,sans-serif; font-weight:bold; ' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPUESTO: </span>$puesto
		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >DE</span> $numest</td>
		<td scope='col' colspan='5' style='text-align:left; font:12px 	arial,sans-serif;' rowspan='2'>
		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >PROMEDIO GENERAL AÑO LECTIVO:</span> ".number_format((float)$promedioanio,3,".",",")." 
		<span style='font:12px bold 	arial,sans-serif; font-weight:bold; ' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPUESTO: </span>$puestoanio
		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >DE</span> $numest</td></tr>";
	}else{
	
		echo "<tr><td scope='col' colspan='11' style='text-align:left; font:12px 	arial,sans-serif;' rowspan='2'>
		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >PROMEDIO GENERAL PERIODO:</span> ".number_format((float)$promedio,2,".",",")." 
		<span style='font:12px bold 	arial,sans-serif; font-weight:bold; ' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPUESTO: </span>$puesto
		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >DE</span> $numest</td></tr>";
	}

	echo "</table><br/><br/>";
	/*echo "<table class='tabledes' style='floar:left;'>
	  
	  <tr>
		<td colspan='8' class='fonttitle4'><div align='center'>CONVENCIONES</div></td>
	  </tr>
	  <tr>
		<td class='fonttitle4'><div align='center'>D</div></td>
		<td class='fonttitle5'>DESEMPEÑO</td>
		<td class='fonttitle4'>V.N</div></td>
		<td class='fonttitle5'>VALORACIÓN NÚMERICA</td>
		<td class='fonttitle4'>J</div></td>
		<td class='fonttitle5' colspan='3'>FALTAS JUSTIFICADAS</td>
	  </tr>
	  <tr>
		<td class='fonttitle4'>S.J</div></td>
		<td class='fonttitle5' >FALTAS SIN JUSTIFICAR</td>
		<td class='fonttitle4'>T</td>
		<td class='fonttitle5' >TOTAL FALTAS</td>
		<td class='fonttitle4'>DS</div></td>
		<td class='fonttitle5' colspan='3'>DESEMPEÑO SUPERIOR (4.6 - 5.0)</td>

	  </tr>
	  <tr>
		<td class='fonttitle4'>DA</div></td>
		<td class='fonttitle5' >DESEMPEÑO ALTO (4.0 - 4.5)</td>
		<td class='fonttitle4'>DB</td>
		<td class='fonttitle5' >DESEMPEÑO BÁSICO (3.0 - 3.9)</td>
		<td class='fonttitle4'>Db</div></td>
		<td class='fonttitle5' colspan='3'>DESEMPEÑO BAJO (1.0 - 2.9)</td>
	  </tr>
	 </table>";*/
	$sql4 = "SELECT * 
	FROM  `tbasign_asignatura` , tbdocente
	WHERE  `coddocen_fk` = codigo
	AND  `grado` =  '$grado'
	AND  `dg` =  'S'";
	$consulta4 = $conx->query($sql4);
	$records4 = $conx->records_array($consulta4);
	$dg = $records4['n1']." ". $records4['n2']." ".$records4['a1']." ".$records4['a2'];
	//echo "<hr class='linea'>";
	echo "<div class='pie'>
	<span style='font:15px Lucida Calligraphy, sans-serif; font-weight:bold;'>$dg</span><br/>
	<span style='font:12px bold arial,sans-serif; font-weight:bold;'>DIRECTOR (A) DE GRUPO</span></div><br/>";
	/*echo "<div class='pie'>
	<p>Dirección: calle Sucre Antiguo Colegio Divino Niño - Frente a la Catedral San Andrés<br>Telefono: 7277001 
	<a href='' >www.tumacoaltono.com</a></p>
	</div>";*/
	echo "<h1 class='SaltoDePagina'> </h1>";
	//-------------------------------FIN LADO A------------------------------------------------

    }
}else if($formato=="f2"){
	//-------------------------------------------------------LADO A------------------------------------
	$sql = "SELECT DISTINCT e.a1, e.a2, e.n1, e.n2, m.grado, e.codest FROM tbestudiante e, tbnotas n, matricula m 
	WHERE e.codest=n.codest_fk AND m.grado='$grado' AND e.estado='ACT' AND n.periodo=$periodo AND n.aniolect=$aniolect 
    AND m.codest_fk=n.codest_fk AND n.aniolect=m.aniolect ORDER BY e.a1, e.a2, e.n1, e.n2 DESC";
	$consulta1 = $conx->query($sql);
	while($records1 = $conx->records_array($consulta1)){

	echo "<div style='line-height:7px; '><br/><br/><br/><br/>
							<span class='Estilo2 blocktext' align='center'>Colegio&nbsp;&nbsp;T&eacute;cnico&nbsp;&nbsp;Militar </span><br/><br/><br/>
							<span class='Estilo4c blocktext' align='center'>&quot;Almirante Tono Tumaco S.A.S&quot;</span><br/>
							<span class='Estilo1 blocktext' align='center'>Nit: 900.300282-2</span><br/>
							<span class='Estilo1 blocktext' align='center'>EDUCACI&Oacute;N PREESCOLAR, BASICA Y MEDIA</span><br/>
							<span class='Estilo1 blocktext' align='center'>Resoluci&oacute;n Ministerio de Educaci&oacute;n Nacional</span><br/>
							<span class='Estilo1 blocktext' align='center'>Secretaria de Educaci&oacute;n Municipal N&deg; 1002 de Dic. 22 de 2009</span><br/>
							<span class='Estilo1 blocktext' align='center'>Concepto Batall&oacute;n No. 70:00829MDN—CG—CARMA—CIMAR</span><br/>
							<span class='Estilo1 blocktext' align='center'>REG: MERCANTIL: 24033-16</span><br/>
							<span class='Estilo1 blocktext' align='center'>C&oacute;digo DANE: 349935487701 </span><br/>
						  <span align='center' class='blocktext'><img  src='ESCUDO TRASNPARENTE.png' width='80' height='80'/></span>
	<p class='fonttitle6'>INFORME VALORATIVO</p>
	</div>";
	echo "<table class='boletin'>
	<tr >
	<th colspan='14' class='fonttitle7'   style='width:80%'>CADETE:
	<span style='font:12px Lucida Calligraphy;  margin-left:50px; font-weight:bold;'>".$records1['a1']." ".$records1['a2']." ".$records1['n1']." ".$records1['n2']."</span></th>
	<th scope='col' colspan='1' class='fonttitle7' >AÑO ESCOLAR: ".$aniolect."</th>
	</tr>
	<tr >
	<th scope='col' colspan='14' class='fonttitle7' >GRADO: ".$records1['grado']."</th>
	<th scope='col' colspan='1' class='fonttitle7' >PERIODO: $periodo</th>
	</tr>
	</table>
	<table class='boletin'>
	<tr>
	<th scope='col' colspan='6' class='fonttitle8' rowspan='2' style='width:24%'>ASIGNATURAS </th>
	<th scope='col' colspan='2' class='fonttitle4b' >DESEMPEÑO</th>
	<th scope='col' colspan='3' class='fonttitle4b' >FALTAS</th>
	<th scope='col' colspan='4' class='fonttitle8' rowspan='2'>INDICADORES DE DESEMPEÑO </th>
	</tr>
	<tr>
	<td class='fonttitle4b' >V.N
	</td>
	<td class='fonttitle4b' >D
	</td>
	<td class='fonttitle4b' >J
	</td>
	<td class='fonttitle4b' >S.J
	</td>
	<td class='fonttitle4b' >T
	</td>
	</tr>";
	$sql = "SELECT DISTINCT a.nasig, n.* 
	FROM tbasignatura a, tbnotas n WHERE n.codest_fk=".$records1['codest']." AND a.codasig=n.codasig_fk AND periodo='$periodo'  AND aniolect=$aniolect AND a.Tipo='ACA' ORDER BY a.nasig ASC";
	$consulta2 = $conx->query($sql);
	
	$numasig=0;
	$sumDS=0;
	$sumDA=0;
	$sumDB=0;
	$sumDb=0;
	$porcDS=0;
	$porcDA=0;
	$porcDB=0;
	$porcDb=0;

	while($records2 = $conx->records_array($consulta2)){
	$numasig++;
	if($records2['desempeno']=='D-'){
		$desempeno="Db";
	}else{
		$desempeno=$records2['desempeno'];
	}

	switch($records2['comportamiento']){
		case "DS": $sumDS++; break;
		case "DA": $sumDA++; break;
		case "DB": $sumDB++; break;
		case "D-": $sumDb++; break;
		default:
	}
		echo"<tr>
		<td scope='col' colspan='6' class='fonttitle7' >".$records2['nasig']."</td>
		<td scope='col' class='fonttitle9b' >".number_format((float)$records2['vn'],1,".",",")."</td>
		<td scope='col' class='fonttitle9b' >".$desempeno."</td>
		<td scope='col' class='fonttitle9b' >".$records2['fj']."</td>
		<td scope='col' class='fonttitle9b' >".$records2['fsj']."</td>
		<td scope='col' class='fonttitle9b' >".$records2['ft']."</td>
		<td scope='col' colspan='4' class='fonttitle10b' ><div align='justify'>";
		$gradotemp = $records1['grado'];
		
		$sql = "SELECT DISTINCT descripcion 
		FROM tbindcdesempeno WHERE codasig_fk=".$records2['codasig_fk']." AND grado='".$gradotemp."' AND tipo='".$records2['desempeno']."' 
		 AND periodo=".$records2['periodo']." AND estado='HA' AND aniolect=$aniolect";
		$consulta3 = $conx->query($sql);
		while($records3 = $conx->records_array($consulta3)){
		$desc=String_oracion($records3['descripcion']);
		//$desc=ucfirst($desc);
		echo $desc." ";
		}
		echo "
		</div></td>
		</tr>";
		
	}
	$porcDS=round(($sumDS*100)/$numasig);
	$porcDA=round(($sumDA*100)/$numasig);
	$porcDB=round(($sumDB*100)/$numasig);
	$porcDb=round(($sumDb*100)/$numasig);
	$comportamiento="";
	if($porcDS>$porcDA && $porcDS>$porcDB && $porcDS>$porcDb){
		if($porcDS>89 && $porcDS<101){
			$comportamiento="DS";
		}else{
			$comportamiento="DA";
		}
	}else if($porcDA>$porcDS && $porcDA>$porcDB && $porcDA>$porcDb){
		if($porcDA>49 && $porcDA<101){
			$comportamiento="DA";
		}else{
			$comportamiento="DB";
		}
	}else if($porcDB>$porcDS && $porcDB>$porcDA && $porcDB>$porcDb){
			$comportamiento="DB";
	}else if($porcDb>$porcDS && $porcDb>$porcDA && $porcDb>$porcDB){
		if($porcDb>60 && $porcDb<101){
			$comportamiento="Db";
		}else{
			$comportamiento="DB";
		}
	}
	if($comportamiento==""){
		$comportamiento="DB";
	}

	echo "<tr>
		<td scope='col' colspan='6' class='fonttitle7' >COMPORTAMIENTO</td>
		<td scope='col' colspan='10	' class='fonttitle8' >$comportamiento</td>
		</tr>";
	$sql3 = "SELECT DISTINCT descripcion 
		FROM tbcomportamiento WHERE tipo='$comportamiento' ORDER BY descripcion ASC";
		$consulta3 = $conx->query($sql3);
	echo "<tr>
		<td scope='col' colspan='16' style='text-align:left; font:12px 	arial,sans-serif;'><span style='font:12px bold 	arial,sans-serif; font-weight:bold;'>OBSERVACIONES:</span> ";
		while($records4 = $conx->records_array($consulta3)){
		echo String_oracion($records4['descripcion'])." ";
		
		}
	$sqlTasig = "SELECT DISTINCT codasig_fk FROM `tbasign_asignatura` WHERE `grado`='$grado' AND aniolect='$aniolect'";
	$consultaTasig= $conx->query($sqlTasig);
	$numasigProm= $conx->get_numRecords($consultaTasig);
	$sqlpuesto = "SELECT AVG( n.vn ) AS promedio, SUM( n.vn ) AS sumnotas, n.codest_fk 
	FROM tbnotas n, tbestudiante e, matricula m WHERE m.grado='$grado' AND n.codest_fk=e.codest AND n.codest_fk=m.codest_fk
    AND n.periodo='$periodo' AND e.estado='ACT'
    AND n.aniolect=$aniolect AND n.aniolect=m.aniolect 
	GROUP BY n.codest_fk
	ORDER BY promedio DESC";
	$sqlpuestoanio = "SELECT ROUND(AVG( vn ),3) AS promedio, SUM( n.vn ) AS sumnotas, n.codest_fk 
	FROM tbnotas n, tbestudiante e, matricula m WHERE m.grado='$grado' AND n.codest_fk=e.codest AND n.codest_fk=m.codest_fk
    AND e.estado='ACT'
    AND n.aniolect=$aniolect AND n.aniolect=m.aniolect 
	GROUP BY n.codest_fk
	ORDER BY promedio DESC";
	$consultapuesto = $conx->query($sqlpuesto);
	$consultapuestoanio = $conx->query($sqlpuestoanio);
	$puesto=1;
	$puestoanio=1;
	$numest= $conx->get_numRecords($consultapuesto);
	$notaEstAnt=0;
	while($recordspuesto = $conx->records_array($consultapuesto)){
		if(!($records1['codest']==$recordspuesto['codest_fk'])){
			$puesto++;
		}else{
			if($periodo=='1' or $periodo=='2'){
				$promedio=$recordspuesto['sumnotas']/($numasigProm-1);
			}else{
				$promedio=$recordspuesto['promedio'];
			}
			break;
		}
	}
	if($periodo=4){
		while($recordspuestoanio = $conx->records_array($consultapuestoanio)){
			if(!($records1['codest']==$recordspuestoanio['codest_fk'])){
				$puestoanio++;
			}else{
				$promedioanio=$recordspuestoanio['promedio'];
				break;
			}
		}
	}

	echo "
		</td>
		</tr>";
	if($periodo=4){
		echo "<tr><td scope='col' colspan='11' style='text-align:left; font:12px 	arial,sans-serif;' rowspan='2'>
		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >PROMEDIO GENERAL PERIODO:</span> ".number_format((float)$promedio,2,".",",")." 
		<span style='font:12px bold 	arial,sans-serif; font-weight:bold; ' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPUESTO: </span>$puesto
		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >DE</span> $numest</td>
		<td scope='col' colspan='5' style='text-align:left; font:12px 	arial,sans-serif;' rowspan='2'>
		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >PROMEDIO GENERAL AÑO LECTIVO:</span> ".number_format((float)$promedioanio,3,".",",")." 
		<span style='font:12px bold 	arial,sans-serif; font-weight:bold; ' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPUESTO: </span>$puestoanio
		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >DE</span> $numest</td></tr>";
	}else{
	
		echo "<tr><td scope='col' colspan='11' style='text-align:left; font:12px 	arial,sans-serif;' rowspan='2'>
		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >PROMEDIO GENERAL PERIODO:</span> ".number_format((float)$promedio,2,".",",")." 
		<span style='font:12px bold 	arial,sans-serif; font-weight:bold; ' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPUESTO: </span>$puesto
		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >DE</span> $numest</td></tr>";
	}

	echo "</table><br/><br/>";
	/*echo "<table class='tabledes' style='floar:left;'>
	  
	  <tr>
		<td colspan='8' class='fonttitle4'><div align='center'>CONVENCIONES</div></td>
	  </tr>
	  <tr>
		<td class='fonttitle4'><div align='center'>D</div></td>
		<td class='fonttitle5'>DESEMPEÑO</td>
		<td class='fonttitle4'>V.N</div></td>
		<td class='fonttitle5'>VALORACIÓN NÚMERICA</td>
		<td class='fonttitle4'>J</div></td>
		<td class='fonttitle5' colspan='3'>FALTAS JUSTIFICADAS</td>
	  </tr>
	  <tr>
		<td class='fonttitle4'>S.J</div></td>
		<td class='fonttitle5' >FALTAS SIN JUSTIFICAR</td>
		<td class='fonttitle4'>T</td>
		<td class='fonttitle5' >TOTAL FALTAS</td>
		<td class='fonttitle4'>DS</div></td>
		<td class='fonttitle5' colspan='3'>DESEMPEÑO SUPERIOR (4.6 - 5.0)</td>

	  </tr>
	  <tr>
		<td class='fonttitle4'>DA</div></td>
		<td class='fonttitle5' >DESEMPEÑO ALTO (4.0 - 4.5)</td>
		<td class='fonttitle4'>DB</td>
		<td class='fonttitle5' >DESEMPEÑO BÁSICO (3.0 - 3.9)</td>
		<td class='fonttitle4'>Db</div></td>
		<td class='fonttitle5' colspan='3'>DESEMPEÑO BAJO (1.0 - 2.9)</td>
	  </tr>
	 </table>";*/
	$sql4 = "SELECT * 
	FROM  `tbasign_asignatura` , tbdocente
	WHERE  `coddocen_fk` = codigo
	AND  `grado` =  '$grado'
	AND  `dg` =  'S'";
	$consulta4 = $conx->query($sql4);
	$records4 = $conx->records_array($consulta4);
	$dg = $records4['n1']." ". $records4['n2']." ".$records4['a1']." ".$records4['a2'];
	//echo "<hr class='linea'>";
	echo "<div class='pie'>
	<span style='font:15px Lucida Calligraphy, sans-serif; font-weight:bold;'>$dg</span><br/>
	<span style='font:12px bold arial,sans-serif; font-weight:bold;'>DIRECTOR (A) DE GRUPO</span></div><br/>";
	/*echo "<div class='pie'>
	<p>Dirección: calle Sucre Antiguo Colegio Divino Niño - Frente a la Catedral San Andrés<br>Telefono: 7277001 
	<a href='' >www.tumacoaltono.com</a></p>
	</div>";*/
	echo "<h1 class='SaltoDePagina'> </h1>";
	//-------------------------------FIN LADO A------------------------------------------------
	//-------------------------------LADO B------------------------------------------------
	$colspan=($periodo*2)+3;
	$sqlnivelacion = "SELECT DISTINCT periodo
	FROM tbnotas_nivelacion, tbasignatura WHERE codest_fk='".$records1['codest']."' AND tbasignatura.Tipo='ACA' AND aniolect=$aniolect  ORDER BY nasig ASC";
	$consultanivelacion = $conx->query($sqlnivelacion);
	$flagnivel = $conx->get_numRecords($consultanivelacion);
	if($flagnivel>0){
		$colspan=($periodo*2)+5+(int)$flagnivel;
	}else{
		$colspan=($periodo*2)+3;
	}
    
    $sqldatnivel = "SELECT DISTINCT tbnotas_nivelacion.*
	FROM tbnotas_nivelacion WHERE codest_fk='".$records1['codest']."' 
    AND periodo='2'
    AND aniolect=$aniolect ";
    $consultadatnivel = $conx->query($sqldatnivel);
    $nv2p=$conx->get_numRecords($consultadatnivel);
    
    $sqldatnivel = "SELECT DISTINCT tbnotas_nivelacion.*
	FROM tbnotas_nivelacion WHERE codest_fk='".$records1['codest']."' 
    AND periodo='4'
    AND aniolect=$aniolect ";
    $consultadatnivel = $conx->query($sqldatnivel);
    $nv4p=$conx->get_numRecords($consultadatnivel);
                                            
	echo "<br/><table class='boletin' cellspacing='0' align='center'>
				
				<tr>
					<td style='border: 1px solid #0000FF'>
						<table align='center' width='480' >
						  <tr>
							<td colspan='$colspan' align='center' valign='middle' class='Estilo5 columna3'><span>HIST&Oacute;RICO  DE RESULTADOS POR PERIODOS</span></td>
						  </tr>";
						  
						  switch($periodo){
							case 1: echo"<tr>
											<td width='0%'rowspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>AREAS  Y/O ASIGNATURAS</span></td>
											<td colspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>PRIMERO </span></td>
											<td colspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>PROMEDIO PARCIAL</span></td>
										</tr>
										 <tr>
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>V.N</span></td>
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>D</span></td>
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>V.N</span></td>
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>D</span></td>
										 </tr>"; break;
							case 2: echo"<tr>
											<td width='0%'rowspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>AREAS  Y/O ASIGNATURAS</span></td>
											<td colspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>PRIMERO </span></td>
											<td colspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>SEGUNDO </span></td>";
											
    									    if($nv2p>0){
												echo "<td colspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>NIVELACIÓN</span></td>";
											}
											echo"
											<td colspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>PROMEDIO PARCIAL</span></td>
										</tr>
										 <tr>
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>V.N</span></td>
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>D</span></td>
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>V.N</span></td>
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>D</span></td>";
											if($nv2p>0){
												echo "<td align='center' valign='middle' class='columna3'><span class='Estilo6'>V.N</span></td>
												<td align='center' valign='middle' class='columna3'><span class='Estilo6'>D</span></td>";
											}
											echo"
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>V.N</span></td>
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>D</span></td>
										 </tr>"; break;	
							case 3: echo"<tr>
											<td width='0%'rowspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>AREAS  Y/O ASIGNATURAS</span></td>
											<td colspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>PRIMERO </span></td>
											<td colspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>SEGUNDO </span></td>";
											
    									    if($nv2p>0){
												echo "<td colspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>NIVELACIÓN</span></td>";
											}
											echo"
                                            <td colspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>TERCERO</span></td>
											<td colspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>PROMEDIO PARCIAL</span></td>
										</tr>
										 <tr>
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>V.N</span></td>
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>D</span></td>
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>V.N</span></td>
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>D</span></td>";
											if($nv2p>0){
												echo "<td align='center' valign='middle' class='columna3'><span class='Estilo6'>V.N</span></td>
												<td align='center' valign='middle' class='columna3'><span class='Estilo6'>D</span></td>";
											}
											echo"
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>V.N</span></td>
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>D</span></td>
                                            <td align='center' valign='middle' class='columna3'><span class='Estilo6'>V.N</span></td>
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>D</span></td>
										 </tr>"; break;	
							case 4: echo"<tr>
											<td width='0%'rowspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>AREAS  Y/O ASIGNATURAS</span></td>
											<td colspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>PRIMERO </span></td>
											<td colspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>SEGUNDO </span></td>";
											                                          
    									    if($nv2p>0){
												echo "<td colspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>NIVELACIÓN</span></td>";
											}
											echo"
                                            <td colspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>TERCERO</span></td>
											<td colspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>CUARTO</span></td>";
                                            
											echo"
                                            <td colspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>PROMEDIO FINAL</span></td>";
                                            if($nv4p>0){
												echo "<td colspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>NIVELACIÓN AÑO ESCOLAR</span></td>";
											}
                                            echo "
							             </tr>
										 <tr>
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>V.N</span></td>
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>D</span></td>
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>V.N</span></td>
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>D</span></td>";
											if($nv2p>0){
												echo "<td align='center' valign='middle' class='columna3'><span class='Estilo6'>V.N</span></td>
												<td align='center' valign='middle' class='columna3'><span class='Estilo6'>D</span></td>";
											}
											echo"
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>V.N</span></td>
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>D</span></td>
                                            <td align='center' valign='middle' class='columna3'><span class='Estilo6'>V.N</span></td>
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>D</span></td>";
                                            
											echo"
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>V.N</span></td>
											<td align='center' valign='middle' class='columna3'><span class='Estilo6'>D</span></td>";
                                            if($nv4p>0){
												echo "<td align='center' valign='middle' class='columna3'><span class='Estilo6'>V.N</span></td>
												<td align='center' valign='middle' class='columna3'><span class='Estilo6'>D</span></td>";
											}
                                            echo"
                                            
                                        </tr>"; break;	
							default: break;
						  }
						  //--------------------HISTORICO DE RESULTADOS
								$sqlhisresult = "SELECT DISTINCT codasig_fk, nasig
								FROM tbnotas, tbasignatura WHERE codest_fk='".$records1['codest']."' AND codasig=codasig_fk AND Tipo='ACA' ORDER BY nasig ASC";
								$consultahistr = $conx->query($sqlhisresult);
								$mPerdidas=0;
								while($recordshistr = $conx->records_array($consultahistr)){
									
								echo"<tr >
									<td align='center' valign='middle' class='columna3 Estilo9'>".$recordshistr['nasig']."</td>";
									$loopperiodo=1;
									$sumaprogeneral=0;
                                    $promfinal=0;
									$periodosDiv=0;
                                    while($loopperiodo<=$periodo){
											
											$sqlhis = "SELECT DISTINCT n.vn, n.desempeno, periodo, codasig_fk 
											FROM tbnotas n WHERE codest_fk='".$records1['codest']."' AND periodo='$loopperiodo' AND n.codasig_fk='".$recordshistr['codasig_fk']."'";
											$consultasqlhis = $conx->query($sqlhis);
											$recordshis = $conx->records_array($consultasqlhis);
											if($recordshis['desempeno']=='D-'){
												$desempeno="Db";
											}else{
												$desempeno=$recordshis['desempeno'];
											}
										switch($recordshis['periodo']){
											case "1": $periodosDiv++; 
                                                echo "<td align='center' valign='middle' class='columna3 Estilo9'>"
    											.number_format((float)$recordshis['vn'],1,".",",")."</td>
    											<td align='center' valign='middle' class='columna3 Estilo9' >"
    											.$desempeno."</td>"; $sumaprogeneral+=$recordshis['vn']; $promfinal=$sumaprogeneral/$periodosDiv;
                                                break;
    											
											case "2": $periodosDiv++;
                                                echo "<td align='center' valign='middle' class='columna3 Estilo9'>"
    											.number_format((float)$recordshis['vn'],1,".",",")."</td>
    											<td align='center' valign='middle' class='columna3 Estilo9' >"
    											.$desempeno."</td>";
                                                $sumaprogeneral+=$recordshis['vn'];
                                                $promfinal=$sumaprogeneral/$periodosDiv;
    											$sqldatnivel = "SELECT DISTINCT tbnotas_nivelacion.*
    											FROM tbnotas_nivelacion WHERE codest_fk='".$records1['codest']."' 
                                                AND codasig_fk='".$recordshistr['codasig_fk']."'
                                                AND periodo='2'
    											AND aniolect=$aniolect ";
                                                $consultadatnivel = $conx->query($sqldatnivel);
    									        $recordsnivel = $conx->records_array($consultadatnivel);
    											if($conx->get_numRecords($consultadatnivel)>0){	 
    												if($recordsnivel['desempeno']=='D-'){
    													$desempenonv="Db";
    												}else{
    													$desempenonv=$recordsnivel['desempeno'];
    												}
    												echo "<td align='center' valign='middle' class='columna3 Estilo9'>"
    												.number_format((float)$recordsnivel['vn'],1,".",",")."</td>
    												<td align='center' valign='middle' class='columna3 Estilo9' >"
    												.$desempenonv."</td>";
    												if($recordsnivel['vn'] > $promfinal){
    												    $periodosDiv--;
                                                        $sumaprogeneral=$recordsnivel['vn'];
                                                        $promfinal=$sumaprogeneral/$periodosDiv;
    												}
    											}else{
                                                    if($nv2p>0){
    												    echo "<td align='center' valign='middle' class='columna3 Estilo9'></td>
    												    <td align='center' valign='middle' class='columna3 Estilo9' ></td>";
                                                    }
    											}
    											break;
                                            
											case "3": $periodosDiv++; 
                                                echo "<td align='center' valign='middle' class='columna3 Estilo9'>"
    											.number_format((float)$recordshis['vn'],1,".",",")."</td>
    											<td align='center' valign='middle' class='columna3 Estilo9' >"
    											.$desempeno."</td>"; $sumaprogeneral+=$recordshis['vn']; $promfinal=$sumaprogeneral/$periodosDiv;
                                                break;
                                                
											case "4": $periodosDiv++;
                                                echo "<td align='center' valign='middle' class='columna3 Estilo9'>"
    											.number_format((float)$recordshis['vn'],1,".",",")."</td>
    											<td align='center' valign='middle' class='columna3 Estilo9' >"
    											.$desempeno."</td>";
                                                $sumaprogeneral+=$recordshis['vn'];
                                                $promfinal=$sumaprogeneral/$periodosDiv;
                                                $promfinalnonnv=$promfinal;
                                                
                                                $notaf = (float)$promfinalnonnv;
            									$notaf=number_format((float)$notaf,1, ".",",");
            									if($notaf >= 2.9 and $notaf < 3){
            										$notaf=3.0;
            										$notaf=number_format((float)$notaf,1, ".",",");
            									}
            									if($notaf >= 1.0 and $notaf < 3){
            										  $mPerdidas++; 
            										  $desempenofinal="Db"; 
           										      echo "<td align='center' valign='middle' class='columna3 Estilo9' style='color:red;'>".$notaf."</td><td align='center' valign='middle' class='columna3 Estilo9' style='color:red;'>".$desempenofinal."</td>";
            									}else if($notaf >= 3.0 and $notaf < 4){
            									       $desempenofinal="DB";
           										       echo "<td align='center' valign='middle' class='columna3 Estilo9' >".$notaf."</td><td align='center' valign='middle' class='columna3 Estilo9' >".$desempenofinal."</td>";
            									}else if($notaf >= 4.0 and $notaf < 4.6){
            									       $desempenofinal="DA";
            									       echo "<td align='center' valign='middle' class='columna3 Estilo9' >".$notaf."</td><td align='center' valign='middle' class='columna3 Estilo9' >".$desempenofinal."</td>";
            									}else if($notaf >= 4.6 and $notaf <= 5.0){
            									       $desempenofinal="DS";
            									       echo "<td align='center' valign='middle' class='columna3 Estilo9' >".$notaf."</td><td align='center' valign='middle' class='columna3 Estilo9' >".$desempenofinal."</td>";
            									}else{
            									       echo "<td align='center' valign='middle' class='columna3 Estilo9' ></td><td align='center' valign='middle' class='columna3 Estilo9' ></td>";
            									}
                                                
    											$sqldatnivel = "SELECT DISTINCT nasig, tbnotas_nivelacion.*
    											FROM tbnotas_nivelacion, tbasignatura WHERE codest_fk='".$records1['codest']."' 
                                                AND codasig_fk='".$recordshistr['codasig_fk']."'
                                                AND periodo='4'
    											AND aniolect=$aniolect ";
                                                $consultadatnivel = $conx->query($sqldatnivel);
    									        $recordsnivel = $conx->records_array($consultadatnivel);
    											if($conx->get_numRecords($consultadatnivel)>0){	 
    												if($recordsnivel['desempeno']=='D-'){
    													$desempenonv="Db";
    												}else{
    													$desempenonv=$recordsnivel['desempeno'];
    												}
    												echo "<td align='center' valign='middle' class='columna3 Estilo9'>"
    												.number_format((float)$recordsnivel['vn'],1,".",",")."</td>
    												<td align='center' valign='middle' class='columna3 Estilo9' >"
    												.$desempenonv."</td>";
    												if($recordsnivel['vn'] > $promfinal){
    												    $periodosDiv--;
                                                        $sumaprogeneral=$recordsnivel['vn'];
                                                        $promfinal=$sumaprogeneral;
                                                        $mPerdidas--;
    												}
    											}else{
    												if($nv4p>0){
    												    echo "<td align='center' valign='middle' class='columna3 Estilo9'></td>
    												    <td align='center' valign='middle' class='columna3 Estilo9' ></td>";
                                                    }
    											}
              	                                 echo "</tr>";
    											 break;
                                            default: 
                                                $sqldatnivel = "SELECT DISTINCT nasig, tbnotas_nivelacion.*
    											FROM tbnotas_nivelacion, tbasignatura WHERE codest_fk='".$records1['codest']."' 
                                                AND codasig_fk='".$recordshistr['codasig_fk']."'
                                                AND periodo='".($loopperiodo+1)."'
    											AND aniolect=$aniolect ";
                                                $consultadatnivel = $conx->query($sqldatnivel);
    									        if($conx->get_numRecords($consultadatnivel)>0){
    									           
                                                   $periodosDiv++;
    									        }	
                                                 
                                                 echo "<td align='center' valign='middle' class='columna3 Estilo9'></td>
    												    <td align='center' valign='middle' class='columna3 Estilo9' ></td>";
                                                 if($nv2p>0 && $loopperiodo==2){
    												    echo "<td align='center' valign='middle' class='columna3 Estilo9'></td>
    												    <td align='center' valign='middle' class='columna3 Estilo9' ></td>";
                                                 }
                                                 if($loopperiodo==4){
    												    $notaf = (float)$promfinal;
                    									$notaf=number_format((float)$notaf,1, ".",",");
                    									if($notaf >= 2.9 and $notaf < 3){
                    										$notaf=3.0;
                    										$notaf=number_format((float)$notaf,1, ".",",");
                    									}
                    									if($notaf >= 1.0 and $notaf < 3){
                    									   $mPerdidas++; 
                    									   $desempenofinal="Db"; 
                    									   echo "<td align='center' valign='middle' class='columna3 Estilo9' style='color:red;'>".$notaf."</td><td align='center' valign='middle' class='columna3 Estilo9' style='color:red;'>".$desempenofinal."</td>";
                    									}else if($notaf >= 3.0 and $notaf < 4){
                    									   $desempenofinal="DB";
                    									   echo "<td align='center' valign='middle' class='columna3 Estilo9' >".$notaf."</td><td align='center' valign='middle' class='columna3 Estilo9' >".$desempenofinal."</td>";
                    									}else if($notaf >= 4.0 and $notaf < 4.6){
                    									   $desempenofinal="DA";
                    									   echo "<td align='center' valign='middle' class='columna3 Estilo9' >".$notaf."</td><td align='center' valign='middle' class='columna3 Estilo9' >".$desempenofinal."</td>";
                 									    }else if($notaf >= 4.6 and $notaf <= 5.0){
                    									   $desempenofinal="DS";
                    									   echo "<td align='center' valign='middle' class='columna3 Estilo9' >".$notaf."</td><td align='center' valign='middle' class='columna3 Estilo9' >".$desempenofinal."</td>";
                    									}else{
                    									   echo "<td align='center' valign='middle' class='columna3 Estilo9' ></td><td align='center' valign='middle' class='columna3 Estilo9' ></td>";
                    									}
                                                 }    
                                                
											break;
										}
										
										
										$loopperiodo++;
									}
									//$notaf = (float)$sumaprogeneral/((float)$periodo);
									/*if($periodosDiv<=0){
										$periodosDiv=1;
									}*/
									if($periodo!=4){
                                        $notaf = (float)$promfinalnonnv;
    									$notaf=number_format((float)$notaf,1, ".",",");
    									if($notaf >= 2.9 and $notaf < 3){
    										$notaf=3.0;
    										$notaf=number_format((float)$notaf,1, ".",",");
    									}
    									if($notaf >= 1.0 and $notaf < 3){
    									   $mPerdidas++; 
    									   $desempenofinal="Db"; 
    									   echo "<td align='center' valign='middle' class='columna3 Estilo9' style='color:red;'>".$notaf."</td><td align='center' valign='middle' class='columna3 Estilo9' style='color:red;'>".$desempenofinal."</td>";
    									}else if($notaf >= 3.0 and $notaf < 4){
    									   $desempenofinal="DB";
    									   echo "<td align='center' valign='middle' class='columna3 Estilo9' >".$notaf."</td><td align='center' valign='middle' class='columna3 Estilo9' >".$desempenofinal."</td>";
    									}else if($notaf >= 4.0 and $notaf < 4.6){
    									   $desempenofinal="DA";
    									   echo "<td align='center' valign='middle' class='columna3 Estilo9' >".$notaf."</td><td align='center' valign='middle' class='columna3 Estilo9' >".$desempenofinal."</td>";
 									    }else if($notaf >= 4.6 and $notaf <= 5.0){
    									   $desempenofinal="DS";
    									   echo "<td align='center' valign='middle' class='columna3 Estilo9' >".$notaf."</td><td align='center' valign='middle' class='columna3 Estilo9' >".$desempenofinal."</td>";
    									}else{
    									   echo "<td align='center' valign='middle' class='columna3 Estilo9' ></td><td align='center' valign='middle' class='columna3 Estilo9' ></td>";
    									}
    									echo "</tr>";
                                    }
                            if($records1['codest']=='93121511027'){
								$mPerdidas-=4;
							}
							if($mPerdidas>0 and $mPerdidas <3){
								$estadoP= "<span style='color:red;'>"."PENDIENTE"."</span><br/>Tiene $mPerdidas área(s) reprobada(s),
									debe recuperar en la semana del 23 al 27 de Enero de 2012";
							}elseif($mPerdidas>2){
								$estadoP= "<span style='color:red;'>"."DEBE REPETIR EL GRADO"."</span><br/>Tiene $mPerdidas área(s) reprobada(s).";
								
							}elseif($mPerdidas==0){
								$estadoP= "PROMOVIDO(A)";
								switch($grado){
									case '1°1': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO SEGUNDO"."</span>"; break;
									case '1°2': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO SEGUNDO"."</span>"; break;
									case '2': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO TERCERO"."</span>"; break;
									case '3': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO CUARTO"."</span>"; break;
									case '4': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO QUINTO"."</span>"; break;
									case '5': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO SEXTO"."</span>"; break;
									case '6°1': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO SEPTIMO"."</span>"; break;
									case '6°2': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO SEPTIMO"."</span>"; break;
									case '7': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO OCTAVO"."</span>"; break;
									case '8°1': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO NOVENO"."</span>"; break;
									case '8°2': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO NOVENO"."</span>"; break;
									case '9': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO DECIMO"."</span>"; break;
									case '10': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO ONCE"."</span>"; break;
									default: break;
									
								
								}
							}
						}
								if($flagnivel>0){
									if($periodo='4'){
										echo"<tr ><td colspan='$colspan' align='center' valign='middle' class='columna3 Estilo1' style='text-align:justify; padding:15px;'>Nota: La valoración númerica de nivelación solo aplica si esta supera el promedio final.</td></tr>";
									}else{
										echo"<tr ><td colspan='$colspan' align='center' valign='middle' class='columna3 Estilo1' style='text-align:justify; padding:15px;'>Nota: La valoración númerica de nivelación solo aplica si esta supera el promedio parcial.</td></tr>";
									
									}
								}
								if($periodo='4'){
									echo"<tr><td colspan='$colspan' align='center' valign='middle' class='columna3 Estilo1' style='text-align:justify; padding:15px;'><span style='font:13px bold 	arial,sans-serif; font-weight:bold;' >ESTADO DE PROMOCIÓN:</span> $estadoP</td></tr>";
								}
								/*if($mPerdidas>2){
									echo"<tr ><td colspan='11' align='center' valign='middle' class='columna3 Estilo1' style='text-align:justify; padding:15px;'>Nota: En promedio tienes $mPerdidas áreas reprobadas,
									debes presentarte mañana a las 7:00 a.m. con tus padres o acudientes para concertar actividades complementarias de nivelación.</td></tr>";
								}*/
								//------------------FIN HISTORICO RESULTADOS
						  /*echo "
						  
						</table><br/>
						<table width='575' border='0' cellspacing='5px' >
							<tr >
							<th colspan='2'>
								<p class='Estilo5' align='center'>OBSERVACIONES GENERALES</p>
							</th>
							</tr>
							<tr>
								<td width='30%' align='left' class='Estilo6'>ASIGNATURA</td>
								<td  align='left' class='Estilo6' >OBSERVACI&Oacute;N</td>";	
						//observaciones generales
						$sqlog = "SELECT DISTINCT a.nasig, n.* 
								FROM tbasignatura a, tbnotas n WHERE n.codest_fk=".$records1['codest']." AND a.codasig=n.codasig_fk  AND periodo='$periodo' AND a.Tipo='ACA' ORDER BY a.nasig ASC";
						$consultaog = $conx->query($sqlog);
						while($recordsog = $conx->records_array($consultaog)){
							if($recordsog['observaciones']!=NULL){
							$observaciones=$recordsog['observaciones'];
							$existe = strrpos($observaciones, ".");
							if($existe==false ){
								$observaciones.=".";
							}
					  echo "<tr>
								<td  class='Estilo1'>".$recordsog['nasig']."</td>
								<td align='left' valign='top' style='line-height:15px; text-align:justify'>
									<span ' class='Estilo1' >".
										String_oracion($observaciones)."</span>&nbsp;
								</td>
							</tr>";
							}
						}
						//---------------------------			
					echo "
						</table>";*/
					//CONVENCIONES
				  echo "<table class='tabledes' style='floar:left;'>
				  
				  <tr>
					<td colspan='8' class='fonttitle4'><div align='center'>CONVENCIONES</div></td>
				  </tr>
				  <tr>
					<td class='fonttitle4'><div align='center'>D</div></td>
					<td class='fonttitle5'>DESEMPEÑO</td>
					<td class='fonttitle4'>V.N</div></td>
					<td class='fonttitle5'>VALORACIÓN NÚMERICA</td>
					<td class='fonttitle4'>J</div></td>
					<td class='fonttitle5' colspan='3'>FALTAS JUSTIFICADAS</td>
				  </tr>
				  <tr>
					<td class='fonttitle4'>S.J</div></td>
					<td class='fonttitle5' >FALTAS SIN JUSTIFICAR</td>
					<td class='fonttitle4'>T</td>
					<td class='fonttitle5' >TOTAL FALTAS</td>
					<td class='fonttitle4'>DS</div></td>
					<td class='fonttitle5' colspan='3'>DESEMPEÑO SUPERIOR (4.6 - 5.0)</td>

				  </tr>
				  <tr>
					<td class='fonttitle4'>DA</div></td>
					<td class='fonttitle5' >DESEMPEÑO ALTO (4.0 - 4.5)</td>
					<td class='fonttitle4'>DB</td>
					<td class='fonttitle5' >DESEMPEÑO BÁSICO (3.0 - 3.9)</td>
					<td class='fonttitle4'>Db</div></td>
					<td class='fonttitle5' colspan='3'>DESEMPEÑO BAJO (1.0 - 2.9)</td>
				  </tr>
				 </table>
				</tr>
							
			</table><br/><br/>
					</td>";
			if($periodo=='4'){
				echo "<div class='pie'>
				<span style='font:15px Lucida Calligraphy, sans-serif; font-weight:bold;'>Esp. AUGUSTO ANTONIO TORRES PEÑALOZA</span><br/>
				<span style='font:12px bold arial,sans-serif; font-weight:bold;'>RECTOR ACADEMICO</span></div><br/>";
			}
					  
			echo "<div class='pie'>
<p>Dirección: calle Sucre Antiguo Colegio Divino Niño - Frente a la Catedral San Andrés<br>Telefono: 7277001 
<a href='' >www.tumacoaltono.com</a></p>
</div>";
			echo "<h1 class='SaltoDePagina'> </h1>";
	//-------------------------------FIN LADO B------------------------------------------------

	}
}else if($formato=="f3"){
	header ("Location: boletinxcursof3.php?grado=$grado&periodo=$periodo"); 

}




	$conx->close_conex();
?>

 <br/>

<!-- <span>
<a href="../../forms/planillas/listaplanillasxcurso.php" class="large button orange" style="font-size: 12px !important;">Regresar</a>
</span>
<span>
<a href="javascript: void window.print()" class="large button orange" style="font-size: 12px !important;" >Imprimir</a>
</span>-->
</body>
</html>