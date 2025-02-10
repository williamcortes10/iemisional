<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Bind" id="btnBind2" />&nbsp;
<input type="button" value="Unbind" id="btnUnbind" />
<div id="bindExample2">Click me</div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnBind2')
  ->execute(
    YsJQuery::bind()
      ->in('#bindExample2')
      ->eventType(YsJQueryConstant::CLICK_EVENT)
      ->eventData(array('foo' => 'bar'))
      ->handler(new YsJsFunction('alert(event.data.foo)','event'))
  )
?>

<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnUnbind')
  ->execute(
    YsJQuery::unbind()
      ->in('#bindExample2')
      ->eventType(YsJQueryConstant::CLICK_EVENT)
  )
?>
</div>