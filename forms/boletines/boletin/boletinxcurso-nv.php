<html>
<head>
<title>-CTMATT-</title>
<link  href="http://fonts.googleapis.com/css?family=Cabin+Sketch:bold" rel="stylesheet" type="text/css" >
<link  href="http://fonts.googleapis.com/css?family=Lobster:regular" rel="stylesheet" type="text/css" >
<link  href="http://fonts.googleapis.com/css?family=Tangerine:regular,bold" rel="stylesheet" type="text/css" >

<link rel="stylesheet" type="text/css" href="../../css/listcurso.css" media="all">
<style>
.separatordashed{
color: #000000;
height: 0px;
border:1px dashed;
}
</style>
</head>
<body>
<div class="cabecera1">
<?php
include('../../class/MySqlClass.php');
$conx = new ConxMySQL("localhost","root","","bdaltono");
//mysql_set_charset('utf8',$conx->conexion);
$grado = utf8_decode($_POST['grado']);
$periodo= $_POST['periodo'];
$aniolect= $_POST['aniolect'];
$formato= trim($_POST['formato']);

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
switch($periodo){
    
    case '2': $txt_nv= '1ER SEMETRE'; break;
    case '4': $txt_nv= 'AÑO ESCOLAR'; break;
    default: break; 
}
if($formato=="f2"){
	//-------------------------------------------------------LADO A------------------------------------
	$sql = "SELECT DISTINCT e.a1, e.a2, e.n1, e.n2, m.grado, e.codest FROM tbestudiante e, tbnotas_nivelacion n, matricula m 
	WHERE e.codest=n.codest_fk AND m.grado='$grado' AND e.estado='ACT' AND n.periodo=$periodo AND n.aniolect=$aniolect 
    AND m.codest_fk=n.codest_fk AND n.aniolect=m.aniolect ORDER BY e.a1, e.a2, e.n1, e.n2 DESC";
	$consulta1 = $conx->query($sql);
	$salto=0;
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
								<span class='Estilo1 blocktext' align='center'>C&oacute;digo DANE: 349935487701 </span><br/><br/><br/>
							  <span align='center' class='blocktext'><img  src='ESCUDO TRASNPARENTE.png' width='80' height='80'/></span>
		<p class='fonttitle6'>INFORME VALORATIVO - NIVELACION $txt_nv</p>
		</div>";
		echo "<table class='boletin'>
		<tr >
		<th colspan='14' class='fonttitle7'   style='width:80%'>CADETE:
		<span style='font:12px Lucida Calligraphy;  margin-left:50px; font-weight:bold;'>".$records1['a1']." ".$records1['a2']." ".$records1['n1']." ".$records1['n2']."</span></th>
		<th scope='col' colspan='1' class='fonttitle7' >AÑO ESCOLAR: $aniolect</th>
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
		<th scope='col' colspan='4' class='fonttitle8' rowspan='2'>OBSERVACIONES</th>
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
		FROM tbasignatura a, tbnotas_nivelacion n WHERE n.codest_fk=".$records1['codest']." AND a.codasig=n.codasig_fk AND periodo='$periodo'  AND n.aniolect='$aniolect' ORDER BY a.nasig ASC";
		$consulta2 = $conx->query($sql);
		
		while($records2 = $conx->records_array($consulta2)){
			if($records2['desempeno']=='D-'){
				$desempeno="Db";
			}else{
				$desempeno=$records2['desempeno'];
			}
				echo"<tr>
				<td scope='col' colspan='6' class='fonttitle7' >".$records2['nasig']."</td>";
				if($records2['vn'] >= 1.0 and $records2['vn'] <= 2.9){
					echo "<td scope='col' class='fonttitle9b' style='color:red;' >".number_format((float)$records2['vn'],2,".",",")."</td>";
				}else{
					echo "<td scope='col' class='fonttitle9b' style='color:black;' >".number_format((float)$records2['vn'],2,".",",")."</td>";
				}
				echo"
				
				<td scope='col' class='fonttitle9b' >".$desempeno."</td>
				<td scope='col' class='fonttitle9b' >".$records2['fj']."</td>
				<td scope='col' class='fonttitle9b' >".$records2['fsj']."</td>
				<td scope='col' class='fonttitle9b' >".$records2['ft']."</td>
				<td scope='col' colspan='4' class='fonttitle10b' ><div align='justify'>";
				
				if($records2['observaciones']!=NULL){
					$observaciones= ucfirst($records2['observaciones']);
					$desc=strtolower($observaciones);
					$desc=ucfirst($desc);
					echo $desc." ";
				}
				echo "
				</div></td>
				</tr>";
				
		}
		echo "</table><br/><hr class='separatordashed'></hr>";
		$salto++;	
		if($salto==2) { echo "<h1 class='SaltoDePagina'> </h1>"; $salto=0;}
		
		//-------------------------------FIN LADO A------------------------------------------------
	}
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