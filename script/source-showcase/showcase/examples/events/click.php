<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<div style="background-color:red" id="divToClik">
Click Me!!!
</div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#divToClik')
  ->execute(
      YsJQuery::slideUp()->in('this')
  )
?>
</div>