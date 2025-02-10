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

//$response->addRow('1',array(1,2007-10-01,YsXML::cDATA("Client 1"),100.00,20.00,120.00,YsXML::cDATA("note 1")));
//$response->addRow('2',array(2,2007-10-01,YsXML::cDATA("Client 2"),100.00,20.00,120.00,YsXML::cDATA("note 2")));
//$response->addRow('3',array(3,2007-10-01,YsXML::cDATA("Client 3"),100.00,20.00,120.00,YsXML::cDATA("note 3")));
//$response->addRow('4',array(4,2007-10-01,YsXML::cDATA("Client 4"),100.00,20.00,120.00,YsXML::cDATA("note 4")));
//$response->addRow('5',array(5,2007-10-01,YsXML::cDATA("Client 5"),100.00,20.00,120.00,YsXML::cDATA("note 5")));
//$response->addRow('6',array(6,2007-10-01,YsXML::cDATA("Client 6"),100.00,20.00,120.00,YsXML::cDATA("note 6")));


for($i = 1; $i <= 7; $i++){
  $row = new YsGridRow();
  $row->setId($i);
  $row->newCell($i);
  $row->newCell(2007-10-01);
  $row->newCell("Client " . $i);
  $row->newCell(100.00);
  $row->newCell(20.00);
  $row->newCell(120.00);
  $row->newCell("note ". $i);
  $response->addGridRow($row);
}

header('Content-Type: application/xml');
echo $response->buildResponseAsXML();

?>
