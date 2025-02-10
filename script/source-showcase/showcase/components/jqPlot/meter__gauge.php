<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot1 = new YsPlot('plot1Id');

$serie1 = new YsPlotSerie();
$serie1->addData(52200);

$plot1->addSerie($serie1);

$seriesDefaults = new YsPlotSerie();
$seriesDefaults->setRenderer(YsPlotRenderer::getMeterGaugeRenderer());

$rendererOptions = new YsPlotRenderer();
$rendererOptions->setLabel("Metric Tons per Year");
$rendererOptions->setLabelPosition(YsAlignment::$BOTTOM);
$rendererOptions->setLabelHeightAdjust(-5);
$rendererOptions->setIntervalOuterRadius(85);
$rendererOptions->setTicks(array(10000, 30000, 50000, 70000));
$rendererOptions->setIntervals(array(22000, 55000, 70000));
$rendererOptions->setIntervalColors(array('#66cc66', '#E7E658', '#cc6666'));

$seriesDefaults->setRendererOptions($rendererOptions);

$plot1->setSeriesDefaults($seriesDefaults);

?>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <table width="90%">
    <tr><td><?php echo $plot1->renderTemplate(); ?></td></tr>
    <tr><td>
    Plugins dependencies:<br/>
    -  jqplot.meterGaugeRenderer.min.js<br/>
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