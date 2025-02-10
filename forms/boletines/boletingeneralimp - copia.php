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
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
//$docx->addText($text, $paramsText);$docx->createDocx('example_text');
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
$sqlaaula = "SELECT descripcion, idaula, grado FROM aula WHERE idaula = $idaula";
$consultaaula = $conx->query($sqlaaula);    
$recordsaula = $conx->records_array($consultaaula);
$grado=$recordsaula['descripcion'];
$grado_int=$recordsaula['grado'];
$idaula=$recordsaula['idaula'];
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
//CALCULAR PUESTOS ALGORITMO 1
function puestoPeriodo($id, $idaula, $aniolectivo, $periodo){
$conxp = new ConxMySQL("localhost","root","","appacademy");
$sqlarraypuesto="	
					SELECT @rownum := @rownum +1 AS Puesto, ROUND( AVG( n.vn ) , 2 ) AS Promedio, n.idestudiante
					FROM notas n, matricula m, estudiante e
					WHERE n.idestudiante = m.idestudiante
					AND n.idestudiante=e.idestudiante
					AND e.habilitado='S'
					AND m.idaula =  '$idaula'
					AND m.aniolectivo =$aniolectivo
					AND m.aniolectivo = n.aniolectivo
					AND m.tipo_matricula = 'R'
					AND n.periodo = '$periodo'
					AND n.idmateria != '27'
					GROUP BY n.idestudiante
					ORDER BY Promedio DESC;
					";
	$consultapuestoarray = $conxp->query($sqlarraypuesto);
	$countpuesto=1;

	while($recordspuestoarray = $conxp->records_array($consultapuestoarray)){
		$datos[] = $recordspuestoarray;
	}
	foreach($datos as $valor){
		$valor[0]=$countpuesto++;
		$datos2[] = $valor;
		$datos3[] = $valor;
	}
	$valorant=0;
	$nvPuesto=1;
	foreach($datos2 as $valor){
		foreach($datos3 as $valor2){
			if($valor[1]==$valor2[1]){
				$nvPuesto=$valor2[0];break;
			}
		
		}
		$valor[0]=$nvPuesto;
		$datos4[] = $valor;
	}
	foreach($datos4 as $valor3){
		if($id==$valor3[2]){
			$nvPuesto=$valor3[0];break;
		}
	}
    return $nvPuesto;
    
}
//CALCULAR PUESTOS ALGORITMO 2
function puestoPeriodoAlg2($id, $idaula, $aniolectivo, $periodo){
$conxp = new ConxMySQL("localhost","root","","appacademy");
	///calcular tabla de promedios
	$sqlarraypuesto="	
					SELECT DISTINCT ROUND( AVG( n.vn ) , 2 ) AS Promedio 
					FROM notas n, matricula m, estudiante e
					WHERE n.idestudiante = m.idestudiante
					AND n.idestudiante=e.idestudiante
					AND e.habilitado='S'
					AND m.idaula =  '$idaula'
					AND m.aniolectivo =$aniolectivo
					AND m.aniolectivo = n.aniolectivo
					AND m.tipo_matricula = 'R'
					AND n.periodo = '$periodo'
					AND n.idmateria != '27'
					GROUP BY n.idestudiante
					ORDER BY Promedio DESC;
					";
	$consultapuestoarray = $conxp->query($sqlarraypuesto);
	//consultar promedio de estudiante a buscar
	$sqlarraypuestoEst="	
					SELECT ROUND( AVG( n.vn ) , 2 ) AS Promedio 
					FROM notas n, matricula m, estudiante e
					WHERE n.idestudiante = m.idestudiante
					AND n.idestudiante=e.idestudiante
					AND n.idestudiante='$id'
					AND e.habilitado='S'
					AND m.idaula =  '$idaula'
					AND m.aniolectivo =$aniolectivo
					AND m.aniolectivo = n.aniolectivo
					AND m.tipo_matricula = 'R'
					AND n.periodo = '$periodo'
					AND n.idmateria !=  '27'
					GROUP BY n.idestudiante
					ORDER BY Promedio DESC;
					";
	$consultapuestoarrayEst = $conxp->query($sqlarraypuestoEst);
	$recordspuestoarrayEst = $conxp->records_array($consultapuestoarrayEst);
	$promEst=$recordspuestoarrayEst['Promedio'];
	//fin consulta promedio estudiante
	//ubicando puesto segun promedio
	$countpuesto=1;
	while($recordspuestoarray = $conxp->records_array($consultapuestoarray)){
		if($recordspuestoarray['Promedio']==$promEst){
			break;
		}else{
			$countpuesto++;
		}
	}
	//fin ubicar puesto
	
    return $countpuesto;
    
}
function puestoAnioAlg2($id, $idaula, $aniolectivo, $periodo){
$conxp = new ConxMySQL("localhost","root","","appacademy");
	///calcular tabla de promedios
	$sqlarraypuesto="	
					SELECT DISTINCT ROUND( AVG( n.vn ) , 3 ) AS Promedio 
					FROM notas n, matricula m, estudiante e
					WHERE n.idestudiante = m.idestudiante
					AND n.idestudiante=e.idestudiante
					AND e.habilitado='S'
					AND m.idaula =  '$idaula'
					AND m.aniolectivo =$aniolectivo
					AND m.aniolectivo = n.aniolectivo
					AND m.tipo_matricula = 'R'
					AND n.periodo <= '$periodo'
					AND n.idmateria != '27'
					GROUP BY n.idestudiante
					ORDER BY Promedio DESC;
					";
	$consultapuestoarray = $conxp->query($sqlarraypuesto);
	//consultar promedio de estudiante a buscar
	$sqlarraypuestoEst="	
					SELECT ROUND( AVG( n.vn ) , 3 ) AS Promedio 
					FROM notas n, matricula m, estudiante e
					WHERE n.idestudiante = m.idestudiante
					AND n.idestudiante=e.idestudiante
					AND n.idestudiante='$id'
					AND e.habilitado='S'
					AND m.idaula =  '$idaula'
					AND m.aniolectivo =$aniolectivo
					AND m.aniolectivo = n.aniolectivo
					AND m.tipo_matricula = 'R'
					AND n.periodo <= '$periodo'
					AND n.idmateria != '27'
					GROUP BY n.idestudiante
					ORDER BY Promedio DESC;
					";
	$consultapuestoarrayEst = $conxp->query($sqlarraypuestoEst);
	$recordspuestoarrayEst = $conxp->records_array($consultapuestoarrayEst);
	$promEst=$recordspuestoarrayEst['Promedio'];
	//fin consulta promedio estudiante
	//ubicando puesto segun promedio
	$countpuesto=1;
	while($recordspuestoarray = $conxp->records_array($consultapuestoarray)){
		if($recordspuestoarray['Promedio']==$promEst){
			break;
		}else{
			$countpuesto++;
		}
	}
	//fin ubicar puesto
	
    return $countpuesto;
    
}
//----------------------------------------------------------------------------------
if($existeescala==1){
    if($formato=="f1"){
        
           $sqlest = "SELECT DISTINCT e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula, e.idestudiante 
			FROM estudiante e, notas n, matricula m 
        	WHERE e.idestudiante=n.idestudiante AND m.idestudiante=n.idestudiante
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
                                <span  class='blocktext'><img  src='../../images/logocol.png' width='80' height='95'/></span>
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
                                        echo "<span align='center' class='tituloinforme' align='center'><p class='fonttitle6'>INFORME $periodo"."°"." PERIODO</p></span>";        
                                    }else{
                                        echo "<span align='center' class='tituloinforme' align='center'><p class='fonttitle6'>INFORME $periodo"."°"." PERIODO</p></span>";        
									
									}
                                echo "
                            </td>
                        </tr>
                        
                </table>
            	</div>";
            	echo "<table class='alumno'>
            	<tr >
            	<td colspan='14' class='fonttitle7'   style='width:80%'>ESTUDIANTE:&nbsp;".
                utf8_decode($records1['nombre1'])." ".utf8_decode($records1['nombre2'])." ".utf8_decode($records1['apellido1'])." ".utf8_decode($records1['apellido2'])." (COD: ".$records1['idestudiante'].")
                <br/>GRADO:&nbsp;".$grado." th
                </td>
            	</tr>
            	</table>";
				//-----------------------------------numero de paginas
				/*$sql = "SELECT DISTINCT mt.nombre_materia, n.* 
            	FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
				AND mt.idmateria=n.idmateria AND n.periodo=$periodo  AND n.aniolectivo=$aniolect 
				AND n.tipo_nota='R' ORDER BY mt.nombre_materia ASC";*/
            	$sql="SELECT *
					FROM clase c, aula a
					WHERE a.idaula = c.idaula
					AND a.idaula =$idaula AND aniolectivo=$aniolect";
					$consulta2 = $conx->query($sql);
					//$records2 = $conx->records_array($consulta2);
					$numasig=0;
					$numasigimp=0;
					$asigxpage=0;
					$numapaginas=0;
					//$numapaginas=$records2['nunmat']/$pages;
					while($records2 = $conx->records_array($consulta2)){
							$numasig++;
							/*$numasigimp++;
							if($numasigimp>$pages){
									$numasigimp=0;
									$numapaginas++;
									$asigxpage=$numasig;
							}*/
										
					}
					$numasig--;
					//verificar echo $numasig." - ".$asigxpage." - ".$numapaginas;
					/*if(($numasig-$asigxpage)>0){
						$numapaginas++;
					}*/			
					$numapaginas=round($numasig/$pages,0);
					if($numasig%$pages==0){
						$numapaginas++;
					}
                //----------------------------------------------------
                //Generar resultados por asignatura
                $sql = "SELECT DISTINCT mt.nombre_materia, n.* 
            	FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
				AND mt.idmateria=n.idmateria AND n.periodo=$periodo AND n.idmateria != '27' AND n.aniolectivo=$aniolect 
				AND n.tipo_nota='R' ORDER BY mt.nombre_materia ASC";
            	$consulta2 = $conx->query($sql);
            	$numasig=0;
            	$sumComp=0;
            	$promComp=0;
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
						$sumComp+=$records2['comportamiento'];/*
                    	switch($records2['comportamiento']){
                    		case "DS": $sumDS++; break;
                    		case "DA": $sumDA++; break;
                    		case "DB": $sumDB++; break;
                    		case "D-": $sumDb++; break;
                    		default: break;
                    	}*/
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
                                <td width='499' colspan='3'  ><div align='justify'>".$desct."</div></td>
                                <td width='38' style='text-align:center;'>".$records2['fj']."</td>
                                <td width='38' style='text-align:center;'>".$records2['fsj']."</td>
                            </tr>
                            </tbody></table>";
							if($numasigimp>$pages-1){
									echo "</div><br/><span style='text-align:right; margin-left:700px' class='continuapag'>PAGINA $pagina DE $numapaginas</span><h1 class='SaltoDePagina'> </h1><div class='fondo'><span class='continuapag'>CONTINUA BOLETIN: ".
									utf8_decode($records1['nombre1'])." ".utf8_decode($records1['nombre2'])." ".utf8_decode($records1['apellido1'])." ".
									utf8_decode($records1['apellido2'])."  &nbsp;&nbsp;&nbsp;$periodo"."°"." PERIODO</span><br/>";
									$numasigimp=0;
									$pagina++;
							}
                                    
            	}
                //------------------COMPORTAMIENTO
               	//$promComp=round($sumComp/$numasig,1);
            	/*$porcDA=round(($sumDA*100)/$numasig);
            	$porcDB=round(($sumDB*100)/$numasig);
            	$porcDb=round(($sumDb*100)/$numasig);*/
            	/*$comportamiento="";
				if($promComp >= $rcbamin && $promComp <= $rcbamax){
					$comportamiento="Db"; 
				}else if($promComp >= $rcbmin && $promComp <= $rcbmax){
					$comportamiento="DB";
				}else if($promComp >= $rcamin && $promComp <= $rcamax){
					$comportamiento="DA";
				}else if($promComp >= $rcsmin && $promComp <= $rcsmax){
					$comportamiento="DS";
				}
            	/*if($porcDS>$porcDA && $porcDS>$porcDB && $porcDS>$porcDb){
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
            	}*/
				if($numasigimp>4){
									echo "</div><br/><span style='text-align:right; margin-left:700px' class='continuapag'>PAGINA $pagina DE $numapaginas</span><h1 class='SaltoDePagina'> </h1><div class='fondo'><span class='continuapag'>CONTINUA BOLETIN: ".
									utf8_decode($records1['nombre1'])." ".utf8_decode($records1['nombre2'])." ".utf8_decode($records1['apellido1'])." ".
									utf8_decode($records1['apellido2'])."  &nbsp;&nbsp;&nbsp;$periodo"."°"." PERIODO</span><br/>";
									$numasigimp=0;
									$pagina++;
				}
				//Generar resultados de convivencia
                $sqlconvi = "SELECT DISTINCT mt.nombre_materia, n.* 
            	FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
				AND mt.idmateria=n.idmateria AND n.periodo=$periodo AND n.idmateria = '27' AND n.aniolectivo=$aniolect 
				AND n.tipo_nota='R' ORDER BY mt.nombre_materia ASC";
            	$consultaconvi = $conx->query($sqlconvi);
            	while($recordsconvi = $conx->records_array($consultaconvi)){
                    	
                        $desct='';
                        if($recordsconvi['vn'] >= (float)$rcbamin and $recordsconvi['vn'] <= (float)$rcbamax){
                    		$desempeno="Db"; 
                    	}else if($recordsconvi['vn'] >= (float)$rcbmin and $recordsconvi['vn'] <= (float)$rcbmax){
                    		$desempeno="DB";
                    	}else if($recordsconvi['vn'] >= (float)$rcamin and $recordsconvi['vn'] <= (float)$rcamax){
                    		$desempeno="DA";
                    	}else if($recordsconvi['vn'] >= (float)$rcsmin and $recordsconvi['vn'] <= (float)$rcsmax){
                    		$desempeno="DS";
                    	}
                    	if($desempeno=='Db'){
                    		$desempeno2="D-";
                    	}else{
                    		$desempeno2=$desempeno;
                    	}
						//docente que tiene la materia 
                 		$sqld = "SELECT DISTINCT c.ih, d. * 
                        FROM clase c, docente d
                        WHERE c.idmateria=  '".$recordsconvi['idmateria']."'
                        AND c.idaula = $idaula
                        AND c.aniolectivo =  $aniolect
                        AND c.iddocente = d.iddocente";
                        $consultad = $conx->query($sqld);
                		$recordsd = $conx->records_array($consultad);
                        $docente = utf8_decode($recordsd['nombre1'])." ".utf8_decode($recordsd['nombre2'])." ".utf8_decode($recordsd['apellido1'])." ".utf8_decode($recordsd['apellido2']);
                        $iddocente = $recordsd['iddocente'];
                        //descripcion del indicador de desempeño
						$sql3 = "SELECT DISTINCT i.descripcion 
                		FROM indicadores i, indicadoresestudiante ib 
						WHERE i.idindicador=ib.idindicador AND i.idmateria=".$recordsconvi['idmateria']."
						AND i.idaula='".$idaula."'
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
                                <td width='100' style='text-align:center;' class='textcn'>".utf8_decode($recordsconvi['nombre_materia'])."</td>
                                <td width='277'><span style='font-style: italic;'>Coordinador(a):</span> <span class='textcn'>$docente</span></td>
                                <td width='47' style='text-align:center;' class='textcn'>V.N</td>
                                <td width='96' style='text-align:center;' class='textcn'>DESEMPEÑO</td>
                            </tr>
                            <tr style=''>
                                <td width='499' colspan='2'  ><div align='justify'>".$desct."</div></td>
								<td width='47' rowspan='2' style='text-align:center;'><span style='font-weight:bold;'>".number_format((float)$recordsconvi['vn'],1,".",",")."</span></td>
                                <td width='96' rowspan='2' style='text-align:center; '><span style='font-weight:bold;'>".$desempeno."</span></td>
                            </tr>                         
                            </tbody></table>";					
                                    
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
                </table>";  */  
                //------------------FIN COMPORTAMIENTO
                //------------------PUESTO PERIODO Y ANUAL
                    $sqlTasig = "SELECT DISTINCT idmateria FROM clase WHERE aniolectivo=$aniolect AND idaula=$idaula";
                	$consultaTasig= $conx->query($sqlTasig);
                	$numasigProm= $conx->get_numRecords($consultaTasig);
                	$sqlpuesto = "SELECT ROUND( AVG( vn ) , 2 ) AS promedio, SUM( vn ) AS sumnotas, n.idestudiante 
                	FROM notas n, estudiante e, matricula m WHERE m.idaula='$idaula' AND n.idestudiante=e.idestudiante AND n.periodo='$periodo' 
                    AND m.idestudiante=e.idestudiante AND e.habilitado='S'
                    AND n.aniolectivo=$aniolect 
                    AND m.aniolectivo=n.aniolectivo
					AND m.tipo_matricula='R'
					AND m.tipo_matricula=n.tipo_nota
					AND n.idmateria != '27'
                	GROUP BY n.idestudiante
                	ORDER BY promedio DESC";
                	
                	$consultapuesto = $conx->query($sqlpuesto);
                	$puesto=1;
                	$numest= $conx->get_numRecords($consultapuesto);
                	$notaEstAnt=0;
                	//Buscar el puesto academico segun resultados
					$puestoPeriodo= puestoPeriodoAlg2($records1['idestudiante'], $idaula, $aniolect, $periodo);
					while($recordspuesto = $conx->records_array($consultapuesto)){
                		if(!($records1['idestudiante']==$recordspuesto['idestudiante'])){
                			$puesto++;
                		}else{
                			$promedio=$recordspuesto['promedio'];
                			break;
                		}
                	}
                	               
                	echo "<br/><table class='resultadoasig'>";
                	if($periodo=='4'){
                		echo "<tr><td style='text-align:left; font:12px arial,sans-serif;'>
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >PROMEDIO GENERAL PERIODO:</span> ".number_format((float)$promedio,2,".",",")." 
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold; ' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPUESTO: </span>$puestoPeriodo
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >DE</span> $numest</td>
                		";
                	}else{
                	
                		echo "<tr><td style='text-align:left; font:12px 	arial,sans-serif;'>
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >PROMEDIO GENERAL PERIODO:</span> ".number_format((float)$promedio,2,".",",")." 
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold; ' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPUESTO: </span>$puestoPeriodo
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >DE</span> $numest</td></tr>";
                	}
                	echo "</table><br/>";
                    /*if($mPerdidas>0 and $mPerdidas <3){
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
                   	echo "</table><br/>";*/
                    
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
                				        <td  class='Estilo1'>".utf8_decode($recordsog['nombre_materia'])."</td>
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
							<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
							<table class='firma' border='0'>
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
        	WHERE e.idestudiante=n.idestudiante AND m.idestudiante=n.idestudiante
			AND m.idaula=$idaula AND e.habilitado='S' 
			AND n.periodo=$periodo AND m.periodo='0' 
			AND n.aniolectivo=$aniolect AND m.aniolectivo=n.aniolectivo
			AND m.tipo_matricula='R' AND n.tipo_nota=m.tipo_matricula
			ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";
        	$consulta1 = $conx->query($sqlest);
            while($records1 = $conx->records_array($consulta1)){
    
               	 echo 
                    "<div class='fondo'><div style='line-height:7px;'>
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
					/*$sql = "SELECT DISTINCT mt.nombre_materia, n.* 
					FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
					AND mt.idmateria=n.idmateria AND n.periodo=$periodo  AND n.aniolectivo=$aniolect 
					AND n.tipo_nota='R' ORDER BY mt.nombre_materia ASC";*/
					$sql="SELECT *
					FROM clase c, aula a
					WHERE a.idaula = c.idaula
					AND a.idaula =$idaula AND aniolectivo=$aniolect";
					$consulta2 = $conx->query($sql);
					//$records2 = $conx->records_array($consulta2);
					$numasig=0;
					$numasigimp=0;
					$asigxpage=0;
					$numapaginas=0;
					//$numapaginas=$records2['nunmat']/$pages;
					while($records2 = $conx->records_array($consulta2)){
							$numasig++;
							$numasigimp++;
							if($numasigimp>$pages-1){
									$numasigimp=0;
									$numapaginas++;
									$asigxpage=$numasig;
							}
										
					}
					//verificar echo $numasig." - ".$asigxpage." - ".$numapaginas;
					if(($numasig-$asigxpage)>0){
						$numapaginas++;
					}/*
					if($convencion=='on'){
						$numapaginas++;
					}*/
					//----------------------------------------------------
                    //Generar resultados por asignatura
                    $sql = "SELECT DISTINCT mt.nombre_materia, n.* 
					FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
					AND mt.idmateria=n.idmateria AND n.periodo=$periodo  AND n.aniolectivo=$aniolect 
					AND n.tipo_nota='R' ORDER BY mt.nombre_materia ASC";
                	$consulta2 = $conx->query($sql);
                	$numasig=0;
                	$sumComp=0;
					$promComp=0;
                    $mPerdidas=0;
					$numasigimp=0;
					$pagina=1;
					$cantfundamentales=0;
					$cantoptativas=0;
					$cantprofundizacion=0;
					
                	while($records2 = $conx->records_array($consulta2)){
                        	$numasig++;
							$numasigimp++;
                            $desct='';
                            if($records2['vn'] >= (float)$rcbamin && $records2['vn'] <= (float)$rcbamax){
                        		$desempeno="Db"; 
                        	}else if($records2['vn'] >= (float)$rcbmin && $records2['vn'] <= (float)$rcbmax){
                        		$desempeno="DB";
                        	}else if($records2['vn'] >= (float)$rcamin && $records2['vn'] <= (float)$rcamax){
                        		$desempeno="DA";
                        	}else if($records2['vn'] >= (float)$rcsmin && $records2['vn'] <= (float)$rcsmax){
                        		$desempeno="DS";
                        	}
                        	if($desempeno=='Db'){
                        		$desempeno2="D-";
                        	}else{
                        		$desempeno2=$desempeno;
                        	}
                        	/*switch($records2['comportamiento']){
                        		case "DS": $sumDS++; break;
                        		case "DA": $sumDA++; break;
                        		case "DB": $sumDB++; break;
                        		case "D-": $sumDb++; break;
                        		default: break;
                        	}*/
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
							FROM indicadores i, indicadoresestudiantenf ib 
							WHERE i.idindicador=ib.idindicador AND i.idmateria=".$records2['idmateria']."
							AND i.idaula='".$idaula."' AND i.tipo='DS' 
							AND ib.aniolectivo=$aniolect
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
                                    $desempenofinal="";
									$promfinal=number_format((float)$promfinal,1,".",",");
                                    if($promfinal >= (float)$rcbamin and $promfinal <= (float)$rcbamax){
                                		$desempenofinal="Db";
                                        $mPerdidas++;
										$sqlareafund = "SELECT * FROM areasfundamentales WHERE codasig='".$records2['idmateria']."' AND $grado_int>=gradoinicia AND $grado_int<=gradotermina";
										$consultaareafund = $conx->query($sqlareafund);
                						if($conx->get_numRecords($consultaareafund)>0){	
											$cantfundamentales++;
										}
										$sqlareaopt = "SELECT * FROM areasoptativas WHERE codasig=".$records2['idmateria']." AND $grado_int>=gradoinicia AND $grado_int<=gradotermina";
										$consultaareaopt = $conx->query($sqlareaopt);
                						if($conx->get_numRecords($consultaareaopt)>0){	
											$cantoptativas++;
										}
										$sqlareapro = "SELECT * FROM areasprofundizacion WHERE codasig=".$records2['idmateria']." AND $grado_int>=gradoinicia AND $grado_int<=gradotermina";
										$consultaareapro = $conx->query($sqlareapro);
                						if($conx->get_numRecords($consultaareapro)>0){	
											$cantprofundizacion++;
										}
										
                                	}else if($promfinal >= (float)$rcbmin and $promfinal <= (float)$rcbmax){
                                		$desempenofinal="DB";
                                	}else if($promfinal >= (float)$rcamin and $promfinal <= (float)$rcamax){
                                		$desempenofinal="DA";
                                	}else if($promfinal >= (float)$rcsmin and $promfinal <= (float)$rcsmax){
                                		$desempenofinal="DS";
                                	}
									if($promfinal>=3.0){
										echo "<td width='47' rowspan='2' style='text-align:center;'><span style='font-weight:bold;'>".number_format((float)$promfinal,1,".",",")."</span></td>";
									}else{
										echo "<td width='47' rowspan='2' style='text-align:center;'><span style='font-weight:bold; color:red;'>".number_format((float)$promfinal,1,".",",")."</span></td>";
									}
                                    echo"<td width='96' rowspan='2' style='text-align:center; '><span style='font-weight:bold;'>".$desempenofinal."</span></td>
                                </tr>
                                <tr >
                                    <td width='499' colspan='3'  ><div align='justify'>".$desct."</div></td>
                                </tr>
                                </tbody></table>";
								if($numasigimp>$pages-1){
									echo "</div><br/><span style='text-align:right; margin-left:700px' class='continuapag'>PAGINA $pagina DE $numapaginas</span><h1 class='SaltoDePagina'> </h1><div class='fondo'><span class='continuapag'>CONTINUA BOLETIN FINAL: ".
									utf8_decode($records1['nombre1'])." ".utf8_decode($records1['nombre2'])." ".utf8_decode($records1['apellido1'])." ".
									utf8_decode($records1['apellido2'])."  &nbsp;&nbsp;&nbsp;".""."</span><br/>";
									$numasigimp=0;
									$pagina++;
								}
                                   /*$sqlconvivencia = "SELECT ide.comportamiento FROM  indicadoresestudiantenf  ide, indicadores i 
								   WHERE ide.idindicador=i.idindicador and i.idmateria=".$records2['idmateria']."
								   and ide.idestudiante='".$records1['idestudiante']."' and aniolectivo=$aniolect";*/
									//promedio comportamiento hasta el ultimo periodo elegido
										$sqlComp = "SELECT DISTINCT ROUND( AVG( comportamiento ) , 1 ) AS PromedioComp  
										FROM notas n, matricula m, estudiante e
										WHERE n.idestudiante = m.idestudiante
										AND n.idestudiante=e.idestudiante
										AND n.idestudiante='".$records1['idestudiante']."'
										AND e.habilitado='S'
										AND m.idaula =  '$idaula'
										AND m.aniolectivo ='$aniolect'
										AND m.aniolectivo = n.aniolectivo
										AND m.tipo_matricula = 'R'
										AND n.periodo <= $periodo
										GROUP BY n.idestudiante";
										$consultaProm = $conx->query($sqlComp);
										$recordsProm = $conx->records_array($consultaProm);
										$promComp=round($recordsProm['PromedioComp'],1);
										$comportamiento="";
										if($promComp >= $rcbamin && $promComp <= $rcbamax){
											$comportamiento="Db"; 
										}else if($promComp >= $rcbmin && $promComp <= $rcbmax){
											$comportamiento="DB";
										}else if($promComp >= $rcamin && $promComp <= $rcamax){
											$comportamiento="DA";
										}else if($promComp >= $rcsmin && $promComp <= $rcsmax){
											$comportamiento="DS";
										}
									/*$consultaconv = $conx->query($sqlconvivencia);
                					$recordsconv  = $conx->records_array($consultaconv);
									$sumComp+=$recordsconv['comportamiento'];*/
									/*switch($recordsconv['comportamiento']){
										case "DS": $sumDS++; break;
										case "DA": $sumDA++; break;
										case "DB": $sumDB++; break;
										case "D-": $sumDb++; break;
										default: break;
									}*/
								}
                    //------------------COMPORTAMIENTO
                   	//$promComp=round($sumComp/$numasig,1);
            	/*$porcDA=round(($sumDA*100)/$numasig);
            	$porcDB=round(($sumDB*100)/$numasig);
            	$porcDb=round(($sumDb*100)/$numasig);*/
            	/*$comportamiento="";
				if($promComp >= (float)$rcbamin and $promComp <= (float)$rcbamax){
					$comportamiento="Db"; 
				}else if($promComp >= (float)$rcbmin and $promComp <= (float)$rcbmax){
					$comportamiento="DB";
				}else if($promComp >= (float)$rcamin and $promComp <= (float)$rcamax){
					$comportamiento="DA";
				}else if($promComp >= (float)$rcsmin and $promComp <= (float)$rcsmax){
					$comportamiento="DS";
				}*/
					/*if($porcDS>$porcDA && $porcDS>$porcDB && $porcDS>$porcDb){
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
                			$comportamiento="DA";
                		}
                	}
                	if($comportamiento==""){
                		$comportamiento="DB";
                	}*/
					if($numasigimp>$pages){
									echo "</div><br/><span style='text-align:right; margin-left:700px' class='continuapag'>PAGINA $pagina DE $numapaginas</span><h1 class='SaltoDePagina'> </h1><div class='fondo'><span class='continuapag'>CONTINUA BOLETIN: ".
									utf8_decode($records1['nombre1'])." ".utf8_decode($records1['nombre2'])." ".utf8_decode($records1['apellido1'])." ".
									utf8_decode($records1['apellido2'])."  &nbsp;&nbsp;&nbsp;$periodo"."°"." PERIODO</span><br/>";
									$numasigimp=0;
									$pagina++;
					}
                	echo "<br/>
                    <table class='resultadoasig'>
                        <tr>
                		<td scope='col' colspan='6' class='Estilo5' >CONSOLIDADO CONVIVENCIAL </td>
                		<td scope='col' colspan='10	' class='fonttitle8' ><span style='fon-size:small; font-family: Times New Roman,sans-serif; font-weight:bold;'>$comportamiento: </span>";
                	
					if($idaula>=5 and $idaula<10){
						$sql3 = "SELECT DISTINCT descripcion 
							FROM indicadores WHERE tipo='$comportamiento' AND idaula=5 AND idmateria=27 AND habilitado='S' ORDER BY descripcion ASC";
					}elseif($idaula>=10 and $idaula<16){
						
						$sql3 = "SELECT DISTINCT descripcion 
							FROM indicadores WHERE tipo='$comportamiento' AND idaula='16' AND idmateria=27 AND habilitado='S' ORDER BY descripcion ASC";
					}
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
                	$sqlpuestoanio = "SELECT ROUND(AVG( vn ),3) AS promedio, SUM( vn ) AS sumnotas, n.idestudiante"
                    . "	FROM notas n, estudiante e, matricula m WHERE m.idaula='$idaula' AND n.idestudiante=e.idestudiante 
					AND m.idestudiante=e.idestudiante AND e.habilitado='S' 
					AND n.aniolectivo=$aniolect 
                    AND m.aniolectivo=n.aniolectivo
					AND m.tipo_matricula='R'
					AND m.tipo_matricula=n.tipo_nota
					AND n.idmateria != '27'				
                	GROUP BY n.idestudiante
                	ORDER BY promedio DESC";
                	//$consultapuesto = $conx->query($sqlpuesto);
                	$consultapuestoanio = $conx->query($sqlpuestoanio);
                	$puesto=1;
                	$puestoanio=1;
                	$numest= $conx->get_numRecords($consultapuestoanio);
                	$notaEstAnt=0;
                	
					$puestoAnio2= puestoAnioAlg2($records1['idestudiante'], $idaula, $aniolect, $periodo);
					//consultar promedio de estudiante a buscar
					$sqlarraypuestoEst="	
									SELECT ROUND( AVG( n.vn ) , 3 ) AS Promedio 
									FROM notas n, matricula m, estudiante e
									WHERE n.idestudiante = m.idestudiante
									AND n.idestudiante=e.idestudiante
									AND n.idestudiante=".$records1['idestudiante']."
									AND e.habilitado='S'
									AND m.idaula =  '$idaula'
									AND m.aniolectivo ='$aniolect'
									AND m.aniolectivo = n.aniolectivo
									AND m.tipo_matricula = 'R'
									AND n.periodo <= '$periodo'
									GROUP BY n.idestudiante
									ORDER BY Promedio DESC;
									";
					$consultapuestoarrayEst = $conx->query($sqlarraypuestoEst);
					$recordspuestoarrayEst = $conx->records_array($consultapuestoarrayEst);
					$promedioanio=$recordspuestoarrayEst['Promedio'];
					//--------------------------
					$sqlpuesto = "SELECT AVG( vn ) AS promedio, SUM( vn ) AS sumnotas, n.idestudiante 
                	FROM notas n, estudiante e, matricula m WHERE m.idaula='$idaula' AND n.idestudiante=e.idestudiante AND n.periodo='$periodo' 
                    AND m.idestudiante=e.idestudiante AND e.habilitado='S'
                    AND n.aniolectivo=$aniolect 
                    AND m.aniolectivo=n.aniolectivo
					AND m.tipo_matricula='R'
					AND m.tipo_matricula=n.tipo_nota
                	GROUP BY n.idestudiante
                	ORDER BY promedio DESC";
                	
                	$consultapuesto = $conx->query($sqlpuesto);
                	$puesto=1;
                	$numest= $conx->get_numRecords($consultapuesto);
                	$notaEstAnt=0;
                	//Buscar el puesto academico segun resultados
					$puestoPeriodo= puestoPeriodoAlg2($records1['idestudiante'], $idaula, $aniolect, $periodo);
					$sqlPromedio = "SELECT AVG( n.vn ) AS promedio 
                	FROM notas n WHERE n.idestudiante=".$records1['idestudiante']." AND 
					n.periodo='$periodo' 
                    AND n.aniolectivo=$aniolect
					GROUP BY n.idestudiante";
					$consultaPromPeriodo = $conx->query($sqlPromedio);
					$recordsPromedio = $conx->records_array($consultaPromPeriodo);
					$promedio=$recordsPromedio['promedio'];              
                		
					//fin consulta promedio estudiante
					                	               
                	echo "<br/><table class='resultadoasig'>";
                	if($periodo<='4'){
          			echo"
                		<td style='text-align:left; font:12px 	arial,sans-serif;'>
						<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >PROMEDIO GENERAL PERIODO:</span> ".number_format((float)$promedio,2,".",",")." 
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold; ' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPUESTO: </span>$puestoPeriodo
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >DE</span> $numest
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPROMEDIO GENERAL AÑO LECTIVO:</span> ".number_format((float)$promedioanio,3,".",",")." 
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold; ' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPUESTO: </span>$puestoAnio2
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >DE</span> $numest</td></tr>";
                	}
                	echo "</table><br/>";
					
					$sqlprom = "SELECT resultadoprom FROM nivelespromocion WHERE areasfundamentales = $cantfundamentales AND areasoptativas = $cantoptativas
					AND areasprofundizacion = $cantprofundizacion  AND aniolect=$aniolect";
					$consultaprom = $conx->query($sqlprom);
                    $recordsprom = $conx->records_array($consultaprom);
					
					if($recordsprom['resultadoprom']=="PromovidoR"){
						$sqlpromocion="SELECT descripcion FROM aula  WHERE idaula IN ( SELECT idaulafin FROM promocion WHERE idaulainicio=$idaula)";
						$consultapromocion = $conx->query($sqlpromocion);
                		$descripcionProm  = $conx->records_array($consultapromocion);
						if($descripcionProm['descripcion']!='GRADUADO(A)'){
							$descripcion= $descripcionProm['descripcion'];
						}
                        $estadoP= "<span style='color:blue;'>"."PROMOVIDO AL GRADO ".$descripcion."</span>. Debe presentar actividades de recuperación, $mPerdidas área(s) reprobada(s).";
                    }else if($recordsprom['resultadoprom']=="Reprobado" or $cantfundamentales>3){
            		      $estadoP="<span style='color:black;'>DEBE REPETIR EL GRADO, </span> Tiene $mPerdidas área(s) reprobada(s).";
                    }else{
                        $estadoP= "FUE PROMOVIDO(A)";
						$sqlpromocion="SELECT descripcion FROM aula  WHERE idaula IN ( SELECT idaulafin FROM promocion WHERE idaulainicio=$idaula)";
						$consultapromocion = $conx->query($sqlpromocion);
                		$descripcionProm  = $conx->records_array($consultapromocion);
						if($descripcionProm['descripcion']!='GRADUADO(A)'){
							$estadoP= "FUE PROMOVIDO(A) AL GRADO ".$descripcionProm['descripcion'];
						}else{
							$estadoP= $descripcionProm['descripcion'];
						}
            			//$estadoP.=" SEGÚN LO ESTABLECIDO EN EL PEI DEL COLEGIO";
            		}
                    /*if($mPerdidas>0 and $mPerdidas <3){
                        $estadoP= "<span style='color:red;'>"."PROMOCION PENDIENTE,"."</span> Tiene $mPerdidas área(s) reprobada(s)";
                    }elseif($mPerdidas>2){
            		      $estadoP= "<span style='color:red;'>"."DEBE REPETIR EL GRADO, "."</span> Tiene $mPerdidas área(s) reprobada(s).";
                    }elseif($mPerdidas==0){
                        $estadoP= "FUE PROMOVIDO(A)";
						$sqlpromocion="SELECT descripcion FROM aula  WHERE idaula IN ( SELECT idaulafin FROM promocion WHERE idaulainicio=$idaula)";
						$consultapromocion = $conx->query($sqlpromocion);
                		$recordsprom  = $conx->records_array($consultapromocion);
						if($recordsprom['descripcion']!='GRADUADO(A)'){
							$estadoP= "FUE PROMOVIDO(A) AL GRADO ".$recordsprom['descripcion'];
						}else{
							$estadoP= $recordsprom['descripcion'];
						}
            			/*switch($grado){
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
            		//}*/
                	
                    echo "<br/><table class='resultadoasig'>";
                	if($periodo==4){
                		echo "<tr><td style='text-align:left; font:12px 	arial,sans-serif;'>
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >$estadoP</span></td></tr>";
                	}
                   	echo "</table><br/>";
                    
                    //------------------FIN PUESTO 
                    if($convencion=='on'){
									
									echo "</div><br/><span style='text-align:right; margin-left:700px' class='continuapag'>PAGINA $pagina DE $numapaginas</span><h1 class='SaltoDePagina'> </h1><div class='fondo'><span class='continuapag'>CONTINUA BOLETIN: ".
									utf8_decode($records1['nombre1'])." ".utf8_decode($records1['nombre2'])." ".utf8_decode($records1['apellido1'])." ".
									utf8_decode($records1['apellido2'])."  &nbsp;&nbsp;&nbsp;$periodo"."°"." PERIODO</span><br/>";
									$pagina++;
					}
					//------------------OBSERVACIONES
                    /*echo "
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
											<br/><span align='center' class='blocktext' >Rector(a)</span>
						
										</td>
										<td align='center'>
											<span class='blocktext' style='text-decoration:overline; font-weight:bold'>$docentedg</span>
											<br/><span align='center' class='blocktext' >Coordinador(a) de Grupo</span>
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
											<br/><span align='center' class='blocktext' >Rector(a) de Grupo</span>
						
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
        	WHERE e.idestudiante=n.idestudiante AND m.idestudiante=n.idestudiante
			AND m.idaula=$idaula AND e.habilitado='S' 
			AND n.periodo=$periodo AND m.periodo='0' 
			AND n.aniolectivo=$aniolect AND m.aniolectivo=n.aniolectivo
			AND m.tipo_matricula='R' AND n.tipo_nota=m.tipo_matricula
			ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";
        	$consultaest = $conx->query($sqlest);
			if($convencion=='on'){
				$extrapag=1;
			}else{
				$extrapag=0;
			}
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
                                        //echo "<span align='center' class='tituloinforme' align='center'><p class='fonttitle6'>INFORME FINAL</p></span>";        
										 echo "<span align='center' class='tituloinforme' align='center'><p class='fonttitle6'>INFORME $periodo"."°"." PERIODO</p></span>"; 
                                    }else{
                                        echo "<br/><span align='center' class='tituloinforme' align='center'><span class='fonttitle6'>INFORME $periodo"."°"." PERIODO</span></span>";        
									
									}
                                echo "
                            </td>
                        </tr>
                        
                </table>
            	</div>";
            	echo "<table class='alumnoKinder'>
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
				/*$sql = "SELECT DISTINCT mt.nombre_materia, n.* 
            	FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
				AND mt.idmateria=n.idmateria AND n.periodo=$periodo  AND n.aniolectivo=$aniolect 
				AND n.tipo_nota='R' ORDER BY mt.nombre_materia ASC";*/
            	$sql="SELECT *
					FROM clase c, aula a
					WHERE a.idaula = c.idaula
					AND a.idaula =$idaula";
					$consulta2 = $conx->query($sql);
					//$records2 = $conx->records_array($consulta2);
					$numasig=0;
					$numasigimp=0;
					$asigxpage=0;
					$numapaginas=0;
					//$numapaginas=$records2['nunmat']/$pages;
					while($records2 = $conx->records_array($consulta2)){
							$numasig++;
							$numasigimp++;
							if($numasigimp>$pages-1){
									$numasigimp=0;
									$numapaginas++;
									$asigxpage=$numasig;
							}
										
					}
					$numasig=$numasig-1;
					//echo $numasig." - ".$asigxpage." - ".$pages;
					if(($numasig-$asigxpage)>0){
						$numapaginas++;
					}
				//----------------------------------------------------
				$numapaginas+=$extrapag;
                //Generar resultados por asignatura
                $sql = "SELECT DISTINCT mt.nombre_materia, n.* 
            	FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
				AND mt.idmateria=n.idmateria AND n.idmateria!=25 AND n.periodo=$periodo  AND n.aniolectivo=$aniolect 
				AND n.tipo_nota='R' ORDER BY mt.nombre_materia ASC";
            	$consulta2 = $conx->query($sql);
            	$numasig=0;
            	$sumComp=0;
            	$promComp=0;
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
                    		//$desempeno="Db";
							$desempeno="<img src='../../images/caritaD-.png'</img>";
                    	}else if($records2['vn'] >= (float)$rcbmin and $records2['vn'] <= (float)$rcbmax){
                    		//$desempeno="DB";
							$desempeno="<img src='../../images/caritaDB.png'</img>";
                    	}else if($records2['vn'] >= (float)$rcamin and $records2['vn'] <= (float)$rcamax){
                    		//$desempeno="DA";
							$desempeno="<img src='../../images/caritaDA.png'</img>";
                    	}else if($records2['vn'] >= (float)$rcsmin and $records2['vn'] <= (float)$rcsmax){
                    		//$desempeno="DS";
							$desempeno="<img src='../../images/caritaDS.png'</img>";

                    	}
                    	/*if($desempeno=='Db'){
                    		$desempeno2="D-";
                    	}else{
                    		$desempeno2=$desempeno;
                    	}*/
                    	switch($records2['comportamiento']){
                    		case "DS": $sumDS++; break;
                    		case "DA": $sumDA++; break;
                    		case "DB": $sumDB++; break;
                    		case "D-": $sumDb++; break;
                    		default: break;
                    	}
						$sumComp+=$records2['comportamiento'];
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
										//$desempenon="Db";
										$desempenon="<img src='../../images/caritaD-.png'</img>";
									}else if($recordsn['vn'] >= (float)$rcbmin and $recordsn['vn'] <= (float)$rcbmax){
										//$desempenon="DB";
										$desempenon="<img src='../../images/caritaDB.png'</img>";
									}else if($recordsn['vn'] >= (float)$rcamin and $recordsn['vn'] <= (float)$rcamax){
										//$desempenon="DA";
										$desempenon="<img src='../../images/caritaDA.png'</img>";
									}else if($recordsn['vn'] >= (float)$rcsmin and $recordsn['vn'] <= (float)$rcsmax){
										//$desempenon="DS";
										$desempenon="<img src='../../images/caritaDS.png'</img>";
									}
							}
							//descripcion del indicador de desempeño
							$sql4 = "SELECT DISTINCT i.descripcion, i.idmateria
							FROM indicadores i, indicadoresestudiante ib 
							WHERE i.idindicador=ib.idindicador AND i.idmateria=25
							AND i.idaula='".$idaula."' AND i.tipo='DS' 
							AND ib.periodo=$periodo AND ib.aniolectivo=$aniolect
							AND ib.idestudiante=".$records1['idestudiante']." ORDER BY ib.idindicador ASC";
							$consulta4 = $conx->query($sql4);
							$desct4="<ul>";
							//echo $records4['idmateria'];
							while($records4 = $conx->records_array($consulta4)){
							  $desct4.="<li style='list-style-type:circle'>".String_oracion($records4['descripcion'])."</li>	";
							}
							$desct4.="</ul>";
							 echo"                           
                            <tr >
								<td width='100' style='text-align:center;' class='textcn' rowspan='2'>".utf8_decode($records2['nombre_materia'])."</td>";
								if ($idaula!=1 and $idaula!=2) {
									echo"<td width='499' colspan='1'  ><div align='justify'><span style='text-decoration: underline;'>INGLES</span><br/>$desct4</div></td>";
								
									echo "<td width='96' rowspan='1' style='text-align:center; '><span style='font-weight:bold;'>".$desempenon."</span></td>";
								}
                            echo "</tr>
							
							<tr>";
								echo "<td width='499' colspan='1'  ><div align='justify'>$desct</div></td>";
								echo "<td width='96' rowspan='1' style='text-align:center; '><span style='font-weight:bold;'>".$desempeno."</span></td>
							</tr>";
						
						}
						if($records2['idmateria']==3){
							echo"                           
                            <tr >
								<td width='100' style='text-align:center;' class='textcn'>CORPORAL</td>
                                <td width='499' colspan='1'  ><div align='justify'>$desct</div></td>
                                <td width='96' rowspan='1' style='text-align:center; '><span style='font-weight:bold;'>".$desempeno."</span></td>

                            </tr>";
						
						}else if($records2['idmateria']!=21){
						
						    echo"                           
                            <tr >
								<td width='100' style='text-align:center;' class='textcn'>".utf8_decode($records2['nombre_materia'])."</td>
                                <td width='499' colspan='1'  ><div align='justify'>$desct</div></td>
                                <td width='96' rowspan='1' style='text-align:center; '><span style='font-weight:bold;'>".$desempeno."</span></td>

                            </tr>";
						}
						
                        /*echo $numasigimp."-".$pages; 
						if($numasigimp>$pages-1){
								echo "</div><br/><span style='text-align:right; margin-left:700px' class='continuapag'>PAGINA $pagina DE 2</span><h1 class='SaltoDePagina'> </h1><div class='fondo'><span class='continuapag'>CONTINUA BOLETIN: ".
								utf8_decode($records1['nombre1'])." ".utf8_decode($records1['nombre2'])." ".utf8_decode($records1['apellido1'])." ".
								utf8_decode($records1['apellido2'])."  &nbsp;&nbsp;&nbsp;$periodo"."°"." PERIODO</span><br/>";
								$numasigimp=0;
								$pagina++;
						}*/						
            	}
				echo "</tbody></table>";
                //------------------COMPORTAMIENTO
               	$promComp=round($sumComp/$numasig,1);
            	/*$porcDA=round(($sumDA*100)/$numasig);
            	$porcDB=round(($sumDB*100)/$numasig);
            	$porcDb=round(($sumDb*100)/$numasig);*/
            	$comportamiento="";
				if($promComp >= (float)$rcbamin and $promComp <= (float)$rcbamax){
					$comportamiento="Db"; 
				}else if($promComp >= (float)$rcbmin and $promComp <= (float)$rcbmax){
					$comportamiento="DB";
				}else if($promComp >= (float)$rcamin and $promComp <= (float)$rcamax){
					$comportamiento="DA";
				}else if($promComp >= (float)$rcsmin and $promComp <= (float)$rcsmax){
					$comportamiento="DS";
				}
            	/*if($porcDS>$porcDA && $porcDS>$porcDB && $porcDS>$porcDb){
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
            	}*/
				
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
						if($pages>4){
								echo "</div><br/><span style='text-align:right; margin-left:700px' class='continuapag'>PAGINA $pagina DE 2</span><h1 class='SaltoDePagina'> </h1><div class='fondo'><span class='continuapag'>CONTINUA BOLETIN: ".
								utf8_decode($records1['nombre1'])." ".utf8_decode($records1['nombre2'])." ".utf8_decode($records1['apellido1'])." ".
								utf8_decode($records1['apellido2'])."  &nbsp;&nbsp;&nbsp;$periodo"."°"." PERIODO</span><br/>";
								$numasigimp=0;
								$pagina++;
						}
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
                    	if($pages>4){
								echo "</div><br/><span style='text-align:right; margin-left:700px' class='continuapag'>PAGINA $pagina DE $numapaginas</span><h1 class='SaltoDePagina'> </h1>";
						}else{
							echo "</div><h1 class='SaltoDePagina'></h1>";
						}
                        
                	//-------------------------------FIN LADO B------------------------------------------------  
			}
	}elseif($formato=="f4"){
			$sqlest = "SELECT DISTINCT e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula, e.idestudiante 
			FROM estudiante e, notas n, matricula m 
        	WHERE e.idestudiante=n.idestudiante AND m.idestudiante=n.idestudiante
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
					/*$sql = "SELECT DISTINCT mt.nombre_materia, n.* 
					FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
					AND mt.idmateria=n.idmateria AND n.periodo=$periodo  AND n.aniolectivo=$aniolect 
					AND n.tipo_nota='R' ORDER BY mt.nombre_materia ASC";*/
					$sql="SELECT *
					FROM clase c, aula a
					WHERE a.idaula = c.idaula
					AND a.idaula =$idaula";
					$consulta2 = $conx->query($sql);
					//$records2 = $conx->records_array($consulta2);
					$numasig=0;
					$numasigimp=0;
					$asigxpage=0;
					$numapaginas=0;
					//$numapaginas=$records2['nunmat']/$pages;
					while($records2 = $conx->records_array($consulta2)){
							$numasig++;
							$numasigimp++;
							if($numasigimp>$pages-1){
									$numasigimp=0;
									$numapaginas++;
									$asigxpage=$numasig;
							}
										
					}
					//verificar echo $numasig." - ".$asigxpage." - ".$numapaginas;
					if(($numasig-$asigxpage)>0){
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
                        	/*switch($records2['comportamiento']){
                        		case "DS": $sumDS++; break;
                        		case "DA": $sumDA++; break;
                        		case "DB": $sumDB++; break;
                        		case "D-": $sumDb++; break;
                        		default: break;
                        	}*/
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
							FROM indicadores i, indicadoresestudiantenf ib 
							WHERE i.idindicador=ib.idindicador AND i.idmateria=".$records2['idmateria']."
							AND i.idaula='".$idaula."' AND i.tipo='DS' 
							AND ib.aniolectivo=$aniolect
							AND ib.idestudiante=".$records1['idestudiante']." ORDER BY ib.idindicador ASC";
							$consulta3 = $conx->query($sql3);
							$desct="<ul>";
                    		while($records3 = $conx->records_array($consulta3)){
								$desct.="<li style='list-style-type:circle'>".$records3['descripcion']."</li>	";                    		//$desc=ucfirst($desc);
                    		
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
                                    $promfinal=number_format((float)$promfinal,1,".",",");
                                    if($promfinal >= (float)$rcbamin and $promfinal <= (float)$rcbamax){
                                		$desempeno="<img src='../../images/caritaD-.png'></img>";
                                        $mPerdidas++; 
                                	}else if($promfinal >= (float)$rcbmin and $promfinal <= (float)$rcbmax){
                                		$desempeno="<img src='../../images/caritaDB.png'></img>";
                                	}else if($promfinal >= (float)$rcamin and $promfinal <= (float)$rcamax){
                                		$desempeno="<img src='../../images/caritaDA.png'></img>";
                                	}else if($promfinal >= (float)$rcsmin and $promfinal <= (float)$rcsmax){
                                		$desempeno="<img src='../../images/caritaDS.png'></img>";
                                	}
                                    echo "<td width='47' rowspan='2' style='text-align:center;'><span style='font-weight:bold;'>".number_format((float)$promfinal,1,".",",")."</span></td>
                                    <td width='96' rowspan='2' style='text-align:center; '><span style='font-weight:bold;'>".$desempeno."</span></td>
                                </tr>
                                <tr >
                                    <td width='499' colspan='3'  ><div align='justify'>$desct</div></td>
                                </tr>
                                </tbody></table>";
								if($numasigimp>$pages-1){
									echo "</div><br/><span style='text-align:right; margin-left:700px' class='continuapag'>PAGINA $pagina DE $numapaginas</span><h1 class='SaltoDePagina'> </h1><div class='fondo'><span class='continuapag'>CONTINUA BOLETIN: ".
									utf8_decode($records1['nombre1'])." ".utf8_decode($records1['nombre2'])." ".utf8_decode($records1['apellido1'])." ".
									utf8_decode($records1['apellido2'])."  &nbsp;&nbsp;&nbsp;$periodo"."°"." PERIODO</span><br/>";
									$numasigimp=0;
									$pagina++;
								}
                                   $sqlconvivencia = "SELECT ide.comportamiento FROM  indicadoresestudiantenf  ide, indicadores i 
								   WHERE ide.idindicador=i.idindicador and i.idmateria=".$records2['idmateria']."
								   and ide.idestudiante='".$records1['idestudiante']."' and aniolectivo=$aniolect";  
									$consultaconv = $conx->query($sqlconvivencia);
                					$recordsconv  = $conx->records_array($consultaconv);
									switch($recordsconv['comportamiento']){
										case "DS": $sumDS++; break;
										case "DA": $sumDA++; break;
										case "DB": $sumDB++; break;
										case "D-": $sumDb++; break;
										default: break;
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
					if($numasigimp>$pages){
									echo "</div><br/><span style='text-align:right; margin-left:700px' class='continuapag'>PAGINA $pagina DE $numapaginas</span><h1 class='SaltoDePagina'> </h1><div class='fondo'><span class='continuapag'>CONTINUA BOLETIN: ".
									utf8_decode($records1['nombre1'])." ".utf8_decode($records1['nombre2'])." ".utf8_decode($records1['apellido1'])." ".
									utf8_decode($records1['apellido2'])."  &nbsp;&nbsp;&nbsp;$periodo"."°"." PERIODO</span><br/>";
									$numasigimp=0;
									$pagina++;
					}
                	echo "<br/>";
                    
                    //------------------FIN COMPORTAMIENTO
                    //------------------PUESTO PERIODO Y ANUAL
                    $sqlTasig = "SELECT DISTINCT idmateria FROM clase WHERE aniolectivo=$aniolect AND idaula=$idaula";
                	$consultaTasig= $conx->query($sqlTasig);
                	$numasigProm= $conx->get_numRecords($consultaTasig);
                	$sqlpuestoanio = "SELECT ROUND(AVG( vn ),3) AS promedio, SUM( vn ) AS sumnotas, n.idestudiante"
                    . "	FROM notas n, estudiante e, matricula m WHERE m.idaula='$idaula' AND n.idestudiante=e.idestudiante 
					AND m.idestudiante=e.idestudiante AND e.habilitado='S' 
					AND n.aniolectivo=$aniolect 
                    AND m.aniolectivo=n.aniolectivo
					AND m.tipo_matricula='R'
					AND m.tipo_matricula=n.tipo_nota
                	GROUP BY n.idestudiante
                	ORDER BY promedio DESC";
                	//$consultapuesto = $conx->query($sqlpuesto);
                	$consultapuestoanio = $conx->query($sqlpuestoanio);
                	$puesto=1;
                	$puestoanio=1;
                	$numest= $conx->get_numRecords($consultapuestoanio);
                	$notaEstAnt=0;
                	
					$puestoAnio2= puestoAnioAlg2($records1['idestudiante'], $idaula, $aniolect, $periodo);
					//consultar promedio de estudiante a buscar
					$sqlarraypuestoEst="	
									SELECT ROUND( AVG( n.vn ) , 3 ) AS Promedio 
									FROM notas n, matricula m, estudiante e
									WHERE n.idestudiante = m.idestudiante
									AND n.idestudiante=e.idestudiante
									AND n.idestudiante=".$records1['idestudiante']."
									AND e.habilitado='S'
									AND m.idaula =  '$idaula'
									AND m.aniolectivo ='$aniolect'
									AND m.aniolectivo = n.aniolectivo
									AND m.tipo_matricula = 'R'
									AND n.periodo <= '$periodo'
									GROUP BY n.idestudiante
									ORDER BY Promedio DESC;
									";
					$consultapuestoarrayEst = $conx->query($sqlarraypuestoEst);
					$recordspuestoarrayEst = $conx->records_array($consultapuestoarrayEst);
					$promedioanio=$recordspuestoarrayEst['Promedio'];
					//fin consulta promedio estudiante
					                	               
                	echo "<br/><table class='resultadoasig'>";
                	if($periodo<='4'){
          			echo"
                		<td style='text-align:left; font:12px 	arial,sans-serif;'>
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >PROMEDIO GENERAL AÑO LECTIVO:</span> ".number_format((float)$promedioanio,3,".",",")." 
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold; ' >&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPUESTO: </span>$puestoAnio2
                		<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >DE</span> $numest</td></tr>";
                	}
                	echo "</table><br/>";
                    if($mPerdidas>0 and $mPerdidas <3){
                        $estadoP= "<span style='color:red;'>"."PROMOCION PENDIENTE,"."</span> Tiene $mPerdidas área(s) reprobada(s)";
                    }elseif($mPerdidas>2){
            		      $estadoP= "<span style='color:red;'>"."DEBE REPETIR EL GRADO, "."</span> Tiene $mPerdidas área(s) reprobada(s).";
                    }elseif($mPerdidas==0){
                        $estadoP= "FUE PROMOVIDO(A)";
						$sqlpromocion="SELECT descripcion FROM aula  WHERE idaula IN ( SELECT idaulafin FROM promocion WHERE idaulainicio=$idaula)";
						$consultapromocion = $conx->query($sqlpromocion);
                		$recordsprom  = $conx->records_array($consultapromocion);
						if($recordsprom['descripcion']!='GRADUADO(A)'){
							$estadoP= "FUE PROMOVIDO(A) AL GRADO ".$recordsprom['descripcion'];
						}else{
							$estadoP= $recordsprom['descripcion'];
						}
            			/*switch($grado){
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
            									
            			}*/
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
											<br/><span align='center' class='blocktext' >Rector(a)</span>
						
										</td>
										<td align='center'>
											<span class='blocktext' style='text-decoration:overline; font-weight:bold'>$docentedg</span>
											<br/><span align='center' class='blocktext' >Coordinador(a) de Grupo</span>
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
											<br/><span align='center' class='blocktext' >Rector(a) de Grupo</span>
						
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