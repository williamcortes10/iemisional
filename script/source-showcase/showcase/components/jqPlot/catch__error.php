<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);
//For use JLAYOUT plugin
YsJQuery::usePlugin(YsJQueryConstant::PLUGIN_JLAYOUT);

$plot1 = new YsPlot('plot1Id');
$plot2 = new YsPlot('plot2Id');

$plot2->setErrorMessage('A Plot Error has Occurred');
$plot2->setErrorBackground('#fbeddf');
$plot2->setErrorBorder('2px solid #aaaaaa');
$plot2->setErrorFontFamily('Courier New');
$plot2->setErrorFontSize('16pt');

?>

<button id="btnOpenDialog">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo YsJLayout::initGridLayout() ?>
    <?php echo YsUIPanel::initWidget('panelOne', 'align="center" style="border:0; width:50%;"') ?>
      <?php echo $plot1->renderTemplate(); ?>
    <?php echo YsUIPanel::endWidget() ?>
    <?php echo YsUIPanel::initWidget('panelTwo', 'align="center" style="border:0; width:50%;"') ?>
      <?php echo $plot2->renderTemplate(); ?>
    <?php echo YsUIPanel::endWidget() ?>
  <?php echo YsJLayout::endGridLayout() ?>
<?php echo YsUIDialog::endWidget() ?>



<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnOpenDialog')
  ->execute(
    YsUIDialog::build('#dialogId')
      ->_modal(true)
      ->_width(670)
      ->_height(500)
      ->_buttons(array(
        'Ok' => new YsJsFunction('alert("Hello world")'),
        'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       ),
     YsJLayout::build('.grid')->_hgap(2)->_vgap(2),
     $plot1->build(),
     $plot2->build()
  )
?>