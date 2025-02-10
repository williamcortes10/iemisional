<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Run" id="btnRunSlideUp" />
<div id="divToSlideUp">
  <img style="background-color:black" 
       src="images/jquery4php-logo.jpg"
       width="215" height="53" />
</div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunSlideUp')
  ->execute(
    YsJQuery::slideUp()
      ->in('#divToSlideUp')
      ->duration(2000)
      ->callback('alert("SlideUp callback")')
  )
?>
</div>