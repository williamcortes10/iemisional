<?php
include('class/MySqlClass.php');
$aniolect = $_POST['aniolect'];
$periodolv = $_POST['periodolv'];
$periodonv = $_POST['periodonv'];
$rcsmin = $_POST['rcsmin'];
$rcsmax = $_POST['rcsmax'];
$rcamin = $_POST['rcamin'];
$rcamax = $_POST['rcamax'];
$rcbmin = $_POST['rcbmin'];
$rcbmax = $_POST['rcbmax'];
$rcbamin = $_POST['rcbamin'];
$rcbamax = $_POST['rcbamax'];

$conx = new ConxMySQL("localhost","root","","bdaltono");
if($aniolect!=""){
    $sql = "UPDATE  configuracion SET valor =  '$aniolect' WHERE item = 'aniolect'";
    $consulta = $conx->query($sql);    
    echo "<img align='center' src='images/ico/png-48/icono_ok19.jpg'></img>";	
}

if($periodolv!=""){
    $sql = "UPDATE `configuracion` SET `valor` = '$periodolv' WHERE item = 'periodo_hab'";
    $consulta = $conx->query($sql);    
}

if($periodonv!=""){
    $sql = "UPDATE  configuracion SET valor =  '$periodonv' WHERE item = 'periodon'";
    $consulta = $conx->query($sql);
    
}

if($rcsmin!=""){
    $sql = "UPDATE  configuracion SET valor =  '$rcsmin' WHERE item = 'rcsmin'";
    $consulta = $conx->query($sql);    
}

if($rcsmax!=""){
    $sql = "UPDATE  configuracion SET valor =  '$rcsmax' WHERE item = 'rcsmax'";
    $consulta = $conx->query($sql);    
}

if($rcamin!=""){
    $sql = "UPDATE  configuracion SET valor =  '$rcamin' WHERE item = 'rcamin'";
    $consulta = $conx->query($sql);    
}

if($rcamax!=""){
    $sql = "UPDATE  configuracion SET valor =  '$rcamax' WHERE item = 'rcamax'";
    $consulta = $conx->query($sql);    
}

if($rcbmin!=""){
    $sql = "UPDATE  configuracion SET valor =  '$rcbmin' WHERE item = 'rcbmin'";
    $consulta = $conx->query($sql);    
}

if($rcbmax!=""){
    $sql = "UPDATE  configuracion SET valor =  '$rcbmax' WHERE item = 'rcbmax'";
    $consulta = $conx->query($sql);    
}

if($rcbamin!=""){
    $sql = "UPDATE  configuracion SET valor =  '$rcbamin' WHERE item = 'rcbamin'";
    $consulta = $conx->query($sql);    
}

if($rcbamax!=""){
    $sql = "UPDATE  configuracion SET valor =  '$rcbamax' WHERE item = 'rcbamax'";
    $consulta = $conx->query($sql);    
}
//
$conx->close_conex();
?>