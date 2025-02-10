<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Go" id="btnToggle" />
<p class="myText">Hello</p>
<p class="myText" style="display: none">Good Bye</p>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnToggle')
  ->execute(
    YsJQuery::toggle()->in('.myText')
  )
?>
<br/><br/><br/><br/><br/><br/>
</div>