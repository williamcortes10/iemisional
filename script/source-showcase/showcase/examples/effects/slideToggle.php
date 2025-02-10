<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Run" id="btnRunSlideToggle" />
<div id="divToSlideToggle" style="display:none">
  <img style="background-color:black" 
       src="images/jquery4php-logo.jpg"
       width="215" height="53" />
</div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunSlideToggle')
  ->execute(
    YsJQuery::slideToggle()
      ->in('#divToSlideToggle')
      ->duration(1000)
      ->callback('alert("SlideToggle callback")')
  )
?>
</div>