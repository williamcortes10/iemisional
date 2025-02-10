<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
  <div id="addExample">
    <div style="width:60px; height:60px; margin:10px; float:left;"></div>
    <div style="width:60px; height:60px; margin:10px; float:left;"></div>
    <div style="width:60px; height:60px; margin:10px; float:left;"></div>
    <div style="width:60px; height:60px; margin:10px; float:left;"></div>
    <div style="width:60px; height:60px; margin:10px; float:left;"></div>
    <p style="clear:left; font-weight:bold; font-size:16px;
     color:blue; margin:0 10px; padding:2px;">
    </p>
    <input type="button" id="btnRunAdd" value="Run" />
  </div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunAdd')
  ->execute(
    YsJQuery::css('border', '2px solid red')->in('#addExample div'),
    YsJQuery::add('p', 'this'),
    YsJQuery::css('background', 'yellow')
  )
?>
</div>