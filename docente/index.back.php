<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Pagin principal para docentes</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="description" content="" />
        <meta name="keywords" content=""/>
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
        <link rel="stylesheet" href="../css/style.css" type="text/css" media="screen"/>
		<link rel="stylesheet" href="../css/form.css" type="text/css" media="screen"/>
		<script src="../js/cufon-yui.js" type="text/javascript"></script>
		<script src="../js/Aller.font.js" type="text/javascript"></script>
		<script type="text/javascript">
			Cufon.replace('ul.oe_menu div a',{hover: true});
			Cufon.replace('h1,h2,.oe_heading');
		</script>
        <style type="text/css">
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
				font-size:75px;
				text-align:right;
				position:absolute;
				right:40px;
				top:20px;
				font-weight:normal;
				/*text-shadow:  0 0 3px #0096ff, 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #fff, 0 0 40px #0096ff, 0 0 70px #0096ff, 0 0 80px #0096ff, 0 0 100px #0096ff, 0 0 150px #0096ff;
			*/}
			h1 span{
				display:block;
				font-size:15px;
				font-weight:bold;
			}
			h2{
				position:absolute;
				top:220px;
				left:50px;
				font-size:40px;
				font-weight:normal;
				/*text-shadow:  0 0 3px #f6ff00, 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #fff, 0 0 40px #f6ff00, 0 0 70px #f6ff00, 0 0 80px #f6ff00, 0 0 100px #f6ff00, 0 0 150px #f6ff00;
*/}
		</style>
    </head>

    <body id="main_body">
	<div class="bg_img"><img src="../images/1.jpg" alt="background" /></div>
	<h1>APP ACADEMY<span>La manera mas facil de administrar sus notas y boletines academicos</span></h1>
	<h2>PANEL DOCENTE</h2>
	
	<?php 
		include('../class/MySqlClass.php');
		$look=false;

		if (isset($_SESSION['k_username'])) {
			$conx = new ConxMySQL("localhost","root","","appacademy");
			$sql = "SELECT idusuario, apellido1, nombre1, tipousuario FROM usuario, docente 
			WHERE idusuario='".$_SESSION['k_username']."' and iddocente=idusuario and tipousuario='D'";
			$consulta = $conx->query($sql);
			if($conx->get_numRecords($consulta)>0){
				$records = $conx->records_array($consulta);
				$look=true;
			}
		}else{
			echo "<div class='form'>
					<div id='stylized' class='myform'><h3 align='center' style='color:black'>Debes Loguearte</h3><br/>";
			echo "<span align='center'><a href='../index.php' align='center'>Regresar</a></span></div></div>";
		}
		if($look){
			$sql = "SELECT * FROM appconfig WHERE item = 'index_docen_ful'";
			$consulta = $conx->query($sql);
			$recordsM = $conx->records_array($consulta);
			if($recordsM['valor']=='on')
			{
				echo "
				<div class='oe_wrapper'>
					<div id='oe_overlay' class='oe_overlay'></div>
					<ul id='oe_menu' class='oe_menu'>
						<li><a href=''>Cuenta de Usuario</a>
							<div>
								<ul class='oe_full'>
									<li class='oe_heading'>Usuario</li>
									<li><a href='../forms/usuarios/actualizar_usuario.php'>Cambiar Clave</a></li>
								</ul>
							</div>
						</li>
						<li><a href=''>Indicadores</a>
							<div style='left:-111px;'>
								<ul>
									<li class='oe_heading'>Indicadores</li>
									<li><a href='../forms/indicadores/buscar_docente.php'>Nuevo</a></li>
									<li><a href='../forms/indicadores/buscar_docenteup.php'>Actualizar/Eliminar</a></li>
									<li><a href='../forms/indicadores/seleccionarIndicadores.php'>Seleccionar Indicadores</a></li>
									<li><a href='../forms/indicadores/desseleccionarIndicadores.php'>Des-seleccionar Indicadores</a></li>
									<li><a href='../forms/indicadores/seleccionarIndicadoresnf.php'>Seleccionar Indicadores Finales</a></li>
								</ul>
								<ul>
									<li class='oe_heading'>Informe</li>
									<li><a href='../forms/indicadores/listado_indicadorescreados.php'>Indicadores creados</a></li>
									<!-- <li><a href='../forms/indicadores/listado_indicadoresseleccionados.php'>Indicadores seleccionados por docentes</a></li>
									<!-- <li><a href='../forms/indicadores/listado_indicadorescreadosasig.php'>indicadores creados por asignaturas</a></li> --!>
								</ul>
							</div>
						</li>
						<li><a href=''>Notas</a>
							<div style='left:-223px;'>
							<ul>
								<li class='oe_heading'>Notas Regulares</li>
								<li><a href='../forms/notas/buscar_estudiante.php'>Ingresar Notas</a></li>
								<li><a href='../forms/notas/buscar_estudiantenf.php'>Ingresar Finales</a></li>
								<li><a href='../forms/notas/buscar_estudianteup.php'>Actualizar Notas</a></li>
								<li><a href='../forms/notas/buscar_estudianteupnf.php'>Actualizar Finales</a></li>
							</ul>
							<ul>
								<li class='oe_heading'>Notas Nivelacion</li>
								<li><a href='../forms/notasnv/buscar_estudiante.php'>Ingresar Notas</a></li>
								<li><a href='../forms/notasnv/buscar_estudianteup.php'>Actualizar Notas</a></li>
								<li><a href='../forms/notasnv/buscar_estudiantedel.php'>Eliminar Notas</a></li>
							</ul>
							<ul>
								<li class='oe_heading'>Informe</li>
								<li><a href='../forms/notas/notasxasignatura.php'>Notas por asignaturas</a></li>
							</ul>
							</div>
						</li>
						
					</ul>	
				</div>";
			}else{
				echo "<div class='form'>
					<div id='stylized' class='myform'><h3 align='center' style='color:black'>Sistema Cerrado Temporalmente</h3><br/>";
				echo "<span align='center'><a href='../index.php' align='center'>Regresar</a></span></div></div>";
			}
		
		}
		$conx->close_conex();
		?>
		
        <div>
            <span class="reference">
				<?php
					echo "<img src='../images/profile.png'><a>Usuario: ".$records['apellido1']." ".$records['nombre1']."
				     </a><a href='logout.php'>Salir</a>";
				?>
                <a href="http://tympanus.net/codrops/2010/11/25/overlay-effect-menu/">Derechos reservados</a>
				<a href="http://www.flickr.com/photos/duke9042004/" target="_blank">williamcortes10@gmail.com</a>
            </span>
		</div>


        <!-- The JavaScript -->
        <script type="text/javascript" src="../script/jquery.min.js"></script>
        <script type="text/javascript">
            $(function() {
				var $oe_menu		= $('#oe_menu');
				var $oe_menu_items	= $oe_menu.children('li');
				var $oe_overlay		= $('#oe_overlay');

                $oe_menu_items.bind('mouseenter',function(){
					var $this = $(this);
					$this.addClass('slided selected');
					$this.children('div').css('z-index','9999').stop(true,true).slideDown(200,function(){
						$oe_menu_items.not('.slided').children('div').hide();
						$this.removeClass('slided');
					});
				}).bind('mouseleave',function(){
					var $this = $(this);
					$this.removeClass('selected').children('div').css('z-index','1');
				});

				$oe_menu.bind('mouseenter',function(){
					var $this = $(this);
					$oe_overlay.stop(true,true).fadeTo(200, 0.6);
					$this.addClass('hovered');
				}).bind('mouseleave',function(){
					var $this = $(this);
					$this.removeClass('hovered');
					$oe_overlay.stop(true,true).fadeTo(200, 0);
					$oe_menu_items.children('div').hide();
				})
            });
        </script>
    </body>
</html>