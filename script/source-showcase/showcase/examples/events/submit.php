<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<form action="#" id="frmSubmitEvent">
  <label for="txtName">Your name: </label>
  <input type="text" value="" id="txtName" />
  <input type="submit" value="Submit" />
</form>
<p id="logForSelect" style="color:green"></p>
<?php
echo
YsJQuery::newInstance()
  ->onSubmit()
  ->in('#frmSubmitEvent')
  ->execute(
    sprintf('alert("Hello <" + %s +">The form was Subimted"); return false;',
            YsJQuery::val()->in('#txtName'))

  ) 
?>
</div>