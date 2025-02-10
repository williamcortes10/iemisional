<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<?php include_once 'ajax.php';?>
<div>
<input type="button" value="Get Data" class="ajaxTrigger" />
<div style="color:red" id="logForAjaxStop">
</div>
<?php
echo
YsJQuery::ajaxStop()
  ->in('#btnAjax')
  ->handler(
   YsJQuery::html()->in('#logForAjaxStop')->value('On ajax stop')
  )
  ->executeOnReady();
?>
</div>