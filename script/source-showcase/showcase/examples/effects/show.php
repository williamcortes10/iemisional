<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Run" id="btnRunShow" />
<div id="divToShow" style="display:none">
  <img style="background-color:black" 
       src="images/jquery4php-logo.jpg"
       width="215" height="53" />
</div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunShow')
  ->execute(
    YsJQuery::show()
      ->in('#divToShow')
      ->duration(YsJQueryConstant::FAST)
      ->callback('alert("Show callback")')
  )
?>
</div>