<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>





<?php

YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQGRID);

$grid = new YsGrid('gridId','Title');
$invGridField = new YsGridField('id', 'Id');
$dateGridField = new YsGridField('invDate', 'Date');
$nameGridField = new YsGridField('name', 'Name');

$grid->addGridFields($invGridField, $dateGridField, $nameGridField);

$records = new YsGridRecordList();
$record = new YsGridRecord();
$record->setAttribute('id', '123456');
$record->setAttribute('invDate', '2011-01-01');
$record->setAttribute('name', 'Homer');
$records->append($record);
$grid->setRecordList($records);

$record = new YsGridRecord();
$record->setAttribute('id', '654321');
$record->setAttribute('invDate', '2011-01-01');
$record->setAttribute('name', 'Aristotle');
$grid->addRecord($record);

$grid->setSortable(true);
$grid->setWidth("100%");
$grid->setDataType(YsGridConstants::DATA_TYPE_LOCAL);
$grid->setHeight('auto');
$grid->setRowNum(30);
$grid->setRowList(array(3,5,10));
$grid->setViewRecords(true);
$grid->setSortname('name');

?>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo $grid->draw(); ?>
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
  )
?>