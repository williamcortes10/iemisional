<?php error_reporting(E_ALL) ?>
<?php ini_set('display_errors', 1) ?>
<?php
include_once dirname(__FILE__) . '/../../../lib/YepSua/Labs/RIA/jQuery4PHP/YsJQueryAutoloader.php';
YsJQueryAutoloader::register();

YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQGRID);

$grid = new YsGrid('subGridId' . $_POST['rowid']);

$idGridField = new YsGridField('id', 'Id');
$clientGridField = new YsGridField('client', 'Client');
$dayGridField = new YsGridField('day', 'Day');
$balanceGridField = new YsGridField('balance', 'Balance');

$grid->addGridFields($idGridField, $clientGridField, $dayGridField, $balanceGridField);

$recordList = new YsGridRecordList();
$day = date('Y-m-d');
for($i = 1; $i <= 10 ; $i++){
  $record = new YsGridRecord();
  $record->setAttribute('id', $_POST['rowid']);
  $record->setAttribute('client', 'Client #' . $_POST['rowid']);
  $record->setAttribute('day', $day);
  $record->setAttribute('balance', rand(1, 1000));

  $grid->addRecord($record);
}

$grid->setWidth("500");
$grid->setDataType('local');
$grid->setMultiselect(true);
$grid->noPager();
echo $grid->draw();

?>