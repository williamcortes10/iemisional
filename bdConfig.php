<?php
$usuario='u418684922_notasmisional';
$bd='u418684922_notasmisional';
$pass='Radamel1006';
$dominio='localhost';
if (isset($_SERVER['HTTPS'])) {
    $protocolo="https";
} else {
    $protocolo="http";
}
$host=$_SERVER["HTTP_HOST"];
$base_url=$protocolo."://".$host."/iemisional";
?>
