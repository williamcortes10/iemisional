<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>




<div id="responseDiv"> </div>
<?php
echo
YsJQuery::newInstance()
  ->execute(
    YsJQuery::load('examples/response/timeResponse.php')
      ->in('#responseDiv')
      ->setTimeout(5000)
  );
?>
