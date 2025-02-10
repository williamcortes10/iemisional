<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" id="btnSerializeArray" value="Serialize Array" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnSerializeArray')
  ->execute(
    sprintf('alert(%s); return false;',
            YsJQuery::serializeArray()->in('#myForm'))
  )
?>
</div>