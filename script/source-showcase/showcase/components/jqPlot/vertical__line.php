<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot = new YsPlot('plot1Id', 'Date Data with line at today');

$serie1 = new YsPlotSerie();
$serie1->addData('June 6, 2010', 2);
$serie1->addData('June 7, 2010', 33);
$serie1->addData('June 8, 2010', 14);
$serie1->addData('June 9, 2010', 19);

$serie2 = new YsPlotSerie();
$serie2->addData('2010/06/08', 2);
$serie2->addData('2010/06/08', 33);

$serie2->setLineWidth(1);
$serie2->setColor('#999999');
$serie2->setShowMarker(false);

$xaxis = new YsPlotAxis();
$xaxis->setRenderer(YsPlotRenderer::getDateAxisRenderer());
$xaxis->setNumberTicks(5);

$serie1->setXaxis($xaxis);

$plot->setSeries($serie1, $serie2);

?>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo $plot->renderTemplate(); ?>
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
