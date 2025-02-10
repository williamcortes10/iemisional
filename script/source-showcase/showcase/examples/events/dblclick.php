<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Are you sure?" id="divToDblclik"  />
<?php
echo
YsJQuery::newInstance()
  ->onDblclick()
  ->in('#divToDblclik')
  ->execute('alert("Success")')
?>			  
</div>