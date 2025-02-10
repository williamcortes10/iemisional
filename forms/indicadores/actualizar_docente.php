<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
 			$("#result").hide();
  			$("#txt_filtro").keyup(function(){
  				txt=$("#txt_filtro").val();
  				$.post("updocente_response.php",{str_search:txt},function(data){
    					$("#result").html(data);
					$("#result").show(1000);
  				});
			});
		});
		function updateReg(codigo){
			$(document).ready(function(){
				
				location.href='updatedocentefrm.php?id='+codigo;	
			  
			});
		}
		function deleteReg(codigo){
			$(document).ready(function(){
			  var agree=confirm("Realmente desea eliminar este registro? ");
			  if (agree){
				$.post("deletedocensucess.php",{str_del:codigo},function(result){
				  alert(result);
				});
				
			  }
			  

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
	<?php
		include("../../class/ultimatemysql/mysql.class.php");
		$conx = new MySQL();
		if (! $conx->Open("appacademy", "localhost", "root", "")) {
			$conx->Kill();
		}
	
	?>
	<div class="bg_img"><img src="../../images/1.jpg" alt="background" /></div>
		<h1>APP ACADEMY<span>La manera mas facil de administrar sus notas y boletines academicos</span></h1>
		<div class="form">
			<div id="stylized" class="myform2">
			<form id="formupuser" name="formupuser" method="post" action="">
			<h1>Formulario  - Actualizar/Eliminar Docente</h1>
			<p>Ingrese el codigo o nombre para buscar registro</p>
			<label for="txt_filtro">Buscar</label>
			<input type="text" id="txt_filtro" />
				
			<div id="result">
			
			</div>
			<div class="spacer"></div>
			</form>
			<p><span>
				<a href='../../index.php' class='large button orange' style='font-size: 12px !important;'><img src="../../images/back.png" id="back" alt="Regresar" /></a>
			</span></p>
			
			
			
		</div>
			

</body>
</html>
