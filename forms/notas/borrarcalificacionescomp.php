<?php
include("../../class/ultimatemysql/mysql.class.php");
include("../../class/MySqlClass.php");
$conx = new ConxMySQL("localhost","root","","appacademy");
$periodo = $_GET['periodo'];
$idmateria = $_GET['idmateria'];
$idaula = $_GET['idaula'];
$iddocente = $_GET['id'];
$aniolectivo = $_GET['aniolectivo'];
$sql = "SELECT descripcion, grupo, grado FROM aula WHERE idaula = '$idaula'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$grado = $records['grado'];
//area
$sqlarea ="SELECT idarea_fk  FROM materia WHERE idmateria = '$idmateria'";
$qarea = $conx->query($sqlarea);
$rowarea = $conx->records_array($qarea);
$area=$rowarea['idarea_fk'];

if($aniolectivo<2016){
	$sql = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
	pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
	FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
	(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
	and pc.estandarbc=ebc.codigo
	and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
	and eb.periodo =$periodo and eb.iddocente =$iddocente and eb.grado ='$grado'
	and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
	ORDER BY consecutivo DESC";
}else{
	$sql= "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
	pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
	FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
	(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
	and pc.estandarbc=ebc.codigo
	and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
	and eb.periodo =$periodo and eb.grado ='$grado'
	and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
	ORDER BY consecutivo DESC";
}
$consulta = $conx->query($sql);
if($conx->get_numRecords($consulta)>0){
	$sqlest = "SELECT e.idestudiante, e.apellido1, e.apellido2, e.nombre1, e.nombre2, m.idaula 
					FROM estudiante e, matricula m  
					WHERE e.idestudiante=m.idestudiante AND e.habilitado='S' 
					AND m.tipo_matricula='R' AND m.aniolectivo='$aniolectivo' AND m.idaula=$idaula AND m.idaula IN 
					(SELECT c.idaula FROM clase c, indicadoresboletin ib, plan_curricular i, aula a WHERE c.iddocente='$iddocente'
					AND c.idmateria=$idmateria AND c.aniolectivo=$aniolectivo
					AND ib.iddocente=c.iddocente
					AND ib.aniolectivo=c.aniolectivo
					AND ib.periodo=$periodo
					AND ib.idmateria=$idmateria
					AND ib.idindicador=i.consecutivo
					AND c.idaula=a.idaula and a.grado='$grado' AND a.grado=ib.grado) 
					ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";

	$consulta2 = $conx->query($sqlest);
	$numreg=0;
	$numind=0;
	$flag=0;
	while ($row = $conx->records_array($consulta2)) {
		
		$id = $row['idestudiante'];
		$sqlduplicate="SELECT DISTINCT e.idestudiante, e.nombre1, e.nombre2, e.apellido1, e.apellido2 FROM estudiante e 
		WHERE e.idestudiante='$id' AND e.idestudiante IN (SELECT n.idestudiante FROM notas n WHERE n.aniolectivo=$aniolectivo 
		AND n.tipo_nota='R' AND n.periodo=$periodo AND n.idmateria=$idmateria) ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
		$consultaduplicate = $conx->query($sqlduplicate);
		if($row = $conx->records_array($consultaduplicate)){
			
			/*$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
				pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
				FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
				(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
				and pc.estandarbc=ebc.codigo
				and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo and eb.idmateria =$idmateria
				and eb.periodo =$periodo and eb.iddocente ='$iddocente' and eb.grado ='$grado'
				and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and m.idmateria=$idmateria
				ORDER BY consecutivo DESC";*/
			if($aniolectivo<2016){
				$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
				pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
				FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
				(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
				and pc.estandarbc=ebc.codigo
				and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
				and eb.periodo =$periodo and eb.iddocente =$iddocente and eb.grado ='$grado'
				and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
				ORDER BY consecutivo DESC";
			}else{
				$sqlind= "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
				pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
				FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
				(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
				and pc.estandarbc=ebc.codigo
				and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
				and eb.periodo =$periodo and eb.grado ='$grado'
				and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
				ORDER BY consecutivo DESC";
			}
			$consultaind = $conx->query($sqlind);
			while ($rowind = $conx->records_array($consultaind)) {
				$consecutivo=$rowind['consecutivo'];
				$sqlduplicatecomp="SELECT DISTINCT * FROM indicadoresestudiante WHERE idindicador = '$consecutivo' 
					AND idestudiante = '$id' AND aniolectivo = '$aniolectivo' AND periodo = '$periodo' and idmateria =$idmateria";
				$consultaduplicatecomp = $conx->query($sqlduplicatecomp);
				if($row = $conx->records_array($consultaduplicatecomp)){
					$sqldelinde="DELETE FROM indicadoresestudiante WHERE idindicador = '$consecutivo' 
					AND idestudiante = '$id' AND aniolectivo = '$aniolectivo' AND periodo = '$periodo' and idmateria =$idmateria";
					$consultadelinde = $conx->query($sqldelinde);
					$numind++;
					$flag=1;
				}
				
			}
			$numreg+=$flag;
			$flag=0;
		}
	}
	if($numreg==0){
		echo "Los(as) estudiantes de este curso no se le ha calificado competencias";
	}else{
		echo "Se borraron competencias de $numreg registros, $numind competencias borradas. No olvide ingresar nuevamente competencias a los estudiantes";
	}
}else{
	echo "No ha selecionado competencias";
}

?>