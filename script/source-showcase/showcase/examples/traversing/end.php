<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<ul class="first">
   <li class="foo">list item 1</li>
   <li>list item 2</li>
   <li class="bar">list item 3</li>
</ul>
<ul class="second">
   <li class="foo">list item 1</li>
   <li>list item 2</li>
   <li class="bar">list item 3</li>
</ul>
<input type="button" id="btnRunEnd" value="Run" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunEnd')
  ->execute(
    YsJQuery::find('.foo')->in('ul.first'),
    YsJQuery::css('background-color', 'red'),
    YsJQuery::end(),
    YsJQuery::find('.bar'),
    YsJQuery::css('background-color', 'green')
  )
?>
</div>