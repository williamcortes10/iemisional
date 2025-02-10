<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" id="btnGetData2" value="Get Data" />
<input type="button" id="btnRemoveData" value="Remove" />
<div id="blockForData2"></div>
<?php
echo
YsJQuery::newInstance()
  ->execute(
    YsJQuery::data()
      ->in('#blockForData2')
      ->value(array('foo' => 'bar'))
  );

echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnGetData2')
  ->execute(
    sprintf('alert(%s)', YsJQuery::data()->in('#blockForData2')
                                         ->key('foo') )
  );
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRemoveData')
  ->execute(
    YsJQuery::removeData('foo')->in('#blockForData2'),
    'alert("data removed")'
  )
?>
</div>