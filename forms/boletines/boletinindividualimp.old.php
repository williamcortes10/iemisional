<?php
session_start();
include('../../class/MySqlClass.php');

$conx = new ConxMySQL("localhost","root","","appacademy");
$sql = "SELECT valor FROM appconfig WHERE item='ie'";
$consulta = $conx->query($sql);
$records = $conx->records_array($consulta);
$ie= $records['valor'];
$sqlaaula = "SELECT descripcion FROM aula WHERE idaula = ".$_POST["aula"];
$consultaaula = $conx->query($sqlaaula);    
$recordsaula = $conx->records_array($consultaaula);
$aula=$recordsaula['descripcion'];
$p=$_POST["periodo"];
$al=$_POST["aniolect"];
$id=$_POST['idestudiante'];
?>
<html>
<head>
<title><?php echo $ie."-BOLETIN GRADO $aula-PERIODO $p - $al"; ?></title>
<link  href="http://fonts.googleapis.com/css?family=Cabin+Sketch:bold" rel="stylesheet" type="text/css" >
<link  href="http://fonts.googleapis.com/css?family=Lobster:regular" rel="stylesheet" type="text/css" >
<link  href="http://fonts.googleapis.com/css?family=Tangerine:regular,bold" rel="stylesheet" type="text/css" >

<link rel="stylesheet" type="text/css" href="../../css/boletin.css" media="print, screen">
</head>
<body>
<div>
<?php
include("../../class/phpdocx/classes/createDocx.inc");
$docx = new CreateDocx();
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
$docx->addText($text, $paramsText);
$docx->createDocx('example_text');
include("../../class/ultimatemysql/mysql.class.php");
$conx = new ConxMySQL("localhost","root","","appacademy");
//-----------------------------datos basicos de colegio

$sql = "SELECT valor FROM appconfig WHERE item = 'ie'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$ie = $records['valor'];
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
$idaula = $_POST['aula'];
$periodo= $_POST['periodo'];
$aniolect= $_POST['aniolect'];
$formato= $_POST['formato'];
function String_oracion($string){
 $stringReturn="";
 $arraySplit = explode('.', $string);
 for($i=0; $i<count($arraySplit); $i++){
	
	$arraySplit[$i]=ucfirst($arraySplit[$i]);
 }
 $stringReturn = implode(".", $arraySplit);
 return $stringReturn;
}
//aula
$sqlaaula = "SELECT descripcion FROM aula WHERE idaula = $idaula";
$consultaaula = $conx->query($sqlaaula);    
$recordsaula = $conx->records_array($consultaaula);
$grado=$recordsaula['descripcion'];
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
if($existeescala==1){
			
    if($formato=="f1"){
        
           $sqlest = "SELECT DISTINCT e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula, e.idestudiante 
			FROM estudiante e, notas n, matricula m 
        	WHERE e.idestudiante=$id AND e.idestudiante=n.idestudiante AND m.idestudiante=n.idestudiante
			AND m.idaula=$idaula AND e.habilitado='S' 
			AND n.periodo=$periodo AND m.periodo='0' 
			AND n.aniolectivo=$aniolect AND m.aniolectivo=n.aniolectivo
			AND m.tipo_matricula='R' AND n.tipo_nota=m.tipo_matricula
			ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";
        	$consultaest = $conx->query($sqlest);
            while($records1 = $conx->records_array($consultaest)){
            	echo 
                "<div class='fondo'><div style='line-height:7px;'>
                <table class='normal'>
                        <tr>
                            <td width='100px' align='left' rowspan='2' valign='top'>
                                <span  class='blocktext'><img  src='../../images/logocol.png' width='80' height='80'/></span>
                            </td>
                            <td >
                                <span class='ie' align='center'>".($ie)."</span><br/>
            	                <span class='lema' align='center'>".($lema)."</span><br/>
            	                <span class='lema' align='center'>".($localizacion)."</span><br/>
                                
                            </td>
                        </tr>
                        <tr>
                            <td colspan='2'>
                            <span class='tituloinforme' align='center'>AÑO LECTIVO $aniolect</span>";
                                    if($periodo=='4'){
                                        echo "<span align='center' class='tituloinforme' align='center'><p class='fonttitle6'>INFORME FINAL</p></span>";        
                                    }else{
                                        echo "<span align='center' class='tituloinforme' align='center'><p class='fonttitle6'>INFORME $periodo"."°"." PERIODO</p></span>";        
									
									}
                                echo "
                            </td>
                        </tr>
                        
                </table>
            	</div>";
            	echo "<br/><table class='alumno'>
            	<tr >
            	<td colspan='14' class='fonttitle7'   style='width:80%'>ESTUDIANTE:&nbsp;".
                utf8_decode($records1['nombre1'])." ".utf8_decode($records1['nombre2'])." ".utf8_decode($records1['apellido1'])." ".utf8_decode($records1['apellido2'])."
                <br/>GRADO:&nbsp;".$grado." th
                </td>
            	</tr>
            	</table>";
				//-----------------------------------numero de paginas
				$sql = "SELECT DISTINCT mt.nombre_materia, n.* 
            	FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
				AND mt.idmateria=n.idmateria AND n.periodo=$periodo  AND n.aniolectivo=$aniolect 
				AND n.tipo_nota='R' ORDER BY mt.nombre_materia ASC";
            	$consulta2 = $conx->query($sql);
            	$numasig=0;
            	$numasigimp=0;
				$numapaginas=1;
            	while($records2 = $conx->records_array($consulta2)){
                    	$numasig++;
						$numasigimp++;
                        if($numasigimp>5){
								$numasigimp=0;
								$numapaginas++;
						}
                                    
            	}
                
				if($numasigimp>3){
					$numasigimp=0;
					$numapaginas++;
				}
				//----------------------------------------------------
                //Generar resultados por asignatura
                $sql = "SELECT DISTINCT mt.nombre_materia, n.* 
            	FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
				AND mt.idmateria=n.idmateria AND n.periodo=$periodo  AND n.aniolectivo=$aniolect 
				AND n.tipo_nota='R' ORDER BY mt.nombre_materia ASC";
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
                $numasigimp=0;
				$pagina=1;
            	while($records2 = $conx->records_array($consulta2)){
                    	$numasig++;
						$numasigimp++;
                        $desct='';
                        if($records2['vn'] >= (float)$rcbamin and $records2['vn'] <= (float)$rcbamax){
                    		$desempeno="Db"; 
                    	}else if($records2['vn'] >= (float)$rcbmin and $records2['vn'] <= (float)$rcbmax){
                    		$desempeno="DB";
                    	}else if($records2['vn'] >= (float)$rcamin and $records2['vn'] <= (float)$rcamax){
                    		$desempeno="DA";
                    	}else if($records2['vn'] >= (float)$rcsmin and $records2['vn'] <= (float)$rcsmax){
                    		$desempeno="DS";
                    	}
                    	if($desempeno=='Db'){
                    		$desempeno2="D-";
                    	}else{
                    		$desempeno2=$desempeno;
                    	}
                    	switch($records2['comportamiento']){
                    		case "DS": $sumDS++; break;
                    		case "DA": $sumDA++; break;
                    		case "DB": $sumDB++; break;
                    		case "D-": $sumDb++; break;
                    		default: break;
                    	}
						//docente que tiene la materia 
                 		$sqld = "SELECT DISTINCT c.ih, d. * 
                        FROM clase c, docente d
                        WHERE c.idmateria=  '".$records2['idmateria']."'
                        AND c.idaula = $idaula
                        AND c.aniolectivo =  $aniolect
                        AND c.iddocente = d.iddocente";
                        $consultad = $conx->query($sqld);
                		$recordsd = $conx->records_array($consultad);
                        $docente = utf8_decode($recordsd['nombre1'])." ".utf8_decode($recordsd['nombre2'])." ".utf8_decode($recordsd['apellido1'])." ".utf8_decode($recordsd['apellido2']);
                        $ih = $recordsd['ih'];
                        $iddocente = $recordsd['iddocente'];
                        //descripcion del indicador de desempeño
						$sql3 = "SELECT DISTINCT i.descripcion 
                		FROM indicadores i, indicadoresestudiante ib 
						WHERE i.idindicador=ib.idindicador AND i.idmateria=".$records2['idmateria']."
						AND i.idaula='".$idaula."' AND i.tipo='DS' 
                		AND ib.periodo=$periodo AND ib.aniolectivo=$aniolect
						AND ib.idestudiante=".$records1['idestudiante']." ORDER BY ib.idindicador ASC";
                		$consulta3 = $conx->query($sql3);
						$desct="<ul>";
                		while($records3 = $conx->records_array($consulta3)){
                		  $desct.="<li style='list-style-type:circle'>".String_oracion($records3['descripcion'])."</li>	";
						}
						$desct.="</ul>";
                        $sqldg = "SELECT DISTINCT d.* 
                        FROM clase c, docente d
                        WHERE c.idaula = $idaula
                        AND c.aniolectivo =  $aniolect
                        AND c.dg='S' AND c.iddocente=d.iddocente";
                        $consultadg = $conx->query($sqldg);
                		$recordsdg = $conx->records_array($consultadg);
                        $docentedg = $recordsdg['apellido1']." ".$recordsdg['apellido2']." ".$recordsdg['nombre1']." ".$recordsdg['nombre2'];
                        echo"<br/><table class='resultadoasig'>
                            <tbody>
                            <tr style=''>
                                <td width='100' style='text-align:center;' class='textcn'>".utf8_decode($records2['nombre_materia'])."</td>
                                <td width='277'><span style='font-style: italic;'>Prof:</span> <span class='textcn'>$docente</span></td>
                                <td width='66' style='text-align:center;' class='textcn'>I.H: $ih</td>
                                <td width='76' style='text-align:center;' colspan='2' class='textcn'>FALTAS</td>
                                <td width='47' style='text-align:center;' class='textcn'>V.N</td>
                                <td width='96' style='text-align:center;' class='textcn'>DESEMPEÑO</td>
                            </tr>
                            <tr style=''>
                                <td width='499' colspan='3' style='text-align:center; background-color: #E5E5E5;'>Indicadores de Desempeño</td>
                                <td width='38' valign='top' style='text-align:center;' class='textcn'>CJ</td>
                                <td width='38' valign='top' style='text-align:center;' class='textcn'>SJ</td>
                                <td width='47' rowspan='2' style='text-align:center;'><span style='font-weight:bold;'>".number_format((float)$records2['vn'],1,".",",")."</span></td>
                                <td width='96' rowspan='2' style='text-align:center; '><span style='font-weight:bold;'>".$desempeno."</span></td>
                            </tr>
                            <tr >
                                <td width='499' colspan='3'  ><div align='justify'>$desct</div></td>
                                <td width='38' style='text-align:center;'>".$records2['fj']."</td>
                                <td width='38' style='text-align:center;'>".$records2['fsj']."</td>
                            </tr>
                            </tbody></table>";
							if($numasigimp>5){
									echo "</div><br/><span style='text-align:right; margin-left:700px' class='continuapag'>PAGINA $pagina DE $numapaginas</span><h1 class='SaltoDePagina'> </h1><div class='fondo'><span class='continuapag'>CONTINUA BOLETIN: ".
									utf8_decode($records1['nombre1'])." ".utf8_decode($records1['nombre2'])." ".utf8_decode($records1['apellido1'])." ".
									utf8_decode($records1['apellido2'])."  &nbsp;&nbsp;&nbsp;$periodo"."°"." PERIODO</span><br/>";
									$numasigimp=0;
									$pagina++;
							}
                                    
            	}
                //------------------COMPORTAMIENTO
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
				if($numasigimp>3){
									echo "</div><br/><span style='text-align:right; margin-left:700px' class='continuapag'>PAGINA $pagina DE $numapaginas</span><h1 class='SaltoDePagina'> </h1><div class='fondo'><span class='continuapag'>CONTINUA BOLETIN: ".
									utf8_decode($records1['nombre1'])." ".utf8_decode($records1['nombre2'])." ".utf8_decode($records1['apellido1'])." ".
									utf8_decode($records1['apellido2'])."  &nbsp;&nbsp;&nbsp;$periodo"."°"." PERIODO</span><br/>";
									$numasigimp=0;
									$pagina++;
				}
            	echo "<br/>
                <table class='resultadoasig'>
                    <tr>
                	<td scope='col' colspan='6' class='Estilo5' >CONSOLIDADO CONVIVENCIAL</td>
            		<td scope='col' colspan='10	' class='fonttitle8' ><span style='fon-size:small; font-family: Times New Roman,sans-serif; font-weight:bold;'>$comportamiento: </span>";
            	$sql3 = "SELECT DISTINCT descripcion 
            		FROM comportamiento WHERE tipo='$comportamiento' ORDER BY descripcion ASC";
            		$consulta3 = $conx->query($sql3);
            	echo "<span style='fon-size:small; font-family: Times New Roman,sans-serif;'> ";
            		while($records4 = $conx->records_array($consulta3)){
            		echo String_oracion($records4['descripcion'])." ";
            		
            		}
                echo "</span>
                    </td>
                    </tr>
                </table>";    
                //------------------FIN COMPORTAMIENTO
                //------------------PUESTO PERIODO Y ANUAL
                    $sqlTasig = "SELECT DISTINCT idmateria FROM clase WHERE aniolectivo=$aniolect AND idaula=$idaula";
                	$consultaTasig= $conx->query($sqlTasig);
                	$numasigProm= $conx->get_numRecords($consultaTasig);
                	$sqlpuesto = "SELECT AVG( vn ) AS promedio, SUM( vn ) AS sumnotas, n.idestudiante 
                	FROM notas n, estudiante e, matricula m WHERE m.idaula='$idaula' AND n.idestudiante=e.idestudiante AND n.periodo='$periodo' 
                    AND m.idestudiante=e.idestudiante AND e.habilitado='S'
                    AND n.aniolectivo=$aniolect 
                    AND m.aniolectivo=n.aniolectivo
					AND m.tipo_matricula='R'
					AND m.tipo_matricula=n.tipo_nota
                	GROUP BY n.idestudiante
                	ORDER BY promedio DESC";
                	$sqlpuestoanio = "SELECT ROUND(AVG( vn ),3) AS promedio, SUM( vn ) AS sumnotas, n.idestudiante"
                    . "	FROM notas n, estudiante e, matricula m WHERE m.idaula='$idaula' AND n.idestudiante=e.idestudiante 
					AND m.idestudiante=e.idestudiante AND e.habilitado='S' 
					AND n.aniolectivo=$aniolect 
                    AND m.aniolectivo=n.aniolectivo
					AND m.tipo_matricula='R'
					AND m.tipo_matricula=n.tipo_nota
                	GROUP BY n.idestudiante
                	ORDER BY promedio DESC";
                	$consultapuesto = $conx->query($sqlpuesto);
                	$consultapuestoanio = $conx->query($sqlpuestoanio);
                	$puesto=1;
                	$puestoanio=1;
                	$numest= $conx->get_numRecords($consultapuesto);
                	$notaEstAnt=0;
                	while($recordspuesto = $conx->records_array($consultapuesto)){
                		if(!($records1['idestudiante']==$recordspuesto['idestudiante'])){
                			$puesto++;
                		}else{
                			$promedio=$recordspuesto['promedio'];
                			break;
                		}
                	}
                	if($periodo==4){
                		while($recordspuestoanio = $conx->records_array($consultapuestoanio)){
                			if(!($records1['idestudiante']==$recordspuestoanio['idestudiante'])){
                				$puestoanio++;
                			}else{
                				$promedioanio=$recordspuestoanio['promedio'];
                				break;
                			}
                		}
                	}
                
                	echo "<br/><table class='resultadoasig'>";
                	if($periodo==4){
                		echo "<tr><td style='text-align:left; font:12px arial,sans-serif;'>
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >PROMEDIO GENERAL PERIODO:</span> ".number_format((float)$promedio,2,".",",")." 
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold; ' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPUESTO: </span>$puesto
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >DE</span> $numest</td>
                		<td style='text-align:left; font:12px 	arial,sans-serif;'>
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >PROMEDIO GENERAL AÑO LECTIVO:</span> ".number_format((float)$promedioanio,3,".",",")." 
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold; ' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPUESTO: </span>$puestoanio
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >DE</span> $numest</td></tr>";
                	}else{
                	
                		echo "<tr><td style='text-align:left; font:12px 	arial,sans-serif;'>
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >PROMEDIO GENERAL PERIODO:</span> ".number_format((float)$promedio,2,".",",")." 
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold; ' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPUESTO: </span>$puesto
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >DE</span> $numest</td></tr>";
                	}
                
                	echo "</table><br/>";
                    if($mPerdidas>0 and $mPerdidas <3){
                        $estadoP= "<span style='color:red;'>"."PROMOCION PENDIENTE,"."</span> Tiene $mPerdidas área(s) reprobada(s)";
                    }elseif($mPerdidas>2){
            		      $estadoP= "<span style='color:red;'>"."DEBE REPETIR EL GRADO, "."</span> Tiene $mPerdidas área(s) reprobada(s).";
                    }elseif($mPerdidas==0){
                        $estadoP= "FUE PROMOVIDO(A)";
            			switch($grado){
            			 case '1': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO SEGUNDO"; break;
            			 case '2': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO TERCERO"; break;
            			 case '3': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO CUARTO"; break;
            			 case '4': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO QUINTO"; break;
            			 case '5': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO SEXTO"; break;
                         case '6': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO SEPTIMO"; break;
            			 case '7': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO OCTAVO"; break;
            			 case '8': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO NOVENO"; break;
                         case '9': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO DECIMO"; break;
            			 case '10': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO ONCE"; break;
            	         default: $estadoP=""; break;
            									
            			}
                        $estadoP.=" SEGÚN LO ESTABLECIDO EN EL PEI DEL COLEGIO";
            		}
                	
                    echo "<br/><table class='resultadoasig'>";
                	if($periodo==4){
                		echo "<tr><td style='text-align:left; font:12px 	arial,sans-serif;'>
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >$estadoP</span></td></tr>";
                	}
                   	echo "</table><br/>";
                    
                    //------------------FIN PUESTO 
                    //------------------OBSERVACIONES
                    echo "
                    <br/><table class='alumno' border='0' cellspacing='5px' >
                	   <tr >
                	   <th colspan='2'>
                	       <p class='Estilo5' align='center'>OBSERVACIONES</p>
                	   </th>
                	   </tr>
                	   <tr>
                            <td width='30%' align='left' class='Estilo6'>ASIGNATURA</td>
                            <td  align='left' class='Estilo2' >OBSERVACI&Oacute;N</td>";	
                			//observaciones generales
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
                                echo "<tr>
                				        <td  class='Estilo1'>".$recordsog['nombre_materia']."</td>
                	                   <td align='left' valign='top' style='line-height:15px; text-align:justify'>
                						<span class='Estilo7' >".
                						String_oracion($observaciones)."</span>&nbsp;
                				        </td>
                                    </tr>";
                			}
                	       }
                        //---------------------------CONVENCIONES
                        echo "
                        </table><br/><div class='firma'>
                        <table class='convenciones'>
                        <tr>
                            <td width='150px' colspan='4' valign='center' style='text-align:center; background:#E5E5E5;'>Convenciones</td>
                        </tr>
                        <tr>
                            <td width='45' valign='top'>C.J</td>
                            <td width='161' valign='top' class='Estilo7'>Con Justificación</td>
							<td width='45' valign='top'>DS</td>
                            <td width='161' valign='top' class='Estilo7'>Desempeño Superior [".number_format((float)$rcsmin,1,'.',',')." a ".number_format((float)$rcsmax,1,'.',',')."]</td>
                        </tr>
                        <tr>
                            <td width='45' valign='top'>S.J</td>
                            <td width='161' valign='top' class='Estilo7' >Sin Justificación</td>
							<td width='45' valign='top'>DA</td>
                            <td width='161' valign='top' class='Estilo7'>Desempeño Alto [".number_format((float)$rcamin,1,'.',',')." a ".number_format((float)$rcamax,1,'.',',')."]</td>
                        </tr>
                        <tr>
                            <td width='45' valign='top'>D</td>
                            <td width='161' valign='top' class='Estilo7' >Definitiva</td>
							<td width='45' valign='top'>DB</td>
                            <td width='161' valign='top' class='Estilo7'>Desempeño Básico [".number_format((float)$rcbmin,1,'.',',')." a ".number_format((float)$rcbmax,1,'.',',')."]</td>
                        </tr>
                        <tr>
                            <td width='45' valign='top'>I.H</td>
                            <td width='161' valign='top' class='Estilo7' >Intensidad Horaria</td>
							<td width='45' valign='top'>Db</td>
                            <td width='161' valign='top' class='Estilo7'>Desempeño Bajo [".number_format((float)$rcbamin,1,'.',',')." a ".number_format((float)$rcbamax,1,'.',',')."]</td>
                        </tr>
                        <tr>
                            <td width='45' valign='top'>V.N</td>
                            <td width='161' valign='top' class='Estilo7' >Valoración Numérica</td>
							<td width='45' valign='top'></td>
                            <td width='161' valign='top' class='Estilo7'></td>
                        </tr>
                    </table></div>"; 
						$sqldg = "SELECT DISTINCT d.* 
							FROM coordinadoresgrupo c, docente d
							WHERE c.idaula = $idaula
							AND c.aniolectivo =  $aniolect
							AND c.iddocente = d.iddocente";
							$consultadg = $conx->query($sqldg);
							$recordsd = $conx->records_array($consultadg);
							$docentedg = $recordsd['apellido1']." ".$recordsd['apellido2']." ".$recordsd['nombre1']." ".$recordsd['nombre2'];					
                	   if($periodo==4){
							echo 
							"<div style='line-height:7px;'>
							<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
							<table class='firma' border='0'>
									<tr>
										<td width='50%' align='center'>
											<span  class='blocktext' style='text-decoration:overline; font-weight:bold'>$nrector</span>
											<br/><span align='center' class='blocktext' >Director(a)</span>
						
										</td>
										<td align='center'>
											<span class='blocktext' style='text-decoration:overline; font-weight:bold'>$docentedg</span>
											<br/><span align='center' class='blocktext' >Director(a) de Grupo</span>
										</td>
									</tr>
									<tr>
										<td colspan='2' align='center'><br/><br/><br/>
											<br/><span align='center' class='blocktext' style='text-decoration:overline; font-weight:bold' >Padre de Familia o Acudiente</span>
										</td>
									</tr>
							</table>
							</div>";
					   
					   }else{
							echo 
							"<div style='line-height:7px;'>
							<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
							<table class='firma' border='0'>
									<tr>
										<td width='50%' align='center'>
											<span class='blocktext' style='text-decoration:overline; font-weight:bold'>$docentedg</span>
											<br/><span align='center' class='blocktext' >Director(a) de Grupo</span>
						
										</td>
										<td align='center'>
											<br/><span align='center' class='blocktext' style='text-decoration:overline; font-weight:bold' >Padre de Familia o Acudiente</span>
										</td>
									</tr>
							</table>
							</div>";
						
					   }
					   
                    	echo "</div><br/><br/><br/><br/><span style='text-align:right; margin-left:700px; position:relative;' class='continuapag'>PAGINA $pagina DE $numapaginas</span><h1 class='SaltoDePagina'></h1>";
                        
                	//-------------------------------FIN LADO B------------------------------------------------  
			}
	}elseif($formato=="f2"){
			$sqlest = "SELECT DISTINCT e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula, e.idestudiante 
			FROM estudiante e, notas n, matricula m 
        	WHERE e.idestudiante=$id AND e.idestudiante=n.idestudiante AND m.idestudiante=n.idestudiante
			AND m.idaula=$idaula AND e.habilitado='S' 
			AND n.periodo=$periodo AND m.periodo='0' 
			AND n.aniolectivo=$aniolect AND m.aniolectivo=n.aniolectivo
			AND m.tipo_matricula='R' AND n.tipo_nota=m.tipo_matricula
			ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";
        	$consulta1 = $conx->query($sqlest);
            while($records1 = $conx->records_array($consulta1)){
    
               	 echo 
                    "<div style='line-height:7px;'>
                    <table class='normal'>
                            <tr>
                                <td width='100px' align='left' rowspan='2'>
                                    <span  class='blocktext'><img  src='../../images/logocol.png' width='80' height='80'/></span>
                                </td>
                                <td >
                                    <span class='ie' align='center'>".($ie)."</span><br/>
									<span class='lema' align='center'>".($lema)."</span><br/>
									<span class='lema' align='center'>".($localizacion)."</span><br/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2'>
                                <span align='center' class='lema'>AÑO LECTIVO $aniolect</span>";
                                    if($periodo=='4'){
                                        echo "<span align='center' class='tituloinforme' align='center'><p class='fonttitle6'>INFORME FINAL</p></span>";        
                                    }else{
                                        echo "<span align='center' class='tituloinforme' align='center'><p class='fonttitle6'>INFORME $periodo"."°"." PERIODO</p></span>";        
									
									}
                                    echo "
                                </td>
                            </tr>
                            
                            
                    </table>
                	</div>";
                	echo "<br/><table class='alumno'>
                	<tr >
                	<td colspan='14' class='fonttitle7'   style='width:80%'>ESTUDIANTE:&nbsp;".
					utf8_decode($records1['nombre1'])." ".utf8_decode($records1['nombre2'])." ".utf8_decode($records1['apellido1'])." ".utf8_decode($records1['apellido2'])."
					<br/>GRADO:&nbsp;".$grado." th
                    </td>
                	</tr>
                	</table>";
					//-----------------------------------numero de paginas
					$sql = "SELECT DISTINCT mt.nombre_materia, n.* 
					FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
					AND mt.idmateria=n.idmateria AND n.periodo=$periodo  AND n.aniolectivo=$aniolect 
					AND n.tipo_nota='R' ORDER BY mt.nombre_materia ASC";
					$consulta2 = $conx->query($sql);
					$numasig=0;
					$numasigimp=0;
					$numapaginas=1;
					while($records2 = $conx->records_array($consulta2)){
							$numasig++;
							$numasigimp++;
							if($numasigimp>5){
									$numasigimp=0;
									$numapaginas++;
							}
										
					}
					
					if($numasigimp>3){
						$numasigimp=0;
						$numapaginas++;
					}
					//----------------------------------------------------
                    //Generar resultados por asignatura
                    $sql = "SELECT DISTINCT mt.nombre_materia, n.* 
					FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
					AND mt.idmateria=n.idmateria AND n.periodo=$periodo  AND n.aniolectivo=$aniolect 
					AND n.tipo_nota='R' ORDER BY mt.nombre_materia ASC";
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
                    $mPerdidas=0;
					$numasigimp=0;
					$pagina=1;
                	while($records2 = $conx->records_array($consulta2)){
                        	$numasig++;
							$numasigimp++;
                            $desct='';
                            if($records2['vn'] >= (float)$rcbamin and $records2['vn'] <= (float)$rcbamax){
                        		$desempeno="Db"; 
                        	}else if($records2['vn'] >= (float)$rcbmin and $records2['vn'] <= (float)$rcbmax){
                        		$desempeno="DB";
                        	}else if($records2['vn'] >= (float)$rcamin and $records2['vn'] <= (float)$rcamax){
                        		$desempeno="DA";
                        	}else if($records2['vn'] >= (float)$rcsmin and $records2['vn'] <= (float)$rcsmax){
                        		$desempeno="DS";
                        	}
                        	if($desempeno=='Db'){
                        		$desempeno2="D-";
                        	}else{
                        		$desempeno2=$desempeno;
                        	}
                            
                        	switch($records2['comportamiento']){
                        		case "DS": $sumDS++; break;
                        		case "DA": $sumDA++; break;
                        		case "DB": $sumDB++; break;
                        		case "D-": $sumDb++; break;
                        		default: break;
                        	}
                            //docente que tiene la materia 
							$sqld = "SELECT DISTINCT c.ih, d. * 
							FROM clase c, docente d
							WHERE c.idmateria=  '".$records2['idmateria']."'
							AND c.idaula = $idaula
							AND c.aniolectivo =  $aniolect
							AND c.iddocente = d.iddocente";
							$consultad = $conx->query($sqld);
							$recordsd = $conx->records_array($consultad);
							$docente = utf8_decode($recordsd['nombre1'])." ".utf8_decode($recordsd['nombre2'])." ".utf8_decode($recordsd['apellido1'])." ".utf8_decode($recordsd['apellido2']);
							$ih = $recordsd['ih'];
							$iddocente = $recordsd['iddocente'];
							//descripcion del indicador de desempeño
							$sql3 = "SELECT DISTINCT i.descripcion 
							FROM indicadores i, indicadoresestudiante ib 
							WHERE i.idindicador=ib.idindicador AND i.idmateria=".$records2['idmateria']."
							AND i.idaula='".$idaula."' AND i.tipo='DS' 
							AND ib.periodo=$periodo AND ib.aniolectivo=$aniolect
							AND ib.idestudiante=".$records1['idestudiante']." ORDER BY ib.idindicador ASC";
							$consulta3 = $conx->query($sql3);
							$desct="<ul>";
                    		while($records3 = $conx->records_array($consulta3)){
								$desct.="<li style='list-style-type:circle'>".String_oracion($records3['descripcion'])."</li>	";                    		//$desc=ucfirst($desc);
                    		
                    		}
                            $desct.="</ul>";
							$sqldg = "SELECT DISTINCT d.* 
							FROM clase c, docente d
							WHERE c.idaula = $idaula
							AND c.aniolectivo =  $aniolect
							AND c.dg='S' AND c.iddocente=d.iddocente";
							$consultadg = $conx->query($sqldg);
							$recordsdg = $conx->records_array($consultadg);
							$docentedg = $recordsdg['apellido1']." ".$recordsdg['apellido2']." ".$recordsdg['nombre1']." ".$recordsdg['nombre2'];
                            //NUMERO DE NIVELACIONES
                            $sqlnivelacion = "SELECT DISTINCT periodo
                        	FROM notas n, materia m WHERE n.idestudiante='".$records1['idestudiante']."' AND n.aniolectivo=$aniolect  
                            AND n.idmateria=".$records2['idmateria']." AND n.tipo_nota='N' AND n.idmateria=m.idmateria ORDER BY nombre_materia ASC";
                        	$consultanivelacion = $conx->query($sqlnivelacion);
                        	$flagnivel = $conx->get_numRecords($consultanivelacion);
                        	if($flagnivel>0){
                        		$colspan=$periodo+(int)$flagnivel;
                        	}else{
                        		$colspan=$periodo;
                        	}
                            //-------------------
                            echo"<br/><table class='resultadoasig'>
                                <tbody>
                                <tr style=''>
                                    <td width='100' style='text-align:center;' class='textcn' rowspan='2'>".utf8_decode($records2['nombre_materia'])."</td>
                                    <td width='277' rowspan='2'><span style='font-style: italic;'>Prof:</span> <span class='textcn'>$docente</span></td>
                                    <td width='66' style='text-align:center;' class='textcn' rowspan='2'>I.H: $ih</td>
                                    <td width='76' style='text-align:center;' colspan='2' class='textcn'>FALTAS</td>";
									if($periodo!=1){
										echo "<td width='47' style='text-align:center;' colspan='$colspan' class='textcn' >V.N PERIODOS</td>";
									}else{
										echo "<td width='47' style='text-align:center;' colspan='$colspan' class='textcn' >V.N PERIODO</td>";
									}
                                    echo "<td width='47' style='text-align:center;'  rowspan='2' class='textcn'>D</td>
                                    <td width='96' style='text-align:center;'  rowspan='2' class='textcn'>DESEMPEÑO</td>
                                </tr>
                                <tr style=''>
                                    <td width='38' valign='top' style='text-align:center;' class='textcn'>CJ</td>
                                    <td width='38' valign='top' style='text-align:center;' class='textcn'>SJ</td>
                                    ";
                                    for($p=1; $p<$periodo+1; $p++){
                                        $sqlhis = "SELECT DISTINCT n.vn, n.periodo, n.idmateria 
                                        FROM notas n WHERE idestudiante='".$records1['idestudiante']."' AND periodo='$p' AND n.idmateria='".$records2['idmateria']."' 
                                        AND aniolectivo='$aniolect' AND n.tipo_nota='R'";
                                        $consultasqlhis = $conx->query($sqlhis);
                                        $recordshis = $conx->records_array($consultasqlhis);
                                        echo "<td width='47' style='text-align:center;' class='textcn' >$p"."°"."</td>";
                                        $sqldatnivel = "SELECT DISTINCT n.vn, n.periodo, n.idmateria 
                                        FROM notas n WHERE idestudiante='".$records1['idestudiante']."' AND periodo='$p' AND n.idmateria='".$records2['idmateria']."' 
                                        AND aniolectivo='$aniolect' AND n.tipo_nota='N'";
                                        $consultadatnivel = $conx->query($sqldatnivel);
                						$recordsnivel = $conx->records_array($consultadatnivel);
                						if($conx->get_numRecords($consultadatnivel)>0){	 
                						  	echo "<td width='47' style='text-align:center;' class='textcn' >NV</td>";
                                        }
                                    }
                                    echo "
                                </tr>
                                <tr style=''>
                                    <td width='499' colspan='3' style='text-align:center; background-color: #E5E5E5;'>Indicadores de Desempeño</td>
                                    <td width='38' rowspan='2' style='text-align:center;'>".$records2['fj']."</td>
                                    <td width='38' rowspan='2' style='text-align:center;'>".$records2['fsj']."</td>
                                    ";
                                    $sumaprogeneral=0;
                                    $promfinal=0;
            						$periodosDiv=0;
                                    for($p=1; $p<$periodo+1; $p++){
                                        $periodosDiv++;
                                        $sqlhis = "SELECT DISTINCT n.vn, n.periodo, n.idmateria 
                                        FROM notas n WHERE idestudiante='".$records1['idestudiante']."' AND periodo='$p' AND n.idmateria='".$records2['idmateria']."' 
                                        AND aniolectivo='$aniolect' AND n.tipo_nota='R'";
                                        $consultasqlhis = $conx->query($sqlhis);
                                        $recordshis = $conx->records_array($consultasqlhis);
                                        if($recordshis!=null){
                                            echo "<td rowspan='2' style='text-align:center;'><span style='font-weight:bold;'>".number_format((float)$recordshis['vn'],1,".",",")."</span></td>";
                                            $sumaprogeneral+=$recordshis['vn'];
                                            $promfinal=$sumaprogeneral/$periodosDiv;
                                        }else{
                                            echo "<td rowspan='2' style='text-align:center;'></td>";
                                            $periodosDiv--;
                                        }
                                        
                						$sqldatnivel = "SELECT DISTINCT n.vn, n.periodo, n.idmateria 
                                        FROM notas n WHERE idestudiante='".$records1['idestudiante']."' AND periodo='$p' AND n.idmateria='".$records2['idmateria']."' 
                                        AND aniolectivo='$aniolect' AND n.tipo_nota='N'";
                                        $consultadatnivel = $conx->query($sqldatnivel);
                						$recordsnivel = $conx->records_array($consultadatnivel);
                						if($conx->get_numRecords($consultadatnivel)>0){	 
                						  	echo "<td rowspan='2' style='text-align:center;'><span style='font-weight:bold;'>".number_format((float)$recordsnivel['vn'],1,".",",")."</span></td>";
                                              if($recordsnivel['vn'] > $promfinal){
                								$periodosDiv--;
                                                $sumaprogeneral=$recordsnivel['vn'];
                                                $promfinal=$sumaprogeneral;
              								}
                                        }
                                    }
                                    
                                    if($promfinal >= (float)$rcbamin and $promfinal <= (float)$rcbamax){
                                		$desempeno="Db";
                                        $mPerdidas++; 
                                	}else if($promfinal >= (float)$rcbmin and $promfinal <= (float)$rcbmax){
                                		$desempeno="DB";
                                	}else if($promfinal >= (float)$rcamin and $promfinal <= (float)$rcamax){
                                		$desempeno="DA";
                                	}else if($promfinal >= (float)$rcsmin and $promfinal <= (float)$rcsmax){
                                		$desempeno="DS";
                                	}
                                    echo "<td width='47' rowspan='2' style='text-align:center;'><span style='font-weight:bold;'>".number_format((float)$promfinal,1,".",",")."</span></td>
                                    <td width='96' rowspan='2' style='text-align:center; '><span style='font-weight:bold;'>".$desempeno."</span></td>
                                </tr>
                                <tr >
                                    <td width='499' colspan='3'  ><div align='justify'>$desct</div></td>
                                </tr>
                                </tbody></table>";
								if($numasigimp>5){
									echo "</div><br/><span style='text-align:right; margin-left:700px' class='continuapag'>PAGINA $pagina DE $numapaginas</span><h1 class='SaltoDePagina'> </h1><div class='fondo'><span class='continuapag'>CONTINUA BOLETIN: ".
									utf8_decode($records1['nombre1'])." ".utf8_decode($records1['nombre2'])." ".utf8_decode($records1['apellido1'])." ".
									utf8_decode($records1['apellido2'])."  &nbsp;&nbsp;&nbsp;$periodo"."°"." PERIODO</span><br/>";
									$numasigimp=0;
									$pagina++;
								}
                                        
                	}
                    //------------------COMPORTAMIENTO
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
					if($numasigimp>3){
									echo "</div><br/><span style='text-align:right; margin-left:700px' class='continuapag'>PAGINA $pagina DE $numapaginas</span><h1 class='SaltoDePagina'> </h1><div class='fondo'><span class='continuapag'>CONTINUA BOLETIN: ".
									utf8_decode($records1['nombre1'])." ".utf8_decode($records1['nombre2'])." ".utf8_decode($records1['apellido1'])." ".
									utf8_decode($records1['apellido2'])."  &nbsp;&nbsp;&nbsp;$periodo"."°"." PERIODO</span><br/>";
									$numasigimp=0;
									$pagina++;
					}
                	echo "<br/>
                    <table class='resultadoasig'>
                        <tr>
                		<td scope='col' colspan='6' class='Estilo5' >CONSOLIDADO CONVIVENCIAL</td>
                		<td scope='col' colspan='10	' class='fonttitle8' ><span style='fon-size:small; font-family: Times New Roman,sans-serif; font-weight:bold;'>$comportamiento: </span>";
                	$sql3 = "SELECT DISTINCT descripcion 
                		FROM comportamiento WHERE tipo='$comportamiento' ORDER BY descripcion ASC";
                		$consulta3 = $conx->query($sql3);
                	echo "<span style='fon-size:small; font-family: Times New Roman,sans-serif;'> ";
                		while($records4 = $conx->records_array($consulta3)){
                		echo String_oracion($records4['descripcion'])." ";
                		
                		}
                    echo "</span>
                        </td>
                        </tr>
                    </table>";    
                    //------------------FIN COMPORTAMIENTO
                    //------------------PUESTO PERIODO Y ANUAL
                    $sqlTasig = "SELECT DISTINCT idmateria FROM clase WHERE aniolectivo=$aniolect AND idaula=$idaula";
                	$consultaTasig= $conx->query($sqlTasig);
                	$numasigProm= $conx->get_numRecords($consultaTasig);
                	$sqlpuesto = "SELECT AVG( vn ) AS promedio, SUM( vn ) AS sumnotas, n.idestudiante 
                	FROM notas n, estudiante e, matricula m WHERE m.idaula='$idaula' AND n.idestudiante=e.idestudiante AND n.periodo='$periodo' 
                    AND m.idestudiante=e.idestudiante AND e.habilitado='S'
                    AND n.aniolectivo=$aniolect 
                    AND m.aniolectivo=n.aniolectivo
					AND m.tipo_matricula='R'
					AND m.tipo_matricula=n.tipo_nota
                	GROUP BY n.idestudiante
                	ORDER BY promedio DESC";
                	$sqlpuestoanio = "SELECT ROUND(AVG( vn ),3) AS promedio, SUM( vn ) AS sumnotas, n.idestudiante"
                    . "	FROM notas n, estudiante e, matricula m WHERE m.idaula='$idaula' AND n.idestudiante=e.idestudiante 
					AND m.idestudiante=e.idestudiante AND e.habilitado='S' 
					AND n.aniolectivo=$aniolect 
                    AND m.aniolectivo=n.aniolectivo
					AND m.tipo_matricula='R'
					AND m.tipo_matricula=n.tipo_nota
                	GROUP BY n.idestudiante
                	ORDER BY promedio DESC";
                	$consultapuesto = $conx->query($sqlpuesto);
                	$consultapuestoanio = $conx->query($sqlpuestoanio);
                	$puesto=1;
                	$puestoanio=1;
                	$numest= $conx->get_numRecords($consultapuesto);
                	$notaEstAnt=0;
                	while($recordspuesto = $conx->records_array($consultapuesto)){
                		if(!($records1['idestudiante']==$recordspuesto['idestudiante'])){
                			$puesto++;
                		}else{
                			$promedio=$recordspuesto['promedio'];
                			break;
                		}
                	}
                	if($periodo==4){
                		while($recordspuestoanio = $conx->records_array($consultapuestoanio)){
                			if(!($records1['idestudiante']==$recordspuestoanio['idestudiante'])){
                				$puestoanio++;
                			}else{
                				$promedioanio=$recordspuestoanio['promedio'];
                				break;
                			}
                		}
                	}
                
                	echo "<br/><table class='resultadoasig'>";
                	if($periodo=='4'){
                		echo "<tr><td style='text-align:left; font:12px arial,sans-serif;'>
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >PROMEDIO GENERAL PERIODO:</span> ".number_format((float)$promedio,2,".",",")." 
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold; ' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPUESTO: </span>$puesto
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >DE</span> $numest</td>
                		<td style='text-align:left; font:12px 	arial,sans-serif;'>
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >PROMEDIO GENERAL AÑO LECTIVO:</span> ".number_format((float)$promedioanio,3,".",",")." 
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold; ' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPUESTO: </span>$puestoanio
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >DE</span> $numest</td></tr>";
                	}else{
                	
                		echo "<tr><td style='text-align:left; font:12px 	arial,sans-serif;'>
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >PROMEDIO GENERAL PERIODO:</span> ".number_format((float)$promedio,2,".",",")." 
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold; ' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPUESTO: </span>$puesto
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >DE</span> $numest</td></tr>";
                	}
                
                	echo "</table><br/>";
                    if($mPerdidas>0 and $mPerdidas <3){
                        $estadoP= "<span style='color:red;'>"."PROMOCION PENDIENTE,"."</span> Tiene $mPerdidas área(s) reprobada(s)";
                    }elseif($mPerdidas>2){
            		      $estadoP= "<span style='color:red;'>"."DEBE REPETIR EL GRADO, "."</span> Tiene $mPerdidas área(s) reprobada(s).";
                    }elseif($mPerdidas==0){
                        $estadoP= "FUE PROMOVIDO(A)";
            			switch($grado){
            			 case '1': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO SEGUNDO"; break;
            			 case '2': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO TERCERO"; break;
            			 case '3': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO CUARTO"; break;
            			 case '4': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO QUINTO"; break;
            			 case '5': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO SEXTO"; break;
                         case '6': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO SEPTIMO"; break;
            			 case '7': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO OCTAVO"; break;
            			 case '8': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO NOVENO"; break;
                         case '9': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO DECIMO"; break;
            			 case '10': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO ONCE"; break;
            	         default: $estadoP=""; break;
            									
            			}
                        $estadoP.=" SEGÚN LO ESTABLECIDO EN EL PEI DEL COLEGIO";
            		}
                	
                    echo "<br/><table class='resultadoasig'>";
                	if($periodo==4){
                		echo "<tr><td style='text-align:left; font:12px 	arial,sans-serif;'>
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >$estadoP</span></td></tr>";
                	}
                   	echo "</table><br/>";
                    
                    //------------------FIN PUESTO 
                    //------------------OBSERVACIONES
                    echo "
                    <br/><table class='alumno' border='0' cellspacing='5px' >
                	   <tr >
                	   <th colspan='2'>
                	       <p class='Estilo5' align='center'>OBSERVACIONES</p>
                	   </th>
                	   </tr>
                	   <tr>
                            <td width='30%' align='left' class='Estilo6'>ASIGNATURA</td>
                            <td  align='left' class='Estilo2' >OBSERVACI&Oacute;N</td>";	
                			//observaciones generales
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
                                echo "<tr>
                				        <td  class='Estilo1'>".$recordsog['nombre_materia']."</td>
                	                   <td align='left' valign='top' style='line-height:15px; text-align:justify'>
                						<span class='Estilo7' >".
                						String_oracion($observaciones)."</span>&nbsp;
                				        </td>
                                    </tr>";
                			}
                	       }
                        //---------------------------CONVENCIONES
echo "
                        </table><br/><div class='firma'>
                        <table class='convenciones'>
                        <tr>
                            <td width='150px' colspan='4' valign='center' style='text-align:center; background:#E5E5E5;'>Convenciones</td>
                        </tr>
                        <tr>
                            <td width='45' valign='top'>C.J</td>
                            <td width='161' valign='top' class='Estilo7'>Con Justificación</td>
							<td width='45' valign='top'>DS</td>
                            <td width='161' valign='top' class='Estilo7'>Desempeño Superior [".number_format((float)$rcsmin,1,'.',',')." a ".number_format((float)$rcsmax,1,'.',',')."]</td>
                        </tr>
                        <tr>
                            <td width='45' valign='top'>S.J</td>
                            <td width='161' valign='top' class='Estilo7' >Sin Justificación</td>
							<td width='45' valign='top'>DA</td>
                            <td width='161' valign='top' class='Estilo7'>Desempeño Alto [".number_format((float)$rcamin,1,'.',',')." a ".number_format((float)$rcamax,1,'.',',')."]</td>
                        </tr>
                        <tr>
                            <td width='45' valign='top'>D</td>
                            <td width='161' valign='top' class='Estilo7' >Definitiva</td>
							<td width='45' valign='top'>DB</td>
                            <td width='161' valign='top' class='Estilo7'>Desempeño Básico [".number_format((float)$rcbmin,1,'.',',')." a ".number_format((float)$rcbmax,1,'.',',')."]</td>
                        </tr>
                        <tr>
                            <td width='45' valign='top'>I.H</td>
                            <td width='161' valign='top' class='Estilo7' >Intensidad Horaria</td>
							<td width='45' valign='top'>Db</td>
                            <td width='161' valign='top' class='Estilo7'>Desempeño Bajo [".number_format((float)$rcbamin,1,'.',',')." a ".number_format((float)$rcbamax,1,'.',',')."]</td>
                        </tr>
                        <tr>
                            <td width='45' valign='top'>V.N</td>
                            <td width='161' valign='top' class='Estilo7' >Valoración Numérica</td>
							<td width='45' valign='top'></td>
                            <td width='161' valign='top' class='Estilo7'></td>
                        </tr>
                    </table></div>"; 
						$sqldg = "SELECT DISTINCT d.* 
							FROM coordinadoresgrupo c, docente d
							WHERE c.idaula = $idaula
							AND c.aniolectivo =  $aniolect
							AND c.iddocente = d.iddocente";
							$consultadg = $conx->query($sqldg);
							$recordsd = $conx->records_array($consultadg);
							$docentedg = $recordsd['apellido1']." ".$recordsd['apellido2']." ".$recordsd['nombre1']." ".$recordsd['nombre2'];					
                	   if($periodo==4){
							echo 
							"<div style='line-height:7px;'>
							<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
							<table class='firma' border='0'>
									<tr>
										<td width='50%' align='center'>
											<span  class='blocktext' style='text-decoration:overline; font-weight:bold'>$nrector</span>
											<br/><span align='center' class='blocktext' >Director(a)</span>
						
										</td>
										<td align='center'>
											<span class='blocktext' style='text-decoration:overline; font-weight:bold'>$docentedg</span>
											<br/><span align='center' class='blocktext' >Director(a) de Grupo</span>
										</td>
									</tr>
									<tr>
										<td colspan='2' align='center'><br/><br/><br/>
											<br/><span align='center' class='blocktext' style='text-decoration:overline; font-weight:bold' >Padre de Familia o Acudiente</span>
										</td>
									</tr>
							</table>
							</div>";
					   
					   }else{
							echo 
							"<div style='line-height:7px;'>
							<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
							<table class='firma' border='0'>
									<tr>
										<td width='50%' align='center'>
											<span class='blocktext' style='text-decoration:overline; font-weight:bold'>$docentedg</span>
											<br/><span align='center' class='blocktext' >Director(a) de Grupo</span>
						
										</td>
										<td align='center'>
											<br/><span align='center' class='blocktext' style='text-decoration:overline; font-weight:bold' >Padre de Familia o Acudiente</span>
										</td>
									</tr>
							</table>
							</div>";
						
					   }
					   
                    	echo "</div><br/><br/><br/><br/><span style='text-align:right; margin-left:700px; position:relative;' class='continuapag'>PAGINA $pagina DE $numapaginas</span><h1 class='SaltoDePagina'></h1>";
                        
                	//-------------------------------FIN LADO B------------------------------------------------
                    
			}
	}elseif($formato=="f3"){
        
           $sqlest = "SELECT DISTINCT e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula, e.idestudiante 
			FROM estudiante e, notas n, matricula m 
        	WHERE e.idestudiante=$id AND e.idestudiante=n.idestudiante AND m.idestudiante=n.idestudiante
			AND m.idaula=$idaula AND e.habilitado='S' 
			AND n.periodo=$periodo AND m.periodo='0' 
			AND n.aniolectivo=$aniolect AND m.aniolectivo=n.aniolectivo
			AND m.tipo_matricula='R' AND n.tipo_nota=m.tipo_matricula
			ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";
        	$consultaest = $conx->query($sqlest);
            while($records1 = $conx->records_array($consultaest)){
            	echo 
                "<div class='fondo'><div style='line-height:7px;'>
                <table class='normal'>
                        <tr>
                            <td width='100px' align='left' rowspan='2' valign='top'>
                                <span  class='blocktext'><img  src='../../images/logocol.png' width='80' height='80'/></span>
                            </td>
                            <td >
                                <span class='ie' align='center'>".($ie)."</span><br/>
            	                <span class='lema' align='center'>".($lema)."</span><br/>
            	                <span class='lema' align='center'>".($localizacion)."</span><br/>
                                
                            </td>
                        </tr>
                        <tr>
                            <td colspan='2'>";
                                    if($periodo=='4'){
                                        echo "<span align='center' class='tituloinforme' align='center'><p class='fonttitle6'>INFORME FINAL</p></span>";        
                                    }else{
                                        echo "<span align='center' class='tituloinforme' align='center'><p class='fonttitle6'>INFORME $periodo"."°"." PERIODO</p></span>";        
									
									}
                                echo "
                            </td>
                        </tr>
                        
                </table>
            	</div>";
            	echo "<br/><table class='alumnoKinder'>
            	<tr>
				<td align='center'>ESTUDIANTE</td>
				<td align='center'>GRADO</td>
				<td align='center'>CODIGO</td>
				<td align='center'>AÑO LECTIVO</td>
				</tr>
				<tr>
				<td align='center' class='fonttitle7'>".utf8_decode($records1['nombre1'])." ".utf8_decode($records1['nombre2'])." ".utf8_decode($records1['apellido1'])." ".utf8_decode($records1['apellido2'])."</td>
				<td align='center'>".$grado."</td>
				<td align='center'>".$records1['idestudiante']."</td>
				<td align='center'>".$aniolect."</td>
				</tr>
            	</table>";
				//-----------------------------------numero de paginas
				$sql = "SELECT DISTINCT mt.nombre_materia, n.* 
            	FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
				AND mt.idmateria=n.idmateria AND n.periodo=$periodo  AND n.aniolectivo=$aniolect 
				AND n.tipo_nota='R' ORDER BY mt.nombre_materia ASC";
            	$consulta2 = $conx->query($sql);
            	$numasig=0;
            	$numasigimp=0;
				$numapaginas=1;
            	while($records2 = $conx->records_array($consulta2)){
                    	$numasig++;
						$numasigimp++;
                        if($numasigimp>5){
								$numasigimp=0;
								$numapaginas++;
						}
                                    
            	}
                
				if($numasigimp>5){
					$numasigimp=0;
					$numapaginas++;
				}
				//----------------------------------------------------
                //Generar resultados por asignatura
                $sql = "SELECT DISTINCT mt.nombre_materia, n.* 
            	FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
				AND mt.idmateria=n.idmateria AND n.periodo=$periodo  AND n.aniolectivo=$aniolect 
				AND n.tipo_nota='R' ORDER BY mt.nombre_materia ASC";
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
                $numasigimp=0;
				$pagina=1;
				echo "<br/><table class='resultadoasig'>
                            <tbody>
                            <tr style=''>
                                <td width='100' style='text-align:center;' class='textcn'>DIMENSIONES</td>
								<td width='499' colspan='1' style='text-align:center; background-color: #E5E5E5;'>LOGROS</td>
                                <td width='96' style='text-align:center;' class='textcn'>VALORACIÓN</td>
                            </tr>";
            	while($records2 = $conx->records_array($consulta2)){
                    	$numasig++;
						$numasigimp++;
                        $desct='';
                        if($records2['vn'] >= (float)$rcbamin and $records2['vn'] <= (float)$rcbamax){
                    		$desempeno="Db"; 
                    	}else if($records2['vn'] >= (float)$rcbmin and $records2['vn'] <= (float)$rcbmax){
                    		$desempeno="DB";
                    	}else if($records2['vn'] >= (float)$rcamin and $records2['vn'] <= (float)$rcamax){
                    		$desempeno="DA";
                    	}else if($records2['vn'] >= (float)$rcsmin and $records2['vn'] <= (float)$rcsmax){
                    		$desempeno="DS";
                    	}
                    	if($desempeno=='Db'){
                    		$desempeno2="D-";
                    	}else{
                    		$desempeno2=$desempeno;
                    	}
                    	switch($records2['comportamiento']){
                    		case "DS": $sumDS++; break;
                    		case "DA": $sumDA++; break;
                    		case "DB": $sumDB++; break;
                    		case "D-": $sumDb++; break;
                    		default: break;
                    	}
						//docente que tiene la materia 
                 		$sqld = "SELECT DISTINCT c.ih, d. * 
                        FROM clase c, docente d
                        WHERE c.idmateria=  '".$records2['idmateria']."'
                        AND c.idaula = $idaula
                        AND c.aniolectivo =  $aniolect
                        AND c.iddocente = d.iddocente";
                        $consultad = $conx->query($sqld);
                		$recordsd = $conx->records_array($consultad);
                        $docente = utf8_decode($recordsd['nombre1'])." ".utf8_decode($recordsd['nombre2'])." ".utf8_decode($recordsd['apellido1'])." ".utf8_decode($recordsd['apellido2']);
                        $ih = $recordsd['ih'];
                        $iddocente = $recordsd['iddocente'];
                        //descripcion del indicador de desempeño
						$sql3 = "SELECT DISTINCT i.descripcion 
                		FROM indicadores i, indicadoresestudiante ib 
						WHERE i.idindicador=ib.idindicador AND i.idmateria=".$records2['idmateria']."
						AND i.idaula='".$idaula."' AND i.tipo='DS' 
                		AND ib.periodo=$periodo AND ib.aniolectivo=$aniolect
						AND ib.idestudiante=".$records1['idestudiante']." ORDER BY ib.idindicador ASC";
                		$consulta3 = $conx->query($sql3);
						$desct="<ul>";
                		while($records3 = $conx->records_array($consulta3)){
                		  $desct.="<li style='list-style-type:circle'>".String_oracion($records3['descripcion'])."</li>	";
						}
						$desct.="</ul>";
                        $sqldg = "SELECT DISTINCT d.* 
                        FROM clase c, docente d
                        WHERE c.idaula = $idaula
                        AND c.aniolectivo =  $aniolect
                        AND c.dg='S' AND c.iddocente=d.iddocente";
                        $consultadg = $conx->query($sqldg);
                		$recordsdg = $conx->records_array($consultadg);
						if($records2['idmateria']==21){
							//nota ingles 
							$sqln = "SELECT DISTINCT mt.nombre_materia, n.* 
							FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
							AND mt.idmateria=25 AND n.periodo=$periodo  AND n.aniolectivo=$aniolect 
							AND n.tipo_nota='R' ORDER BY mt.nombre_materia ASC";
							$consultan = $conx->query($sqln);
							while($recordsn = $conx->records_array($consultan)){
									if($recordsn['vn'] >= (float)$rcbamin and $recordsn['vn'] <= (float)$rcbamax){
										$desempenon="Db"; 
									}else if($recordsn['vn'] >= (float)$rcbmin and $recordsn['vn'] <= (float)$rcbmax){
										$desempenon="DB";
									}else if($recordsn['vn'] >= (float)$rcamin and $recordsn['vn'] <= (float)$rcamax){
										$desempenon="DA";
									}else if($recordsn['vn'] >= (float)$rcsmin and $recordsn['vn'] <= (float)$rcsmax){
										$desempenon="DS";
									}
							}
							//descripcion del indicador de desempeño
							$sql4 = "SELECT DISTINCT i.descripcion 
							FROM indicadores i, indicadoresestudiante ib 
							WHERE i.idindicador=ib.idindicador AND i.idmateria=25
							AND i.idaula='".$idaula."' AND i.tipo='DS' 
							AND ib.periodo=$periodo AND ib.aniolectivo=$aniolect
							AND ib.idestudiante=".$records1['idestudiante']." ORDER BY ib.idindicador ASC";
							$consulta4 = $conx->query($sql4);
							$desct4="<ul>";
							while($records4 = $conx->records_array($consulta4)){
							  $desct4.="<li style='list-style-type:circle'>".String_oracion($records4['descripcion'])."</li>	";
							}
							$desct4.="</ul>";
							 echo"                           
                            <tr >
								<td width='100' style='text-align:center;' class='textcn' rowspan='2'>".utf8_decode($records2['nombre_materia'])."</td>
								<td width='499' colspan='1'  ><div align='justify'><span style='text-decoration: underline;'>INGLES</span><br/>$desct4</div></td>
								<td width='96' rowspan='1' style='text-align:center; '><span style='font-weight:bold;'>".$desempenon."</span></td>
                            </tr>
							
							<tr>
								<td width='499' colspan='1'  ><div align='justify'>$desct</div></td>
								<td width='96' rowspan='1' style='text-align:center; '><span style='font-weight:bold;'>".$desempeno."</span></td>
							</tr>";
						
						}else{
						
						    echo"                           
                            <tr >
								<td width='100' style='text-align:center;' class='textcn'>".utf8_decode($records2['nombre_materia'])."</td>
                                <td width='499' colspan='1'  ><div align='justify'>$desct</div></td>
                                <td width='96' rowspan='1' style='text-align:center; '><span style='font-weight:bold;'>".$desempeno."</span></td>

                            </tr>";
						}
							if($numasigimp>10){
									echo "</div><br/><span style='text-align:right; margin-left:700px' class='continuapag'>PAGINA $pagina DE $numapaginas</span><h1 class='SaltoDePagina'> </h1><div class='fondo'><span class='continuapag'>CONTINUA BOLETIN: ".
									utf8_decode($records1['nombre1'])." ".utf8_decode($records1['nombre2'])." ".utf8_decode($records1['apellido1'])." ".
									utf8_decode($records1['apellido2'])."  &nbsp;&nbsp;&nbsp;$periodo"."°"." PERIODO</span><br/>";
									$numasigimp=0;
									$pagina++;
							}
                                    
            	}
				echo "</tbody></table>";
                //------------------COMPORTAMIENTO
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
				if($numasigimp>10){
									echo "</div><br/><span style='text-align:right; margin-left:700px' class='continuapag'>PAGINA $pagina DE $numapaginas</span><h1 class='SaltoDePagina'> </h1><div class='fondo'><span class='continuapag'>CONTINUA BOLETIN: ".
									utf8_decode($records1['nombre1'])." ".utf8_decode($records1['nombre2'])." ".utf8_decode($records1['apellido1'])." ".
									utf8_decode($records1['apellido2'])."  &nbsp;&nbsp;&nbsp;$periodo"."°"." PERIODO</span><br/>";
									$numasigimp=0;
									$pagina++;
				}
            	/*echo "<br/>
                <table class='resultadoasig'>
                    <tr>
                	<td scope='col' colspan='6' class='Estilo5' >CONSOLIDADO CONVIVENCIAL</td>
            		<td scope='col' colspan='10	' class='fonttitle8' ><span style='fon-size:small; font-family: Times New Roman,sans-serif; font-weight:bold;'>$comportamiento: </span>";
            	$sql3 = "SELECT DISTINCT descripcion 
            		FROM comportamiento WHERE tipo='$comportamiento' ORDER BY descripcion ASC";
            		$consulta3 = $conx->query($sql3);
            	echo "<span style='fon-size:small; font-family: Times New Roman,sans-serif;'> ";
            		while($records4 = $conx->records_array($consulta3)){
            		echo String_oracion($records4['descripcion'])." ";
            		
            		}
                echo "</span>
                    </td>
                    </tr>
                </table>";*/    
                //------------------FIN COMPORTAMIENTO
                /*//------------------PUESTO PERIODO Y ANUAL
                    $sqlTasig = "SELECT DISTINCT idmateria FROM clase WHERE aniolectivo=$aniolect AND idaula=$idaula";
                	$consultaTasig= $conx->query($sqlTasig);
                	$numasigProm= $conx->get_numRecords($consultaTasig);
                	$sqlpuesto = "SELECT AVG( vn ) AS promedio, SUM( vn ) AS sumnotas, n.idestudiante 
                	FROM notas n, estudiante e, matricula m WHERE m.idaula='$idaula' AND n.idestudiante=e.idestudiante AND n.periodo='$periodo' 
                    AND m.idestudiante=e.idestudiante AND e.habilitado='S'
                    AND n.aniolectivo=$aniolect 
                    AND m.aniolectivo=n.aniolectivo
					AND m.tipo_matricula='R'
					AND m.tipo_matricula=n.tipo_nota
                	GROUP BY n.idestudiante
                	ORDER BY promedio DESC";
                	$sqlpuestoanio = "SELECT ROUND(AVG( vn ),3) AS promedio, SUM( vn ) AS sumnotas, n.idestudiante"
                    . "	FROM notas n, estudiante e, matricula m WHERE m.idaula='$idaula' AND n.idestudiante=e.idestudiante 
					AND m.idestudiante=e.idestudiante AND e.habilitado='S' 
					AND n.aniolectivo=$aniolect 
                    AND m.aniolectivo=n.aniolectivo
					AND m.tipo_matricula='R'
					AND m.tipo_matricula=n.tipo_nota
                	GROUP BY n.idestudiante
                	ORDER BY promedio DESC";
                	$consultapuesto = $conx->query($sqlpuesto);
                	$consultapuestoanio = $conx->query($sqlpuestoanio);
                	$puesto=1;
                	$puestoanio=1;
                	$numest= $conx->get_numRecords($consultapuesto);
                	$notaEstAnt=0;
                	while($recordspuesto = $conx->records_array($consultapuesto)){
                		if(!($records1['idestudiante']==$recordspuesto['idestudiante'])){
                			$puesto++;
                		}else{
                			$promedio=$recordspuesto['promedio'];
                			break;
                		}
                	}
                	if($periodo==4){
                		while($recordspuestoanio = $conx->records_array($consultapuestoanio)){
                			if(!($records1['idestudiante']==$recordspuestoanio['idestudiante'])){
                				$puestoanio++;
                			}else{
                				$promedioanio=$recordspuestoanio['promedio'];
                				break;
                			}
                		}
                	}
                
                	echo "<br/><table class='resultadoasig'>";
                	if($periodo==4){
                		echo "<tr><td style='text-align:left; font:12px arial,sans-serif;'>
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >PROMEDIO GENERAL PERIODO:</span> ".number_format((float)$promedio,2,".",",")." 
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold; ' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPUESTO: </span>$puesto
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >DE</span> $numest</td>
                		<td style='text-align:left; font:12px 	arial,sans-serif;'>
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >PROMEDIO GENERAL AÑO LECTIVO:</span> ".number_format((float)$promedioanio,3,".",",")." 
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold; ' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPUESTO: </span>$puestoanio
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >DE</span> $numest</td></tr>";
                	}else{
                	
                		echo "<tr><td style='text-align:left; font:12px 	arial,sans-serif;'>
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >PROMEDIO GENERAL PERIODO:</span> ".number_format((float)$promedio,2,".",",")." 
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold; ' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPUESTO: </span>$puesto
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >DE</span> $numest</td></tr>";
                	}
                
                	echo "</table><br/>";
                    if($mPerdidas>0 and $mPerdidas <3){
                        $estadoP= "<span style='color:red;'>"."PROMOCION PENDIENTE,"."</span> Tiene $mPerdidas área(s) reprobada(s)";
                    }elseif($mPerdidas>2){
            		      $estadoP= "<span style='color:red;'>"."DEBE REPETIR EL GRADO, "."</span> Tiene $mPerdidas área(s) reprobada(s).";
                    }elseif($mPerdidas==0){
                        $estadoP= "FUE PROMOVIDO(A)";
            			switch($grado){
            			 case '1': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO SEGUNDO"; break;
            			 case '2': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO TERCERO"; break;
            			 case '3': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO CUARTO"; break;
            			 case '4': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO QUINTO"; break;
            			 case '5': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO SEXTO"; break;
                         case '6': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO SEPTIMO"; break;
            			 case '7': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO OCTAVO"; break;
            			 case '8': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO NOVENO"; break;
                         case '9': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO DECIMO"; break;
            			 case '10': $estadoP="<span style='color:blue;'>".$estadoP." AL GRADO ONCE"; break;
            	         default: $estadoP=""; break;
            									
            			}
                        $estadoP.=" SEGÚN LO ESTABLECIDO EN EL PEI DEL COLEGIO";
            		}
                	
                    echo "<br/><table class='resultadoasig'>";
                	if($periodo==4){
                		echo "<tr><td style='text-align:left; font:12px 	arial,sans-serif;'>
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >$estadoP</span></td></tr>";
                	}
                   	echo "</table><br/>";
                    
                    //------------------FIN PUESTO 
                    //------------------OBSERVACIONES
                    echo "
                    <br/><table class='alumno' border='0' cellspacing='5px' >
                	   <tr >
                	   <th colspan='2'>
                	       <p class='Estilo5' align='center'>OBSERVACIONES</p>
                	   </th>
                	   </tr>
                	   <tr>
                            <td width='30%' align='left' class='Estilo6'>ASIGNATURA</td>
                            <td  align='left' class='Estilo2' >OBSERVACI&Oacute;N</td>";	
                			//observaciones generales
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
                                echo "<tr>
                				        <td  class='Estilo1'>".$recordsog['nombre_materia']."</td>
                	                   <td align='left' valign='top' style='line-height:15px; text-align:justify'>
                						<span class='Estilo7' >".
                						String_oracion($observaciones)."</span>&nbsp;
                				        </td>
                                    </tr>";
                			}
                	       }*/
                        //---------------------------CONVENCIONES
                        echo "
                        </table><br/><br/><div class='firma'>
                        <table class='convenciones'>
                        <tr>
                            <td colspan='3' align='center' style='text-align:center; background:#E5E5E5; font-size: 14px;'>CONVENCIONES</td>
                        </tr>
                        <tr>
                            <td width='10%' align='center'>SUPERIOR&nbsp;(DS)</td>
                            <td width='10%' align='center'><img src='../../images/caritaDS.png'</img></td>
							<td width='80%' valign='center' class='estilo7'>Se distingue por llevar un proceso integral donde supera los logros propuestos.</td>
                        </tr>
						<tr>
                            <td width='10%' align='center'>ALTO&nbsp;(DA)</td>
                            <td width='10%' align='center'><img src='../../images/caritaDA.png'</img></td>
							<td width='80%' valign='center' class='estilo7'>Su proceso es sobresaliente, avanza según los logros propuestos.</td>
                        </tr>
						<tr>
                            <td width='10%' align='center'>BÁSICO&nbsp;(DB)</td>
                            <td width='10%' align='center'><img src='../../images/caritaDB.png'</img></td>
							<td width='80%' valign='center' class='estilo7'>Desarrolla un proceso acorde con lo establecido pero requiere más esfuerzo y dedicación.</td>
                        </tr>
						<tr>
                            <td width='10%' align='center'>Bajo&nbsp;(Db)</td>
                            <td width='10%' align='center'><img src='../../images/caritaD-.png'</img></td>
							<td width='80%' valign='center' class='estilo7'>Presenta dificultad en el proceso y la adquisición de logros.</td>
                        </tr>
                       
                    </table></div>"; 
						/*$sqldg = "SELECT DISTINCT d.* 
							FROM coordinadoresgrupo c, docente d
							WHERE c.idaula = $idaula
							AND c.aniolectivo =  $aniolect
							AND c.iddocente = d.iddocente";
							$consultadg = $conx->query($sqldg);
							$recordsd = $conx->records_array($consultadg);
							$docentedg = $recordsd['apellido1']." ".$recordsd['apellido2']." ".$recordsd['nombre1']." ".$recordsd['nombre2'];					
                	   if($periodo==4){
							echo 
							"<div style='line-height:7px;'>
							<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
							<table class='firma' border='0'>
									<tr>
										<td width='50%' align='center'>
											<span  class='blocktext' style='text-decoration:overline; font-weight:bold'>$nrector</span>
											<br/><span align='center' class='blocktext' >Director(a)</span>
						
										</td>
										<td align='center'>
											<span class='blocktext' style='text-decoration:overline; font-weight:bold'>$docentedg</span>
											<br/><span align='center' class='blocktext' >Director(a) de Grupo</span>
										</td>
									</tr>
									<tr>
										<td colspan='2' align='center'><br/><br/><br/>
											<br/><span align='center' class='blocktext' style='text-decoration:overline; font-weight:bold' >Padre de Familia o Acudiente</span>
										</td>
									</tr>
							</table>
							</div>";
					   
					   }else{
							echo 
							"<div style='line-height:7px;'>
							<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
							<table class='firma' border='0'>
									<tr>
										<td width='50%' align='center'>
											<span class='blocktext' style='text-decoration:overline; font-weight:bold'>$docentedg</span>
											<br/><span align='center' class='blocktext' >Director(a) de Grupo</span>
						
										</td>
										<td align='center'>
											<br/><span align='center' class='blocktext' style='text-decoration:overline; font-weight:bold' >Padre de Familia o Acudiente</span>
										</td>
									</tr>
							</table>
							</div>";
						
					   }*/
					   
                    	//echo "</div><br/><br/><br/><br/><span style='text-align:right; margin-left:700px; position:relative;' class='continuapag'>PAGINA $pagina DE $numapaginas</span><h1 class='SaltoDePagina'></h1>";
                    	echo "</div><h1 class='SaltoDePagina'></h1>";
                        
                	//-------------------------------FIN LADO B------------------------------------------------  
			}
	}else{
        echo "No se pueden Generar Boletines por que no existen rango de notas para el año lectivo $aniolect <br/> para configurar presione <a href='../../configuration.php'>aqui</a>";
	}
	$conx->close_conex();
}	
?>

 <br/>

<span>
<a href="boletingeneral.php" class="large button orange" style="font-size: 12px !important;">Regresar</a>
</span>
<span>
<a href="javascript: void window.print()" class="large button orange" style="font-size: 12px !important;" >Imprimir</a>
</span>
<span>
<?php
echo "<a href='boletinExcel.php?aniolect=$aniolect&periodo=$periodo&aula=$idaula&formato=$formato' style='font-size: 12px !important;' >Descargar en formato Excel</a>";
?>
</span>
<span>
<?php
echo "<a href='boletinWord.php?aniolect=$aniolect&periodo=$periodo&aula=$idaula&formato=$formato' style='font-size: 12px !important;' >Descargar en formato Word</a>";
?>
</span>
<span>
<?php
echo "<a href='boletinPdf.php?aniolect=$aniolect&periodo=$periodo&aula=$idaula&formato=$formato' style='font-size: 12px !important;' >Descargar en formato Pdf</a>";
?>
</span>
</body>
</html>