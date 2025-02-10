<html>
<head>
<title>-CTMATT-BOLETIN MILITAR</title>
<link  href="http://fonts.googleapis.com/css?family=Cabin+Sketch:bold" rel="stylesheet" type="text/css" >
<link  href="http://fonts.googleapis.com/css?family=Lobster:regular" rel="stylesheet" type="text/css" >
<link  href="http://fonts.googleapis.com/css?family=Tangerine:regular,bold" rel="stylesheet" type="text/css" >

<link rel="stylesheet" type="text/css" href="../../css/listcursomil.css" media="all">
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
function String_oracion($string){
 $stringReturn="";
 $arraySplit = explode('.', $string);
 for($i=0; $i<count($arraySplit); $i++){
	
	$arraySplit[$i]=ucfirst($arraySplit[$i]);
 }
 $stringReturn = implode(".", $arraySplit);
 return $stringReturn;
}

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
if($formato=="f2"){
	//-------------------------------------------------------LADO A------------------------------------
	
	
	$sql = "SELECT DISTINCT e.a1, e.a2, e.n1, e.n2, e.grado, e.codest FROM tbestudiante e, notasmil n 
	WHERE e.codest=n.codest_fk AND e.grado='$grado' AND e.estado='ACT' AND `condmil` =  'A' AND n.periodo=$periodo ORDER BY e.a1, e.a2, e.n1, e.n2 DESC";
	$consulta1 = $conx->query($sql);
	$existenNotas=false;
	while($records1 = $conx->records_array($consulta1)){
	$existenNotas=true;
	echo "<div style='line-height:7px; '><br/>
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
	<p class='fonttitle6'>INFORME VALORATIVO COMPONENTE MILITAR</p>
	</div>";
	echo "<table class='boletin'>
	<tr >
	<th colspan='14' class='fonttitle7'   style='width:80%'>CADETE:
	<span style='font:14px Lucida Calligraphy;  margin-left:50px; font-weight:bold;'>".$records1['a1']." ".$records1['a2']." ".$records1['n1']." ".$records1['n2']."</span></th>
	<th scope='col' colspan='1' class='fonttitle7' >AÑO ESCOLAR: ".date('Y',time())."</th>
	</tr>
	<tr >";
	if($records1['grado']=='9'){
		 echo "<th scope='col' colspan='14' class='fonttitle7' >FASE: PRELIMINAR</th>
	<th scope='col' colspan='14' class='fonttitle7' >GRADO: ".$records1['grado']."</th>
	</tr>";
	}else if($records1['grado']=='10'){
			echo "<th scope='col' colspan='14' class='fonttitle7' >FASE: PRIMERO MILITAR</th>
	<th scope='col' colspan='14' class='fonttitle7' >GRADO: ".$records1['grado']."</th>
	</tr>";
	}
	echo "
	<tr>";
	if($records1['grado']=='9'){
		 echo "<th scope='col' colspan='14' class='fonttitle7' >COMPAÑIA: CABAL</th>
		<th scope='col' colspan='14' class='fonttitle7' >PERIODO: $periodo</th>";
	}else if($records1['grado']=='10'){
			 echo "<th scope='col' colspan='14' class='fonttitle7' >COMPAÑIA: BOYACA</th>
		<th scope='col' colspan='14' class='fonttitle7' >PERIODO: $periodo</th>";
	}
	echo "
	</tr>
	</table>
	<table class='boletin'>
	<tr >
	<th scope='col' colspan='6' class='fonttitle8' rowspan='2' style='width:24%'>AREAS MILITARES </th>
	<th scope='col' colspan='1' rowspan='2' class='fonttitle8' >VALORACIÓN</th>
	<th scope='col' colspan='3' class='fonttitle8' >INASISTENCIAS</th>
	</tr>
	<tr'>
	<td class='fonttitle4b' >J
	</td>
	<td class='fonttitle4b' >S.J
	</td>
	<td class='fonttitle4b' >T
	</td>
	</tr>";
	$prompar=0;
	$numasig=0;
	$promtotal=0;
	$sqlareas="SELECT DISTINCT codarea, nomarea, SUM(fj) AS fj, SUM(fsj) AS fsj, SUM(ft) AS ft
	FROM areamil, materiamil, tbestudiante, notasmil
	WHERE codest_fk =  ".$records1['codest']."
	AND codmat = codmat_fk
	AND codarea_fk = codarea
	AND codarea_fk !=5
	AND  `condmil` =  'A'
	AND periodo =  '$periodo'
	ORDER BY nomarea";
	$consultanotas = $conx->query($sqlareas);
	while($recordsnotas = $conx->records_array($consultanotas)){
		$sqlnotas="SELECT DISTINCT codmat, nommat, vn, COUNT(codmat_fk) AS nummat  FROM `notasmil`, materiamil, areamil 
		WHERE `codest_fk` ='".$records1['codest']."' AND `periodo` ='$periodo' 
		AND codmat=codmat_fk AND codarea_fk=".$recordsnotas['codarea']."
		AND codarea_fk!=5
		ORDER BY codmat";
		$consultanotas2 = $conx->query($sqlnotas);
		$flagn=false;
		$promedio=0;
		while($recordsnotas2 = $conx->records_array($consultanotas2)){
			$sqlnotas2="SELECT DISTINCT codmat, nommat, vn  FROM `notasmil_nivelacion`, materiamil, areamil 
			WHERE `codest_fk` ='".$records1['codest']."' AND `periodo` ='$periodo' 
			AND codmat_fk = ".$recordsnotas2['codmat']."
			AND codarea_fk!=5
			AND vn > ".$recordsnotas2['vn']."
			ORDER BY codmat";
			$consultanotas3 = $conx->query($sqlnotas2);
			$recordsnotamat = $conx->records_array($consultanotas3)
			if($recordsnotamat!=null){
				$promedio+=$recordsnotamat['vn'];
			}else{
				$promedio+=$recordsnotas2['vn'];
			}
		}
		$prom=$promedio/$recordsnotas2['nummat'];
		if($flagn){
			echo"<tr>
			<td scope='col' colspan='6' class='fonttitle7b' >".$recordsnotas['nomarea']."</td>
			<td scope='col' class='fonttitle9b' >".number_format((float)$prom,2,".",",")."(N)"."</td>
			<td scope='col' class='fonttitle9b' >".$recordsnotas['fj']."</td>
			<td scope='col' class='fonttitle9b' >".$recordsnotas['fsj']."</td>
			<td scope='col' class='fonttitle9b' >".$recordsnotas['ft']."</td>
			</tr>";
			
		}else{
			echo"<tr>
			<td scope='col' colspan='6' class='fonttitle7b' >".$recordsnotas['nomarea']."</td>
			<td scope='col' class='fonttitle9b' >".number_format((float)$prom,2,".",",")."</td>
			<td scope='col' class='fonttitle9b' >".$recordsnotas['fj']."</td>
			<td scope='col' class='fonttitle9b' >".$recordsnotas['fsj']."</td>
			<td scope='col' class='fonttitle9b' >".$recordsnotas['ft']."</td>
			</tr>";
		}
		$prompar+=number_format((float)$prom,2,".",",");
		$numasig++;
		
	}
	$sql = "SELECT DISTINCT FORMAT(AVG (vn),2) AS promedio, COUNT(codmat_fk) AS nummat, SUM(fj) AS fj, SUM(fsj) AS fsj, SUM(ft) AS ft,
	codarea, nomarea 
	FROM areamil, materiamil, tbestudiante, notasmil WHERE codest_fk=".$records1['codest']." AND 
	codmat=codmat_fk AND codarea_fk=codarea AND codarea_fk!=5
	AND `condmil` =  'A'
	AND vn >= 6
	AND periodo='$periodo'
	group by codarea, codest	
	ORDER BY nomarea";
	$consulta2 = $conx->query($sql);
	$prompar=0;
	$numasig=0;
	$promtotal=0;
	while($records2 = $conx->records_array($consulta2)){
		$sqln = "SELECT DISTINCT FORMAT(AVG (vn),2) AS promedio, COUNT(codmat_fk) AS nummat FROM areamil, materiamil, tbestudiante, notasmil_nivelacion 
				WHERE codest_fk=".$records1['codest']."
				AND codmat_fk=codmat
				AND codarea_fk=".$records2['codarea']."
				AND vn > (SELECT notasmil.vn FROM notasmil WHERE 
				notasmil.codest_fk=".$records1['codest']."
				AND notasmil.codmat_fk=codmat
				AND notasmil.periodo = '$periodo')
				AND `condmil` = 'A'
				AND periodo = '$periodo'
				group by codarea, codest";
		$consultan = $conx->query($sqln);
		$recordn = $conx->records_array($consultan);
		if($recordn!=null){
			$prom=(($records2['promedio']*$records2['nummat'])+($recordn['promedio']*$recordn['nummat']))/($records2['nummat']+$recordn['nummat']);
			echo"<tr>
			<td scope='col' colspan='6' class='fonttitle7b' >".$records2['nomarea']."</td>
			<td scope='col' class='fonttitle9b' >".number_format((float)$prom,2,".",",")."(N)"."</td>
			<td scope='col' class='fonttitle9b' >".$records2['fj']."</td>
			<td scope='col' class='fonttitle9b' >".$records2['fsj']."</td>
			<td scope='col' class='fonttitle9b' >".$records2['ft']."</td>
			</tr>";
			$prompar+=number_format((float)$prom,2,".",",");
			
		}else{
			echo"<tr>
			<td scope='col' colspan='6' class='fonttitle7b' >".$records2['nomarea']."</td>
			<td scope='col' class='fonttitle9b' >".number_format((float)$records2['promedio'],2,".",",")."</td>
			<td scope='col' class='fonttitle9b' >".$records2['fj']."</td>
			<td scope='col' class='fonttitle9b' >".$records2['fsj']."</td>
			<td scope='col' class='fonttitle9b' >".$records2['ft']."</td>
			</tr>";
			$prompar+=number_format((float)$records2['promedio'],2,".",",");
		}
		$numasig++;
		
	}
	echo"<tr>
		<td scope='col' colspan='6' class='fonttitle7' >PROMEDIO PARCIAL</td>
		<td scope='col' class='fonttitle7' colspan='4' >".number_format((float)$prompar/$numasig,2,".",",")."</td>
	</tr>
	<tr >
	<th scope='col' colspan='6' class='fonttitle8' style='width:24%'>CONDICIONES MILITARES</th>
	<th scope='col' colspan='1' class='fonttitle8' >VALORACIÓN</th>
	<th scope='col' colspan='3' class='fonttitle8' >OBSERVACIONES</th>
	</tr>";
	
	$promtotal+=number_format((float)$prompar/$numasig,2,".",",");
	$sql = "SELECT DISTINCT FORMAT(AVG (vn),2) AS promedio, notasmil.*,codarea, nommat  
	FROM `notasmil`, areamil,materiamil, tbestudiante WHERE codest_fk=".$records1['codest']." AND 
	codmat=codmat_fk AND codarea_fk=5
	AND `condmil` =  'A'
	AND periodo='$periodo'
	group by nommat, codest
	ORDER BY codmat";
	$consulta2 = $conx->query($sql);
	$prompar=0;
	$numasig=0;
	while($records2 = $conx->records_array($consulta2)){
	 $sqln = "SELECT DISTINCT FORMAT(AVG (vn),2) AS promedio FROM areamil, materiamil, tbestudiante, notasmil_nivelacion 
				WHERE codest_fk=".$records1['codest']."
				AND codmat_fk=".$records2['codmat_fk']."
				AND vn > (SELECT notasmil.vn FROM notasmil WHERE 
				notasmil.codest_fk=".$records1['codest']."
				AND notasmil.codmat_fk=notasmil_nivelacion.codmat_fk
				AND notasmil.periodo = '$periodo')
				AND `condmil` = 'A'
				AND periodo = '$periodo'
				group by codarea, codest";
		$consultan = $conx->query($sqln);
		$recordn = $conx->records_array($consultan);
		if($recordn!=null){
			$prompar+=number_format((float)$recordn['promedio'],2,".",",");
			echo "<tr>
			<td scope='col' colspan='6' class='fonttitle7b' >".$records2['nommat']."</td>
			<td scope='col' class='fonttitle9b' >".number_format((float)$recordn['vn'],2,".",",")."(N)"."</td>
			<td scope='col' class='fonttitle9b'  colspan='3'>".$records2['observaciones']."</td>
			</tr>";
						
		}else{
			echo "<tr>
			<td scope='col' colspan='6' class='fonttitle7b' >".$records2['nommat']."</td>
			<td scope='col' class='fonttitle9b' >".number_format((float)$records2['vn'],2,".",",")."</td>
			<td scope='col' class='fonttitle9b'  colspan='3'>".$records2['observaciones']."</td>
			</tr>";
			$prompar+=number_format((float)$records2['vn'],2,".",",");
		}
	    $numasig++;
	}
	$promtotal+=number_format((float)$prompar/$numasig,2,".",",");
	echo"<tr>
		<td scope='col' colspan='6' class='fonttitle7' >PROMEDIO PARCIAL</td>
		<td scope='col' class='fonttitle7' colspan='4' >".number_format((float)$prompar/$numasig,2,".",",")."</td>
	</tr>";
	echo"<tr>
		<td scope='col' colspan='6' class='fonttitle8' >PROMEDIO TOTAL</td>
		<td scope='col' class='fonttitle7' colspan='4' >".number_format((float)$promtotal/2,2,".",",")."</td>
	</tr>";
	echo "</table>";
	echo "<h1 class='SaltoDePagina'> </h1><br/><br/><table class='boletin'>";

	
	echo"<tr>
		<td scope='col' colspan='10' class='fonttitle8' style='height:20%' ><div style='height:30%;'>OBSERVACIONES GENERALES</div></td>
	</tr>";
	echo"<tr>
		<td scope='col' colspan='10' class='fonttitle7b' style='height:20%' >";
	
	$sqlperiodo="SELECT DISTINCT periodo
	FROM notasmil_nivelacion
	WHERE codest_fk ='".$records1['codest']."' ORDER BY periodo";
	$consultaperiodo = $conx->query($sqlperiodo);
	$bandn=0;
	while($recordsperiodo = $conx->records_array($consultaperiodo)){
		
		if($recordsperiodo['periodo']<=$periodo){
		$bandn=1;
			switch($recordsperiodo['periodo']){
				case 1: echo "<span class='fonttitle7'>PRIMER PERIODO: </span><br/>"; break;
				case 2: echo "<span class='fonttitle7'>SEGUNDO PERIODO: </span><br/>"; break;
				case 3: echo "<span class='fonttitle7'>TERCER PERIODO: </span><br/>"; break;
				case 4: echo "<span class='fonttitle7'>CUARTO PERIODO: </span><br/>"; break;
				default: break;
			
			}
			$sqlobservacion="SELECT observaciones FROM `notasmil_nivelacion` WHERE codest_fk=".$records1['codest']." 
			AND periodo='".$recordsperiodo['periodo']."'";
			$consultaob = $conx->query($sqlobservacion);
			$observaciones="";
			while($recordsob = $conx->records_array($consultaob)){
				if($recordsob['observaciones']!=null){
					$observaciones.=String_oracion($recordsob['observaciones']).". ";
					
				}
			}
			echo String_oracion($observaciones)."<br/><br/>";
		}
	}
	if($bandn==1){
		echo "<span style='color:blue;'>Aclaración: La nota de nivelación solo aplica si esta supera la nota anterior a la nivelación en la materia.</span>";
	}
		
	/*$sql = "SELECT DISTINCT FORMAT(AVG (vn),2) AS promedio, notasmil.*,codarea, nomarea  
	FROM `notasmil`, areamil,materiamil, tbestudiante WHERE codest_fk=".$records1['codest']." AND 
	codmat=codmat_fk AND codarea_fk=codarea AND codarea_fk!=5
	AND `condmil` =  'A'


	group by codarea, codest

	ORDER BY nomarea";
	$consulta2 = $conx->query($sql);
	$areareprobadas="";
	
	while($records2 = $conx->records_array($consulta2)){
		
		if(number_format((float)$records2['vn'],2,".",",") < 6){
			$areareprobadas.=$records2['nomarea'];
		}
	}
	if($areareprobadas!=""){
		echo "AREAS REPROBADAS: ".$areareprobadas;
	}else{
		echo "<br/>";
	}*/
	echo "</td>
	</tr>";

	echo "</table>";
	$sql4 = "SELECT * 
	FROM  `asigareamil` , tbdocente
	WHERE  `coddocen_fk` = codigo
	AND  `grado` =  '$grado'
	AND  `dg` =  'S'";
	$consulta4 = $conx->query($sql4);
	$records4 = $conx->records_array($consulta4);
	$dg ="SM&reg; ".$records4['n1']." ". $records4['n2']." ".$records4['a1']." ".$records4['a2'];
	echo "<BR/><BR/><BR/><BR/><BR/><table class='firma' style='border-color:#FFFFFF;'>
	<tr>
		<td style='border-color:white'><span style='font:15px arial, sans-serif; font-weight:bold;'>$dg</span><br/>
		<span style='font:12px bold arial,sans-serif; font-weight:bold;'>Comandante de Pelotón</span></td>
		<td style='border-color:white'><span style='font:15px arial, sans-serif; font-weight:bold;'>$dg</span><br/>
		<span style='font:12px bold arial,sans-serif; font-weight:bold;'>Comandante de Compañía</span></td>
	</tr>
	<tr>
		<td colspan='2' style='border-color:white'><BR/><BR/><span style='font:15px arial, sans-serif; font-weight:bold;'>CR&reg; CAMILO RUEDA ORTIZ</span><br/>
		<span style='font:12px bold arial,sans-serif; font-weight:bold;'>Director Militar</span></td>
		
	</tr>
	<tr>
		<td colspan='2' style='border-color:white; text-align:left'><BR/><span style='font:15px arial, sans-serif; font-weight:bold; text-align:left;'>NOTA: Cualquier enmendadura o tachón anula este documento</span><br/>
		</td>
		
	</tr>
	
	</table>";
	echo "<div class='pie'>
<p>Dirección: calle Sucre Antiguo Colegio Divino Niño - Frente a la Catedral San Andrés<br>Telefono: 7277001 
<a href='' >www.tumacoaltono.com</a></p>
</div>";
	
	echo "<h1 class='SaltoDePagina'> </h1>";
	//-------------------------------FIN LADO A------------------------------------------------

 }
 if($existenNotas==false){
  echo "<span class='Estilo1 blocktext' align='center'>NO EXISTEN NOTAS PARA ESTE PERIODO</span><br/><br/><br/>
						  <span align='center' class='blocktext'><img  src='ESCUDO TRASNPARENTE.png' width='80' height='80'/></span>";
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