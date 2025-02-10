<?php
include("../../class/ultimatemysql/mysql.class.php");
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
header ('Content-type: text/html; charset=utf-8');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$estudiantes= explode(",", $_GET['estudiantes'] );
$aula = $_GET['idaula'];
$tipo_matricula	= $_GET['tipomatricula'];
$aniolect = $_GET['aniolect'];
$periodo = $_GET['periodo'];

if($tipo_matricula!='N'){
	$periodo=0;
}

$reg=0;

if(!empty($_GET['estudiantes'])){
	foreach ($estudiantes as $idestudiante){
	
		$values["idestudiante"]  = MySQL::SQLValue($idestudiante);
		$values["tipo_matricula"] = MySQL::SQLValue($tipo_matricula);
		$values["idaula"] = MySQL::SQLValue($aula);
		$values["aniolectivo"] = MySQL::SQLValue($aniolect);
		$values["periodo"] = MySQL::SQLValue($periodo);
		$sqlinsert=MySQL::BuildSQLInsert("matricula", $values);
		$sqlduplicateentry = "SELECT DISTINCT * FROM matricula WHERE idestudiante='$idestudiante' and aniolectivo='$aniolect'
		and tipo_matricula='$tipo_matricula' and periodo='$periodo'";
		$consulta = $conx->query($sqlduplicateentry);
		if($conx->get_numRecords($consulta)>0){
		}else{
			
			if($tipo_matricula=='N'){
				$sqlexistgrado = "SELECT DISTINCT * FROM matricula WHERE idestudiante='$idestudiante' 
				and idaula='$aula' and aniolectivo='$aniolect'";
				$consulta2 = $conx->query($sqlexistgrado);
				if($conx->get_numRecords($consulta2)>0){
					$consulta3 = $conx->query($sqlinsert);
					$reg++;						
				}else{

				}
			}else{
				$consulta3 = $conx->query($sqlinsert);
				$reg++;

			}
			
		}

	}
}
echo "Registros guardados: ".$reg." De ".count($estudiantes);
echo "<span align='center'>
				<a href='buscar_grupo_estudiante.php' class='large button orange' style='font-size: 12px !important;'>Regresar</a>
			</span>";
?>