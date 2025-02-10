<?php
	include("../../class/ultimatemysql/mysql.class.php");
	include("../../class/MySqlClass.php");
	$conx = new ConxMySQL("localhost","root","","appacademy");
	$tpindicador = $_POST['tpindicador'];
	$dindicador = $_POST['dindicador'];
	$idpropietario = $_POST['idpropietario'];
	$idmateria = $_POST['idmateria'];
	$hindicador = $_POST['hindicador'];
	$cindicador = $_POST['cindicador'];
	$idaula = $_POST['idaula'];


	if(!$tpindicador || !$dindicador || !$idpropietario || !$idmateria || !$hindicador || !$cindicador){
		echo "<span class='small' style='color:red'>Debe llenar campos requeridos</span>";
	}else{
		$values["tipo"] = MySQL::SQLValue($tpindicador);
		$values["descripcion"]  = MySQL::SQLValue($dindicador);
		$values["idpropietario"] = MySQL::SQLValue($idpropietario);
		$values["idmateria"] = MySQL::SQLValue($idmateria);
		$values["idaula"] = MySQL::SQLValue($idaula);
		$values["habilitado"] = MySQL::SQLValue($hindicador);
		$values["compartido"] = MySQL::SQLValue($cindicador);			
		$sqlinsert=MySQL::BuildSQLInsert("indicadores", $values);
		$sqlduplicateentry = "SELECT * FROM indicadores WHERE descripcion='$dindicador' AND idmateria='$idmateria' AND idaula='$idaula'";
		$consulta1 = $conx->query($sqlduplicateentry);
		if($conx->get_numRecords($consulta1)>0){
			echo "<span class='small' style='color:red'>Esta intentando guardar un indicador con el mismo contenido</span>";
		}else{
			$consulta = $conx->query($sqlinsert);
			echo "<span class='small'><img src='../../images/ok.png' width='30' height='30' />Registro guardado con exito</span>";
		}
	}
?>