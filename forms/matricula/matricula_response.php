<?php
	include("../../class/ultimatemysql/mysql.class.php");
	include("../../class/MySqlClass.php");
	include('../../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	$idestudiante = $_POST['idestudiante'];
	$aula = $_POST['aula'];
	$tipo_matricula	= $_POST['tipo_matricula'];
	$aniolect = $_POST['aniolect'];
	$periodo = $_POST['periodo'];

	if($tipo_matricula!='N'){
		$periodo=0;
	}
	$values["idestudiante"]  = MySQL::SQLValue($idestudiante);
	$values["tipo_matricula"] = MySQL::SQLValue($tipo_matricula);
	$values["idaula"] = MySQL::SQLValue($aula);
	$values["aniolectivo"] = MySQL::SQLValue($aniolect);
	$values["periodo"] = MySQL::SQLValue($periodo);
	$sqlinsert=MySQL::BuildSQLInsert("matricula", $values);
	$sqlduplicateentry = "SELECT DISTINCT * FROM matricula WHERE idestudiante='$idestudiante' and aniolectivo='$aniolect'
	and tipo_matricula='$tipo_matricula' and periodo='$periodo'";
	$consulta = $conx->query($sqlduplicateentry);
	if($conx->get_numRecords($consulta)>0){
		echo "<span class='small'><img src='../../images/nook.png' width='30' height='30' />ya esta matriculado</span>";	
	}else{
		if($tipo_matricula=='N'){
			$sqlexistgrado = "SELECT DISTINCT * FROM matricula WHERE idestudiante='$idestudiante' 
			and idaula='$aula' and aniolectivo='$aniolect'";
			$consulta2 = $conx->query($sqlexistgrado);
			if($conx->get_numRecords($consulta2)>0){
				$consulta3 = $conx->query($sqlinsert);
				echo "<span class='small'><img src='../../images/ok.png' width='30' height='30' />
				Registro guardado con exito</span>";
			
			}else{
				
				echo "<p class='small'><img src='../../images/nook.png' width='30' height='30' />
				No se puede efectuar la matricula el estudiante no esta registrado en este grado</p>";	
				echo "<p style='color:red'>[*si el tipo de matricula es 'N' verifique el grado]</p>";

			}

		
		}else{
			$consulta3 = $conx->query($sqlinsert);
			echo "<span class='small'><img src='../../images/ok.png' width='30' height='30' />
			Registro guardado con exito</span>";
		}
		
	}
?>