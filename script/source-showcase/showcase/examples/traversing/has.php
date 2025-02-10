<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
  <div class="hasSpan border_block"></div>
  <div class="hasSpan border_block"></div>
  <div class="hasSpan border_block"><span></span></div>
  <div class="hasSpan border_block"></div>
  <div class="hasSpan border_block"></div>
  <br><br><br><br><br>
  <input type="button" id="btnRunHas" value="Run" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunHas')
  ->execute(
    YsJQuery::has('span')->in('.hasSpan'),
    YsJQuery::append('This has a span')
  )
?>

</div>