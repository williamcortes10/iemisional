<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>

  <?php echo YsUIPanel::initWidget('resizablePanel', 'style="height:150px"') ?>
  <?php echo YsUIPanel::title('Resizable panel', YsUIConstant::ICON_ALERT) ?>
  <?php echo YsUIPanel::initContent() ?>
    <?php for($i=0; $i<=3; $i++): ?>
      Etiam libero neque, luctus a, eleifend nec, semper at, lorem.
      Sed pede. Nulla lorem metus, adipiscing ut, luctus sed,
      hendrerit vitae, mi.
    <?php endfor; ?>
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
      ->_minWidth(150)
      ->_minHeight(150)
  )
?>