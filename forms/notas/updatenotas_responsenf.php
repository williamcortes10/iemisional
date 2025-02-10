<?php
include('../../class/MySqlClass.php');
include("../../class/ultimatemysql/mysql.class.php");
$conx = new ConxMySQL("localhost","root","","appacademy");
$conx2 = new MySQL();
if (! $conx2->Open("appacademy", "localhost", "root", "")) {
		$conx2->Kill();
}
$listdestudiante = $_POST['listdestudiante'];
$aniolect = $_POST['aniolect'];
$docente = $_POST['docente'];
$reg=0;$sqlperiodo = "SELECT * FROM appconfig WHERE item = 'periodo_hab'";
if(!empty($_POST['listdestudiante'])){
	foreach ($listdestudiante as $id){
		
		$obs=false;
		$sqldeleteIndicador= "DELETE FROM indicadoresestudiantenf  
						WHERE aniolectivo=$aniolect AND idestudiante=$id AND
						idindicador IN (SELECT idindicador FROM indicadoresboletinnf
						WHERE iddocente='$docente')";
		$consultaDelete = $conx->query($sqldeleteIndicador);
		if(!empty($_POST['ci'.trim($id)])){
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