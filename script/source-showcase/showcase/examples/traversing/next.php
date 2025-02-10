<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
  <div id="divNext">
    <button disabled="disabled">First</button> - <span></span><br>
    <button>Second</button> - <span></span><br>
    <button disabled="disabled">Third</button> - <span></span><br>
  </div>
  <input type="button" id="btnRunNext" value="Run" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunNext')
  ->execute(
    YsJQuery::next()->in('#divNext > button[disabled]'),
    YsJQuery::text('this button is disabled')
  )
?>

</div>