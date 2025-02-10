<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<button id="btnShowDemo">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>

  <?php echo YsUIDatepicker::input('datepickerId')?>
  <br/><br/><br/>
  <?php echo YsUIButton::buttonTag('btnGetDate', 'Get Date') ?>
  The date: <span id="lblDate"></span>
  <br/>
  <?php echo YsUIButton::buttonTag('btnSetDate', 'Set Date') ?>  
  Date: <input type="text" id="txtDate" />

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
echo YsUIButton::build('#btnGetDate, #btnSetDate')->executeOnReady();
echo 
YsJQuery::click()
  ->in('#btnGetDate')
  ->handler(
    YsJQuery::html()
      ->in('#lblDate')
      ->value(YsUIDatepicker::getDate('#datepickerId')->toString())
  )
  ->execute();
echo
YsJQuery::click()
  ->in('#btnSetDate')
  ->handler(
      YsUIDatepicker::setDate()
        ->in('#datepickerId')
        ->value(YsJQuery::val()->in('#txtDate'))
      )
  ->execute()
?>