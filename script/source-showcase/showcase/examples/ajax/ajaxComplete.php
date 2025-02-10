<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<?php include_once 'ajax.php';?>
<div>
<div style="color:green" id="logForAjaxComplete">
</div>
<?php
echo
YsJQuery::ajaxComplete()
  ->in('#btnAjax')
  ->handler(
    YsJQuery::html()->in('#logForAjaxComplete')->value('AJAX COMPLETED')
  )
  ->executeOnReady();
?>
</div>