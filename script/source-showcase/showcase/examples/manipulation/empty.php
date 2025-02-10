<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<p id="paragraphToEmpty">
   Hello, <span>Person</span> <a href="javascript:;">and person</a>
</p>
<button id="btnCallEmpty">Call empty() on above paragraph</button>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnCallEmpty')
  ->execute(
    YsJQuery::emptyEvent()->in('#paragraphToEmpty')
  )
?>
</div>