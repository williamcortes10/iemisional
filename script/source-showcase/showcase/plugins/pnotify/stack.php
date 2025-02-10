<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<style type="text/css">
  /* <![CDATA[ */
  /* Alternate stack initial positioning. */
  .ui-pnotify.stack-topleft {
    top: 15px;
    left: 15px;
    right: auto;
  }
  /* ]]> */
</style>

<?php YsJQuery::usePlugin(YsJQueryConstant::PLUGIN_PNOTYFY); ?>

<input value="Show" id="btnShow" type="button" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnShow')
  ->execute(
    YsPNotify::build("Message from button")
      ->_pnotify_addclass('ui-pnotify stack-topleft')
      ->_pnotify_title('Error')
      ->_pnotify_type(YsPNotify::ERROR_TYPE)
  );
?>