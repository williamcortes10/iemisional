<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Run" id="btnRunHide" />
<div id="divToHide">
  <img style="background-color:black"
       src="images/jquery4php-logo.jpg"
       width="215" height="53" />
</div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunHide')
  ->execute(
    YsJQuery::hide()
      ->in('#divToHide')
      ->duration(YsJQueryConstant::FAST)
      ->callback('alert("Hide callback")')
  )
?>
</div>