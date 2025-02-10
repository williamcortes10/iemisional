<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>

  <ol id="sortable" style="list-style-type: none; margin: 0; padding: 0; width: 60%;">
    <li id="foo_1" class="ui-widget-header" style="margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; height: 1.5em;">
      Item 1
    </li>
    <li id="foo_2" class="ui-widget-header" style="margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; height: 1.5em;">
      Item 2
    </li>
    <li id="foo_3" class="ui-widget-header" style="margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; height: 1.5em;">
      Item 3
    </li>
    <li id="foo_4" class="ui-widget-header" style="margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; height: 1.5em;">
      Item 4
    </li>
  </ol>
  <br/>
  <?php echo YsUIButton::buttonTag('btnSerialize', 'Serialize')?>

<?php echo YsUIDialog::endWidget() ?>



<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnOpenDialog')
  ->execute(
    YsUIDialog::build('#dialogId')
      ->_width(500)
      ->_height(500)
      ->_modal(true)
      ->_resizable(false)
      ->_buttons(array(
          'Ok' => new YsJsFunction('alert("Hello world")'),
          'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       )
  );
echo
YsJQuery::newInstance()
  ->execute(
    YsUISortable::build()->in('#sortable'),
    YsUIButton::build('#btnSerialize')
  );
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnSerialize')
  ->execute(
    sprintf('alert("Serilized : " + %s )',YsUISortable::serialize('#sortable'))
  );
?>