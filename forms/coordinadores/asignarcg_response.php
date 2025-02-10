<?php
	include("../../class/ultimatemysql/mysql.class.php");
	include("../../class/MySqlClass.php");
	$conx = new ConxMySQL("localhost","root","","appacademy");
	$idaula = $_POST['idaula'];
	$iddocente = $_POST['iddocente'];
	$aniolect = $_POST['aniolect'];

	if(!$idaula || !$iddocente || !$aniolect){
		echo "<span class='small' style='color:red'>Debe completar campos requeridos</span>";
	}else{
			$values["iddocente"]  = MySQL::SQLValue($iddocente);
			$values["idaula"]  = MySQL::SQLValue($idaula);
			$values["aniolectivo"]  = MySQL::SQLValue($aniolect);
			$sqlinsert=MySQL::BuildSQLInsert("coordinadoresgrupo", $values);
			$sqlduplicateentry = "SELECT DISTINCT * FROM coordinadoresgrupo WHERE idaula=$idaula AND aniolectivo=$aniolect";
			$consulta = $conx->query($sqlduplicateentry);
			if($conx->get_numRecords($consulta)>0){
				echo "<span class='small'><img src='../../images/nook.png' width='30' height='30' />Docente Ya se asigno Direccion de Grupo</span>";	
			}else{
				$sqlduplicateentry = "SELECT DISTINCT * FROM coordinadoresgrupo WHERE idaula=$idaula AND aniolectivo=$aniolect";
				$consulta = $conx->query($sqlduplicateentry);
				if($conx->get_numRecords($consulta)>0){
					echo "<span class='small'><img src='../../images/nook.png' width='30' height='30' />Gadro Escolar Ya se asigno Direccion de Grupo</span>";	
				}else{
					$consulta = $conx->query($sqlinsert);
					echo "<span class='small'><img src='../../images/ok.png' width='30' height='30' />Registro guardado con exito</span>";
				}
			}
		
	}
?>