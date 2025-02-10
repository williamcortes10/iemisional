<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="text" id="txtFocusIn" >
<?php
echo
YsJQuery::newInstance()
  ->onFocusin()
  ->in('#txtFocusIn')
  ->execute("alert('On focusin')")
?>           
</div>