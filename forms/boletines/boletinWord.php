<?php
$idaula = $_GET['aula'];
$periodo= $_GET['periodo'];
$aniolect= $_GET['aniolect'];
$formato= $_GET['formato'];
require_once("../../class/phpdocx/classes/createDocx.inc");
$docx = new CreateDocx();
$docx ->importHeadersAndFooters('../../documents/plantillaboletin.docx');
$docx->createDocx('../documents/hello_world_headersAndFooters.docx','footer');
?>
<html>
<head http-equiv="Content-Type" content="text/html; charset=Windows-1252">
<title>-CTMATT-</title>
<link  href="http://fonts.googleapis.com/css?family=Cabin+Sketch:bold" rel="stylesheet" type="text/css" >
<link  href="http://fonts.googleapis.com/css?family=Lobster:regular" rel="stylesheet" type="text/css" >
<link  href="http://fonts.googleapis.com/css?family=Tangerine:regular,bold" rel="stylesheet" type="text/css" >

<link rel="stylesheet" type="text/css" href="../../css/boletin.css" media="all">
</head>
<body>
<div class="cabecera1">
<?php
include("../../class/ultimatemysql/mysql.class.php");
include("../../class/MySqlClass.php");
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
$sql = "SELECT valor FROM appconfig WHERE item = 'pub'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$pub = $records['valor'];
//-----------------------------------------------------
//mysql_set_charset('utf8',$conx->conexion);

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
        
        if($periodo!='4'){
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
                "<div style='line-height:7px;'>
                <table class='normal'>
                        <tr>
                            <td width='150px' align='left' rowspan='2'>
                                <span  class='blocktext'><img  src='../../images/logocol.png' width='80' height='80'/></span>
                            </td>
                            <td >
                                <span class='ie' align='center'>".utf8_decode($ie)."</span><br/>
            	                <span class='pub' align='center'>".utf8_decode($pub)."</span><br/>
                                
                            </td>
                        </tr>
                        <tr>
                            <td colspan='2'>
                            <p class='tituloinforme' align='center'>AÑO LECTIVO $aniolect</p></span>";
                                    if($periodo=='4'){
                                        echo "<span align='center' class='tituloinforme' align='center'><p class='fonttitle6'>INFORME FINAL</p></span><br/>";        
                                    }
                                echo "
                            </td>
                        </tr>
                        
                </table>
            	</div>";
            	echo "<br/><table class='alumno'>
            	<tr >
            	<td colspan='14' class='fonttitle7'   style='width:80%'>ESTUDIANTE:&nbsp;".
                $records1['apellido1']." ".$records1['apellido2']." ".$records1['nombre1']." ".$records1['nombre2']."
                <br/>GRADO:&nbsp;".$grado." th
                </td>
            	</tr>
            	</table>";
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
                
            	while($records2 = $conx->records_array($consulta2)){
                    	$numasig++;
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
                        $docente = $recordsd['apellido1']." ".$recordsd['apellido2']." ".$recordsd['nombre1']." ".$recordsd['nombre2'];
                        $ih = $recordsd['ih'];
                        $iddocente = $recordsd['iddocente'];
                        //descripcion del indicador de desempeño
						$sql3 = "SELECT DISTINCT i.descripcion 
                		FROM indicadores i, indicadoresboletin ib 
						WHERE i.idindicador=ib.idindicador AND i.idmateria=".$records2['idmateria']."
						AND i.idaula='".$idaula."' AND i.tipo='DS' 
                		AND ib.periodo=$periodo AND ib.aniolectivo=$aniolect
						AND ib.iddocente=$iddocente ORDER BY ib.idindicador ASC";
                		$consulta3 = $conx->query($sql3);
                		while($records3 = $conx->records_array($consulta3)){
                		  $desct.=String_oracion($records3['descripcion'])." ";
						}
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
                                <td width='100' style='text-align:center;' class='textcn'>".$records2['nombre_materia']."</td>
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
            
            	echo "<br/>
                <table class='resultadoasig'>
                    <tr>
            		<td scope='col' colspan='6' class='fonttitle7' >COMPORTAMIENTO</td>
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
                
                    //---------------------------CONVENCIONES
                    echo "
                    </table><br/><div class='firma'>
                    <table class='convenciones'>
                    <tr>
                        <td width='150px' colspan='2' valign='center' style='text-align:center; background:#E5E5E5;'>Convenciones</td>
                    </tr>
                    <tr>
                        <td width='45' valign='top'>C.J</td>
                        <td width='161' valign='top' class='Estilo7' >Con Justificación</td>
                    </tr>
                    <tr>
                        <td width='45' valign='top'>S.J</td>
                        <td width='161' valign='top' class='Estilo7' >Sin Justificación</td>
                    </tr>
                    <tr>
                        <td width='45' valign='top'>D</td>
                        <td width='161' valign='top' class='Estilo7' >Definitiva</td>
                    </tr>
                    <tr>
                        <td width='45' valign='top'>I.H</td>
                        <td width='161' valign='top' class='Estilo7' >Intensidad Horaria</td>
                    </tr>
                    <tr>
                        <td width='45' valign='top'>V.N</td>
                        <td width='161' valign='top' class='Estilo7' >Valoración Numérica</td>
                    </tr>
                </table></div>"; 			
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
                    </table>
                	</div>";
        	echo "<h1 class='SaltoDePagina'> </h1>";    
    	//-------------------------------FIN LADO B------------------------------------------------
			}
        }
        $conx->close_conex();
	}
}else{
        echo "No se pueden Generar Boletines por que no existen rango de notas para el año lectivo $aniolect <br/> para configurar presione <a href='../../configuration.php'>aqui</a>";
}
?>
</body>
</html>