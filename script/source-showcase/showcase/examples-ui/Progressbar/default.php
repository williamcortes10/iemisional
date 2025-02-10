<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo YsUIProgressbar::initWidget('progressbarId') ?>
  <?php echo YsUIProgressbar::endWidget() ?>
  <br/>
  <button id="btnChangeVal">Change value</button>
  <select id="cboValue">
    <option value="30">30</option>
    <option value="50">50</option>
    <option value="80">80</option>
  </select>
<?php echo YsUIDialog::endWidget() ?>

<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnOpenDialog')
  ->execute(
    YsUIDialog::build('#dialogId')
      ->_modal(true)
      ->_buttons(array(
          'Ok' => new YsJsFunction('alert("Hello world")'),
          'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       )
  );
echo
YsJQuery::newInstance()
  ->execute(
    YsUIProgressbar::build('#progressbarId')->_value(20)
  );
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnChangeVal')
  ->execute(
    YsUIProgressbar::widgetValue('#progressbarId')
      ->value(YsJQuery::val()->in('#cboValue')->toInteger())
  );
?>