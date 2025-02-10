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
    YsJQuery::when(
      YsJQuery::get('examples/response/ajaxResponse.php')
    ),
    YsJQuery::then(
      new YsJSFunction('alert("$.get succeeded")')
    )
  );
?>

<input type="button" value="Testing" id="btnTesting" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnTesting')
  ->execute(
    YsJQuery::when(
      array('testing' => '123')
    ),
    YsJQuery::done(
      new YsJSFunction('alert(x.testing)', 'x')
    )
  );
?>

</div>