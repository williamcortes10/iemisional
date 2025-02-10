<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
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
		$conx = new ConxMySQL("localhost","root","","appacademy");
		$aniolect= $_POST['aniolect'];
	
	?>
		<div class="bg_img"><img src="../../images/1.jpg" alt="background" /></div>
		<h1>APP ACADEMY<span>La manera mas facil de administrar sus notas y boletines academicos</span>
		<span>Derechos reservados: williamcortes10@gmail.com</span></h1>
		</div><div class="tabla" id='aniolectdiv'>
		<label style='margin:50px; font-weight:bold'> Año lectivo </label>
		<form method='POST' action='listado_indicadoresseleccionados.php'>
			<select  id="aniolect" name='aniolect'>
			  <?php
				for($i=2012; $i>1990; $i--){
					if($i==$aniolect){
						echo "<option value='".$i."' selected>".$i."</option>";
					}else{
						echo "<option value='".$i."' >".$i."</option>";
					}
				}
			  ?>
			</select>
			<input type='submit' value='Mostrar'> 			
		</form>
		</div>
		<div class="tabla">
			<table>
			<?php
				if($aniolect){	
					$sql = "Select Distinct d.iddocente, d.nombre1, d.nombre2, d.apellido1, d.apellido2
					From docente d, indicadoresboletin ib WHERE d.iddocente=ib.iddocente 
					AND ib.aniolectivo=$aniolect";
					$consulta = $conx->query($sql);
					if($conx->get_numRecords($consulta)>0){
						echo "<tr><td class='estilocelda' colspan='8'>Informe  - Indicadores Selecionados Por Docentes</td></tr>";
						while ($row = $conx->records_array($consulta)) {
							$sumih=0;
							echo "<tr><th colspan='4' style='text-align:left'>DOCENTE: ".$row['nombre1'].' '.$row['nombre2'].' '.$row['apellido1'].' '.$row['apellido2']."</th>";
							$sqlreporte= "SELECT DISTINCT i.idindicador, i.tipo, i.descripcion, i.habilitado, 
							i.compartido, a.grado, a.grupo, m.nombre_materia, ib.aniolectivo 
							FROM indicadores i, aula a, materia m, indicadoresboletin ib   
							WHERE i.idpropietario=".$row['iddocente']." AND i.idmateria=m.idmateria AND 
							i.idaula=a.idaula AND ib.iddocente=i.idpropietario 
							AND ib.aniolectivo=$aniolect ORDER BY m.nombre_materia,grado, grupo, tipo";
							$consultareporte = $conx->query($sqlreporte);
							echo "<tr><td style='font-weight:bold'>Asignatura</td>
							<td style='font-weight:bold'>Idindicador</td>
							<td style='font-weight:bold'>Tipo</td>
							<td style='font-weight:bold'>Descripcion</td>
							<td style='font-weight:bold'>Grado</td>
							<td style='font-weight:bold'>Habilitado</td>
							<td style='font-weight:bold'>Compartido</td>
							<td style='font-weight:bold'>Año Lectivo</td>";
							while ($rowreporte = $conx->records_array($consultareporte)) {
								echo "<tr>";
								echo "<td>".$rowreporte['nombre_materia']."</td>";
								echo "<td>".$rowreporte['idindicador']."</td>";
								echo "<td>".$rowreporte['tipo']."</td>";
								echo "<td>".$rowreporte['descripcion']."</td>";
								echo "<td>".$rowreporte['grado']."-G".$rowreporte['grupo']."</td>";
								echo "<td>".$rowreporte['habilitado']."</td>";
								echo "<td>".$rowreporte['compartido']."</td>";
								echo "<td>".$rowreporte['aniolectivo']."</td>";
								echo "</tr>";
							}
							echo "<tr><th><br/></th></tr>";
						}
							
					} else {
						echo "No Existen Indicadores";
					}
				}
			  ?>
			  
			</table>

			<span>
				<a href='../../index.php' class='large button orange' style='font-size: 12px !important;'><img src="../../images/back.png" id="back" alt="Regresar" /></a>
			</span>
			<span>
				<a href='javascript: void window.print()' class='large button orange' style='font-size: 12px !important;'><img src="../../images/printer.png" id="printer" /></a>
			</span>
		</div>
	</body>
</html>