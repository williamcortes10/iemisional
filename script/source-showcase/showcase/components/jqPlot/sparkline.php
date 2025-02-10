<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot = new YsPlot('plot1Id');

$serie1 = new YsPlotSerie();
$serie1->setLinealData(1242573966, 14400, 1242573966, 5000, 1242573966, 0);

$xaxisAndYaxis = new YsPlotAxis();
$xaxisAndYaxis->setShowTicks(false);
$xaxisAndYaxis->setShowTickMarks(false);

$serie1->setXaxis($xaxisAndYaxis);
$serie1->setYaxis($xaxisAndYaxis);
$serie1->setLineWidth(1);

$markerOptions = new YsPlotMarker(YsPlotMarker::$STYLE_FILLED_CIRCLE);
$markerOptions->setLineWidth(.5);
$markerOptions->setSize(2);
$markerOptions->setColor('#666666');
$markerOptions->setShadow(false);

$serie1->setMarkerOptions($markerOptions);
$serie1->setLineWidth(1);

$plot->setSeries($serie1);

$plot->setGridPadding(array('top'    => 0, 
                            'right'  => 0,
                            'bottom' => 0,
                            'left'   => 0));

$grid = new YsPlotGrid();
$grid->setDrawGridlines(false);
$grid->setGridLineColor('#fffdf6');
$grid->setBackground('#fffdf6');
$grid->setBorderColor('#999999');
$grid->setBorderWidth(1);
$grid->setShadow(false);

$plot->setGrid($grid);
?>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo $plot->renderTemplate('style="margin-top:20px; margin-left:20px; width:100px; height:40px;"'); ?>
<?php echo YsUIDialog::endWidget() ?>

<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnOpenDialog')
  ->execute(
    YsUIDialog::build('#dialogId')
      ->_modal(true)
      ->_width(160)
      ->_height(160)
      ->_buttons(array(
        'Ok' => new YsJsFunction('alert("Hello world")'),
        'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       ),
     $plot->build()
  )
?>
