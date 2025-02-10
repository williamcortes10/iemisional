<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>

<button id="btnOpenDialog">Show Demo</button>

<?php echo YsUIDialog::initWidget('dialogId','style="display:none" title="Basic dialog"') ?>

  Tags: <input type="text" id="txtAutocomplete" /> 
  <div style="vertical-align:top;float:right;" >Powered by <a href="http://geonames.org">geonames.org</a></div>

  <div id="log">&nbsp</div>

<?php echo YsUIDialog::endWidget() ?>

<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnOpenDialog')
  ->execute(
    YsUIDialog::build('#dialogId')
      ->_modal(true)
      ->_width(400)
      ->_buttons(array(
          'Ok' => new YsJsFunction('alert("Hello world")'),
          'Close' =>  new YsJsFunction(YsUIDialog::close('this')))
       )
  );

echo
YsUIAutocomplete::build()
  ->in('#txtAutocomplete')
  ->_minLength(2)
  ->_select(
    new YsJsFunction(
      'log(ui.item ? ("Selected: " + ui.item.label) : "Nothing selected, input was " + this.value);',
      'event, ui'
    )
  )
  ->_source(
    new YsJsFunction(
      YsJQuery::ajax()
        ->_url("http://ws.geonames.org/searchJSON")
        ->_dataType(YsJQueryConstant::DATA_TYPE_JSONP)
        ->_data(array(
            'featureClass' => "P",
            'style' => "full",
            'maxRows' => 12,
            'name_startsWith' => YsArgument::likeVar('request.term')
        ))
        ->_success(
          new YsJsFunction(
            'response($.map(data.geonames, function(item) {
              return {
                label: item.name + (item.adminName1 ? ", " + item.adminName1 : "") + ", " + item.countryName,
                value: item.name
              }
            }))'
          ,'data')
        )
    ,'request,response')
  )
  ->execute()
?>

<script language="javascript" type="text/javascript">
  function log(message) {
			$("<div/>").text(message).prependTo("#log");
			$("#log").attr("scrollTop", 0);
		}
</script>