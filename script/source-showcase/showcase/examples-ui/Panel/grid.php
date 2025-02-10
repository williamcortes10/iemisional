<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
<br>
  <?php echo YsUIPanel::initGrid('cellpadding="50px" cellspacing="50px"') ?>
    <?php echo YsUIPanel::initGridSection('width="50%"') ?>
        <?php echo YsUIPanel::initWidget('panelId', 'style="height:150px"') ?>
        <?php echo YsUIPanel::title('Mi test', YsUIConstant::ICON_NOTICE) ?>
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
    <?php echo YsUIPanel::endGridSection() ?>
    <?php echo YsUIPanel::initGridSection('width="50%"') ?>
        <?php echo YsUIPanel::initWidget('panelId2', 'style="height:150px"') ?>
        <?php echo YsUIPanel::title('Mi test', array(YsUIConstant::ICON_CIRCLE_CHECK, YsUIPosition::$RIGHT_POSITION)) ?>
        <?php echo YsUIPanel::initContent() ?>
          Etiam libero neque, luctus a, eleifend nec, semper at, lorem. 
          Sed pede. Nulla lorem metus, adipiscing ut, luctus sed,
          hendrerit vitae, mi.
        <?php echo YsUIPanel::endContent() ?>
        <?php echo YsUIPanel::initFooter() ?>
          This is my footer
        <?php echo YsUIPanel::endFooter() ?>
        <?php echo YsUIPanel::endWidget() ?>
    <?php echo YsUIPanel::endGridSection() ?>
  <?php echo YsUIPanel::endGrid() ?>
<?php echo YsUIDialog::endWidget() ?>


<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnOpenDialog')
  ->execute(
    YsUIDialog::build('#dialogId')
      ->_modal(true)
      ->_width(600)
      ->_height(500)
      ->_buttons(array(
          'Ok' => new YsJsFunction('alert("Hello world")'),
          'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       )
  )
?>
