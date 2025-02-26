﻿<?php
session_start();
?>
<html>
    <head>
        <title>SISTEMA ACADEMICO DE CALIFICACIONES - SINTESIS CALIFICACIONES</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="description" content="" />
        <meta name="keywords" content=""/>
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
		<!-- CSS de Bootstrap -->
		<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="../../css/boletin.css" rel="stylesheet" media="print, screen">
		<!-- Custom styles for this template -->
		<script type="text/javascript" src="../../script/jquery.min.js"></script>
		<script type="text/javascript" src="../../script/tooltip.js"></script>
		<!-- Librería jQuery requerida por los plugins de JavaScript -->
		<script src="../js/jquery.js"></script>
	 
		<!-- Todos los plugins JavaScript de Bootstrap (también puedes
			 incluir archivos JavaScript individuales de los únicos
			 plugins que utilices) -->
		<script src="../js/bootstrap.min.js"></script>
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
	include('../../class/MySqlClass.php');
	include('../../bdConfig.php');
		
	include("../../class/puesto.php");
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
			WHERE idusuario='".$_SESSION['k_username']."' and iddocente=idusuario and (tipousuario='D' OR tipousuario='A' OR tipousuario='S') limit 1";
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
		$ie= utf8_encode($records['valor']);
		$sql = "SELECT valor FROM appconfig WHERE item = 'Lema'";
		$consulta = $conx->query($sql);    
		$records = $conx->records_array($consulta);
		$lema = utf8_encode($records['valor']);
		$sql = "SELECT valor FROM appconfig WHERE item = 'ciudad'";
		$consulta = $conx->query($sql);    
		$records = $conx->records_array($consulta);
		$ciudad = utf8_encode($records['valor']);
		$sql = "SELECT valor FROM appconfig WHERE item = 'departamento'";
		$consulta = $conx->query($sql);    
		$records = $conx->records_array($consulta);
		$departamento = utf8_encode($records['valor']);
		$sql = "SELECT valor FROM appconfig WHERE item = 'plannotaspages'";
		$consulta = $conx->query($sql);    
		$records = $conx->records_array($consulta);
		$cantestxhoja = (int)$records['valor'];
		$idaula = $_POST['idaula'];
		$aniolect = $_POST['aniolectivo'];
		$idmateria = $_POST['idmateria'];
		$periodo = $_POST['periodo'];
		if($periodo=='s1' or $periodo=='s2' or $periodo=='F'){
			$sql = "SELECT * FROM appconfig WHERE item = 'periodo_hab'";
			$consulta = $conx->query($sql);    
			$records = $conx->records_array($consulta);
			$periodod = $records['valor'];
		}else{
			$periodod = $periodo;
		}
		$sqldinamizador= "
						SELECT   c.iddocente, c.idmateria, c.idaula, a.descripcion, a.grupo, a.jornada, a.grado
						FROM clase c
						LEFT JOIN aula a ON c.idaula=a.idaula
						WHERE c.idmateria='49' AND c.aniolectivo='$aniolect' 
						AND a.idaula='$idaula' AND c.periodos LIKE '%".$periodod."%' LIMIT 1";
		$papel = "letter";
		$caracteresxlinea = 65;
		$lineascabezera=14;
		$consultadinamizador = $conx2->query($sqldinamizador);
		$cadena=0;
		while($rowdinamizador = $conx2->records_array($consultadinamizador)){
				$lineasimpresas=$lineascabezera;
				echo "<div class='tabla'>
				<form id='notas' method='POST' action=''>
				<table class='tabla'>";
						
						$iddocente = $rowdinamizador['iddocente'];
						
						$curso = utf8_encode($rowdinamizador['descripcion']."-GRUPO ".$rowdinamizador['grupo']."-".$rowdinamizador['jornada']."-CORTE NUMERO $periodo");
						$grado = $rowdinamizador['grado'];
						if($papel=='letter'){
							$lineasxhoja=40;
						}elseif($papel=='legal'){
							$lineasxhoja=55;
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
						echo "<tr><td class='estilocelda' colspan='4'>LISTADO DE ESTUDIANTES QUE RECUPERAN</td></tr>";
						echo "<tr><td colspan='3'>DINAMIZADOR:".utf8_encode($row['nombre1'])." ".utf8_encode($row['nombre2'])." ".utf8_encode($row['apellido1'])." ".utf8_encode($row['apellido2'])."</td>";
						echo "<td colspan='1' align='right'>Curso:".$curso."</td></tr>";
						echo "<tr><td colspan='3' >".("Año Lectivo:$aniolect")."</td>
						<td align='right'>$txtperiodo</td></tr>";
						echo "</table><br/>";
						echo "<table class='table table-bordered' style='font-family: \"Courier New\", Times, serif; font-size:11px;'>";
						echo "<tr align='center' class='tabla'>";
						echo "<td>Nro.</td><td>Estudiante</td>";
						$sqlindest = "SELECT DISTINCT m.abreviatura, m.idmateria, m.idarea_fk FROM materia m
										LEFT JOIN clase c ON c.idmateria=m.idmateria 
										WHERE c.idaula = '$idaula' AND c.aniolectivo = '$aniolect
										and c.idmateria!=49 '
										ORDER BY c.idmateria ASC;";
						$consultaindest = $conx2->query($sqlindest);
						$asignaturas="";				
						echo "<td>Asignaturas Reprobadas</td>";
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
								echo "<td>Asignaturas Reprobadas</td>";
								echo "</tr>";
								$lineasimpresas=0;
							}
							$cadena+=strlen($row2['apellido1'].$row2['apellido2'].$row2['nombre1'].$row2['nombre2'].$row2['idestudiante']);
							if($idmateria=='T'){
								$sqlindest = "SELECT DISTINCT mt.abreviatura, mt.idmateria, mt.nombre_materia 
								FROM materia mt 
								INNER JOIN notas n ON mt.idmateria=n.idmateria  WHERE n.idestudiante='".$row2['idestudiante']."' 
								AND n.aniolectivo=$aniolect 
								AND n.tipo_nota='R' ORDER BY mt.nombre_materia ASC";
							}else{
								$sqlindest = "SELECT DISTINCT mt.abreviatura, mt.idmateria, mt.nombre_materia 
								FROM materia mt 
								INNER JOIN notas n ON mt.idmateria=n.idmateria  WHERE n.idestudiante='".$row2['idestudiante']."' 
								AND n.aniolectivo=$aniolect and n.idmateria='$idmateria'
								AND n.tipo_nota='R' ORDER BY mt.nombre_materia ASC";
								
							}
							
							$consultaindest = $conx2->query($sqlindest);
							$faltas=0;
							$materias_perdidas=0;
							$asignaturas='';
							while ($rowindest = $conx2->records_array($consultaindest)) {
								$msjest="";
								if($periodo>=1 and $periodo<=4){
									$idestudiante=$row2['idestudiante'];
									$idmateria=$rowindest['idmateria'];
									$area=$rowindest['idarea_fk'];
									$sqliddocente = "SELECT DISTINCT c.iddocente
									FROM clase c
									WHERE c.idmateria= $idmateria AND c.idaula=$idaula AND c.periodos LIKE '%$periodo%' AND c.aniolectivo=$aniolect";
									$consultaiddocente = $conx2->query($sqliddocente);
									$rowiddocente = $conx2->records_array($consultaiddocente);
									$iddocenteind=$rowiddocente['iddocente'];
									$sqlnota="SELECT vn , fj, fsj FROM notas WHERE 
									periodo = $periodo AND tipo_nota = 'R' AND aniolectivo = '$aniolect' 
									AND idmateria = '".$rowindest['idmateria']."' AND idestudiante='".$row2['idestudiante']."' LIMIT 1";
									//inicio de verificación de calificaciones
									//---fin verificar si ya se ha calificado
									//verificando si se ingreso nota del estudiante
									$sqldata1 = "SELECT DISTINCT e.idestudiante FROM estudiante e
									LEFT JOIN notas n ON e.idestudiante=n.idestudiante
									WHERE e.idestudiante='$idestudiante' AND   n.aniolectivo=$aniolect 
									AND n.tipo_nota='R' AND n.periodo=$periodo AND n.idmateria=$idmateria ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 LIMIT 1";
									$consultadata1 = $conx->query($sqldata1);
									$numnota=$conx->get_numRecords($consultadata1);
									//fin verificando nota
									//mensajes 
									$msjest="";
									
									//fin mensajes
								}elseif($periodo=='s1'){
									
									$sqlnota="SELECT ROUND( AVG( vn ) , 3 ) AS nota, (SUM(fj)+SUM(fsj)) AS faltas  FROM notas WHERE 
									periodo <= 2 AND tipo_nota = 'R' AND aniolectivo = '$aniolect' 
									AND idmateria = '".$rowindest['idmateria']."' AND idestudiante='".$row2['idestudiante']."'
									GROUP BY idestudiante";
									$sqlrecordNVSEM = "SELECT DISTINCT mt.nombre_materia, n.* 
									FROM materia mt, notas n WHERE n.idestudiante=".$row2['idestudiante']." 
									AND mt.idmateria=n.idmateria AND n.idmateria='".$rowindest['idmateria']."' AND n.periodo=5  AND n.aniolectivo=$aniolect 
									AND n.tipo_nota='N'";
									$consultarecordNVSEM = $conx->query($sqlrecordNVSEM);
									$nvSEM1=0;
									if($recordsperiodoNVSEM = $conx->records_array($consultarecordNVSEM)){
										$nvSEM1=number_format((float)$recordsperiodoNVSEM['vn'],1,".",",");
										$nvSEM1="<span nowrap valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>".$nvSEM1."</strong></span>";
									}
									if($nvSEM1==0){
										$nota=promedioSemMateria($row2['idestudiante'], $idaula, $aniolect, 1, 2,$rowindest['idmateria']);
									}else{
										$nota=$nvSEM1;
									}
									$asignaturas.=$rowindest['abreviatura']."[".$nota."] ";

								}elseif($periodo=='s2'){
									$sqlnota="SELECT ROUND( AVG( vn ) , 3 ) AS nota, (SUM(fj)+SUM(fsj)) AS faltas  FROM notas WHERE 
									(periodo >= 3 and periodo <= 4) AND tipo_nota = 'R' AND aniolectivo = '$aniolect' 
									AND idmateria = '".$rowindest['idmateria']."' AND idestudiante='".$row2['idestudiante']."'
									GROUP BY idestudiante";
									$sqlrecordNVSEM = "SELECT DISTINCT mt.nombre_materia, n.* 
									FROM materia mt, notas n WHERE n.idestudiante=".$row2['idestudiante']." 
									AND mt.idmateria=n.idmateria AND n.idmateria='".$rowindest['idmateria']."' AND n.periodo=6  AND n.aniolectivo=$aniolect 
									AND n.tipo_nota='N'";
									$consultarecordNVSEM = $conx->query($sqlrecordNVSEM);
									$nvSEM2=0;
									if($recordsperiodoNVSEM = $conx->records_array($consultarecordNVSEM)){
										$nvSEM2=number_format((float)$recordsperiodoNVSEM['vn'],1,".",",");
										$nvSEM2="<span nowrap valign='center' style='text-align:center; border: 1px solid white; background-color:#4C4C4C; color:white;' ><strong>".$nvSEM2."</strong></span>";
									}
									if($nvSEM2==0){
										$nota=promedioSemMateria($row2['idestudiante'], $idaula, $aniolect, 3, 4,$rowindest['idmateria']);
									}else{
										$nota=$nvSEM2;
									}
									$asignaturas.=$rowindest['abreviatura']."[".$nota."] ";
								}elseif($periodo=='F'){
									//FINAL
									$sqlrecordNVSEM = "SELECT DISTINCT mt.nombre_materia, n.* 
									FROM materia mt, notas n WHERE n.idestudiante=".$row2['idestudiante']." 
									AND mt.idmateria=n.idmateria AND n.idmateria='".$rowindest['idmateria']."' AND n.periodo=5  AND n.aniolectivo=$aniolect 
									AND n.tipo_nota='N'";
									$consultarecordNVSEM = $conx->query($sqlrecordNVSEM);
									$nvSEM1=0;
									if($recordsperiodoNVSEM = $conx->records_array($consultarecordNVSEM)){
										$nvSEM1=number_format((float)$recordsperiodoNVSEM['vn'],1,".",",");
									}
									$sqlrecordNVSEM = "SELECT DISTINCT mt.nombre_materia, n.* 
									FROM materia mt, notas n WHERE n.idestudiante=".$row2['idestudiante']." 
									AND mt.idmateria=n.idmateria AND n.idmateria='".$rowindest['idmateria']."' AND n.periodo=6  AND n.aniolectivo=$aniolect 
									AND n.tipo_nota='N'";
									$consultarecordNVSEM = $conx->query($sqlrecordNVSEM);
									$nvSEM2=0;
									if($recordsperiodoNVSEM = $conx->records_array($consultarecordNVSEM)){
										$nvSEM2=number_format((float)$recordsperiodoNVSEM['vn'],1,".",",");
									}
									$promedioFinal1=promedioAnioAlg2MateriaNV($row2['idestudiante'], $idaula, $aniolect, 1, 2,$rowindest['idmateria']);
									$promedioFinal2=promedioAnioAlg2MateriaNV($row2['idestudiante'], $idaula, $aniolect, 3, 4,$rowindest['idmateria']);
									if($nvSEM1>$promedioFinal1){
										$promedioFinal1=$nvSEM1;
									}
									if($nvSEM2>$promedioFinal2){
										$promedioFinal2=$nvSEM2;
									}
									$promedioFinal = round(($promedioFinal1+$promedioFinal2)/2,1, PHP_ROUND_HALF_UP);
									$sqlrecordNVFINAL = "SELECT DISTINCT mt.nombre_materia, n.* 
									FROM materia mt, notas n WHERE n.idestudiante=".$row2['idestudiante']." 
									AND mt.idmateria=n.idmateria AND n.idmateria='".$rowindest['idmateria']."' AND n.periodo=7  AND n.aniolectivo=$aniolect 
									AND n.tipo_nota='N'";
									$consultarecordNFINAL = $conx->query($sqlrecordNVFINAL);
									$nvFINAL=0;
									if($recordsperiodoNVFINAL = $conx->records_array($consultarecordNFINAL)){
										$nvFINAL=number_format((float)$recordsperiodoNVFINAL['vn'],1,".",",");
									}
									if($promedioFinal<$nvFINAL){
										$nota=$nvFINAL;
									}else{
										$nota=$promedioFinal;
									}
									
								}
								if($nota<3.0){
									$materias_perdidas++;
									$asignaturas.=$rowindest['abreviatura']."[".$nota."] ";
								}
					
							}
							if($materias_perdidas>0 and $materias_perdidas<3){
								echo "<tr class='info'>";
								echo "<td align='center'>".++$numero."</td>";
								echo "<td width='445px'>".utf8_encode($row2['apellido1']." ".$row2['apellido2']." ".$row2['nombre1']." ".$row2['nombre2'])."(".$row2['idestudiante'].")</td>";
								echo "<td width='400px'>".utf8_encode($asignaturas)."</td>";
							
							}
							echo "</tr>";
							
							
						}
						
					
					if($lineasimpresas>=$lineasxhoja){
						echo "</table></div>";
						echo "<h1 class='SaltoDePagina'></h1>";
						echo "<div class='tabla'><table class='table table-bordered' style='font-family: \"Courier New\", Times, serif; font-size:11px;'>";
						echo "<span style='text-align:right; margin-left:0px; position:relative;' class='continuapag'>CONTINUA SINTESIS $curso</span>";														
						echo "<tr align='center' class='tabla'>";
						echo "<td>Nro.</td><td>Estudiante</td>";
						echo "<td>Asignaturas Reprobadas</td>";
						echo $asignaturas;
						
						echo "</tr>";
						$lineasimpresas=0;
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

	</body>
</html>
