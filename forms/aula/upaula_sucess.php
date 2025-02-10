<?php
	include("../../class/ultimatemysql/mysql.class.php");
	include('../../class/MySqlClass.php');
	include('../../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	$idaula = $_POST['idaula'];
	$grado = $_POST['grado'];
	$grupo = $_POST['grupo'];
	$jornada = $_POST['jornada'];
	$older_grado = $_POST['older_grado'];
	$older_grupo = $_POST['older_grupo'];
	$descripcion = $_POST['descripcion'];

	if(!$descripcion){
		echo "<span class='small' style='color:red'>Debe completar campos requeridos</span>";
	}else{
		$values["descripcion"] = MySQL::SQLValue($descripcion);
		$values["grado"] = MySQL::SQLValue($grado);
		$values["jornada"] = MySQL::SQLValue($jornada);
		$valueswhere1['idaula']= MySQL::SQLValue($idaula);
		$sqlupdate=MySQL::BuildSQLUpdate("aula", $values, $valueswhere1);
		$sqlduplicateentry = "SELECT DISTINCT * FROM aula WHERE descripcion='$descripcion' AND (grado=$grado AND grupo=$grupo) AND jornada=$jornada";
		$consulta1 = $conx->query($sqlduplicateentry);
		if($conx->get_numRecords($consulta1)>0){
			echo "<span class='small'><i class='glyphicon glyphicon-remove'></i>No se puede actualizar registro, ya existe grupo y grado diferente con el nombre $descripcion.</span>";	
		}else{
			$consulta5 = $conx->query($sqlupdate);
			echo "<span class='small'><i class='glyphicon glyphicon-ok'></i> Registro actualizado con éxito.</span>";
		
		}

	}
?>