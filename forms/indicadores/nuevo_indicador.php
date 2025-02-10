<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Nuevo Indicador</title>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content=""/>
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
		<link rel="stylesheet" href="../../css/formst2.css" type="text/css" media="screen"/>
		<link rel="stylesheet" href="../../css/form.css" type="text/css" media="screen"/>
		<script type="text/javascript" src="../../script/jquery.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			$('#dindicador').val("");
			$("input").change(function () {
				  $("#resultado").hide(2000);
			});
			$("select").change(function () {
				  $("#resultado").hide(2000);
			});
			$("dindicador").change(function () {
				  $("#resultado").hide(2000);
			});
			$("competencia").change(function () {
				  $("#resultado").hide(3000);
			});
			$("#resultado").hide(3000);
			//formulario indicador por competencias
			$("#formcomp").submit(function(event) {
			
				// stop form from submitting normally
				event.preventDefault(); 
					
				// get some values from elements on the page:
				idestandar1=$('#idestandar').val();
				competencia1=$('#competencia').val();
				estrategia1=$('#estrategia').val();
				idmateria1=$('#idmateria').val();
				idaula1=$('#idaula').val();
				// Send the data using post and put the results in a div
				$.post( "nvindicadorcomp_response.php", {idestandar: idestandar1, competencia: competencia1,
				estrategia:estrategia1, idmateria:idmateria1, idaula:idaula1} ,
				  function( data ) {
					  $( "#resultado" ).html( data );
						$("#resultado").show(1000);
			
				  }
				);
			  });
			//---------------------------------------
			$("#formupuser").submit(function(event) {
			
				// stop form from submitting normally
				event.preventDefault(); 
					
				// get some values from elements on the page:
				tpindicador1=$('#tpindicador').val();
				dindicador1=$('#dindicador').val();
				idpropietario1=$('#idpropietario').val();
				idmateria1=$('#idmateria').val();
				hindicador1=$('#hindicador').val();
				cindicador1=$('#cindicador').val();
				idaula1=$('#idaula').val();
				// Send the data using post and put the results in a div
				$.post( "nvindicador_response.php", {tpindicador: tpindicador1, dindicador: dindicador1,
				idpropietario:idpropietario1, idmateria:idmateria1, hindicador: hindicador1, cindicador:cindicador1,
				idaula:idaula1} ,
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
				font-size:30px;
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
	<?php
		include("../../class/ultimatemysql/mysql.class.php");
		$conx = new MySQL();
		if (! $conx->Open("appacademy", "localhost", "root", "")) {
			$conx->Kill();
		}
	
	?>
		<div class="bg_img"><img src="../../images/1.jpg" alt="background" /></div>
		<h1>APP ACADEMY<span>La manera mas facil de administrar sus notas y boletines academicos</span></h1>
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
			//buscar año lectivo activo, aula y materia
			$sqlaniolect = "SELECT * FROM appconfig WHERE item = 'aniolect'";
			if ($conx->QueryArray($sqlaniolect)) {
				$valor=$conx->RowCount();
				$conx->MoveFirst();
				$row = $conx->Row();
				$añolectivo=$row->valor;
			}else {
				echo "<option>No esta configurado el ano lectivo</option>";
			}
			$materia=$_GET['idmateria'];
			$aula=$_GET['idaula'];
			//-------------------------
			//Mostrar formulario de estandares por competencia para año lectivo superior a 2014
			
			if($añolectivo>2014 and $materia!=27){
				echo "
				
				<h2>Formulario  - Nuevo Indicador por competencias</h2>
				<div id='form_container'>
				<form class='appnitro' id='formcomp' name='formcomp' method='post' action=''>
				<input type='hidden' name='aniolectivo' value='$añolectivo'>
				<div class='form_description'>
					<div id='resultado'>
					
					</div>
					<p>Complete los datos</p>
				</div>						
				<ul >
					<li id='li_3' >
					<label class='description' for='idestandar'>ESTANDAR BASICO DE COMPETENCIA/DIMENSION </label>
					<div>
					<select class='element select medium' id='idestandar' name='idestandar'>";
					$sql = "SELECT *  FROM estandares WHERE idmateria_fk = '$materia' AND grado= '$aula'";
					if ($conx->QueryArray($sql)) {
						$valor=$conx->RowCount();
						$conx->MoveFirst();
						while (! $conx->EndOfSeek()) {
							$row = $conx->Row();
							echo "<option value='".$row->codigo."'>".
							utf8_encode($row->descripcion)."</option>";
							
						}
							
					} else {
						echo "<option>No se ha configurado estandares</option>";
					}
					
					echo "
					</select>
					</div> 
					</li>		
					<li id='li_1' >
					<label class='description' for='competencia'>COMPETENCIA </label>
					<div>
						<textarea id='competencia' name='competencia' class='element textarea medium'></textarea> 
					</div> 
					</li>		
					<li id='li_2' >
					<label class='description' for='estrategia'>ESTRATEGIA DE APRENDIZAJE </label>
					<div>
						<textarea id='estrategia' name='estrategia' class='element textarea medium'></textarea> 
					</div> 
					</li>		
					<li id='li_4' >
					<label class='description' for='idmateria'>ASIGNATURA </label>
					<div>
					<select class='element select medium' id='idmateria' name='idmateria'> 
					";
					$sql = "SELECT idmateria , nombre_materia FROM materia 
						WHERE idmateria=".$_GET['idmateria'];
						if ($conx->QueryArray($sql)) {
							$valor=$conx->RowCount();
							$conx->MoveFirst();
							$row = $conx->Row();
							echo "<option value='".$row->idmateria."' readonly>".$row->nombre_materia."</option>";
						}
					echo "
					</select>
					</div> 
					</li>		
					<li id='li_5' >
					<label class='description' for='idaula'>GRADO ESCOLAR </label>
					<div>
					<select class='element select medium' id='idaula' name='idaula'> 
					";
					$sql = "SELECT * FROM aula WHERE idaula=".$_GET['idaula'];
					if ($conx->QueryArray($sql)) {
						$valor=$conx->RowCount();
						$conx->MoveFirst();
						while (! $conx->EndOfSeek()) {
							$row = $conx->Row();
							echo "<option value='".$row->idaula."'>".
							$row->descripcion."-G".$row->grupo."</option>";
							
						}
							
					} else {
						echo "<option>No existen grados</option>";
					}
					
				echo "
					</select>
					</div> 
					</li>
					<li class='buttons'>	
							<input id='saveForm' class='button_text' type='submit' name='submit' value='Guardar' />
					</li>
				</ul>
				</form>	
				";
				
			}else{
				//muestra formulario por tipo de desempeño
				echo "<div class='form'>
				<div id='stylized' class='myform'>
				<form id='formupuser' name='formupuser' method='post' action=''>
				<h1>Formulario  - Nuevo Indicador</h1>
				<div id='resultado'>
				
				</div>
				<p>Complete los datos</p>
				<label>Tipo Desempeño
				<span class='small'>DS=Superior, DA=Alto, DB=Básico, Db=Bajo<span style='color:red'>*</span></span>
				</label>
				<select id='tpindicador'>
					<option value='DS'>DS</option>
					<option value='DA'>DA</option>
					<option value='DB'>DB</option>
					<option value='D-'>Db</option>
					
				</select>
				<label>Descripción
				<span class='small'>Maximo 200 caracteres<span style='color:red'>*</span></span>
				</label>
				<textarea name='dindicador' id='dindicador'  cols='28' rows='4' maxlength='200'></textarea>
				<label>Propietario
				</label>
				<select id='idpropietario'>";
				$sql = "SELECT iddocente , nombre1, nombre2, apellido1 FROM docente 
					WHERE iddocente=".$_GET['id'];
					if ($conx->QueryArray($sql)) {
						$valor=$conx->RowCount();
						$conx->MoveFirst();
						$row = $conx->Row();
						echo "<option value='".$row->iddocente."' readonly>".utf8_decode($row->nombre1)." ".utf8_decode($row->nombre2).
							" ".utf8_decode($row->apellido1)." ".utf8_decode($row->apellido2)."</option>";
					}
				
				echo"</select>
				<label>Asignatura
				</label>
				<select id='idmateria'>";
				$sql = "SELECT idmateria , nombre_materia FROM materia 
					WHERE idmateria=".$_GET['idmateria'];
					if ($conx->QueryArray($sql)) {
						$valor=$conx->RowCount();
						$conx->MoveFirst();
						$row = $conx->Row();
						echo "<option value='".$row->idmateria."' readonly>".utf8_decode($row->nombre_materia)."</option>";
					}
				echo "</select>
				<label>Grado escolar
				</label>
				<select  id='idaula'>";
					$sql = "SELECT * FROM aula WHERE idaula=".$_GET['idaula'];
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
				<label>Habilitado
				<span class='small'>S=Si, N=No<span style='color:red'>*</span></span>
				</label>
				<select id='hindicador'>
					<option value='S'>S</option>
					<option value='N'>N</option>
					
				</select>
				<label>Compartido
				<span class='small'>S=Si, N=No<span style='color:red'>*</span></span>
				</label>
				<select id='cindicador'>
					<option value='S'>S</option>
					<option value='N'>N</option>
					
				</select>
				<button type='submit'>Guardar</button>
				<div class='spacer'></div>

				</form>
				<span>
					<a href='buscar_docente.php' class='large button orange' style='font-size: 12px !important;'><img src='../../images/back.png' id='back' alt='Regresar' /></a>
				</span>
				<span>
					<span style='font-size: 9px !important;' class='small'><span style='color:red'>*</span> Campos requeridos</span>
			</div>";
				
			}
			
	}
	?>
		<br/><br/><br/><br/><br/>
     <div>
            <span class="reference">
				<?php
					if(isset($records2)){
					echo "<img src='../../images/profile.png'><a>Usuario: ".$records2['apellido1']." ".$records2['nombre1']."
				     </a><a href='../../docente/logout.php'>Salir</a>";
					}
				?>
                <a href="http://tympanus.net/codrops/2010/11/25/overlay-effect-menu/">Derechos reservados</a>
				<a href="http://www.flickr.com/photos/duke9042004/" target="_blank">williamcortes10@gmail.com</a>
            </span>
		</div>

    </body>
</html>