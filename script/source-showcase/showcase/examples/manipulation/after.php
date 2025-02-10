<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<p id="blockAfter">Click Me</p>
<?php
echo YsJQuery::newInstance()
       ->onClick()
       ->in('#blockAfter')
       ->execute(
         YsJQuery::after()->in('this')->content('<b> Hello</b>')
       )
?>
</div>