<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<button id="btnWrap">wrap</button>
<div id="blockToWrap">
  <div>
  <p>Hello</p>
  <p>cruel</p>
  <p>World</p>
  </div>
</div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnWrap')
  ->execute(
    YsJQuery::wrap('<div></div>')->in('#blockToWrap  p')
  )
?>
</div>