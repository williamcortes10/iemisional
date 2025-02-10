<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="text" id="txtToHtml" value="" />
<div type="text" id="log4html"></div>
<?php
echo
YsJQuery::newInstance()
  ->onKeyup()
  ->in('#txtToHtml')
  ->execute(
    YsJQuery::html()
      ->in('#log4html')
      ->value(YsJQuery::val()->in('this'))
  )
?>
</div>