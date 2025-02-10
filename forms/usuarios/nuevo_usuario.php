<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Nuevo Usuario</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="description" content="" />
        <meta name="keywords" content=""/>
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
		<link rel="stylesheet" href="../../css/form.css" type="text/css" media="screen"/>
		<script type="text/javascript" src="../../script/jquery.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
			$("#tipo_user").change(function(){
				$("#resultado").hide(3000);
			});
			$("#usuario").change(function(){
				$("#resultado").hide(3000);
			});
			$("#password").change(function(){
				$("#resultado").hide(3000);
			});
			$("#resultado").hide(3000);
			$("#formupuser").submit(function(event) {
			
				// stop form from submitting normally
				event.preventDefault(); 
					
				// get some values from elements on the page:
				user=$('#usuario').val();
				tipouser=$('#tipo_user').val();
				pass=$('#password').val();
				
				// Send the data using post and put the results in a div
				$.post( "nvuser_response.php", {usuario: user, tipo_user: tipouser, password:pass} ,
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
	<?php
		include("../../class/ultimatemysql/mysql.class.php");
		include('../../class/MySqlClass.php');
		$conx = new MySQL();
		if (! $conx->Open("appacademy", "localhost", "root", "")) {
			$conx->Kill();
		}
		

	?>
		<div class="bg_img"><img src="../../images/1.jpg" alt="background" /></div>
		<h1>APP ACADEMY<span>La manera mas facil de administrar sus notas y boletines academicos</span></h1>
		</div>
		<?php 
		$look=false;

		if (isset($_SESSION['k_username'])) {
			$conx2 = new ConxMySQL("localhost","root","","appacademy");
			$sql = "SELECT idusuario, apellido1, nombre1, tipousuario FROM usuario, docente 
			WHERE idusuario='".$_SESSION['k_username']."' and iddocente=idusuario and tipousuario='A'";
			$consulta = $conx2->query($sql);
			if($conx2->get_numRecords($consulta)>0){
				$records2 = $conx2->records_array($consulta);
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
			<h1>Formulario  - Nuevo Usuario</h1>
			<p>Ingrese los datos para agregar usuario</p>

			<label for='usuario'>Nombre
			<span class='small'>Eliga el usuario</span>
			</label>
			<select  id='usuario' name='usuario'>";
				$sql = "";
				if($records2['tipousuario']=='D'){
				$sql = "SELECT iddocente , nombre1, nombre2, apellido1 FROM docente 
				WHERE iddocente='".$_SESSION['k_username']."' ORDER BY nombre1, nombre2, apellido1, apellido2";
				}elseif($records2['tipousuario']=='A'){
					$sql = "SELECT iddocente , nombre1, nombre2, apellido1 FROM docente 
					ORDER BY nombre1, nombre2, apellido1, apellido2";
				}
				if ($conx->QueryArray($sql)) {
					$conx->MoveFirst();
					while (! $conx->EndOfSeek()) {
						$row = $conx->Row();
						if($row->iddocente==$_SESSION['k_username']){
							echo "<option value='".$row->iddocente."' selected>".utf8_decode($row->nombre1)." ".utf8_decode($row->nombre2).
							" ".utf8_decode($row->apellido1)." ".utf8_decode($row->apellido2)."</option>";
						}else{
							echo "<option value='".$row->iddocente."'>".utf8_decode($row->nombre1)." ".utf8_decode($row->nombre2).
							" ".utf8_decode($row->apellido1)." ".utf8_decode($row->apellido2)."</option>";
						}
					}
				}else {
					echo "<option value='NULL'>No Existen Usuarios </option>";
				}
			  
			echo "</select>

			<label for='tipo_user'>Tipo de Usuario
			<span class='small'>Eliga el tipo usuario</span>
			</label>
			<select  id='tipo_user' name='tipo_user'>
			  <option value='D'>Docente</option>
			  <option value='A'>Administrador</option>
			</select>
			

			<label>Contraseña
			<span class='small'>Min.  6 caracteres</span>
			</label>
			<input type='password' name='password' id='password' size='15'/>

			<button type='submit'>Dar Alta</button>
			<div class='spacer'></div>

			</form>
			<div id='resultado'>
			
			</div>
			<span>
				<a href='../../index.php' class='large button orange' style='font-size: 12px !important;'>Regresar</a>
			</span>
		</div>";
		}
		?>
		
        <div>
            <span class="reference">
				<?php
					echo "<img src='../../images/profile.png'><a>Usuario: ".$records2['apellido1']." ".$records2['nombre1']."
				     </a><a href='../../docente/logout.php'>Salir</a>";
				?>
                <a href="http://tympanus.net/codrops/2010/11/25/overlay-effect-menu/">Derechos reservados</a>
				<a href="http://www.flickr.com/photos/duke9042004/" target="_blank">williamcortes10@gmail.com</a>
            </span>
		</div>
    </body>
</html>