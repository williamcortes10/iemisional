<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<?php YsJQuery::usePlugin(YsJQueryConstant::PLUGIN_PNOTYFY); ?>

<input value="Notice" id="btnNotice" type="button" />
<input value="Remove all" id="btnRemoveAll" type="button" />

<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnNotice')
  ->execute(
      YsPNotify::build('Simple message')->_pnotify_closer(false)
  );
 
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRemoveAll')
  ->execute(
    YsPNotify::removeAll()
  )
?>