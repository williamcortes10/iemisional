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
require('fpdf.php');
$conx = new ConxMySQL("localhost","root","","bdaltono");
$pdf=new FPDF();
//mysql_set_charset('utf8',$conx->conexion);
$grado = utf8_decode($_POST['grado']);
$periodo= $_POST['periodo'];
switch($grado){
	case "0": $grado2="PRE-ESCOLAR"; break;
	case "1": $grado2="PRIMERO"; break;
	case "2": $grado2="SEGUNDO"; break;
	case "3": $grado2="TERCERO"; break;
	case "4": $grado2="CUARTO"; break;
	case "5": $grado2="QUINTO"; break;
	case "6°1": $grado2="SEXTO UNO"; break;
	case "6°2": $grado2="SEXTO DOS"; break;
	case "7": $grado2="SEPTIMO"; break;
	case "8°1": $grado2="OCTAVO UNO"; break;
	case "8°2": $grado2="OCTAVO DOS"; break;
	case "9": $grado2="NOVENO"; break;
	case "10": $grado2="DECIMO"; break;
	default: $grado2=$grado; 
	
}

$sql = "SELECT DISTINCT e.a1, e.a2, e.n1, e.n2, e.grado, e.codest FROM tbestudiante e, tbnotas n 
WHERE e.codest=n.codest_fk AND e.grado='$grado' AND n.periodo=$periodo ORDER BY e.a1, e.a2, e.n1, e.n2 DESC";
$consulta1 = $conx->query($sql);
while($records1 = $conx->records_array($consulta1)){

echo "
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
FROM tbasignatura a, tbnotas n WHERE n.codest_fk=".$records1['codest']." AND a.codasig=n.codasig_fk ORDER BY a.nasig ASC";
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
	 AND periodo=".$records2['periodo']." AND estado='HA'";
	$consulta3 = $conx->query($sql);
	while($records3 = $conx->records_array($consulta3)){
	echo $records3['descripcion']." ";
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
	if($porcDb>79 && $porcDb<101){
		$comportamiento="Db";
	}else{
		$comportamiento="DB";
	}
}

echo "<tr>
	<td scope='col' colspan='6' class='fonttitle7' >COMPORTAMIENTO</td>
	<td scope='col' colspan='10	' class='fonttitle8' >$comportamiento</td>
	</tr>";
$sql3 = "SELECT DISTINCT descripcion 
	FROM tbcomportamiento WHERE tipo='$comportamiento' ORDER BY descripcion ASC";
	$consulta3 = $conx->query($sql3);
echo "<tr>
	<td scope='col' colspan='16' style='text-align:left; font:13px 	arial,sans-serif;'><span style='font:13px bold 	arial,sans-serif; font-weight:bold;'>OBSERVACIONES:</span> ";
	while($records4 = $conx->records_array($consulta3)){
	echo $records4['descripcion']." ";
	}
$sqlpuesto = "SELECT AVG( vn ) AS promedio,  `codest_fk` 
FROM tbnotas, tbestudiante WHERE grado='$grado' AND codest_fk=codest AND periodo='$periodo'
GROUP BY codest_fk
ORDER BY promedio DESC";
$consultapuesto = $conx->query($sqlpuesto);
$puesto=1;
$numest= $conx->get_numRecords($consultapuesto);
while($recordspuesto = $conx->records_array($consultapuesto)){
	if(!($records1['codest']==$recordspuesto['codest_fk'])){
		$puesto++;
	}else{
		$promedio=$recordspuesto['promedio']; break;
	}
}

echo "
	</td>
	</tr>";
echo "<tr><td scope='col' colspan='16' style='text-align:left; font:12px 	arial,sans-serif;' rowspan='2'>
<span style='font:13px bold 	arial,sans-serif; font-weight:bold;' >PROMEDIO GENERAL:</span> ".number_format((float)$promedio,2,".",",")." 
<span style='font:13px bold 	arial,sans-serif; font-weight:bold; ' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPUESTO: </span>$puesto
<span style='font:13px bold 	arial,sans-serif; font-weight:bold;' >DE</span> $numest</td></tr>";

echo "</table>";
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
 </table><br/>";
$sql4 = "SELECT * 
FROM  `tbasign_asignatura` , tbdocente
WHERE  `coddocen_fk` = codigo
AND  `grado` =  '$grado'
AND  `dg` =  'S'";
$consulta4 = $conx->query($sql4);
$records4 = $conx->records_array($consulta4);
$dg = $records4['n1']." ". $records4['n2']." ".$records4['a1']." ".$records4['a2'];
echo "<hr class='linea'>";
echo "<div class='pie'>
<span style='font:20px Lucida Calligraphy, sans-serif; font-weight:bold;'>$dg</span><br/>
<span style='font:14px bold arial,sans-serif; font-weight:bold;'>DIRECTOR (A) DE GRUPO</span></div><br/>";
echo "<div class='pie'>
<p>Dirección: calle Sucre Antiguo Colegio Divino Niño - Frente a la Catedral San Andrés<br>Telefono: 7277001 
<a href='' >www.tumacoaltono.com</a></p>
</div>";
echo "<h1 class='SaltoDePagina'> </h1>";

}





	$conx->close_conex();
?>

 <br/>

<span>
<a href="../../forms/planillas/listaplanillasxcurso.php" class="large button orange" style="font-size: 12px !important;">Regresar</a>
</span>
<span>
<a href="javascript: void window.print()" class="large button orange" style="font-size: 12px !important;" >Imprimir</a>
</span>
</body>
</html>