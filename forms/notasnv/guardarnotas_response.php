<?php
include("../../class/ultimatemysql/mysql.class.php");
include("../../class/MySqlClass.php");
$conx = new ConxMySQL("localhost","root","","appacademy");
$idestudiante = $_POST['idestudiante'];
$listdestudiante = $_POST['listdestudiante'];
$periodo = $_POST['periodo'];
$idmateria = $_POST['idmateria'];
$aniolect = $_POST['aniolect'];
$reg=0;
if(!empty($_POST['listdestudiante'])){
	foreach ($listdestudiante as $id){
		$obs=false;
		$sqlduplicate="SELECT DISTINCT e.idestudiante, e.nombre1, e.nombre2, e.apellido1, e.apellido2 FROM estudiante e 
					WHERE e.idestudiante=$id AND e.idestudiante NOT IN (SELECT n.idestudiante FROM notas n WHERE n.aniolectivo=$aniolect 
					AND n.tipo_nota='N' AND n.periodo=$periodo AND n.idmateria=$idmateria) ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
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
					VALUES ('$id',  '$periodo',  '$vn', '$fj' , '$fsj' ,  '$comp', '$obs' ,  'N',  '$aniolect',  '$idmateria')";
				}else{
					$sql= "INSERT INTO  notas(idestudiante, periodo, vn, fj, fsj, comportamiento, observaciones, tipo_nota, aniolectivo, idmateria)
					VALUES ('$id',  '$periodo',  '$vn', '$fj' , '$fsj' ,  '$comp', NULL ,  'N',  '$aniolect',  '$idmateria')";
				}
				$consulta = $conx->query($sql);
				$reg++;
			}
		}



	}
}
echo "Registros guardados: ".$reg." De ".count($listdestudiante);
echo "<span align='center'>
				<a href='buscar_estudiante.php' class='large button orange' style='font-size: 12px !important;'>Regresar</a>
			</span>";
?>