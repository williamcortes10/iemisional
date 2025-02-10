<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot = new YsPlot('plot1Id', "Horizontally Oriented Bar Chart");

$serie1 = new YsPlotSerie('Cats');
$serie1->addData(1,1);
$serie1->addData(4,2);
$serie1->addData(9,3);
$serie1->addData(16,4);

$serie2 = new YsPlotSerie('Dogs');
$serie2->addData(25,1);
$serie2->addData(12.5,2);
$serie2->addData(6.25,3);
$serie2->addData(3.125,4);

$rendererOptions = new YsPlotRenderer();
$rendererOptions->setBarDirection(YsDirection::$HORIZONTAL);
$rendererOptions->setBarPadding(6);
$rendererOptions->setBarMargin(15);

$serie1->setRenderer(YsPlotRenderer::getBarRenderer());
$serie1->setShadowAngle(135);
$serie1->setRendererOptions($rendererOptions);

$serie2->setRenderer(YsPlotRenderer::getBarRenderer());
$serie2->setShadowAngle(135);
$serie2->setRendererOptions($rendererOptions);

$min = new YsPlotSerie('Min');
$min->addData(2, 0.6);
$min->addData(2, 4.4);
$min->setShowMarker(false);

$max = new YsPlotSerie('Max');
$max->addData(15, 0.6);
$max->addData(15, 4.4);
$max->setShowMarker(false);

$xaxis = new YsPlotAxis();
$xaxis->setMin(0);

$serie1->setXaxis($xaxis);

$yaxis = new YsPlotAxis();
$yaxis->setRenderer(YsPlotRenderer::getCategoryAxisRenderer());
$yaxis->setTicks(array('Once', 'Twice', 'Three Times', 'More'));

$serie1->setYaxis($yaxis);

$plot->setSeries($serie1,$serie2,$min,$max);
$plot->showLegend(YsLocation::$N_E);


?>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <table width="90%">
    <tr><td><?php echo $plot->renderTemplate(); ?></td></tr>
    <tr><td>
    Plugins dependencies:<br/>
    -  jqplot.categoryAxisRenderer.min.js<br/>
    -  jqplot.barRenderer.min.js<br/>
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
     $plot->build()
  )
?>
