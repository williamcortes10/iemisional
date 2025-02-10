<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
  <div>
    <div class="border_block"></div>
    <div class="border_block"></div>
    <div class="border_block" id="divSiblings">< siblings ></div>
    <div class="border_block"></div>
    <div class="border_block"></div>
  </div>

  <br><br><br><br><br><br>
  <input type="button" id="btnRunSiblings" value="Run" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunSiblings')
  ->execute(
    YsJQuery::siblings()->in('#divSiblings'),
    YsJQuery::css('background-color','blue')
  )
?>

</div>