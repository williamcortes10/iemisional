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
		echo "<span class='small' style='color:red'>La contrase&ntilde;a debe ser mayor a 5 caracteres $usuario</span>";
	}else{
		/*$password = md5($password);
		$values["tipousuario"] = MySQL::SQLValue($tipo_user);
		$values["idusuario"]  = MySQL::SQLValue($usuario);
		$values["contrasena"] = MySQL::SQLValue($password);
		$valueswhere['idusuario']= MySQL::SQLValue($usuario);
		$sqlupdate=MySQL::BuildSQLUpdate("usuario", $values, $valueswhere);*/
		$sqlupdate="UPDATE  `appacademy`.`usuario` SET  `contrasena` = MD5(  '$password' ) WHERE  `usuario`.`tipousuario` =  '$tipo_user' AND  `usuario`.`idusuario` =  '$usuario'";
		$sqlduplicateentry = "SELECT * FROM usuario WHERE idusuario='$usuario'";
		$consulta = $conx->query($sqlduplicateentry);
		if($conx->get_numRecords($consulta)>0){
			$consulta2 = $conx->query($sqlupdate);
			echo "<span class='small'><img src='../../images/ok.png' width='30' height='30' />Cuenta actualizada con exito</span>";
		}else{
			echo "<span class='small'><img src='../../images/nook.png' width='30' height='30' />El $usuario  no posee cuenta - <a href='nuevo_usuario.php'>Crear cuenta</a></span>";
			
		}
	}
?>