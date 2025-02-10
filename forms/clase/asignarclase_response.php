<?php
	include("../../class/ultimatemysql/mysql.class.php");
	include("../../class/MySqlClass.php");
	include('../../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	$iddocente = $_POST['iddocente'];
	$materia = $_POST['idmateria'];
	$aula = $_POST['idaula'];
	$ih	= $_POST['ih'];
	$aniolect = $_POST['aniolect'];
	$periodos = $_POST['periodos'];
	$periodos_string = implode(",",$_POST['periodos']);
	
	$values["idmateria"]  = MySQL::SQLValue($materia);
	$values["idaula"] = MySQL::SQLValue($aula);
	$values["iddocente"] = MySQL::SQLValue($iddocente);
	$values["ih"] = MySQL::SQLValue($ih);
	$values["aniolectivo"] = MySQL::SQLValue($aniolect);
	$values["periodos"] = MySQL::SQLValue($periodos_string);
	$sqlinsert=MySQL::BuildSQLInsert("clase", $values);
	$sqlduplicateentry = "SELECT DISTINCT * FROM clase WHERE iddocente='$iddocente' and idmateria='$materia' and idaula='$aula' and aniolectivo='$aniolect'";
	$consulta = $conx->query($sqlduplicateentry);
	if($conx->get_numRecords($consulta)>0){
		echo "<span class='small'><i class='glyphicon glyphicon-remove'></i> El registro ya existe</span>";	
	}else{
		$periodos_exist="";
		foreach($periodos as $clave=>$valor){
			$sqlduplicateentry = "SELECT DISTINCT * FROM clase WHERE idmateria='$materia' and idaula='$aula' and aniolectivo='$aniolect' and periodos LIKE '%$valor%'";
			$consulta = $conx->query($sqlduplicateentry);
			if($conx->get_numRecords($consulta)>0){
				while($data = $conx->records_array_assoc($consulta)){
					$iddocenteOcupa=$data["iddocente"];
				}
				switch($valor){
					case 1: $periodos_exist.="1C Primer Semestre Docente: $iddocenteOcupa "; break;
					case 2: $periodos_exist.="2C Primer Semestre Docente: $iddocenteOcupa "; break;
					case 3: $periodos_exist.="1C Segundo Semestre Docente: $iddocenteOcupa "; break;
					case 4: $periodos_exist.="2C Segundo Semestre Docente: $iddocenteOcupa "; break;
				}
				
			}
		}
		if($periodos_exist!=""){
			echo "<span class='small'><i class='glyphicon glyphicon-remove'></i> Esta asignatura ya tiene docente calificando los cortes: $periodos_exist.</span>";
		}else{
			$consulta = $conx->query($sqlinsert);
			echo "<span class='small'><i class='glyphicon glyphicon-ok'></i> Registro guardado con éxito</span>";
		}
		
	}
?>