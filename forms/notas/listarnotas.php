<?php
session_start();
?>
<html>
    <head>
        
        <meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; "/>
		<title> INFORME DE NOTAS - PLANILLA</title>
        <meta name="description" content="" />
        <meta name="keywords" content=""/>
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
		<link rel="stylesheet" href="../../css/form.css" type="text/css" media="screen"/>
		<script type="text/javascript" src="../../script/jquery.min.js"></script>
		<script type="text/javascript" src="../../script/tooltip.js"></script>
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
				margin:0 auto 0 auto; 
				width:1000px;
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
				background-color:F5AC54; 
				color:333333; 
				font-weight:bold; 
				font-size:13pt; 
				text-align: center;
			} 
			.estilocelda2{ 
				font-size:10pt; 
			} 
			#printer {
			  width: 28px;
			  height: 28px;
			}
			#back {
			  width: 28px;
			  height: 28px;
			}
			.SaltoDePagina {
				page-break-after: always;
				
			}
	</style>
    </head>

    <body>
	<?php
		include("../../class/MySqlClass.php");
		include('../../bdConfig.php');
			
	?>
		<div class="bg_img"><img src="../../images/1.jpg" alt="background" /></div>
		<h1>APP ACADEMY<span>La manera mas facil de administrar sus notas y boletines academicos</span>
		<span>Derechos reservados: williamcortes10@gmail.com</span></h1>
		</div>
		<?php
		$look=false;
		if (isset($_SESSION['k_username'])) {
			$conx2 = new ConxMySQL($dominio,$usuario,$pass,$bd);
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
		$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
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
		$idaula = $_GET['idaula'];
		$sql = "SELECT descripcion, grupo, grado FROM aula WHERE idaula = '$idaula'";
		$consulta = $conx->query($sql);    
		$records = $conx->records_array($consulta);
		$curso = ($records['descripcion']);
		$grado = $records['grado'];
		$sql = "SELECT num_periodos, tipo_periodo FROM periodos_por_anio WHERE anio = '$aniolect'";
		$consulta = $conx->query($sql);    
		$records = $conx->records_array($consulta);
		$num_periodos = $records['num_periodos'];
		
		echo "<div class='tabla'>
		<form id='notas' method='POST' action='guardarnotas_response.php'>
		<table class='tabla'>";
				$periodo = $_GET['periodo'];
				if(isset($_GET['promediar'])){
					switch($periodo){
						case 2: $periodo=12; break;
						case 3: $periodo=13; break;
						case 4: $periodo=14; break;
						default: break;
					}
				}
				$idmateria = $_GET['idmateria'];
				$aniolect = $_GET['aniolectivo'];
				$aniolectivo = $_GET['aniolectivo'];
				$iddocente = $_GET['id'];
				
				//Recuperamos el numero de decimales configurados para el año lectivo
				$sql = "SELECT numero_decimales from redondeo_decimal where anio_lectivo=$aniolectivo LIMIT 1";
				$consulta = $conx->query($sql);    
				$records = $conx->records_array($consulta);
				$numero_decimales = $records['numero_decimales'];
				if(empty($numero_decimales)){
					$numero_decimales = 1;
				}
				//area
				$sqlarea ="SELECT idarea_fk  FROM materia WHERE idmateria = '$idmateria'";
				$qarea = $conx->query($sqlarea);
				$rowarea = $conx->records_array($qarea);
				$area=$rowarea['idarea_fk'];
				$tn = "R";
				$flag=false;
				$numreg=0;
				$lineasxhoja=0;
				
				if($tn=='R'){
					$txt='Regulares';
				}elseif($tn=='N'){
					$txt='Nivelacion';
				}
								
				$sql1 = "SELECT DISTINCT nombre1, nombre2, apellido1, apellido2, m.nombre_materia, 
				a.grado, a.grupo, a.descripcion FROM docente d, clase c, materia m, aula a 
				WHERE d.iddocente='$iddocente' AND c.iddocente=d.iddocente AND c.idmateria= $idmateria AND m.idmateria=c.idmateria 
				AND c.idaula=$idaula AND c.idaula=a.idaula";
				$consulta2 = $conx2->query($sql1);
				$row = $conx2->records_array($consulta2);
				echo ("<tr><td class='estilocelda' colspan='12'>$ie<br/>$lema<br/>$ciudad-$departamento</td></tr>");
				if($periodo<5){
					echo "<tr><td class='estilocelda' colspan='12'>Informe De Notas";
				}else{
					switch($periodo){
						case 12: echo "<tr><td class='estilocelda' colspan='12'>Informe De Notas - Promedio hasta el 2do periodo"; break;
						case 13: echo "<tr><td class='estilocelda' colspan='12'>Informe De Notas - Promedio hasta el 3er periodo"; break;
						case 14: echo "<tr><td class='estilocelda' colspan='12'>Informe De Notas - Promedio hasta el 4to periodo"; break;
					}
					
					
				}
					if($tn=='N'){
						echo '-Nivelacion';
					}
				echo "</td></tr>";
				echo "<tr><td colspan='7' class='estilocelda2'>Docente:".($row['nombre1'])." ".($row['nombre2'])." ".($row['apellido1'])." ".($row['apellido2'])."</td>
				<td align='' colspan='3' class='estilocelda2'>Materia:".($row['nombre_materia'])."</td>";
				if($periodo<5){
					echo "<td align='right' colspan=''>Periodo:$periodo</td></tr>";
				}else{
					echo "<td align='right' colspan=''></td></tr>";
					
				}
				echo "<tr><td colspan='3' class='estilocelda2'>Año Lectivo:$aniolect</td><td colspan=''>Grado:".$row['descripcion']."-Grupo".$row['grupo']."</td></tr>";
				if($periodo<5){
					echo "<tr ><td colspan='12' align='center' class='estilocelda2' ><b>COMPETENCIAS DE APRENDIZAJE SELECCIONADOS</b></td></tr>
					<tr><td colspan='2' class='estilocelda2'><b>CODIGO</b></td><td colspan='10' class='estilocelda2'><b>COMPETENCIA DE APRENDIZAJE";
					if($aniolect<2015 or $idmateria==27){
						echo "</b></td></tr>";
					}else{
						echo " | F=Fortaleza   D= Debilidad</b></td></tr>";
					}
				}
				
				$lineasxhoja+=9;
				/*$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
				pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
				FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
				(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
				and pc.estandarbc=ebc.codigo
				and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolect
				and eb.periodo =$periodo and eb.iddocente ='$iddocente' and eb.grado ='$grado'
				and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area
				ORDER BY consecutivo DESC";*/
				if($periodo<5){
					if($aniolectivo<2016){
						$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
								pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
								FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
								(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
								and pc.estandarbc=ebc.codigo
								and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
								and eb.periodo =$periodo and eb.iddocente ='$iddocente' and eb.grado ='$grado'
								and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
								ORDER BY consecutivo DESC";
					}else{
						$sqlind = "SELECT DISTINCT pc.consecutivo, pc.grados, pc.competencia, 
								pc.estandarbc, ebc.descripcion, eb.periodo, eb.aniolectivo 
								FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
								(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
								and pc.estandarbc=ebc.codigo
								and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
								and eb.periodo =$periodo and eb.grado ='$grado'
								and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
								ORDER BY consecutivo DESC";
					}
					$consultaind = $conx->query($sqlind);
					while ($rowind = $conx->records_array($consultaind)) {
						echo "<tr><td colspan='2' class='estilocelda2'>".$rowind['consecutivo']."</td><td colspan='10' class='estilocelda2'>".($rowind['competencia'])."</td>";
						echo "</tr>";
						$lineasxhoja++;
					}
				}
				echo "</span></table><br/>";
				echo "<table class='tabla'>";
				echo "<tr align='center' class='tabla'>";
				if($periodo<5){
					$sql = "SELECT n.*, e.* FROM notas n, estudiante e, matricula m WHERE n.periodo = $periodo 
					AND n.tipo_nota ='$tn' AND n.aniolectivo = $aniolect AND n.idmateria = $idmateria 
					AND e.idestudiante=n.idestudiante AND m.idestudiante=n.idestudiante 
					AND n.tipo_nota=m.tipo_matricula AND m.idaula=$idaula AND m.aniolectivo=n.aniolectivo 
					ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
					echo "<td class='estilocelda2'>Nro.</td><td class='estilocelda2'>Estudiante</td><td>COMPETENCIA DE APRENDIZAJE</td><td class='estilocelda2'>V.N</td><td class='estilocelda2'>Faltas J</td><td class='estilocelda2'>Faltas S.J</td><td class='estilocelda2'>Observaciones</td>";
				}else{
					switch($periodo){
						case 12: $periodo_promedio=2; break;
						case 13: $periodo_promedio=3; break;
						case 14: $periodo_promedio=4; break;
						
						
					}
					$sql = "SELECT ROUND( SUM( vn )/$periodo_promedio ,1) AS vn, SUM(n.fj) AS fj, SUM(n.fsj) AS fsj, n.observaciones, e.* FROM notas n, estudiante e, matricula m 
					WHERE n.periodo <= $periodo_promedio 
					AND n.tipo_nota ='$tn' AND n.aniolectivo = $aniolect AND n.idmateria = $idmateria 
					AND e.idestudiante=n.idestudiante AND m.idestudiante=n.idestudiante 
					AND n.tipo_nota=m.tipo_matricula AND m.idaula=$idaula AND m.aniolectivo=n.aniolectivo 
					GROUP BY n.idestudiante ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2 ";
					echo "<td class='estilocelda2'>Nro.</td><td class='estilocelda2'>Estudiante</td><td class='estilocelda2'>Promedio</td><td class='estilocelda2'>Faltas J</td><td class='estilocelda2'>Faltas S.J</td>";
				}
				//die($sql);
				echo "</tr>";
				$numero=0; 	
				$lineasxhoja++;
				
				
				$consulta = $conx2->query($sql);
				$numreg = $conx2->get_numRecords($consulta);
				$numpag=$cantestxhoja;
				$pag=1;
				while ($row2 = $conx2->records_array($consulta)) {
					$numlineasobs=0;
					$lineasxhoja++;
					$numlineasobs+=ceil(strlen($row2['observaciones'])/25);
					$lineasxhoja+=$numlineasobs;
					if($lineasxhoja>=52){
						echo "</table></div>";
						echo "<h1 class='SaltoDePagina'></h1>";
						echo "<div class='tabla'><table class='area'>";
						echo "<tr align='center' class='tabla'>";
						if($periodo<5){
							echo "<td class='estilocelda2'>Nro.</td><td class='estilocelda2'>Estudiante</td><td>COMPETENCIA DE APRENDIZAJE</td><td class='estilocelda2'>V.N</td><td class='estilocelda2'>Faltas J</td><td class='estilocelda2'>Faltas S.J</td><td class='estilocelda2'>Observaciones</td>";
						}else{
							echo "<td class='estilocelda2'>Nro.</td><td class='estilocelda2'>Estudiante</td><td class='estilocelda2'>Promedio</td><td class='estilocelda2'>Faltas J</td><td class='estilocelda2'>Faltas S.J</td>";
						}
						echo "</tr>";
						$lineasxhoja=1;
					}
					echo "<tr>";
						echo "<td align='center' class='estilocelda2'>".++$numero."</td>";
						echo "<td width='400px' class='estilocelda2'>".(($row2['apellido1'])." ".($row2['apellido2'])." ".($row2['nombre1']))." ".($row2['nombre2'])."</td>";
						if($periodo<5){
							echo "<td align='center' width='250px' class='estilocelda2'>";
							
							if($aniolectivo<2016){
								$sqlindest = "SELECT ie.* FROM indicadoresestudiante ie WHERE ie.idestudiante='".$row2['idestudiante']."'
								AND ie.aniolectivo=$aniolect AND ie.periodo=$periodo
								AND ie.idindicador IN (SELECT DISTINCT pc.consecutivo FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
								(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
								and pc.estandarbc=ebc.codigo
								and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolect
								and eb.periodo =$periodo and eb.iddocente ='$iddocente' and eb.grado ='$grado'
								and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area							
								ORDER BY consecutivo DESC)
								and ie.idmateria=$idmateria
								ORDER BY idindicador ASC";
							}else{
								$sqlindest = "SELECT ie.* FROM indicadoresestudiante ie WHERE ie.idestudiante='".$row2['idestudiante']."'
								AND ie.aniolectivo=$aniolect AND ie.periodo=$periodo
								AND ie.idindicador IN (SELECT DISTINCT pc.consecutivo
								FROM plan_curricular pc, estandares ebc, indicadoresboletin eb, materia m WHERE  
								(pc.gradoinicio<='$grado' and pc.gradofinal>='$grado') 
								and pc.estandarbc=ebc.codigo
								and eb.idindicador=pc.consecutivo and eb.aniolectivo =$aniolectivo
								and eb.periodo =$periodo and eb.grado ='$grado'
								and ebc.idmateria_fk=m.idmateria and m.idarea_fk=$area and eb.idmateria=$idmateria
								ORDER BY consecutivo DESC)
								and ie.idmateria=$idmateria
								ORDER BY idindicador ASC";
							}
							$consultaindest = $conx2->query($sqlindest);
							while ($rowindest = $conx2->records_array($consultaindest)) {
								echo "<span class='estilocelda2' style='font-size:15px; padding:2px; background-color:#E6E6E6;  border: 1px dashed #C60;'>".$rowindest['idindicador']."(".$rowindest['nivel_aprendizaje'].")</span>";
							}
							echo "</td>";
						}
						$vn_nota = number_format($row2['vn'], $numero_decimales);	
						if($vn_nota<3){
							echo "<td align='center' class='estilocelda2' bgcolor='gray'>".$vn_nota."</td>";
						}else{
							echo "<td align='center' class='estilocelda2'>".$vn_nota."</td>";
						}
						
						echo "<td align='center' class='estilocelda2'>".$row2['fj']."</td>";
						echo "<td align='center' class='estilocelda2'>".$row2['fsj']."</td>";
						if($periodo<5){
							echo "<td align='center' width='300px' class='estilocelda2'>".($row2['observaciones'])."</td>";
						}
					echo "</tr>";
					
				}
			  
			echo "</table><br/>";
			echo "</br></br><div align='center'>
			<span style='font:15px Arial, sans-serif; font-weight:bold;'>".$row['nombre1']." ".$row['nombre2']." ".$row['apellido1']."</span><br/>
			<span style='font:12px bold arial,sans-serif; font-weight:bold;'>FIRMA</span></div>";
			echo "<span align='center'>
				<input type='button' id ='btnguardar' value='Imprimir' onclick='javascript: void window.print()'/>
			</span>
		</form>
		</div>";
		}
	?>
	<div align='center'>
			<span align='center'>
				<a href='listarcalificaciones.php' class='large button orange' style='font-size: 12px !important;'><img src='../../images/back.png' id='back' alt='Regresar' /></a>
			</span>
            <span class="reference">
				<?php
					if(isset($records2)){
					echo "<img src='../../images/profile.png'><a>Usuario: ".($records2['apellido1'])." ".($records2['nombre1'])."
				     </a><a href='../../docente/logout.php'>Salir</a>";
					}
				?>
                <a href="http://tympanus.net/codrops/2010/11/25/overlay-effect-menu/">Derechos reservados</a>
				<a href="http://www.flickr.com/photos/duke9042004/" target="_blank">williamcortes10@gmail.com</a>
            </span>
		</div>
	</body>
</html>
