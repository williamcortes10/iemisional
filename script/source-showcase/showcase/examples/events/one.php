<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Click me" id="btnOneEvent">
<p id="logForMouseUp" style="color:red"></p>
<?php
echo
YsJQuery::newInstance()
  ->execute(
    YsJQuery::one()
      ->in('#btnOneEvent')
      ->eventType(YsJQueryConstant::CLICK_EVENT)
      ->handler("alert('Only one click')")
  )
?>
</div>