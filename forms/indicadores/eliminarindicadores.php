<?php
	include("../../class/ultimatemysql/mysql.class.php");
	include("../../class/MySqlClass.php");
	$conx = new ConxMySQL("localhost","root","","appacademy");
	$iddocente = $_POST['iddocente'];
	$periodo = $_POST['periodo'];
	//$idmateria = $_POST['idmateria'];
	$aniolect = $_POST['aniolect'];
	$numreg=0;

	if(!$_POST['indicadores']){
		echo "<span class='small' style='color:red'>Debe Seleccionar al menos un indicador</span>";
	}else{
		foreach($_POST['indicadores'] as $id){
			$values["idindicador"] = MySQL::SQLValue($id);
			$values["iddocente"]  = MySQL::SQLValue($iddocente);
			$values["aniolectivo"] = MySQL::SQLValue($aniolect);
			$values["periodo"] = MySQL::SQLValue($periodo);
			//verificando si ya existe el indicador en la  tabla indicadoresboletin
			$sqlddelete=MySQL::BuildSQLDelete("indicadoresboletin", $values);
			if($id!=NULL){
				$consulta = $conx->query($sqlddelete);
				$numreg++;
				
			}				
			
		}
		if($numreg>0){
			echo "<span class='small'><img src='../../images/ok.png' width='30' height='30' />Registros Eliminados con exito $numreg</span>";
		}else{
			echo "<span style='color:red;'>Debe Seleccionar al menos un indicador</span>";
		}
	}
?>