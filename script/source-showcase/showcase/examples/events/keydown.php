<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="text" value="" id="txtKeyDown">
<?php
echo
YsJQuery::newInstance()
  ->onKeydown()
  ->in('#txtKeyDown')
  ->execute(
    new YsJsFunction("alert('On key down, The event code is = '
                      + event.keyCode)", 'event')
  )
?>

</div>