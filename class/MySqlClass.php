<?php  
class ConxMySQL{
	public $conexion;
	private $results;
	
	function __construct($domain, $user, $pass, $db){
		$enlace = mysqli_connect($domain, $user, $pass, $db);

		if (!$enlace) {
			echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
			echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
			echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
			exit;
		}
		$this->conexion = $enlace;
		//$this->conexion->query("SET NAMES 'utf8'");
	}

	function getConexion(){
		return $this->conexion;
	}
	//funcion para realizar una consulta
	function query($_query){
		$results = $this->conexion->query($_query);
		if(!$results){  
			//echo 'MySQL Error: ' . mysql_error();  
			//exit;  
			return FALSE;
		}  
		return $results;
	}
	//funcion que obtiene los registros
	function records_array($_queryResult){
		return $_queryResult->fetch_array();
		//return mysqli_fetch_array($_queryResult);
	}
	//funcion que obtiene los registros asociativos
	function records_array_assoc($_queryResult){
		return mysqli_fetch_assoc($_queryResult);
		//return mysqli_fetch_array($_queryResult);
	}
	
	function records_array_assoc_all($_queryResult){
		return mysqli_fetch_all($_queryResult, MYSQLI_ASSOC);
		//return mysqli_fetch_array($_queryResult);
	}
	//funcion que obtiene el numero de registro
	function get_numRecords($_queryResult){
		return $_queryResult->num_rows;
	}
	function get_num_rows($_queryResult){
		return mysqli_num_rows($_queryResult);;
	}
	function get_affected_rows(){
		return $this->conexion->affected_rows;
	}
	//liberar memoria
	function result_free($_queryResult){
		return $_queryResult->free();
	}
	
	function close_conex(){
		$this->conexion->close();
	}
	
	
}
?>  