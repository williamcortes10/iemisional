<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot1 = new YsPlot('plot1Id', 'Pie Chart with Legend and sliceMargin');
$legend = new YsPlotLegend();
$legend->setShow(true);
$plot1->setLegend($legend);

$serie1 = new YsPlotSerie();
$serie1->addData('frogs',3);
$serie1->addData('buzzards',7);
$serie1->addData('deer',2.5);
$serie1->addData('turkeys',6);
$serie1->addData('moles',5);
$serie1->addData('ground hogs',4);

$seriesDefaults = new YsPlotSerie();
$seriesDefaults->setRenderer(YsPlotRenderer::getPieRenderer());
$renderOptions = new YsPlotRenderer();
$renderOptions->setSliceMargin(8);
$seriesDefaults->setRendererOptions($renderOptions);

$plot1->setSeriesDefaults($seriesDefaults);
$plot1->setSeries($serie1);

$plot1->onDataHighlight(
  new YsJsFunction(
    "jQuery('#info').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);", // <- The body
    'ev, seriesIndex, pointIndex, data' // <- The args
  )
);

$plot1->onDataUnhighlight("$('#info').html('Nothing');");

$plot1->onDataClick("alert('You click')");

// OR Another way
// $plot1->bindHandler(YsPlot::$DATA_RIGHT_CLICK_HANDLER, "alert('You click')");

?>
<button id="btnOpenDialog">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <div id="info">Nothing</div>
  <table width="90%">
    <tr><td><?php echo $plot1->renderTemplate(); ?></td></tr>
    <tr><td>
    Plugins dependencies:<br/>
    - jqplot.pieRenderer.min.js<br/>
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