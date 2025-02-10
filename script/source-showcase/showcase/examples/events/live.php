<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Do it" id="btnExecute" >
<input type="button" value="Live event" id="btnExecuteLive" >
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnExecuteLive')
  ->execute(
    YsJQuery::live()
      ->in('#btnExecute')
      ->eventType(YsJQueryConstant::CLICK_EVENT)
      ->handler('jQuery(this).after("<p>Another paragraph!</p>")')
  )
?>
</div>