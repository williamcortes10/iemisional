<?php
include('../../class/MySqlClass.php');
$conx = new ConxMySQL("localhost","root","","appacademy");
$str_del = $_POST['str_del'];
$sql = "DELETE FROM docente WHERE iddocente='".$str_del."'";
$consulta = $conx->query($sql);
echo "Registro Borrado con exito";
$conx->close_conex();	
?>