<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<div class="blockAttr yellow_block"></div>
<div class="blockAttr blue_block"></div>
<div class="blockAttr red_block"></div>
<br>
<div id="blockAttrClient" class="white_block"></div>
<?php
echo YsJQuery::newInstance()
       ->onClick()
       ->in('.blockAttr')
       ->executeOnReady(
         YsJQuery::attr()
          ->attributeName('class')
          ->value(YsJQuery::attr('class')->in('this'))
          ->in('#blockAttrClient')
       )
?>
</div>