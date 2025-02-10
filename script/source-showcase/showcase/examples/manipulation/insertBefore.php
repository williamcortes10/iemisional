<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<div style="display:none">
  <span id="templateToInsertBefore">Hello</span>
</div>
<p id="blockInsertBefore">Click Me: World </p>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#blockInsertBefore')
  ->execute(
    YsJQuery::insertBefore('#blockInsertBefore')
              ->in('#templateToInsertBefore')
  )
?>
</div>