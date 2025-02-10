<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot1 = new YsPlot('plot1Id', 'Customized Date Axis');
$serie1 = new YsPlotSerie();
$serie1->addData('2008-06-30',4);
$serie1->addData('2008-7-30',6.5);
$serie1->addData('2008-8-30',5.7);
$serie1->addData('2008-9-30',9);
$serie1->addData('2008-10-30',8.2);
$serie1->setLineWidth(4);

$markerOptions = new YsPlotMarker();
$markerOptions->setStyle(YsPlotMarker::$STYLE_SQUARE);

$serie1->setMarkerOptions($markerOptions);

$tickOptions = new YsPlotAxisTickOption();
$tickOptions->setFormatString('%b %#d, %y');

$xaxis = new YsPlotAxis();
$xaxis->setTickOptions($tickOptions);
$xaxis->setMin('May 30, 2008');
$xaxis->setTickInterval('1 month');
$xaxis->setRenderer(YsPlotRenderer::getDateAxisRenderer());

$serie1->setXaxis($xaxis);

$plot1->setSeries($serie1);

?>
<button id="btnOpenDialog">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <table width="90%">
    <tr><td><?php echo $plot1->renderTemplate(); ?></td></tr>
    <tr><td>
    Plugins dependencies:<br/>
    - jqplot.dateAxisRenderer.min.js<br/>
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