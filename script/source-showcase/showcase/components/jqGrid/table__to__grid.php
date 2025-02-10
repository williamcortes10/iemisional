<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
<table id="mytable" border="1">
  <thead>
    <tr>
      <th>Header1</th>
      <th>Header2</th>
      <th>Header3</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Cell 11</td>
      <td>Cell 12</td>
      <td>Cell 13</td>
    </tr>
    <tr>
      <td>Cell 21</td>
      <td>Cell 22</td>
      <td>Cell 23</td>
    </tr>
    <tr>
      <td>Cell 31</td>
      <td>Cell 32</td>
      <td>Cell 33</td>
    </tr>
  </tbody>
</table> 
<input type="button" id="btnTblToGrid" value="Table to Grid" />
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
  );

echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnTblToGrid')
  ->execute(
    "tableToGrid('#mytable');"
  );

?>