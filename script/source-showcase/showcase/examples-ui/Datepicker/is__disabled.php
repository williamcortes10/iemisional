<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<button id="btnShowDemo">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>

  <?php echo YsUIDatepicker::input('datepickerId')?>

  Is Disabled: <strong><span id="lblIsDisabled">No</span></strong>
  <br/>
  <?php echo YsUIButton::buttonTag('btnToggle', 'Toggle') ?>

<?php echo YsUIDialog::endWidget() ?>

<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnShowDemo')
  ->execute(
    YsUIDialog::build('#dialogId')
      ->_modal(true)
      ->_draggable(false)
      ->_buttons(array(
          'Ok' => new YsJsFunction('alert("Hello world")'),
          'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       )
  );
echo YsUIDatepicker::build('#datepickerId')->executeOnReady();
echo YsUIButton::build('#btnToggle')->executeOnReady();
echo
YsJQuery::toggle()
  ->in('#btnToggle')
  ->handler(
    new YsJQueryDynamic(
      YsUIDatepicker::disable('#datepickerId'),
      YsJQuery::html('Yes')->in('#lblIsDisabled')
    )
  )
  ->handler(
    new YsJQueryDynamic(
      YsUIDatepicker::enable('#datepickerId'),
      YsJQuery::html('No')->in('#lblIsDisabled')
    )
  )
  ->execute();
?>