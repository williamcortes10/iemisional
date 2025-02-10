<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" id="btnRemoveClass" value="Remove Class">
<div id="blockToRemoveClass" class="blue_block">
  Hello World
</div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRemoveClass')
  ->execute(
    YsJQuery::removeClass('blue_block')->in('#blockToRemoveClass')
  )
?>
</div>