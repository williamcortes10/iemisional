<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<?php YsJQuery::usePlugin(YsJQueryConstant::PLUGIN_JQGRID); ?>

<button id="btnOpenDialog">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <table id="list48"></table>
  <div id="plist48"></div>
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

<?php
$mydata = array(
      array('id'=>"1",'invdate'=>"2010-05-24",'name'=>"test",'note'=>"note",'tax'=>"10.00",'total'=>"2111.00"),
      array('id'=>"2",'invdate'=>"2010-05-25",'name'=>"test2",'note'=>"note2",'tax'=>"20.00",'total'=>"320.00"),
      array('id'=>"3",'invdate'=>"2007-09-01",'name'=>"test3",'note'=>"note3",'tax'=>"30.00",'total'=>"430.00"),
      array('id'=>"4",'invdate'=>"2007-10-04",'name'=>"test",'note'=>"note",'tax'=>"10.00",'total'=>"210.00"),
      array('id'=>"5",'invdate'=>"2007-10-05",'name'=>"test2",'note'=>"note2",'tax'=>"20.00",'total'=>"320.00"),
      array('id'=>"6",'invdate'=>"2007-09-06",'name'=>"test3",'note'=>"note3",'tax'=>"30.00",'total'=>"430.00"),
      array('id'=>"7",'invdate'=>"2007-10-04",'name'=>"test",'note'=>"note",'tax'=>"10.00",'total'=>"210.00"),
      array('id'=>"8",'invdate'=>"2007-10-03",'name'=>"test2",'note'=>"note2",'amount'=>"300.00",'tax'=>"21.00",'total'=>"320.00"),
      array('id'=>"9",'invdate'=>"2007-09-01",'name'=>"test3",'note'=>"note3",'amount'=>"400.00",'tax'=>"30.00",'total'=>"430.00"),
      array('id'=>"11",'invdate'=>"2007-10-01",'name'=>"test",'note'=>"note",'amount'=>"200.00",'tax'=>"10.00",'total'=>"210.00"),
      array('id'=>"12",'invdate'=>"2007-10-02",'name'=>"test2",'note'=>"note2",'amount'=>"300.00",'tax'=>"20.00",'total'=>"320.00"),
      array('id'=>"13",'invdate'=>"2007-09-01",'name'=>"test3",'note'=>"note3",'amount'=>"400.00",'tax'=>"30.00",'total'=>"430.00"),
      array('id'=>"14",'invdate'=>"2007-10-04",'name'=>"test",'note'=>"note",'amount'=>"200.00",'tax'=>"10.00",'total'=>"210.00"),
      array('id'=>"15",'invdate'=>"2007-10-05",'name'=>"test2",'note'=>"note2",'amount'=>"300.00",'tax'=>"20.00",'total'=>"320.00"),
      array('id'=>"16",'invdate'=>"2007-09-06",'name'=>"test3",'note'=>"note3",'amount'=>"400.00",'tax'=>"30.00",'total'=>"430.00"),
    );
?>

<?php
echo
YsJQGrid::build(array('caption' => 'jQGrid plugin => YsJQGrid'))->in('#list48')
  ->_data($mydata)
  ->_width('100%')
  ->_datatype("local")
  ->_height('auto')
  ->_rowNum(30)
  ->_rowList(array(3,5,10))
  ->_colNames(array('Inv No','Date', 'Client', 'Amount','Tax','Total','Notes'))
  ->_colModel(array(
        array('name'=>'id','index'=>'id', 'width'=>60, 'sorttype'=>"int"),
        array('name'=>'invdate','index'=>'invdate', 'width'=>90, 'sorttype'=>"date", 'formatter'=>"date"),
        array('name'=>'name','index'=>'name', 'width'=>100, 'editable'=>true),
        array('name'=>'amount','index'=>'amount', 'width'=>80, 'align'=>"right",'sorttype'=>"float", 'formatter'=>"number", 'editable'=>true),
        array('name'=>'tax','index'=>'tax', 'width'=>80, 'align'=>"right",'sorttype'=>"float", 'editable'=>true),
        array('name'=>'total','index'=>'total', 'width'=>80,'align'=>"right",'sorttype'=>"float"),
        array('name'=>'note','index'=>'note', 'width'=>150, 'sortable'=>false)
      ))
  ->_pager("#plist48")
  ->_viewrecords(true)
  ->_sortname('name')
  ->_grouping(true)
  ->_groupingView(array('groupField' => array('name')))
  ->execute();
?>