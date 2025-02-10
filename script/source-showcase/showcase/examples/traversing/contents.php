<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
  <div id="divContents">
    <p>Hello</p>
    <span>World</span>
  </div>
  <input type="button" id="btnRunContents" value="Run" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunContents')
  ->execute(
    YsJQuery::contents()->in('#divContents'),
    YsJQuery::css(array('background-color' =>'green'))
  )
?>
</div>