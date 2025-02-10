<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
Send the form above
<input type="button" value="Submit" id="btnTrigger" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnTrigger')
  ->execute(
    YsJQuery::trigger()
      ->in('#frmSubmitEvent')
      ->eventType(YsJQueryConstant::SUBMIT_EVENT)
  )
?>
</div>