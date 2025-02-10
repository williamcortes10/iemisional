<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<img style="background-color:black" 
     src="/jquery4php/public_html/images/jquery4php-logo.jpg"
     id="imgMouseEnter">
<p id="logForMouseEnter" style="color:blue"></p>
<?php
echo
YsJQuery::newInstance()
  ->onMouseenter()
  ->in('#imgMouseEnter')
  ->execute(
    YsJQuery::append('Mouse Enter ')->in('#logForMouseEnter')
  )
?>
</div>