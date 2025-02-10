<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot1 = new YsPlot('plot1Id','Donut Chart Test');
$plot1->setCaptureRightClick(true);

$serie1 = new YsPlotSerie();
$serie1->addData('a',2);
$serie1->addData('b',8);
$serie1->addData('c',14);
$serie1->addData('d',20);

$serie2 = new YsPlotSerie();
$serie2->addData('a', 4);
$serie2->addData('b', 12);
$serie2->addData('c', 6);
$serie2->addData('d', 3);

$serie3 = new YsPlotSerie();
$serie3->addData('a', 2);
$serie3->addData('b', 1);
$serie3->addData('c', 3);
$serie3->addData('d', 3);

$serie4 = new YsPlotSerie();
$serie4->addData('a', 4);
$serie4->addData('b', 3);
$serie4->addData('c', 2);
$serie4->addData('d', 1);

$plot1->setSeries($serie1,$serie4,$serie3,$serie4);

$seriesDefaults = new YsPlotSerie();
$seriesDefaults->setRenderer(YsPlotRenderer::getDonutRenderer());
$seriesDefaults->setShadow(false);

$rendererOptions = new YsPlotRenderer();
$rendererOptions->setInnerDiameter(110);
$rendererOptions->setStartAngle(-90);
$rendererOptions->setSliceMargin(2);
$rendererOptions->setHighlightMouseDown(true);

$seriesDefaults->setRendererOptions($rendererOptions);

$plot1->setSeriesDefaults($seriesDefaults);

$legend = new YsPlotLegend(YsLocation::$S);
$legend->setPlacement('outside');

$rendererOptions = new YsPlotRenderer();
$rendererOptions->setNumberRows(1);
$legend->setRendererOptions($rendererOptions);
$legend->setLabels(array('Slice A', 'Slice B', 'Slice C', 'Slice D'));
$plot1->setLegend($legend);

?>

<button id="btnOpenDialog">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <table width="90%">
    <tr><td><?php echo $plot1->renderTemplate(); ?></td></tr>
    <tr><td>
    Plugins dependencies:<br/>
    - jqplot.donutRenderer.min.js<br/>
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