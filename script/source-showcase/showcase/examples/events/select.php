<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="text" value="Select this text" id="txtToSelect" />
<p id="logForSelect" style="color:green"></p>
<?php
echo
YsJQuery::newInstance()
  ->onSelect()
  ->in('#txtToSelect')
  ->execute(
    YsJQuery::append('Something was selected ')->in('#logForSelect')
  )
?>
</div>