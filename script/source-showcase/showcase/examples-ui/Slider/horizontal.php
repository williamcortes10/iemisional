<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<?php $properties = 'class="vertical"
                     style="height:120px; float:left; margin:15px"'  ?>
<button id="btnOpenDialog">Slider Demo</button>
<?php echo YsUIDialog::initWidget('dialogId',
                                  'style="display:none"
                                   title="Slider Demo"')?>
  Master:<br/>
  <?php echo YsUISlider::initWidget('master')?>
  <?php echo YsUISlider::endWidget()?>
  <br/>
  <?php echo YsUIPanel::initWidget('panelId', 'style="height:150px"')?>
    <?php echo YsUISlider::initWidget('slider1', '')?>
    <?php echo YsUISlider::endWidget()?>
    <?php echo YsUISlider::initWidget('slider2', $properties)?>
    <?php echo YsUISlider::endWidget()?>
    <?php echo YsUISlider::initWidget('slider3', $properties)?>
    <?php echo YsUISlider::endWidget()?>
    <?php echo YsUISlider::initWidget('slider4', $properties)?>
    <?php echo YsUISlider::endWidget()?>
    <?php echo YsUISlider::initWidget('slider5', $properties)?>
    <?php echo YsUISlider::endWidget()?>
  <?php echo YsUIPanel::endWidget()?>
  <span id="sliderVal">Id: Val: </span>
<?php echo YsUIDialog::endWidget() ?>

<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnOpenDialog')
  ->execute(
    YsUIDialog::build('#dialogId')
      ->_modal(true)
      ->_height(400)
      ->_buttons(array(
          'Ok' => new YsJsFunction('alert("Hello world")'),
          'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       )
    ,YsUISlider::build('#master')
      ->_range(YsUISlider::MIN_RANGE)
      ->_value(0)
      ->_max(10)
      ->_min(1)
      ->_slide(new YsJsFunction(YsJQuery::html(YsArgument::value('"Id: " + this.id + " Val: " + ui.value'))
                                ->in('#sliderVal'),'event, ui'))
   ,YsUISlider::build('#panelId .vertical')
      ->_range(YsUISlider::MIN_RANGE)
      ->_value(1)
      ->_max(10)
      ->_min(1)
      ->_orientation('vertical')
      ->_slide(new YsJsFunction(YsJQuery::html(YsArgument::value('"Id: " + this.id + " Val: " + ui.value'))
                                  ->in('#sliderVal'),'event, ui'))
  );
?>