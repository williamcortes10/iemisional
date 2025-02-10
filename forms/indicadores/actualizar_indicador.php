<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
		include("../../class/ultimatemysql/mysql.class.php");
		$conx = new MySQL();
		if (! $conx->Open("appacademy", "localhost", "root", "")) {
			$conx->Kill();
		}
		$sql = "SELECT * FROM indicadores 
		WHERE idindicador=".(int)$_GET["id"];
		if ($conx->QueryArray($sql)) {
			$conx->MoveFirst();
			$row = $conx->Row();
			$idindicador=$row->idindicador;
			$iddocente=$row->idpropietario;
			$idmateria=$row->idmateria;
			$idaula=$row->idaula;
			$tipo=$row->tipo;
			$habilitado=$row->habilitado;
			$descripcion=$row->descripcion;
			$compartido=$row->compartido;

		}
		$aniolect=$_GET["aniolect"]
	
	?>
<html>
    <head>
        <title>FORMULARIO - ACTUALIZAR INDICADOR</title>
        <meta http-equiv="Content-Type" content="text/html;"/>
        <meta name="description" content="" />
        <meta name="keywords" content=""/>
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
		<link rel="stylesheet" href="../../css/form.css" type="text/css" media="screen"/>
		<script type="text/javascript" src="../../script/jquery.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			$('#dindicador').val("<?php echo $descripcion; ?>");
			$("input").change(function () {
				  $("#resultado").hide(2000);
			});
			$("select").change(function () {
				  $("#resultado").hide(2000);
			});
			$("dindicador").change(function () {
				  $("#resultado").hide(2000);
			});
			$("#resultado").hide(3000);
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
				idindicador1=$('#idindicador').val();
				idaula1=$('#idaula').val();
				// Send the data using post and put the results in a div
				$.post( "actualizarindicador_response.php", {tpindicador: tpindicador1, dindicador: dindicador1,
				idpropietario:idpropietario1, idmateria:idmateria1, hindicador: hindicador1, cindicador:cindicador1,
				idindicador:idindicador1, idaula:idaula1} ,
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
			echo"<div class='form'>
			<div id='stylized' class='myform'>
			<form id='formupuser' name='formupuser' method='post' action=''>
			<h1>Formulario  - Actualizar Indicador</h1>
			<div id='resultado'>
			
			</div>
			<p>Complete los datos</p>";
				echo "<input type='hidden' name='idindicador' id='idindicador' value='$idindicador'/>";
			echo "<label>Tipo Desempeño
			<span class='small'>DS=Superior, DA=Alto, DB=Básico, Db=Bajo<span style='color:red'>*</span></span>
			</label>
			<select id='tpindicador'>";
					if($tipo=='DS'){
						echo "	<option value='DS' selected>DS</option>
								<option value='DA'>DA</option>
								<option value='DB'>DB</option>
								<option value='D-'>Db</option>";
					}elseif($tipo=='DA'){
						echo "	<option value='DS'>DS</option>
								<option value='DA' selected>DA</option>
								<option value='DB'>DB</option>
								<option value='D-'>Db</option>";
					}elseif($tipo=='DB'){
						echo "	<option value='DS'>DS</option>
								<option value='DA'>DA</option>
								<option value='DB' selected>DB</option>
								<option value='D-'>Db</option>";
					}elseif($tipo=='D-'){
						echo "	<option value='DS'>DS</option>
								<option value='DA'>DA</option>
								<option value='DB'>DB</option>
								<option value='D-' selected>Db</option>";
					}
				
			echo "</select>
			<label>Descripción
			<span class='small'>Maximo 300 caracteres<span style='color:red'>*</span></span>
			</label>
			<textarea name='dindicador' id='dindicador'  cols='28' rows='4' maxlength='300'>
			</textarea>
			<label>Propietario
			</label>
			<select id='idpropietario'>";
			$sql = "SELECT iddocente , nombre1, nombre2, apellido1 FROM docente 
				WHERE iddocente=".$iddocente;
				if ($conx->QueryArray($sql)) {
					$valor=$conx->RowCount();
					$conx->MoveFirst();
					$row = $conx->Row();
					echo "<option value='".$row->iddocente."' readonly>".utf8_decode($row->nombre1)." ".utf8_decode($row->nombre2).
						" ".utf8_decode($row->apellido1)." ".utf8_decode($row->apellido2)."</option>";
				}
			echo "</select>
			<label>Asignatura
			</label>
			<select id='idmateria'>";
			$sql = "SELECT idmateria , nombre_materia FROM materia 
				WHERE idmateria=".$idmateria;
				if ($conx->QueryArray($sql)) {
					$valor=$conx->RowCount();
					$conx->MoveFirst();
					$row = $conx->Row();
					echo "<option value='".$row->idmateria."' readonly>".utf8_decode($row->nombre_materia)."</option>";
				}
			echo "</select>
			<label>Grado escolar
			<span class='small'>Eliga grado</span>
			</label>
			<select  id='idaula'>";
				$sql = "SELECT DISTINCT aula.* FROM aula, clase WHERE 
				clase.iddocente=$iddocente AND clase.idaula=aula.idaula 
				AND aniolectivo=$aniolect  AND clase.idmateria=$idmateria ORDER BY clase.idaula";
				if ($conx->QueryArray($sql)) {
					$valor=$conx->RowCount();
					$conx->MoveFirst();
					while (! $conx->EndOfSeek()) {
						$row = $conx->Row();
						if($idaula==$row->idaula){
							echo "<option value='".$row->idaula."' selected>".
							$row->grado."-G".$row->grupo."</option>";
						}else{
							echo "<option value='".$row->idaula."'>".
							$row->grado."-G".$row->grupo."</option>";
						}
						
					}
						
				} else {
					echo "<option value='null'>No se ha asignado carga académica</option>";
				}
			echo "</select>
			<label>Habilitado
			<span class='small'>S=Si, N=No<span style='color:red'>*</span></span>
			</label>
			<select id='hindicador'>";
				if($habilitado=='S'){
						echo "	<option value='S' selected>S</option>
								<option value='N'>N</option>";
				}elseif($habilitado=='N'){
						echo "	<option value='S'>S</option>
								<option value='N' selected>N</option>";
				}
			echo "</select>
			<label>Compartido
			<span class='small'>S=Si, N=No<span style='color:red'>*</span></span>
			</label>
			<select id='cindicador'>";
				if($compartido=='S'){
						echo "	<option value='S' selected>S</option>
								<option value='N'>N</option>";
				}elseif($compartido=='N'){
						echo "	<option value='S'>S</option>
								<option value='N' selected>N</option>";
				}
			echo "</select>
			<button type='submit'>Actualizar</button>
			<div class='spacer'></div>
	
			</form>
			<span>
				<a href='buscar_docenteup.php' class='large button orange' style='font-size: 12px !important;'><img src='../../images/back.png' id='back' alt='Regresar' /></a>
			</span>
			<span>
				<span style='font-size: 9px !important;' class='small'><span style='color:red'>*</span> Campos requeridos</span>
		</div>";
		}
		?>
        <div>
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