<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot1 = new YsPlot('plot1Id','Default Multiple y axes');

$serie1 = new YsPlotSerie();
$serie1->setLinealData(2, 3, 1, 4, 3);
$serie2 = new YsPlotSerie();
$serie2->setLinealData(1, 4, 3, 2, 2.5, 2);
$serie3 = new YsPlotSerie();
$serie3->setLinealData(14, 24, 18, 22);
$serie4 = new YsPlotSerie();
$serie4->setLinealData(102, 104, 153, 122, 138, 115);
$serie5 = new YsPlotSerie();
$serie5->setLinealData(843, 777, 754, 724, 722);

$serie2->setYaxis(new YsPlotAxis("y2axis"));
$serie3->setYaxis(new YsPlotAxis("y3axis"));
$serie4->setYaxis(new YsPlotAxis("y4axis"));
$serie5->setYaxis(new YsPlotAxis("y5axis"));
$serie5->setYaxis(new YsPlotAxis("y6axis"));

$axesDefaults = new YsPlotAxis();
$axesDefaults->setUseSeriesColor(true);

$plot1->setAxesDefaults($axesDefaults);
$plot1->setSeries($serie1,$serie2,$serie3,$serie4,$serie5);


?>
<button id="btnOpenDialog">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo $plot1->renderTemplate(); ?>
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