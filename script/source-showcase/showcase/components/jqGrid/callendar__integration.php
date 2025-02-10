<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>





<?php

YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQGRID);

$grid = new YsGrid('gridId','Title');
$idGridField = new YsGridField('idField', 'Id');

$clientGridField = new YsGridField('clientField', 'Client');
$clientGridField->setEditable(true);
$clientGridField->setEditType(YsGridConstants::EDIT_TYPE_SELECT);
$clientGridField->setEditOptions(array('value' => '1:Client 1;2:Client 2;3:Client 3;n:Client n'));


$dateGridField = new YsGridField('dateField', 'Date');
$dateGridField->setEditable(true);

$activeGridField = new YsGridField('activeField', 'Active');
$activeGridField->setEditable(true);
$activeGridField->setEditType(YsGridConstants::EDIT_TYPE_CHECKBOX);
$activeGridField->setEditOptions(array('value' => 'Yes:No'));


$grid->addGridFields($idGridField, $clientGridField, $dateGridField, $activeGridField);

$grid->setWidth("100%");
$grid->setUrl('examples/response/gridResponse.php');
$grid->setPager('#pgridId');
$grid->setDataType(YsGridConstants::DATA_TYPE_XML);
$grid->setRowList(array(3,5,10));
$grid->setViewRecords(true);
$grid->setSortname('clientField');
$grid->setEditUrl('url/To/Edit/The/Data.php');
$grid->setEditOnSelectRow(true);
$grid->setCalendarSupportIn('dateField');
$grid->setCalendarDefaultOptions(array('zIndex' => 20000, 'dateFormat' => 'dd-mm-yy'));

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
  );
?>