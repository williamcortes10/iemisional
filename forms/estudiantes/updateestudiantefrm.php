<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
		include('../../class/MySqlClass.php');
		include('../../bdConfig.php');
		$conx = new ConxMySQL($dominio,$usuario,$pass,$bd);
		$sql = "SELECT DISTINCT idestudiante, nombre1, nombre2, apellido1, apellido2, sexo, telefono, direccion, fechanac, habilitado FROM estudiante WHERE idestudiante = '".$_GET["id"]."' LIMIT 1";
		$consulta = $conx->query($sql);
		while ($row = $conx->records_array($consulta)) {
			$idestudiante=$row['idestudiante'];
			$nombre1=utf8_encode($row['nombre1']);
			$nombre2=utf8_encode($row['nombre2']);
			$apellido1=utf8_encode($row['apellido1']);
			$apellido2=utf8_encode($row['apellido2']);
			$sexo=$row['sexo'];
			$telefono=$row['telefono'];
			$direccion=utf8_encode($row['direccion']);
			$fechanac=$row['fechanac'];
			$habilitado=$row['habilitado'];
		}
	
	
?>
<html>
    <head>
        <title>ACTUALIZAR ESTUDIANTE</title>
        <meta http-equiv="Content-Type" content="text/html;"/>
        <meta name="description" content="" />
        <meta name="keywords" content=""/>
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
		<link rel="stylesheet" href="../../css/form.css" type="text/css" media="screen"/>
		<script type="text/javascript" src="../../script/jquery.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			$("input").change(function () {
				  $("#resultado").hide(2000);
			});
			$("#resultado").hide(3000);
			$("#formupuser").submit(function(event) {
			
				// stop form from submitting normally
				event.preventDefault(); 
					
				// get some values from elements on the page:
				idestudiante1=$('#idestudiante').val();
				idestudianteold1=$('#idestudianteold').val();
				apellido11=$('#apellido1').val();
				apellido22=$('#apellido2').val();
				nombre11=$('#nombre1').val();
				nombre22=$('#nombre2').val();
				sexo1=$('#sexo').val();
				telefono1=$('#telefono').val();				
				direccion1=$('#direccion').val();
				fechanac1=$('#fechanac').val();
				habilitado1=$('#habilitado').val();
				
				// Send the data using post and put the results in a div
				$.post( "upestudiante_sucess.php", {idestudiante: idestudiante1,idestudianteold:idestudianteold1,
				apellido1: apellido11, apellido2:apellido22, nombre1:nombre11, nombre2:nombre22,
				sexo:sexo1, telefono: telefono1, direccion:direccion1, fechanac:fechanac1, habilitado: habilitado1} ,
				  function( data ) {
					  $( "#resultado" ).html( data );
						$("#resultado").show(1000);
						$("#resultado").hide(3000);
			
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
			$sql2 = "SELECT idusuario, apellido1, nombre1, tipousuario FROM usuario, docente 
			WHERE idusuario='".$_SESSION['k_username']."' and iddocente=idusuario and (tipousuario='D' OR tipousuario='A')";
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
			echo "
				<div id='stylized' class='myform'>
				<form id='formupuser' name='formupuser' method='post' action=''>
				<h1>Formulario  - Actualizar Estudiante</h1>
				<p>Ingrese los datos para actualizar  estudiante</p>
				<label>Identificaci&oacute;n
				<span class='small'>Maximo 10 digitos<span style='color:red'>*</span></span>
				</label>";
				echo "<input type='text' name='idestudiante' id='idestudiante' size='10' maxlength='10' value='$idestudiante'/>";
				echo "<input type='hidden' name='idestudianteold' id='idestudianteold' size='10' maxlength='10' value='$idestudiante'/>";
				echo "<label>Primer Apellido
				<span class='small'>Maximo 20 caracteres<span style='color:red'>*</span></span>
				</label>";
				echo "<input type='text' name='apellido1' id='apellido1' size='20' maxlength='20' value='$apellido1'/>";
				echo "<label>Segundo Apellido
				<span class='small'>Maximo 20 caracteres</span>
				</label>";
				echo "<input type='text' name='apellido2' id='apellido2' size='20' maxlength='20' value='$apellido2'/>";
				echo "<label>Primer Nombre
				<span class='small'>Maximo 20 caracteres<span style='color:red'>*</span></span>
				</label>";
				echo "<input type='text' name='nombre1' id='nombre1' size='20' maxlength='20' value='$nombre1'/>";
				echo "<label>Segundo Nombre
				<span class='small'>Maximo 20 caracteres</span>
				</label>";
				echo "<input type='text' name='nombre2' id='nombre2' size='20' maxlength='20' value='$nombre2'/>";
				echo "<label>Fecha Nacimiento
				<span class='small'>YYYY-MM-DD</span>
				</label>
				<input type='text' name='fechanac' id='fechanac' size='10' maxlength='10' value='$fechanac'/>
				<label>Sexo
				<span class='small'>Elija el sexo<span style='color:red'>*</span></span>
				</label>
				<select id='sexo'>";
						if($sexo=='M'){
							echo "<option value='M' selected>M</option>";
							echo "<option value='F' >F</option>";
						}else{
							echo "<option value='M' >M</option>";
							echo "<option value='F' selected>F</option>";
						}
				echo "</select>
				<label>Habilitado
				<span class='small'>Elija el estado de ingreso<span style='color:red'>*</span></span>
				</label>
				<select id='habilitado'>";
						if($habilitado=='S'){
							echo "<option value='S' selected>S</option>";
							echo "<option value='N' >N</option>";
						}else{
							echo "<option value='S' >S</option>";
							echo "<option value='N' selected>N</option>";
						}
				echo "</select>
				<label>Telefono
				<span class='small'>Maximo 10 caracteres</span>
				</label>
				<input type='text' name='telefono' id='telefono' size='10' maxlength='10' value='$telefono'/>
				<label>Direccion
				<span class='small'>Maximo 20 caracteres</span>
				</label>
				<input type='text' name='direccion' id='direccion' size='20' maxlength='20' value='$direccion'/>	
				
				<button type='submit'>Actualizar</button>
				<div class='spacer'></div>

				</form>
				<div id='resultado'>
				
				</div>
				<span>
					<a href='actualizar_estudiante.php' class='large button orange' style='font-size: 12px !important;'><img src='../../images/back.png' id='back' alt='Regresar' /></a>
				</span>
				<span>
					<span style='font-size: 9px !important;' class='small'><span style='color:red'>*</span> Campos requeridos</span>
			<br/><br/><br/>";
		}
		?>
		<div align='center'>
			<span class="reference">
				<?php
					if(isset($records2)){
					echo "<img src='../../images/profile.png'><a>Usuario: ".utf8_decode($records2['apellido1'])." ".utf8_decode($records2['nombre1'])."
				     </a><a href='../../docente/logout.php'>Salir</a>";
					}
					$conx->close_conex();
				?>
                <a href="http://tympanus.net/codrops/2010/11/25/overlay-effect-menu/">Derechos reservados</a>
				<a href="http://www.flickr.com/photos/duke9042004/" target="_blank">williamcortes10@gmail.com</a>
            </span>
		</div>
    </body>
</html>