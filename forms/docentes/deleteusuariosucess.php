<?php
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$str_del = $_POST['str_del'];
$sql = "DELETE FROM usuario WHERE idusuario='".$str_del."'";
$consulta = $conx->query($sql);
echo "<i class='glyphicon glyphicon-ok'></i> Registro Borrado con exito";
$conx->close_conex();	
?>