<?php
//Datos de Configuración de la app
session_start();
include("../../class/ultimatemysql/mysql.class.php");
include('../../bdConfig.php');
include('../../class/puesto.php');
include('../../class/MySqlClass.php');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$consulta = $conx->query("SET NAMES 'utf8'");
$sql = "SELECT valor FROM appconfig WHERE item='ie'";
$consulta = $conx->query($sql);
$records = $conx->records_array($consulta);
$ie= $records['valor'];


$sqlaaula = "SELECT descripcion, grupo, jornada FROM aula WHERE idaula = ".$_GET["aula"];
$consultaaula = $conx->query($sqlaaula);    
$recordsaula = $conx->records_array($consultaaula);
if($recordsaula['jornada']=='M'){
$jornada="MAÑANA";
}else{
$jornada="TARDE";

}
$aula=$recordsaula['descripcion']."-".$recordsaula['grupo']."-".$jornada;
$sql = "SELECT valor FROM appconfig WHERE item = 'pages'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$pages = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'convenciones'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$convencion = $records['valor'];
$p=4;
$al=$_GET["aniolectivo"];
$papel="legal";

?>
<html>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<head>
<title><?php echo "BOLETIN GRADO $aula-PERIODO $p - $al"; ?></title>
<link  href="http://fonts.googleapis.com/css?family=Cabin+Sketch:bold" rel="stylesheet" type="text/css" >
<link  href="http://fonts.googleapis.com/css?family=Lobster:regular" rel="stylesheet" type="text/css" >
<link  href="http://fonts.googleapis.com/css?family=Tangerine:regular,bold" rel="stylesheet" type="text/css" >
<!-- Custom styles for this template -->
<link rel="stylesheet" type="text/css" href="../../css/boletin.css" media="print, screen">
<style type="text/css" media="print">
@page{
   size:Legal portrait;
   margin: 10mm 0 0 0;
}
</style>
<script src="../../js/jquery.js"></script>
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
//$docx->addText($text, $paramsText);$docx->createDocx('example_text');
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
$idaula = $_GET['aula'];
$aniolect= $_GET['aniolectivo'];
$numcert= $_GET['numcert'];
$numdoc= $_GET['numdoc'];
$formato= "f3";
$sql = "SELECT num_periodos, tipo_periodo FROM periodos_por_anio WHERE anio = '$aniolect'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$num_periodos = $records['num_periodos'];
$tipo_periodo = $records['tipo_periodo'];
if($aniolect>2016){
	$p=$num_periodos;
	$formato= "f5";
}	
$periodo= $p;
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
//aula
$sqlaaula = "SELECT descripcion, idaula, grado, grupo, jornada FROM aula WHERE idaula = $idaula";
$consultaaula = $conx->query($sqlaaula);    
$recordsaula = $conx->records_array($consultaaula);
if($recordsaula['jornada']=="M"){
	$jornada="MAÑANA";
}else{
	$jornada="TARDE";
}
$grado2=$recordsaula['descripcion']."-".$recordsaula['grupo']."-".$jornada;
$grado=$recordsaula['grado'];
$idaula=$recordsaula['idaula'];
$gradonombre=$recordsaula['descripcion'];
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
    if($formato=="f1"){
           $sqlest = "SELECT DISTINCT e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula, e.idestudiante 
			FROM estudiante e, notas n, matricula m 
        	WHERE e.idestudiante=n.idestudiante AND m.idestudiante=n.idestudiante
			AND m.idaula=$idaula  
			AND n.periodo=$periodo AND m.periodo='0' 
			AND n.aniolectivo=$aniolect AND m.aniolectivo=n.aniolectivo
			AND m.tipo_matricula='R' AND n.tipo_nota=m.tipo_matricula
			ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";
        	$consultaest = $conx->query($sqlest);
			//
            while($records1 = $conx->records_array($consultaest)){
            	echo 
                "<div class='fondo'><div style='line-height:7px;'>
                <table class='normal'>
                        <tr>
                            <td width='100px' align='left' rowspan='2' valign='top'>
                                <span  class='blocktext'><img  src='../../images/logocol.png' width='95' height='95'/></span>
                            </td>
                            <td >
								<span class='ie' align='center'>".($ie)."</span><br/>
            	                <span class='lema' align='center'>".($lema)."</span><br/>
            	                <span class='lema' align='center'>".$ciudad."-".$departamento."</span><br/>
                                
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
                $records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".$records1['apellido2']." (CODIGO: ".$records1['idestudiante'].")
                <br/>GRADO:&nbsp;".$grado."
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
				AND mt.idmateria=n.idmateria AND n.periodo=$periodo  AND n.aniolectivo=$aniolect 
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
                        $docente = ($recordsd['nombre1'])." ".($recordsd['nombre2'])." ".($recordsd['apellido1'])." ".($recordsd['apellido2']);
                        $ih = $recordsd['ih'];
                        $iddocente = $recordsd['iddocente'];
                        //descripcion del indicador de desempeño
						$sql3 = "SELECT DISTINCT i.descripcion 
                		FROM indicadores i, indicadoresestudiante ib 
						WHERE i.idindicador=ib.idindicador AND i.idmateria=".$records2['idmateria']."
						AND i.idaula IN (SELECT idaula FROM aula WHERE grado='$grado_int') 
                		AND ib.periodo=$periodo AND ib.aniolectivo=$aniolect
						AND ib.idestudiante=".$records1['idestudiante']." ORDER BY ib.idindicador ASC";
                		$consulta3 = $conx->query($sql3);
						$desct="<ul>";
                		while($records3 = $conx->records_array($consulta3)){
                		  $desct.="<li style='list-style-type:circle'>".String_oracion($records3['descripcion'])."</li>	";
						}
						$desct.="</ul>";
                       
                        echo"<br/><table class='resultadoasig'>
                            <tbody>
                            <tr style=''>
                                <td width='100' style='text-align:center;' class='textcn'>".($records2['nombre_materia'])."</td>
                                <td width='277'><span style='font-style: italic;'>Prof:</span> <span class='textcn'>".$docente."</span></td>
                                <td width='66' style='text-align:center;' class='textcn'>I.H: $ih</td>
                                <td width='76' style='text-align:center;' colspan='2' class='textcn'>INASISTENCIAS</td>
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
									echo "</div><br/><span style='text-align:right; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span><h1 class='SaltoDePagina'> </h1><div class='fondo'><span class='continuapag'>CONTINUA BOLETIN: ".
									$records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
									$records1['apellido2']."  &nbsp;&nbsp;&nbsp;$periodo"."°"." PERIODO</span><br/>";
									$numasigimp=0;
									$pagina++;
							}
                                    
            	}
                //------------------COMPORTAMIENTO
               	$promComp=round($sumComp/$numasig,1);
            	/*$porcDA=round(($sumDA*100)/$numasig);
            	$porcDB=round(($sumDB*100)/$numasig);
            	$porcDb=round(($sumDb*100)/$numasig);*/
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
									echo "</div><br/><span style='text-align:right; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span><h1 class='SaltoDePagina'> </h1><div class='fondo'><span class='continuapag'>CONTINUA BOLETIN: ".
									$records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
									$records1['apellido2']."  &nbsp;&nbsp;&nbsp;$periodo"."°"." PERIODO</span><br/>";
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
                </table>"; */   
                //------------------FIN COMPORTAMIENTO
                //------------------PUESTO PERIODO Y ANUAL
                    $sqlTasig = "SELECT DISTINCT idmateria FROM clase WHERE aniolectivo=$aniolect AND idaula=$idaula";
                	$consultaTasig= $conx->query($sqlTasig);
                	$numasigProm= $conx->get_numRecords($consultaTasig);
                	$sqlpuesto = "SELECT AVG( vn ) AS promedio, SUM( vn ) AS sumnotas, n.idestudiante 
                	FROM notas n, estudiante e, matricula m WHERE m.idaula='$idaula' AND n.idestudiante=e.idestudiante AND n.periodo='$periodo' 
                    AND m.idestudiante=e.idestudiante 
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
						/*$sqldg = "SELECT DISTINCT d.* 
                        FROM coordinadoresgrupo c, docente d
                        WHERE c.idaula = $idaula
                        AND c.aniolectivo =  $aniolect
                        AND c.iddocente=d.iddocente";*/
						$sqldg = "SELECT DISTINCT d.* 
                        FROM clase c, docente d
                        WHERE c.idaula = $idaula
                        AND c.aniolectivo =  $aniolect
                        AND c.idmateria =  27
                        AND c.iddocente=d.iddocente";
                        $consultadg = $conx->query($sqldg);
                		$recordsdg = $conx->records_array($consultadg);
                        $docentedg = $recordsdg['apellido1']." ".$recordsdg['apellido2']." ".$recordsdg['nombre1']." ".$recordsdg['nombre2'];				
                	   if($periodo==4){
							echo 
							"<div style='line-height:7px;'>
							<br/><br/><br/><br/><br/><br/><br/><br/>
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
							<br/><br/><br/><br/><br/><br/><br/><br/>
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
			AND m.idaula='$idaula' 
			AND n.periodo=$periodo AND m.periodo='0' 
			AND n.aniolectivo=$aniolect AND m.aniolectivo=n.aniolectivo
			AND m.tipo_matricula='R' AND n.tipo_nota=m.tipo_matricula
			ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";
        	$consultaest = $conx->query($sqlest);
			$numest = $conx->get_numRecords($consultaest);
			//
            while($records1 = $conx->records_array($consultaest)){
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
				
				$puestoperiodo=puestoPeriodoAlg2($records1['idestudiante'], $idaula, $aniolect, $periodo);
				$promedioperiodo=promedioPeriodoAlg2($records1['idestudiante'], $idaula, $aniolect, $periodo);
            	echo "<table class='alumno'>
            	<tr >
            	<td colspan='' class='fonttitle7'   style=''><strong>ESTUDIANTE</strong><BR/>".strtoupper(
                $records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".$records1['apellido2'])."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>CODIGO</strong><BR/>".$records1['idestudiante']."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>CURSO</strong><BR/>".$grado2."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>AÑO LECTIVO</strong><BR/>".$aniolect."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>PUESTO</strong><BR/>$puestoperiodo</td>
				<td colspan='' class='fonttitle7'   style=''><strong>PROMEDIO</strong><BR/>$promedioperiodo</td>
            	</tr>
            	</table>";
				   
                //----------------------------------------------------
                //Generar resultados por Area/asignatura
				$sqlarea = "SELECT DISTINCT a.*
            	FROM area a, clase c, materia m, notas n WHERE a.idarea=m.idarea_fk AND m.idmateria=c.idmateria AND c.idaula=$idaula
				AND n.tipo_nota='R' AND m.idmateria=n.idmateria
				AND n.idmateria!=49
				AND n.idestudiante=".$records1['idestudiante']."
				AND n.periodo=$periodo  AND n.aniolectivo=$aniolect
				AND n.aniolectivo=c.aniolectivo
				ORDER BY a.nomarea ASC";
				$sqlasig = "SELECT DISTINCT mt.nombre_materia, n.* 
				FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
				AND mt.idmateria=n.idmateria AND n.periodo=$periodo  AND n.aniolectivo=$aniolect 
				AND n.tipo_nota='R' ORDER BY mt.nombre_materia ASC";
				$sqldelindest="SELECT competencia FROM indicadoresestudiante i, plan_curricular, notas n WHERE i.idindicador=consecutivo
				and i.aniolectivo=$aniolect 
				and n.idestudiante=i.idestudiante and n.idmateria=i.idmateria and n.periodo=i.periodo and n.aniolectivo=i.aniolectivo
				and i.periodo=$periodo and i.idestudiante='".$records1['idestudiante']."'";
				$sqldelindestobs="SELECT DISTINCT a.nombre_materia, n.* 
				FROM materia a, notas n WHERE n.idestudiante=".$records1['idestudiante']." AND a.idmateria=n.idmateria 
				AND periodo='$periodo' AND n.aniolectivo=$aniolect 
				AND n.tipo_nota='R'
				ORDER BY a.nombre_materia ASC";
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
						$sqlrecordNV = "SELECT DISTINCT mt.nombre_materia, n.* 
						FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
						AND mt.idmateria=n.idmateria AND mt.idarea_fk=".$recordsarea['idarea']." AND n.periodo=$i  AND n.aniolectivo=$aniolect 
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
						strtoupper($recordsarea['nomarea'])."
					</th>
					</tr>";
					$lineasimpresas++;
					$sql = "SELECT DISTINCT mt.nombre_materia, n.* 
					FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
					AND mt.idmateria=n.idmateria AND mt.idarea_fk=".$recordsarea['idarea']." AND n.periodo=$periodo  AND n.aniolectivo=$aniolect 
					AND n.tipo_nota='R' ORDER BY mt.nombre_materia ASC";
					$consulta2 = $conx->query($sql);
					
					while($records2 = $conx->records_array($consulta2)){
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
						$fj=$records2['fj'];
						$fsj=$records2['fsj'];
						$vn=$records2['vn'];
						echo "<tr class='asignatura'>
						<td width='*%' ><strong>ASIGNATURA:</strong> ".strtoupper($records2['nombre_materia'])."
						<br/><strong>DOCENTE:</strong> ".strtoupper($docente)."</td>
						<td width='3%' style='text-align:center; '><strong>I.H</strong><br/> $ih</td>
						<td width='3%' style='text-align:center; '><strong>A.J</strong><br/> $fj</td>
						<td width='3%' style='text-align:center; '><strong>A.S.J</strong><br/> $fsj</td>";
						$promedioAcomulado=0;
						if($periodo<5){
							for($i=1; $i<=$periodo; $i++){
								$sqlrecord = "SELECT DISTINCT mt.nombre_materia, n.* 
								FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
								AND mt.idmateria=n.idmateria AND n.idmateria='".$records2['idmateria']."' AND n.periodo=$i  AND n.aniolectivo=$aniolect 
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
						$lineasimpresas+=2;
						///seleccionando indicadores escogidos por el docenbte en esta area y curso
						$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
						pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
						FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
						(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
						and pc.estandarbc=ebc.codigo
						and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolect
						and eb.periodo =$periodo and eb.iddocente =$iddocente and eb.grado ='$grado'
						and ebc.idmateria_fk=m.idmateria and m.idarea_fk='".$recordsarea['idarea']."'
						ORDER BY consecutivo DESC";
						$consultaind = $conx->query($sqlind);
						$numind=$conx->get_numRecords($consulta);
						$colspan2=$colspan-2;
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
							/*echo "
							<tr><td style='border-top: 1px solid black;' colspan='$colspan2' ><strong>COMPETENCIAS $corte</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>FORTALEZA</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>DEBILIDAD</strong></td></tr>";*/
							echo "<span class='Estilo7c'> CONTINUACIÓN INFORME ACADÉMICO DE ".
							strtoupper($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
							$records1['apellido2'])."  $corte</span><br/><br/>";
						}else{
							/*echo "<tr><td style='border-top: 1px solid black;' colspan='$colspan2' ><strong>COMPETENCIAS $corte</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>FORTALEZA</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>DEBILIDAD</strong></td></tr>";*/
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
									echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";								
									echo "<h1 class='SaltoDePagina'></h1>";
									$pagina++;
									if (($pagina%2)==0){
										echo"<br/><br/><br/><br/><br/>";
									}
									echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
									strtoupper($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
									$records1['apellido2'])."  $corte</span><br/><br/>";
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
						echo "<span style='text-align:right; text-align:right; margin-left:810px; position:relative;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						strtoupper($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
						$records1['apellido2'])."  $corte</span><br/><br/>";
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
						strtoupper($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
						$records1['apellido2'])."  $corte</span><br/><br/>";
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
						<td width='400px' colspan='3'><strong>DINAMIZADOR(A):</strong> ".strtoupper($docente)."</td>";
						echo "</tr>";
						$lineasimpresas+=2;
						///seleccionando indicadores escogidos por el docenbte en esta area y curso
						$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
						pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
						FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
						(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
						and pc.estandarbc=ebc.codigo
						and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolect
						and eb.periodo =$periodo and eb.iddocente =$iddocente and eb.grado ='$grado'
						and ebc.idmateria_fk=m.idmateria and m.idarea_fk='20'
						ORDER BY consecutivo DESC";
						$consultaind = $conx->query($sqlind);
						$numind=$conx->get_numRecords($consulta);
						$colspan2=1;
						if(($lineasimpresas+7)>=($lineasxhoja)){
							echo "</table>";
							echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";														
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
							strtoupper($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
							$records1['apellido2'])."  $corte</span><br/><br/>";
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
									echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";								
									echo "<h1 class='SaltoDePagina'></h1>";
									$pagina++;
									if (($pagina%2)==0){
										echo"<br/><br/><br/><br/><br/>";
									}
									echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
									strtoupper($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
									$records1['apellido2'])."  $corte</span><br/><br/>";
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
						strtoupper($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
						$records1['apellido2'])."  $corte</span><br/><br/>";
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
						 $lineasimpresas+=$lineaspie+$numlineasobs;
						 if(($lineasimpresas+4)>=($lineasxhoja)){
							echo "</table>";
							echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";								
							echo "<h1 class='SaltoDePagina'></h1>";
							$pagina++;
							if (($pagina%2)==0){
								echo"<br/><br/><br/><br/><br/>";
							}
							echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
							strtoupper($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
							$records1['apellido2'])."  $corte</span><br/><br/>";
							echo "<table class='alumno' border='0' cellspacing='5px' >";
							echo "<tr>
							<td  width='30%' align='center' class='Estilo1'>".strtoupper($recordsog['nombre_materia'])."</td>
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
				if(($lineasimpresas+4)>=($lineasxhoja)){
						echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
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
				AND c.iddocente=d.iddocente";
				$consultadg = $conx->query($sqldg);
				$recordsdg = $conx->records_array($consultadg);
				$docentedg = $recordsdg['apellido1']." ".$recordsdg['apellido2']." ".$recordsdg['nombre1']." ".$recordsdg['nombre2'];				
				if($periodo==4){
					echo 
					"<div style='line-height:7px;'>
					<br/><br/><br/><br/>
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
					<br/><br/><br/><br/>
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
				echo "</div><br/><span style='text-align:right; margin-left:810px; position:relative;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
				
				if($numest>1){
					echo "<h1 class='SaltoDePagina'></h1>";
					if (($numapaginas%2)!=0 and $numest!=1 and $numapaginas>1){
						echo "<h1 class='SaltoDePagina'><span style='color:white'>CONTINUACIÓN INFORME ACADÉMICO DE ".
									strtoupper($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
									$records1['apellido2'])." $corte</span></h1>";
					}
				}
				$numest--;
				

				
				//-------------------------------FIN LADO B------------------------------------------------  
			}
			
			
	}elseif($formato=="f5" and $periodo==$num_periodos ){
		if (isset($_GET['id'])) {
			/*$sqlest = "SELECT DISTINCT e.idestudiante, e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula 
						FROM estudiante e
						INNER JOIN matricula m ON e.idestudiante=m.idestudiante
						INNER JOIN notas n ON m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo AND m.tipo_matricula=n.tipo_nota
						WHERE m.aniolectivo=$aniolect AND m.idaula=$idaula AND m.tipo_matricula='R' AND m.periodo=0
						AND n.periodo=$periodo AND e.idestudiante='".$_GET['id']."'
						ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";*/
						
			$sqlest = "SELECT DISTINCT e.idestudiante, e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula 
				FROM estudiante e
				INNER JOIN matricula m ON e.idestudiante=m.idestudiante
				INNER JOIN notas n ON m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo AND m.tipo_matricula=n.tipo_nota
				WHERE m.aniolectivo=$aniolect AND m.idaula=$idaula AND m.tipo_matricula='R' AND m.periodo=0
				AND n.periodo=$periodo AND e.idestudiante='".$_GET['id']."'
				ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";
			
		}
		$consultaest = $conx->query($sqlest);
		while($records1 = $conx->records_array($consultaest)){
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
								<td colspan='2' style='text-align:left'><strong>CERTIFICADO No. $numcert</strong>	
								</td>
							</tr>
							<tr>
								<td colspan='2' style='text-align:center'><strong>LA SUSCRITA RECTORA Y SECRETARIA<br/> CERTIFICAN</strong><br/>
								</td>
							</tr>
							<tr >
								<td colspan='2' style='text-align:justify; background-color:white;'>
								<br/><span >Que, <strong>".strtoupper($records1['apellido1']." ".$records1['apellido2']." ".$records1['nombre1']." ".$records1['nombre2'])."</strong>, identificada con <strong>$numdoc</strong>. Cursó y <span id='aprobacion'>aprobó</span> en esta institución el grado
								<strong>$gradonombre</strong> durante el año lectivo $aniolect, calendario A. Y obtuvo las siguientes calificaciones:</span>							
								</td>
							</tr>
							
					</table>
			</div>";
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
			$materiasperdidas=0;
			$numapaginas=1;
			$lineasimpresas=0;
			/*switch($tipo_periodo){
				case 'T': $corte.=" TRIMESTRE"; break;
				case 'S': $corte.=" SEMESTRE"; break;							
			}*/
			?>
			<br/>
			<?php
			while($recordsarea = $conx->records_array($consulta_area_asignatura)){
			?>
			<table class='area'>
			<?php
				if($recordsarea['idarea']!=$id_area){
					$id_area=$recordsarea['idarea'];
			?>
					<tr>
						<th class='fonttitle7'   style='' colspan=''>
							<?php echo strtoupper(($recordsarea['nomarea'])) ?>
						</th>
					</tr>
			<?php
				}
			?>
				<table class='area'>
					<tr class='asignatura'>
						<td width='*%' ><strong>ASIGNATURA:</strong> <?php echo strtoupper(($recordsarea['nombre_materia']))?>
						<br/><strong>DOCENTE:</strong>  <?php echo strtoupper(($recordsarea['nombre_docente'])); ?></td>
						<td width='3%' style='text-align:center; border-left: 1px solid black;'><strong>I.H</strong><br/>  <?php echo $recordsarea['ih']; ?></td>
						<td width='3%' style='text-align:center; border-left: 1px solid black;'><strong>A.J</strong><br/>  <?php echo$recordsarea['fj']; ?></td>
			<?php
						if($periodo<4){
							$vnSuma=0;
							$sql_notas="SELECT notas.vn, notas.periodo FROM notas WHERE notas.idestudiante='".$records1['idestudiante']."' 
							AND notas.idmateria='".$recordsarea['idmateria']."' AND notas.tipo_nota='R' AND notas.aniolectivo=$aniolect 
							AND notas.periodo<=$periodo ORDER BY notas.periodo";
							
							$consulta_notas = $conx->query($sql_notas);
							$numperiodos=0;
							while($fila_notas = $conx->records_array($consulta_notas)){
								$numperiodos++;
								$corte3=$fila_notas['periodo'].' '.$tipo_periodo;
								/*switch($fila_notas['periodo']){
									case 1: $corte3='1 T'; break;
									case 2:	$corte3='2 T'; break;
									case 3: $corte3='3 T'; break;
								}*/
							?>
								<td width='3%' valign='center' style='text-align:center; border-left: 1px solid black;'><strong><?php echo $corte3;?></strong><br/><?php echo number_format((float)$fila_notas['vn'],1,".",","); ?></td>
								
							<?php
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
									}else{
										$vnSuma+=number_format((float)$fila_notas['vn'],1,".",",");
									}
									
									echo "<td width='3%' valign='center' style='text-align:center;'><strong>$corte2</strong><br/>".number_format((float)$recordsperiodoNV['vn'],1,".",",")."</td>";
								}else{
									$vnSuma+=number_format((float)$fila_notas['vn'],1,".",",");
								}
							}
							$promedioFinal=number_format((float)($vnSuma/$num_periodos),1,".",",");
							$sqlrecordNV = "SELECT notas.vn, notas.periodo FROM notas WHERE notas.idestudiante='".$records1['idestudiante']."' 
							AND notas.idmateria='".$recordsarea['idmateria']."' AND notas.tipo_nota='N' AND notas.aniolectivo=$aniolect 
							AND notas.periodo=7 ORDER BY notas.periodo";
							
							$consultarecordNV = $conx->query($sqlrecordNV);
							if($recordsperiodoNV = $conx->records_array($consultarecordNV)){
								
								$corte2='NV'; 
								if(number_format((float)$recordsperiodoNV['vn'],1,".",",") > number_format((float)$promedioFinal,1,".",",") ){
									$promedioFinal=number_format((float)$recordsperiodoNV['vn'],1,".",",");
								}
								
								echo "<td width='3%' valign='center' style='text-align:center;'><strong>$corte2</strong><br/>".number_format((float)$recordsperiodoNV['vn'],1,".",",")."</td>";
							}
							/*$sqlrecordNV = "SELECT DISTINCT mt.nombre_materia, n.* 
								FROM materia mt
								INNER JOIN notas n ON mt.idmateria=n.idmateria  WHERE n.idestudiante='".$records1['idestudiante']."' 
								AND n.idmateria=".$recordsarea['idmateria']." AND n.periodo=7  AND n.aniolectivo=$aniolect 
								AND n.tipo_nota='N'";*/
							
							/*if($recordsperiodoNV = $conx->records_array($consultarecordNV)){
								?>
								<td width='3%' valign='center' style='text-align:center; border-left: 1px solid black;'><strong>NV</strong><br/><?php echo number_format((float)$recordsperiodoNV['vn'],1,".",","); ?></td>
								<?php
								$promedioFinal=number_format((float)$recordsperiodoNV['vn'],1,".",",");
								$vnSuma=0;
							}else{
								$promedioFinal=number_format((float)($vnSuma/$numperiodos),1,".",",");
								$vnSuma=0;
							}
							*/
							//$promedioFinal=number_format((float)($vnSuma/$num_periodos),1,".",",");
							$vnSuma=0;
							if($promedioFinal >= (float)$rcbamin and $promedioFinal <= (float)$rcbamax){
								$desempenoFinal="Dba"; 
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
							?>
							<td width='6%' nowrap valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>FINAL</strong><br><?php echo number_format((float)$promedioFinal,1,".",","); ?></td>
							<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong><?php echo $desempenoFinal; ?></strong></td>
							<td colspan='2' width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong><?php echo$aprobacion; ?></strong></td>
						<?php
						}
			?>
					</tr>
				</table>
			<?php
			}
			?>
			</table>
			<br/>
			<table class='area'>
			<?php
				$sql="SELECT DISTINCT a.idmateria, ar.idarea, ar.nomarea, a.nombre_materia, concat_ws(' ', d.nombre1, d.nombre2, d.apellido1, d.apellido2) AS nombre_docente, c.ih, n.idestudiante, n.vn, n.periodo, n.fj, n.fsj, n.observaciones, n.aniolectivo FROM clase c 
				JOIN materia a ON c.idmateria=a.idmateria AND c.idmateria=49 AND c.aniolectivo='$aniolect' AND c.idaula='$idaula' AND c.periodos LIKE '%$periodo%'
				JOIN notas n ON a.idmateria=n.idmateria AND n.periodo=$periodo AND n.tipo_nota='R' AND n.aniolectivo=c.aniolectivo AND n.idestudiante='".$records1['idestudiante']."'
				JOIN matricula m ON m.idestudiante=n.idestudiante AND n.tipo_nota=m.tipo_matricula AND n.aniolectivo=m.aniolectivo AND m.idaula=c.idaula
				JOIN area ar ON ar.idarea=a.idarea_fk
				JOIN docente d ON c.iddocente=d.iddocente  
				ORDER BY ar.nomarea, a.nombre_materia  DESC";
				$consulta2 = $conx->query($sql);
				$colspan2=1;
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
				?>
					<br/>
					<table class='area'>
						<tr>
						<th class='fonttitle7'   style='' colspan=''>COMPORTAMIENTO</th>
						<td width='6%' nowrap valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong><?php echo number_format((float)$nota_asignatura,1,".",","); ?></strong></td>
						<td width='6%' valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong><?php echo $desempeno_asignatura; ?></strong></td>
						</tr>
					</table>
					<table class='area'>
						<tr class='asignatura'>
							<td width='*%' colspan='<?php echo ($periodo+4); ?>'><strong>DINAMIZADOR(A):</strong><?php echo strtoupper($dinamizador); ?></td>
						</tr>
					</table>
					<?php
				}
			?>
			</table>
			<?php
			if($materiasperdidas>0 and $materiasperdidas <3){
				$estadoP= "FUE PROMOVIDO(A)";
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
					 case 11: $estadoP="<span style='color:red;'>GRADUADO(A)"; break;
					 default: $estadoP=""; break;
										
				}
				if($grado!=11){ $estadoP.=" SEGÚN LO ESTABLECIDO EN EL S.I.E DE LA INSTITUCIÓN";}
			}elseif($materiasperdidas>2){

				echo "<script type='text/javascript'>$('#aprobacion').text('reprobó');</script>";
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
			?>
			<br/>
			<table class='resultadoasig'>
			<?php 
			if($periodo==$num_periodos){
			?>
				<tr><td style='text-align:left; font:12px 	arial,sans-serif;'>
				<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' ><?php echo $estadoP;?></span></td>
				</tr>
			<?php
			}
			?>
			</table>
			<?php
			//---------------------------CONVENCIONES
				/*echo "
				<br/><div class='firma'>
				<table class='convenciones'>
				<tr>
					<td width='150px' colspan='6' valign='center' style='text-align:center; background:#E5E5E5;'>CONVENCIONES</td>
				</tr>
				<tr>
					<td width='45' valign='top'>DS</td>
					<td width='161' valign='center' class='Estilo7'>Desempeño Superior [".number_format((float)$rcsmin,1,'.',',')." a ".number_format((float)$rcsmax,1,'.',',')."]</td>
					<td width='45' valign='top'>DA</td>
					<td width='161' valign='center' class='Estilo7'>Desempeño Alto [".number_format((float)$rcamin,1,'.',',')." a ".number_format((float)$rcamax,1,'.',',')."]</td>
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
					<td width='45' valign='top'>1 T</td>
					<td width='161' valign='top' class='Estilo7' >Primer Trimestre</td>
					<td width='45' valign='top'>2 T</td>
					<td width='161' valign='top' class='Estilo7'>Segundo Trimestre</td>
					<td width='45' valign='top'>I.H</td>
					<td width='161' valign='top' class='Estilo7' >Intensidad Horaria</td>
				</tr>
				<tr>
					<td width='45' valign='top'>3 T</td>
					<td width='161' valign='top' class='Estilo7' >Tercer Trimestre</td>
					<td width='45' valign='top'>D</td>
					<td width='161' valign='top' class='Estilo7'>Definitiva</td>
					<td width='45' valign='top'>NV</td>
					<td width='161' valign='top' class='Estilo7' >Nivelación año lectivo</td>
				</tr>
				</table></div>"; */
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
				$sqldg = "SELECT DISTINCT d.* 
				FROM clase c, docente d
				WHERE c.idaula = $idaula
				AND c.aniolectivo =  $aniolect
				AND c.idmateria =  49
				AND c.iddocente=d.iddocente";
				$consultadg = $conx->query($sqldg);
				$recordsdg = $conx->records_array($consultadg);
				$docentedg = $recordsdg['apellido1']." ".$recordsdg['apellido2']." ".$recordsdg['nombre1']." ".$recordsdg['nombre2'];
				$sqlrector= "SELECT *  FROM appconfig WHERE item LIKE 'nrector'";
				$consultarector = $conx->query($sqlrector);
				$recordsrector = $conx->records_array($consultarector);
				$rector = $recordsrector['valor'];				
				if($periodo==$num_periodos){
					$fecha=date("m-d-y"); 
					$num = date("d");
					$anno = date("Y");
					$mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
					$mes = $mes[date('n')-1];
					$fechaletra=$num.' de '.$mes.' de '.$anno;
					echo 
					"<div style='line-height:7px;'>
					<br/>
					<table class='firma' border='0'>
							<tr>
								<td width='50%' align='justify' colspan='2' style='font-size:14px'>Para mayor constancia se firma en San Andrés de Tumaco, el $fechaletra<br/><br/><br/><br/><br/><br/></td>
							</tr>
							<tr style='background-color:white; font-size:14px'>
								<td width='50%' align='left'>
									<span class='blocktext' style='text-decoration:overline; font-weight:bold'>$rector</span>
									<br/><span align='left' class='blocktext' >C.C 59.660.938 de Tumaco <br/>Rectora.</span>
				
								</td>
								<td width='50%' align='left'>
									<span class='blocktext' style='text-decoration:overline; font-weight:bold'>SANDRA DEL PILAR GOMEZ ESPAÑA</span>
									<br/><span align='left' class='blocktext' >C.C 59.668.844 de Tumaco <br/>Secretaria.</span>
								</td>
							</tr>
					</table>
					</div>";
			   
			   }else{
					echo 
					"<div style='line-height:7px;'>
					<br/><br/><br/><br/>
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
			   echo "</div><span style='text-align:right; margin-left:810px; position:relative;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
			
		}
		
	}elseif($formato=="f3" and $periodo==4 ){
            if (isset($_GET['id'])) {
				$sqlest = "SELECT DISTINCT e.idestudiante, e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula 
							FROM estudiante e
							INNER JOIN matricula m ON e.idestudiante=m.idestudiante
							INNER JOIN notas n ON m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo AND m.tipo_matricula=n.tipo_nota
							WHERE m.aniolectivo=$aniolect AND m.idaula=$idaula AND m.tipo_matricula='R' AND m.periodo=0
							AND n.periodo=$periodo AND e.idestudiante='".$_GET['id']."'
							ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";
				
			}else{
				$sqlest = "SELECT DISTINCT e.idestudiante, e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula 
							FROM estudiante e
							INNER JOIN matricula m ON e.idestudiante=m.idestudiante
							INNER JOIN notas n ON m.idestudiante=n.idestudiante AND m.aniolectivo=n.aniolectivo AND m.tipo_matricula=n.tipo_nota
							WHERE m.aniolectivo=$aniolect AND m.idaula=$idaula AND m.tipo_matricula='R' AND m.periodo=0
							AND n.periodo=$periodo
							ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";
			}
			
        	$consultaest = $conx->query($sqlest);
			$numest = $conx->get_numRecords($consultaest);
			//
            while($records1 = $conx->records_array($consultaest)){
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
							<td colspan='2' style='text-align:left'><strong>CERTIFICADO No. $numcert</strong>	
							</td>
                        </tr>
						<tr>
							<td colspan='2' style='text-align:center'><strong>EL SUSCRITO RECTOR Y SECRETARIA<br/> CERTIFICAN</strong><br/>
							</td>
                        </tr>
						<tr >
							<td colspan='2' style='text-align:justify; background-color:white;'>
							<br/><span >Que, <strong>".strtoupper($records1['apellido1']." ".$records1['apellido2']." ".$records1['nombre1']." ".$records1['nombre2'])."</strong>, identificada con <strong>$numdoc</strong>. Curso y aprobó en esta institución el grado
							<strong>$gradonombre</strong> durante el año lectivo $aniolect, calendario A. Y obtuvo las siguientes calificaciones:</span>							
							</td>
                        </tr>
                        
                </table>
            	</div>";
				
				$puestoanio=puestoAnioSem($records1['idestudiante'], $idaula, $aniolect);
				$peromedioanio=promedioAnioSem($records1['idestudiante'], $idaula, $aniolect);
				$materiasperdidas=0;
            	/*echo "<table class='alumno'>
            	<tr >
            	<td colspan='' class='fonttitle7'   style=''><strong>ESTUDIANTE</strong><BR/>".strtoupper(
                $records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".$records1['apellido2'])."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>CODIGO</strong><BR/>".$records1['idestudiante']."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>CURSO</strong><BR/>".$grado2."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>AÑO LECTIVO</strong><BR/>".$aniolect."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>PUESTO</strong><BR/>".$puestoanio."</td>
				<td colspan='' class='fonttitle7'   style=''><strong>PROMEDIO</strong><BR/>$peromedioanio</td>
            	</tr>
            	</table>";*/
				   
                //----------------------------------------------------
                //Generar resultados por Area/asignatura
				$sqlarea = "SELECT DISTINCT a.*
				FROM notas n
				INNER JOIN clase c ON c.idmateria=n.idmateria
				INNER JOIN materia m ON m.idmateria=c.idmateria
				INNER JOIN	area a ON a.idarea=m.idarea_fk
				WHERE c.idaula=$idaula  AND n.tipo_nota='R' AND n.idmateria!=49 AND n.idestudiante='".$records1['idestudiante']."' AND n.periodo=$periodo  
				AND n.aniolectivo=$aniolect AND n.aniolectivo=c.aniolectivo
				ORDER BY a.nomarea ASC";
				$sqlasig = "SELECT DISTINCT mt.nombre_materia, n.* 
				FROM materia mt, notas n WHERE n.idestudiante=".$records1['idestudiante']." 
				AND mt.idmateria=n.idmateria AND n.periodo=$periodo  AND n.aniolectivo=$aniolect 
				AND n.tipo_nota='R' ORDER BY mt.nombre_materia ASC";
				$sqldelindest="SELECT competencia FROM indicadoresestudiante i, plan_curricular, notas n WHERE i.idindicador=consecutivo
				and i.aniolectivo=$aniolect 
				and n.idestudiante=i.idestudiante and n.idmateria=i.idmateria and n.periodo=i.periodo and n.aniolectivo=i.aniolectivo
				and i.periodo=$periodo and i.idestudiante='".$records1['idestudiante']."'";
				$sqldelindestobs="SELECT DISTINCT a.nombre_materia, n.* 
				FROM materia a, notas n WHERE n.idestudiante=".$records1['idestudiante']." AND a.idmateria=n.idmateria 
				AND periodo='$periodo' AND n.aniolectivo=$aniolect 
				AND n.tipo_nota='R'
				ORDER BY a.nombre_materia ASC";
				$consultaindestobs = $conx->query($sqldelindestobs);
				$consultaindest = $conx->query($sqldelindest);
				$caracteresxlinea = 98;
				if($papel=='letter'){
					$lineasxhoja=60;
				}elseif($papel=='legal'){
					$lineasxhoja=73;
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
							strtoupper($recordsarea['nomarea'])."
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
						<td width='*%' ><strong>ASIGNATURA:</strong> ".strtoupper($records2['nombre_materia'])."
						<br/><strong>DOCENTE:</strong> ".strtoupper($docente)."</td>
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
						/*$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
						pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
						FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
						(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
						and pc.estandarbc=ebc.codigo
						and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolect
						and eb.periodo =$periodo and eb.iddocente =$iddocente and eb.grado ='$grado'
						and ebc.idmateria_fk=m.idmateria and m.idarea_fk='".$recordsarea['idarea']."'
						ORDER BY consecutivo DESC";
						$consultaind = $conx->query($sqlind);
						$numind=$conx->get_numRecords($consulta);*/
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
							/*echo "
							<tr><td style='border-top: 1px solid black;' colspan='$colspan2' ><strong>COMPETENCIAS $corte</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>FORTALEZA</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>DEBILIDAD</strong></td></tr>";*/
							echo "<span class='Estilo7c'> CONTINUACIÓN INFORME ACADÉMICO DE ".
							strtoupper($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
							$records1['apellido2'])."  $corte</span><br/><br/>";
						}else{
							/*echo "<tr><td style='border-top: 1px solid black;' colspan='$colspan2' ><strong>COMPETENCIAS $corte</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>FORTALEZA</strong></td>
							<td width='6% valign='center' style='text-align:center; border-top: 1px solid black;'><strong>DEBILIDAD</strong></td></tr>";*/
						}
						$lineasimpresas+=1;
						/*while ($rowind = $conx->records_array($consultaind)) {
							$sqldelinselect="SELECT * FROM indicadoresestudiante WHERE idindicador='".$rowind['consecutivo']."'
							and aniolectivo=$aniolect and periodo=$periodo and idestudiante='".$records1['idestudiante']."'";
							$consultaindselect = $conx->query($sqldelinselect);
							
							if($rowindselect = $conx->records_array($consultaindselect)){
								$cadena = $rowind['competencia'];
								$numlineasind=ceil(strlen($cadena)/$caracteresxlinea);
								$lineasimpresas+=$numlineasind;
								if(($lineasimpresas+4)>=$lineasxhoja){
									echo "</table>";
									echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";								
									echo "<h1 class='SaltoDePagina'></h1>";
									$pagina++;
									if (($pagina%2)==0){
										echo"<br/><br/><br/><br/><br/>";
									}
									echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
									strtoupper($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
									$records1['apellido2'])."  $corte</span><br/><br/>";
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
					
						}*/
							
					}
					if(($lineasimpresas+4)>=($lineasxhoja)){
						echo "</table>";
						echo "<span style='text-align:right; text-align:right; margin-left:810px; position:relative;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
						echo "<h1 class='SaltoDePagina'></h1>";
						$pagina++;
						if (($pagina%2)==0){
							echo"<br/><br/><br/><br/><br/>";
						}
						echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
						strtoupper($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
						$records1['apellido2'])."  $corte</span><br/><br/>";
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
						strtoupper($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
						$records1['apellido2'])."  $corte</span><br/><br/>";
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
						<td width='400px' colspan='3'><strong>DINAMIZADOR(A):</strong> ".strtoupper($docente)."</td>";
						echo "</tr>";
						$lineasimpresas+=2;
						///seleccionando indicadores escogidos por el docenbte en esta area y curso
						$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
						pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
						FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
						(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
						and pc.estandarbc=ebc.codigo
						and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolect
						and eb.periodo =$periodo and eb.iddocente =$iddocente and eb.grado ='$grado'
						and ebc.idmateria_fk=m.idmateria and m.idarea_fk='20'
						ORDER BY consecutivo DESC";
						$consultaind = $conx->query($sqlind);
						$numind=$conx->get_numRecords($consulta);
						$colspan2=1;
						if(($lineasimpresas+4)>=($lineasxhoja)){
							echo "</table>";
							echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";														
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
							strtoupper($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
							$records1['apellido2'])."  $corte</span><br/><br/>";
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
									echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";								
									echo "<h1 class='SaltoDePagina'></h1>";
									$pagina++;
									if (($pagina%2)==0){
										echo"<br/><br/><br/><br/><br/>";
									}
									echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
									strtoupper($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
									$records1['apellido2'])."  $corte</span><br/><br/>";
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
						strtoupper($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
						$records1['apellido2'])."  $corte</span><br/><br/>";
						$lineasimpresas=3;
					}else{
						echo "</table>";
					}
						
				}
				
				//observaciones generales
				if(($lineasimpresas+4)>=$lineasxhoja){
					echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";								
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
				/*echo "
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
						 if(($lineasimpresas+4)>=($lineasxhoja)){
							echo "</table>";
							echo "<span style='text-align:right; position:relative; margin-left:810px' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";								
							echo "<h1 class='SaltoDePagina'></h1>";
							$pagina++;
							if (($pagina%2)==0){
								echo"<br/><br/><br/><br/><br/>";
							}
							echo "<span class='Estilo7c'>CONTINUACIÓN INFORME ACADÉMICO DE ".
							strtoupper($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
							$records1['apellido2'])."  $corte</span><br/><br/>";
							echo "<table class='alumno' border='0' cellspacing='5px' >";
							echo "<tr>
							<td  width='30%' align='center' class='Estilo1'>".strtoupper($recordsog['nombre_materia'])."</td>
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
				echo "</table>";*/
				$lineasimpresas+1;
				if(($lineasimpresas+4)>=($lineasxhoja)){
						echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
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
				if($materiasperdidas>2){
						  $estadoP= "<span style='color:red;'>"."DEBE REPETIR EL GRADO, "."</span> Tiene $materiasperdidas área(s) reprobada(s).";
				}elseif($materiasperdidas<3){
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
						if($materiasperdidas !=0){
							$estadoP.=".</span> Tiene $materiasperdidas área(s) reprobada(s)";
						}
				}

echo "<br/><table class='resultadoasig'>";
if($periodo==4){
	echo "<tr><td style='text-align:left; font:12px 	arial,sans-serif;'>
	<span style='font:12px bold 	arial,sans-serif; font-weight:bold;' >$estadoP</span></td></tr>";
}
echo "</table>";
$lineasimpresas+=2;
if(($lineasimpresas+4)>=($lineasxhoja)){
		echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
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
				
				
				if(($lineasimpresas+8)>=($lineasxhoja)){
						echo "<span style='text-align:left; position:relative; margin-left:810px;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
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
				$sqldg = "SELECT DISTINCT d.* 
				FROM clase c, docente d
				WHERE c.idaula = $idaula
				AND c.aniolectivo =  $aniolect
				AND c.idmateria =  49
				AND c.iddocente=d.iddocente";
				$consultadg = $conx->query($sqldg);
				$recordsdg = $conx->records_array($consultadg);
				$docentedg = $recordsdg['apellido1']." ".$recordsdg['apellido2']." ".$recordsdg['nombre1']." ".$recordsdg['nombre2'];
				$sqlrector= "SELECT *  FROM appconfig WHERE item LIKE 'nrector'";
				$consultarector = $conx->query($sqlrector);
				$recordsrector = $conx->records_array($consultarector);
				$rector = $recordsrector['valor'];				
				if($periodo==4){
					$fecha=date("m-d-y"); 
					$num = date("d");
					$anno = date("Y");
					$mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
					$mes = $mes[date('n')-1];
					$fechaletra=$num.' de '.$mes.' de '.$anno;
					echo 
					"<div style='line-height:7px;'>
					<br/>
					<table class='firma' border='0'>
							<tr>
								<td width='50%' align='justify' colspan='2' style='font-size:14px'>Para mayor constancia se firma en San Andrés de Tumaco, el $fechaletra<br/><br/><br/><br/><br/><br/></td>
							</tr>
							<tr style='background-color:white; font-size:14px'>
								<td width='50%' align='left'>
									<span class='blocktext' style='text-decoration:overline; font-weight:bold'>$rector</span>
									<br/><span align='left' class='blocktext' >C.C 59.660.938 de Tumaco <br/>Rectora.</span>
				
								</td>
								<td width='50%' align='left'>
									<span class='blocktext' style='text-decoration:overline; font-weight:bold'>SANDRA DEL PILAR GOMEZ ESPAÑA</span>
									<br/><span align='left' class='blocktext' >C.C 59.668.844 de Tumaco <br/>Secretaria.</span>
								</td>
							</tr>
					</table>
					</div>";
			   
			   }else{
					echo 
					"<div style='line-height:7px;'>
					<br/><br/><br/><br/>
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
				echo "</div><span style='text-align:right; margin-left:810px; position:relative;' class='continuapag'>PAGINA $pagina DE $numapaginas</span>";
				
				if($numest>1){
					echo "<h1 class='SaltoDePagina'></h1>";
					if (($numapaginas%2)!=0 and $numest!=1 and $numapaginas>1){
						echo "<h1 class='SaltoDePagina'><span style='color:white'>CONTINUACIÓN INFORME ACADÉMICO DE ".
							strtoupper($records1['nombre1']." ".$records1['nombre2']." ".$records1['apellido1']." ".
							$records1['apellido2'])." $corte</span></h1>";
					}
				}
				$numest--;
				

				
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