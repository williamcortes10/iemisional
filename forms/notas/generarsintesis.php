<?php
session_start();
include('../../class/MySqlClass.php');
include('../../bdConfig.php');
	
include("../../class/puesto.php");
$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
$sqlcurso= "SELECT CONCAT_WS('-', descripcion, grupo, jornada) AS curso FROM aula WHERE idaula = ".$_GET['idaula'];
$consulta = $conx->query($sqlcurso);
$records = $conx->records_array($consulta);
$curso= ($records['curso']);
?>
<html>
    <head>
        <title>SISTEMA ACADEMICO DE CALIFICACIONES - SINTESIS CALIFICACIONES - <?php echo $curso; ?></title>
        <meta http-equiv="Content-Type" content="text/html;" />
        <meta name="description" content="" />
        <meta name="keywords" content=""/>
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
		<!-- CSS de Bootstrap -->
		<link href="../../css/boletin.css" rel="stylesheet" media="print, screen">
		<link href="../../css/loader.css" rel="stylesheet" media="print, screen">
		<!-- Custom styles for this template -->
		<script type="text/javascript" src="../../script/jquery.min.js"></script>
		<script type="text/javascript" src="../../script/tooltip.js"></script>
		<!-- Librería jQuery requerida por los plugins de JavaScript -->
		
	 
		<!-- Todos los plugins JavaScript de Bootstrap (también puedes
			 incluir archivos JavaScript individuales de los únicos
			 plugins que utilices) -->
		<script type="text/javascript">
		// Mostrar el loader cuando comienza la carga del DOM
		
		$(document).ready(function(){
			$("#aniolectdiv").show();
			$("#printer").click(function(event) {
				$("#aniolectdiv").hide();
			
			});
			$("input:checkbox").click(function(){
				var id = $(this).attr("value");
				if($(this).is(":checked")){
					$("#obs"+id).attr('readonly', true);
				}else{
					$("#obs"+id).attr('readonly', false);
					
				}
			});
		});
		</script>
		<style type="text/css">
			body{
				background-color: #ffffff; 
				font-family:"Trebuchet MS", Helvetica, sans-serif;
				font-size:15px;
				color: #fff;
				text-transform:uppercase;
				overflow-x:hidden;
			}
			span.reference{
				position:fixed;
				left:0px;
				bottom:0px;
				background:#000;
				width:100%;
				font-size:10px;
				line-height:20px;
				text-align:right;
				height:50px;
				-moz-box-shadow:-1px 0px 10px #000;
				-webkit-box-shadow:-1px 0px 10px #000;
				box-shadow:-1px 0px 10px #000;
			}
			span.reference a{
				color:#baa;
				text-transform:uppercase;
				text-decoration:none;
				margin-right:10px;
				
			}
			span.reference a:hover{
				color:#ddd;
			}
			.bg_img img{
				width:100%;
				position:fixed;
				top:0px;
				left:0px;
				z-index:-1;
				display: none !important;

			}
			h1{
				color: black;
				font-size:30px;
				text-align:right;
				position:none;
				right:40px;
				top:350px;
				font-weight:normal;
				/*text-shadow:  0 0 3px #0096ff, 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #fff, 0 0 40px #0096ff, 0 0 70px #0096ff, 0 0 80px #0096ff, 0 0 100px #0096ff, 0 0 150px #0096ff;
			*/}
			h1 span{
				display:block;
				font-size:8px;
				font-weight:bold;
			}
			h2{
				position:absolute;
				top:20px;
				left:50px;
				font-size:20px;
				font-weight:normal;
				/*text-shadow:  0 0 3px #f6ff00, 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #fff, 0 0 40px #f6ff00, 0 0 70px #f6ff00, 0 0 80px #f6ff00, 0 0 100px #f6ff00, 0 0 150px #f6ff00;
			*/}
			.tabla{
				width:966px;
				color: black;
                border: 1px solid #000;
				border-collapse: collapse;
				padding: 5px;

			}
			.tabla td , .tabla tr{
				margin:0 auto 0 auto; 
				color: black;
                border: 1px solid #000;
				border-collapse: collapse;
				padding: 5px;

			}
			.anio{
				margin:0 auto 0 auto; 
				width:350;
				color: black;
				border-collapse: collapse;
				padding: 5px;

			}
			.estilocelda{ 
				background-color:ddeeff; 
				color:333333; 
				font-weight:bold; 
				font-size:16pt; 
				text-align: center;
			} 
			#printer {
			  width: 28px;
			  height: 28px;
			}
			#back {
			  width: 28px;
			  height: 28px;
			}
	</style>
    </head>

    <body>
	<div id="loader-overlay">
		<div class="loader"></div>
	</div>
	
		<script>
			// Mostrar el spinner
			document.getElementById('loader-overlay').style.display = 'block';
		</script>
		<div class="bg_img"><img src="../../images/1.jpg" alt="background" /></div>
		<h1>APP ACADEMY<span>La manera mas facil de administrar sus notas y boletines academicos</span>
		<span>Derechos reservados: williamcortes10@gmail.com</span></h1>
		</div>
		<?php
		$look=false;
		if (isset($_SESSION['k_username'])) {
			$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
			$sql2 = "SELECT idusuario, apellido1, nombre1, tipousuario FROM usuario, docente 
			WHERE idusuario='".$_SESSION['k_username']."' and iddocente=idusuario and (tipousuario='D' OR tipousuario='A' OR tipousuario='S' OR tipousuario='C') limit 1";
			$consulta2 = $conx->query($sql2);
			if($conx->get_numRecords($consulta2)>0){
				$records2 = $conx->records_array($consulta2);
				$look=true;
				
			}
			$conx->close_conex();
		}else{
			echo "<div class='form'>
					<div id='stylized' class='myform'><h3 align='center' style='color:black'>Debes Loguearte</h3><br/>";
			echo "<span align='center'><a href='../index.php' align='center'>Regresar</a></span></div></div>";
		}
		if($look){
		$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
		$conx2 = new ConxMySQL($dominio,$usuario,$pass,$bd);
		$sql = "SELECT valor FROM appconfig WHERE item='ie'";
		$consulta = $conx->query($sql);
		$records = $conx->records_array($consulta);
		$ie= ($records['valor']);
		$sql = "SELECT valor FROM appconfig WHERE item = 'Lema'";
		$consulta = $conx->query($sql);    
		$records = $conx->records_array($consulta);
		$lema = ($records['valor']);
		$sql = "SELECT valor FROM appconfig WHERE item = 'ciudad'";
		$consulta = $conx->query($sql);    
		$records = $conx->records_array($consulta);
		$ciudad = ($records['valor']);
		$sql = "SELECT valor FROM appconfig WHERE item = 'departamento'";
		$consulta = $conx->query($sql);    
		$records = $conx->records_array($consulta);
		$departamento = ($records['valor']);
		$sql = "SELECT valor FROM appconfig WHERE item = 'plannotaspages'";
		$consulta = $conx->query($sql);    
		$records = $conx->records_array($consulta);
		$cantestxhoja = (int)$records['valor'];
		$idaula = $_GET['idaula'];
		$aniolect = $_GET['aniolectivo'];
		$periodo = $_GET['periodo'];
		$iddocente = $_GET['id'];
		$sql = "SELECT num_periodos, tipo_periodo FROM periodos_por_anio WHERE anio = '$aniolect'";
		$consulta = $conx->query($sql);    
		$records = $conx->records_array($consulta);
		$num_periodos = $records['num_periodos'];
		if($periodo=='s2' or $periodo=='F'){
			$periodod = $num_periodos;
		}elseif($periodo=='s1'){
			$periodod = 2;
		}else{
			$periodod = $periodo;
			
		}
		
		//Recuperamos el numero de decimales configurados para el año lectivo
		$sql = "SELECT numero_decimales from redondeo_decimal where anio_lectivo=$aniolect LIMIT 1";
		$consulta = $conx->query($sql);    
		$records = $conx->records_array($consulta);
		$numero_decimales = $records['numero_decimales'];
		if(empty($numero_decimales)){
			$numero_decimales = 1;
		}
		$sqldinamizador= "SELECT   c.idmateria, c.idaula, a.descripcion, a.grupo, a.jornada, a.grado
						FROM clase c
						LEFT JOIN aula a ON c.idaula=a.idaula
						WHERE
						c.idmateria='49' AND c.aniolectivo='$aniolect'  AND c.iddocente='$iddocente'  AND c.idaula='$idaula' AND c.periodos LIKE '%".$periodod."%' LIMIT 1";
		$papel = "legal";
		$caracteresxlinea = 65;
		$lineascabezera=14;
		$consultadinamizador = $conx2->query($sqldinamizador);
		$cadena=0;
		$total_materias=numero_asignaturas_salon($idaula, $aniolect);
		while($rowdinamizador = $conx2->records_array($consultadinamizador)){
				$lineasimpresas=$lineascabezera;
				echo "<div class='tabla'>
				<form id='notas' method='POST' action=''>
				<table class='tabla'>";
						
						$idmateria = $rowdinamizador['idmateria'];
						
						$curso = ($rowdinamizador['descripcion']."-GRUPO ".$rowdinamizador['grupo']."-".$rowdinamizador['jornada']."-CORTE NUMERO $periodo");
						$grado = $rowdinamizador['grado'];
						if($papel=='letter'){
							$lineasxhoja=40;
						}elseif($papel=='legal'){
							$lineasxhoja=61;
						}else{
							$lineasxhoja=40;
							
						}
						$tn = "R";
						$flag=false;
						$numreg=0;
						$final="";
						if($periodo=='s1'){
							$final="S1";
							$txtperiodo='Corte: Primer semestre ';
						}elseif($periodo=='s2'){
							$final="S2";
							$txtperiodo='Corte: Segundo semestre ';
						}elseif($periodo=='F'){
							$final="S";
							$txtperiodo=('Corte: Año Lectivo ');
						}else{
							$txtperiodo="Periodo: ".$periodo;
						}
						if($tn=='R'){
							$txt='Regulares';
						}elseif($tn=='N'){
							$txt='Nivelacion';
						}
										
						$sql1 = "SELECT DISTINCT nombre1, nombre2, apellido1, apellido2 
						FROM docente d
						WHERE d.iddocente=$iddocente LIMIT 1";
						$consulta2 = $conx2->query($sql1);
						$row = $conx2->records_array($consulta2);
						echo "<tr><td class='estilocelda' colspan='4'>$ie<br/>$lema<br/>$ciudad-$departamento</td></tr>";
						echo "<tr><td class='estilocelda' colspan='4'>SINTESIS CALIFICACIONES 
						<span style='background-color:white; width:80px; height:15px; font-size:12px;'>COMPLETO</span>
						<span style='background-color:#F3E2A9; width:80px; height:15px; font-size:12px;'>PENDIENTE GUARDAR COMPETENCIAS</span>";
						echo "</td></tr>";
						echo "<tr><td colspan='3'>DINAMIZADOR:".($row['nombre1'])." ".($row['nombre2'])." ".($row['apellido1'])." ".($row['apellido2'])."</td>";
						echo "<td colspan='1' align='right'>Curso:".$curso."</td></tr>";
						echo "<tr><td colspan='3' >".("Año Lectivo:$aniolect")."</td>
						<td align='right'>$txtperiodo</td></tr>";
						echo "</table><br/>";
						//echo "<table class='table table-bordered' style='font-family: \"Courier New\", Times, serif; font-size:11px;'>";
						echo "<table class='table table-bordered' style='font-family: \"Courier New\", Times, serif; font-size:11px; font-weight: bold;'>";
						echo "<tr align='center' class='tabla'>";
						echo "<td>Nro.</td><td>Estudiante</td>";
						$sqlindest = "SELECT DISTINCT m.abreviatura, m.idmateria, m.idarea_fk FROM materia m
										LEFT JOIN clase c ON c.idmateria=m.idmateria 
										WHERE c.idaula = '$idaula' AND c.aniolectivo = '$aniolect'
										ORDER BY c.idmateria ASC;";
										
						$consultaindest = $conx2->query($sqlindest);
						//$asignaturas="";
						$asignaturas = array();
						$vn_materias = array();
						while ($rowindest = $conx2->records_array($consultaindest)) {
							//$nombredocente=$rowindest['apellido1']." ".$rowindest['apellido2']." ".$rowindest['nombre1']." ".$rowindest['nombre2'];
							$asignaturas[$rowindest['idmateria']] = ($rowindest['abreviatura']);
							$vn_materias[$rowindest['abreviatura']]="";
							$cadena+=4;

						}
						foreach ($asignaturas as $clave => $abreviatura):
							echo "<td align='center' title=''>".$abreviatura."</td>";
						endforeach;
						

						echo "<td>Faltas</td>";
						echo "<td>Puesto</td>";
						echo "<td>Promedio</td>";
						echo "</tr>";
						$cadena+=12;
						$lineasimpresas+=3;
						$numero=0; 	
						
						// Llamar al procedimiento almacenado
				        $sql = "CALL ConsultarNotas($total_materias, $numero_decimales, $aniolect, $idaula, $periodod, '$final')";
						//$consulta = $conx2->query($sql);
						$resultado = mysqli_query($conx2->conexion, $sql);
						$numpag=$cantestxhoja;
						$pag=1;
						if ($resultado) {
							$resultados = $conx2->records_array_assoc_all($resultado);
							// Array para almacenar los resultados agrupados por nombre
							$resultados_agrupados = array();

							// Iterar sobre los resultados y agruparlos por nombre
							// Recorrer los resultados y agruparlos por nombre y materia
							foreach ($resultados as $fila) {
								$nombre = $fila['nombre'];
								$materia = $fila['idmateria'];
								// Verificar si ya existe una entrada para este nombre en el array
								if (!isset($resultados_agrupados[$nombre])) {
									$resultados_agrupados[$nombre] = array();
								}
								// Verificar si ya existe una entrada para esta materia en el array del nombre actual
								if (!isset($resultados_agrupados[$nombre][$materia])) {
									$resultados_agrupados[$nombre][$materia] = array();
								}
								// Agregar la fila a la entrada correspondiente
								$resultados_agrupados[$nombre][$materia][] = $fila;
							}
							$numreg = count($resultados_agrupados);
							// Recorrer el array $resultados_agrupados
							$numero=0;
							foreach ($resultados_agrupados as $nombre => $materias) {
								if($lineasimpresas>=$lineasxhoja){
									echo "</table></div>";
									echo "<h1 class='SaltoDePagina'></h1>";
									echo "<div class='tabla'><table class='table table-bordered' style='font-family: \"Courier New\", Times, serif; font-size:11px;'>";
									echo "<span style='text-align:right; margin-left:0px; position:relative;' class='continuapag'>CONTINUA SINTESIS $curso</span>";														
									echo "<tr align='center' class='tabla'>";
									echo "<td>Nro.</td><td>Estudiante</td>";
									foreach ($asignaturas as $clave => $abreviatura):
										echo "<td align='center' title=''>".$abreviatura."</td>";
									endforeach;
									echo "<td>Faltas</td>";
									echo "<td>Puesto</td>";
									echo "<td>Promedio</td>";
									echo "</tr>";
									$lineasimpresas=0;
								}
								echo "<tr class='info'>";
								echo "<td align='center'>".++$numero."</td>";
								echo "<td width='300px'>".$nombre."</td>";
								$faltas=0;
								$id_estudiante=0;
								$promedio=0;
								$puesto=0;
								foreach ($materias as $materia => $registros) {
																		
									// Verificar si la materia existe en el array $materias
									$msjest="";
									if (isset($asignaturas[$materia])) {
										// Si la materia existe, recorrer los registros asociados a esta materia
										foreach ($registros as $registro) {
											
											$vn_materias[$asignaturas[$materia]]=number_format($registro['vn'], $numero_decimales);;
											$faltas+=$registro['fj']+$registro['fsj'];
											$id_estudiante = $registro['idestudiante'];
											$promedio = $registro['promedio'];
											$puesto = $registro['puesto'];
											
										}
										
										
									}
									
								}
								
								foreach ($vn_materias as $vn) {
									$msjest="";
									// Aquí puedes acceder a los valores de cada columna de cada registro										
									if(empty($vn)){
										echo "<td align='center' style='$msjest'></td>";
									}else{
										if($vn<3.0 and $vn!=""){
											$msjest="background-color:#BDBDBD;";
										}
										echo "<td align='center' style='$msjest'>".$vn."</td>";
									}
										
								}
								echo "<td align='center'>$faltas</td>";
								
								$bckg='#FFFFFF';
							
								if($puesto<6){
									$bckg='#00FF99';
								}
								if($promedio=='0'){
									$puesto='';
									$promedio='';
								}
								echo "<td align='center' style='background-color:$bckg; width:54px;'>$puesto</td>";	
								echo "<td align='center' style='background-color:$bckg; width:54px;'>$promedio</td>";	
								echo "</tr>";
								$vn_materias = array_fill_keys(array_keys($vn_materias),null);
							}
							
							
						} 
					echo "</table>";
					echo "</br></br></br></br><div align='center'>
					<span style='font:15px Arial, sans-serif; font-weight:bold;'>".utf8_encode($row['nombre1']." ".$row['nombre2']." ".$row['apellido1'])."</span><br/>
					<span style='font:12px bold arial,sans-serif; font-weight:bold;'>FIRMA</span></div>";
					echo "<span align='center'>
						<input type='button' id ='btnguardar' value='Imprimir' onclick='javascript: void window.print()'/>
					</span>
				</form>
				</div>";
				echo "<h1 class='SaltoDePagina'></h1>";
			}
			
		}
		$conx->close_conex();
		$conx2->close_conex();

	?>
	<script src="../../js/loader.js"></script>
	</body>
</html>
