<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>

 <ul id="sortable1" class="connectedSortable" style="list-style-type: none; margin: 0; padding: 0; float: left; margin-right: 10px;">
	<li class="ui-state-default" style="margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; width: 120px;">Item 1</li>
	<li class="ui-state-default" style="margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; width: 120px;">Item 2</li>
	<li class="ui-state-default" style="margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; width: 120px;">Item 3</li>
	<li class="ui-state-default" style="margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; width: 120px;">Item 4</li>
	<li class="ui-state-default" style="margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; width: 120px;">Item 5</li>
</ul>

<ul id="sortable2" class="connectedSortable" style="list-style-type: none; margin: 0; padding: 0; float: left; margin-right: 10px;">
	<li class="ui-state-highlight" style="margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; width: 120px;">Item 1</li>
	<li class="ui-state-highlight" style="margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; width: 120px;">Item 2</li>
	<li class="ui-state-highlight" style="margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; width: 120px;">Item 3</li>
	<li class="ui-state-highlight" style="margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; width: 120px;">Item 4</li>
	<li class="ui-state-highlight" style="margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; width: 120px;">Item 5</li>
</ul>


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
    YsUISortable::build()->in('#sortable1, #sortable2')
      ->_connectWith('.connectedSortable')

  )
?>