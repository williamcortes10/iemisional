<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php YsJQuery::usePlugin(YsJQueryConstant::PLUGIN_PNOTYFY); ?>

<input value="Show" id="btnShow" type="button" />

<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnShow')
  ->execute(
    YsPNotify::build()->_pnotify_title('Title')
                      ->_pnotify_text('Text')
                      ->_pnotify_before_close(new YsJsFunction('alert("Before Close")'))
  )
?>