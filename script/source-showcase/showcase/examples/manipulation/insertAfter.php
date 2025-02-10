<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<div style="display:none">
  <span id="templateToInsertAfter">World</span>
</div>
<p id="blockInsertAfter">Click Me: Hello </p>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#blockInsertAfter')
  ->execute(
    YsJQuery::insertAfter('#blockInsertAfter')->in('#templateToInsertAfter')
  )
?>
</div>