<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Click me" id="btnOnReadyEvent">
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnOnReadyEvent')
  ->executeOnReady(
   'alert("I am ready")'
  )
?>
</div>