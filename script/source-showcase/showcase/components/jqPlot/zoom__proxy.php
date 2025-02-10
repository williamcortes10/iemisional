<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

//Loading assets when the document is ready
echo
YsJQueryAssets::loadScriptsOnReady(
  'jquery4php-assets/js/plugins/jqplot/plugins/jqplot.cursor.min.js'
,  // callback: ENABLE THE BUTTON
  YsJQuery::removeAttr('disabled')->in('#btnOpenDialog')
);

$plot1 = new YsPlot('targetPlot', 'Data Point Highlighting');

$serie1 = new YsPlotSerie();
$serie1->addData('23-May-08', 578.55);
$serie1->addData('20-Jun-08', 566.5);
$serie1->addData('25-Jul-08', 480.88);
$serie1->addData('22-Aug-08', 509.84);
$serie1->addData('26-Sep-08', 454.13);
$serie1->addData('24-Oct-08', 379.75);
$serie1->addData('21-Nov-08', 303);
$serie1->addData('26-Dec-08', 308.56);
$serie1->addData('23-Jan-09', 299.14);
$serie1->addData('20-Feb-09', 346.51);
$serie1->addData('20-Mar-09', 325.99);
$serie1->addData('24-Apr-09', 386.15);

$xaxis = new YsPlotAxis();
$xaxis->setRenderer(YsPlotRenderer::getDateAxisRenderer());
$rendererOptions = new YsPlotRenderer();
$rendererOptions->setTickRenderer(YsPlotRenderer::getCanvasAxisTickRenderer());
$xaxis->setRendererOptions($rendererOptions);

$tickOptions = new YsPlotAxisTickOption();
$tickOptions->setFormatString('%b %#d, %Y');
$tickOptions->setFontSize('10pt');
$tickOptions->setFontFamily('Tahoma');

$xaxis->setTickOptions($tickOptions);
$serie1->setXaxis($xaxis);

$yaxis = new YsPlotAxis();
$tickOptions = new YsPlotAxisTickOption();
$tickOptions->setFormatString('$%.2f');
$yaxis->setTickOptions($tickOptions);

$serie1->setYaxis($yaxis);

$plot1->setSeries($serie1);

$highlighter = new YsPlotHighlighter();
$highlighter->setSizeAdjust(7.5);
$highlighter->setTooltipLocation(YsLocation::$N);

$plot1->setHighlighter($highlighter);

$plot2 = new YsPlot('controllerPlot');
$cursor = new YsPlotCursor();
$cursor->setZoom(true);
$plot2->setCursor($cursor);
$plot2->setSeries($serie1);


?>
<button id="btnOpenDialog" disabled="disabled">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo $plot1->renderTemplate('style="height:200px;"'); ?>
  <?php echo $plot2->renderTemplate('style="margin-top: 30px; height:100px;"'); ?>
  Plugins dependencies:<br/>
  -jqplot.cursor.min.js<br/>
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
     $plot1->build(),
     $plot2->build(),
     YsPlot::zoomProxy($plot1, $plot2)
  )
?>