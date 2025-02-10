<?php
session_start();
include('../../class/MySqlClass.php');

$conx = new ConxMySQL("localhost","root","","appacademy");
$sql = "SELECT valor FROM appconfig WHERE item='ie'";
$consulta = $conx->query($sql);
$records = $conx->records_array($consulta);
$ie= $records['valor']; 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>JourAcademy - ::<?php echo utf8_encode($ie); ?>::</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="description" content="" />
        <meta name="keywords" content=""/>
		<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"/>
		<link rel="stylesheet" href="../../css/form.css" type="text/css" media="screen"/>
		<script type="text/javascript" src="../../script/jquery.min.js"></script>
		<script type="text/javascript">
		
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
	<div class="bg_img"><img src="../../images/1.jpg" alt="background" /></div>
		<h1>APP ACADEMY<span>La manera mas facil de administrar sus notas y boletines academicos</span></h1>
			<div id="stylized" class="myform">
			<form id="formupuser" name="formupuser" method="post" action="loginresponse.php">
			<h1><?php echo "$ie"; ?></h1>
            <h3 color='black'>Inicio de Sesión </h3>
			<p>Para ingresar al sistema complete los datos</p>
			<label class="description" for="user">Usuario 
			<span class="small">Ingrese nombre de usuario<span style="color:red">*</span></span>
			</label>
			<input id="user" name="user" class="element text medium" type="text" maxlength="10" value=""/> 
		    <label class="description" for="pass">Clave 
			<span class="small">Ingrese la clave<span style="color:red">*</span></span>
			</label>
			<input id="pass" name="pass" class="element text medium" type="password" maxlength="20" value=""/> 
			<label>Tipo Usuario
			</label>
			<select id='tp_user' name="tp_user">
				<option value='A'>Administrador</option>
				<option value='D'>Docente</option>
			</select>
			<button type="submit">Iniciar</button>
			</form>
		</div>
		<div>
            <span class="reference">
                <a href="http://tympanus.net/codrops/2010/11/25/overlay-effect-menu/">Derechos reservados</a>
				<a href="http://www.flickr.com/photos/duke9042004/" target="_blank">williamcortes10@gmail.com</a>
            </span>
		</div>
		
	
			

</body>
</html>