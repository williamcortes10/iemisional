<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
		include("../../class/ultimatemysql/mysql.class.php");
		$conx = new MySQL();
		if (! $conx->Open("appacademy", "localhost", "root", "")) {
			$conx->Kill();
		}
		$sql = "SELECT DISTINCT iddocente, nombre1, nombre2, apellido1, apellido2, profesion, email FROM docente WHERE iddocente = '".$_GET["id"]."'";
		if ($conx->QueryArray($sql)) {
			$conx->MoveFirst();
			while (! $conx->EndOfSeek()) {
				$row = $conx->Row();
				$iddocente=$row->iddocente;
				$nombre1=$row->nombre1;
				$nombre2=$row->nombre2;
				$apellido1=$row->apellido1;
				$apellido2=$row->apellido2;
				$profesion=$row->profesion;
				$email=$row->email;
			}
		}
	
?>
<html>
    <head>
        <title></title>
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
			$("#resultado").hide(3000);
			$("#formupuser").submit(function(event) {
			
				// stop form from submitting normally
				event.preventDefault(); 
					
				// get some values from elements on the page:
				iddocente1=$('#iddocente').val();
				iddocenteback1=$('#iddocenteback').val();
				apellido11=$('#apellido1').val();
				apellido22=$('#apellido2').val();
				nombre11=$('#nombre1').val();
				nombre22=$('#nombre2').val();
				profesion1=$('#profesion').val();
				email1=$('#email').val();
				
				tipouser=$('#tipo_user').val();
				pass=$('#password').val();
				
				// Send the data using post and put the results in a div
				$.post( "updocente_sucess.php", {iddocente: iddocente1,iddocenteback:iddocenteback1, apellido1: apellido11, apellido2:apellido22,
				nombre1:nombre11, nombre2:nombre22, profesion:profesion1, email: email1} ,
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
				height:20px;
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
		<div class="form">
			<div id="stylized" class="myform">
			<form id="formupuser" name="formupuser" method="post" action="">
			<h1>Formulario  - Actualizar Docente</h1>
			<p>Ingrese los datos para agregar docente</p>
			<label>Identificaci&oacute;n
			<span class="small">Maximo 10 digitos<span style="color:red">*</span></span>
			</label>
			<?php
			echo "<input type='text' name='iddocente' id='iddocente' size='10' maxlength='10' value='$iddocente'/>";
			echo "<input type='hidden' name='iddocenteback' id='iddocenteback' size='10' maxlength='10' value='$iddocente'/>";
			?>
			<label>Primer Apellido
			<span class="small">Maximo 20 caracteres<span style="color:red">*</span></span>
			</label>
			<?php
			echo "<input type='text' name='apellido1' id='apellido1' size='20' maxlength='20' value='$apellido1'/>";
			?>
			<label>Segundo Apellido
			<span class="small">Maximo 20 caracteres</span>
			</label>
			<?php
			echo "<input type='text' name='apellido2' id='apellido2' size='20' maxlength='20' value='$apellido2'/>";
			?>			
			<label>Primer Nombre
			<span class="small">Maximo 20 caracteres<span style="color:red">*</span></span>
			</label>
			<?php
			echo "<input type='text' name='nombre1' id='nombre1' size='20' maxlength='20' value='$nombre1'/>";
			?>
			<label>Segundo Nombre
			<span class="small">Maximo 20 caracteres</span>
			</label>
			<?php
			echo "<input type='text' name='nombre2' id='nombre2' size='20' maxlength='20' value='$nombre2'/>";
			?>			
			<label>Profesi&oacute;n
			<span class="small">Maximo 30 caracteres</span>
			</label>
			<?php
			echo "<input type='text' name='profesion' id='profesion' size='30' maxlength='30' value='$profesion'/>";
			?>			
			<label>Correo Electronico
			<span class="small">Maximo 30 caracteres</span>
			</label>
			<?php
			echo "<input type='text' name='email' id='email' size='30' maxlength='30' value='$email'/>";
			?>			
			<button type="submit">Actualizar</button>
			<div class="spacer"></div>

			</form>
			<div id="resultado">
			
			</div>
			<span>
				<a href='actualizar_docente.php' class='large button orange' style='font-size: 12px !important;'><img src="../../images/back.png" id="back" alt="Regresar" /></a>
			</span>
			<span>
				<span style='font-size: 9px !important;' class="small"><span style="color:red">*</span> Campos requeridos</span>
		</div>
		
        <div>
            <span class="reference">
                <a href="#">Derechos reservados</a>
				<a href="#" target="_blank">williamcortes10@gmail.com</a>
            </span>
		</div>

        </script>
    </body>
</html>