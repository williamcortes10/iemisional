<?php
	include("../../class/ultimatemysql/mysql.class.php");
	include("../../class/MySqlClass.php");
	$conx = new ConxMySQL("localhost","root","","appacademy");
	$idaula = $_POST['idaula'];
	$iddocente = $_POST['iddocente'];
	$iddocenteback = $_POST['iddocenteback'];
	$aniolectivo = $_POST['aniolectivo'];

	if(!$idaula || !$iddocente || !$aniolectivo){
		echo "<span class='small' style='color:red'>Debe completar campos requeridos</span>";
	}else{
		$values["iddocente"] = MySQL::SQLValue($iddocente);
		//$valueswhere1['idaula']= MySQL::SQLValue($idaula);
		$valueswhere1="idaula=$idaula AND aniolectivo=$aniolectivo";
		$sqlupdate=MySQL::BuildSQLUpdate("coordinadoresgrupo", $values, $valueswhere1);
		
		if($iddocente==$iddocenteback){
			$consulta5 = $conx->query($sqlupdate);
			echo "<span class='small'><img src='../../images/ok.png' width='30' height='30' />Registro actualizado con exito.</span>";
		}else{
			$sqlduplicateentry = "SELECT DISTINCT * FROM coordinadoresgrupo WHERE 
			iddocente=$iddocente AND idaula=$idaula	AND aniolectivo='$aniolectivo'";
			
			$consulta1 = $conx->query($sqlduplicateentry);
			if($conx->get_numRecords($consulta1)>0){
				echo "<span class='small'><img src='../../images/nook.png' width='30' height='30' />No se puede actualizar registro, ya existe.</span>";	
			}else{
				$consulta5 = $conx->query($sqlupdate);
				echo "<span class='small'><img src='../../images/ok.png' width='30' height='30' />Registro actualizado con exito.</span>";
			
			}
		}
		

	}
?>