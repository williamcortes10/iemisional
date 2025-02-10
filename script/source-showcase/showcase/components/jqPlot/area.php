<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot1 = new YsPlot('plot1Id');
$serie1 = new YsPlotSerie();
$serie1->setLinealData(4, -3, 3, 6, 2, -2);

$seriesDefault = new YsPlotSerie();
$seriesDefault->setFill(true);
$seriesDefault->setFillToZero(true);

$seriesRendererOptions = new YsPlotRenderer();

$seriesRendererOptions = new YsPlotRenderer();
$seriesRendererOptions->setHighlightMouseDown(true);

$seriesDefault->setRendererOptions($seriesRendererOptions);


$plot1->setStackSeries(true);
$plot1->setShowMarker(true);
$plot1->setSeriesDefaults($seriesDefault);

$plot1->setSeries($serie1);



?>
<button id="btnOpenDialog">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo $plot1->renderTemplate(); ?>
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