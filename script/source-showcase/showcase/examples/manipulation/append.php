<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<p id="blockAppend">Click Me</p>
<?php
echo YsJQuery::newInstance()
       ->onClick()
       ->in('#blockAppend')
       ->execute(
         YsJQuery::append()->in('this')->content('<b> World</b>')
       )
?>
</div>