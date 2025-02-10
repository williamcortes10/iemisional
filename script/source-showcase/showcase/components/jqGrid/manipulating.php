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
  <a href="javascript:void(0)" id="getData">Get data from selected row</a>
  <br>
  <a href="javascript:void(0)" id="delRow">Delete row 10</a>
  <br>
  <a href="javascript:void(0)" id="updateRow">Update amounts in row 1</a>
  <br>
  <a href="javascript:void(0)" id="addRow">Add row with id 10</a>
<?php echo YsUIDialog::endWidget() ?>

<?php
echo
YsJQuery::newInstance()->onClick()->in('#btnOpenDialog')->execute(
  YsUIDialog::build('#dialogId')
    ->_modal(true)
    ->_width(670)
    ->_height('auto')
    ->_buttons(array(
      'Ok' => new YsJsFunction('alert("Hello world")'),
      'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
     )
);


echo YsJQuery::newInstance()->onClick()->in('#getData')->execute('getData()');

echo YsJQuery::newInstance()->onClick()->in('#delRow')->execute('deleteRow()');

echo YsJQuery::newInstance()->onClick()->in('#updateRow')->execute('updateRow()');

echo YsJQuery::newInstance()->onClick()->in('#addRow')->execute('addRow()');
?>

<script type="text/javascript" language="javascript">
  
  /* In these cases we recommend using only javascript
   * We put this example to show the support to jQGrid methods
   * For more information, see the jQGrid homepage
   * */

  function getData(){
    var id = <?php echo $grid->invoke('getGridParam','selrow') ?>;

    if(id){
      var record = <?php echo $grid->invoke('getRowData',YsArgument::likeVar('id'))->in('#gridId') ?>;
      alert("id="+record.id+" client="+record.client+"...");
    }else{
      alert("Please select row");
    }
  }
  
  function deleteRow(){
    var success = <?php echo $grid->invoke('delRowData',10) ?>;
    if(success){
      alert("Succes. Write custom code to delete row from server");
    }else{
       alert("Allready deleted or not in list"); 
    }
  }
  
  function updateRow(){
    var record = {client:"New Client #1",account:"1111-1111",balance:"729"};
    var success = <?php echo $grid->invoke('setRowData',1,YsArgument::likeVar('record')) ?>;
    if(success){
      alert("Succes. Write custom code to update row in server");
    }else{
       alert("Can not update");
    }
  }
  
  function addRow(){
    var record = {id: "10",client:"Client #10",account:"1111-1111",balance:"729"};
    var success= <?php echo $grid->invoke('addRowData',10,YsArgument::likeVar('record')) ?>;
    if(success){
      alert("Succes. Write custom code to update row in server");
    }else{
       alert("Can not update");
    }
    <?php echo YsJQGrid::reloadGrid('#gridId'); ?>
  }

</script>


