<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<?php include_once 'ajax.php';?>
<div>
<input type="button" value="Get Data" class="ajaxTrigger" />
<div style="color:green" id="logForAjaxSuccess">
</div>
<?php
echo
YsJQuery::ajaxSuccess()
  ->in('#btnAjax')
  ->handler(
   YsJQuery::html()->in('#logForAjaxSuccess')->value('On ajax success')
  )
  ->executeOnReady();
?>
</div>