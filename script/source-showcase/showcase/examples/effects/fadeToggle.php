<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Run" id="btnRunFadeto" />
<div id="divToFadeto">
  <img style="background-color:black" 
       src="images/jquery4php-logo.jpg"
       width="215" height="53" />
</div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunFadeto')
  ->execute(
    YsJQuery::fadeToggle()
      ->in('#divToFadeto')
      ->duration(YsJQueryConstant::SLOW)
      ->easing("linear")
      ->callback('alert("fadeToggle")')
  )
?>
</div>