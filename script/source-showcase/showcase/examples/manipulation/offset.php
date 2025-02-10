<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" id="btnOffsetLeft" value="Get Offset.left" />
<input type="button" id="btnOffsetTop" value="Get Offset.top" />
<div id="blockToOffset">Offset test</div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnOffsetLeft')
  ->execute(
    sprintf('alert(%s)',YsJQuery::offset()->in('#blockToOffset')
                                          ->setAccesors('.left'))
    );

echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnOffsetTop')
  ->execute(
    sprintf('alert(%s)',YsJQuery::offset()->in('#blockToOffset')
                                          ->setAccesors('.top'))
    );
?>
</div>