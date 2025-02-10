<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="text" id="txtFocusOut" >
<?php
echo
YsJQuery::newInstance()
  ->onFocusout()
  ->in('#txtFocusOut')
  ->execute("alert('On focus out')")
?>
</div>