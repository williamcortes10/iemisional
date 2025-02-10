<?php
	include("../class/ultimatemysql/mysql.class.php");
	include('../class/MySqlClass.php');
	include('../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	$ie = $_POST['ie'];
	$nit = $_POST['nit'];
	$nrector = ($_POST['nrector']);
	$lema = ($_POST['lema']);
	$resol = ($_POST['resol']);
	$direccion = ($_POST['direccion']);
	$telefono = $_POST['telefono'];
	$ciudad = ($_POST['ciudad']);
	$departamento = ($_POST['departamento']);
	if(!$ie || !$nit || !$nrector || !$lema || !$resol || !$direccion || !$ciudad || !$departamento){
		echo "<span class='small' style='color:red'>Debe completar campos requeridos</span>";
	}else{
		
			$sql = "UPDATE appconfig SET valor='$ie' WHERE  item='ie'";
			$consulta = $conx->query($sql);
			$sql = "UPDATE appconfig SET valor='$nit' WHERE  item='nit'";
			$consulta = $conx->query($sql);
			$sql = "UPDATE appconfig SET valor='$nrector' WHERE  item='nrector'";
			$consulta = $conx->query($sql);
			$sql = "UPDATE appconfig SET valor='$lema' WHERE  item='lema'";
			$consulta = $conx->query($sql);
			$sql = "UPDATE appconfig SET valor='$resol' WHERE  item='resol'";
			$consulta = $conx->query($sql);
			$sql = "UPDATE appconfig SET valor='$direccion' WHERE  item='direccion'";
			$consulta = $conx->query($sql);
			$sql = "UPDATE appconfig SET valor='$telefono' WHERE  item='telefono'";
			$consulta = $conx->query($sql);
			$sql = "UPDATE appconfig SET valor='$ciudad' WHERE  item='ciudad'";
			$consulta = $conx->query($sql);
			$sql = "UPDATE appconfig SET valor='$departamento' WHERE  item='departamento'";
			$consulta = $conx->query($sql);
			echo "<h4 class='text text-success'><i class='glyphicon glyphicon-ok'></i> Datos actualizados con exito</h4>";		

	}
?>