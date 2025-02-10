<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Get Data [GET]" id="ajaxGetJson" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#ajaxGetJson')
  ->execute(
    YsJQuery::getJSON(
      'examples/response/jsonResponse.php',
      array('my_data' => 'data'),
      new YsJsFunction('alert(response.message)','response')
    )
  )
?>
</div>