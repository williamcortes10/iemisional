<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>DIRECCION DE GRUPO</title>
        <meta http-equiv="Content-Type" content="text/html"/>
        <meta name="description" content="" />
        <meta name="keywords" content=""/>
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
		<link rel="stylesheet" href="../../css/form.css" type="text/css" media="screen"/>
		<script type="text/javascript" src="../../script/jquery.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
 			$("input").change(function () {
				  $("#result").hide(2000);
			});
			$("select").change(function () {
				  $("#result").hide(2000);
			});
			$("#result").hide(3000);
			$("#formupuser").submit(function(event) {
			
				// stop form from submitting normally
				event.preventDefault(); 
					
				// get some values from elements on the page:
				//buscar materias para docente
  				idaula1=$("#idaula").val();
				aniolect1=$("#aniolect").val();
  				iddocente1=$("#iddocentes").val();
  				$.post("asignarcg_response.php",{iddocente:iddocente1, idaula:idaula1, aniolect:aniolect1},function(data){
    					$("#result").html(data);
						$("#result").show(1000);
  				});
			  });
			
		});

		function nuevoIndicador(codigo, idmateria, idaula){
		$(document).ready(function(){
			
			location.href='nuevo_indicador.php?id='+codigo+'&idmateria='+idmateria+'&idaula='+idaula;	
		  
		});

		}

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
			}
			#filtro,#footer{
				margin: 0 auto 0 auto;
				width: 750px;
				height: auto;
			}
			.tabla , .tabla td , .tabla tr, .tabla th{
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
				font-size:10pt; 
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
	
	?>
	<div class="bg_img"><img src="../../images/1.jpg" alt="background" /></div>
		<h1>APP ACADEMY<span>La manera mas facil de administrar sus notas y boletines academicos</span></h1>
		<?php
		include('../../class/MySqlClass.php');
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
			<h1>Formulario  - Asignar Director de Grupo</h1>
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
						echo "<option value='".$row->iddocente."'>".utf8_decode($row->nombre1)." ".utf8_decode($row->nombre2).
						" ".utf8_decode($row->apellido1)." ".utf8_decode($row->apellido2)."</option>";
					}
			}else {
					echo "<option value='NULL'>No se ha asignado carga académica</option>";
			}
			echo "</select>
			<label>Grado escolar
			<span class='small'>Eliga grado</span>
			</label>
			<select  id='idaula'>";
				$sql = "SELECT DISTINCT * FROM aula ORDER BY idaula";
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
			<div id='divaula'>
			
			</div>	
			<button type='submit'>Guardar</button>
			<div id='result'>
			
			</div>
			<br/><br/><br/><br/><br/><br/>
			<div class='spacer'></div>
			</form>
			<p><span>
				<a href='../../index.php' class='large button orange' style='font-size: 12px !important;'><img src='../../images/back.png' id='back' alt='Regresar' /></a>
			</span></p>
			</div></div>";
			
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
