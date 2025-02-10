<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Get Data" id="btnAjax" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnAjax')
  ->execute(
    YsJQuery::ajax()
      ->_url('examples/response/ajaxResponse.php')
      ->_async(false)
      ->_success(
        new YsJsFunction('alert(response)','response')
      )
  )
?>
</div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('.ajaxTrigger')
  ->executeOnReady(
    YsJQuery::triggerHandler()->in('#btnAjax')
                              ->eventType(YsJQueryConstant::CLICK_EVENT)
  )
?>