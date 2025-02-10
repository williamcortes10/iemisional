<?php
include("../../class/ultimatemysql/mysql.class.php");
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$periodo = $_POST['periodo'];
$idmateria = $_POST['idmateria'];
$iddocente = $_POST['iddocente'];
$aniolectivo = $_POST['aniolectivo'];
$grado = $_POST['grado'];
$id = $_POST['idcomp'];
$da = $_POST['da'];
$ds = $_POST['ds'];
$db = $_POST['db'];
$dba = $_POST['dba'];
$sqlupdate= "UPDATE indicadoresboletin SET DS = '$ds', DA = '$da', DB = '$db', DBA = '$dba'
WHERE idindicador = '$id' AND iddocente = '$iddocente' AND aniolectivo = $aniolectivo AND idmateria=$idmateria 
AND periodo = $periodo AND grado=$grado";
$consulta = $conx->query($sqlupdate);
if ($consulta==FALSE) { 
	echo "error";
}else{
	echo "ok";
}
?>