<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

//Loading assets when the document is ready
echo
YsJQueryAssets::loadScriptsOnReady(array(
  'jquery4php-assets/js/plugins/jqplot/plugins/jqplot.dragable.min.js',
  'jquery4php-assets/js/plugins/jqplot/plugins/jqplot.trendline.min.js'
),
  // callback: ENABLE THE BUTTON
  YsJQuery::removeAttr('disabled')->in('#btnOpenDialog')
);


$plot = new YsPlot('plot1Id', 'mytitle');

$serie1 = new YsPlotSerie();
$serie1->addData('23-May-11',1);
$serie1->addData('24-May-11',4);
$serie1->addData('25-May-11',2);
$serie1->addData('26-May-11', 6);

$serie1->setMarkerOptions(new YsPlotMarker(YsPlotMarker::$STYLE_DIAMOND));

$dragable = new YsPlotDraggable();
$dragable->setColor('#ff3366');
$dragable->setConstrainTo(YsDirection::$X);

$serie1->setDragable($dragable);

$trendline = new YsPlotTrendline();
$trendline->setLabel('trendline 1');
$trendline->setColor('#cccccc');

$serie1->setTrendline($trendline);

$xaxis = new YsPlotAxis();
$xaxis->setRenderer(YsPlotRenderer::getDateAxisRenderer());
$xaxis->setNumberTicks(12);
$tickOptions = new YsPlotAxisTickOption();
$tickOptions->setFormatString('%H:%S');

$xaxis->setTickOptions($tickOptions);

$serie1->setXaxis($xaxis);

$yaxis = new YsPlotAxis();
$tickOptions = new YsPlotAxisTickOption();
$tickOptions->setFormatString('%.2f');

$xaxis->setTickOptions($tickOptions);
$serie1->setYaxis($yaxis);

$serie2 = new YsPlotSerie();
$serie2 = new YsPlotSerie();
$serie2->addData('23-May-11',2);
$serie2->addData('24-May-11',3);
$serie2->addData('25-May-11',7);
$serie2->addData('26-May-11', 4);

$serie2->setTrendline(new YsPlotTrendline());
$serie2->setIsDragable(false);

$plot->addSerie($serie1);
$plot->addSerie($serie2);

$plot->showLegend();


?>

<button id="btnOpenDialog" disabled="disabled">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <table width="90%">
    <tr><td><?php echo $plot->renderTemplate(); ?></td></tr>
    <tr><td>
    Plugins dependencies:<br/>
    - jqplot.dragable.min.js<br/>
    - jqplot.trendline.min.js<br/>
    - jqplot.dateAxisRenderer.min.js<br/>
    - jqplot.canvasAxisTickRenderer.min.js<br/>
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
