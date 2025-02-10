<?php
include('../../class/MySqlClass.php');
$conx = new ConxMySQL("localhost","root","","appacademy");
$idaula = $_POST['aula'];
$aniolectivo = $_POST['aniolect'];

$sql = "DELETE FROM coordinadoresgrupo WHERE idaula='$idaula' AND aniolectivo='$aniolectivo'";
$consulta = $conx->query($sql);
echo "Registro Borrado con exito";
$conx->close_conex();	
?>