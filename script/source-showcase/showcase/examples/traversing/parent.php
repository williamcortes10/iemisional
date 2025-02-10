<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
  <table id="tblData" border="">
  <tr>
    <th>Name</th><th>Last name</th><th>Web</th>
  </tr>
  <tr>
    <td>John</td><td>Resig</td><td>http://ejohn.org/</td>
  </tr>
  <tr>
    <td>Paul</td><td>Bakaus</td><td>http://paulbakaus.com/</td>
  </tr>
  <tr>
    <td>Omar</td><td>Yepez</td><td>http://yepsua.com/</td>
  </tr>
  </table>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#tblData td')
  ->execute(
    YsJQuery::css('background', '#ffffff')->in('#tblData tr'),
    YsJQuery::parent()->in(YsJQueryConstant::THIS),
    YsJQuery::css('background', '#5C9CCC')
  );
?>
</div>