<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>

  Tags: <input type="text" id="txtAutocomplete" />

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
YsUIAutocomplete::build()
  ->in('#txtAutocomplete')
  ->_source(array("c++", "java", "php", "coldfusion", "javascript", "asp",
                  "ruby", "python", "c", "scala", "groovy", "haskell", "perl"))
  ->execute()
?>