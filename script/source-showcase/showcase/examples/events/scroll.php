<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Activate Scroll" id="btnActivateScroll" />
<p id="logForScroll" style="color:blue"></p>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnActivateScroll')
  ->execute(
    YsJQuery::newInstance()
    ->onScroll()
    ->in('window')
    ->execute(
      YsJQuery::append('You use the scroll')->in('#logForScroll')
    )
    ->getSintax()
  )
 ?>
</div>