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

$grid->setWidth("100%");
$grid->setUrl('examples/response/gridUserDataResponse.php');
$grid->setPager('#pgridId');
$grid->setDataType(YsGridConstants::DATA_TYPE_XML);
$grid->setRowList(array(3,5,10));
$grid->setViewRecords(true);
$grid->setSortname('client');
$grid->setToolbar(array(true, YsAlignment::$TOP));
$grid->showInUserData('"Totals Amount:<b>"+userdata.amount+"</b> ' .
                      'Tax: <b>"+userdata.tax+"</b> Total: <b>"+userdata.total+ ' .
                      '"</b>&nbsp;&nbsp;&nbsp;"'
                      ,YsAlignment::$RIGHT);

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