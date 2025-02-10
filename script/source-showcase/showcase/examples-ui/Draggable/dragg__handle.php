<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>

<?php echo YsUIPanel::initWidget('panelDraggabble', 'style="height:auto;width:auto"')?>
  <?php echo YsUIPanel::title('Title (Drag from here)') ?>
  <?php echo YsUIPanel::initContent() ?>
    Etiam libero neque, luctus a, eleifend nec, semper at, lorem.
    Sed pede. Nulla lorem metus, adipiscing ut, luctus sed,
    hendrerit vitae, mi.
  <?php echo YsUIPanel::endContent() ?>
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
      ->_revert(true)
      ->_cursor('move')
      ->_handle('h3')
  )
?>