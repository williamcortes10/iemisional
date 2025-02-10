<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Ingresar notas - nivelacion</title>
        <meta http-equiv="Content-Type" content="text/html"/>
        <meta name="description" content="" />
        <meta name="keywords" content=""/>
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
		<link rel="stylesheet" href="../../css/form.css" type="text/css" media="screen"/>
		<script type="text/javascript" src="../../script/jquery.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function(){
 			$("#resultlista").hide();
			idaula1=$("#idaula").val();
  			aniolect1=$("#aniolect").val();
  			iddocente1=$("#iddocentes").val();
				//buscar aulas para docente
				$.post("buscaraula_responseup.php",{iddocente:iddocente1, aniolect:aniolect1},function(data){
    					$("#divaula").html(data);
						$("#divaula").fadeIn();
  				});
  			$("#iddocentes").change(function(){
  				aniolect1=$("#aniolect").val();
  				iddocente1=$("#iddocentes").val();
				//buscar aulas para docente
				$.post("buscaraula_responseup.php",{iddocente:iddocente1, aniolect:aniolect1},function(data){
    					$("#resultlista").fadeOut();
						$("#divaula").fadeOut();
						$("#divaula").html(data);
						$("#divaula").fadeIn();
  				});
			});
			$("#formbusqueda").submit(function(event) {
				// stop form from submitting normally
				event.preventDefault(); 
				$("#resultlista").fadeOut(100);
	
				// get some values from elements on the page:
				idaula1=$("#idaula").val();
				idmateria1=$("#idmateria").val();
  				iddocente1=$("#iddocentes").val();
  				aniolect1=$("#aniolect").val();
  				periodo1=$("#periodo").val();
				$(location).attr('href', '../notas/calificacionesxestudiantenv.php?id='+iddocente1+'&idmateria='+idmateria1+'&idaula='+idaula1+'&aniolectivo='+aniolect1);
			  });
			 //Guardar indicadores seleccionados
			 $("#formestudiantes").submit(function(event) {
				event.preventDefault(); 
				// stop form from submitting normally
				// get some values from elements on the page:
				//armando array de indicadores
				var val = $('#idestudiante:checked').map(function(i,n) {
					return $(n).val();
				}).get(); //get converts it to an array         
				periodo1=$("#periodo").val();
  				idmateria1=$("#idmateria").val();
  				aniolect1=$("#aniolect").val();
  				iddocente1=$("#iddocentes").val();
				idaula1=$("#idaula").val();
				$(location).attr('href', '../notas/calificacionesxestudiantenv.php?id='+iddocente1+'&idmateria='+idmateria1+'&idaula='+idaula1+'&aniolectivo='+aniolect1);
			  });
			
			  		
			
		});
		function checktodos(){
			if($("#todos").is(":checked")){
				$("input:checkbox").attr('checked', true);
			}else{
				$("#formestudiantes input:checkbox").attr('checked', false);
				
			}
		}	
		</script>
		<style type="text/css">
			ul{
			}
			ul > li{
				background-color: #999;
				list-style: none;

			}
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
			a:hover{ background-color: #999;
			color: yellow;
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
		<!-- Formulario Busqueda-->
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
			echo "<span align='center'><a href='../index.php' align='center'>Regresar</a></span></div></div>";
		}
		if($look){
			echo "<div class='form'>
			<div id='stylized' class='myform4'>
			<form id='formbusqueda' name='formbusqueda' method='post' action=''>
			<h1>Formulario  - Ingresar Notas Nivelacion</h1>
			<p>Complete parametros de busqueda</p>
			<<label for='iddocentes'>Docente
			<span class='small'>Eliga Docente</span>
			</label>
			<select  id='iddocentes'>";
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
						echo "<option value='".$row->iddocente."'>".utf8_decode($row->nombre1)." ".utf8_decode($row->nombre2).
						" ".utf8_decode($row->apellido1)." ".utf8_decode($row->apellido2)."</option>";
					}
				}else {
					echo "<option value='NULL'>No se ha asignado carga académica</option>";
				}
			echo "</select>
			<label>Año lectivo
			</label>
			<select  id='aniolect'>";
				$sqlaniolect = "";
				if($records2['tipousuario']=='D'){
					$sqlaniolect = "SELECT * FROM appconfig WHERE item = 'aniolect'";
					if ($conx->QueryArray($sqlaniolect)) {
					$valor=$conx->RowCount();
					$conx->MoveFirst();
					$row = $conx->Row();
					echo "<option value='".$row->valor."'>".$row->valor."</option>";
					}else {
						echo "<option>No esta configurado el ano lectivo</option>";
					}
				}elseif($records2['tipousuario']=='A'){
					$sqlaniolect = "SELECT * FROM appconfig WHERE item = 'aniolect'";
					if ($conx->QueryArray($sqlaniolect)) {
					$valor=$conx->RowCount();
					$conx->MoveFirst();
					$row = $conx->Row();
					for($year=2040; $year>=2000; $year--){
						if($year==$row->valor){
							echo "<option value='".$row->valor."' selected>".$row->valor."</option>";						
						}else{
							echo "<option value='".$year."'>".$year."</option>";
						}
					}
					}else {
						echo "<option>No esta configurado el ano lectivo</option>";
					}
				}	
			echo "</select>
			<div id='divaula'>
			
			</div>
				<button type='submit'>Calificar</button>
				<div class='spacer'></div>
				</form>
				<p><span>
					<a href='../../administrador/index.php' class='large button orange' style='font-size: 12px !important;'><img src='../../images/back.png' id='back' alt='Regresar' /></a>
				</span></p>
				</div>
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
