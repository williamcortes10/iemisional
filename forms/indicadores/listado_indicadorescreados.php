<?php
session_start();
?>
<html>
    <head>
        <title>Listar indicadores</title>
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
			.tabla aniolectdiv{
				margin:0 auto; 
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
		$conx = new MySQL();
		if (! $conx->Open("appacademy", "localhost", "root", "")) {
			$conx->Kill();
		}
		if (isset($_POST['aniolect'])) {
			$aniolect= $_POST['aniolect'];
		}else{
			$aniolect=date("Y");
		}
		if (isset($_POST['iddocentes'])) {
			$iddocente= $_POST['iddocentes'];
		}else{
			$iddocente=0;
		}
		if (isset($_POST['materia'])) {
			$materia= $_POST['materia'];
		}else{
			$materia=0;
		}
		if (isset($_POST['grupo'])) {
			$grupo= $_POST['grupo'];
		}else{
			$grupo=0;
		}
		
	?>
		<div class="bg_img"><img src="../../images/1.jpg" alt="background" /></div>
		<h1>APP ACADEMY<span>La manera mas facil de administrar sus notas y boletines academicos</span>
		<span>Derechos reservados: williamcortes10@gmail.com</span></h1>
		</div>
		<?php
		include('../../class/MySqlClass.php');
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
			echo "<span align='center'><a href='../../index.php' align='center'>Regresar</a></span></div></div>";
		}
		if($look){
			echo "<div class='tabla' id='aniolectdiv'>
			
			<form method='POST' action='listado_indicadorescreados.php'>
			
				<label style='margin:50px; font-weight:bold'> Ano lectivo 
				<select  id='aniolect' name='aniolect'>";
					for($i=2020; $i>1990; $i--){
						if($i==$aniolect){
							echo "<option value='".$i."' selected>".$i."</option>";
						}else{
							echo "<option value='".$i."' >".$i."</option>";
						}
					}
				echo "</select></label><br/><br/><br/>
				<label style='margin:50px; font-weight:bold' >Docente
				<select  id='iddocentes' name='iddocentes'>";
				echo "<option value='0'>Todos</option>";
				$sql = "";
				if($records2['tipousuario']=='D'){
				$sql = "SELECT iddocente , nombre1, nombre2, apellido1 FROM docente 
				WHERE iddocente='".$_SESSION['k_username']."' ORDER BY iddocente";
				}elseif($records2['tipousuario']=='A'){
					$sql = "SELECT iddocente , nombre1, nombre2, apellido1 FROM docente 
					ORDER BY iddocente";
				}
				if ($conx->QueryArray($sql)) {
					$valor=$conx->RowCount();
					$conx->MoveFirst();
					while (! $conx->EndOfSeek()) {
						$row = $conx->Row();
						if($row->iddocente==$iddocente){
							echo "<option value='".$row->iddocente."' selected>".utf8_decode($row->nombre1)." ".utf8_decode($row->nombre2).
							" ".utf8_decode($row->apellido1)." ".utf8_decode($row->apellido2)."</option>";
						}else{
							echo "<option value='".$row->iddocente."'>".utf8_decode($row->nombre1)." ".utf8_decode($row->nombre2).
							" ".utf8_decode($row->apellido1)." ".utf8_decode($row->apellido2)."</option>";
						}
					}
				}else {
					echo "<option value='NULL'>No Existen Indicadores </option>";
				}
			echo "</select></label><br/><br/><br/>
			<label style='margin:50px; font-weight:bold' >Asignatura
			<select  id='materia' name='materia'>";
				echo "<option value='0'>Todas</option>";
				$sql = "SELECT idmateria, nombre_materia FROM materia";
				if ($conx->QueryArray($sql)) {
					$valor=$conx->RowCount();
					$conx->MoveFirst();
					while (! $conx->EndOfSeek()) {
						$row = $conx->Row();
						if($row->idmateria==$materia){
							echo "<option value='".$row->idmateria."' selected>".
							$row->nombre1." ".$row->nombre2." ".$row->nombre_materia."</option>";
						}else{
							echo "<option value='".$row->idmateria."'>".
							$row->nombre1." ".$row->nombre2." ".$row->nombre_materia."</option>";
						
						}
						
					}
						
				} else {
					echo "<option>No existen asignaturas</option>";
				}
				
			echo "</select></label><br/><br/><br/>
			<label style='margin:50px; font-weight:bold' >Grado Escolar
			<select  id='grupo' name='grupo'>";
				echo "<option value='0'>Todos</option>";
				$sql = "SELECT idaula, descripcion FROM aula";
				if ($conx->QueryArray($sql)) {
					$valor=$conx->RowCount();
					$conx->MoveFirst();
					while (! $conx->EndOfSeek()) {
						$row = $conx->Row();
						if($row->idaula==$grupo){
							echo "<option value='".$row->idaula."' selected>".$row->descripcion."</option>";
						}else{
							echo "<option value='".$row->idaula."'>".$row->descripcion."</option>";
						
						}
						
					}
						
				} else {
					echo "<option>No existen grados escolares</option>";
				}
				
			echo "</select></label>
			<input type='submit' value='Mostrar'> 			
			</form>
			</div>
			<div class='tabla'>
				<table>";
						$sql = "Select Distinct iddocente, nombre1, nombre2, apellido1, apellido2, idmateria
						From docente, indicadores WHERE idpropietario=iddocente";
						
						if($iddocente!=0){
							$sql.=" AND iddocente=$iddocente";
						}
						if($materia!=0){
							$sql.=" AND idmateria=$materia";
							
						}
						if($grupo!=0){
							$sql.=" AND idaula=$grupo";
							
						}
						$consulta = $conx2->query($sql);
						if($conx2->get_numRecords($consulta)>0){
							echo "<tr><td class='estilocelda' colspan='7'>Informe  - Indicadores Creados Por Docentes</td></tr>";
							while ($row = $conx2->records_array($consulta)) {
								$sumih=0;
								echo "<tr><th colspan='4' style='text-align:left'>DOCENTE: ".$row['nombre1'].' '.$row['nombre2'].' '.$row['apellido1'].' '.$row['apellido2']."</th>";
								$sqlreporte= "SELECT i.idindicador, i.tipo, i.descripcion, i.habilitado, 
								i.compartido, a.grado, a.grupo, m.nombre_materia FROM indicadores i, aula a, materia m  
								WHERE i.idpropietario=".$row['iddocente']." AND i.idmateria=m.idmateria AND 
								i.idmateria=".$row['idmateria']." AND i.idaula=a.idaula AND i.idaula=$grupo ORDER BY m.nombre_materia,grado, grupo, tipo";
								$consultareporte = $conx->query($sqlreporte);
								echo "<tr><td style='font-weight:bold'>Asignatura</td>
								<td style='font-weight:bold'>Idindicador</td>
								<td style='font-weight:bold'>Tipo</td>
								<td style='font-weight:bold'>Descripcion</td>
								<td style='font-weight:bold'>Grado</td>
								<td style='font-weight:bold'>Habilitado</td>
								<td style='font-weight:bold'>Compartido</td>";
								while ($rowreporte = $conx2->records_array($consultareporte)) {
									echo "<tr>";
									echo "<td>".$rowreporte['nombre_materia']."</td>";
									echo "<td>".$rowreporte['idindicador']."</td>";
									echo "<td>".$rowreporte['tipo']."</td>";
									echo "<td>".$rowreporte['descripcion']."</td>";
									echo "<td>".$rowreporte['grado']."-G".$rowreporte['grupo']."</td>";
									echo "<td>".$rowreporte['habilitado']."</td>";
									echo "<td>".$rowreporte['compartido']."</td>";
									echo "</tr>";
								}
								echo "<tr><th><br/></th></tr>";
							}
								
						} else {
							echo "No Existen Indicadores ";
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