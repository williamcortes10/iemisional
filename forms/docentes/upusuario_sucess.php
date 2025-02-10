<?php
	include("../../class/ultimatemysql/mysql.class.php");
	include("../../class/MySqlClass.php");
	include('../../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	$idusuario = $_POST['idusuario'];
	$pass = $_POST['pass'];
	$tipousuario = $_POST['tipousuario'];
	$habilitado = $_POST['habilitado'];
	if(!$idusuario){
		echo "<span class='small' style='color:red'>Debe completar campos requeridos</span>";
	}else{
		
		if($pass!=''){
			$values["idusuario"] = MySQL::SQLValue($idusuario);
			$values["tipousuario"]  = MySQL::SQLValue($tipousuario);
			$values["contrasena"] = MySQL::SQLValue(md5($pass));
			$values["habilitado"] = MySQL::SQLValue($habilitado);
		}else{
			$values["idusuario"] = MySQL::SQLValue($idusuario);
			$values["tipousuario"]  = MySQL::SQLValue($tipousuario);
			$values["habilitado"] = MySQL::SQLValue($habilitado);
		}		
		
		$valueswhere1['idusuario']= MySQL::SQLValue($idusuario);
		$sqlupdate=MySQL::BuildSQLUpdate("usuario", $values, $valueswhere1);
			
		$consulta5 = $conx->query($sqlupdate);
		echo "<span class='small'><i class='glyphicon glyphicon-ok'></i> Registro actualizado con éxito.</span>";
	

	}
?>