<?php
	include("../class/ultimatemysql/mysql.class.php");
	include('../class/MySqlClass.php');
	include('../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	$periodo_hab = $_POST['periodo_hab'];
	$aniolectivo = $_POST['aniolectivo'];
	$numero_periodos = $_POST['numero_periodos'];
	$periodo_nivelaciones = $_POST['periodon'];
	$tipo_periodo = $_POST['tipo_periodo'];
	$activo = $_POST['activo'];
	if(!$periodo_hab || !$aniolectivo || !$periodo_nivelaciones){
		echo "<span class='small' style='color:red'>Debe completar campos requeridos</span>";
	}else{
		
		$sql = "SELECT num_periodos FROM periodos_por_anio WHERE anio = '$aniolectivo'";
		$consulta = $conx->query($sql);  
		if($conx->get_numRecords($consulta)>0){
			$sql = "UPDATE appconfig SET valor='$aniolectivo' WHERE  item='aniolect'";
			$consulta = $conx->query($sql);
			$sql = "UPDATE appconfig SET valor='$periodo_hab' WHERE  item='periodo_hab'";
			$consulta = $conx->query($sql);
			$sql = "UPDATE appconfig SET valor='$periodo_nivelaciones' WHERE  item='periodon'";
			$consulta = $conx->query($sql);
			$sql = "UPDATE periodos_por_anio SET activo=0 WHERE  anio!='$aniolectivo'";
			$consulta = $conx->query($sql);
			$sql = "UPDATE periodos_por_anio SET num_periodos='$numero_periodos', periodo_nivelaciones='$periodo_nivelaciones', activo='$activo', tipo_periodo='$tipo_periodo' WHERE  anio='$aniolectivo'";
			$consulta = $conx->query($sql);
			echo "<h4 class='text text-success'><i class='glyphicon glyphicon-ok'></i> Datos actualizados con exito</h4>";		
		}
		else
		{	

			switch($numero_periodos){
				case 1: 
				case 2:	$tipo_periodo='S'; break;
				case 3: $tipo_periodo='T'; break;
				case 4: $tipo_periodo='P'; break;
				default: $tipo_periodo='S'; break;
				
			}
			$sql = "UPDATE appconfig SET valor='$aniolectivo' WHERE  item='aniolect'";
			$consulta = $conx->query($sql);
			$sql = "UPDATE appconfig SET valor='$periodo_hab' WHERE  item='periodo_hab'";
			$consulta = $conx->query($sql);
			$sql = "UPDATE appconfig SET valor='$periodo_nivelaciones' WHERE  item='periodon'";
			$consulta = $conx->query($sql);
			$sql = "INSERT INTO periodos_por_anio (num_periodos,anio,tipo_periodo) VALUES ($numero_periodos, $aniolectivo,'$tipo_periodo')";
			//die($sql);
			$consulta = $conx->query($sql);
			echo "<h4 class='text text-success'><i class='glyphicon glyphicon-ok'></i> Datos actualizados con exito</h4>";	
			
		}	
			

	}
?>