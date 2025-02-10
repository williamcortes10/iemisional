<?php
	include("../../class/ultimatemysql/mysql.class.php");
	include("../../class/MySqlClass.php");
	$conx = new ConxMySQL("localhost","root","","appacademy");
	$idmateria = $_POST['idmateria_hidden'];
	$nombre_materia = $_POST['nombre_materia'];
	
	if(!$idmateria || !$nombre_materia){
		echo "<span class='small' style='color:red'>Debe completar campos requeridos</span>";
	}else{
		
		$values["nombre_materia"] = MySQL::SQLValue($nombre_materia);
		$valueswhere1['idmateria']= MySQL::SQLValue($idmateria);
		$sqlupdate=MySQL::BuildSQLUpdate("materia", $values, $valueswhere1);
		$sqlduplicateentry = "SELECT * FROM materia WHERE nombre_materia='$nombre_materia' AND idmateria!='$idmateria'";
		$consulta1 = $conx->query($sqlduplicateentry);
		if($conx->get_numRecords($consulta1)>0){
		
			echo "<span class='small'><i class='glyphicon glyphicon-remove'></i> No se puede actualizar registro, asignatura ya existe.</span>";	
		
		}else{
			
			$consulta5 = $conx->query($sqlupdate);
			echo "<span class='small'><i class='glyphicon glyphicon-ok'></i> Registro actualizado con éxito.</span>";
		}			
	

	}
?>