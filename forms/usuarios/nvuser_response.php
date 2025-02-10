<?php
	include("../../class/ultimatemysql/mysql.class.php");
	include("../../class/MySqlClass.php");
	$conx = new ConxMySQL("localhost","root","","appacademy");
	$tipo_user = $_POST['tipo_user'];
	$usuario = $_POST['usuario'];
	$password = $_POST['password'];
	if(empty($password)){
		echo "<span class='small' style='color:red'>Debe ingresar contrase&ntilde;a</span>";
	}elseif(strlen($password)<6){
		echo "<span class='small' style='color:red'>La contrase&ntilde;a debe ser mayor a 5 caracteres</span>";
	}else{
		/*$password = md5($password);
		$values["tipousuario"] = MySQL::SQLValue($tipo_user);
		$values["idusuario"]  = MySQL::SQLValue($usuario);
		$values["contrasena"] = MySQL::SQLValue($password);
		$sqlinsert=MySQL::BuildSQLInsert("usuario", $values);*/
		$sqlinsert="INSERT INTO  `appacademy`.`usuario` (
		`tipousuario` ,
		`idusuario` ,
		`contrasena` ,
		`habilitado`
		)
		VALUES (
		'$tipo_user',  '$usuario', MD5(  '$password' ) ,  'S'
		)";
		$sqlduplicateentry = "SELECT * FROM usuario WHERE idusuario='$usuario'";
		$consulta = $conx->query($sqlduplicateentry);
		if($conx->get_numRecords($consulta)>0){
			echo "<span class='small'><img src='../../images/nook.png' width='30' height='30' />El usuario ya tiene una cuenta</span>";	
		}else{
			$consulta = $conx->query($sqlinsert);
			echo "<span class='small'><img src='../../images/ok.png' width='30' height='30' />Cuenta creada con exito</span>";
		}
	}
?>