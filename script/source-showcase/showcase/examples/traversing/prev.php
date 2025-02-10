<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
  <span> 0 </span>
  <span> 0 </span>
  <span id="spnPrev"> 2 </span>
  <span> 3 </span>
  <span> 4 </span>
  <input type="button" id="btnRunPrev" value="Run" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunPrev')
  ->execute(
    YsJQuery::prev()->in('#spnPrev'),
    YsJQuery::html('1')
  )
?>

</div>