<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot = new YsPlot('plot1Id');

$serie1 = new YsPlotSerie('lions');
$serie1->setLinealData(3, 4, 1, 4, 2);
$serie1->setColor('#cc6666');

$serie2 = new YsPlotSerie('tigers');
$serie2->setLinealData(2, 5, 1, 4, 2);
$serie2->setColor('#66cc66');

$serie3 = new YsPlotSerie('bears');
$serie3->setLinealData(1, 6, 1, 4, 2);
$serie3->setColor('#6666cc');

$plot->setSeries($serie1,$serie2,$serie3);

$seriesDefaults = new YsPlotSerie();
$seriesDefaults->setLineWidth(4);

$plot->setSeriesDefaults($seriesDefaults);

$legend = new YsPlotLegend();
$legend->setRenderer(YsPlotRenderer::getEnhancedLegendRenderer());
$plot->setLegend($legend);

$highlighter = new YsPlotHighlighter();
$highlighter->setBringSeriesToFront(true);

$plot->setHighlighter($highlighter);

?>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo $plot->renderTemplate('style="margin-top:20px; margin-left:20px; width:360px; height:300px;"'); ?>
  <div id="button-set">
    <button onclick="plot1IdVar.moveSeriesToFront(0);">Lions</button>
    <button onclick="<?php echo $plot->moveSeriesToFront(1) ?>">Tigers</button>
    <button onclick="plot1IdVar.moveSeriesToFront(2);">Bears</button>

    <button onclick="plot1IdVar.restorePreviousSeriesOrder();">Last Order</button>
    <button onclick="<?php echo $plot->restoreOriginalSeriesOrder() ?>">Original Order</button>
  </div>
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
     YsUIButton::build('#button-set > :button'),
     $plot->build()
  )
?>
