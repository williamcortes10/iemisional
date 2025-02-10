<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot1 = new YsPlot('plot1Id','Revenue Breakdown per Character');

$serie1 = new YsPlotSerie();
$serie1->addData('shirts', 8);
$serie1->addData('hats', 14);
$serie1->addData('shoes', 6);
$serie1->addData('gloves', 16);
$serie1->addData('dolls', 12);


$xaxis = new YsPlotAxis();
$xaxis->setBarLabels(array('Mickey Mouse', 'Donald Duck', 'Goofy'));
$xaxis->setMax(175);

$tickOptions = new YsPlotAxisTickOption();
$tickOptions->setFormatString('$%dM');

$xaxis->setTickOptions($tickOptions);
$serie1->setXaxis($xaxis);

$serie2 = new YsPlotSerie();
$serie2->setLinealData(15,6,9,13,6);

$xaxis2 = $xaxis;
$xaxis2->setName('x2axis');

$xaxis2->setBarLabels(null);

$serie2->setXaxis($xaxis2);

$serie3 = new YsPlotSerie();
$serie3->addData('grumpy',4);
$serie3->addData('sneezy',2);
$serie3->addData('happy',7);
$serie3->addData('sleepy',9);
$serie3->addData('doc',7);

$plot1->setSeries($serie1,$serie2,$serie3);

$seriesDefaults = new YsPlotSerie();
$seriesDefaults->setRenderer(YsPlotRenderer::getMekkoRenderer());

$rendererOptions = new YsPlotRenderer();
$rendererOptions->setBorderColor("#dddddd");

$seriesDefaults->setRendererOptions($rendererOptions);

$plot1->setSeriesDefaults($seriesDefaults);

$axesDefaults = new YsPlotAxis();
$axesDefaults->setRenderer(YsPlotRenderer::getMekkoAxisRenderer());
$plot1->setAxesDefaults($axesDefaults);


$legend = new YsPlotLegend(YsLocation::$E);

$rendererOptions = new YsPlotRenderer();
$rendererOptions->setPlacement('insideGrid');
$legend->setRendererOptions($rendererOptions);
$plot1->setLegend($legend);

?>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo $plot1->renderTemplate('style="height:380px; width:480px;"'); ?>
  Plugins dependencies:<br/>
  -  jqplot.mekkoRenderer.min.js<br/>
  -  jqplot.mekkoAxisRenderer.min.js
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