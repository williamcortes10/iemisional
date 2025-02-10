<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Run" id="btnRunFadeout" />
<div id="divToFadeOut">
  <img style="background-color:black" 
       src="images/jquery4php-logo.jpg"
       width="215" height="53" />
</div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunFadeout')
  ->execute(
    YsJQuery::fadeOut()
      ->in('#divToFadeOut')
      ->duration(YsJQueryConstant::SLOW)
      ->callback('alert("Fade Out")')
  )
?>
</div>