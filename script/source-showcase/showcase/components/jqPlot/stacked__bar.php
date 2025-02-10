<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

//Loading assets when the document is ready
echo
YsJQueryAssets::loadScriptsOnReady(
  'jquery4php-assets/js/plugins/jqplot/plugins/jqplot.pointLabels.min.js',
  // callback: ENABLE THE BUTTON
  YsJQuery::removeAttr('disabled')->in('#btnOpenDialog')
);

$plot = new YsPlot('plot1Id');

$serie1 = new YsPlotSerie();
$serie1->setLinealData(20, 10);
$serie1->setColor('#82BC24');

$pointLabels = new YsPlotPointLabels();
$pointLabels->setYPadding(-15);

$serie1->setPointLabels($pointLabels);

$serie2 = new YsPlotSerie();
$serie2->setLinealData(80, 90);
$serie2->setColor('#363636');

$pointLabels = new YsPlotPointLabels();
$pointLabels->setYPadding(9000);

$serie2->setPointLabels($pointLabels);

$xaxis = new YsPlotAxis();
$xaxis->setTicks(array(2010, 2040));
$xaxis->setRenderer(YsPlotRenderer::getCategoryAxisRenderer());

$tickOptions = new YsPlotAxisTickOption();
$tickOptions->setShowGridline(false);
$tickOptions->setMarkSize(0);

$xaxis->setTickOptions($tickOptions);

$serie1->setXaxis($xaxis);

$plot->setSeries($serie1,$serie2);

$seriesDefaults = new YsPlotSerie();

$yaxis = new YsPlotAxis('y2axis');
$yaxis->setTicks(array(0, 100));

$tickOptions = new YsPlotAxisTickOption();
$tickOptions->setFormatString('%d\%');
$yaxis->setTickOptions($tickOptions);

$seriesDefaults->setYaxis($yaxis);
$seriesDefaults->setRenderer(YsPlotRenderer::getBarRenderer());
$seriesDefaults->setShadow(false);

$pointLabels = new YsPlotPointLabels();
$pointLabels->setStackedValue(true);

$seriesDefaults->setPointLabels($pointLabels);

$rendererOptions = new YsPlotRenderer();
$rendererOptions->setBarMargin(25);

$seriesDefaults->setRendererOptions($rendererOptions);

$plot->setSeriesDefaults($seriesDefaults);

$grid = new YsPlotGrid();
$grid->setDrawGridlines(true);
$grid->setBackground('#ffffff');
$grid->setBorderWidth(0);
$grid->setShadow(false);

$plot->setStackSeries(true);

$plot->setGrid($grid);


?>

<button id="btnOpenDialog" disabled="disabled">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo $plot->renderTemplate('style="margin-top:20px; margin-left:20px; width:200px; height:200px;"'); ?>
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
