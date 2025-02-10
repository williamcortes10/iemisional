<?php
	include("../../class/ultimatemysql/mysql.class.php");
	include('../../class/MySqlClass.php');
	include('../../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	$iddocente = $_POST['iddocente'];
	$apellido1 = $_POST['apellido1'];
	$apellido2 = $_POST['apellido2'];
	$nombre1 = $_POST['nombre1'];
	$nombre2 = $_POST['nombre2'];
	$profesion = utf8_decode($_POST['profesion']);
	$email = $_POST['email'];
	$escalafon = $_POST['escalafon'];



	if(!$iddocente || !$apellido1 || !$nombre1){
		echo "<span class='small' style='color:red'>Debe completar campos requeridos</span>";
	}else{
		
			$values["iddocente"] = MySQL::SQLValue($iddocente);
			$values["apellido1"]  = MySQL::SQLValue(utf8_decode($apellido1));
			$values["apellido2"] = MySQL::SQLValue(utf8_decode($apellido2));
			$values["nombre1"] = MySQL::SQLValue(utf8_decode($nombre1));
			$values["nombre2"] = MySQL::SQLValue(utf8_decode($nombre2));
			$values["profesion"] = MySQL::SQLValue(utf8_decode($profesion));
			$values["email"] = MySQL::SQLValue($email);			
			$values["escalafon"] = MySQL::SQLValue($escalafon);			
			$sqlinsert=MySQL::BuildSQLInsert("docente", $values);
			$sqlduplicateentry = "SELECT DISTINCT * FROM docente WHERE iddocente='$iddocente'";
			$sqlduplicateentry2 = "SELECT DISTINCT * FROM docente WHERE apellido1='$apellido1' AND nombre1='$nombre1'";
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