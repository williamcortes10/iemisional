<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
  <div>
    <div>no class</div>
    <div class="no_include">no class</div>
    <div>no class</div>
    <div>no class</div>
    <div class="border_block" id="divPrevUntil"></div>
  </div>

  <br><br><br><br><br><br>
  <input type="button" id="btnRunPrevUntil" value="Run" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunPrevUntil')
  ->execute(
    YsJQuery::prevUntil('.no_include')->in('#divPrevUntil'),
    YsJQuery::addClass('border_block'),
    YsJQuery::html('border_block')
  )
?>

</div>