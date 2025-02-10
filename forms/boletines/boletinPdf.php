<?php
/**
 * This sample script generates a sample
 * document out of HTML code with a custom
 * template
 */
session_start();
require_once '../../class/mpdf-7.0.3/vendor/autoload.php';
include('../../class/puesto.php');
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$look=false;
$sql = "SELECT valor FROM appconfig WHERE item='ie'";
$consulta = $conx->query($sql);
$records = $conx->records_array($consulta);
$ie= $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'pages'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$pages = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'convenciones'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$convencion = $records['valor'];
$p=$_POST["periodo"];
$al=$_POST["aniolect"];
$aniolectivo=$al;
$papel=$_POST["papel"];
$idaula = $_POST['aula'];
$periodo= $_POST['periodo'];
$aniolect= $_POST['aniolect'];
$formato= $_POST['formato'];
//aula
$sqlaaula = "SELECT descripcion, idaula, grado, grupo, jornada FROM aula WHERE idaula = $idaula";
$consultaaula = $conx->query($sqlaaula);    
$recordsaula = $conx->records_array($consultaaula);
if($recordsaula['jornada']=="M"){
	$jornada="MAÑANA";
}else{
	$jornada="TARDE";
}
$grado2=utf8_encode($recordsaula['descripcion'])."-".$recordsaula['grupo']."-".$jornada;
$grado=$recordsaula['grado'];
$idaula=$recordsaula['idaula'];
//-----------------------------datos basicos de colegio

$sql = "SELECT valor FROM appconfig WHERE item = 'nrector'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$nrector = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'nca'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$nca = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'Lema'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$lema = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'ciudad'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$ciudad = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'departamento'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$departamento = $records['valor'];

$localizacion=$ciudad." ".$departamento;

//-----------------------------------------------------
//mysql_set_charset('utf8',$conx->conexion);

function String_oracion($string){
 $stringReturn="";
 $arraySplit = explode('.', $string);
 for($i=0; $i<count($arraySplit); $i++){
	
	//$stringReturn[$i]=ucfirst($arraySplit[$i]);
	$arraySplit[$i]=ucfirst(strtolower(trim($arraySplit[$i])));
 }
 $stringReturn = implode(". ", $arraySplit);
 $stringReturn=str_replace("Ó","ó",$stringReturn);
 $stringReturn=str_replace("Í","í",$stringReturn);
 $stringReturn=str_replace("Á","á",$stringReturn);
 $stringReturn=str_replace("É","é",$stringReturn);
 $stringReturn=str_replace("Ú","ú",$stringReturn);
 $stringReturn=str_replace("Ñ","ñ",$stringReturn);
 $stringReturn=str_replace(" dios"," DIOS",$stringReturn);
 $stringReturn=str_replace(" jesús"," JESÚS",$stringReturn);
 return $stringReturn;
}

//escala de notas
$existeescala=0;
$sqlrc = "SELECT * FROM escala_de_calificacion WHERE aniolectivo = $aniolect";
$consultarc = $conx->query($sqlrc);    
while($recordsrc = $conx->records_array($consultarc)){

    switch($recordsrc['tipo_escala']){
		case "DS": 	$rcsmin = $recordsrc['rango_inferior'];
					$rcsmax = $recordsrc['rango_superior'];
					break;
				
		case "DA": 	$rcamin = $recordsrc['rango_inferior'];
					$rcamax = $recordsrc['rango_superior'];
					break;
		
		case "DB": 	$rcbmin = $recordsrc['rango_inferior'];
					$rcbmax = $recordsrc['rango_superior'];
					break;
		case "D-": 	$rcbamin = $recordsrc['rango_inferior'];
					$rcbamax = $recordsrc['rango_superior'];
					break;
		default: break;
	}
    $existeescala=1;
}
$conx->close_conex();
if($existeescala==1){
    if($formato=="f4"){
		$html = '<bookmark content="Start of the Document" /><div>Documento de prueba</div>';
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->WriteHTML($html);
		$mpdf->Output();
	}
}else{
	echo "no existe escala 1290";
}
?>