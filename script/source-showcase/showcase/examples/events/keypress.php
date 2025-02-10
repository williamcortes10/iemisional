<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="text" value="" id="txtKeypress">
<?php
echo
YsJQuery::newInstance()
  ->onKeypress()
  ->in('#txtKeypress')
  ->execute(
    new YsJsFunction("alert('On key down, The event code is = '
                      + String.fromCharCode(event.keyCode))", 'event')
  )
?>
</div>