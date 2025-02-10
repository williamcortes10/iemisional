<?php
	include("../../class/ultimatemysql/mysql.class.php");
	include("../../class/MySqlClass.php");
	include('../../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	$iddocente = $_POST['iddocente'];
	$materia = $_POST['idmateria'];
	$aula = $_POST['idaula'];
	$aniolect = $_POST['aniolect'];
	
	$values["idmateria"]  = MySQL::SQLValue($materia);
	$values["idaula"] = MySQL::SQLValue($aula);
	$values["iddocente"] = MySQL::SQLValue($iddocente);
	$values["aniolectivo"] = MySQL::SQLValue($aniolect);
	$sqlinsert=MySQL::BuildSQLInsert("jefearea", $values);
	$sqlduplicateentry = "SELECT DISTINCT * FROM jefearea WHERE iddocente='$iddocente' and idmateria='$materia' and idaula='$aula' and aniolectivo='$aniolect'";
	$consulta = $conx->query($sqlduplicateentry);
	if($conx->get_numRecords($consulta)>0){
		echo "<span class='small' style='color: #C0392B'><i class='glyphicon glyphicon-remove'></i> El registro ya existe</span>";	
	}else{
		$consulta = $conx->query($sqlinsert);
		echo "<span class='small'><i class='glyphicon glyphicon-ok'></i> Registro guardado con éxito</span>";		
	}
?>