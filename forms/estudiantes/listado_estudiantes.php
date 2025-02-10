<?php
session_start();
?>
<html>
    <head>
        <title>LISTADO ESTUDIANTES</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="description" content="" />
        <meta name="keywords" content=""/>
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
		<link rel="stylesheet" href="../../css/form.css" type="text/css" media="screen"/>
		<script type="text/javascript" src="../../script/jquery.min.js"></script>
		<script type="text/javascript">
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
			.tabla , .tabla td , .tabla tr{
				margin:0 auto 0 auto; 
				width:900;
				color: black;
                border: 1px solid #000;
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
		$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
	
	?>
		<div class="bg_img"><img src="../../images/1.jpg" alt="background" /></div>
		<h1>APP ACADEMY<span>La manera mas facil de administrar sus notas y boletines academicos</span>
		<span>Derechos reservados: williamcortes10@gmail.com</span></h1>
		</div><?php
		$look=false;
		
		if (isset($_SESSION['k_username'])) {
			

			$sql2 = "SELECT usuario.idusuario, docente.apellido1, docente.nombre1, usuario.tipousuario 
			FROM usuario, docente WHERE usuario.idusuario='".$_SESSION['k_username']."' AND docente.iddocente=usuario.idusuario 
			AND (usuario.tipousuario='S' OR usuario.tipousuario='A')";
			
			$consulta2 = $conx->query($sql2);
			if($conx->get_numRecords($consulta2)>0){
				$records2 = $conx->records_array($consulta2);
				$look=true;
			}
		}else{
			echo "<div class='form'>
					<div id='stylized' class='myform'><h3 align='center' style='color:black'>Debes Loguearte</h3><br/>";
			echo "<span align='center'><a href='../index.php' align='center'>Regresar</a></span></div></div>";
		}
		if($look){
			echo "<div class='tabla'>
				<table>";
					$sql = "Select * From estudiante Order By nombre1, nombre2, apellido1, apellido2";
					$consulta = $conx->query($sql);
					if($conx->get_numRecords($consulta)>0){
						echo "<tr><td class='estilocelda' colspan='7'>Informe  - Lista de Estudiantes</td></tr>";
						echo "<tr>";
						echo "<th>#</th><th>IDENTIFICACION</th><th>NOMBRES Y APELLIDOS</th><th>SEXO</th><th>FECHA NACIMIENTO</th>
						<th>TELEFONO</th><th>DIRECCION</th><th>HABILITADO</th>";
						echo"</tr>";
						$sumest=0;
						while ($row = $conx->records_array($consulta)) {
							$sumest++;
							echo "<tr><td>$sumest</td>";
							echo "<td>".$row['idestudiante']."</td>";
							echo "<td width='30%'>".$row['nombre1'].' '.$row['nombre2'].' '.$row['apellido1'].' '.$row['apellido2']."</td>";
							echo "<td>".$row['sexo']."</td>";
							echo "<td>".$row['fechanac']."</td>";
							echo "<td>".$row['telefono']."</td>";
							echo "<td>".$row['direccion']."</td>";
							echo "<td>".$row['habilitado']."</td>";
							
						}
						echo "<tr><td colspan='7' style='font-weight:bold'>Total estudiantes: $sumest</td></tr>";
							echo "<tr><th><br/></th></tr>";
										
					} else {
						echo "No se ha registrado Estudiantes";
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
		<div align='center'>
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