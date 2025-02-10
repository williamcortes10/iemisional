<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
  <div id="divNextUntil">
    <div style="width:60px; height:60px; margin:10px; float:left;"></div>
    <div style="width:60px; height:60px; margin:10px; float:left;"></div>
    <div style="width:60px; height:60px; margin:10px; float:left;"></div>
    <div style="width:60px; height:60px; margin:10px; float:left;"></div>
    <span style="width:60px; height:60px; margin:10px; float:left;"></span>
  </div>
  <br><br><br><br><br><br>
  <input type="button" id="btnRunNextUntil" value="Run" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunNextUntil')
  ->execute(
    YsJQuery::css('border', '2px solid red')->in('#divNextUntil div'),
    YsJQuery::add('p', 'this'),
    YsJQuery::css('background', 'yellow'),
    YsJQuery::eq(2),
    YsJQuery::nextUntil('span'),
    YsJQuery::css('background', 'green')
  )
?>
</div>