<?php
$usuario='u756951698_notasmisional';
$bd='u756951698_notasmisional';
$pass='Radamel1006';
$dominio='localhost';
if (isset($_SERVER['HTTPS'])) {
    $protocolo="https";
} else {
    $protocolo="http";
}
$host=$_SERVER["HTTP_HOST"];
$base_url=$protocolo."://".$host."/notas";
?>
