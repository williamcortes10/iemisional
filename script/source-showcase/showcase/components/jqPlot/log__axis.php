<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot1 = new YsPlot('plot1Id', 'Secondary Log Axis, Even Tick Distribution, Specify Min/Max');
$legend = new YsPlotLegend();
$legend->setShow(true);
$legend->setLocation(YsLocation::$E);
$plot1->setLegend($legend);

$serie1 = new YsPlotSerie();
$serie1->addData(1,3);
$serie1->addData(2,4);
$serie1->addData(3,9);
$serie1->addData(4,16);
$serie1->setLabel("Rising line");

$xaxis = new YsPlotAxis();
$xaxis->setMin(0);
$xaxis->setMax(5);

$serie1->setXaxis($xaxis);


$serie2 = new YsPlotSerie();
$serie2->addData(25);
$serie2->addData(12.5);
$serie2->addData(6.25);
$serie2->addData(3.125);
$serie2->setLabel("Declining line");

$yaxis = new YsPlotAxis("y2axis");
$yaxis->setRenderer(YsPlotRenderer::getLogAxisRenderer());
$yaxis->setMin(2);
$yaxis->setMax(30);

$serie2->setYaxis($yaxis);

$plot1->addSerie($serie1);
$plot1->addSerie($serie2);

?>
<button id="btnOpenDialog">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <table width="90%">
    <tr><td><?php echo $plot1->renderTemplate(); ?></td></tr>
    <tr><td>
    Plugins dependencies:<br/>
    - jqplot.logAxisRenderer.min.js<br/>
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