<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>

  <?php echo YsUIPanel::initWidget('panel', 'style="height:150px;width:150px"') ?>
  <?php echo YsUIPanel::title('Panel', YsUIConstant::ICON_ALERT) ?>
  <?php echo YsUIPanel::initContent() ?>

  <?php echo YsUIPanel::endContent() ?>
  <?php echo YsUIPanel::endWidget() ?>
  <br/>
  <?php echo YsUIButton::buttonTag('btnAnimate', 'Run Effect')?>

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
    YsUIButton::build('#btnAnimate')
  );
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnAnimate')
  ->execute(
    YsUIEffect::animate()
      ->properties(
        array(
        'backgroundColor' => '#aa0000', 'color' => '#fff', 'width' => 250
        )
      )
      ->duration(1000)
      ->in('#panel, #panel > p')
  )
?>