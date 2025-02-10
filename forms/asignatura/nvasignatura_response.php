<?php
	include("../../class/ultimatemysql/mysql.class.php");
	include('../../class/MySqlClass.php');
	include('../../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	$nombremat = strtoupper($_POST['nombremat']);
	



	if(!$nombremat){
		echo "<span class='small' style='color:red'>Debe completar campos requeridos</span>";
	}else{
			$values["nombre_materia"]  = MySQL::SQLValue($nombremat);
			$sqlinsert=MySQL::BuildSQLInsert("materia", $values);
			$sqlduplicateentry = "SELECT DISTINCT * FROM materia WHERE nombre_materia='$nombremat'";
			$consulta = $conx->query($sqlduplicateentry);
			if($conx->get_numRecords($consulta)>0){
				echo "<h4 class='text text-danger'><i class='glyphicon glyphicon-remove'></i> Asignatura ya existe</h4>";	
			}else{
				$consulta = $conx->query($sqlinsert);
				echo "<h4 class='text text-success'><i class='glyphicon glyphicon-ok'></i> Registro guardado con exito</h4>";
			}
		

	}
?>