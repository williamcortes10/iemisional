<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot1 = new YsPlot('plot1Id');

$serie1 = new YsPlotSerie("Line 1");
$serie1->setLinealData(2,5,8,1,9,7);


$serie2 = new YsPlotSerie("Line 2");
$serie2->setLinealData(9,13,11);
$serie2->setMarkerOptions(new YsPlotMarker(YsPlotMarker::$STYLE_DASH));

$serie3 = new YsPlotSerie("Line 3");
$serie3->setLinealData(7,6,5,3,2,5);
$serie3->setMarkerOptions(new YsPlotMarker(YsPlotMarker::$STYLE_PLUS));

$serie4 = new YsPlotSerie("Line 4");
$serie4->setLinealData(15, 12, 19, 14, 9, 15);
$serie4->setMarkerOptions(new YsPlotMarker(YsPlotMarker::$STYLE_X));

$plot1->setSeries($serie1,$serie2,$serie3,$serie4);

$plot1->showLegend();

?>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo $plot1->renderTemplate('style="height:380px; width:480px;"'); ?>
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