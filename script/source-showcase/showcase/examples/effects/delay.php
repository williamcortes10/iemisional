<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Run" id="btnRunDelay" />
<div id="divToDelay" style="width: 60px; 
                            height: 60px;
                            background-color: #3f3;"></div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunDelay')
  ->execute(
    YsJQuery::slideUp()->duration(700)->in('#divToDelay'),
    YsJQuery::delay()->duration(5000),
    YsJQuery::fadeIn()->duration(YsJQueryConstant::SLOW)
  )
?>
</div>