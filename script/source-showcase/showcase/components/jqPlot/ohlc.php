<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot = new YsPlot('plot1Id');

$serie1 = new YsPlotSerie();
$serie1->addData(1, 138.7, 139.68, 135.18, 135.4);
$serie1->addData(2, 143.46, 144.66, 139.79, 140.02);
$serie1->addData(3, 140.67, 143.56, 132.88, 142.44);
$serie1->addData(4, 136.01, 139.5, 134.53, 139.48);
$serie1->addData(5, 143.82, 144.56, 136.04, 136.97);
$serie1->addData(6, 136.47, 146.4, 136, 144.67);
$serie1->addData(7, 124.76, 135.9, 124.55, 135.81);
$serie1->addData(8, 123.73, 129.31, 121.57, 122.5);



$tickOptions = new YsPlotAxisTickOption();
$tickOptions->setFormatString('$%.2f');

$yaxis = new YsPlotAxis();
$yaxis->setTickOptions($tickOptions);
$serie1->setYaxis($yaxis);

$xaxis = new YsPlotAxis();
$xaxis->setRenderer(YsPlotRenderer::getCategoryAxisRenderer());
$xaxis->setTicks(array('Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun', 'Mon', 'Tue'));
$serie1->setXaxis($xaxis);

$serie1->setRenderer(YsPlotRenderer::getOHLCRenderer());
$rendererOptions = new YsPlotRenderer();
$rendererOptions->setCandleStick(true);
$serie1->setRendererOptions($rendererOptions);

$plot->setSeries($serie1);

?>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <table width="90%">
    <tr><td><?php echo $plot->renderTemplate(); ?></td></tr>
    <tr><td>
    Plugins dependencies:<br/>
    - jqplot.categoryAxisRenderer.min.js<br/>
    - jqplot.ohlcRenderer.min.js<br/>
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
