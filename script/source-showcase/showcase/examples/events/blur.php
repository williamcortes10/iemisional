<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="Text" value="Blur" id="txtBlur">
<?php
echo
YsJQuery::newInstance()
  ->onBlur()
  ->in('#txtBlur')
  ->execute("alert('Handler for .blur() called.')")
?>
</div>