<?php
	include("../../class/ultimatemysql/mysql.class.php");
	include("../../class/MySqlClass.php");
	include('../../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	$idestudiante = $_POST['idestudiante'];
	$aula = $_POST['aula'];
	$tipo_matricula	= $_POST['tm'];
	$aniolect = $_POST['aniolect'];
	$periodo = $_POST['periodo'];
	$periodoold = $_POST['periodoold'];
	$aulaold = $_POST['aulaold'];
	$tmold = $_POST['tmold'];
	$aniolectold = $_POST['aniolectold'];
	
	if($tipo_matricula!='N'){
		$periodo=0;
	}
	$values["idestudiante"]  = MySQL::SQLValue($idestudiante);
	$values["tipo_matricula"] = MySQL::SQLValue($tipo_matricula);
	$values["idaula"] = MySQL::SQLValue($aula);
	$values["aniolectivo"] = MySQL::SQLValue($aniolect);
	$values["periodo"] = MySQL::SQLValue($periodo);
	$valueswhere1['idestudiante']= MySQL::SQLValue($idestudiante);
	$valueswhere1['tipo_matricula']= MySQL::SQLValue($tmold);
	$valueswhere1['idaula']= MySQL::SQLValue($aulaold);
	$valueswhere1['aniolectivo']= MySQL::SQLValue($aniolectold);
	$valueswhere1['periodo']= MySQL::SQLValue($periodoold);
	$sqlupdate=MySQL::BuildSQLUpdate("matricula", $values, $valueswhere1);
	$sqlduplicateentry = "SELECT DISTINCT * FROM matricula WHERE idestudiante='$idestudiante' and aniolectivo='$aniolect'
	and tipo_matricula='$tipo_matricula' and periodo='$periodo' and idaula='$aula'";
	$consulta = $conx->query($sqlduplicateentry);
	if($conx->get_numRecords($consulta)>0){
		echo "<span class='small'><img src='../../images/nook.png' width='30' height='30' />ya existe matricula</span>";	
	}else{
		$sqlnotasexist = "SELECT DISTINCT * FROM notas WHERE idestudiante='$idestudiante' and aniolectivo='$aniolectold'
		and tipo_nota='N' and periodo='$periodoold'";
		$consultanexist = $conx->query($sqlnotasexist);
		if(($tmold=='R' && $tipo_matricula=='N') || ($tmold=='N' && $tipo_matricula=='R')){
			echo "<p class='small'><img src='../../images/nook.png' width='30' height='30' />
				<p style='color:red'>No se puede efectuar la actualización de matricula, los tipos de matriculas no coiciden</p>";	
		}elseif($conx->get_numRecords($consultanexist)>0){
			echo "<p class='small'><img src='../../images/nook.png' width='30' height='30' />
			<p style='color:red'>No se puede efectuar la actualización de matricula, ya existen notas registradas</p>";
		}else{	
			if($tipo_matricula=='N'){
				$sqlexistgrado = "SELECT DISTINCT * FROM matricula WHERE idestudiante='$idestudiante' 
				and idaula='$aula' and tipo_matricula='R' and aniolectivo='$aniolect'";
				$consulta2 = $conx->query($sqlexistgrado);
				if($conx->get_numRecords($consulta2)>0){
					$consulta3 = $conx->query($sqlupdate);
					echo "<span class='small'><img src='../../images/ok.png' width='30' height='30' />
					Registro actualizado con exito</span>";	
				}else{
					echo "<p class='small'><img src='../../images/nook.png' width='30' height='30' />
					No se puede efectuar la actualización de matricula el estudiante no esta registrado en este grado</p>";	
					echo "<p style='color:red'>[*si el tipo de matricula es 'N' verifique el grado]</p>";
				}
			}else{
				$sqlnotasexist = "SELECT DISTINCT * FROM notas WHERE idestudiante='$idestudiante' and aniolectivo='$aniolectold' 
				and aniolectivo!='$aniolect' and tipo_nota='R'";
				$consultanexist = $conx->query($sqlnotasexist);
				if($conx->get_numRecords($consultanexist)>0){
					echo "<p class='small'><img src='../../images/nook.png' width='30' height='30' />
					<p style='color:red'>No se puede efectuar la actualización de matricula, ya existen notas registradas</p>";
				}else{
					
					$consulta3 = $conx->query($sqlupdate);
					echo "<span class='small'><img src='../../images/ok.png' width='30' height='30' />
					Registro actualizado con exito</span>";	
				}
				
			}
			
		}

		
	}
?>