<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot1 = new YsPlot('plot1Id', 'breakOnNull true');

$serie1 = new YsPlotSerie();
$serie1->setLinealData(null, 13, 43, null, 18, 25, 26, 41, 42, null, null, null, 37, 29, 27, 19);
$serie1->setBreakOnNull(true);

$xaxis = new YsPlotAxis();
$xaxis->setMin(0);
$xaxis->setMax(18);
$xaxis->setTickInterval(2);

$serie1->setXaxis($xaxis);

$plot1->setSeries($serie1);


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