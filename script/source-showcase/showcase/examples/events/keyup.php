<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="text" value="" id="txtKeyup">
<?php
echo
YsJQuery::newInstance()
  ->onKeyup()
  ->in('#txtKeyup')
  ->execute("alert('On key UP')")
?> 
</div>