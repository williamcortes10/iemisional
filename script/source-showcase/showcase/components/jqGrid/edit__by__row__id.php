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

$grid->setWidth("100%");
$grid->setUrl('examples/response/gridUserDataResponse.php');
$grid->setPager('#pgridId');
$grid->setDataType(YsGridConstants::DATA_TYPE_XML);
$grid->setRowList(array(3,5,10));
$grid->setViewRecords(true);
$grid->setSortname('client');
$grid->setEditUrl('url/To/Edit/The/Data.php');


?>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo $grid->draw(); ?>
<input type="button" id="btnEdit" value="Edit Row 3" />
<input type="button" id="btnCancel" value="Cancel Row 3" />
<input type="button" id="btnSave" value="Save Row 3" />
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
  ->in('#btnEdit')
  ->execute(
    $grid->editRowById(3),
    YsJQuery::attr('disabled', true)->in('this'),
    YsJQuery::attr('disabled', false)->in('#btnSave')
  );
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnCancel')
  ->execute(
    $grid->cancelEditRowById(3),
    YsJQuery::attr('disabled', false)->in('#btnEdit'),
    YsJQuery::attr('disabled', true)->in('#btnSave')
  );
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnSave')
  ->execute(
    $grid->saveRowById(3),
    YsJQuery::attr('disabled', false)->in('#btnEdit'),
    YsJQuery::attr('disabled', true)->in('this'),
    'alert("See the POST data with a javascript debugger like firebug")'
  );
?>