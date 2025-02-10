<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<img style="background-color:black" 
     src="images/jquery4php-logo.jpg"
     id="imgHover">
<p id="logForHover" style="color:green"></p>
<?php
echo
YsJQuery::newInstance()
  ->onHover()
  ->in('#imgHover')
  ->execute(
    YsJQuery::append('Hover event ')->in('#logForHover')
  )
?>
            
</div>