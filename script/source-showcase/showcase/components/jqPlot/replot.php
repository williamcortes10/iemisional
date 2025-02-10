<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>





<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot = new YsPlot('chartdiv', 'Exponential Line');
//$plot->setPlotHtmlProperties('style="height:400px;width:300px;"');
$serie1 = new YsPlotSerie();

$serie1->setColor("#5FAB78");
$serie1->addData(1,2);
$serie1->addData(3,5.12);
$serie1->addData(5,13.1);
$serie1->addData(7,33.6);
$serie1->addData(7,33.6);
$serie1->addData(9,85.9);
$serie1->addData(11,219.9);

$serie2 = new YsPlotSerie();
$serie2->addData(1,2);
$serie2->addData(3,5.12);
$serie2->addData(5,13.1);
$serie2->addData(7,33.6);
$serie2->addData(7,33.6);
$serie2->addData(9,85.9);
$serie2->addData(11,219.9);

$plot->setSeries($serie1, $serie2);

?>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo YsUIPanel::initWidget('panelId') ?>
    <?php echo YsUIPanel::title('Mi test', YsUIConstant::ICON_ALERT) ?>
    <?php echo YsUIPanel::initContent() ?>
      <?php echo $plot->renderTemplate(); ?>
    <?php echo YsUIPanel::endContent() ?>
  <?php echo YsUIPanel::endWidget() ?>
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
      ->_minHeight(500)
      ->_height('auto')
      ->_resizeStop(new YsJSFunction($plot->replot(array("resetAxes"))))
      ->_buttons(array(
        'Ok' => new YsJsFunction('alert("Hello world")'),
        'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       ),
     $plot->build()
  )
?>