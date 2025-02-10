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
	
	?>
		<div class="bg_img"><img src="../../images/1.jpg" alt="background" /></div>
		<h1>APP ACADEMY<span>La manera mas facil de administrar sus notas y boletines academicos</span>
		<span>Derechos reservados: williamcortes10@gmail.com</span></h1>
		</div>
		<div class="tabla">
			<table>
			<?php
				$sql = "Select iddocente, nombre1, nombre2, apellido1, apellido2, profesion, email
				From docente";
				$consulta = $conx->query($sql);
				if($conx->get_numRecords($consulta)>0){
					echo "<tr><td class='estilocelda' colspan='4'>Informe  - Lista de Docentes</td></tr>";
					echo "<tr><th>Identificacion</th><th>Nombres y Apellidos</th><th>Profesion</th><th>Email</th></tr>";
					while ($row = $conx->records_array($consulta)) {
						echo "<tr>";
						echo "<td>".$row['iddocente']."</td>";
						echo "<td>".$row['nombre1'].' '.$row['nombre2'].' '.$row['apellido1'].' '.$row['apellido2']."</td>";
						echo "<td>".$row['profesion']."</td>";
						echo "<td>".$row['email']."</td>";
						echo "</tr>";
					}
						
				} else {
					echo "No existen usuarios";
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