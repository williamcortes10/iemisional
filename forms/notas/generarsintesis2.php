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
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="description" content="" />
        <meta name="keywords" content=""/>
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
		<!-- CSS de Bootstrap -->
		<link href="../../css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="../../css/boletin.css" rel="stylesheet" media="print, screen">
		<!-- Custom styles for this template -->
		<script type="text/javascript" src="../../script/jquery.min.js"></script>
		<script type="text/javascript" src="../../script/tooltip.js"></script>
		<!-- Librería jQuery requerida por los plugins de JavaScript -->
		<script src="../../js/jquery.js"></script>
	 
		<!-- Todos los plugins JavaScript de Bootstrap (también puedes
			 incluir archivos JavaScript individuales de los únicos
			 plugins que utilices) -->
		<script src="../../js/bootstrap.min.js"></script>
		<script type="text/javascript">
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
	<?php
	
		?>
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
			
		$conx2 = new ConxMySQL($dominio,$usuario,$pass,$bd);
		$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
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
		if($periodo=='s1' or $periodo=='s2' or $periodo=='F'){
			$periodod = $num_periodos;
		}else{
			$periodod = $periodo;
			
		}

		$sqlcursos="SELECT   c.iddocente, c.idmateria, c.idaula, a.descripcion, a.grupo, a.jornada, a.grado
						FROM clase c LEFT JOIN aula a ON c.idaula=a.idaula
						WHERE c.idmateria='49' AND c.aniolectivo='$aniolect' AND c.idaula=$idaula";
		$consultacursos = $conx->query($sqlcursos);
		while($rowcursos = $conx->records_array($consultacursos)){
		$iddocente=$rowcursos['iddocente'];
		$idaula=$rowcursos['idaula'];
		$sqldinamizador= "SELECT   c.idmateria, c.idaula, a.descripcion, a.grupo, a.jornada, a.grado
						FROM clase c
						LEFT JOIN aula a ON c.idaula=a.idaula
						WHERE
						c.idmateria='49' AND c.aniolectivo='$aniolect'  AND c.iddocente='$iddocente' AND c.idaula='$idaula' AND c.periodos LIKE '%".$periodod."%' LIMIT 1";
		$papel = "legal";
		$caracteresxlinea = 65;
		$lineascabezera=14;
		$consultadinamizador = $conx2->query($sqldinamizador);
		$cadena=0;
		$total_materias=numero_asignaturas_salon($idaula, $aniolect);
		if($aniolect>2016){
			if($periodo=='F'){
				$tabla_promedios=tabla_promedios_con_comportamiento($idaula, $aniolect, $periodo , 'S', $total_materias);
			}else{
				$tabla_promedios=tabla_promedios_con_comportamiento($idaula, $aniolect, $periodo, '', $total_materias);
			}
		}else{
			$tabla_promedios=tabla_promedios($idaula, $aniolect, $periodo);
		}
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
						if($periodo=='s1'){
							$txtperiodo='Corte: Primer semestre ';
						}elseif($periodo=='s2'){
							$txtperiodo='Corte: Segundo semestre ';
						}elseif($periodo=='F'){
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
						echo "<table class='table table-bordered' style='font-family: \"Courier New\", Times, serif; font-size:11px;'>";
						echo "<tr align='center' class='tabla'>";
						echo "<td>Nro.</td><td>Estudiante</td>";
						$sqlindest = "SELECT DISTINCT m.abreviatura, m.idmateria, m.idarea_fk FROM materia m
										LEFT JOIN clase c ON c.idmateria=m.idmateria 
										WHERE c.idaula = '$idaula' AND c.aniolectivo = '$aniolect'
										ORDER BY c.idmateria ASC;";
										
						$consultaindest = $conx2->query($sqlindest);
						$asignaturas="";
						$materias = array();
						$imat=0;
						while ($rowindest = $conx2->records_array($consultaindest)) {
							//$nombredocente=$rowindest['apellido1']." ".$rowindest['apellido2']." ".$rowindest['nombre1']." ".$rowindest['nombre2'];
							$asignaturas.="<td align='center' title=''>".($rowindest['abreviatura'])."</td>";
							$cadena+=4;
							$materias[$imat] = $rowindest;
							$imat++;
						}
						
						echo $asignaturas;
						echo "<td>Faltas</td>";
						echo "<td>Puesto</td>";
						echo "<td>Promedio</td>";
						echo "</tr>";
						$cadena+=12;
						$lineasimpresas+=3;
						$numero=0; 	
						$sql = "SELECT e.nombre1, e.nombre2, e.apellido1, e.apellido2, e.idestudiante FROM estudiante e
						LEFT JOIN  matricula m ON m.idestudiante=e.idestudiante 
						WHERE m.idaula='$idaula' AND m.aniolectivo=$aniolect AND m.tipo_matricula='R' AND e.habilitado='S' AND m.periodo='0'
						ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
						
						$consulta = $conx2->query($sql);
						$numreg = $conx2->get_numRecords($consulta);
						$numpag=$cantestxhoja;
						$pag=1;
						while ($row2 = $conx2->records_array($consulta)) {
							
							if($lineasimpresas>=$lineasxhoja){
								echo "</table></div>";
								echo "<h1 class='SaltoDePagina'></h1>";
								echo "<div class='tabla'><table class='table table-bordered' style='font-family: \"Courier New\", Times, serif; font-size:11px;'>";
								echo "<span style='text-align:right; margin-left:0px; position:relative;' class='continuapag'>CONTINUA SINTESIS $curso</span>";														
								echo "<tr align='center' class='tabla'>";
								echo "<td>Nro.</td><td>Estudiante</td>";
								echo $asignaturas;
								echo "<td>Faltas</td>";
								echo "<td>Puesto</td>";
								echo "<td>Promedio</td>";
								echo "</tr>";
								$lineasimpresas=0;
							}
							echo "<tr class='info'>";
							echo "<td align='center'>".++$numero."</td>";
							echo "<td width='300px'>".($row2['apellido1']." ".$row2['apellido2']." ".$row2['nombre1']." ".$row2['nombre2'])."(".$row2['idestudiante'].")</td>";
							$cadena+=strlen($row2['apellido1'].$row2['apellido2'].$row2['nombre1'].$row2['nombre2'].$row2['idestudiante']);
							
							$faltas=0;
							$consultaindest = $conx2->query($sqlindest);
							while ($rowindest = $conx2->records_array($consultaindest)) {
								$area=$rowindest['idarea_fk'];
								$idestudiante=$row2['idestudiante'];
								$idmateria=$rowindest['idmateria'];
								$area=$rowindest['idarea_fk'];
								if($periodo>=1 and $periodo<=4){
									$sqlnota="SELECT vn , fj, fsj FROM notas WHERE 
									periodo = $periodo AND tipo_nota = 'R' AND aniolectivo = '$aniolect' 
									AND idmateria = '".$rowindest['idmateria']."' AND idestudiante='".$row2['idestudiante']."' LIMIT 1";
									//inicio de verificación de calificaciones
									
								}elseif($periodo=='s1'){
									
									$sqlnota="SELECT ROUND( AVG( vn ) , 3 ) AS nota, (SUM(fj)+SUM(fsj)) AS faltas  FROM notas WHERE 
									periodo <= 2 AND tipo_nota = 'R' AND aniolectivo = '$aniolect' 
									AND idmateria = '".$rowindest['idmateria']."' AND idestudiante='".$row2['idestudiante']."'
									GROUP BY idestudiante";
									$nota=promedioSemMateria($row2['idestudiante'], $idaula, $aniolect, 1, 2,$rowindest['idmateria']);
										
								}elseif($periodo=='s2'){
									$sqlnota="SELECT ROUND( AVG( vn ) , 3 ) AS nota, (SUM(fj)+SUM(fsj)) AS faltas  FROM notas WHERE 
									(periodo >= 3 and periodo <= 4) AND tipo_nota = 'R' AND aniolectivo = '$aniolect' 
									AND idmateria = '".$rowindest['idmateria']."' AND idestudiante='".$row2['idestudiante']."'
									GROUP BY idestudiante";
									$nota=promedioSemMateria($row2['idestudiante'], $idaula, $aniolect, 3, 4,$rowindest['idmateria']);
								}elseif($periodo=='F'){
									$sqlnota="SELECT ROUND( SUM( vn )/$num_periodos , 3 ) AS nota, (SUM(fj)+SUM(fsj)) AS faltas  FROM notas WHERE 
									periodo <= $num_periodos AND tipo_nota = 'R' AND aniolectivo = '$aniolect' 
									AND idmateria = '".$rowindest['idmateria']."' AND idestudiante='".$row2['idestudiante']."'
									GROUP BY idestudiante";
									//var_dump($sqlnota);
									$nota=promedioAnioSemMateria($row2['idestudiante'], $idaula, $aniolect, $rowindest['idmateria']);
									$sqlrecordNV = "SELECT notas.vn, notas.periodo FROM notas WHERE notas.idestudiante='$idestudiante' 
									AND notas.idmateria='$idmateria' AND notas.tipo_nota='N' AND notas.aniolectivo=$aniolect 
									AND notas.periodo=7 ORDER BY notas.periodo";
									//var_dump($sqlrecordNV);
									$consultarecordNV = $conx->query($sqlrecordNV);
									if($recordsperiodoNV = $conx->records_array($consultarecordNV)){
										if(number_format((float)$recordsperiodoNV['vn'],1,".",",") > number_format((float)$nota,1,".",",") ){
											$nota=number_format((float)$recordsperiodoNV['vn'],1,".",",");
										}
									}
								}
								$consultanota = $conx2->query($sqlnota);
								$msjest="";
								if ($rownota = $conx2->records_array($consultanota)) {
									if($periodo>=1 and $periodo<=4){
										//
										if(round($rownota['vn'], 1)<3.0){
											$msjest="background-color:#BDBDBD;";
										}
										echo "<td align='center' style='$msjest'>".round($rownota['vn'], 1)."</td>";
										$faltas+=$rownota['fj']+$rownota['fsj'];
									}else{
										if($nota<3.0){
											$msjest="background-color:#BDBDBD;";
										}
										echo "<td align='center' style='$msjest'>".$nota."</td>";
										$faltas+=$rownota['faltas'];
									}
									
									
								}else{
									echo "<td align='center' style='background-color:#white; border: 2px solid red'></td>";
								}

							}
							
							if($periodo>=1 and $periodo<=4){
								
								//$puesto=puestoPeriodoAlg2($row2['idestudiante'], $idaula, $aniolect, $periodo);
								//$promedio=promedioPeriodoAlg2($row2['idestudiante'], $idaula, $aniolect, $periodo);
								if($aniolect>2016){
									//die("<h1>".$aniolect."</h1>");
									$promedio=promedio_periodo_con_comportamiento($row2['idestudiante'], $idaula, $aniolect, $periodo, '', $total_materias);
									
									$puesto=array_search($promedio,$tabla_promedios)+1;;
								}else{
									$promedio=promedioPeriodoAlg2($row2['idestudiante'], $idaula, $aniolect, $periodo);
									$puesto=array_search($promedio,$tabla_promedios)+1;;
								}
							}elseif($periodo=='s1'){
								$puesto=puestoAnioAlg2($row2['idestudiante'], $idaula, $aniolect, 1, 2);
								$promedio=promedioAnioAlg2($row2['idestudiante'], $idaula, $aniolect, 1, 2);
							}elseif($periodo=='s2'){
								$puesto=puestoAnioAlg2($row2['idestudiante'], $idaula, $aniolect, 3, 4);
								$promedio=promedioAnioAlg2($row2['idestudiante'], $idaula, $aniolect, 3, 4);
							}elseif($periodo=='F'){
								if($aniolect>2016){
									$promedio=promedio_periodo_con_comportamiento($row2['idestudiante'], $idaula, $aniolect, $periodo, 'S', $total_materias);
									
									$puesto=array_search($promedio,$tabla_promedios)+1;;
								}else{
									$puesto=puestoAnioSem($row2['idestudiante'], $idaula, $aniolect);
									$promedio=promedioAnioSem($row2['idestudiante'], $idaula, $aniolect);
								}
								
							}
							$bckg='#FFFFFF';
							
							if($puesto<6){
								$bckg='#00FF99';
							}
							if($promedio=='0'){
								$puesto='';
								$promedio='';
							}
							echo "<td align='center'>$faltas</td>";	
							echo "<td align='center' style='background-color:$bckg; width:54px;'>$puesto</td>";	
							echo "<td align='center' style='background-color:$bckg; width:54px;'>$promedio</td>";	
							echo "</tr>";
							$numlineasind=ceil(strlen($cadena)/$caracteresxlinea);
							$lineasimpresas+=$numlineasind;
							
							
						}
						
					
					if($lineasimpresas>=$lineasxhoja){
						echo "</table></div>";
						echo "<h1 class='SaltoDePagina'></h1>";
						echo "<div class='tabla'><table class='table table-bordered' style='font-family: \"Courier New\", Times, serif; font-size:11px;'>";
						echo "<span style='text-align:right; margin-left:0px; position:relative;' class='continuapag'>CONTINUA SINTESIS $curso</span>";														
						echo "<tr align='center' class='tabla'>";
						echo "<td>Nro.</td><td>Estudiante</td>";
						echo $asignaturas;
						echo "<td>Faltas</td>";
						echo "<td>Puesto</td>";
						echo "<td>Promedio</td>";
						echo "</tr>";
						$lineasimpresas=0;
					}
					echo "</table>";
					echo "</br></br></br></br><div align='center'>
					<span style='font:15px Arial, sans-serif; font-weight:bold;'>".($row['nombre1']." ".$row['nombre2']." ".$row['apellido1'])."</span><br/>
					<span style='font:12px bold arial,sans-serif; font-weight:bold;'>FIRMA</span></div>";
					echo "<span align='center'>
						<input type='button' id ='btnguardar' value='Imprimir' onclick='javascript: void window.print()'/>
					</span>
				</form>
				</div>";
				echo "<h1 class='SaltoDePagina'></h1>";
			}
		}
			
		}
		$conx->close_conex();
		$conx2->close_conex();

	?>

	</body>
</html>
