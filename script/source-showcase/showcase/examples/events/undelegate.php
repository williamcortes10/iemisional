<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Delegate" id="btnDelegate" />
<input type="button" value="Undelegate" id="btnUndelegate" />
<div id="divDelegate2">
  <p style="background-color: red;">Click me</p>
</div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnDelegate')
  ->execute(
    YsJQuery::delegate()
      ->in('#divDelegate2')
      ->selector('p')
      ->eventType(YsJQueryConstant::CLICK_EVENT)
      ->handler(
        '$(this).after("<p style=\"background-color: yellow;\">Test</p>");'
      )
  )
?>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnUndelegate')
  ->execute(
    YsJQuery::undelegate()
      ->in('#divDelegate2')
      ->selector('p')
      ->eventType(YsJQueryConstant::CLICK_EVENT)
  )
?>
</div>