<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot1 = new YsPlot('plot1Id');

$serie1 = new YsPlotSerie();
$serie1->setLinealData(1,6,9,8); /* => $serie1->addData(1);
                                       $serie1->addData(6);
                                       $serie1->addData(9);
                                       $serie1->addData(8);*/


$xaxis = new YsPlotAxis();
$xaxis->setMin(1);
$xaxis->setMax(4);

$serie1->setXaxis($xaxis);

$yaxis = new YsPlotAxis();
$yaxis->setMin(0);
$yaxis->setMax(35);

$serie1->setYaxis($yaxis);

$serie2 = new YsPlotSerie();
$serie2->setLinealData(4,3,1,2);

$serie3 = new YsPlotSerie();
$serie3->setLinealData(6,2,4,1);

$serie4 = new YsPlotSerie();
$serie4->setLinealData(1,2,3,4);

$serie5 = new YsPlotSerie();
$serie5->setLinealData(4,3,2,1);

$serie6 = new YsPlotSerie();
$serie6->setLinealData(8,2,6,3);

$plot1->setSeries($serie1,$serie2,$serie3,$serie4,$serie5,$serie6);


$plot1->setStackSeries(true);

$seriesDefaults = new YsPlotSerie();
$seriesDefaults->setFill(true);
$seriesDefaults->setShowMarker(false);

$plot1->setSeriesDefaults($seriesDefaults);

$legend = new YsPlotLegend(YsLocation::$S);
$legend->setMarginTop("30px");
$legend->setRenderer(YsPlotRenderer::getEnhancedLegendRenderer());


$rendererOptions = new YsPlotRenderer();
$rendererOptions->setNumberColumns(3);

$legend->setRendererOptions($rendererOptions);

$legend->setLabels(array('Fog', 'Rain', 'Frost', 'Sleet', 'Hail', 'Snow'));

$plot1->setLegend($legend);





?>
<button id="btnOpenDialog">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <table width="90%">
    <tr><td><?php echo $plot1->renderTemplate(); ?></td></tr>
    <tr><td>
    Plugins dependencies:<br/>
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