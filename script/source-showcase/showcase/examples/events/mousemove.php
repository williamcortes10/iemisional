<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<img style="background-color:black" 
     src="images/jquery4php-logo.jpg"
     id="imgMouseMove">
<p id="logForMouseMove" style="font-size:8px"></p>
<?php
echo
YsJQuery::newInstance()
  ->onMousemove()
  ->in('#imgMouseMove')
  ->execute(
    YsJQuery::append('Mousemove ')->in('#logForMouseMove')
  )
?>
</div>