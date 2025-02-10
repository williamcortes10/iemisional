<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Clon" id="btnToClone" />
<div id="clontainer" >
</div>
<?php
echo YsJQuery::newInstance()
       ->onClick()
       ->in('#btnToClone')
       ->execute(
         YsJQuery::clonation()->in('#btnToClone')
           ->withDataAndEvents(true)
           ->deepWithDataAndEvents(true),
         YsJQuery::appendTo('#clontainer')
       )
?>
</div>