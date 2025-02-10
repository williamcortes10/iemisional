<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
  <div id="divFirst">
    <ul>
      <li>First</li>
      <li>Second</li>
      <li>Third</li>
      <li>Fourth</li>
    </ul>
  </div>
  <input type="button" id="btnRunFirst" value="Run" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunFirst')
  ->execute(
    YsJQuery::first()->in('#divFirst > ul > li'),
    YsJQuery::css('background-color', 'red')
  )
?>
</div>