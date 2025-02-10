<?php
include("../../class/ultimatemysql/mysql.class.php");
include("../../class/MySqlClass.php");
$conx = new ConxMySQL("localhost","root","","appacademy");
$listdestudiante = $_POST['listdestudiante'];
$periodo = $_POST['periodo'];
$idmateria = $_POST['idmateria'];
$idaula = $_POST['idaula'];
$docente = $_POST['docente'];
$aniolect = $_POST['aniolect'];
$reg=0;
if(!empty($_POST['listdestudiante'])){
	if($aniolect<2015 or $idmateria==27){
		foreach ($listdestudiante as $id){
			$obs=false;
			$sqlduplicate="SELECT DISTINCT e.idestudiante, e.nombre1, e.nombre2, e.apellido1, e.apellido2 FROM estudiante e 
						WHERE e.idestudiante=$id AND e.idestudiante NOT IN (SELECT n.idestudiante FROM notas n WHERE n.aniolectivo=$aniolect 
						AND n.tipo_nota='R' AND n.periodo=$periodo AND n.idmateria=$idmateria) ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
			$consultaduplicate = $conx->query($sqlduplicate);
			if($row = $conx->records_array($consultaduplicate) and !empty($_POST['ci'.trim($id)])){
				if($_POST['vn'.trim($id)]!=""){
					$vn=(float)$_POST['vn'.trim($id)];
					if($_POST['fj'.trim($id)]!=""){
						$fj=$_POST['fj'.trim($id)];
					}else{
						$fj=0;
					}
					if($_POST['fsj'.trim($id)]!=""){
						$fsj=$_POST['fsj'.trim($id)];
					}else{
						$fsj=0;
					}
					$comp=$_POST['comp'.trim($id)];
					if(!empty($_POST['idestudiante'])){
						$idestudiante = $_POST['idestudiante'];
						foreach ($idestudiante as $valor){
							if($valor==$id){
								$obs= true;
								break;
							}
						}
					}
					if(!$obs){
						$obs=$_POST['obs'.trim($id)];
						$sql= "INSERT INTO  notas(idestudiante, periodo, vn, fj, fsj, comportamiento, observaciones, tipo_nota, aniolectivo, idmateria)
						VALUES ('$id',  '$periodo',  '$vn', '$fj' , '$fsj' ,  '$comp', '$obs' ,  'R',  '$aniolect',  '$idmateria')";
					}else{
						$sql= "INSERT INTO  notas(idestudiante, periodo, vn, fj, fsj, comportamiento, observaciones, tipo_nota, aniolectivo, idmateria)
						VALUES ('$id',  '$periodo',  '$vn', '$fj' , '$fsj' ,  '$comp', NULL ,  'R',  '$aniolect',  '$idmateria')";
					}
					$consulta = $conx->query($sql);
					$indicadores=$_POST['ci'.trim($id)];
					foreach ($indicadores as $idindicador){
							$sqlind = "INSERT INTO indicadoresestudiante (idindicador, idestudiante, aniolectivo, periodo) 
							VALUES ('$idindicador', '$id', '$aniolect', '$periodo')";
							$consultaind = $conx->query($sqlind);
					}
					$reg++;
				}
			}

		}
	}else{
		
		foreach ($listdestudiante as $id){
			$obs=false;
			$filtrosave=0;
			$sqlduplicate="SELECT DISTINCT e.idestudiante, e.nombre1, e.nombre2, e.apellido1, e.apellido2 FROM estudiante e 
						WHERE e.idestudiante=$id AND e.idestudiante NOT IN (SELECT n.idestudiante FROM notas n WHERE n.aniolectivo=$aniolect 
						AND n.tipo_nota='R' AND n.periodo=$periodo AND n.idmateria=$idmateria) ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
			$consultaduplicate = $conx->query($sqlduplicate);
			if($row = $conx->records_array($consultaduplicate)){
				if($_POST['vn'.trim($id)]!=""){
					$vn=(float)$_POST['vn'.trim($id)];
					if($_POST['fj'.trim($id)]!=""){
						$fj=$_POST['fj'.trim($id)];
					}else{
						$fj=0;
					}
					if($_POST['fsj'.trim($id)]!=""){
						$fsj=$_POST['fsj'.trim($id)];
					}else{
						$fsj=0;
					}
					$comp=$_POST['comp'.trim($id)];
					if(!empty($_POST['idestudiante'])){
						$idestudiante = $_POST['idestudiante'];
						foreach ($idestudiante as $valor){
							if($valor==$id){
								$obs= true;
								break;
							}
						}
					}
					if(!$obs){
						$obs=$_POST['obs'.trim($id)];
						$sql= "INSERT INTO  notas(idestudiante, periodo, vn, fj, fsj, comportamiento, observaciones, tipo_nota, aniolectivo, idmateria)
						VALUES ('$id',  '$periodo',  '$vn', '$fj' , '$fsj' ,  '$comp', '$obs' ,  'R',  '$aniolect',  '$idmateria')";
						$filtrosave++;
					}else{
						$sql= "INSERT INTO  notas(idestudiante, periodo, vn, fj, fsj, comportamiento, observaciones, tipo_nota, aniolectivo, idmateria)
						VALUES ('$id',  '$periodo',  '$vn', '$fj' , '$fsj' ,  '$comp', NULL ,  'R',  '$aniolect',  '$idmateria')";
						$filtrosave++;
					}
					$consulta = $conx->query($sql);
					$sqlind = "SELECT pc . * FROM plan_curricular pc, indicadoresboletin eb
					WHERE eb.iddocente =$docente
					AND eb.idindicador = pc.consecutivo
					AND pc.estandarbc
					IN ( SELECT codigo FROM estandares WHERE idmateria_fk =$idmateria AND grado =$idaula)
					AND eb.aniolectivo =$aniolect
					AND eb.periodo =$periodo
					ORDER BY eb.idindicador ASC ";
					if($aniolect<2016){
						$sqlind = "SELECT pc . * FROM plan_curricular pc, indicadoresboletin eb
						WHERE eb.iddocente =$docente
						AND eb.idindicador = pc.consecutivo
						AND pc.estandarbc
						IN ( SELECT codigo FROM estandares WHERE idmateria_fk =$idmateria AND grado =$idaula)
						AND eb.aniolectivo =$aniolect
						AND eb.periodo =$periodo
						ORDER BY eb.idindicador ASC ";
					}else{
						$sqlind = "SELECT pc . * FROM plan_curricular pc, indicadoresboletin eb
						WHERE eb.iddocente =$docente
						AND eb.idindicador = pc.consecutivo
						AND pc.estandarbc
						IN ( SELECT codigo FROM estandares WHERE idmateria_fk =$idmateria AND grado =$idaula)
						AND eb.aniolectivo =$aniolect
						AND eb.periodo =$periodo
						ORDER BY eb.idindicador ASC ";
						
						$sqlind= "SELECT DISTINCT pc. * 
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
						if(!empty($_POST['ci'.trim($id).'-'.$consecutivo])){
							$nivel_aprendizaje=$_POST['ci'.trim($id).'-'.$consecutivo];
							$sqlindinsert = "INSERT INTO indicadoresestudiante (idindicador, idestudiante, aniolectivo, periodo,nivel_aprendizaje) 
							VALUES ('$consecutivo', '$id', '$aniolect', '$periodo','$nivel_aprendizaje')";
							$consultaindinsert = $conx->query($sqlindinsert);
							$filtrosave++;
						}
					}							
					
				}
				if($filtrosave>2){
					$reg++;
					
				}
			}



		}
	}
	
}
echo "Registros guardados: ".$reg." De ".count($listdestudiante);
echo "<span align='center'>
				<a href='buscar_estudiante.php' class='large button orange' style='font-size: 12px !important;'>Regresar</a>
			</span>";
?>