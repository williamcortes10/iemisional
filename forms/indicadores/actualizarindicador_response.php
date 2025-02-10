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
	$idindicador = $_POST['idindicador'];
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
		$valueswhere1['idindicador']= MySQL::SQLValue($idindicador);
		$sqlupdate=MySQL::BuildSQLUpdate("indicadores", $values, $valueswhere1);		
		$sqlduplicateentry = "SELECT * FROM  indicadoresboletin WHERE idindicador='$idindicador'";
		$consulta1 = $conx->query($sqlduplicateentry);
		if($conx->get_numRecords($consulta1)>0){
			echo "<span class='small' style='color:red'>
			El indicador ya fue utilizado para reporte de boletin. No esta permitido modificarlo</span>";
		}else{
			$consulta = $conx->query($sqlupdate);
			echo "<span class='small'><img src='../../images/ok.png' width='30' height='30' />Registro actualizado con exito</span>";
		}
	}
?>