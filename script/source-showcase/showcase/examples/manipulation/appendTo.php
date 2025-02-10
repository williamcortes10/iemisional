<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<div style="display:none"><span id="template">World</span></div>
<p id="blockAppendTo">Click Me: Hello </p>
<?php
echo YsJQuery::newInstance()
       ->onClick()
       ->in('#blockAppendTo')
       ->execute(
         YsJQuery::appendTo('#blockAppendTo')->in('#template')
       )
?>
</div>