<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<p id="blockAddClass">Click Me</p>
<?php
echo YsJQuery::newInstance()
       ->onClick()
       ->in('#blockAddClass')
       ->execute(
         YsJQuery::addClass()->in('this')->className('selected highlight')
       )
?>
</div>