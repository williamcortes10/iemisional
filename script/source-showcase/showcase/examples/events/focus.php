<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="text" id="txtFocus" >
<?php
echo
YsJQuery::newInstance()
  ->onFocus()
  ->in('#txtFocus')
  ->execute("alert('On focus')")
?>
</div>