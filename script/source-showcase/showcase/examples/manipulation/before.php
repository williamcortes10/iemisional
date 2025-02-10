<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<p id="blockBefore">Click Me</p>
<?php
echo YsJQuery::newInstance()
       ->onClick()
       ->in('#blockBefore')
       ->execute(
         YsJQuery::before()->in('this')->content('<b> Hello World</b>')
       )
?>
</div>