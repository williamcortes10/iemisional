<?php
	include("../../class/ultimatemysql/mysql.class.php");
	include('../../class/MySqlClass.php');
	include('../../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	$idestudiante = $_POST['idestudiante'];
	$apellido1 = strtoupper($_POST['apellido1']);
	$apellido2 = strtoupper($_POST['apellido2']);
	$nombre1 = strtoupper($_POST['nombre1']);
	$nombre2 = strtoupper($_POST['nombre2']);
	$fechanac = $_POST['fechanac'];
	$sexo = $_POST['sexo'];
	$direccion = $_POST['direccion'];
	$telefono = $_POST['telefono'];
	$habilitado = $_POST['habilitado'];



	if(!$idestudiante || !$apellido1 || !$nombre1){
		echo "<span class='small' style='color:red'>Debe completar campos requeridos</span>";
	}else{
		
			$values["idestudiante"] = MySQL::SQLValue($idestudiante);
			$values["apellido1"]  = MySQL::SQLValue(utf8_decode($apellido1));
			$values["apellido2"] = MySQL::SQLValue(utf8_decode($apellido2));
			$values["nombre1"] = MySQL::SQLValue(utf8_decode($nombre1));
			$values["nombre2"] = MySQL::SQLValue(utf8_decode($nombre2));
			$values["fechanac"] = MySQL::SQLValue($fechanac);
			$values["sexo"] = MySQL::SQLValue($sexo);
			$values["telefono"] = MySQL::SQLValue($telefono);			
			$values["direccion"] = MySQL::SQLValue($direccion);			
			$values["habilitado"] = MySQL::SQLValue($habilitado);			
			$sqlinsert=MySQL::BuildSQLInsert("estudiante", $values);
			$sqlduplicateentry = "SELECT DISTINCT * FROM estudiante WHERE idestudiante='$idestudiante'";
			$sqlduplicateentry2 = "SELECT DISTINCT * FROM estudiante WHERE apellido1='$apellido1' AND nombre1='$nombre1'";
			if(empty($apellido2)){
				$sqlduplicateentry2.=" AND apellido2 IS NULL";
			}else{
				$sqlduplicateentry2.=" AND apellido2='$apellido2'";
			}
			if(empty($nombre2)){
				$sqlduplicateentry2.=" AND nombre2 IS NULL";
			}else{
				$sqlduplicateentry2.=" AND nombre2='$nombre2'";
			}
			$consulta = $conx->query($sqlduplicateentry);
			$consulta2 = $conx->query($sqlduplicateentry2);
			if($conx->get_numRecords($consulta)>0){
				echo "<h4 class='text text-danger'><i class='glyphicon glyphicon-remove'></i> Identificación ya existe</h4>";	
			}elseif($conx->get_numRecords($consulta2)>0){
				echo "<h4 class='text text-danger'><i class='glyphicon glyphicon-remove'></i> Apellidos y nombres ya existen</h4>";	
				
			}else{
				$consulta = $conx->query($sqlinsert);
				echo "<h4 class='text text-success'><i class='glyphicon glyphicon-ok'></i> Registro guardado con exito</h4>";
			}
		

	}
?>