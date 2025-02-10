<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot = new YsPlot('plot1Id','Fill to zero');

$serie1 = new YsPlotSerie('Traps Division');
$serie1->setLinealData(4, -7, 9, 16);

$xaxis = new YsPlotAxis();
$xaxis->setRenderer(YsPlotRenderer::getCategoryAxisRenderer());
$xaxis->setTicks(array(2006,2007,2008,2009));

$tickOptions = new YsPlotAxisTickOption();
$tickOptions->setFormatString('%d');

$xaxis->setTickOptions($tickOptions);

$serie1->setXaxis($xaxis);

$yaxis = new YsPlotAxis();
$yaxis->setAutoscale(true);

$serie1->setYaxis($yaxis);

$serie2 = new YsPlotSerie('Decoy Division');
$serie2->setLinealData(3, -3, 6.25, 3.125);

$seriesDefaults = new YsPlotSerie();
$seriesDefaults->setFill(true);
$seriesDefaults->setFillToZero(true);
$seriesDefaults->setShowMarker(false);
$seriesDefaults->setRenderer(YsPlotRenderer::getBarRenderer());

$plot->setSeries($serie1, $serie2);
$plot->setSeriesDefaults($seriesDefaults);

$legend = new YsPlotLegend(YsLocation::$E);
$plot->setLegend($legend);

?>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
<table width="90%">
  <tr><td><?php echo $plot->renderTemplate(); ?></td></tr>
  <tr><td>
  Plugins dependencies:<br/>
  - jqplot.categoryAxisRenderer.min.js<br/>
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
     $plot->build()
  )
?>