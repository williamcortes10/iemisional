<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="To Array" id="btnToArray" />
<ul id="lstToArray">
  <li style="padding:0px">Item 1</li>
  <li style="padding:0px">Item 2</li>
  <li style="padding:0px">Item 3</li>
  <li style="padding:0px">Item 4</li>
</ul>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnToArray')
  ->execute(
    sprintf('alert(%s)', 
            YsJQuery::toArray()->in('#lstToArray li')
                               ->setAccesors('[0].innerHTML'))
  )
?>
</div>