<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style>
html {
	height: 780px;
	width: 1280px;
}
#salto {
	height: 16px;
	width: 1280px;
	float:right;
}
#contenedor {
	height: 780px;
	width: 1172;
	position:absolute;
}
#ladoaIzq {
	float: left;
	height: 780px;
	width: 585px;
	border: 1px solid blue;
	position:relative;
}
#ladoaDer {
	float: left;
	height: 780px;
	width: 585px;
	border: 1px solid blue;
	position:relative;
}
#ladoaCen {
	float: left;
	height: 780px;
	width: 80px;
	position:relative;
}
.cabecera1{
	width: 1333px;
	height: auto;
	margin: 0 auto 0 auto;
}
h1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
.boletin{
width: 1171px;
height: 748px;
}

.bordesolido1{
border:-color: #blue;
border-width: 2px;
border-style: solid;
}
.positiontop{
position:absolute;
top:0px;
}
@font-face{
	font-family: Splendid ES;
	src:url(../../fuentes/Splendid ES.ttf);
	
}
.Estilo1 {
	font-family: Arial, Helvetica, sans-serif;
	font-style: italic;
	font-size: 14px;
}
.Estilo2 {
	font-family: Splendid ES;
	font-size: 46px;
}
.Estilo3 {font-family: Arial, Helvetica, sans-serif; font-style: italic; font-weight: bold; }
.Estilo4 {font-family: Arial, Helvetica, sans-serif; font-style: italic; font-weight: bold; font-size: 16px; }
.Estilo5 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
	font-style: italic;
}
.Estilo6 {font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: italic; 
	font-weight: bold; 
}
.Estilo7 {font-size: 9px;
 font-family: Arial, Helvetica, sans-serif;
}
.Estilo8 {font-size: 9.3px;
 font-family: Arial, Helvetica, sans-serif;
 text-align:justify;
}
.Estilo9 {font-size: 9px;
 font-family: Arial, Helvetica, sans-serif;
 font-style: italic; 
 text-align:left;
}
.fonttitle1{
	font:12px bold arial,sans-serif;
	text-align:center;
	font-weight:bold;

}
.fonttitle2{
	font:12px bold arial,sans-serif;
	text-align:left;
}
.fonttitle3{
	font:10px bold arial,sans-serif;
	text-align:center;
}
.fonttitle4{
	font:12px bold arial,sans-serif;
	text-align:center;
	font-weight:bold;

}
.fonttitle5{
	font:11px bold arial,sans-serif;
	text-align:left;
}
.fonttitle6{
	font:16px bold arial,sans-serif;
	text-align:center;
	font-weight:bold;

}
.fonttitle7{
	font:13px bold arial,sans-serif;
	text-align:left;
	font-weight:bold;

}
.fonttitle8{
	font:13px bold arial,sans-serif;
	text-align:center;
	font-weight:bold;

}
.fonttitle9{
	font:10px bold arial,sans-serif;
	text-align:center;

}
.fonttitle10{
	font:10px bold arial,sans-serif;
	text-align:left;

}
.fonttitle11{
	font:12px bold arial,sans-serif;
	text-align:center;
	font-weight:bold;
	margin: 0 auto;
}
.fonttitle4b{
	font:12px bold arial,sans-serif;
	text-align:center;
	font-weight:bold;

}
.fonttitle9b{
	font:12px bold arial,sans-serif;
	text-align:center;

}
.fonttitle10b{
	font:12px bold arial,sans-serif;
	text-align:left;

}
.tablalistinc{
	width: 900px;
	height: auto;
	border: solid black 1px;
	margin: 0 auto 0 auto;
}
.cabecera1{
	width: 950px;
	height: auto;
	margin: 0 auto 0 auto;
}
.columna {
color:black;
padding:.1em 1em;
border:1px solid black;
text-align:center;
}
.columna2 {
color:black;
padding:.1em 1em;
border:1px solid black;
text-align:left;
}
.columna3 {
color:black;
padding:.1px .1px;
border:1px solid black;
text-align:center;
}
</style>
</head>

<body>
<div id="contenedor">
<?php
include('../../class/MySqlClass.php');
require('fpdf.php');
$conx = new ConxMySQL("localhost","root","","bdaltono");
$pdf=new FPDF();
//mysql_set_charset('utf8',$conx->conexion);
$grado = utf8_decode($_POST['grado']);
$periodo= $_POST['periodo'];
$Fecha=getdate(); 
$Anio=$Fecha["year"];
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
$sqldg = "SELECT * 
FROM  `tbasign_asignatura` , tbdocente
WHERE  `coddocen_fk` = codigo
AND  `grado` =  '$grado'
AND  `dg` =  'S'";
$consultadg = $conx->query($sqldg);
$recordsdg = $conx->records_array($consultadg);
$dg = $recordsdg['n1']." ". $recordsdg['n2']." ".$recordsdg['a1']." ".$recordsdg['a2'];

$sql = "SELECT DISTINCT e.a1, e.a2, e.n1, e.n2, e.grado, e.codest FROM tbestudiante e, tbnotas n 
WHERE e.codest=n.codest_fk AND e.grado='$grado' AND n.periodo=$periodo ORDER BY e.a1, e.a2, e.n1, e.n2 DESC";
$consulta1 = $conx->query($sql);
while($records1 = $conx->records_array($consulta1)){
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
//----------------------------LADO A------------------------------------------------------------
echo "
	<div id='ladoaIzq'>
		<table width='570' border='0' cellspacing='0' align='center'>
			<tr>
			<th>
				<p class='Estilo4'>OBSERVACIONES GENERALES</p>
			</th>
			</tr>
			<tr>
				<td height='200px'>
					<table width='575' border='0' cellspacing='5px' >
						<tr>
							<th width='30%' align='left' class='Estilo5'>ASIGNATURA</th>
							<th  align='left' class='Estilo5' >OBSERVACI&Oacute;N</th>";	
					//observaciones generales
					$sqlog = "SELECT DISTINCT a.nasig, n.* 
							FROM tbasignatura a, tbnotas n WHERE n.codest_fk=".$records1['codest']." AND a.codasig=n.codasig_fk  AND periodo='$periodo' ORDER BY a.nasig ASC";
					$consultaog = $conx->query($sqlog);
					while($recordsog = $conx->records_array($consultaog)){
						if($recordsog['observaciones']!=NULL){
						$observaciones= ucfirst($recordsog['observaciones']);
						$existe = strrpos($observaciones, ".");
						if($existe===false ){
							$observaciones.=".";
						}
				  echo "<tr>
							<td  class='Estilo1'>".$recordsog['nasig']."</td>
							<td align='left' valign='top' style='line-height:15px; text-align:justify'>
								<span ' class='Estilo1' >".
									$observaciones."</span>&nbsp;
							</td>
						</tr>";
						}
					}
					//---------------------------			
				echo "
					</table>
				</td>
			</tr>
			<tr>
				<td align='center' valign='top' height='120px'><br/><br/>
					  <p class='Estilo5'>PROMEDIO GENERAL&nbsp;:&nbsp;".number_format((float)$promedio,2,".",",")."
					  &nbsp;&nbsp;PUESTO&nbsp;".$puesto."&nbsp;DE&nbsp;".$numest."</p>
				</td>
			</tr>
			<tr>
				<td align='center' valign='bottom' height='132px' style='line-height:5px;'><br/>
						<span style='font:14px Lucida Calligraphy, sans-serif; font-weight:bold;'>$dg</span><br/>
						<span style='font:14px bold arial,sans-serif; font-weight:bold;'>DIRECTOR (A) DE GRUPO</span></div><br/>
				</td>
			</tr>
		</table>
		</div>
		<div id='ladoaCen'></div>
		<div id='ladoaDer'>
			<table width='570' border='0' cellspacing='0' align='center'  style='line-height:1px; text-align:center'>
				<tr>
					<td valign='top'>
						<p class='Estilo2'>Colegio T&eacute;cnico Militar </p>
						<p class='Estilo4'>&quot;Almirante Tono Tumaco S.A.S&quot;</p>
						<p class='Estilo3'>&nbsp;</p>
						<p class='Estilo1'>Nit: 900.300282-2</p>
						<p class='Estilo1'>EDUCACI&Oacute;N PREESCOLAR, BASICA Y MEDIA</p>
						<p class='Estilo1'>Resoluci&oacute;n Ministerio de Educaci&oacute;n Nacional</p>
						<p class='Estilo1'>Secretaria de Educaci&oacute;n Municipal N&deg; 1002 de Dic. 22 de 2009</p>
						<p class='Estilo1'>C&oacute;digo DANE: 349935487701 </p>
					</td>
				</tr>
				<tr>
					<td align='center' valign='center'>
					  <p><img src='ESCUDO TRASNPARENTE.png' width='250' height='280'/></p>
					</td>
					
				</tr>
				<tr>
							<td colspan='0'><p align='center' class='Estilo4' >INFORME VALORATIVO </p>
							</td>
				</tr>
				<tr>
						<td width='300px' style='line-height:10px;' align='left'>
						<p class='Estilo5'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CADETE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp".$records1['a1']." ".$records1['a2']." ".$records1['n1']." ".$records1['n2']."</p>
						<p class='Estilo5'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;GRADO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;$grado2</p>
						<p class='Estilo5'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PERIODO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;$periodo</p>
						<p class='Estilo5'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A&Ntilde;O&nbsp;LECTIVO :&nbsp;&nbsp;$Anio</p>
						<p class='Estilo5'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
						<p>&nbsp;</p>
						</td>
				</tr>
					
					</table>
					</td>
				</tr>
		  </table>
		 </div>
	";
/* opcion dos informe valorativo membrete cadetes
						
						<tr>
						<td width='300px' style='line-height:10px;'>
						<p class='Estilo5'>CADETE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp".$records1['a1']." ".$records1['a2']." ".$records1['n1']." ".$records1['n2']."</p>
						<p class='Estilo5'>GRADO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;$grado2</p>
						<p class='Estilo5'>PERIODO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;$periodo</p>
						<p class='Estilo5'>A&Ntilde;O&nbsp;LECTIVO :&nbsp;&nbsp;$Anio</p>
						<p class='Estilo5'>&nbsp;</p>
						<p>&nbsp;</p>
						</td>
						</tr>
						
*/
echo "<h1 class='SaltoDePagina'> </h1><div id='salto'></div>";
//----------------------------------------------FIN LADO A

//----------------------------LADO B------------------------------------------------------------
echo "
<div id='ladoaIzq'>";
	//--------------------BOLETIN 
		echo "
		<table>
			<tr class='Estilo6'>
				<th rowspan='2' align='center' valign='middle' class='columna'>ASIGNATURAS </th>
				<th colspan='2' align='center' valign='middle' class='columna'>DESEMPEÑO</th>
				<th colspan='3' align='center' valign='middle' class='columna'>FALTAS</th>
				<th width='70%' rowspan='2' align='center' valign='middle' class='columna'>INDICADORES DE DESEMPEÑO </th>
			</tr>
			<tr class='Estilo6' >
			<td align='center' valign='middle' class='columna'>V.N
			</td>
			<td align='center' valign='middle' class='columna'>D
			</td>
			<td align='center' valign='middle' class='columna'>J
			</td>
			<td align='center' valign='middle' class='columna'>S.J
			</td>
			<td align='center' valign='middle' class='columna'>T
			</td>
			</tr>";
		$sql = "SELECT DISTINCT a.nasig, n.* 
		FROM tbasignatura a, tbnotas n WHERE n.codest_fk=".$records1['codest']." AND a.codasig=n.codasig_fk  AND periodo='$periodo'ORDER BY a.nasig ASC";
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
			echo"<tr >
				<td align='left' valign='middle' class='Estilo9 columna' >".$records2['nasig']."</td>
				<td class='Estilo7 columna' align='center' valign='middle' >".number_format((float)$records2['vn'],1,".",",")."</td>
				<td class='Estilo7 columna' align='center' valign='middle' >".$desempeno."</td>
				<td class='Estilo7 columna' align='center' valign='middle' >".$records2['fj']."</td>
				<td class='Estilo7 columna' align='center' valign='middle' >".$records2['fsj']."</td>
				<td class='Estilo7 columna' align='center' valign='middle' >".$records2['ft']."</td>
				<td><div class='Estilo8 columna2' style='text-align:justify'>";
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
			<td align='left' valign='middle' class='Estilo6 columna'>COMPORTAMIENTO</td>
			<td align='center' valign='middle' colspan='6' class='Estilo6 columna'>$comportamiento</td>
			</tr>";
		$sql3 = "SELECT DISTINCT descripcion 
			FROM tbcomportamiento WHERE tipo='$comportamiento' ORDER BY descripcion ASC";
			$consulta3 = $conx->query($sql3);
		echo "<tr>
			<td colspan='7' class='columna2'><span align='left' valign='middle' class='Estilo6 '>OBSERVACIONES:</span><span class='Estilo7'> ";
			while($records4 = $conx->records_array($consulta3)){
			echo $records4['descripcion']." ";
			}
		echo "
			</span></td>
			</tr>
		</table>
</div>";
	//---------------------------FIN BOLETIN
    
echo "	
<div id='ladoaCen'></div>
<div id='ladoaDer'>
	<table align='center'>
	<tr>
		<td height='500px'  valign='top'>
			<table align='center' width='480'>
      		  <tr>
				<td colspan='11' align='center' valign='middle' class='Estilo4 columna3'><span>HIST&Oacute;RICO  DE RESULTADOS POR PERIODOS</span></td>
			  </tr>
			  <tr>
				<td width='0%'rowspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>AREAS  Y/O ASIGNATURAS</span></td>
				<td colspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>PRIMERO </span></td>
				<td colspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>SEGUNDO</span></td>
				<td colspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>TERCERO</span></td>
				<td colspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>CUARTO</span></td>
				<td colspan='2' align='center' valign='middle' class='columna3'><span class='Estilo6'>DEFINITIVO</span></td>
			  </tr>
			  <tr>
				<td align='center' valign='middle' class='columna3'><span class='Estilo6'>V.N</span></td>
				<td align='center' valign='middle' class='columna3'><span class='Estilo6'>D</span></td>
				<td align='center' valign='middle' class='columna3'><span class='Estilo6'>V.N</span></td>
				<td align='center' valign='middle' class='columna3'><span class='Estilo6'>D</span></td>
				<td align='center' valign='middle' class='columna3'><span class='Estilo6'>V.N</span></td>
				<td align='center' valign='middle' class='columna3'><span class='Estilo6'>D</span></td>
				<td align='center' valign='middle' class='columna3'><span class='Estilo6'>V.N</span></td>
				<td align='center' valign='middle' class='columna3'><span class='Estilo6'>D</span></td>
				<td align='center' valign='middle' class='columna3'><span class='Estilo6'>V.N</span></td>
				<td align='center' valign='middle' class='columna3'><span class='Estilo6'>D</span></td>
			  </tr>";
			  //--------------------HISTORICO DE RESULTADOS
				    $sqlhisresult = "SELECT DISTINCT codasig_fk, nasig
					FROM tbnotas, tbasignatura WHERE codest_fk='".$records1['codest']."' AND codasig=codasig_fk ORDER BY nasig ASC";
					$consultahistr = $conx->query($sqlhisresult);
					$mPerdidas=0;
					while($recordshistr = $conx->records_array($consultahistr)){
						
					echo"<tr >
						<td align='center' valign='middle' class='columna3 Estilo9'>".$recordshistr['nasig']."</td>";
						$loopperiodo=1;
						$sumaprogeneral=0;
						while($loopperiodo<=4){
								
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
								case "1": echo "<td align='center' valign='middle' class='columna3 Estilo9'>".number_format((float)$recordshis['vn'],1,".",",")."</td><td align='center' valign='middle' class='columna3 Estilo9' >".$desempeno."</td>"; $sumaprogeneral+=$recordshis['vn']; break;
								case "2": echo "<td align='center' valign='middle' class='columna3 Estilo9'>".number_format((float)$recordshis['vn'],1,".",",")."</td><td align='center' valign='middle' class='columna3 Estilo9' >".$desempeno."</td>"; $sumaprogeneral+=$recordshis['vn'];break;
								case "3": echo "<td align='center' valign='middle' class='columna3 Estilo9'>".number_format((float)$recordshis['vn'],1,".",",")."</td><td align='center' valign='middle' class='columna3 Estilo9' >".$desempeno."</td>"; $sumaprogeneral+=$recordshis['vn'];break;
								case "4": echo "<td align='center' valign='middle' class='columna3 Estilo9'>".number_format((float)$recordshis['vn'],1,".",",")."</td><td align='center' valign='middle' class='columna3 Estilo9' >".$desempeno."</td>"; $sumaprogeneral+=$recordshis['vn'];break;
								default: echo "<td align='center' valign='middle' class='columna3 Estilo9'>&nbsp;</td><td align='center' valign='middle' class='columna3 Estilo9'>&nbsp;</td>"; break;
							}
							
							$loopperiodo++;
						}
						$notaf = (float)$sumaprogeneral/((float)$periodo);
						if($notaf >= 1.0 and $notaf <= 2.9){
									$desempenofinal="D-"; 
									$mPerdidas++;
						}
						if($recordshis['periodo']=="4"){
								$notaf = (float)$sumaprogeneral/4;
								if($notaf >= 1.0 and $notaf <= 2.9){
									$desempenofinal="D-"; 
									$mPerdidas++;
								}else if($notaf >= 3.0 and $notaf <= 3.9){
									$desempenofinal="DB";
								}else if($notaf >= 4.0 and $notaf <= 4.5){
									$desempenofinal="DA";
								}else if($notaf >= 4.6 and $notaf <= 5.0){
									$desempenofinal="DS";
								}
								echo "<td align='center' valign='middle' class='columna3 Estilo9'>".number_format((float)$sumaprogeneral,1,".",",")."</td><td align='center' valign='middle' class='columna3 Estilo9' >".$desempenofinal."</td>";
							}else{
								echo "<td align='center' valign='middle' class='columna3 Estilo9'>&nbsp;</td><td align='center' valign='middle' class='columna3 Estilo9'>&nbsp;</td>";
						}
				echo "</tr>";
					}
					if($mPerdidas>2){
						echo"<tr ><td colspan='11' align='center' valign='middle' class='columna3 Estilo5' style='text-align:justify; padding:15px; color:red;'>Nota: Debe presentarse el dia de mañana para solucionar situación academica</td></tr>";
					}
					//------------------FIN HISTORICO RESULTADOS
			  echo "
			  
		</table>
		</td>
		</tr>
		<tr>
			<td height='150px'  valign='top'>
				<table width='529'>
  				  <tr>
					<td colspan='8' class='fonttitle4 columna'><div align='center'>CONVENCIONES</div></td>
				  </tr>
				  <tr>
					<td class='fonttitle4 columna'><div align='center'>D</div></td>
					<td class='fonttitle5 columna'>DESEMPEÑO</td>
					<td class='fonttitle4 columna'>V.N</div></td>
					<td class='fonttitle5 columna'>VALORACIÓN NÚMERICA</td>
					<td class='fonttitle4 columna'>J</div></td>
					<td class='fonttitle5 columna' colspan='3'>FALTAS JUSTIFICADAS</td>
				  </tr>
				  <tr>
					<td class='fonttitle4 columna'>S.J</div></td>
					<td class='fonttitle5 columna' >FALTAS SIN JUSTIFICAR</td>
					<td class='fonttitle4 columna'>T</td>
					<td class='fonttitle5 columna' >TOTAL FALTAS</td>
					<td class='fonttitle4 columna'>DS</div></td>
					<td class='fonttitle5 columna' colspan='3'>DESEMPEÑO SUPERIOR (4.6 - 5.0)</td>

				  </tr>
				  <tr>
					<td class='fonttitle4 columna'>DA</div></td>
					<td class='fonttitle5 columna' >DESEMPEÑO ALTO (4.0 - 4.5)</td>
					<td class='fonttitle4 columna'>DB</td>
					<td class='fonttitle5 columna' >DESEMPEÑO BÁSICO (3.0 - 3.9)</td>
					<td class='fonttitle4 columna'>Db</div></td>
					<td class='fonttitle5 columna' colspan='3'>DESEMPEÑO BAJO (1.0 - 2.9)</td>
				  </tr>
				</table>
			</td>
		</tr>
		
	  </table>
</div>";
echo "<h1 class='SaltoDePagina'> </h1><div id='salto'></div>";
//----------------------------------------------*/
}
?>
</div>
</body>
</html>
