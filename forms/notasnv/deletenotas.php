<?php
include("../../class/ultimatemysql/mysql.class.php");
include("../../class/MySqlClass.php");
$conx = new ConxMySQL("localhost","root","","appacademy");
//$idestudiante = $_POST['idestudiante'];
//$listdestudiante = $_POST['listdestudiante'];
$periodo = $_GET['periodo'];
$idmateria = $_GET['idmateria'];
$aniolect = $_GET['aniolect'];
$estudiantes= explode(",", $_GET['estudiantes'] );
$reg=0;
$sql='';
if(!empty($_GET['estudiantes'])){
	foreach ($estudiantes as $id){
		$sqlduplicate="SELECT DISTINCT e.idestudiante, e.nombre1, e.nombre2, e.apellido1, e.apellido2 FROM estudiante e 
					WHERE e.idestudiante='$id' AND e.idestudiante IN (SELECT n.idestudiante FROM notas n WHERE n.aniolectivo=$aniolect 
					AND n.tipo_nota='N' AND n.periodo=$periodo AND n.idmateria=$idmateria) ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
		$consultaduplicate = $conx->query($sqlduplicate);
		if($row = $conx->records_array($consultaduplicate)){
			
			$sql= "DELETE FROM notas WHERE CONVERT(idestudiante USING utf8)='$id' AND aniolectivo=$aniolect AND CONVERT(tipo_nota USING utf8)='N' 
			AND periodo=$periodo AND idmateria=$idmateria";
		}
		if($sql!=''){
		$consulta = $conx->query($sql);
		$reg++;
		}
	}
}

echo "Registros Eliminados: ".$reg." De ".count($estudiantes);
echo "<span align='center'>
				<a href='buscar_estudiante.php' class='large button orange' style='font-size: 12px !important;'>Regresar</a>
			</span>";
?>