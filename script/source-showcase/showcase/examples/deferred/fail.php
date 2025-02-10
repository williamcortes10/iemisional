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
    YsJQuery::get('examples/response/404response.php'),
    YsJQuery::done()->handler("alert('$.get succeeded')"),
    YsJQuery::fail()->handler("alert('$.get failed!')")
  );
?>
</div>