<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php YsJQuery::usePlugin(YsJQueryConstant::PLUGIN_PNOTYFY); ?>

<input value="Button 1" id="btn1" type="button" />
<input value="Button 2" id="btn2" type="button" />
<input value="Button 3" id="btn3" type="button" />

<script type="text/javascript" language="javascript">
<?php
echo YsPNotify::defaults(
     array(
       YsPNotify::NOTICE_ICON => YsPNotify::getIcon(YsUIConstant::ICON_COMMENT),
       YsPNotify::WIDTH => '97%')
     )
     //Or use the method ->renderWithJsTags();
?>
</script>

<?php
for($i = 1; $i <= 3; $i++){
  echo
  YsJQuery::newInstance()
    ->onClick()
    ->in('#btn' . $i)
    ->execute(
      YsPNotify::build("Message from button No: " . $i)
    );
}
?>