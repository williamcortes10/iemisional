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
  'jquery4php-assets/js/plugins/jqplot/plugins/jqplot.cursor.min.js',
  'jquery4php-assets/js/plugins/jqplot/plugins/jqplot.pointLabels.min.js'
),
  // callback: ENABLE THE BUTTON
  YsJQuery::removeAttr('disabled')->in('#btnOpenDialog')
);

$plot = new YsPlot('plot1Id', "City Population (thousands)");

$serie1 = new YsPlotSerie('1980');
$serie1->setLinealData(7071, 2968, 3005, 1595, 789);
$serie2 = new YsPlotSerie('1990');
$serie2->setLinealData(7322, 3485, 2783, 1630, 983);
$serie3 = new YsPlotSerie('2000');
$serie3->setLinealData(8008, 3694, 2896, 1974, 1322);

$xaxis = new YsPlotAxis();
$xaxis->setLabel('City');
$xaxis->setRenderer(YsPlotRenderer::getCategoryAxisRenderer());
$xaxis->setTicks(array("New York", "Los Angeles", "Chicago", "Houston", "Phoenix"));

$serie1->setXaxis($xaxis);

$yaxis = new YsPlotAxis();
$yaxis->setMax(9000);
$yaxis->setMin(500);

$tickOptions = new YsPlotAxisTickOption();
$tickOptions->setFormatString('%d');

$yaxis->setTickOptions($tickOptions);

$serie1->setYaxis($yaxis);

$seriesDefaults = new YsPlotSerie();
$seriesDefaults->setRenderer(YsPlotRenderer::getBarRenderer());

$seriesDefaults->setPointLabels(new YsPlotPointLabels(YsLocation::$S));

$plot->setSeriesDefaults($seriesDefaults);

$plot->setSeries($serie1,$serie2,$serie3);


$plot->showLegend();

?>

<button id="btnOpenDialog" disabled="disabled">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <table width="90%">
    <tr><td><?php echo $plot->renderTemplate(); ?></td></tr>
    <tr><td>
    Plugins dependencies:<br/>
    - jqplot.pointLabels.min.js<br/>
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
