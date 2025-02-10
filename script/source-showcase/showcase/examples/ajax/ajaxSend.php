<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<?php include_once 'ajax.php';?>
<div>
<input type="button" value="Get Data" class="ajaxTrigger" />
<div style="color:blue" id="logForAjaxSend">
</div>
<?php
echo
YsJQuery::ajaxSend()
  ->in('#btnAjax')
  ->handler(
    YsJQuery::html()->in('#logForAjaxSend')->value('The petition was sent')
  )
  ->executeOnReady();
?>
</div>