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

$level = isset($_REQUEST['n_level']) ? $_REQUEST['n_level'] + 1 : 1;

// LOCAL DATA 

$localData = array(
  array(1, 'Cash', '100', 400.00, 250.00, 150.00, 0, 1, 8, false),
  array(2, 'Cash 1', '1', 300.00, 200.00, 100.00, 1, 2, 5, false),
  array(3, 'Sub Cash 1', '1', 300.00, 200.00, 100.00, 2, 3, 4, true),
  array(4, 'Cash 2', '2', 100.00, 50.00, 50.00, 1,6, 7, true),
  array(5, "Bank's", '200', 1500.00, 1000.00, 500.00, 0, 9, 14, false),
  array(7, 'Bank 1', '1', 1000.00, 1000.00, 0.00, 1, 10, 11, true),
  array(8, 'Bank 2', '2', 1000.00, 1000.00, 0.00, 1, 12, 13, true),
  array(9, 'Fixed asset', '300', 0.00, 1000.00, -1000.00, 0, 15, 16, true),
);

for($i = 0; $i < sizeof($localData); $i++){
  $row = new YsGridRow();
  $row->setIsTreeResponse(true);
  $row->setId($localData[$i][0]);
  $row->newCell($localData[$i][0]);
  $row->newCell($localData[$i][1]);
  $row->newCell($localData[$i][2]);
  $row->newCell($localData[$i][3]);
  $row->newCell($localData[$i][4]);
  $row->newCell($localData[$i][5]);
  $row->setLevelField($localData[$i][6]);
  $row->setLeftField($localData[$i][7]);
  $row->setRightField($localData[$i][8]);
  $row->setIsLeaf($localData[$i][9]);
  $row->setIsExpanded(false);
  $response->addGridRow($row);
}

header('Content-Type: application/xml');
echo $response->buildResponseAsXML();
?>
