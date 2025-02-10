<?php
	include("../class/ultimatemysql/mysql.class.php");
	include('../class/MySqlClass.php');
	include('../bdConfig.php');
	$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	$dsmin = $_POST['dsmin'];
	$damin = $_POST['damin'];
	$dbmin = $_POST['dbmin'];
	$dbamin = $_POST['dbamin'];
	$dsmax = $_POST['dsmax'];
	$damax = $_POST['damax'];
	$dbmax = $_POST['dbmax'];
	$dbamax = $_POST['dbamax'];
	$aniolectivo = $_POST['aniolectivo'];
	$alert='<ul>';
	$flag=false;
	if(!$dsmin || !$dsmax || !$damin || !$damax || !$dbmin || !$dbmax || !$dbamin || !$dbamax || !$aniolectivo){
		echo "<span class='small' style='color:red'>Debe completar campos requeridos</span>";
	}else{
		
		if($dsmin>=$dsmax){
			$alert.="<li><span class='small' style='color:red'>DS: El valor mínimo del desempeño superior es mayor o igual al valor máximo</span></li>";
			$flag=true;
		}
		if($damin>=$damax){
			$alert.="<li><span class='small' style='color:red'>DA: El valor mínimo del desempeño alto es mayor o igual al valor máximo</span></li>";
			$flag=true;
		}
		if($dbmin>=$dbmax){
			$alert.="<li><span class='small' style='color:red'>DB: El valor mínimo del desempeño básico es mayor o igual al valor máximo</span></li>";
			$flag=true;
		}
		if($dbamin>=$dbamax){
			$alert.="<li><span class='small' style='color:red'>Db: El valor mínimo del desempeño bajo es mayor o igual al valor máximo</span></li>";
			$flag=true;
		}
		if(!($damax==($dsmin-0.1))){
			$alert.="<li><span class='small' style='color:red'>DA: El valor máximo del desempeño alto debe ser menor  en una décima al valor minimo del desempeño superior</span></li>";
			$flag=true;
		}
		if(!($dbmax==($damin-0.1))){
			$alert.="<li><span class='small' style='color:red'>DB: El valor máximo del desempeño básico debe ser menor  en una décima al valor minimo del desempeño alto</span></li>";
			$flag=true;
		}
		if(!($dbamax==($dbmin-0.1))){
			$alert.="<li><span class='small' style='color:red'>Db: El valor máximo del desempeño bajo debe ser menor  en una décima al valor minimo del desempeño básico</span></li>";
			$flag=true;
		}
		if(!$flag){
			$sql = "UPDATE escala_de_calificacion SET rango_inferior=$dsmin, rango_superior=$dsmax WHERE  tipo_escala='DS' AND aniolectivo=$aniolectivo;";
			$consulta = $conx->query($sql);
			if($consulta!=FALSE){
				$sql = "UPDATE escala_de_calificacion SET rango_inferior=$damin, rango_superior=$damax WHERE  tipo_escala='DA' AND aniolectivo=$aniolectivo;";
				$consulta = $conx->query($sql);
				if($consulta!=FALSE){
					$sql = "UPDATE escala_de_calificacion SET rango_inferior=$dbmin, rango_superior=$dbmax WHERE  tipo_escala='DB' AND aniolectivo=$aniolectivo;";
					$consulta = $conx->query($sql);
					if($consulta!=FALSE){
						$sql = "UPDATE escala_de_calificacion SET rango_inferior=$dbamin, rango_superior=$dbamax WHERE  tipo_escala='D-' AND aniolectivo=$aniolectivo;";
						$consulta = $conx->query($sql);
						if($consulta!=FALSE){
							$alert= "<h4 class='text text-success'><i class='glyphicon glyphicon-ok'></i> Datos actualizados con éxito</h4>";		
						}else{
							$alert.="<li><span class='small' style='color:red'>No se pudo actualizar escala para el año lectivo $aniolectivo</span></li>";
						}
					}else{
						$alert.="<li><span class='small' style='color:red'>No se pudo actualizar escala para el año lectivo $aniolectivo</span></li>";
					}
				}else{
					$alert.="<li><span class='small' style='color:red'>No se pudo actualizar escala para el año lectivo $aniolectivo</span></li>";
				}
			}else{
				$alert.="<li><span class='small' style='color:red'>No se pudo actualizar escala para el año lectivo $aniolectivo</span></li>";
			}
			
		}else{
			$alert.="</ul>";
		}
		echo $alert;
	}
?>