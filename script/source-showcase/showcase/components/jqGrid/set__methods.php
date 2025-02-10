<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>





<?php

YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQGRID);

$grid = new YsGrid('gridId','Title');

$idGridField = new YsGridField('id', 'Id');
$clientGridField = new YsGridField('client', 'Client');
$accountGridField = new YsGridField('account', 'Account');
$balanceGridField = new YsGridField('balance', 'Balance');

$grid->addGridFields($idGridField, $clientGridField, $accountGridField, $balanceGridField);

$recordList = new YsGridRecordList();

for($i = 1; $i <= 10 ; $i++){
  $record = new YsGridRecord();
  $record->setAttribute('id', $i);
  $record->setAttribute('client', 'Client #' . $i);
  $record->setAttribute('account', time() + rand(1, 100000000));
  $record->setAttribute('balance', rand(1, 1000));
  $recordList->append($record);
}

$grid->setRecordList($recordList);

$grid->setWidth("100%");
$grid->setDataType(YsGridConstants::DATA_TYPE_LOCAL);
$grid->setRowNum($i - 1);
$grid->setRowList(array(3,5,10));
$grid->setViewRecords(true);
$grid->setSortname('client');

?>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo $grid->draw() ?>
  <a href="javascript:void(0)" id="setCaption">Set new caption</a><br/>
  <a href="javascript:void(0)" id="setRowNum">Set new Number of Rows(7)</a><br/>
  <a href="javascript:void(0)" id="setPage">Set to view second Page </a><br/>
  <a href="javascript:void(0)" id="setSort">Set Sort new Order </a><br/>

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
      ->_height('auto')
      ->_buttons(array(
        'Ok' => new YsJsFunction('alert("Hello world")'),
        'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       )
  );

echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#setCaption')
  ->execute(
    $grid->invoke('setCaption','New caption')
  );
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#setRowNum')
  ->execute(
    $grid->invoke('setGridParam',array('rowNum' => 7)),
    YsJQGrid::trigger('reloadGrid')
  );
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#setPage')
  ->execute(
    $grid->invoke('setGridParam',array('page' => 2)),
    YsJQGrid::trigger('reloadGrid')
  );
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#setSort')
  ->execute(
    $grid->invoke('setGridParam',array('sortname' => 'client','sortorder'=>'desc')),
    YsJQGrid::trigger('reloadGrid')
  )
?>
