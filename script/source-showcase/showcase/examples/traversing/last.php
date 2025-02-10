<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
  <div id="divLast">
    <ul>
      <li>First</li>
      <li>Second</li>
      <li>Third</li>
      <li>Fourth</li>
    </ul>
  </div>
  <input type="button" id="btnRunLast" value="Run" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunLast')
  ->execute(
    YsJQuery::last()->in('#divLast > ul > li'),
    YsJQuery::css('background-color', 'red')
  )
?>
</div>