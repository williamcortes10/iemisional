<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>

  <?php echo YsUIPanel::initWidget('containerPanel', 'style="height:100%;width:90%"') ?>
  <?php echo YsUIPanel::title('Containment', YsUIConstant::ICON_ALERT) ?>
  <?php echo YsUIPanel::initContent() ?>

    <?php echo YsUIPanel::initWidget('resizablePanel', 'style="height:81px;left:5px;top:40px;width:232px;position:absolute"') ?>
    <?php echo YsUIPanel::title('Resizable panel', YsUIConstant::ICON_ALERT) ?>
    <?php echo YsUIPanel::initContent() ?>

    <?php echo YsUIPanel::endContent() ?>
    <?php echo YsUIPanel::endWidget() ?>


  <?php echo YsUIPanel::endContent() ?>
  <?php echo YsUIPanel::initFooter() ?>
    This is my footer
  <?php echo YsUIPanel::endFooter() ?>
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
      ->_height(300)
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
      ->_containment('#containerPanel')
      ->_minWidth(150)
      ->_minHeight(70)
  )
?>