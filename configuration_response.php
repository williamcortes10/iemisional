<?php
include('class/MySqlClass.php');
$ie = $_POST['ie1'];
$nrector = $_POST['nrector1'];
$nca = $_POST['nca1'];
$pub = $_POST['pub1'];
$nit = $_POST['nit1'];
$tel = $_POST['tel1'];
$dir = $_POST['dir1'];
$resol = $_POST['resol1'];
$conx = new ConxMySQL("localhost","root","","bdaltono");
if($ie!=""){
    $sql = "UPDATE  configuracion SET valor =  '$ie' WHERE item = 'ie'";
    $consulta = $conx->query($sql);    
    echo "<img align='center' src='images/ico/png-48/icono_ok19.jpg'></img>";	
}

if($nrector!=""){
    $sql = "UPDATE `configuracion` SET `valor` = '$nrector' WHERE item = 'nrector'";
    $consulta = $conx->query($sql);    
}

if($nca!=""){
    $sql = "UPDATE `configuracion` SET `valor` = '$nca' WHERE item = 'nca'";
    $consulta = $conx->query($sql);    
}

if($pub!=""){
    $sql = "UPDATE  configuracion SET valor =  '$pub' WHERE item = 'pub'";
    $consulta = $conx->query($sql);
    
}

if($nit!=""){
    $sql = "UPDATE  configuracion SET valor =  '$nit' WHERE item = 'nit'";
    $consulta = $conx->query($sql);    
}

if($tel!=""){
    $sql = "UPDATE  configuracion SET valor =  '$tel' WHERE item = 'telefono'";
    $consulta = $conx->query($sql);    
}

if($dir!=""){
    $sql = "UPDATE  configuracion SET valor =  '$dir' WHERE item = 'direccion'";
    $consulta = $conx->query($sql);    
}

if($resol!=""){
    $sql = "UPDATE  configuracion SET valor =  '$resol' WHERE item = 'resol'";
    $consulta = $conx->query($sql);
}
//
$conx->close_conex();
?>