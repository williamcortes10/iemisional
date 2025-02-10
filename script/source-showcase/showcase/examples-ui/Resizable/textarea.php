<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
Comment:<textarea  id="txtResizable" rows="5" cols="20"></textarea>
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
    YsUIResizable::build()->in('#txtResizable')
  )
?>