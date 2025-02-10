<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot1 = new YsPlot('plot1Id', 'Bubble Test');

$serie1 = new YsPlotSerie();
$serie1->addData(11, 123, 1236, "Acura");
$serie1->addData(45, 92, 1067, "Alfa Romeo");
$serie1->addData(24, 104, 1176, "AM General");
$serie1->addData(50, 23, 610, "Aston Martin Lagonda");
$serie1->addData(18, 17, 539, "Audi");
$serie1->addData(7, 89, 864, "BMW");
$serie1->addData(2, 13, 1026, "Bugatti");

$plot1->setSeries($serie1);

$plot1->setSortData(false);

$seriesDefaults = new YsPlotSerie();
$seriesDefaults->setRenderer(YsPlotRenderer::getBubbleRenderer());
$seriesDefaults->setShadow(true);

$rendererOptions = new YsPlotRenderer();
$rendererOptions->setBubbleAlpha(0.6);
$rendererOptions->setHighlightAlpha(0.8);
$rendererOptions->setHighlightMouseOver(true);
$rendererOptions->setBubbleGradients(true);

$seriesDefaults->setRendererOptions($rendererOptions);
$seriesDefaults->setShadowAlpha(0.05);
$plot1->setSeriesDefaults($seriesDefaults);



?>
<button id="btnOpenDialog">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
<table width="90%">
  <tr><td><?php echo $plot1->renderTemplate('style="width:460px;height:340px;"'); ?></td></tr>
  <tr><td>
  Plugins dependencies:<br/>
  - jqplot.bubbleRenderer.min.js<br/>
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
     YsPlot::enablePlotPlugins(),
     $plot1->build()
  )
?>