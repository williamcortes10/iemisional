<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<?php include_once 'ajax.php';?>
<div>
<input type="button" value="Get Data" class="ajaxTrigger" />
<div style="color:blue" id="logForAjaxStart">
</div>
<?php
echo
YsJQuery::ajaxStart()
  ->in('#btnAjax')
  ->handler(
   YsJQuery::html()->in('#logForAjaxStart')->value('On ajax start')
  )
  ->executeOnReady();
?>
</div>