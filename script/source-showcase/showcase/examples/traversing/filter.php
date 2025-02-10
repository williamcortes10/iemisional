<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
  <div id="divFilter">
    <span>[</span>
    <span class="middle"></span>
    <span class="middle"></span>
    <span class="half">1</span>
    <span class="middle"></span>
    <span class="middle"></span>
    <span>]</span>
  </div>
  <input type="button" id="btnRunFilter" value="Run" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunFilter')
  ->execute(
    YsJQuery::filter('.middle')->in('#divFilter > span'),
    YsJQuery::html('0')
  )
?>
</div>