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
  'jquery4php-assets/js/plugins/jqplot/plugins/jqplot.BezierCurveRenderer.min.js',
  // callback: ENABLE THE BUTTON
  YsJQuery::removeAttr('disabled')->in('#btnOpenDialog')
);

$plot1 = new YsPlot('plot1Id', 'Bezier Curve');

$serie1 = new YsPlotSerie();
$serie2 = new YsPlotSerie();
$serie3 = new YsPlotSerie();
$serie4 = new YsPlotSerie();
$serie5 = new YsPlotSerie();

$seriesDefaults = new YsPlotSerie();
$seriesDefaults->setRenderer(YsPlotRenderer::getBezierCurveRenderer());

$serie1->addData(0,1);
$serie1->addData(2, 2);
$serie1->addData(4, .5);
$serie1->addData(6, 0);

$serie2->addData(0,5);
$serie2->addData(2, 6);
$serie2->addData(5, 1);
$serie2->addData(6, .5);

$serie3->addData(0,6);
$serie3->addData(3, 9);
$serie3->addData(4, 8);
$serie3->addData(6, 3);

$serie4->addData(0,7);
$serie4->addData(2, 9);
$serie4->addData(4, 8);
$serie4->addData(6, 6);

$serie5->addData(0,8);
$serie5->addData(2, 9);
$serie5->addData(4, 8);
$serie5->addData(6, 6);

$plot1->setSeries($serie1,$serie2,$serie3,$serie4,$serie5);

$plot1->setSeriesDefaults($seriesDefaults);

?>
<button id="btnOpenDialog" disabled="disabled">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
<table width="90%">
  <tr><td><?php echo $plot1->renderTemplate(); ?></td></tr>
  <tr><td>
  Plugins dependencies:<br/>
  - jqplot.BezierCurveRenderer.min.js<br/>
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
     YsPlot::enablePlotPlugins(),
     $plot1->build()
  )
?>