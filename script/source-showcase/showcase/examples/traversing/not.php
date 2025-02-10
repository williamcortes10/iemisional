<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
  <div id="divNot">
    <div class="border_block"></div>
    <div class="border_block"></div>
    <div>no class</div>
    <div class="border_block"></div>
    <div class="border_block"></div>
  </div>

  <br><br><br><br><br><br>
  <input type="button" id="btnRunNot" value="Run" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunNot')
  ->execute(
    YsJQuery::not('.border_block')->in('#divNot > div'),
    YsJQuery::html('border_block'),
    YsJQuery::addClass('border_block')
  )
?>

</div>