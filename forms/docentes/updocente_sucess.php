<?php
	include("../../class/ultimatemysql/mysql.class.php");
	include("../../class/MySqlClass.php");
	$conx = new ConxMySQL("localhost","root","","appacademy");
	$iddocente = $_POST['iddocente'];
	$apellido1 = $_POST['apellido1'];
	$apellido2 = $_POST['apellido2'];
	$nombre1 = $_POST['nombre1'];
	$nombre2 = $_POST['nombre2'];
	$profesion = $_POST['profesion'];
	$email = $_POST['email'];
	$escalafon = $_POST['escalafon'];
	$iddocenteback = $_POST['iddocenteback'];
	if(!$iddocente || !$apellido1 || !$nombre1){
		echo "<span class='small' style='color:red'>Debe completar campos requeridos</span>";
	}else{
		
		$values["iddocente"] = MySQL::SQLValue($iddocente);
		$values["apellido1"]  = MySQL::SQLValue(utf8_decode($apellido1));
		$values["apellido2"] = MySQL::SQLValue(utf8_decode($apellido2));
		$values["nombre1"] = MySQL::SQLValue(utf8_decode($nombre1));
		$values["nombre2"] = MySQL::SQLValue(utf8_decode($nombre2));
		$values["profesion"] = MySQL::SQLValue(utf8_decode($profesion));
		$values["email"] = MySQL::SQLValue($email);
		$values["escalafon"] = MySQL::SQLValue(utf8_decode($escalafon));
		$valueswhere1['iddocente']= MySQL::SQLValue($iddocenteback);
		$sqlupdate=MySQL::BuildSQLUpdate("docente", $values, $valueswhere1);
		$sqlduplicateentry = "SELECT * FROM docente WHERE iddocente='$iddocente'";
		$consulta1 = $conx->query($sqlduplicateentry);
		if($conx->get_numRecords($consulta1)>0 and $iddocenteback!=$iddocente){
		
			echo "<span class='small'><i class='glyphicon glyphicon-remove'></i> No se puede actualizar registro, identificacion no existe.</span>";	
		
		}else{
			$sqlduplicateentry = "SELECT * FROM usuario WHERE idusuario='$iddocenteback'";
			$consulta2 = $conx->query($sqlduplicateentry);
			if($conx->get_numRecords($consulta2)>0 and $iddocenteback!=$iddocente){
				$password = md5($iddocente);
				$values2["idusuario"]  = MySQL::SQLValue($iddocente);
				$values2["contrasena"] = MySQL::SQLValue($password);
				$valueswhere2['idusuario']= MySQL::SQLValue($iddocenteback);
				$sqlupdateuser=MySQL::BuildSQLUpdate("usuario", $values2, $valueswhere2);
				$consulta3 = $conx->query($sqlupdateuser);
				$consulta4 = $conx->query($sqlupdate);
				echo "<span class='small'><i class='glyphicon glyphicon-ok'></i> Registro actualizado con éxito. Tambien se actualizaron los
				datos de usuario y contrasena a su nueva identificacion</span>";
			}else{
				$consulta5 = $conx->query($sqlupdate);
				echo "<span class='small'><i class='glyphicon glyphicon-ok'></i> Registro actualizado con éxito.</span>";
			
			}
		}			
	

	}
?>