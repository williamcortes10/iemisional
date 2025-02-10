<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" id="btnLeftPosition" value="Get Position.left" />
<input type="button" id="btnTopPosition" value="Get Position.top" />
<div id="blockToGetPosition">Position test</div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnLeftPosition')
  ->execute(
    sprintf('alert(%s)',YsJQuery::position()->in('#blockToGetPosition')
                                            ->setAccesors('.left'))
  );

echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnTopPosition')
  ->execute(
    sprintf('alert(%s)',YsJQuery::position()->in('#blockToGetPosition')
                                            ->setAccesors('.top'))
);
?>
</div>