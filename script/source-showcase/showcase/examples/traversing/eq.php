<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
  <div id="divEq">
    <div style="width:60px; height:60px; margin:10px; float:left;"></div>
    <div style="width:60px; height:60px; margin:10px; float:left;"></div>
    <div style="width:60px; height:60px; margin:10px; float:left;"></div>
    <div style="width:60px; height:60px; margin:10px; float:left;"></div>
    <div style="width:60px; height:60px; margin:10px; float:left;"></div>
    <p style="clear:left; font-weight:bold; font-size:16px;
     color:blue; margin:0 10px; padding:2px;">
    </p>
    <input type="button" id="btnRunEq" value="Run" />
  </div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunEq')
  ->execute(
    YsJQuery::css('border', '2px solid red')->in('#divEq div'),
    YsJQuery::add('p', 'this'),
    YsJQuery::css('background', 'yellow'),
    YsJQuery::eq(2),
    YsJQuery::css('background', 'blue')
  )
?>
</div>