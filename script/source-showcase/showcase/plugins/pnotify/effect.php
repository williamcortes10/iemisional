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
    YsPNotify::build('Simple message')->_pnotify_animation(YsUIConstant::SLIDE_EFFECT)
  )
?>