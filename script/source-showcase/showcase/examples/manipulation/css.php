<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<div style="background-color:yellow;" class="blockCss block"></div>
<div style="background-color:blue;" class="blockCss block"></div>
<div style="background-color:red;" class="blockCss block"></div>
<br>
<div id="clontainer" >That div is 
<span id="blockColor"></span>
</div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('.blockCss')
  ->execute(
      YsJQuery::html(
        YsJQuery::css()->inVar('this')
                       ->propertyName('background-color')
      )->in('#blockColor')
    )
?>
</div>