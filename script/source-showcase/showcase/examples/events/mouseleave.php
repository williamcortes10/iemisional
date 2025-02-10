<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<img style="background-color:black" 
     src="/jquery4php/public_html/images/jquery4php-logo.jpg"
     id="imgMouseLeave">
<p id="logForMouseLeave" style="color:red"></p>
<?php
echo
YsJQuery::newInstance()
  ->onMouseleave()
  ->in('#imgMouseLeave')
  ->execute(
    YsJQuery::append('Mouse Leaves ')->in('#logForMouseLeave')
  )
?>
</div>