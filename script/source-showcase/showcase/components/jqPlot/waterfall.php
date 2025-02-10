<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot = new YsPlot('plot1Id', 'Crop Yield Charnge, 2010 to 2011');

$ticks = array('2008', 'Apricots', 'Tomatoes', 'Potatoes', 'Rhubarb', 'Squash',
               'Grapes', 'Peanuts', '2009');

$serie1 = new YsPlotSerie();
$serie1->setLinealData(14, 3, 4, -3, 5, 2, -3, -7);

$xaxis = new YsPlotAxis();
$xaxis->setRenderer(YsPlotRenderer::getCategoryAxisRenderer());
$xaxis->setTicks($ticks);
$xaxis->setTickRenderer(YsPlotRenderer::getCanvasAxisTickRenderer());

$tickOptions = new YsPlotAxisTickOption();
$tickOptions->setAngle(-90);
$tickOptions->setFontSize('10pt');
$tickOptions->setShowMark(false);
$tickOptions->setShowGridline(false);


$xaxis->setTickOptions($tickOptions);

$serie1->setXaxis($xaxis);

$seriesDefaults = new YsPlotSerie();
$seriesDefaults->setRenderer(YsPlotRenderer::getBarRenderer());

$rendererOptions = new YsPlotRenderer();
$rendererOptions->setWaterfall(true);
$rendererOptions->setVaryBarColor(true);

$seriesDefaults->setRendererOptions($rendererOptions);

$pointLabels = new YsPlotPointLabels();
$pointLabels->setHideZeros(true);

$seriesDefaults->setPointLabels($pointLabels);

$yaxis = new YsPlotAxis('y2axis');
$yaxis->setMin(0);
$yaxis->setTickInterval(5);

$seriesDefaults->setYaxis($yaxis);

$plot->setSeriesDefaults($seriesDefaults);
$plot->setSeries($serie1);

?>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo $plot->renderTemplate(); ?>
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
