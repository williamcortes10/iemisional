<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot1 = new YsPlot('plot1Id','Data Labels');

$serie1 = new YsPlotSerie();
$serie1->addData('Sony',7);
$serie1->addData('Samsumg',13.3);
$serie1->addData('LG',14.7);
$serie1->addData('Vizio',5.2);
$serie1->addData('Insignia', 1.2);

$plot1->setSeries($serie1);

$seriesDefaults = new YsPlotSerie();
$seriesDefaults->setRenderer(YsPlotRenderer::getPieRenderer());

$rendererOptions = new YsPlotRenderer();
$rendererOptions->setShowDataLabels(true);
$rendererOptions->setDataLabelPositionFactor(0.6);
$rendererOptions->setDataLabelNudge(0);
$rendererOptions->setDataLabels(array('Longer', 'B', 'C', 'Longer', 'None'));
$rendererOptions->setHighlightMouseDown(true);
$rendererOptions->setHighlightMouseOver(true);

$seriesDefaults->setRendererOptions($rendererOptions);

$plot1->setSeriesDefaults($seriesDefaults);

$legend  = new YsPlotLegend();
$legend->setPlacement('outside');

$plot1->setLegend($legend);

$grid = new YsPlotGrid();

$grid->setDrawBorder(false);
$grid->setDrawGridlines(false);
$grid->setBackground("#ffffff");
$grid->setShadow(false);

$plot1->setGrid($grid);

?>

<button id="btnOpenDialog">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <table width="90%">
    <tr><td><?php echo $plot1->renderTemplate(); ?></td></tr>
    <tr><td>
    Plugins dependencies:<br/>
    - jqplot.pieRenderer.min.js<br/>
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