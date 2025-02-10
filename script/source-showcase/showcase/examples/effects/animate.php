<pre>
<?php echo htmlentities(file_get_contents(__FILE__,true,null,92)) ?>
</pre>
<br/>
<div>
<input type="button" value="Run" id="btnRunAnimation" />
<div style="background-color:#BBCCAA; 
            border:1px solid green;
            width:100px;" id="divToAnimate">
  Hello!
</div>
<?php
echo
YsJQuery::newInstance()
  ->onClick()
  ->in('#btnRunAnimation')
  ->execute(
    YsJQuery::animate()
      ->in('#divToAnimate')
      ->properties(
          array(
            'width' => "70%",
            'opacity' => 0.4,
            'marginLeft' => "0.6in",
            'fontSize' => "3em",
            'borderWidth' => "10px")
      )
      ->duration(YsJQueryConstant::SLOW)
      ->callback('alert("Run Animation")')
    )
	?>
</div>