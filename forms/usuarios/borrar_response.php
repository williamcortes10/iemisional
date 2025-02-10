<?php
	include("../../class/ultimatemysql/mysql.class.php");
	include("../../class/MySqlClass.php");
	$conx = new ConxMySQL("localhost","root","","appacademy");
	$usuario = $_POST['usuario'];
	$values["idusuario"] = MySQL::SQLValue($usuario);
	$sqldelete=MySQL::BuildSQLDelete("usuario", $values);
	$sqlduplicateentry = "SELECT * FROM usuario WHERE idusuario='$usuario'";
	$consulta = $conx->query($sqlduplicateentry);
	if($conx->get_numRecords($consulta)>0){
		$consulta = $conx->query($sqldelete);
		echo "<span class='small'><img src='../../images/ok.png' width='30' height='30' />Usuario eliminado con exito";
		if($_SESSION['k_username']==$usuario){
			echo". Usted a eliminado su propia cuenta, para ingresar la proxima vez debe darse de alta</span>";
		}else{
			echo "</span>";
		}
	}else{
		echo "<span class='small'><img src='../../images/nook.png' width='30' height='30' />Usuario no ha sido dado de alta</span>";
		
	}
?>