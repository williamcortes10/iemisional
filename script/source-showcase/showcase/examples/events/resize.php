<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<p>Resize the window</p>
<p id="logForResize" style="color:blue"></p>
<?php
echo
YsJQuery::newInstance()
  ->onResize()
  ->in('window')
  ->executeOnReady(
    YsJQuery::append('The window resizing. ')->in('#logForResize')
  )
?>
</div>