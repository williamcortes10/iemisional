<?php
	include("../../class/ultimatemysql/mysql.class.php");
	include("../../class/MySqlClass.php");
	include('../../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	$iddocente = $_POST['iddocente'];
	$idaula = $_POST['aula'];
	$idmateria = $_POST['materia'];
	$aniolectivo = $_POST['aniolect'];
	$ih = $_POST['ih'];
	$periodos = $_POST['periodos'];
	$periodos_string = implode(",",$_POST['periodos']);
	
	$values["ih"] = MySQL::SQLValue($ih);
	$values["periodos"] = MySQL::SQLValue($periodos_string);
	$valueswhere1['iddocente']= MySQL::SQLValue($iddocente);
	$valueswhere1['idmateria']= MySQL::SQLValue($idmateria);
	$valueswhere1['idaula']= MySQL::SQLValue($idaula);
	$valueswhere1['aniolectivo']= MySQL::SQLValue($aniolectivo);
	$sqlupdate=MySQL::BuildSQLUpdate("clase", $values, $valueswhere1);
	//verificar si existe algun otro docente ocupando el periodo a actualizar
	$periodos_exist="";
	foreach($periodos as $clave=>$valor){
		$sqlduplicateentry = "SELECT DISTINCT * FROM clase WHERE iddocente!=$iddocente AND idmateria='$idmateria' and idaula='$idaula' and aniolectivo='$aniolectivo' and periodos LIKE '%$valor%'";
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
		$consulta = $conx->query($sqlupdate);
		echo "<span class='small'><i class='glyphicon glyphicon-ok'></i> Registro actualizado con éxito</span>";
	}
				

?>