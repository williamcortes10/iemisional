<?php
include("../../class/ultimatemysql/mysql.class.php");
include("../../class/MySqlClass.php");
$conx = new ConxMySQL("localhost","root","","appacademy");
$listdestudiante = $_POST['listdestudiante'];
$aniolect = $_POST['aniolect'];
$reg=0;
if(!empty($_POST['listdestudiante'])){
	foreach ($listdestudiante as $id){
		
		$obs=false;
		$sqlduplicate = "SELECT e.idestudiante, e.apellido1, e.apellido2, e.nombre1, e.nombre2 FROM estudiante e
					WHERE e.idestudiante=$id AND e.idestudiante NOT IN(SELECT n.idestudiante FROM indicadoresestudiantenf n WHERE n.aniolectivo=$aniolect 
					AND n.idindicador NOT IN (SELECT ibn.idindicador FROM indicadoresestudiantenf ibn WHERE ibn.idestudiante=n.idestudiante)) 
					ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
		$consultaduplicate = $conx->query($sqlduplicate);
		if($row = $conx->records_array($consultaduplicate) and !empty($_POST['ci'.trim($id)])){
				$comp=$_POST['comp'.trim($id)];
				if(!empty($_POST['idestudiante'])){
					$idestudiante = $_POST['idestudiante'];
					
				}
				$indicadores=$_POST['ci'.trim($id)];
				foreach ($indicadores as $idindicador){
						$sqlind = "INSERT INTO indicadoresestudiantenf (idindicador, idestudiante, comportamiento, aniolectivo) 
						VALUES ('$idindicador', '$id', '$comp', '$aniolect')";
						$consultaind = $conx->query($sqlind);
				}
				
				$reg++;
		}



	}
}
echo "Registros guardados: ".$reg." De ".count($listdestudiante);
echo "<span align='center'>
				<a href='buscar_estudiantenf.php' class='large button orange' style='font-size: 12px !important;'>Regresar</a>
			</span>";
?>