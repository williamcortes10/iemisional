<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>

  <?php echo YsUIPanel::initWidget('panelId', 'style="height:150px;width:150px"') ?>
  <?php echo YsUIPanel::title('Panel', YsUIConstant::ICON_ALERT) ?>
  <?php echo YsUIPanel::initContent() ?>

  <?php echo YsUIPanel::endContent() ?>
  <?php echo YsUIPanel::endWidget() ?>
  <br/>

  <select id="effectTypes" name="effects">
    <option value="blind">Blind</option>
    <option value="bounce">Bounce</option>
    <option value="clip">Clip</option>
    <option value="drop">Drop</option>
    <option value="explode">Explode</option>
    <option value="fade">Fade</option>
    <option value="fold">Fold</option>
    <option value="highlight">Highlight</option>
    <option value="puff">Puff</option>
    <option value="pulsate">Pulsate</option>
    <option value="scale">Scale</option>
    <option value="shake">Shake</option>
    <option value="size">Size</option>
    <option value="slide">Slide</option>
    <option value="transfer">Transfer</option>
  </select>

  <?php echo YsUIButton::buttonTag('btnRunEffect', 'Run Effect')?>

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
    YsUIButton::build('#btnRunEffect')
  );
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunEffect')
  ->execute(
    YsUIEffect::effect()
      ->in('#panelId')
      ->effectName(YsJQuery::val()->in('#effectTypes'))
      ->options(array())
      ->duration(500)
      ->callback(
        new YsJsFunction(YsJQuery::show()->in('#panelId'))
      )
  )
?>