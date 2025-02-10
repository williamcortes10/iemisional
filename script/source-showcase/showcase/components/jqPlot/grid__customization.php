<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot1 = new YsPlot('plot1Id');

$serie1 = new YsPlotSerie();

$serie1->addData(1,2);
$serie1->addData(3,5.12);
$serie1->addData(5,13.1);
$serie1->addData(7,33.6);

$serie2 = new YsPlotSerie();

$serie2->addData(1,33.6);
$serie2->addData(3,13.1);
$serie2->addData(5,5.12);
$serie2->addData(7,2);


$plot1->addSerie($serie1);
$plot1->addSerie($serie2);

$grid = new YsPlotGrid();

$grid->setBackground('#9999CC');
$grid->setGridLineColor('##9999CC');
$grid->setBorderWidth(1);

$plot1->setGrid($grid);


?>

<button id="btnOpenDialog">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <table width="90%">
    <tr><td><?php echo $plot1->renderTemplate(); ?></td></tr>
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