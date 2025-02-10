<?php
	include("../../class/ultimatemysql/mysql.class.php");
	include('../../class/MySqlClass.php');
	include('../../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	$idusuario = $_POST['idusuario'];
	$pass = $_POST['pass'];
	$tipousuario = $_POST['tipousuario'];
	$habilitado = $_POST['habilitado'];

	if(!$pass){
		echo "<span class='small' style='color:red'>Debe completar campos requeridos</span>";
	}else{
		
			$values["idusuario"] = MySQL::SQLValue($idusuario);
			$values["tipousuario"]  = MySQL::SQLValue($tipousuario);
			$values["contrasena"] = MySQL::SQLValue(md5($pass));
			$values["habilitado"] = MySQL::SQLValue($habilitado);
			$sqlinsert=MySQL::BuildSQLInsert("usuario", $values);
			$sqlduplicateentry = "SELECT DISTINCT * FROM usuario WHERE idusuario='$idusuario'";
			$consulta = $conx->query($sqlduplicateentry);
			if($conx->get_numRecords($consulta)>0){
				echo "<h4 class='text text-danger'><i class='glyphicon glyphicon-remove'></i> Usuario ya tiene una cuenta</h4>";	
			}else{
				$consulta = $conx->query($sqlinsert);
				echo "<h4 class='text text-success'><i class='glyphicon glyphicon-ok'></i> Registro guardado con éxito</h4>";
			}
		

	}
?>