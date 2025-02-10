<?php
	include("../../class/ultimatemysql/mysql.class.php");
	include("../../class/MySqlClass.php");
	$conx = new ConxMySQL("localhost","root","","appacademy");
	$idestandar = $_POST['idestandar'];
	$competencia = utf8_decode($_POST['competencia']);
	$estrategia = utf8_decode($_POST['estrategia']);
	$idmateria = $_POST['idmateria'];
	$idaula = $_POST['idaula'];


	if(!$idestandar || !$competencia || !$estrategia || !$idmateria || !$idaula){
		echo "<span class='small' style='color:red'>Debe llenar campos requeridos</span>";
	}else{
		$values["estandarbc"] = MySQL::SQLValue($idestandar);
		$values["competencia"]  = MySQL::SQLValue($competencia);
		$values["estrategia"] = MySQL::SQLValue($estrategia);
		$sqlinsert=MySQL::BuildSQLInsert("plan_curricular", $values);
		$sqlduplicateentry = "SELECT pc.* FROM plan_curricular pc, estandares e WHERE e.idmateria_fk='$idmateria'AND e.grado='$idaula' AND e.codigo=pc.estandarbc AND  pc.competencia='$competencia'";
		$consulta1 = $conx->query($sqlduplicateentry);
		if($conx->get_numRecords($consulta1)>0){
			echo "<span class='small' style='color:red'>Esta intentando guardar una competencia con contenido existente en la base de datos</span>";
		}else{
			$consulta = $conx->query($sqlinsert);
			echo "<span class='small' style='color:blue'><img src='../../images/ok.png' width='30' height='30' />Registro guardado con exito</span>";
		}
	}
?>