<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Click me" id="btnLive" >
<input type="button" value="Die" id="btnKiller" >
<?php
echo
YsJQuery::newInstance()
  ->execute(
    YsJQuery::live()
      ->in('#btnLive')
      ->eventType(YsJQueryConstant::CLICK_EVENT)
      ->handler('jQuery(this).after("<p>Another paragraph!</p>")')
  )
?>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnKiller')
  ->execute(
    YsJQuery::dieEvent()
      ->in('#btnLive')
      ->eventType(YsJQueryConstant::CLICK_EVENT))
?>    
</div>