<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Run" id="btnRunFadein" />
<div style="display:none" id="divToFadeIn">
  <img style="background-color:black" 
       src="images/jquery4php-logo.jpg"
       width="215" height="53" />
</div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunFadein')
  ->execute(
    YsJQuery::fadeIn()
      ->in('#divToFadeIn')
      ->duration(YsJQueryConstant::SLOW)
      ->callback('alert("Fade In")')
  )
?>
</div>