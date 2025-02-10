<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<?php

YsJQuery::useComponent(YsJQueryConstant::COMPONENT_JQGRID);

$grid = new YsGrid('gridId','Title');

$idGridField = new YsGridField('id', 'id');
$idGridField->setHidden(true);
$idGridField->setWidth(1);
$idGridField->setKey(true);

$nameGridField = new YsGridField('name', 'Name');
$nameGridField->setWidth(180);

$accNumGridField = new YsGridField('acc_num', 'Acc Num');
$accNumGridField->setAlign(YsAlignment::$CENTER);
$accNumGridField->setWidth(80);
$accNumGridField->setName('num');

$debitGridField = new YsGridField('debit', 'Debit');
$debitGridField->setAlign(YsAlignment::$CENTER);
$debitGridField->setWidth(80);

$creditGridField = new YsGridField('credit', 'Credit');
$creditGridField->setAlign(YsAlignment::$CENTER);
$creditGridField->setWidth(80);

$balanceGridField = new YsGridField('balance', 'Balance');
$balanceGridField->setAlign(YsAlignment::$CENTER);
$balanceGridField->setWidth(80);

$grid->addGridFields($idGridField,$nameGridField,$accNumGridField,$debitGridField,$creditGridField,$balanceGridField);

$grid->setWidth("100%");
$grid->setUrl('examples/response/treeGridResponse.php');
$grid->setMtype('POST');
$grid->setTreeDataType(YsGridConstants::DATA_TYPE_XML);
$grid->setSortname('client');
$grid->setTreeGrid(true);
$grid->setExpandColumn('name');



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
      ->_height('auto')
      ->_buttons(array(
        'Ok' => new YsJsFunction('alert("Hello world")'),
        'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       )
  )
?>
<?php echo $grid->execute() ?>