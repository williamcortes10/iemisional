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
		$sql = "SELECT DISTINCT c.*, a.descripcion FROM coordinadoresgrupo c, aula a WHERE 
		c.idaula = '".$_GET["id"]."' AND c.idaula=a.idaula AND c.aniolectivo='".$_GET["aniolectivo"]."'";
		if ($conx->QueryArray($sql)) {
			$conx->MoveFirst();
			while (! $conx->EndOfSeek()) {
				$row = $conx->Row();
				$idaula=$row->idaula;
				$iddocente=$row->iddocente;
				$aniolectivo=$row->aniolectivo;
				$descripcion=$row->descripcion;
			}
		}
		
	
?>
<html>
    <head>
        <title>ACTUALIZAR AULA</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
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
			$("select").change(function () {
				  $("#resultado").hide(2000);
			});
			$("#resultado").hide(3000);
			$("#formupuser").submit(function(event) {
			
				// stop form from submitting normally
				event.preventDefault(); 
					
				// get some values from elements on the page:
				idaula1=$('#idaula').val();
				iddocente1=$('#iddocentes').val();
				iddocenteback1=$('#iddocenteback').val();
				aniolectivo1=$('#aniolect').val();
				// Send the data using post and put the results in a div
				$.post( "upauladg_sucess.php", {idaula: idaula1, iddocente: iddocente1, 
				iddocenteback: iddocenteback1, aniolectivo: aniolectivo1} ,
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
		include("../../class/MySqlClass.php");
	?>
	
		<div class="bg_img"><img src="../../images/1.jpg" alt="background" /></div>
		<h1>APP ACADEMY<span>La manera mas facil de administrar sus notas y boletines academicos</span></h1>
		</div>
		<?php
		$look=false;
		if (isset($_SESSION['k_username'])) {
			$conx2 = new ConxMySQL("localhost","root","","appacademy");
			$sql2 = "SELECT idusuario, apellido1, nombre1, tipousuario FROM usuario, docente 
			WHERE idusuario='".$_SESSION['k_username']."' and iddocente=idusuario and tipousuario='A'";
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
				<h1>Formulario  - Actualizar Director de Grupo</h1>
			<p>Complete parametros</p>
			<label class='description' for='iddocentes'>Docente
			<span class='small'>Eliga Docente</span>
			</label>
			<select  id='iddocentes'>";
			$sql = "SELECT DISTINCT d.iddocente , d.nombre1, d.nombre2, d.apellido1 FROM docente d, clase c 
				WHERE d.iddocente=c.iddocente
				ORDER BY d.iddocente";
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
					echo "<option value='NULL'>No se ha asignado intensidad horaria</option>";
			}
			echo "</select>
			<label>Grado escolar
			<span class='small'>Eliga grado</span>
			</label>
			<select  id='idaula'>";
				$sql = "SELECT DISTINCT * FROM aula WHERE idaula=$idaula ORDER BY idaula";
				if ($conx->QueryArray($sql)) {
					$conx->MoveFirst();
					while (! $conx->EndOfSeek()) {
						$row = $conx->Row();
						echo "<option value='".$row->idaula."'>".
						$row->descripcion."</option>";
						
					}
						
				} else {
					echo "<option value='null'>No se ha creado grados</option>";
				}
			echo	"</select>
			<label>Año lectivo
			</label>
			<select  id='aniolect'>";
				echo "<option value='".$aniolectivo."'>".$aniolectivo."</option>";
			echo "</select>
				<input type='hidden' name='idaula' id='idaula' value='$idaula'/>
				<input type='hidden' name='iddocenteback' id='iddocenteback' value='$iddocente'/>
				<button type='submit'>Actualizar</button>
				<div class='spacer'></div>

				</form>
				<div id='resultado'>
				
				</div>
				<span>
					<a href='buscarupdel_cg.php' class='large button orange' style='font-size: 12px !important;'><img src='../../images/back.png' id='back' alt='Regresar' /></a>
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