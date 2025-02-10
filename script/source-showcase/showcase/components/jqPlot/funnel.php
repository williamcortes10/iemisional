<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot1 = new YsPlot('plot1Id','Funnel Test');
$plot1->setCaptureRightClick(true);

$serie1 = new YsPlotSerie();
$serie1->addData('Sony',7);
$serie1->addData('Samsumg',13);
$serie1->addData('LG',14);
$serie1->addData('Vizio',5);

$plot1->addSerie($serie1);

$seriesDefaults = new YsPlotSerie();
$seriesDefaults->setRenderer(YsPlotRenderer::getFunnelRenderer());

$rendererOptions = new YsPlotRenderer();
$rendererOptions->setWidthRatio(0.2);
$rendererOptions->setSectionMargin(0);
$rendererOptions->setHighlightMouseDown(true);

$seriesDefaults->setRendererOptions($rendererOptions);

$plot1->setSeriesDefaults($seriesDefaults);

$plot1->setLegend(new YsPlotLegend(YsLocation::$E));

?>

<button id="btnOpenDialog">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <table width="50%">
    <tr><td><?php echo $plot1->renderTemplate(); ?></td></tr>
    <tr><td>
    Plugins dependencies:<br/>
    - jqplot.funnelRenderer.min.js<br/>
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