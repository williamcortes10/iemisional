<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<button id="btnOpenDialog">Slider Demo</button>
<?php echo YsUIDialog::initWidget('dialogId',
                                  'style="display:none"
                                   title="Slider Demo"')?>
  <?php echo YsUISlider::initWidget('sliderId')?>
  <?php echo YsUISlider::endWidget()?>
  Value: <span id="sliderVal">2</span>
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
   ,YsUISlider::build('#sliderId')
      ->_values(array(3,5,9))
      ->_max(10)
      ->_slide(new YsJsFunction(YsJQuery::html(YsArgument::value('ui.value'))
                                  ->in('#sliderVal'),'event, ui'))
  );
?>