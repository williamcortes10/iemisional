<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<button id="btnShowDemo">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>

    <?php echo YsUIPanel::initGrid('cellpadding="50px" cellspacing="50px"') ?>
    <?php echo YsUIPanel::initGridSection('width="50%"') ?>
        <?php echo YsUIPanel::initWidget('panelId', 'style="height:100%"') ?>
        <?php echo YsUIPanel::initContent('style="height:100%;overflow:auto;"') ?>
          <?php echo YsUIDatepicker::inline('from')?>
        <?php echo YsUIPanel::endContent() ?>
    <?php echo YsUIPanel::endGridSection() ?>
    <?php echo YsUIPanel::initGridSection('width="50%"') ?>
        <?php echo YsUIPanel::initWidget('panelId2', 'style="height:100%"') ?>
        <?php echo YsUIPanel::initContent() ?>
          <?php echo YsUIDatepicker::inline('to')?>
        <?php echo YsUIPanel::endContent() ?>
    <?php echo YsUIPanel::endGridSection() ?>
  <?php echo YsUIPanel::endGrid() ?>
  
<?php echo YsUIDialog::endWidget() ?>

<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnShowDemo')
  ->execute(
    YsUIDialog::build('#dialogId')
      ->_modal(true)
      ->_width(450)
      ->_buttons(array(
          'Ok' => new YsJsFunction('alert("Hello world")'),
          'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       )
  );
echo
YsJQuery::newInstance()
  ->executeOnReady(
    YsUIDatepicker::build('#from, #to')
      ->_showOtherMonths(true)
      ->_selectOtherMonths(true)
      ->_onSelect( YsUIDatepicker::doSynchronization('from', 'to'))
      ->synchronize()
  );

?>