<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>





<?php
//For use the plugin
YsJQuery::usePlugin(YsJQueryConstant::PLUGIN_JQPLOT);
?>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>
  <div id="chartdiv" style="height:400px;width:300px; "></div>
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
       ),
    YsJQPlot::build('chartdiv',
                    array(array(1,2,7,4,3)),
                    array('title' => 'Exponential Line',
                          'series' => array('color' => '#5FAB78'))
                    )
  )
?>