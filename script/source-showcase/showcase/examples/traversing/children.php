<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
  <div id="divParent" style="padding:5px;background-color:red">
    <span>I'm the children</span>
  </div>
  <input type="button" id="btnRunChildren" value="Run" />
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunChildren')
  ->execute(
    YsJQuery::children()->in('#divParent'),
    YsJQuery::css(array('background-color' =>'blue','color' => '#ffffff'))
  )
?>
</div>