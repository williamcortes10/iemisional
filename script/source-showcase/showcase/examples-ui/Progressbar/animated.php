<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo YsUIProgressbar::initWidget('progressbarId1') ?>
  <?php echo YsUIProgressbar::endWidget() ?>
  <br/>
  Progressbar 1: <select id="cboValue1">
    <option value="30">30</option>
    <option value="50">50</option>
    <option value="80">80</option>
  </select>
  <button id="btnGetValue">Get value</button>
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
    YsUIProgressbar::build('#progressbarId1')->_value(10)
  );
echo
YsJQuery::newInstance()
  ->onChange()
  ->in('#cboValue1')
  ->execute(
    YsUIProgressbar::widgetValueAnimated('#progressbarId1', YsJQuery::val()->in('#cboValue1')->toInteger())
  );

echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnGetValue')
  ->execute(
    sprintf('alert("The value: " + %s)', YsUIProgressbar::widgetValue()->in('#progressbarId1'))
  );
?>