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
$response->addUserData('amount',3820.1372);
$response->addUserData('tax',462.00);
$response->addUserData('total',4284.00);

for($i = 1; $i <= 7; $i++){
  $row = new YsGridRow();
  $row->setId($i);
  $row->newCell($i);
  $row->newCell("Client " . $i);
  $row->newCell("01-01-2011");
  $row->newCell((rand(1,2) == 1) ? "Yes" : "No");
  $response->addGridRow($row);
}

header('Content-Type: application/xml');
echo $response->buildResponseAsXML();

?>
