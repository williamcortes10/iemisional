<? 
$filename = "fichero.sql"; 
header("Pragma: no-cache"); 
header("Expires: 0"); 
header("Content-Transfer-Encoding: binary"); 	
header("Content-type: application/force-download"); 
header("Content-Disposition: attachment; filename=$filename"); 


$usuario="????"; 
$passwd="????"; 
$bd="usuarios"; 

$executa = "c:\\mysql\\bin\\mysqldump.exe -u $usuario --password=$passwd --opt $bd"; 
system($executa, $resultado); 

if ($resultado) { echo "<H1>Error ejecutando comando: $executa</H1>\n"; } 

?>