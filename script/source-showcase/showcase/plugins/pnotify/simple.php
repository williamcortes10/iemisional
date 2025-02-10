<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php YsJQuery::usePlugin(YsJQueryConstant::PLUGIN_PNOTYFY); ?>

<input value="Say" id="say" type="button" />
<input value="Error" id="error" type="button" />
<input value="Notice" id="notice" type="button" />
<input value="Alarm" id="alarm" type="button" />


<?php
echo
YsJQuery::newInstance()->onClick()->in('#say')->execute(
  YsPNotify::say('Simple message')
);
echo
YsJQuery::newInstance()->onClick()->in('#error')->execute(
  YsPNotify::error('Error message')
);
echo
YsJQuery::newInstance()->onClick()->in('#notice')->execute(
  YsPNotify::notice('Notice message')
);
echo
YsJQuery::newInstance()->onClick()->in('#alarm')->execute(
  YsPNotify::alarm('Alarm message')
);
?>