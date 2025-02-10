<?php
include('class/MySqlClass.php');
$id = $_POST['id1'];
$idn = $_POST['idn1'];
$idnr = $_POST['idnr1'];
$conx = new ConxMySQL("localhost","root","","bdaltono");
if($id!=""){
    $sql = "UPDATE  configuracion SET valor =  '$id' WHERE item = 'index_docen_full'";
    $consulta = $conx->query($sql);    
    echo "<img align='center' src='images/ico/png-48/icono_ok19.jpg'></img>";	
}

if($idn!=""){
    $sql = "UPDATE `configuracion` SET `valor` = '$idn' WHERE item = 'index_docen_nv'";
    $consulta = $conx->query($sql);    
}
if($idnr!=""){
    $sql = "UPDATE `configuracion` SET `valor` = '$idnr' WHERE item = 'index_docen_nr'";
    $consulta = $conx->query($sql);    
}
//
$conx->close_conex();
?>