<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot1 = new YsPlot('plot1Id', 'Concern vs. Occurrance');
$serie1 = new YsPlotSerie();
$serie1->addData('Cup Holder Pinion Bob',7);
$serie1->addData('Generic Fog Lamp',9);
$serie1->addData('HDTV Receiver',15);
$serie1->addData('8 Track Control Module',12);
$serie1->addData('Sludge Pump Fourier Modulator',3);
$serie1->addData('Transcender/Spice Rack',6);
$serie1->addData('Hair Spray Danger Indicator',18);

$serie1->setRenderer(YsPlotRenderer::getBarRenderer());

$xaxis = new YsPlotAxis();
$xaxis->setRenderer(YsPlotRenderer::getCategoryAxisRenderer());
$serie1->setXaxis($xaxis);

$yaxis = new YsPlotAxis();
$yaxis->setAutoscale(true);
$serie1->setYaxis($yaxis);

$axesDefaults = new YsPlotAxis();
$axesDefaults->setTickRenderer(YsPlotRenderer::getCanvasAxisTickRenderer());

$tickOptions = new YsPlotAxisTickOption();
$tickOptions->setAngle(-30);
$tickOptions->setFontSize('10pt');
$axesDefaults->setTickOptions($tickOptions);

$plot1->setAxesDefaults($axesDefaults);

$plot1->setSeries($serie1);

?>
<button id="btnOpenDialog">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <table width="90%">
    <tr><td><?php echo $plot1->renderTemplate(); ?></td></tr>
    <tr><td>
    Plugins dependencies:<br/>
    jqplot.dateAxisRenderer.min.js<br/>
    jqplot.canvasTextRenderer.min.js<br/>
    jqplot.canvasAxisTickRenderer.min.js<br/>
    jqplot.categoryAxisRenderer.min.js<br/>
    jqplot.barRenderer.min.js<br/>
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