<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
		include("../../class/ultimatemysql/mysql.class.php");
		include('../../class/MySqlClass.php');
		$conx = new MySQL();
		if (! $conx->Open("appacademy", "localhost", "root", "")) {
			$conx->Kill();
		}
		$sql = "SELECT DISTINCT * FROM docente WHERE iddocente = '".$_GET["id"]."'";
		if ($conx->QueryArray($sql)) {
			$conx->MoveFirst();
			while (! $conx->EndOfSeek()) {
				$row = $conx->Row();
				$iddocente=$row->iddocente;
				$nombre1=$row->nombre1;
				$nombre2=$row->nombre2;
				$apellido1=$row->apellido1;
				$apellido2=$row->apellido2;
			}
		}
	
?>
<html>
    <head>
        <title>Asignar clase a docente</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="description" content="" />
        <meta name="keywords" content=""/>
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
		<link rel="stylesheet" href="../../css/form.css" type="text/css" media="screen"/>
		<script type="text/javascript" src="../../script/jquery.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			$("select").change(function () {
				  $("#resultado").hide(2000);
			});
			$("#resultado").hide(3000);
			$("#formupuser").submit(function(event) {
			
				// stop form from submitting normally
				event.preventDefault(); 
					
				// get some values from elements on the page:
				iddocente1=$('#iddocente').val();
				//iddocenteback1=$('#iddocenteback').val();
				materia1=$('#materia').val();
				aula1=$('#aula').val();
				ih1=$('#ih').val();
				aniolect1=$('#aniolect').val();
				
				// Send the data using post and put the results in a div
				$.post( "asignarclase_response.php", {iddocente: iddocente1, materia: materia1, aula:aula1,
				ih:ih1, aniolect:aniolect1} ,
				  function( data ) {
					  $( "#resultado" ).html( data );
						$("#resultado").show(1000);
			
				  }
				);
			  });
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
			echo "<span align='center'><a href='../index.php' align='center'>Regresar</a></span></div></div>";
		}
		if($look){
			echo "<div class='form'>
				<div id='stylized' class='myform'>
				<form id='formupuser' name='formupuser' method='post' action=''>
				<h1>Formulario  - Asignar Clase</h1>
				<p>Ingrese los datos para asignar clase</p>
				<label>Asignatura
				<span class='small'>Eliga asignatura</span>
				</label>
				<select  id='materia'>";
					$sql = "SELECT idmateria, nombre_materia FROM materia";
					if ($conx->QueryArray($sql)) {
						$valor=$conx->RowCount();
						$conx->MoveFirst();
						while (! $conx->EndOfSeek()) {
							$row = $conx->Row();
							echo "<option value='".$row->idmateria."'>".
							$row->nombre1." ".$row->nombre2." ".$row->nombre_materia."</option>";
							
						}
							
					} else {
						echo "<option>No existen asignaturas</option>";
					}
					
				echo "</select>
				<label>Grado escolar
				<span class='small'>Eliga grado</span>
				</label>
				<select  id='aula'>";
					$sql = "SELECT * FROM aula ORDER BY idaula";
					if ($conx->QueryArray($sql)) {
						$valor=$conx->RowCount();
						$conx->MoveFirst();
						while (! $conx->EndOfSeek()) {
							$row = $conx->Row();
							echo "<option value='".$row->idaula."'>".
							utf8_encode($row->descripcion)."-G".$row->grupo."</option>";
							
						}
							
					} else {
						echo "<option>No existen grados</option>";
					}
				  
				echo "</select>
				<label>Intensidad Horaria
				<span class='small'>Eliga I.H</span>
				</label>
				<select  id='ih'>";
					for($i=1; $i<10; $i++) {
							echo "<option value='".$i."'>".$i."</option>";
							
					}
				  
				echo "</select>
				<label>Año lectivo
				</label>
				<select  id='aniolect'>";
					$sqlaniolect = "SELECT * FROM appconfig WHERE item = 'aniolect'";
					if ($conx->QueryArray($sqlaniolect)) {
						$valor=$conx->RowCount();
						$conx->MoveFirst();
						$row = $conx->Row();
						echo "<option value='".$row->valor."'>".$row->valor."</option>";
					}else {
						echo "<option>No esta configurado el ano lectivo</option>";
					}

				echo "</select>
				<label>Identificaci&oacute;n
				</label>";
				echo "<input type='text' name='iddocente' id='iddocente' size='10' maxlength='10' value='$iddocente' readonly/>";
				//echo "<input type='hidden' name='iddocenteback' id='iddocenteback' size='10' maxlength='10' value='$iddocente'/>";
				echo "<label>Docente
				</label>";
				$nombrefull=$nombre1.' '.$apellido1;
				echo "<input type='text' name='nombrefull' id='nombrefull' size='40' maxlength='40' value='$nombrefull' readonly/>";
				
				
				echo "<button type='submit'>Guardar</button>
				<div class='spacer'></div>

				</form>
				<div id='resultado'>
				
				</div>
				<span>
					<a href='buscar_docente.php' class='large button orange' style='font-size: 12px !important;'><img src='../../images/back.png' id='back' alt='Regresar' /></a>
				</span>
				<span>
					<span style='font-size: 9px !important;' class='small'><span style='color:red'>*</span> Campos requeridos</span>
			</div><br/><br/><br/><br/>";
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