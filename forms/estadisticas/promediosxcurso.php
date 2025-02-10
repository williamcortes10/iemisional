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
<head>
<title><?php echo $ie."-PROMEDIOS GRADO $aula-PERIODO $p - $al"; ?></title>
<link  href="http://fonts.googleapis.com/css?family=Cabin+Sketch:bold" rel="stylesheet" type="text/css" >
<link  href="http://fonts.googleapis.com/css?family=Lobster:regular" rel="stylesheet" type="text/css" >
<link  href="http://fonts.googleapis.com/css?family=Tangerine:regular,bold" rel="stylesheet" type="text/css" >

<link rel="stylesheet" type="text/css" href="../../css/boletin.css" media="print, screen">
</head>
<body>
<div>
<?php
include("../../class/phpdocx/classes/createDocx.inc");
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
if($periodo=='F'){
	$periodo=4;
	$periodor='F';
	
}else{
	$periodor='P';
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
		function PromedioEstFinal($id, $idaula, $aniolectivo, $periodo){
			$conxp = new ConxMySQL("localhost","root","","appacademy");
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
							GROUP BY n.idestudiante
							ORDER BY Promedio DESC;
							";
			$consultapuestoarrayEst = $conxp->query($sqlarraypuestoEst);
			$recordspuestoarrayEst = $conxp->records_array($consultapuestoarrayEst);
			return $promEst=$recordspuestoarrayEst['Promedio'];
		}
		function PromedioEstPeriodo($id, $idaula, $aniolectivo, $periodo){
			$conxp = new ConxMySQL("localhost","root","","appacademy");
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
							AND n.periodo = '$periodo'
							GROUP BY n.idestudiante
							ORDER BY Promedio DESC;
							";
			$consultapuestoarrayEst = $conxp->query($sqlarraypuestoEst);
			$recordspuestoarrayEst = $conxp->records_array($consultapuestoarrayEst);
			return $promEst=$recordspuestoarrayEst['Promedio'];
		}
		//----------------------------------------------------------------------------------
//aula
$sqlaaula = "SELECT descripcion, idaula FROM aula WHERE idaula = $idaula";
$consultaaula = $conx->query($sqlaaula);    
$recordsaula = $conx->records_array($consultaaula);
$grado=$recordsaula['descripcion'];
$idaula=$recordsaula['idaula'];
		$look=false;
		if (isset($_SESSION['k_username'])) {
			$conx2 = new ConxMySQL("localhost","root","","appacademy");
			$sql2 = "SELECT idusuario, apellido1, nombre1, tipousuario FROM usuario, docente 
			WHERE idusuario='".$_SESSION['k_username']."' and iddocente=idusuario and (tipousuario='D' OR tipousuario='A' OR tipousuario='S')";
			$consulta2 = $conx2->query($sql2);
			if($conx2->get_numRecords($consulta2)>0){
				$records2 = $conx2->records_array($consulta2);
				$look=true;
				
			}
		}else{
			echo "<div class='form'>
					<div id='stylized' class='myform'><h3 align='center' style='color:black'>Debes Loguearte</h3><br/>";
			echo "<span align='center'><a href='../index.php' align='center'>Regresar</a></span></div></div>";
		}		

	$sqlest = "SELECT DISTINCT e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula, e.idestudiante 
			FROM estudiante e, notas n, matricula m 
        	WHERE e.idestudiante=n.idestudiante AND m.idestudiante=n.idestudiante
			AND m.idaula=$idaula AND e.habilitado='S' 
			AND n.periodo=$periodo AND m.periodo='0' 
			AND n.aniolectivo=$aniolect AND m.aniolectivo=n.aniolectivo
			AND m.tipo_matricula='R' AND n.tipo_nota=m.tipo_matricula
			ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 DESC";
			if($periodor=='F'){
				$reporte=" FINAL AÑO LECTIVO".$aniolect;
			
			}else{
				$reporte=" PERIODO $periodo AÑO LECTIVO ".$aniolect;
			}
			echo "<br/><table class='resultadoasig'><th colspan='3'>PROMEDIOS GRADO $grado <br/> $reporte</th><tr><td><b>ESTUDIANTE</td><td><b>PUESTO</td><td><b>PROMEDIO</td></tr>";
        	$consulta1 = $conx->query($sqlest);
            while($records1 = $conx->records_array($consulta1)){
    
				echo "
                	<tr >
                	<td colspan='' class='fonttitle7'   style='width:80%'>".utf8_decode($records1['nombre1'])." ".utf8_decode($records1['nombre2'])." ".utf8_decode($records1['apellido1'])." ".utf8_decode($records1['apellido2']);
                    echo "</td>";
                	
					//------------------PUESTO PERIODO Y ANUAl
					if($periodor=='F'){
						$puesto= puestoAnioAlg2($records1['idestudiante'], $idaula, $aniolect, 4);
						$PromEst= PromedioEstFinal($records1['idestudiante'], $idaula, $aniolect, 4);
					}else{
						$puesto= puestoPeriodoAlg2($records1['idestudiante'], $idaula, $aniolect, $periodo);
						$PromEst= PromedioEstPeriodo($records1['idestudiante'], $idaula, $aniolect, $periodo);
					}
					//fin consulta promedio estudiante
					echo "
                	<td colspan='' class='fonttitle7'   style='width:80%'>".$puesto;
                    echo "</td>";
					echo "
                	<td colspan='' class='fonttitle7'   style='width:80%'>".$PromEst;
                    echo "</td></tr>";
                    
                    //------------------FIN PUESTO 
			}
			echo "</table>";
                   
		$conx->close_conex();
?>
</body>
</html>