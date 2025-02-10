<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php YsJQuery::usePlugin(YsJQueryConstant::PLUGIN_PNOTYFY); ?>

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
      ->_beforeSend(new YsJsFunction(YsPNotify::alarm("Before the request send")))
      ->_error(new YsJsFunction(YsPNotify::error("An error has occurred")))
      ->_complete(new YsJsFunction(YsPNotify::alarm("Ajax completed")->_pnotify_addclass('')))
      ->_success(
        new YsJsFunction(YsPNotify::build(YsArgument::likeVar('response')),'response')
      )
  )
?>