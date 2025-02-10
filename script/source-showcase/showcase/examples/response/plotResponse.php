<?php error_reporting(E_ALL) ?>
<?php ini_set('display_errors', 1) ?>
<?php
include_once dirname(__FILE__) . '/../../../lib/YepSua/Labs/RIA/jQuery4PHP/YsJQueryAutoloader.php';
YsJQueryAutoloader::register();

YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQPLOT);

$plot = new YsPlot('plotId' . $_POST['rowid'], 'Data Via AJAX | Row ' .  $_POST['rowid']);

$serie = new YsPlotSerie();
for($i = 0; $i <= 5; $i++){
  $serie->addData(rand(1, 10));
}

$plot->addSerie($serie);

?>

<table width="100%">
  <tr><td><?php echo $plot->draw(); ?></td></tr>
</table>