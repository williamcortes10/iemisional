<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot1 = new YsPlot('plot1Id');
$serie1 = new YsPlotSerie();

for ($i=0; $i < 2* pi(); $i+=0.1){
  $serie1->addData(cos($i));
}

$axis = new YsPlotAxis();
$axis->setLabel("Cosine");
$axis->setAutoscale(true);
$axis->setLabelRenderer(YsPlotRenderer::getCanvasAxisLabelRenderer());

$labelOptions = new YsPlotRenderer();
$labelOptions->setEnableFontSupport(true);
$labelOptions->setFontFamily('Georgia');
$labelOptions->setFontSize('12pt');

$axis->setLabelOptions($labelOptions);
$serie1->setYaxis($axis);


$axis->setLabel("Angle (radians)");
$serie1->setXaxis($axis);

$plot1->setSeries($serie1);

?>
<button id="btnOpenDialog">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
<table width="70%">
  <tr><td><?php echo $plot1->renderTemplate(); ?></td></tr>
  <tr><td>
  Plugins dependencies:<br/>
  - jqplot.canvasTextRenderer.min.js<br/>
  - jqplot.canvasAxisLabelRenderer.min.js<br/>
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