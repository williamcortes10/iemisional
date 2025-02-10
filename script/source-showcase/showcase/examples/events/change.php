<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<select id="cboList">
  <option>1.- Option</option>
  <option>2.- Option</option>
  <option>3.- Option</option>
  <option>4.- Option</option>
</select>
<?php
echo
YsJQuery::newInstance()
  ->onChange()
  ->in('#cboList')
  ->execute(
    sprintf("alert('you chose: ' + %s)",YsJQuery::val()->in('this'))
  )
?>
</div>