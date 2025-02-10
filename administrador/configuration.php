<?php

/**
 * @author William Eduardo Cortes
 * @copyright 2012
 */
//$conx = new ConxMySQL("localhost","root","","bdaltono");
include('../class/MySqlClass.php');
$conx = new ConxMySQL("localhost","root","","appacademy");
$sql = "SELECT valor FROM appconfig WHERE item = 'ie'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$ie = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'nrector'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$nrector = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'nca'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$nca = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'pub'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$pub = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'telefono'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$telefono = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'direccion'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$direccion = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'resol'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$resol = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'nit'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$nit = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'aniolect'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$al = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'periodon'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$pnv = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'periodo_hab'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$pv = $records['valor'];
//-----------------------------------------escalas de calificacion
$sql = "SELECT valor FROM appconfig WHERE item = 'rcsmax'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$rcsmax = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'rcsmin'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$rcsmin = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'rcamax'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$rcamax = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'rcamin'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$rcamin = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'rcbmax'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$rcbmax = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'rcbmin'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$rcbmin = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'rcbamax'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$rcbamax = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'rcbamin'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$rcbamin = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'index_docen_full'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$id = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'index_docen_nv'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$idn = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'index_docen_nr'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$idnr = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'pages'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$pages = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'convenciones'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$convenciones = $records['valor'];
$sql = "SELECT valor FROM appconfig WHERE item = 'plannotaspages'";
$consulta = $conx->query($sql);    
$records = $conx->records_array($consulta);
$canest = $records['valor'];

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin">
<title>JourAcademy-Cofiguración del Sistema</title>
<script type="text/javascript" src="../script/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    
    $("#okie").hide(2000);
    $("#okal").hide(2000);
    $("#aniolect").change(function (){
        $("#okal").hide(1000);
    });
    $("#rcsmax").change(function (){
        $("#okal").hide(1000);
    });
    $("#rcsmin").change(function (){
        $("#okal").hide(1000);
    });
    $("#viewerdbi").click(function(){
        $("#div_dbi").slideToggle(3000, function(){});
         $("#resultdbi").hide(3000);
    });
    
    $("#viewerdbca").click(function(){
        $("#div_dbca").slideToggle(3000, function(){});
    });
    
    $("#vieweradminsit").click(function(){
        $("#div_adminsit").slideToggle(3000, function(){});
    });
    
    //Enviando datos del formulario de datos basicos de la institucion
    $("#frmdbi").submit(function(event) {
	
		// stop form from submitting normally
		event.preventDefault(); 
		// get some values from elements on the page:
		ie=$('#ie').val();
		nrector=$('#nrector').val();
        nca=$('#nca').val();
		pub=$('#pub').val();
		nit=$('#nit').val();
		tel=$('#tel').val();
		dir=$('#dir').val();
		resol=$('#resol').val();
		logo= $('#logo').val();
		
		// Send the data using post and put the results in a div
		$.post( "configuration_response.php", {ie1: ie, nrector1: nrector, nca1:nca, pub1:pub, nit1:nit, tel1:tel, dir1:dir, resol1:resol, logo1:logo},
		  function( data ) {
			  
              //alert("¡Los Datos Basicos de la Institución se Guardaron con Exito!");
              $("#okie").html(data);
              $("#okie").show(1000);
              //$("#div_dbi").hide(3000);
	
		  }
		);
	  });
      
      //Enviando datos del formulario de datos de appconfig académica
    $("#frmdbca").submit(function(event) {
	
		// stop form from submitting normally
		event.preventDefault(); 
		// get some values from elements on the page:
		al=$('#aniolect').val();
		plv=$('#periodolv').val();
		pnv=$('#periodonv').val();
		rcsmax1=$('#rcsmax').val();
		rcsmin1=$('#rcsmin').val();
		rcamax1=$('#rcamax').val();
        rcamin1=$('#rcamin').val();
        rcbmax1=$('#rcbmax').val();
        rcbmin1=$('#rcbmin').val();
		rcbamax1=$('#rcbamax').val();
        rcbamin1=$('#rcbamin').val();
        if(rcsmax1>rcsmin1 && rcamax1>rcamin1 && rcbmax1>rcbmin1 && rcbamax1>rcbamin1 && rcbamax1<rcbmin1 && rcbmax1<rcamin1 && rcamax1<rcsmin1 && rcbamin1>0){
    		// Send the data using post and put the results in a div
    		$.post( "configurationdba_response.php", {rcsmin:rcsmin1, rcsmax:rcsmax1, rcamin:rcamin1, rcamax:rcamax1, rcbmin:rcbmin1, rcbmax:rcbmax1, rcbamin:rcbamin1, rcbamax:rcbamax1, aniolect:al, periodolv:plv, periodonv: pnv },
    		  function( data ) {                  
                  $("#okal").html(data);
                  $("#okal").show(1000);
                  //$("#div_dbi").hide(3000);
    	
    		  }
    		);
        }else{
            alert("¡No se Guardaron los datos, revise las escalas de calificación");
        }
	  });
	  
	  //Enviando datos del administracion de sitios
    $("#frmadminsit").submit(function(event) {
	
		// stop form from submitting normally
		event.preventDefault(); 
		// get some values from elements on the page:
		id=$('input:radio[name=indexdo]:checked').val();
		idn=$("input[name=indexdon]:checked").val();
		idnr=$("input[name=indexdonr]:checked").val();
		// Send the data using post and put the results in a div
		$.post( "configurationadsit_response.php", {id1: id, idn1: idn, idnr1: idnr},
		  function( data ) {
			  
              //alert("¡Los Datos Basicos de la Institución se Guardaron con Exito!");
              $("#oksit").html(data);
              $("#oksit").show(1000);
              //$("#div_dbi").hide(3000);
	
		  }
		);
	  });
	  //enviando datos de configuracion de impresion
	  $("#frmaimp").submit(function(event) {
	
		// stop form from submitting normally
		event.preventDefault(); 
		// get some values from elements on the page:
		pages=$('#pages').val();
		convencion=$('#convencion').val();
		canestudiantes=$('#canestudiantes').val();
		// Send the data using post and put the results in a div
		$.post( "configurationimp_response.php", {pages1: pages,convencion1: convencion, canestudiantesxhoja:canestudiantes},
		  function( data ) {
			  
              //alert("¡Los Datos Basicos de la Institución se Guardaron con Exito!");
              $("#okimp").html(data);
              $("#okimp").show(1000);
              //$("#div_dbi").hide(3000);
              //$("#div_dbi").hide(3000);
	
		  }
		);
	  });
	  
});
</script>
</head>

<body>
<h1>Configuración del Sistema</h1>
<hr />
<hr />
<br /><br />
<h2>Datos Básicos de la Institución</h2>
<hr />
<div id="div_dbi">
<form id="frmdbi" name="frmdbi" action="" method="post">
    <table>
    <tr>
    <td width="170px">Nombre de la Institución:</td>
    <td><input type='text' maxlength="80" autofocus="" size="80" id="ie" name="ie" value="<?php echo utf8_decode($ie);?>"/><label id="okie"></label></td>
    </tr>
    <tr>
    <td width="170px">Nombre del Rector (a):</td>
    <td><input type='text' maxlength="40" autofocus="" size="40" id="nrector" name="nrector" value="<?php echo utf8_decode($nrector);?>"/></td>
    </tr>
    <tr>
    <td width="270px">Nombre del Coordinador(a) Academico:</td>
    <td><input type='text' maxlength="40" autofocus="" size="40" id="nca" name="nca" value="<?php echo utf8_decode($nca);?>"/></td>
    </tr>
    <tr>
    <td width="170px">Encabezado Publicitario:</td>
    <td><input type='text' maxlength="80" autofocus="" size="80" id="pub" name="pub" value="<?php echo utf8_decode($pub);?>"/></td>
    </tr>
    <tr>
    <td width="170px">Nit:</td>
    <td><input type='text' maxlength="10" autofocus="" size="10" id="nit" name="nit" value="<?php echo utf8_decode($nit);?>"/></td>
    </tr>
    <tr>
    <td width="170px">Telefono:</td>
    <td><input type='text' maxlength="10" autofocus="" size="10" id="tel" name="tel" value="<?php echo utf8_decode($telefono);?>"/></td>
    </tr>
    <tr>
    <td width="170px">Dirección:</td>
    <td><input type='text' maxlength="20" autofocus="" size="20" id="dir" name="dir" value="<?php echo utf8_decode($direccion);?>"/></td>
    </tr>
    <tr>
    <td width="170px">Resolución Secretaria:</td>
    <td><input type='text' maxlength="80" autofocus="" size="80" id="resol" name="resol" value="<?php echo utf8_decode($resol);?>"/></td>
    </tr>
    <tr>
    <td width="170px">Cargar Logo Institucional:</td>
    <td><input type='file' id="logo" name="logo"/></td>
    </tr>
    <tr>
    <td width="170px"></td>
    <td><input type="submit" value="Guardar" id="btnsubmitdbi" name="btnsubmitdbi"/></td>
    </tr>
    </table>
</form>
</div>
<a href="#" id="viewerdbi">Ver/Ocultar</a>
<div id="resultdbi"></div>
<hr />
<h2>Datos de Configuración Académica</h2>
<hr />
<div id="div_dbca">
<form id="frmdbca" name="frmdbca" action="">
    <table>
    <tr>
    <td width="170px">Año Lectivo Vigente:</td>
    <td>
    <select id="aniolect" name="aniolect">
        <?php
        for($i=(int)date('Y',time()); $i>1999; $i--){
            
            if($i==$al){
                echo "<option value='$i' selected/>$i";    
            }else{
                echo "<option value='$i'/>$i";
            }
            
        }
        ?>
    </select><label id="okal"></label>
    </td>
    </tr>
    <tr>
    <td width="170px">Periodo Lectivo Vigente:</td>
    <td>
    <select id="periodolv" name="periodolv">
        <?php
        for($i=1; $i<5; $i++){
            
            if($i==$pv){
                echo "<option value='$i' selected/>$i";    
            }else{
                echo "<option value='$i'/>$i";
            }
        }
        ?>
    </select>
    </td>
    </tr>
    <tr>
    <td width="170px">Periodo Nivelación Vigente:</td>
    <td>
    <select id="periodonv" name="periodonv">
        <?php
        for($i=1; $i<5; $i++){
            
            if($i==$pnv){
                echo "<option value='$i' selected/>$i";    
            }else{
                echo "<option value='$i'/>$i";
            }
        }
        ?>
    </select>
    </td>
    </tr>
    <tr><td colspan="2"><br /><h3>Escala de Calificación Académica</h3></td></tr>
    <tr>
    <td width="220px">Rango de calificación superior (DS):</td>
    <td><input type='text' maxlength="3" autofocus="" size="4" id="rcsmin" name="rcsmin" alt="Minimo" value="<?php echo utf8_decode($rcsmin);?>"/> a
    <input type='text' maxlength="3" autofocus="" size="4" id="rcsmax" name="rcsmax" alt="Maximo" value="<?php echo utf8_decode($rcsmax);?>"/></td>
    </tr>
    <tr>
    <td width="220px">Rango de calificación Alto (DA):</td>
    <td><input type='text' maxlength="3" autofocus="" size="4" id="rcamin" name="rcamin" value="<?php echo utf8_decode($rcamin);?>"/> a
    <input type='text' maxlength="3" autofocus="" size="4" id="rcamax" name="rcamax" value="<?php echo utf8_decode($rcamax);?>"/></td>
    </tr>
    <tr>
    <td width="220px">Rango de calificación Básico (DB):</td>
    <td><input type='text' maxlength="3" autofocus="" size="4" id="rcbmin" name="rcbmin" value="<?php echo utf8_decode($rcbmin);?>"/> a
    <input type='text' maxlength="3" autofocus="" size="4" id="rcbmax" name="rcbmax" value="<?php echo utf8_decode($rcbmax);?>"/></td>
    </tr>
    <tr>
    <td width="220px">Rango de calificación Bajo (Db):</td>
    <td><input type='text' maxlength="3" autofocus="" size="4" id="rcbamin" name="rcbamin" value="<?php echo utf8_decode($rcbamin);?>"/> a
    <input type='text' maxlength="3" autofocus="" size="4" id="rcbamax" name="rcbamax" value="<?php echo utf8_decode($rcbamax);?>"/></td>
    </tr>
    <tr>
    <td width="170px"></td>
    <td><input type="submit" value="Guardar" id="btnsubmitdba" name="btnsubmitdba"/></td>
    </tr>
    </table>
</form>
</div>
<a href="#" id="viewerdbca">Ver/Ocultar</a>
<hr />
<h2>Administración de Sitios</h2>
<hr />
<div id="div_adminsit">
<form id="frmadminsit" name="frmadminsit" action="#" method="post">
    <table>
    <tr>
    <td width="200px">Habilitar sitio principal docentes:</td>
    <td>Si<input type="radio" id="indexdo" name="indexdo" value="on"/>No<input type="radio" id="indexdo" name="indexdo" value="of"/></td>
    </tr>
    <tr>
    <td width="170px">Habilitar sitio nivelaciones:</td>
    <td>Si<input type="radio" id="indexdon" name="indexdon" value="on"/>No<input type="radio" id="indexdon" name="indexdon" value="of"/><label id="oksit"></label></td>
    </tr>
	<tr>
    <td width="170px">Habilitar sitio notas regulares:</td>
    <td>Si<input type="radio" id="indexdonr" name="indexdonr" value="on"/>No<input type="radio" id="indexdonr" name="indexdonr" value="of"/><label id="oksit"></label></td>
    </tr>
    <td width="170px"></td>
    <td><input type="submit" value="Guardar" id="btnsubmitsit" name="btnsubmitsit"/></td>
    </tr>
    </table>
</form>
</div>
<a href="#" id="vieweradminsit">Ver/Ocultar</a>
<h2>Configurar formato de impresión</h2>
<hr />
<div id="div_imp">
<form id="frmaimp" name="frmaimp" action="#" method="post">
    <table>
    <tr>
    <td width="170px">Numero de materias por hoja (Boletin):</td>
    <td>
    <select id="pages" name="pages">
        <?php
        for($i=1; $i<10; $i++){
            
            if($i==$pages){
                echo "<option value='$i' selected/>$i";    
            }else{
                echo "<option value='$i'/>$i";
            }
            
        }
        ?>
    </select><label id="okimp"></label>
    </td>
    </tr><tr>
    <td width="170px">Imprimir convenciones en otra pagina (Boletin):</td>
    <td>
    <select id="convencion" name="convencion">
        <?php
            if($convenciones=='on'){
                echo "<option value='on' selected/>SI";
				echo "<option value='of' />NO";     
            }else{
				echo "<option value='of' selected/>NO";     
				echo "<option value='on'/>SI";
            }
        ?>
    </select>
	</td></tr>
	<tr>
	<td width="170px">Numero de hojas (Planilla de notas):</td>
    <td>
    <select id="canestudiantes" name="canestudiantes">
        <?php
            for($i=1; $i<30; $i++){
            
            if($i==$canest){
                echo "<option value='$i' selected/>$i";    
            }else{
                echo "<option value='$i'/>$i";
            }
            
        }
        ?>
    </select><label id="okconv"></label>
    </td>
    </tr>
	<tr>
    <td width="170px"></td>
    <td><input type="submit" value="Guardar" id="btnsubmitimp" name="btnsubmitimp"/></td>
    </tr>
    </table>
</form>
</div>
<a href="#" id="viewerimp">Ver/Ocultar</a>
<div id="resultimp"></div>
<?php
    if($id=="on"){
        echo "<script>$('input:radio[name=indexdo]:nth(0)').attr('checked', true);</script>";
    }else{
        echo "<script>$('input:radio[name=indexdo]:nth(1)').attr('checked', true);</script>";
        
    }
    if($idn=="on"){
        echo "<script>$('input:radio[name=indexdon]:nth(0)').attr('checked', true);</script>";
    }else{
        echo "<script>$('input:radio[name=indexdon]:nth(1)').attr('checked', true);</script>";
        
    }
	if($idnr=="on"){
        echo "<script>$('input:radio[name=indexdonr]:nth(0)').attr('checked', true);</script>";
    }else{
        echo "<script>$('input:radio[name=indexdonr]:nth(1)').attr('checked', true);</script>";
        
    }
?>
<br />
<span>
<a href="index.php" class="large button orange" style="font-size: 12px !important;">Regresar</a>
</span>
</body>
</html>