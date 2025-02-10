<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

/* New Plot
 * The first argument is the Plot Id
 * The second argument is the Plot Title
 */

$plot = new YsPlot('chartdiv', 'Exponential Line');

/*
 * The first serie
 * The first argument is the value of the label in legend (optional)
 */

$serie1 = new YsPlotSerie("Serie Number 1");


// Adding data to the serie
$serie1->addData(1,2);
$serie1->addData(3,5.12);
$serie1->addData(5,13.1);
$serie1->addData(7,33.6);
$serie1->addData(9,85.9);
$serie1->addData(11,219.9);

// Adding style to the serie

$marker = new YsPlotMarker();
$marker->setStyle(YsPlotMarker::$STYLE_DIAMOND);
$serie1->setShowLine(false);
$serie1->setMarkerOptions($marker);

/*
 * The second serie
 */
$serie2 = new YsPlotSerie();

// The label in the legend
$serie2->setLabel("Serie Number 2");

// Adding style to the serie

$serie2->addData(1,219.9);
$serie2->addData(3,85.9);
$serie2->addData(5,33.6);
$serie2->addData(7,13.1);
$serie2->addData(9,5.12);
$serie2->addData(11,2);

// The legend for the graphic
$legend = new YsPlotLegend(YsLocation::$N);
$legend->setShow(true);

//adding the series and the legend
$plot->setSeries($serie1, $serie2);
$plot->setLegend($legend);

?>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php
  // Write the html template for the plot
  echo $plot->renderTemplate();
  ?>
<?php echo YsUIDialog::endWidget() ?>

<?php

echo
YsJQuery::newInstance()
  ->onClick() // On Click
  ->in('#btnOpenDialog') // In the button with id "btnOpenDialog"
  ->execute( // DO
    YsUIDialog::build('#dialogId') // Build and open the UI Dialog
      ->_modal(true)
      ->_width(670)
      ->_height('auto')
      ->_buttons(array(
        'Ok' => new YsJsFunction('alert("Hello world")'),
        'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       ),
   $plot->build() // Build the plot
  )
?>