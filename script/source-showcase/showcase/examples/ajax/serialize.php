<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<form id="myForm" action="#">
  Name: <input type="text" id="first_name" name="first_name" value="" />
  Last Name:<input type="text" id="last_name" name="last_name" value="" />
  <input type="submit" value="Serialize"  value="" />
</form>
<?php
echo
YsJQuery::newInstance()
  ->onSubmit()
  ->in('#myForm')
  ->execute(
    sprintf('alert(%s); return false;',
            YsJQuery::serialize()->in('#myForm'))
  )
?>
</div>