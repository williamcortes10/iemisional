<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Get Data [GET]" id="ajaxGetType" />
<input type="button" value="Get Data [GET] Error 404" id="ajaxGetType2" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#ajaxGetType')
  ->execute(
    YsJQuery::get('examples/response/ajaxResponse.php'),
    YsJQuery::then()
      ->doneCallbacks(new YsJSFunction('alert("$.get succeeded")'))
      ->failCallbacks(new YsJSFunction('alert("$.get failed!")'))
  );
?>

<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#ajaxGetType2')
  ->execute(
    YsJQuery::get('examples/response/404response.php'),
    YsJQuery::then()
      ->doneCallbacks(new YsJSFunction('alert("$.get succeeded")'))
      ->failCallbacks(new YsJSFunction('alert("$.get failed!")'))
  );
?>
</div>