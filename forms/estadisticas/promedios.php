<?php
session_start();
?>
<!DOCT	YPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
		include('../../class/MySqlClass.php');
		include("../../class/ultimatemysql/mysql.class.php");
		$conx = new MySQL();
		if (! $conx->Open("appacademy", "localhost", "root", "")) {
			$conx->Kill();
		}
?>
<html>
    <head>
        <title>PROMEDIOS X GRADOS</title>
        <meta http-equiv="Content-Type" content="text/html;"/>
        <meta name="description" content="" />
        <meta name="keywords" content=""/>
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
		<link rel="stylesheet" href="../../css/form.css" type="text/css" media="screen"/>
		<script type="text/javascript" src="../../script/jquery.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			
		});
		</script>
		<style type="text/css">
			body{
				background:#000;
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
			}
			h1{
				font-size:50px;
				text-align:right;
				position:absolute;
				right:40px;
				top:20px;
				font-weight:normal;
				/*text-shadow:  0 0 3px #0096ff, 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #fff, 0 0 40px #0096ff, 0 0 70px #0096ff, 0 0 80px #0096ff, 0 0 100px #0096ff, 0 0 150px #0096ff;
			*/}
			h1 span{
				display:block;
				font-size:10px;
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
	</style>
    </head>

    <body>
	
		<div class="bg_img"><img src="../../images/1.jpg" alt="background" /></div>
		<h1>APP ACADEMY<span>La manera mas facil de administrar sus notas y boletines academicos</span></h1>
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
			echo "<span align='center'><a href='../../index.php' align='center'>Regresar</a></span></div></div>";
		}
		if($look){
			echo "<div class='form'>
				<div id='stylized' class='myform'>
				<form id='formupuser' name='formupuser' method='post' action='promediosxcurso.php'>
				<h1>Formulario  - Boletin General</h1>
				<p>Complete datos para generar boletin</p>
				<label>Grado escolar
				<span class='small'>Eliga grado</span>
				</label>
				<select  id='aula' name='aula'>";
					$sql = "SELECT * FROM aula";
					if ($conx->QueryArray($sql)) {
						$valor=$conx->RowCount();
						$conx->MoveFirst();
						while (! $conx->EndOfSeek()) {
							$row = $conx->Row();
							echo "<option value='".$row->idaula."'>".
							$row->grado."-G".$row->grupo."</option>";
							
						}
							
					} else {
						echo "<option>No existen grados</option>";
					}
				  
				echo "</select>
				<label>Año lectivo
				</label>
				<select  id='aniolect' name='aniolect'>";
					$fechahoy=date("Y");
					for($ano=2030; $ano>1990; $ano--){
						if ($ano==$fechahoy) {
							echo "<option value='".$ano."' selected>".$ano."</option>";
						}else {
							echo "<option value='".$ano."'>".$ano."</option>";
						}
					}
				  
				echo "</select>
				<label>Periodo
				</label>
				<select  id='periodo' name='periodo'>";
					$sqlaniolect = "SELECT * FROM appconfig WHERE item = 'periodo_hab'";
					if ($conx->QueryArray($sqlaniolect)) {
						$valor=$conx->RowCount();
						$conx->MoveFirst();
						$row = $conx->Row();
						$periodo=$row->valor;
					}else{
						$periodo=1;
					}
					for($i=1; $i<5; $i++){
						if ($i==$periodo) {
							echo "<option value='".$i."' selected>".$i."</option>";
						}else {
							echo "<option value='".$i."'>".$i."</option>";
						}
						
					}
					echo "<option value='F'>Final</option>";
				  
				echo "</select>
				<button type='submit'>Generar</button>
				<div class='spacer'></div>

				</form>
				<div id='resultado'>
				
				</div>
				<span>
					<a href='../../index.php' class='large button orange' style='font-size: 12px !important;'><img src='../../images/back.png' id='back' alt='Regresar' /></a>
				</span>
				<span>
					<span style='font-size: 9px !important;' class='small'><span style='color:red'>*</span> Campos requeridos</span>
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