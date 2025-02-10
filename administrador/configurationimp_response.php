<?php
include('../class/MySqlClass.php');
$pages = $_POST['pages1'];
$convencion = $_POST['convencion1'];
$canestudiantesxhoja = $_POST['canestudiantesxhoja'];
$conx = new ConxMySQL("localhost","root","","appacademy");
if($pages!=""){
    $sql = "UPDATE  appconfig SET valor =  '$pages' WHERE item = 'pages'";
	$consulta = $conx->query($sql);
    $sql = "UPDATE  appconfig SET valor =  '$convencion' WHERE item = 'convenciones'";
    $consulta = $conx->query($sql);  
	$sql = "UPDATE  appconfig SET valor =  '$canestudiantesxhoja' WHERE item = 'plannotaspages'";
    $consulta = $conx->query($sql); 	
    echo "<img align='center' src='../images/caritaDA.png'></img>";	
}
//
$conx->close_conex();
?>