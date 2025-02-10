<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
  <table id="tblData2" border="">
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
  ->in('#tblData2 td')
  ->execute(
    YsJQuery::css('background', '#ffffff')->in('#tblData2 tr'),
    YsJQuery::parents('#tblData2 tr')->in(YsJQueryConstant::THIS),
    YsJQuery::css('background', '#9FDA58')
  );
?>
</div>