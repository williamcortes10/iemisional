<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);
//For use the component
YsJQuery::usePlugin(YsJQueryConstant::PLUGIN_JLAYOUT);

$plots = array();

for($i = 0; $i<=3; $i++){
  $plot = new YsPlot('plot'. $i .'Id', "Metric Tons per Year 201" . $i);

  $serie1 = new YsPlotSerie();
  $serie1->addData(rand(1,10));

  $plot->addSerie($serie1);

  $seriesDefaults = new YsPlotSerie();
  $seriesDefaults->setRenderer(YsPlotRenderer::getMeterGaugeRenderer());

  if($i !== 0 && $i !== 3){
    $plot->setTitle('Network speed');
    $rendererOptions = new YsPlotRenderer();
    $rendererOptions->setIntervals(array(2,6,10));
    $rendererOptions->setIntervalColors(array('#66cc66', '#E7E658', '#cc6666'));
    $seriesDefaults->setRendererOptions($rendererOptions);
  }

  $plot->setSeriesDefaults($seriesDefaults);
  $plot->setPlotHtmlProperties('align="center" style="width:180px;height:180px"');
  $plots[$i] = $plot;
}


?>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo YsJLayout::initGridLayout() ?>

    <?php echo YsUIPanel::initWidget('panelOne', 'align="center" style="width:50%;height:180px"') ?>
      <?php echo $plots[0]->renderTemplate(); ?>
    <?php echo YsUIPanel::endWidget() ?>
    <?php echo YsUIPanel::initWidget('panelTwo', 'align="center" style="width:50%;height:180px"') ?>
      <?php echo $plots[1]->renderTemplate(); ?>
    <?php echo YsUIPanel::endWidget() ?>
    <?php echo YsUIPanel::initWidget('panelThree', 'align="center" style="width:50%;height:180px"') ?>
     <?php echo $plots[2]->renderTemplate(); ?>
    <?php echo YsUIPanel::endWidget() ?>
    <?php echo YsUIPanel::initWidget('panelFour', 'align="center" style="width:50%;height:180px"') ?>
      <?php echo $plots[3]->renderTemplate(); ?>
    <?php echo YsUIPanel::endWidget() ?>

<?php echo YsJLayout::endGridLayout() ?>

  Plugins dependencies:<br/>
  -  jqplot.meterGaugeRenderer.min.js<br/>
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
     YsJLayout::build('.grid')->_hgap(3)->_vgap(3)->_columns(2)->_rows(2),
     $plots[0]->build(),
     $plots[1]->build(),
     $plots[2]->build(),
     $plots[3]->build()
  )
?>
