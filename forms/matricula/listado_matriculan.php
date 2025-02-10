<?php
session_start();
?>
<html>
    <head>
        <title>Listado Matriculas  </title>
        <meta http-equiv="Content-Type" content="text/html; "/>
        <meta name="description" content="" />
        <meta name="keywords" content=""/>
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
		<link rel="stylesheet" href="../../css/form.css" type="text/css" media="screen"/>
		<script type="text/javascript" src="../../script/jquery.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			$("#aniolectdiv").show();
			$("#printer").click(function(event) {
				$("#aniolectdiv").hide();
			
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
				height:20px;
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
			.tabla , .tabla td , .tabla tr{
				margin:0 auto 0 auto; 
				width:900;
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
			.estilocelda2{ 
				background-color:ddeeff; 
				color:333333; 
				font-weight:bold; 
				font-size:12pt; 
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
		include("../../class/ultimatemysql/mysql.class.php");
		include('../../bdConfig.php');
		//$conx = new ConxMySQL($dominio,$usuario,$pass,$bd)
		if (isset($_POST['aniolect'])) {
			$aniolect= $_POST['aniolect'];
		}else{
			$aniolect=date("Y");
		}
		if (isset($_POST['idaula'])) {
			$idaula= $_POST['idaula'];
		}else{
			$idaula="T";
		}
			
	?>
		<div class="bg_img"><img src="../../images/1.jpg" alt="background" /></div>
		<h1>APP ACADEMY<span>La manera mas facil de administrar sus notas y boletines academicos</span>
		<span>Derechos reservados: williamcortes10@gmail.com</span></h1>
		</div>
		<?php
 		$look=false;
		if (isset($_SESSION['k_username'])) {
			$conx2 = new ConxMySQL($dominio,$usuario,$pass,$bd)
			$sql2 = "SELECT idusuario, apellido1, nombre1, tipousuario FROM usuario, docente 
			WHERE idusuario='".$_SESSION['k_username']."' and iddocente=idusuario and (tipousuario='S' OR tipousuario='A')";
			die($sql2);
			$consulta2 = $conx2->query($sql2);
			if($conx2->get_numRecords($consulta2)>0){
				$records2 = $conx2->records_array($consulta2);
				$look=true;
				
			}
		}else{
			echo "<div class='form'>
					<div id='stylized' class='myform'><h3 align='center' style='color:black'>Debes Loguearte</h3><br/>";
			echo "<span align='center'><a href='../../index.php' align='center'>Regresar</a></span></div></div>";
		}
		if($look){
			$conx = new ConxMySQL($dominio,$usuario,$pass,$bd)
			echo "<div class='anio' id='aniolectdiv'>
			<label style='margin:50px; font-weight:bold'> Año lectivo </label>
			<form method='POST' action='listado_matriculan.php'>
				<select  id='aniolect' name='aniolect'>";
				  for($i=2012; $i>1990; $i--){
							if($i==$aniolect){
								echo "<option value='".$i."' selected>".$i."</option>";
							}else{
								echo "<option value='".$i."' >".$i."</option>";
							}
						}
				echo "</select><br/><br/><br/>";
				echo "<label style='margin:50px; font-weight:bold'>Grado escolar</label>
				<select  id='idaula' name='idaula'>";
				echo "<option value='T' selected>Todos</option>";
				$sql = "SELECT DISTINCT aula.* FROM aula ORDER BY idaula";
				if ($conx3->QueryArray($sql)) {
					$conx3->MoveFirst();
					while (! $conx3->EndOfSeek()) {
						$row3 = $conx3->Row();
						echo "<option value='".$row3->idaula."'>".
						$row3->grado."-G".$row3->grupo."</option>";
						
					}
						
				} else {
					echo "<option value='null'>No se han creado grados</option>";
				}
				echo	"</select><br/><br/><br/>";
				echo "<input type='submit' value='Mostrar'> 			
			</form>
			</div>
			<div class='tabla'>
			<table>";
					$sql = "SELECT * FROM aula ORDER BY grado, grupo";
					if($idaula!="T"){
							$sql="SELECT * FROM aula WHERE idaula=$idaula ORDER BY grado, grupo";
					}
					$consulta = $conx->query($sql);
					if($conx->get_numRecords($consulta)>0){
						echo "<tr><td class='estilocelda' colspan='4'>Informe  - Matricula Nivelacion Estudiantes</td></tr>";
						while ($row = $conx->records_array($consulta)) {
							$sumest=0;
							echo "<tr><th colspan='4' style='text-align:left'>clase: ".$row['grado'].'-'.$row['grupo']."</th>";
							$sqlreporte= "SELECT DISTINCT e.*, m.* FROM aula a, matricula m, estudiante e 
							WHERE e.idestudiante = m.idestudiante  AND m.tipo_matricula = 'N'
							AND aniolectivo='$aniolect' AND m.idaula = ".$row['idaula'];
							$consultareporte = $conx->query($sqlreporte);
							echo "<tr class='estilocelda2'><td style='font-weight:bold'>IDENTIFICACION</td><td style='font-weight:bold'>ESTUDIANTE</td><td style='font-weight:bold'>AÑO LECTIVO</td>";
							while ($rowreporte = $conx->records_array($consultareporte)) {
								echo "<tr>";
								echo "<td>".$rowreporte['idestudiante']."</td>";
								echo "<td>".$rowreporte['nombre1']." ".$rowreporte['nombre2']." ".$rowreporte['apellido1']." 
								".$rowreporte['apellido2']."</td>";
								echo "<td>".$rowreporte['aniolectivo']."</td>";
								echo "</tr>";
								$sumest++;
							}
							echo "<tr><td colspan='4' style='font-weight:bold'>Total estudiantes: $sumest</td></tr>";
							echo "<tr><th><br/></th></tr>";
						}
							
					} else {
						echo "No Existen matriculas";
					}
				  
				echo "</table>

				<span>
					<a href='../../index.php' class='large button orange' style='font-size: 12px !important;'><img src='../../images/back.png' id='back' alt='Regresar' /></a>
				</span>
				<span>
					<a href='javascript: void window.print()' class='large button orange' style='font-size: 12px !important;'><img src='../../images/printer.png' id='printer' /></a>
				</span>
			</div>";
		}
	?>
	
	</body>
</html>