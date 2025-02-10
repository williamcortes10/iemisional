<?php
	include("../../class/ultimatemysql/mysql.class.php");
	include("../../class/MySqlClass.php");
	$conx = new ConxMySQL("localhost","root","","appacademy");
	$iddocente = $_POST['iddocente'];
	//$idmateria = $_POST['idmateria'];
	$aniolect = $_POST['aniolect'];
	$flag=false;
	$numreg=0;

	if(!$_POST['indicadores']){
		echo "<span class='small' style='color:red'>Debe Seleccionar al menos un indicador</span>";
	}else{
		$text= "Los siguientes indicadores no se guardaron por que ya fueron seleccionados: ";
		foreach($_POST['indicadores'] as $id){
			$values["idindicador"] = MySQL::SQLValue($id);
			$values["iddocente"]  = MySQL::SQLValue($iddocente);
			$values["aniolectivo"] = MySQL::SQLValue($aniolect);
			$sqlinsert=MySQL::BuildSQLInsert("indicadoresboletinnf", $values);
			//verificando si ya existe el indicador en la  tabla indicadoresboletin
			$where = MySQL::BuildSQLWhereClause($values);
			$sqlduplicateentry = "SELECT * FROM indicadoresboletinnf $where";
			$consulta1 = $conx->query($sqlduplicateentry);
			if($id!=NULL){
				if($conx->get_numRecords($consulta1)>0){
					$text.="id $id, ";
					$flag=true;
				}else{
					$consulta = $conx->query($sqlinsert);
					$numreg++;
				}
			}				
			
		}
		if($flag){
			echo "<span class='small' style='color:red'>$text</span>"; 
		}
		if($numreg>0){
			echo "<span class='small'><img src='../../images/ok.png' width='30' height='30' />Registros guardados con exito $numreg</span>";
		}
		if(!$flag and $numreg==0){
			echo "<div style='color:red; width:400px'><label >Debe Seleccionar al menos un indicador</label></div>";
		}
	}
?>