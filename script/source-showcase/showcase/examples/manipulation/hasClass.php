<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<p class="paragraphHasClass">Paragraph 1</p>
<p class="paragraphHasClass selected">Paragraph 2</p>
<div id="divHasClassResult1">
  Paragraph 1 has 'selected' class: <span></span>
</div>
<div id="divHasClassResult2">
  Paragraph 2 has 'selected' class: <span></span>
</div>
<div id="divHasClassResult3">
  Some Paragraph has 'selected' class: <span></span>
</div>
<?php
echo
YsJQuery::newInstance()
  ->execute(
    YsJQuery::html()->in('#divHasClassResult1>span')->value(
      YsJQuery::hasClass('selected')->in('.paragraphHasClass:first')
                                    ->toString()
    ),
    YsJQuery::html()->in('#divHasClassResult2>span')->value(
      YsJQuery::hasClass('selected')->in('.paragraphHasClass:last')
                                    ->toString()
    ),
    YsJQuery::html()->in('#divHasClassResult3>span')->value(
      YsJQuery::hasClass('selected')->in('.paragraphHasClass')
                                    ->toString()
    )
  )
?>
</div>