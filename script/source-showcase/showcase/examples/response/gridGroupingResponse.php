<?php error_reporting(E_ALL) ?>
<?php ini_set('display_errors', 1) ?>
<?php
include_once dirname(__FILE__) . '/../../../lib/YepSua/Labs/RIA/jQuery4PHP/YsJQueryAutoloader.php';
YsJQueryAutoloader::register();

YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQGRID);

$response = new YsGridResponse();
$response->setPage(1);
$response->setTotal(3);
$response->setRecords(13);

$tAmount = $tTax = $tTotal = 0;

for($i = 1; $i <= 7; $i++){
  $randClient = rand(1,3);
  $row = new YsGridRow();
  $row->setId($i);
  $row->newCell($i);
  $row->newCell('2010-05-24');
  $row->newCell('Client ' . $randClient);
  $rand = rand(1,100);
  $tAmount += $rand;
  $row->newCell($rand);
  $rand = rand(1,100);
  $tTax += $rand;
  $row->newCell($rand);
  $rand = rand(1,1000);
  $tTotal += $rand;
  $row->newCell($rand);
  $row->newCell('note'. $randClient);
  $response->addGridRow($row);
}

$response->addUserData('amount',$tAmount);
$response->addUserData('tax',$tTax);
$response->addUserData('total',$tTotal);
$response->addUserData('invdate',"Totals:");

header('Content-Type: application/xml');
echo $response->buildResponseAsXML();