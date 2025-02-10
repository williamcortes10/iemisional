<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Get Data [GET]" id="ajaxGetType" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#ajaxGetType')
  ->execute(
    YsJQuery::get(
      'examples/response/ajaxResponse.php',
      array('my_data' => 'data'),
      new YsJsFunction('alert(response)','response'),
      YsJQueryConstant::DATA_TYPE_HTML
    )
  );
?>
</div>