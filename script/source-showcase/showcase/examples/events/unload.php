<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
Unload this window for call the event
<?php
/* Disabled for demo
echo
YsJQuery::newInstance()
  ->onUnload()
  ->in('window')
  ->execute(
    'alert("Bye now!");'
  )
*/
?>
</div>