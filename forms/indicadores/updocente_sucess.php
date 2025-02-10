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
	$iddocenteback = $_POST['iddocenteback'];
	
	$patronnumeros = "`[0-9]`";
	$patronemail = "#^(((( [a-z\d]  [\.\-\+_] ?)*) [a-z0-9] )+)\@(((( [a-z\d]  [\.\-_] ?){0,62}) [a-z\d] )+)\.( [a-z\d] {2,6})$#i";



	if(!$iddocente || !$apellido1 || !$nombre1){
		echo "<span class='small' style='color:red'>Debe completar campos requeridos</span>";
	}else{
		$flagidd=false; $flagemail=false;
		$text= "<span class='small' style='color:red'>Los siguientes campos no son validos:";
		if(!preg_match($patronnumeros, $iddocente)){
			$flagidd=true;
		}
		if($email!=""){
			if(!preg_match($patronemail, $email) ){
				$flagemail=true;
			}
		}
		if($flagidd and !$flagemail){
			$text.="Identificacion</span>";
			echo $text;
		}elseif(!$flagidd and $flagemail){
		 $text.="Email </span>";
		 echo $text;
		}elseif($flagidd and $flagemail){
			$text.="Identificacion, Email </span>";
			echo $text;
		}else{
			$values["iddocente"] = MySQL::SQLValue($iddocente);
			$values["apellido1"]  = MySQL::SQLValue($apellido1);
			$values["apellido2"] = MySQL::SQLValue($apellido2);
			$values["nombre1"] = MySQL::SQLValue($nombre1);
			$values["nombre2"] = MySQL::SQLValue($nombre2);
			$values["profesion"] = MySQL::SQLValue($profesion);
			$values["email"] = MySQL::SQLValue($email);
			$valueswhere1['iddocente']= MySQL::SQLValue($iddocenteback);
			$sqlupdate=MySQL::BuildSQLUpdate("docente", $values, $valueswhere1);
			$sqlduplicateentry = "SELECT * FROM docente WHERE iddocente='$iddocente'";
			$consulta1 = $conx->query($sqlduplicateentry);
			if($conx->get_numRecords($consulta1)>0){
			
				echo "<span class='small'><img src='../../images/nook.png' width='30' height='30' />No se puede actualizar registro identifcacion ya existe.</span>";	
			
			}else{
				$sqlduplicateentry = "SELECT * FROM usuario WHERE idusuario='$iddocenteback'";
				$consulta2 = $conx->query($sqlduplicateentry);
				if($conx->get_numRecords($consulta2)>0){
					$password = md5($iddocente);
					$values2["idusuario"]  = MySQL::SQLValue($iddocente);
					$values2["contrasena"] = MySQL::SQLValue($password);
					$valueswhere2['idusuario']= MySQL::SQLValue($iddocenteback);
					$sqlupdateuser=MySQL::BuildSQLUpdate("usuario", $values2, $valueswhere2);
					$consulta3 = $conx->query($sqlupdateuser);
					$consulta4 = $conx->query($sqlupdate);
					echo "<span class='small'><img src='../../images/ok.png' width='30' height='30' />Registro actualizado con exito. Tambien se actualizaron los
					datos de usuario y contrasena a su nueva identificacion</span>";
				}else{
					$consulta5 = $conx->query($sqlupdate);
					echo "<span class='small'><img src='../../images/ok.png' width='30' height='30' />Registro actualizado con exito.</span>";
				
				}
			}			
		
		}

	}
?>