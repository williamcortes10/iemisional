<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<input type="button" value="Toggle Class" id="btnToggleClass" />
<div align="center">
<table id="tblToggleClass">
  <tr><td>Lorem ipsum dolor sit amet</td></tr>
  <tr><td>consectetur adipisicing elit</td></tr>
  <tr><td>sed do eiusmod tempor incididunt ut</td></tr>
  <tr><td>labore et dolore magna aliqua</td></tr>
  <tr><td>Ut enim ad minim veniam</td></tr>
  <tr><td>quis nostrud exercitation ullamco laboris</td></tr>
  <tr><td>nisi ut aliquip ex ea commodo consequat.</td></tr>
</table>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnToggleClass')
  ->execute(
    YsJQuery::toggleClass('even')->in('#tblToggleClass tr:even'),
    YsJQuery::toggleClass('odd')->in('#tblToggleClass tr:odd')
  )
?>
</div>