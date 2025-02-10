<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
  <div>
    <span id="divChildren" style="color:#ffffff;background-color:blue">
      I'm the children
    </span>
  </div>
  <input type="button" id="btnRunClosest" value="Run" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunClosest')
  ->execute(
    YsJQuery::closest('div')->in('#divChildren'),
    YsJQuery::css(array('background-color' =>'red','padding' => '5px'))
  )
?>
</div>