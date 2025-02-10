<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
  <div class="testIs" style="cursor:pointer">Click me</div>
  <span class="testIs" style="cursor:pointer">Click me</span>
  <br>
  <input class="testIs" type="button" id="btnRunHas" value="Click me" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('.testIs')
  ->execute(
      sprintf(
      'if(%s){
        alert("Yes, I am a button")
      }else{
        alert("No, I am not a button")
      }',YsJQuery::is('input:button')->in('this'))
  )
?>

</div>