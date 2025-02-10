<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
  <div>
    <div>no class</div>
    <div>no class</div>
    <div>no class</div>
    <div>no class</div>
    <div class="border_block" id="divPrevAll"></div>
  </div>

  <br><br><br><br><br><br>
  <input type="button" id="btnRunPrevAll" value="Run" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunPrevAll')
  ->execute(
    YsJQuery::prevAll()->in('#divPrevAll'),
    YsJQuery::addClass('border_block'),
    YsJQuery::html('border_block')
  )
?>

</div>