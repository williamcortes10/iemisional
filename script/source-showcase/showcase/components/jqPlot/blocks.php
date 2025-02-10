<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot1 = new YsPlot('plot1Id', 'Blocks');

$serie1 = new YsPlotSerie('Independent Brands');
$serie2 = new YsPlotSerie('Pepsi Brands');
$serie3 = new YsPlotSerie('Coke Brands');

$serie1->addData(0.9, 120, 'Vernors');
$serie1->addData(1.8, 140, 'Fanta');
$serie1->addData(3.2, 90, 'Barqs');
$serie1->addData(4.1, 140, 'Arizon Iced Tea');
$serie1->addData(4.5, 91, 'Red Bull');
$serie1->addData(6.8, 17, 'Go Girl');

$serie2->addData(1.3, 44, 'Pepsi');
$serie2->addData(2.1, 170, 'Sierra Mist');
$serie2->addData(2.6, 66, 'Moutain Dew');
$serie2->addData(4, 52, 'Sobe');
$serie2->addData(5.4, 16, 'Amp');
$serie2->addData(6, 48, 'Aquafina');

$serie3->addData(1, 59, 'Coca-Cola');
$serie3->addData(2, 50, 'Sprite');
$serie3->addData(3, 90, 'Mello Yello');
$serie3->addData(4, 90, 'Ambasa');
$serie3->addData(5, 71, 'Squirt');
$serie3->addData(5, 155, 'Youki');

$xaxis = new YsPlotAxis();
$xaxis->setMin(0);
$xaxis->setMax(8);

$yaxis = new YsPlotAxis();
$yaxis->setMin(0);
$yaxis->setMax(200);

$serie1->setXaxis($xaxis);
$serie1->setYaxis($yaxis);

$plot1->setSeries($serie1,$serie2,$serie3);

$seriesDefaults = new YsPlotSerie();
$pointLabels = new YsPlotPointLabels();
$pointLabels->setShow(false);
$seriesDefaults->setPointLabels($pointLabels);
$seriesDefaults->setRenderer(YsPlotRenderer::getBlockRenderer());

$rendererOptions = new YsPlotRenderer();
$rendererOptions->setVaryBlockColors(true);

$seriesDefaults->setRendererOptions($rendererOptions);

$plot1->setSeriesDefaults($seriesDefaults);

$legend = new YsPlotLegend();
$legend->setShowSwatch(true);
$legend->setRenderer(YsPlotRenderer::getEnhancedLegendRenderer());

$plot1->setLegend($legend);

?>
<button id="btnOpenDialog">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
<table width="80%">
  <tr><td><?php echo $plot1->renderTemplate(); ?></td></tr>
  <tr><td>
  Plugins dependencies:<br/>
  - jqplot.blockRenderer.min.js<br/>
  - jqplot.enhancedLegendRenderer.min.js<br/>
  </td></tr>
</table>
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
     $plot1->build()
  )
?>