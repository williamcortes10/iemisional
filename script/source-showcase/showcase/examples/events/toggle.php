<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Click me" id="btnToggle" />
<?php
echo
YsJQuery::newInstance()
  ->execute(
    YsJQuery::toggle()
      ->in('#btnToggle')
      ->handler("alert('One little, two little, three little Indians')")
      ->handler("alert('Four little, five little, six little Indians')")
      ->handler("alert('Seven little, eight little, nine little Indians')")
      ->handler("alert('Ten little Indian boys.')")
  )
?>
</div>