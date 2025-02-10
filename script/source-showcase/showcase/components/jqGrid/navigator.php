<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>





<?php

YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQGRID);

$grid = new YsGrid('gridId','Title');

$idGridField = new YsGridField('id', 'Id');
$clientGridField = new YsGridField('client', 'Client');
$clientGridField->setEditable(true);
$accountGridField = new YsGridField('account', 'Account');
$accountGridField->setEditable(true);
$balanceGridField = new YsGridField('balance', 'Balance');
$balanceGridField->setEditable(true);

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

$navigator = new YsGridNavigator();
$navigator->setDel(false);
$navigator->setEdit(false);

$form = new YsGridForm();
$form->setUrl('url/To/Crud/The/Data.php');
$form->setHeight(180);
$form->setReloadAfterSubmit(false);
$form->setBottomInfo("This is the info");

$navigator->setEditForm($form);
$navigator->setAddForm($form);
$grid->setNavigator($navigator);

?>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo $grid->renderTemplate() ?>
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
      ->_zIndex(100)
      ->_height('auto')
      ->_buttons(array(
        'Ok' => new YsJsFunction('alert("Hello world")'),
        'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       )
  )
?>

<?php echo $grid->execute() ?>