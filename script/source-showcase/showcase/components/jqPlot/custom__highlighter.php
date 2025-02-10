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
  'jquery4php-assets/js/plugins/jqplot/plugins/jqplot.highlighter.min.js',
  'jquery4php-assets/js/plugins/jqplot/plugins/jqplot.cursor.min.js',
  'jquery4php-assets/js/plugins/jqplot/plugins/jqplot.dragable.min.js',
  'jquery4php-assets/js/plugins/jqplot/plugins/jqplot.trendline.min.js'
),
  // callback: ENABLE THE BUTTON
  YsJQuery::removeAttr('disabled')->in('#btnOpenDialog')
);

$plot1 = new YsPlot('plot1Id','Highlighting, Dragging, Cursor and Trend Line');

$serie1 = new YsPlotSerie();
$serie1->addData('23-May-08',1);
$serie1->addData('24-May-08',4);
$serie1->addData('25-May-08',2);
$serie1->addData('26-May-08',6);

$xaxis = new YsPlotAxis();
$xaxis->setRenderer(YsPlotRenderer::getDateAxisRenderer());
$xaxis->setNumberTicks(4);

$tickOptions = new YsPlotAxisTickOption();
$tickOptions->setFormatString('%b %#d, %Y');

$xaxis->setTickOptions($tickOptions);


$yaxis = new YsPlotAxis();
$tickOptions = new YsPlotAxisTickOption();
$tickOptions->setFormatString('$%.2f');

$yaxis->setTickOptions($tickOptions);
$serie1->setXaxis($xaxis);
$serie1->setYaxis($yaxis);

$plot1->setSeries($serie1);

$highlighter = new YsPlotHighlighter();
$highlighter->setSizeAdjust(10);
$highlighter->setTooltipLocation(YsLocation::$N);
$highlighter->setTooltipAxes(YsPlotAxis::$Y);
$highlighter->setTooltipFormatString('<b><i><span style="color:red;">hello</span></i></b> %.2f');
$highlighter->setUseAxesFormatters(false);

$plot1->setHighlighter($highlighter);

$plot1->setCursor(new YsPlotCursor());

?>

<button id="btnOpenDialog" disabled="disabled">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <table width="90%">
    <tr><td><?php echo $plot1->renderTemplate(); ?></td></tr>
    <tr><td>
    Plugins dependencies:<br/>
    - jqplot.dateAxisRenderer.js<br/>
    - jqplot.cursor.js<br/>
    - jqplot.highlighter.js<br/>
    - jqplot.dragable.js<br/>
    - jqplot.trendline.js<br/>
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