<?php
	include("../../class/ultimatemysql/mysql.class.php");
	include('../../class/MySqlClass.php');
	include('../../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	$grado= $_POST['grado'];
	$descripcion = strtoupper($_POST['descripcion']);
	$grupo = $_POST['grupo'];

	if(!$grado || !$descripcion || !$grupo){
		echo "<span class='small' style='color:red'>Debe completar campos requeridos</span>";
	}else{
		
			$values["grado"] = MySQL::SQLValue($grado);
			$values["descripcion"]  = MySQL::SQLValue(utf8_decode($descripcion));
			$values["grupo"] = MySQL::SQLValue(utf8_decode($grupo));
			$sqlinsert=MySQL::BuildSQLInsert("aula", $values);
			$sqlduplicateentry = "SELECT DISTINCT * FROM aula WHERE (grado=$grado AND grupo=$grupo)";
			$consulta = $conx->query($sqlduplicateentry);
			if($conx->get_numRecords($consulta)>0){
				echo "<h4 class='text text-danger'><i class='glyphicon glyphicon-remove'></i>El registro ya existe</h4>";	
			}else{
				$consulta = $conx->query($sqlinsert);
				echo "<h4 class='text text-success'><i class='glyphicon glyphicon-ok'></i> Registro guardado con éxito</h4>";
			}
		

	}
?>
