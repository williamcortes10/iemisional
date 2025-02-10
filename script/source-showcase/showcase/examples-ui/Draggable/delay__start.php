<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>

<?php echo YsUIPanel::initWidget('panelDraggabble', 'style="height:auto;width:auto"')?>
  Regardless of the distance, you have to drag and wait for 1000ms before dragging starts
<?php echo YsUIPanel::endWidget()?>
<br/><br/>
<?php echo YsUIPanel::initWidget('panelDraggabble2', 'style="height:auto;width:auto"')?>
  Only if you drag me by 20 pixels, the dragging will start
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
      ->_buttons(array(
          'Ok' => new YsJsFunction('alert("Hello world")'),
          'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       )
  );
echo
YsJQuery::newInstance()
  ->execute(
    YsUIDraggable::build()->in('#panelDraggabble')
      ->_delay(1000)
   ,YsUIDraggable::build()->in('#panelDraggabble2')
      ->_distance(20)
   ,YsUICore::disableSelection()->in('.ui-draggable')
  )
?>