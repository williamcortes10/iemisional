<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Load" id="btnAjaxLoad" />
<div style="color:green" id="logForAjaxLoad"></div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnAjaxLoad')
  ->execute(
    YsJQuery::load(
      'examples/response/htmlResponse.php',
      array('my_data' => 'data'),
      new YsJsFunction('alert(response)','response')
    )
    ->in('#logForAjaxLoad')
  );
?>
</div>