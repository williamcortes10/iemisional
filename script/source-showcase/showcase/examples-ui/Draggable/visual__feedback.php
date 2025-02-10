<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>

<?php echo YsUIPanel::initWidget('panelDraggabble', 'style="height:auto;width:auto"')?>
  <p>Custom helper (in combination with cursorAt)</p>
<?php echo YsUIPanel::endWidget()?>
<br/><br/>
<?php echo YsUIPanel::initWidget('panelDraggabble2', 'style="height:auto;width:auto"')?>
  <p class="ui-widget-header">Semi-transparent clone</p>
<?php echo YsUIPanel::endWidget()?>

<?php echo YsUIDialog::endWidget() ?>

<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnOpenDialog')
  ->execute(
    YsUIDialog::build('#dialogId')
      ->_modal(true)
      ->_width(500)
      ->_height(300)
      ->_buttons(array(
          'Ok' => new YsJsFunction('alert("Hello world")'),
          'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       )
  );

$customHelper = new YsJsFunction();
$body = "return $('<div class=\"ui-widget-header\">I\'m a custom helper</div>');";
$customHelper->setBody($body);
$customHelper->setArguments('event');

echo
YsJQuery::newInstance()
  ->execute(
    YsUIDraggable::build()->in('#panelDraggabble')
      ->_cursor('move')
      ->_cursorAt(array('top' => -12, 'left' => -20))
      ->_helper($customHelper)
   ,YsUIDraggable::build()->in('#panelDraggabble2')
      ->_opacity(0.7)
      ->_helper(YsUIConstant::CLONE_HELPER)
  )
?>