<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>

      <?php echo YsUIPanel::initWidget('resizablePanel', 'style="height:150px"') ?>
      <?php echo YsUIPanel::title('Resizable panel', YsUIConstant::ICON_ALERT) ?>
      <?php echo YsUIPanel::initContent() ?>

      <?php echo YsUIPanel::endContent() ?>
      <?php echo YsUIPanel::endWidget() ?>

  
<?php echo YsUIDialog::endWidget() ?>



<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnOpenDialog')
  ->execute(
    YsUIDialog::build('#dialogId')
      ->_width(500)
      ->_height(500)
      ->_modal(true)
      ->_resizable(false)
      ->_buttons(array(
          'Ok' => new YsJsFunction('alert("Hello world")'),
          'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       )
  );
echo
YsJQuery::newInstance()
  ->execute(
    YsUIResizable::build()->in('#resizablePanel')
      ->_animate(true)
  )
?>