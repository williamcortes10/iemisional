<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<img style="background-color:black"
     src="images/jquery4php-logo.jpg"
     width="215" height="53" id="imgMouseUp">
Click in the image
<p id="logForMouseUp" style="color:red"></p>
<?php
echo
YsJQuery::newInstance()
  ->onMouseup()
  ->in('#imgMouseUp')
  ->execute(
    YsJQuery::append('Mouse Up ')->in('#logForMouseUp')
  )
?>
</div>