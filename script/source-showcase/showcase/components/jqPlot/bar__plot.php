<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot1 = new YsPlot('plot1Id', 'Unit Sales: Acme Decoy Division');
$plot1->setStackSeries(true);

$serie1 = new YsPlotSerie();
$serie1->setLinealData(4, 2, 9, 16);
$serie1->setLabel('1st Qtr');

$xaxis = new YsPlotAxis();
$xaxis->setRenderer(YsPlotRenderer::getCategoryAxisRenderer());
$xaxis->setTicks(array('Q1', 'Q2', 'Q3', 'Q4'));

$yaxis = new YsPlotAxis();
$yaxis->setMin(0);
$yaxis->setMax(20);
$yaxis->setNumberTicks(5);

$serie1->setXaxis($xaxis);
$serie1->setYaxis($yaxis);

$serie2 = new YsPlotSerie();
$serie2->setLinealData(3, 7, 6.25, 3.125);
$serie2->setLabel('2nd Qtr');

$seriesDefaults = new YsPlotSerie();
$seriesDefaults->setRenderer(YsPlotRenderer::getBarRenderer());

$rendererOptions = new YsPlotRenderer();
$rendererOptions->setBarPadding(6);
$rendererOptions->setBarMargin(40);

$seriesDefaults->setRendererOptions($rendererOptions);

$plot1->setSeries($serie1, $serie2);
$plot1->setSeriesDefaults($seriesDefaults);

$legend = new YsPlotLegend(YsLocation::$N_W);

$plot1->setLegend($legend);
$plot1->setLegend(new YsPlotLegend());



?>
<button id="btnOpenDialog">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
<table width="90%">
  <tr><td><?php echo $plot1->renderTemplate(); ?></td></tr>
  <tr><td>
  Plugins dependencies:<br/>
  - jqplot.canvasTextRenderer.min.js<br/>
  - jqplot.canvasAxisLabelRenderer.min.js<br/>
  - jqplot.barRenderer.min.js<br/>
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