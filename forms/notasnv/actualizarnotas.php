<?php
session_start();
?>
<html>
    <head>
        <title> ACTUALIZAR NOTAS NIVELACION - PLANILLA</title>
        <meta http-equiv="Content-Type" content="text/html; "/>
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
				color:#aaa;
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
		include("../../class/ultimatemysql/mysql.class.php");
		include("../../class/MySqlClass.php");
		$conx = new ConxMySQL("localhost","root","","appacademy");
			
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
		$estudiantes= explode(",", $_GET['estudiantes'] );
		if($look and !empty($estudiantes[0])){
		echo "<div class='tabla'>
		<form id='notas' method='POST' action='actualizarnotas_response.php'>
		<table class='tabla'>";
				$periodo = $_GET['periodo'];
				$idmateria = $_GET['idmateria'];
				$aniolect = $_GET['aniolect'];
				$docente = $_GET['docente'];
				$idaula = $_GET['idaula'];
				$flag=false;
				$numreg=0;
				$sqlescala ="SELECT rango_superior FROM escala_de_calificacion WHERE tipo_escala='DS'";
				$qescala = $conx->query($sqlescala);
				$rowescala = $conx->records_array($qescala);
				$escalas=$rowescala['rango_superior'];
				$sqlescala ="SELECT rango_inferior FROM escala_de_calificacion WHERE tipo_escala='D-'";
				$qescala = $conx->query($sqlescala);
				$rowescala = $conx->records_array($qescala);
				$escalai=$rowescala['rango_inferior'];
				
				$sql1 = "SELECT DISTINCT nombre1, nombre2, apellido1, apellido2, m.nombre_materia, 
				a.grado, a.grupo FROM docente d, clase c, materia m, aula a 
				WHERE d.iddocente='$docente' AND c.iddocente=d.iddocente AND c.idmateria= $idmateria AND m.idmateria=c.idmateria 
				AND c.idaula=$idaula AND c.idaula=a.idaula";
				$consulta = $conx->query($sql1);
				$row = $conx->records_array($consulta);
				echo "<tr><td class='estilocelda' colspan='4'>Actualizar Notas - Nivelacion</td></tr>";
				echo "<tr><td>Docente:".utf8_decode($row['nombre1'])." ".utf8_decode($row['nombre2'])." ".utf8_decode($row['apellido1'])." ".utf8_decode($row['apellido2'])."</td>
				<td align='right'>Materia:".utf8_decode($row['nombre_materia'])."</td></tr>";
				echo "<tr><td>A�o Lectivo:$aniolect</td>
				<td align='right'>Periodo:$periodo</td></tr>";
				echo "<tr><td colspan='2'>Grado:".$row['grado']."-G".$row['grupo']."</td></tr></table><br/>";
				echo "<table class='tabla'>";
				echo "<tr align='center' class='tabla'>";
				echo "<td>Nro.</td><td>Estudiante</td><td>V.N</td><td>Faltas J</td><td>Faltas S.J</td><td>Comportamiento</td><td>Observaciones</td>";
				echo "</tr>";
				$numero=0;
				if(!empty($_GET['estudiantes'])){
					foreach( $estudiantes as $id){
						echo "<tr>";
						$sql1 = "SELECT DISTINCT e.idestudiante, e.nombre1, e.nombre2, e.apellido1, e.apellido2, n.* FROM estudiante e, notas n 
						WHERE e.idestudiante='$id' AND e.idestudiante=n.idestudiante  AND n.aniolectivo=$aniolect 
						AND n.tipo_nota='N' AND n.periodo=$periodo AND n.idmateria=$idmateria ORDER BY e.apellido1, e.apellido2, e.nombre1, e.nombre2";
						$consulta = $conx->query($sql1);
						if($row = $conx->records_array($consulta)){
							echo "<td align='center'>".++$numero."</td>";
							echo "<td width='400px'>".$row['apellido1']." ".$row['apellido2']." ".$row['nombre1']." ".$row['nombre2']."</td>";
							echo "<td align='center'><input type='text' id='vn$id' name='vn$id' size='2' maxlength='4' value='".$row['vn']."'/></td>";
							echo "<td align='center'><input type='text' id='fj$id' name='fj$id' size='2' maxlength='4' value='".$row['fj']."'/></td>";
							echo "<td align='center'><input type='text' id='fsj$id' name='fsj$id' size='2' maxlength='4' value='".$row['fsj']."'/></td>";
							echo "<td align='center'><select id='comp$id' name='comp$id'>";
												if($row['comportamiento']=='DS'){
													echo "<option value='DS' seleted>DS</option>
													<option value='DA'>DA</option>
													<option value='DB'>DB</option>
													<option value='D-'>Db</option>";
												}elseif($row['comportamiento']=='DA'){
													echo "<option value='DS'>DS</option>
													<option value='DA' seleted>DA</option>
													<option value='DB'>DB</option>
													<option value='D-'>Db</option>";
												}elseif($row['comportamiento']=='DB'){
													echo "<option value='DS'>DS</option>
													<option value='DA'>DA</option>
													<option value='DB' seleted>DB</option>
													<option value='D-'>Db</option>";
												}elseif($row['comportamiento']=='D-'){
													echo "<option value='DS'>DS</option>
													<option value='DA'>DA</option>
													<option value='DB'>DB</option>
													<option value='D-' seleted>Db</option>";
												}				
												echo "</select></td>";
							if($row['observaciones']==NULL){
								echo "<td align='center' width='300px'><textarea id='obs$id' name='obs$id' cols='30' rows='5' class='toolTip' title='Desactive la casilla para ingresar un aobservaci�n' readonly></textarea>
								<input type='checkbox' id='idestudiante[]' name='idestudiante[]' value='$id' checked ></td>";
							}else{
								echo "<td align='center' width='300px'><textarea id='obs$id' name='obs$id' cols='30' rows='5' class='toolTip' title='Desactive la casilla para ingresar un aobservaci�n' >".$row['observaciones']."</textarea>
								<input type='checkbox' id='idestudiante[]' name='idestudiante[]' value='$id'></td>";
							}
							echo "<input type='hidden' id='listdestudiante[]' name='listdestudiante[]' value='$id'></td>
							<input type='hidden' id='periodo' name='periodo' value='$periodo'></td>
							<input type='hidden' id='idmateria' name='idmateria' value='$idmateria'></td>
							<input type='hidden' id='aniolect' name='aniolect' value='$aniolect'></td>";
							echo "</tr>";
							echo "<script>
								$(document).ready(function(){
									$('#vn$id').change(function(e){
										e.preventDefault();
										var num = $('#vn$id').val();
										var valor = parseFloat(num);
										if(isNaN(valor)){
											alert('Debe ingresar un numero');
											$('#vn$id').focus();
											$('#vn$id').val('');
										}else{
											if(valor<$escalai || valor>$escalas){
												alert('El valor ingresado no esta dentro del rango configurado');
												$('#vn$id').focus();
												$('#vn$id').val('');
												
											}
										}
									});
									
									$('#fj$id').change(function(e){
										e.preventDefault();
										var num = $('#fj$id').val();
										var valor = parseInt(num);
										if(isNaN(valor)){
											alert('Debe ingresar un numero');
											$('#fj$id').focus();
											$('#fj$id').val('0');
										}else{
											if(valor<0){
												alert('El valor ingresado ser mayor o igual a cero');
												$('#fj$id').focus();
												$('#fj$id').val('0');
												
											}
										}
									});
									$('#fsj$id').change(function(e){
										e.preventDefault();
										var num = $('#fsj$id').val();
										var valor = parseInt(num);
										if(isNaN(valor)){
											alert('Debe ingresar un numero');
											$('#fsj$id').focus();
											$('#fsj$id').val('0');
										}else{
											if(valor<0){
												alert('El valor ingresado ser mayor o igual a cero');
												$('#fsj$id').focus();
												$('#fsj$id').val('0');
												
											}
										}
									});
								});
							</script>";
						}
						
					}
				}
							
			echo "</table>

			<span align='center'>
				<input type='submit' id ='btnguardar' value='Actualizar'/>
			</span>
		</form>
		</div>";
	}
	?>
	<div align='center'>
			<span align='center'>
				<a href='buscar_estudiante.php' class='large button orange' style='font-size: 12px !important;'><img src='../../images/back.png' id='back' alt='Regresar' /></a>
			</span>
            <span class="reference">
				<?php
					if(isset($records2)){
					echo "<img src='../../images/profile.png'><a>Usuario: ".utf8_decode($records2['apellido1'])." ".utf8_decode($records2['nombre1'])."
				     </a><a href='../../docente/logout.php'>Salir</a>";
					}
				?>
                <a href="http://tympanus.net/codrops/2010/11/25/overlay-effect-menu/">Derechos reservados</a>
				<a href="http://www.flickr.com/photos/duke9042004/" target="_blank">williamcortes10@gmail.com</a>
            </span>
	</div>
	</body>
</html>
