<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<div id="divDelegate">
  <p style="background-color: red;"> Click me!</p>
</div>
<?php
echo
YsJQuery::delegate()
  ->in('#divDelegate')
  ->selector('p')
  ->eventType('click')
  ->handler(
    '$(this).after("<p style=\"background-color: yellow;\">Test!</p>");'
  )
  ->execute() ?>
</div>