<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
Info: Demo no completed.
<button id="btnShowDemo">Show Demo</button>
<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <?php echo YsUIDatepicker::input('datepickerId')?>
  <br/><br/>
  <select id="anim">
    <option value="show">Show (default)</option>
    <option value="slideDown">Slide down</option>
    <option value="fadeIn">Fade in</option>
    <option value="">None</option>
  </select>
<?php echo YsUIDialog::endWidget() ?>

<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnShowDemo')
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
  ->executeOnReady(
    YsUIDatepicker::build('#datepickerId')
  );
echo
YsJQuery::newInstance()
  ->onChange()
  ->in('#anim')
  ->execute(
    YsUIDatepicker::option(
      'showAnim', YsJQuery::val()->in(YsJQueryConstant::THIS)
    )->in('datepickerId'),
    sprintf('alert(%s)', YsJQuery::val()->in(YsJQueryConstant::THIS))
  );

?>