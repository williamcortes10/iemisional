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

$sql = "SELECT * FROM escalacalificacion WHERE aniolect = '$aniolect'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
if($records!=null){

    $sql = "UPDATE escalacalificacion  SET rcsmin='$rcsmin', rcsmax='$rcsmax', rcamin='$rcamin', rcamax='$rcamax',
    rcbmin='$rcbmin', rcbmax='$rcbmax', rcbamin='$rcbamin', rcbamax='$rcbamax' WHERE aniolect= '$aniolect'";
    $consulta = $conx->query($sql);

    
}else{
    
    $sql = "INSERT INTO escalacalificacion (rcsmin, rcsmax, rcamin, rcamax, rcbmin, rcbmax, rcbamin, rcbamax, aniolect) VALUES ('$rcsmin', '$rcsmax',
    '$rcamin', '$rcamax', '$rcbmin', '$rcbmax', '$rcbamin', '$rcbamax', '$aniolect')";
    $consulta = $conx->query($sql);
}

//
$conx->close_conex();
?>