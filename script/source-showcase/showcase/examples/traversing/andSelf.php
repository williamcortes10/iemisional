<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
  <div id="andSelfExample">
    <p style="margin:5px; padding:5px;">First Paragraph</p>
    <p style="margin:5px; padding:5px;">Second Paragraph</p>
    <input type="button" id="btnRunAndSelf" value="Run" />
  </div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunAndSelf')
  ->execute(
    YsJQuery::find('p')->in('#andSelfExample'),
    YsJQuery::andSelf(),
    YsJQuery::addClass('border-example'),
    YsJQuery::find('p')->in('#andSelfExample'),
    YsJQuery::addClass('background-example')->in('#andSelfExample'),
    YsJQuery::find('p')->in('#test1'),
    YsJQuery::addClass('otra prueba'),
    YsJQuery::find('p')->in('#test2')
  )
?>
</div>