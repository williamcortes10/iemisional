<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
  <div id="divSlice">
    <div class="border_block"></div>
    <div class="border_block"></div>
    <div class="border_block"></div>
    <div class="border_block"></div>
    <div class="border_block"></div>
  </div>
  <br><br><br><br><br><br>
  <input type="button" id="btnRunSlice" value="Run" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunSlice')
  ->execute(
    YsJQuery::slice(2)->in('#divSlice > div'),
    YsJQuery::css('background-color','yellow')
  )
?>

</div>