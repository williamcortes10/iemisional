<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" id="btnWindowHeight" value="Height in the window" />
<input type="button" id="btnDocumentHeight" value="Height in the document" />
<input type="button" id="btnBlocktHeight" value="Height in the div " />
<div id="blockToHeight" class="blue_block"></div>
<?php
echo
YsJQuery::newInstance()->onClick()->in('#btnWindowHeight')->execute(
  sprintf('alert("Height: " + %s)', YsJQuery::height()->in('window'))
);
echo
YsJQuery::newInstance()->onClick()->in('#btnDocumentHeight')->execute(
  sprintf('alert("Height: " + %s)', YsJQuery::height()->in('document'))
);
echo
YsJQuery::newInstance()->onClick()->in('#btnBlocktHeight')->execute(
  sprintf('alert("Height: " + %s)', YsJQuery::height()->in('#blockToHeight'))
);
?>
</div>