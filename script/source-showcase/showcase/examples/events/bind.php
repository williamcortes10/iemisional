<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Bind" id="btnBind">
<div id="bindExample">Click me</div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnBind')
  ->execute(
    YsJQuery::bind()
      ->in('#bindExample')
      ->eventType('click')
      ->eventData(array('foo' => 'bar'))
      ->handler(new YsJsFunction('alert(event.data.foo)','event'))
  )
?>
</div>