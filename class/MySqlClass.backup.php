<?php  
class ConxMySQL{
	public $conexion;
	private $results;
	function __construct($domain, $user, $pass, $db){
		if(!isset($this->conexion)){  
			$this->conexion = (mysql_connect($domain, $user, $pass)) or die("Could not connect: " . mysql_error());  
			mysql_select_db($db,$this->conexion) or die("Could not found DB" . mysql_error());  
		}  
	}
	//funcion para realizar una consulta
	function query($_query){
		$results = mysql_query($_query, $this->conexion);
		if(!$results){  
			//echo 'MySQL Error: ' . mysql_error();  
			//exit;  
			return FALSE;
		}  
		return $results;
	}
	//funcion que obtiene los registros
	function records_array($_queryResult){
		return mysql_fetch_array($_queryResult);
	}
	
	//funcion que obtiene el numero de registro
	function get_numRecords($_queryResult){
		return mysql_num_rows($_queryResult);
	}
	
	function close_conex(){
		mysql_close($this->conexion);
	}
	
	
}
?>  