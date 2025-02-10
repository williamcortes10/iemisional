<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<button id="btnShowDemo">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none;" title="Basic dialog"') ?>

  From: <?php echo YsUIDatepicker::input('fromDatepicker')?>
  To: <?php echo YsUIDatepicker::input('toDatepicker')?>
<?php echo YsUIDialog::endWidget() ?>

<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnShowDemo')
  ->execute(
    YsUIDialog::build('#dialogId')
      ->_modal(true)
      ->_width(400)
      ->_buttons(array(
          'Ok' => new YsJsFunction('alert("Hello world")'),
          'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       )
  );
echo
YsJQuery::newInstance()
  ->executeOnReady(
    YsUIDatepicker::build('#fromDatepicker, #toDatepicker')
      ->_showOtherMonths(true)
      ->_selectOtherMonths(true)
      ->_onSelect( YsUIDatepicker::doSynchronization('fromDatepicker', 'toDatepicker'))
      ->synchronize()
  );

?>