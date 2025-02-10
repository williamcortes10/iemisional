<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php
//For use the component
YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);



$plot = new YsPlot('plot1Id', 'Theming');

$serie1 = new YsPlotSerie();
$serie1->setLinealData(1,6,4,8,2);

$serie2 = new YsPlotSerie();
$serie2->setLinealData(1,5,1,6,9);

$serie3 = new YsPlotSerie();
$serie3->setLinealData(4,7,3,1,8);

$plot->setSeries($serie1, $serie2, $serie3);

//--------------------------------UMA THEME-----------------------------------//

$umaTheme = new YsPlotTheme('uma');

$seriesStyles = new YsPlotSerie();

$umaTheme->setSeriesStyles($seriesStyles);

$legend = new YsPlotLegend();
$legend->setFontSize('8pt');

$umaTheme->setLegend($legend);

$title = new YsPlotTitle();
$title->setFontSize('18pt');

$umaTheme->setTitle($title);

$grid = new YsPlotGrid();
$grid->setBackgroundColor('rgb(211, 233, 195)');

$serie1->setColor('lightpink');
$serie2->setColor('lightgreen');
$serie3->setColor('lightblue');

$umaTheme->setSeries($serie1, $serie2, $serie3);

$umaTheme->setGrid($grid);

$plot->addTheme($umaTheme);

//--------------------------------OLD STYLE-----------------------------------//

$oldStyle = new YsPlotTheme('oldStyle');

$title = new YsPlotTitle();
$title->setFontFamily('Times New Roman');
$title->setTextColor('black');

$oldStyle->setTitle($title);

$axesStyles = new YsPlotAxis();
$axesStyles->setBorderWidth(0);

$ticks = new YsPlotAxisTickOption();
$ticks->setFontSize('12pt');
$ticks->setFontFamily('Times New Roman');
$ticks->setTextColor('black');

$axesStyles->setTicks($ticks);

$axesStyles->setLabel($title);

$oldStyle->setAxesStyles($axesStyles);

$grid = new YsPlotGrid();
$grid->setBackgroundColor('white');
$grid->setBorderWidth(0);
$grid->setGridLineColor('black');
$grid->setGridLineWidth(2);
$grid->setBorderColor('black');

$oldStyle->setGrid($grid);

$legend = new YsPlotLegend();
$legend->setBackground('white');
$legend->setTextColor('black');
$legend->setFontFamily('Times New Roman');
$legend->setBorder('1px solid black');

$oldStyle->setLegend($legend);

$serie1->setColor('blue');
$serie2->setColor('red');
$serie3->setColor('yellow');

$oldStyle->setSeries($serie1, $serie2, $serie3);

$plot->addTheme($oldStyle);

?>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
<table width="70%">
  <tr>
    <td><?php echo $plot->renderTemplate(); ?></td>
  </tr>
  <tr>
    <td>
    <button onclick="<?php echo $plot->activateDefaultTheme() ?>">Default</button>
    <button onclick="<?php echo $plot->activateTheme($umaTheme) ?>">Uma Theme</button>
    <button onclick="<?php echo $plot->activateTheme($oldStyle) ?>">Old Style</button>
    </td>
  </tr>
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
