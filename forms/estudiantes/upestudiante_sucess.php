<?php
	session_start();
	include("../../class/ultimatemysql/mysql.class.php");
	include("../../class/MySqlClass.php");
	include('../../bdConfig.php');
	include('../../bitacora.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	$idestudiante = $_POST['idestudiante'];
	$apellido1 = strtoupper($_POST['apellido1']);
	$apellido2 = strtoupper($_POST['apellido2']);
	$nombre1 = strtoupper($_POST['nombre1']);
	$nombre2 = strtoupper($_POST['nombre2']);
	$fechanac = $_POST['fechanac'];
	$sexo = $_POST['sexo'];
	$direccion = $_POST['direccion'];
	$telefono = $_POST['telefono'];
	$habilitado = $_POST['habilitado'];
	$older_idestudiante = strtoupper($_POST['older_idestudiante']);
	$older_apellido1 = strtoupper($_POST['older_apellido1']);
	$older_apellido2 = strtoupper($_POST['older_apellido2']);
	$older_nombre1 = strtoupper($_POST['older_nombre1']);
	$older_nombre2 = strtoupper($_POST['older_nombre2']);
	
	function insertar_log_acciones(){
		global $conx, $apellido1, $apellido2, $nombre1, $nombre2, $habilitado, $older_idestudiante, 
		$older_apellido1, $older_apellido2, $older_nombre1, $older_nombre2, $idestudiante;
		$nombre_completo = $older_apellido1." ".$older_apellido2." ". $older_nombre1." ".$older_nombre2;
		$descripcion="Se realizaron al estudiante $nombre_completo las sigientes modificaciones: <br/>";
		if($apellido1!=$older_apellido1){
			$descripcion.="- Se cambia el apellido $older_apellido1> por $apellido1 <br/>";
		}
		if($apellido2!=$older_apellido2){
			$descripcion.="- Se cambia el apellido $older_apellido2 por $apellido2 <br/>";
		}
		
		if($nombre1!=$older_nombre1){
			$descripcion.="- Se cambia el nombre $older_nombre1 por $nombre1 <br/>";
		}
		if($nombre2!=$older_nombre2){
			$descripcion.="- Se cambia el nombre $older_nombre2 por $nombre2 <br/>";
		}
		if($idestudiante!=$older_idestudiante){
			$descripcion.="- Se cambia la identificación  $older_idestudiante por $idestudiante <br/>";
		}
		if($habilitado=="S"){
			$descripcion.=" - Se le habilita en el sistema <br/>";
		}else{
			$descripcion.=" - Se le deshabilita en el sistema <br/>";
		}
		log_acciones($_SESSION["k_username"],"Actualizar","Estudiante", $descripcion, $conx);
		
	}
	
	if(!$idestudiante || !$apellido1 || !$nombre1){
		echo "<span class='small' style='color:red'>Debe completar campos requeridos</span>";
	}else{
		
		$values["idestudiante"] = MySQL::SQLValue($idestudiante);
		$values["apellido1"]  = MySQL::SQLValue(utf8_decode($apellido1));
		$values["apellido2"] = MySQL::SQLValue(utf8_decode($apellido2));
		$values["nombre1"] = MySQL::SQLValue(utf8_decode($nombre1));
		$values["nombre2"] = MySQL::SQLValue(utf8_decode($nombre2));
		$values["fechanac"] = MySQL::SQLValue($fechanac);
		$values["sexo"] = MySQL::SQLValue($sexo);
		$values["telefono"] = MySQL::SQLValue($telefono);			
		$values["direccion"] = MySQL::SQLValue($direccion);			
		$values["habilitado"] = MySQL::SQLValue($habilitado);	
		$valueswhere1['idestudiante']= MySQL::SQLValue($older_idestudiante);
		$sqlupdate=MySQL::BuildSQLUpdate("estudiante", $values, $valueswhere1);
		$sqlduplicateentry = "SELECT DISTINCT * FROM estudiante WHERE idestudiante='$idestudiante'";
		$sqlduplicateentry2 = "SELECT DISTINCT * FROM estudiante WHERE apellido1='$apellido1' AND nombre1='$nombre1'";
		if(empty($apellido2)){
			$sqlduplicateentry2.=" AND apellido2 IS NULL";
		}else{
			$sqlduplicateentry2.=" AND apellido2='$apellido2'";
		}
		if(empty($nombre2)){
			$sqlduplicateentry2.=" AND nombre2 IS NULL";
		}else{
			$sqlduplicateentry2.=" AND nombre2='$nombre2'";
		}
		$consulta = $conx->query($sqlduplicateentry);
		$consulta2 = $conx->query($sqlduplicateentry2);
		if($idestudiante!=$older_idestudiante){
			if($conx->get_numRecords($consulta)>0){
				echo "<h4 class='text text-danger'><i class='glyphicon glyphicon-remove'></i> Identificación ya existe</h4>";	
			}else{
				//die($idestudiante. " ".$older_idestudiante);
				if($apellido1!=$older_apellido1 OR $apellido2!=$older_apellido2 OR $nombre1!=$older_nombre1 OR $nombre2!=$older_nombre2){
					if($conx->get_numRecords($consulta2)>0){
						echo "<h4 class='text text-danger'><i class='glyphicon glyphicon-remove'></i> Apellidos y nombres ya existen </h4>";	
					}else{
						$consulta = $conx->query($sqlupdate);
						echo "<h4 class='text text-success'><i class='glyphicon glyphicon-ok'></i> Registro actualizado con éxito</h4>";
						insertar_log_acciones();
					}
				}else{
					$consulta = $conx->query($sqlupdate);
					echo "<h4 class='text text-success'><i class='glyphicon glyphicon-ok'></i> Registro actualizado con éxito</h4>";
					insertar_log_acciones();
				}
			}
		}elseif($apellido1!=$older_apellido1 OR $apellido2!=$older_apellido2 OR $nombre1!=$older_nombre1 OR $nombre2!=$older_nombre2){
			if($conx->get_numRecords($consulta2)>0){
				echo "<h4 class='text text-danger'><i class='glyphicon glyphicon-remove'></i> Apellidos y nombres ya existen </h4>";	
			}else{
				$consulta = $conx->query($sqlupdate);
				echo "<h4 class='text text-success'><i class='glyphicon glyphicon-ok'></i> Registro actualizado con éxito</h4>";
				insertar_log_acciones();
				
				
			}
		}else{
			$consulta = $conx->query($sqlupdate);
			echo "<h4 class='text text-success'><i class='glyphicon glyphicon-ok'></i> Registro actualizado con éxito</h4>";
			insertar_log_acciones();
		}
	

	}
?>