<?php
	include("../class/ultimatemysql/mysql.class.php");
	include('../class/MySqlClass.php');
	include('../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	if(isset($_POST['index_docen_ful'])){
		$index_docen_ful = $_POST['index_docen_ful'];
	}else{
		$index_docen_ful = "of";
	}
	if(isset($_POST['index_estudiant'])){
		$index_estudiant = $_POST['index_estudiant'];
	}else{
		$index_estudiant = "of";
	}
	if(isset($_POST['index_docen_nt'])){
		$index_docen_nt = $_POST['index_docen_nt'];
	}else{
		$index_docen_nt = "of";
	}
	if(isset($_POST['index_docen_nv'])){
		$index_docen_nv = $_POST['index_docen_nv'];
	}else{
		$index_docen_nv = "of";
	}
	if(isset($_POST['index_docen_ca'])){
		$index_docen_ca = $_POST['index_docen_ca'];
	}else{
		$index_docen_ca = "of";
	}
	if(!$index_docen_nv || !$index_docen_nt || !$index_docen_ful || !$index_docen_ca){
		echo "<span class='small' style='color:red'>Debe completar campos requeridos</span>";
	}else{
		
			$sql = "UPDATE appconfig SET valor='$index_docen_ful' WHERE  item='index_docen_ful'";
			$consulta = $conx->query($sql);
			$sql = "UPDATE appconfig SET valor='$index_estudiant' WHERE  item='index_estudiant'";
			$consulta = $conx->query($sql);
			$sql = "UPDATE appconfig SET valor='$index_docen_nt' WHERE  item='index_docen_nt'";
			$consulta = $conx->query($sql);
			$sql = "UPDATE appconfig SET valor='$index_docen_nv' WHERE  item='index_docen_nv'";
			$consulta = $conx->query($sql);
			$sql = "UPDATE appconfig SET valor='$index_docen_ca' WHERE  item='index_docen_ca'";
			$consulta = $conx->query($sql);
			echo "<h4 class='text text-success'><i class='glyphicon glyphicon-ok'></i> Datos actualizados con exito</h4>";		

	}
?>