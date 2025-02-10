<?php
session_start();
?>
<html>
    <head>
        <title>SISTEMA ACADEMICO DE CALIFICACIONES - SINTESIS CALIFICACIONES</title>
        <meta http-equiv="Content-Type" content="text/html; "/>
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
		include("../../class/MySqlClass.php");
		include("../../class/puesto.php");
		?>
		<div class="bg_img"><img src="../../images/1.jpg" alt="background" /></div>
		<h1>APP ACADEMY<span>La manera mas facil de administrar sus notas y boletines academicos</span>
		<span>Derechos reservados: williamcortes10@gmail.com</span></h1>
		</div>
		<?php
		$look=false;
		if (isset($_SESSION['k_username'])) {
			$conx2 = new ConxMySQL("localhost","root","","appacademy");
			$sql2 = "SELECT idusuario, apellido1, nombre1, tipousuario FROM usuario, docente 
			WHERE idusuario='".$_SESSION['k_username']."' and iddocente=idusuario and (tipousuario='D' OR tipousuario='A')";
			$consulta2 = $conx2->query($sql2);
			if($conx2->get_numRecords($consulta2)>0){
				$records2 = $conx2->records_array($consulta2);
				$look=true;
				
			}
		}else{
			echo "<div class='form'>
					<div id='stylized' class='myform'><h3 align='center' style='color:black'>Debes Loguearte</h3><br/>";
			echo "<span align='center'><a href='../index.php' align='center'>Regresar</a></span></div></div>";
		}
		if($look){
		$conx = new ConxMySQL("localhost","root","","appacademy");
		$sql = "SELECT valor FROM appconfig WHERE item='ie'";
		$consulta = $conx->query($sql);
		$records = $conx->records_array($consulta);
		$ie= $records['valor'];
		$sql = "SELECT valor FROM appconfig WHERE item = 'Lema'";
		$consulta = $conx->query($sql);    
		$records = $conx->records_array($consulta);
		$lema = $records['valor'];
		$sql = "SELECT valor FROM appconfig WHERE item = 'ciudad'";
		$consulta = $conx->query($sql);    
		$records = $conx->records_array($consulta);
		$ciudad = $records['valor'];$sql = "SELECT valor FROM appconfig WHERE item = 'departamento'";
		$consulta = $conx->query($sql);    
		$records = $conx->records_array($consulta);
		$departamento = $records['valor'];
		$sql = "SELECT valor FROM appconfig WHERE item = 'plannotaspages'";
		$consulta = $conx->query($sql);    
		$records = $conx->records_array($consulta);
		$cantestxhoja = (int)$records['valor'];
		$idaula = $_POST['idaula'];
		
		$aniolect = $_POST['aniolect'];
		if($idaula=="all"){
			$sqldinamizador= "SELECT c.*  FROM clase c, aula a WHERE c.idmateria = 49 AND c.aniolectivo = $aniolect AND a.idaula=c.idaula ORDER BY a.grado, a.grupo";
		}else{
			$sqldinamizador= "SELECT c.*  FROM clase c, aula a WHERE c.idmateria = 49 AND c.aniolectivo = $aniolect AND a.idaula=c.idaula AND c.idaula='$idaula' ORDER BY a.grado, a.grupo";
		}
		$papel = $_POST['papel'];
		$caracteresxlinea = 65;
		$lineascabezera=14;
		$consultadinamizador = $conx2->query($sqldinamizador);
		$cadena=0;
		while($rowdinamizador = $conx2->records_array($consultadinamizador)){
				$lineasimpresas=$lineascabezera;
				echo "<div class='tabla'>
				<form id='notas' method='POST' action='guardarnotas_response.php'>
				<table class='tabla'>";
						$periodo = $_POST['idperiodo'];
						$idmateria = $rowdinamizador['idmateria'];
						$idaula=$rowdinamizador['idaula'];
						$sql = "SELECT descripcion, grupo, grado FROM aula WHERE idaula = '$idaula'";
						$consulta = $conx->query($sql);    
						$records = $conx->records_array($consulta);
						$curso = ($records['descripcion']."-GRUPO ".$records['grupo']."-CORTE NUMERO $periodo");
						$grado = $records['grado'];
						if($papel=='letter'){
							$lineasxhoja=40;
						}elseif($papel=='legal'){
							$lineasxhoja=55;
						}else{
							$lineasxhoja=40;
							
						}
						$iddocente = $rowdinamizador['iddocente'];
						$tn = "R";
						$flag=false;
						$numreg=0;
						if($periodo=='s1'){
							$txtperiodo='Corte: Primer semestre ';
						}elseif($periodo=='s2'){
							$txtperiodo='Corte: Segundo semestre ';
						}elseif($periodo=='F'){
							$txtperiodo=utf8_decode('Corte: Año Lectivo ');
						}else{
							$txtperiodo="Periodo: ".$periodo;
						}
						if($tn=='R'){
							$txt='Regulares';
						}elseif($tn=='N'){
							$txt='Nivelacion';
						}
										
						$sql1 = "SELECT DISTINCT nombre1, nombre2, apellido1, apellido2, m.nombre_materia, 
						a.grado, a.grupo, a.descripcion FROM docente d, clase c, materia m, aula a 
						WHERE d.iddocente=$iddocente AND c.iddocente=d.iddocente AND c.idmateria= $idmateria AND m.idmateria=c.idmateria 
						AND c.idaula=$idaula AND c.idaula=a.idaula AND c.aniolectivo=$aniolect";
						$consulta2 = $conx2->query($sql1);
						$row = $conx2->records_array($consulta2);
						echo "<tr><td class='estilocelda' colspan='4'>$ie<br/>$lema<br/>$ciudad-$departamento</td></tr>";
						echo "<tr><td class='estilocelda' colspan='4'>SINTESIS CALIFICACIONES 
						<span style='background-color:#2EFE2E; width:80px; height:15px; font-size:12px;'>COMPLETO</span>
						<span style='background-color:orange; width:80px; height:15px; font-size:12px;'>PENDIENTE GUARDAR COMPETENCIAS</span>";
						echo "</td></tr>";
						echo "<tr><td colspan='3'>DINAMIZADOR:".utf8_decode($row['nombre1'])." ".utf8_decode($row['nombre2'])." ".utf8_decode($row['apellido1'])." ".utf8_decode($row['apellido2'])."</td>";
						echo "<td colspan='1' align='right'>Curso:".$row['descripcion']."-Grupo".$row['grupo']."</td></tr>";
						echo "<tr><td colspan='3' >".utf8_decode("Año Lectivo:$aniolect")."</td>
						<td align='right'>$txtperiodo</td></tr>";
						echo "</table><br/>";
						echo "<table class='table table-bordered' style='font-family: \"Courier New\", Times, serif; font-size:11px;'>";
						echo "<tr align='center' class='tabla'>";
						echo "<td>Nro.</td><td>Estudiante</td>";
						$sqlindest = "SELECT DISTINCT m.*  FROM clase c, materia m WHERE c.idaula = '$idaula' AND c.aniolectivo = '$aniolect'
										AND m.idmateria=c.idmateria
										ORDER BY c.idmateria ASC;";
						$consultaindest = $conx2->query($sqlindest);
						while ($rowindest = $conx2->records_array($consultaindest)) {
							echo "<td align='center'>".$rowindest['abreviatura']."</td>";
							$cadena+=4;

						}
						echo "<td>Faltas</td>";
						echo "<td>Puesto</td>";
						echo "<td>Promedio</td>";
						echo "</tr>";
						$cadena+=12;
						$lineasimpresas+=3;
						$numero=0; 	
						$sql = "SELECT e.* FROM estudiante e, matricula m WHERE
						m.idestudiante=e.idestudiante 
						AND m.idaula='$idaula' AND m.aniolectivo=$aniolect AND m.tipo_matricula='R' AND e.habilitado='S' 
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
								$sqlindest = "SELECT DISTINCT m.*  FROM clase c, materia m WHERE c.idaula = '$idaula' AND c.aniolectivo = '$aniolect'
												AND m.idmateria=c.idmateria
												ORDER BY c.idmateria ASC;";
								$consultaindest = $conx2->query($sqlindest);
								while ($rowindest = $conx2->records_array($consultaindest)) {
									echo "<td align='center'>".$rowindest['abreviatura']."</td>";

								}
								echo "<td>Faltas</td>";
								echo "<td>Puesto</td>";
								echo "<td>Promedio</td>";
								echo "</tr>";
								$lineasimpresas=0;
							}
							echo "<tr class='info'>";
							echo "<td align='center'>".++$numero."</td>";
							echo "<td width='300px'>".($row2['apellido1'])." ".($row2['apellido2'])." ".($row2['nombre1'])." ".($row2['nombre2'])."(".$row2['idestudiante'].")</td>";
								$cadena+=strlen($row2['apellido1'].$row2['apellido2'].$row2['nombre1'].$row2['nombre2'].$row2['idestudiante']);
							$sqlindest = "SELECT DISTINCT m.*  FROM clase c, materia m WHERE c.idaula = '$idaula' AND c.aniolectivo = '$aniolect'
										AND m.idmateria=c.idmateria
										ORDER BY c.idmateria ASC;";
							$consultaindest = $conx2->query($sqlindest);
							$faltas=0;
							while ($rowindest = $conx2->records_array($consultaindest)) {
								$msjest="";
								if($periodo>=1 and $periodo<=4){
									$id=$row2['idestudiante'];
									$idmateria=$rowindest['idmateria'];
									$sqlarea ="SELECT idarea_fk  FROM materia WHERE idmateria = '$idmateria'";
									$qarea = $conx->query($sqlarea);
									$rowarea = $conx->records_array($qarea);
									$area=$rowarea['idarea_fk'];
									$sqliddocente = "SELECT DISTINCT c.iddocente
									FROM clase c, indicadoresboletin ib
									WHERE c.idmateria= $idmateria AND c.idaula=$idaula AND c.periodos LIKE '%$periodo%' AND c.aniolectivo=$aniolect";
									$consultaiddocente = $conx2->query($sqliddocente);
									$rowiddocente = $conx2->records_array($consultaiddocente);
									$iddocenteind=$rowiddocente['iddocente'];
									$sqlnota="SELECT ROUND( AVG( vn ) , 1 ) AS nota, (SUM(fj)+SUM(fsj)) AS faltas  FROM notas WHERE 
									periodo = $periodo AND tipo_nota = 'R' AND aniolectivo = '$aniolect' 
									AND idmateria = '".$rowindest['idmateria']."' AND idestudiante='".$row2['idestudiante']."'
									GROUP BY idestudiante";
									//inicio de verificación de calificaciones
									///seleccionando indicadores escogidos por el docenbte en esta area y curso
									$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
												pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
												FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
												(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
												and pc.estandarbc=ebc.codigo
												and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolect
												and eb.periodo =$periodo and eb.iddocente ='$iddocenteind' and eb.grado ='$grado'
												and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
												ORDER BY consecutivo DESC";
									$consultaind = $conx->query($sqlind);
									$numind=$conx->get_numRecords($consultaind);
									$numindest=0;
									while ($rowind = $conx->records_array($consultaind)) {
										$sqldelinselect="SELECT * FROM indicadoresestudiante WHERE idindicador='".$rowind['consecutivo']."'
										and aniolectivo=$aniolect and periodo=$periodo and idestudiante='$id' and idmateria=$idmateria";
										$consultaindselect = $conx->query($sqldelinselect);
										if($rowindselect = $conx->records_array($consultaindselect)){
											$numindest++;
										}
									}
									
									//---fin verificar si ya se ha calificado
									//verificando si se ingreso nota del estudiante
									/*$sqldata1 = "SELECT DISTINCT e.idestudiante, e.nombre1, e.nombre2, e.apellido1, e.apellido2, n.* FROM estudiante e, notas n 
									WHERE e.idestudiante='$id' AND e.idestudiante=n.idestudiante  AND n.aniolectivo=$aniolect 
									AND n.tipo_nota='R' AND n.periodo=$periodo AND n.idmateria=$idmateria ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
									$consultadata1 = $conx->query($sqldata1);
									$numnota=$conx->get_numRecords($consultadata1);*/
									//fin verificando nota
									//mensajes 
									$promedioFinal1=promedioAnioAlg2MateriaNV($id, $idaula, $aniolect, 1, 2,$idmateria);
									$promedioFinal2=promedioAnioAlg2MateriaNV($id, $idaula, $aniolect, 3, 4,$idmateria);
									$numnota = round(($promedioFinal1+$promedioFinal2)/2,1, PHP_ROUND_HALF_UP);
									$msjest="";
									if($numindest<$numind and $numnota>0){
										$msjest="background-color:orange;";
									}elseif($numindest<$numind and $numnota<=0){
										$msjest="background-color:red;";
									}else{
										$msjest="background-color:#2EFE2E;";
									}
									//fin mensajes
								}elseif($periodo=='s1'){
									
									$sqlnota="SELECT ROUND( AVG( vn ) , 1 ) AS nota, (SUM(fj)+SUM(fsj)) AS faltas  FROM notas WHERE 
									periodo <= 2 AND tipo_nota = 'R' AND aniolectivo = '$aniolect' 
									AND idmateria = '".$rowindest['idmateria']."' AND idestudiante='".$row2['idestudiante']."'
									GROUP BY idestudiante";
									$nota=promedioSemMateria($row2['idestudiante'], $idaula, $aniolect, 1, 2,$rowindest['idmateria']);

								}elseif($periodo=='s2'){
									$sqlnota="SELECT ROUND( AVG( vn ) , 1 ) AS nota, (SUM(fj)+SUM(fsj)) AS faltas  FROM notas WHERE 
									(periodo >= 3 and periodo <= 4) AND tipo_nota = 'R' AND aniolectivo = '$aniolect' 
									AND idmateria = '".$rowindest['idmateria']."' AND idestudiante='".$row2['idestudiante']."'
									GROUP BY idestudiante";
									$nota=promedioSemMateria($row2['idestudiante'], $idaula, $aniolect, 3, 4,$rowindest['idmateria']);
								}elseif($periodo=='F'){
									$sqlnota="SELECT ROUND( AVG( vn ) , 1 ) AS nota, (SUM(fj)+SUM(fsj)) AS faltas  FROM notas WHERE 
									periodo <= 4 AND tipo_nota = 'R' AND aniolectivo = '$aniolect' 
									AND idmateria = '".$rowindest['idmateria']."' AND idestudiante='".$row2['idestudiante']."'
									GROUP BY idestudiante";
									$nota=promedioAnioSemMateria($row2['idestudiante'], $idaula, $aniolect, $rowindest['idmateria']);
								}
								$consultanota = $conx2->query($sqlnota);
								if ($rownota = $conx2->records_array($consultanota)) {
									if($periodo>=1 and $periodo<=4){
										
										if($rownota['nota']<3.0){
											$msjest="background-color:B22222;";
										}
										echo "<td align='center' style='$msjest'>".$rownota['nota']."</td>";
									}else{
										if($nota<3.0){
											$msjest="background-color:B22222;";
										}
										echo "<td align='center' style='$msjest'>".$nota."</td>";
									}
									
									$faltas+=$rownota['faltas'];
								}else{
									echo "<td align='center' style='background-color:#D8D8D8;'></td>";
								}

							}
							if($periodo>=1 and $periodo<=4){
								$puesto=puestoPeriodoAlg2($row2['idestudiante'], $idaula, $aniolect, $periodo);
								$promedio=promedioPeriodoAlg2($row2['idestudiante'], $idaula, $aniolect, $periodo);
							}elseif($periodo=='s1'){
								$puesto=puestoAnioAlg2($row2['idestudiante'], $idaula, $aniolect, 1, 2);
								$promedio=promedioAnioAlg2($row2['idestudiante'], $idaula, $aniolect, 1, 2);
							}elseif($periodo=='s2'){
								$puesto=puestoAnioAlg2($row2['idestudiante'], $idaula, $aniolect, 3, 4);
								$promedio=promedioAnioAlg2($row2['idestudiante'], $idaula, $aniolect, 3, 4);
							}elseif($periodo=='F'){
								$puesto=puestoAnioSem($row2['idestudiante'], $idaula, $aniolect);
								$promedio=promedioAnioSem($row2['idestudiante'], $idaula, $aniolect);
							}
							$bckg='#FFFFFF';
							if($puesto<6){
								$bckg='#00FF99';
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
						$sqlindest = "SELECT m.*  FROM clase c, materia m WHERE c.idaula = '$idaula' AND c.aniolectivo = '2015'
										AND m.idmateria=c.idmateria
										ORDER BY c.idmateria ASC;";
						$consultaindest = $conx2->query($sqlindest);
						while ($rowindest = $conx2->records_array($consultaindest)) {
							echo "<td align='center'>".$rowindest['abreviatura']."</td>";

						}
						echo "<td>Faltas</td>";
						echo "<td>Puesto</td>";
						echo "<td>Promedio</td>";
						echo "</tr>";
						$lineasimpresas=0;
					}
					echo "</table>";
					echo "</br></br></br></br><div align='center'>
					<span style='font:15px Arial, sans-serif; font-weight:bold;'>".$row['nombre1']." ".$row['nombre2']." ".$row['apellido1']."</span><br/>
					<span style='font:12px bold arial,sans-serif; font-weight:bold;'>FIRMA</span></div>";
					echo "<span align='center'>
						<input type='button' id ='btnguardar' value='Imprimir' onclick='javascript: void window.print()'/>
					</span>
				</form>
				</div>";
				echo "<h1 class='SaltoDePagina'></h1>";
			}
			
		}
	?>
	
	</body>
</html>
