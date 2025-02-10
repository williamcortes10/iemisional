<?php
include('../../class/MySqlClass.php');
$conx = new ConxMySQL("localhost","root","","appacademy");
$idindicador = $_POST['idindicador'];
$sql = "DELETE FROM indicadores WHERE idindicador='$idindicador'";
$consulta = $conx->query($sql);
echo "Registro Borrado con exito";
$conx->close_conex();	
?>