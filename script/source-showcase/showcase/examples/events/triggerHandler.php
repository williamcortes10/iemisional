<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Focus" id="btnTrigger2" />
For Trigger <br>
<input type="button" value="Focus" id="btnTriggerHandler" />
For TriggerHandler <br>
<br>
<input type="text" value="" id="txtFocus2" />
<p id="logTriggerHandler" style="color:green"></p>
<?php  echo YsJQuery::newInstance()
              ->onFocus()
              ->in('#txtFocus2')
              ->execute(
                YsJQuery::append('Hocus Focus ')->in('#logTriggerHandler')
              ) ?>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnTrigger2')
  ->execute(
    YsJQuery::trigger()
      ->in('#txtFocus2')
      ->eventType(YsJQueryConstant::FOCUS_EVENT)
  )
?>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnTriggerHandler')
  ->execute(
    YsJQuery::triggerHandler()
      ->in('#txtFocus2')
      ->eventType(YsJQueryConstant::FOCUS_EVENT)
  )
?>
</div>